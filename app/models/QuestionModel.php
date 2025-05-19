<?php

declare(strict_types=1);

class QuestionModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Insert a new question and its choices (if applicable).
     * @param array $data
     * @return int|bool Returns question_id on success, false on failure.
     */
    public function acceptNewQuestion(array $data)
    {
        try {
            if (!isset($data['lesson_id']) || !isset($data['part_id']) || !isset($data['question_type'])) {
                throw new InvalidArgumentException('Missing required fields.');
            }

            $sql = 'INSERT INTO questions (lesson_id, part_id, questions_direction, question_text, 
        content_title, content_img, question_type, is_active, created_at) 
        VALUES (:lesson_id, :part_id, :questions_direction, :question_text, :content_title, :content_img, 
        :question_type, 1, NOW())';

            $stmt = $this->pdo->prepare($sql);

            // Bind parameters securely
            $stmt->bindValue(':lesson_id', $data['lesson_id'], PDO::PARAM_INT);
            $stmt->bindValue(':part_id', $data['part_id'], PDO::PARAM_INT);
            $stmt->bindValue(':questions_direction', $data['questions_direction'] ?? null, PDO::PARAM_STR);
            $stmt->bindValue(':question_text', $data['question_text'] ?? null, PDO::PARAM_STR);
            $stmt->bindValue(':content_title', $data['content_title'] ?? null, PDO::PARAM_STR);
            $stmt->bindValue(':content_img', $data['content_img'] ?? null, PDO::PARAM_STR);
            $stmt->bindValue(':question_type', $data['question_type'], PDO::PARAM_STR);

            if (!$stmt->execute()) {
                throw new PDOException("Failed to execute question insertion.");
            }

            $questionId = $this->pdo->lastInsertId();
            if (!$questionId) {
                throw new PDOException("Failed to retrieve last inserted ID.");
            }

            // Insert multiple-choice options if applicable
            if ($data['question_type'] === "multiple_choice") {
                $this->insertChoices((int) $questionId, $data);
            }

            return $questionId;
        } catch (PDOException $e) {
            error_log("Error inserting question: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => "Database error occurred."]);
            exit;
        } catch (InvalidArgumentException $e) {
            error_log("Validation error: " . $e->getMessage());
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
            exit;
        }
    }



    /**
     * Insert choices for multiple choice questions.
     * @param int $questionId
     * @param array $data
     */
    private function insertChoices(int $questionId, array $data)
    {
        try {
            // Ensure choices and correct answers are arrays
            $choices = $data['multiple_choice_option'] ?? [];
            $correctChoices = isset($data['correct_choice'])
                ? (is_array($data['correct_choice']) ? $data['correct_choice'] : [$data['correct_choice']])
                : [];

            // Convert correctChoices to integers (to match indexes)
            $correctChoices = array_map('intval', $correctChoices);

            foreach ($choices as $index => $choiceText) {
                // Determine if the current index is correct (use zero-based index)
                $isCorrect = in_array($index, $correctChoices) ? 1 : 0;

                $sql = 'INSERT INTO choices (question_id, choice_text, is_correct) 
                    VALUES (:question_id, :choice_text, :is_correct)';

                $stmt = $this->pdo->prepare($sql);
                $stmt->bindValue(':question_id', $questionId, PDO::PARAM_INT);
                $stmt->bindValue(':choice_text', $choiceText, PDO::PARAM_STR);
                $stmt->bindValue(':is_correct', $isCorrect, PDO::PARAM_INT);

                $stmt->execute();
            }
        } catch (PDOException $e) {
            error_log("Error inserting choices: " . $e->getMessage());
        }
    }


    /**
     * Fetch all active questions with lesson and part details.
     * @return array
     */
    public function fetchAllQuestions(): array
    {
        $sql = 'SELECT q.question_id, q.question_text, q.question_type,
        l.lesson_id, l.lesson_name, l.lesson_description, 
        p.part_name, 
        m.module_id, m.module_name
        FROM questions q
        INNER JOIN lessons l ON q.lesson_id = l.lesson_id
        INNER JOIN parts p ON q.part_id = p.part_id
        INNER JOIN modules m ON l.module_id = m.module_id  -- Join modules via lessons
        WHERE q.is_active = 1
        ORDER BY m.module_id, l.lesson_id, p.part_id, q.question_id';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Fetch questions for a specific lesson, ordered by question ID.
     * @param int $lessonId
     * @return array
     */
    public function fetchQuestionByLessonId(int $lessonId): array
    {
        try {
            // Prepare the SQL query to fetch questions along with related lesson, module, part, and choices information
            $sql = 'SELECT 
                    q.question_id, 
                    q.lesson_id, 
                    q.part_id, 
                    q.questions_direction, 
                    q.question_text, 
                    q.content_title, 
                    q.content_img,
                    q.sub_content_1, 
                    q.sub_content_2, 
                    q.sub_content_3, 
                    q.sub_content_4, 
                    q.question_type, 
                    q.is_active, 
                    q.created_at, 
                    q.updated_at,
                    l.lesson_name, 
                    m.module_id, 
                    m.module_name,
                    p.part_name,
                    c.choice_id,
                    c.choice_text,
                    c.is_correct,
                    c.is_active AS choice_is_active,
                    c.created_at AS choice_created_at
                FROM questions q
                INNER JOIN lessons l ON q.lesson_id = l.lesson_id
                INNER JOIN modules m ON l.module_id = m.module_id
                LEFT JOIN parts p ON q.part_id = p.part_id
                LEFT JOIN choices c ON q.question_id = c.question_id
                WHERE q.lesson_id = :lesson_id
                ORDER BY m.module_id, l.lesson_id, p.part_id, q.question_id ASC';

            // Prepare and execute the statement
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':lesson_id', $lessonId, PDO::PARAM_INT);
            $stmt->execute();

            // Fetch all results as an associative array
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Organize the results to group choices under their respective questions
            $questions = [];
            foreach ($results as $row) {
                $questionId = $row['question_id'];
                if (!isset($questions[$questionId])) {
                    // Initialize the question entry
                    $questions[$questionId] = [
                        'question_id' => $row['question_id'],
                        'lesson_id' => $row['lesson_id'],
                        'part_id' => $row['part_id'],
                        'questions_direction' => $row['questions_direction'],
                        'question_text' => $row['question_text'],
                        'content_title' => $row['content_title'],
                        'content_img' => $row['content_img'],
                        'sub_content_1' => $row['sub_content_1'],
                        'sub_content_2' => $row['sub_content_2'],
                        'sub_content_3' => $row['sub_content_3'],
                        'sub_content_4' => $row['sub_content_4'],
                        'question_type' => $row['question_type'],
                        'is_active' => $row['is_active'],
                        'created_at' => $row['created_at'],
                        'updated_at' => $row['updated_at'],
                        'lesson_name' => $row['lesson_name'],
                        'module_id' => $row['module_id'],
                        'module_name' => $row['module_name'],
                        'part_name' => $row['part_name'],
                        'choices' => [] // Initialize choices array
                    ];
                }

                // Add the choice to the question's choices array
                if ($row['choice_id'] !== null) {
                    $questions[$questionId]['choices'][] = [
                        'choice_id' => $row['choice_id'],
                        'choice_text' => $row['choice_text'],
                        'is_correct' => $row['is_correct'],
                        'is_active' => $row['choice_is_active'],
                        'created_at' => $row['choice_created_at']
                    ];
                }
            }

            return array_values($questions); // Return the questions as a numerically indexed array
        } catch (PDOException $e) {
            // Log the error message for debugging
            error_log("Database query failed: " . $e->getMessage());
            return [];
        }
    }

    public function fetchQuestionsById(int $questionId): array
    {
        $sql = 'SELECT 
                q.question_id, 
                q.question_text, 
                q.content_title,
                q.content_img,
                q.sub_content_1,
                q.sub_content_2,
                q.sub_content_3,
                q.sub_content_4,
                q.question_type,
                l.lesson_name, 
                m.module_name,
                p.part_name
            FROM questions q
            INNER JOIN lessons l ON q.lesson_id = l.lesson_id
            INNER JOIN modules m ON l.module_id = m.module_id
            LEFT JOIN parts p ON q.part_id = p.part_id
            WHERE q.question_id = :question_id';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':question_id', $questionId, PDO::PARAM_INT);
        $stmt->execute();

        $question = $stmt->fetch(PDO::FETCH_ASSOC);

        return $question ?: [];
    }
}
