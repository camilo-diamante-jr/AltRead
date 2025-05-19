<?php

class QuizModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Okay nani ahhhhhhhh  bala kamu jannnn!!!!!!
    public function acceptNewInsertedQuiz($quizData)
    {
        try {
            // Prepare the SQL insert query with is_active
            $sql = "INSERT INTO quizzes (quiz_title, quiz_question, quiz_type, 
                                      sub_content_1, sub_content_2, sub_content_3, sub_content_4, sub_content_5, sub_content_6,
                                      choices_1, choices_2, choices_3, choices_4, choices_5, choices_6, created_at, updated_at, is_active)
                VALUES (:quiz_title, :quiz_question, :quiz_type, 
                        :sub_content_1, :sub_content_2, :sub_content_3, :sub_content_4, :sub_content_5, :sub_content_6, 
                        :choices_1, :choices_2, :choices_3, :choices_4, :choices_5, :choices_6, :created_at, :updated_at, :is_active)";

            // Prepare the statement
            $stmt = $this->pdo->prepare($sql);

            // Extract data from quizData
            $quiz_title = $quizData['quiz_title'];
            $quiz_question = $quizData['quiz_question'];
            $quiz_type = $quizData['quiz_type'];

            $sub_content_1 = isset($quizData['sub_contents']['sub_content_1']) ? $quizData['sub_contents']['sub_content_1'] : NULL;
            $sub_content_2 = isset($quizData['sub_contents']['sub_content_2']) ? $quizData['sub_contents']['sub_content_2'] : NULL;
            $sub_content_3 = isset($quizData['sub_contents']['sub_content_3']) ? $quizData['sub_contents']['sub_content_3'] : NULL;
            $sub_content_4 = isset($quizData['sub_contents']['sub_content_4']) ? $quizData['sub_contents']['sub_content_4'] : NULL;
            $sub_content_5 = isset($quizData['sub_contents']['sub_content_5']) ? $quizData['sub_contents']['sub_content_5'] : NULL;
            $sub_content_6 = isset($quizData['sub_contents']['sub_content_6']) ? $quizData['sub_contents']['sub_content_6'] : NULL;

            $choices_1 = isset($quizData['choices']['choices_1']) ? $quizData['choices']['choices_1'] : NULL;
            $choices_2 = isset($quizData['choices']['choices_2']) ? $quizData['choices']['choices_2'] : NULL;
            $choices_3 = isset($quizData['choices']['choices_3']) ? $quizData['choices']['choices_3'] : NULL;
            $choices_4 = isset($quizData['choices']['choices_4']) ? $quizData['choices']['choices_4'] : NULL;
            $choices_5 = isset($quizData['choices']['choices_5']) ? $quizData['choices']['choices_5'] : NULL;
            $choices_6 = isset($quizData['choices']['choices_6']) ? $quizData['choices']['choices_6'] : NULL;

            $created_at = date("Y-m-d H:i:s");
            $updated_at = date("Y-m-d H:i:s");
            $is_active = 1;

            $stmt->bindParam(':quiz_title', $quiz_title);
            $stmt->bindParam(':quiz_question', $quiz_question);
            $stmt->bindParam(':quiz_type', $quiz_type);
            $stmt->bindParam(':sub_content_1', $sub_content_1);
            $stmt->bindParam(':sub_content_2', $sub_content_2);
            $stmt->bindParam(':sub_content_3', $sub_content_3);
            $stmt->bindParam(':sub_content_4', $sub_content_4);
            $stmt->bindParam(':sub_content_5', $sub_content_5);
            $stmt->bindParam(':sub_content_6', $sub_content_6);
            $stmt->bindParam(':choices_1', $choices_1);
            $stmt->bindParam(':choices_2', $choices_2);
            $stmt->bindParam(':choices_3', $choices_3);
            $stmt->bindParam(':choices_4', $choices_4);
            $stmt->bindParam(':choices_5', $choices_5);
            $stmt->bindParam(':choices_6', $choices_6);
            $stmt->bindParam(':created_at', $created_at);
            $stmt->bindParam(':updated_at', $updated_at);
            $stmt->bindParam(':is_active', $is_active);

            if ($stmt->execute()) {
                $lastInsertId = $this->pdo->lastInsertId();

                // Return the quiz details, including the new ID
                return [
                    'quiz_title' => $quiz_title,
                    'quiz_question' => $quiz_question,
                    'created_at' => $created_at,
                    'quiz_id' => $lastInsertId
                ];
            } else {
                return false;
            }
        } catch (Exception $e) {
            error_log('Error inserting quiz: ' . $e->getMessage());
            return false;
        }
    }

    public function fetchAllQuizzes()
    {
        $stmt = $this->pdo->query('SELECT * FROM quizzes WHERE is_active = 1');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchQuizById($quizID)
    {

        $stmt = $this->pdo->prepare("SELECT * FROM quizzes WHERE quiz_id = :quiz_id");
        $stmt->bindParam(':quiz_id', $quizID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    // Pangitaa nyo ang errors ah perfectonist pa naman kamu raan nga mga panelist  kamu debug di ah para sadya!!!!

    public function updateQuiz($quizID, $quizTitle, $quizType, $quizQuestion, $subContents, $choices)
    {
        try {
            $sql = "UPDATE quizzes SET quiz_title = :quiz_title, quiz_type = :quiz_type, quiz_question = :quiz_question, 
                sub_content_1 = :sub_content_1, sub_content_2 = :sub_content_2, sub_content_3 = :sub_content_3, 
                sub_content_4 = :sub_content_4, sub_content_5 = :sub_content_5, sub_content_6 = :sub_content_6, 
                choices_1 = :choices_1, choices_2 = :choices_2, choices_3 = :choices_3, choices_4 = :choices_4, 
                choices_5 = :choices_5, choices_6 = :choices_6 WHERE quiz_id = :quiz_id";

            $stmt = $this->pdo->prepare($sql);

            $stmt->bindParam(':quiz_title', $quizTitle);
            $stmt->bindParam(':quiz_type', $quizType);
            $stmt->bindParam(':quiz_question', $quizQuestion);

            for ($i = 1; $i <= 6; $i++) {
                $stmt->bindParam(":sub_content_$i", $subContents[$i - 1]);
            }

            for ($i = 1; $i <= 6; $i++) {
                $stmt->bindParam(":choices_$i", $choices[$i - 1]);
            }

            $stmt->bindParam(':quiz_id', $quizID);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
