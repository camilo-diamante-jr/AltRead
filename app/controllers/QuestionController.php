<?php


require_once '../core/Controller.php';

class QuestionController extends Controller
{
    private $questionModel;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this->questionModel = $this->loadModel('QuestionModel');
    }


    public function createQuestionFunction()
    {
        // Simulate fetching data securely from POST request
        $questionData = [
            "lesson_id" => $_POST['lesson_id'] ?? null,
            "part_id" => $_POST['part_id'] ?? null,
            "questions_direction" => $_POST['questions_direction'] ?? null,
            "question_text" => $_POST['question_text'] ?? null,
            "content_title" => $_POST['content_title'] ?? null,
            "content_img" => $_POST['content_img'] ?? "default-img.jpg",
            "sub_content_1" => $_POST['sub_content_1'] ?? null,
            "sub_content_2" => $_POST['sub_content_2'] ?? null,
            "sub_content_3" => $_POST['sub_content_3'] ?? null,
            "sub_content_4" => $_POST['sub_content_4'] ?? null,
            "question_type" => $_POST['question_type'] ?? null,
            "multiple_choice_option" => $_POST['multiple_choice_option'] ?? [],
            "correct_choice" => $_POST['correct_choice'] ?? []
        ];


        if (empty($questionData['lesson_id']) || empty($questionData['part_id'])) {
            echo json_encode([
                "status" => "failed",
                "message" => "Missing required fields."
            ]);
            exit;
        }


        if ($questionData["content_img"] !== NULL)

            // Check if content_img is being uploaded and not null
            if (isset($_FILES['content_img']) && $_FILES['content_img']['error'] == 0) {
                // Validate the image file (check file type and size)
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                $fileInfo = pathinfo($_FILES['content_img']['name']);
                $fileExtension = strtolower($fileInfo['extension']);

                // Check file extension
                if (!in_array($fileExtension, $allowedExtensions)) {
                    echo json_encode([
                        "status" => "failed",
                        "message" => "Invalid file type. Allowed types: jpg, jpeg, png, gif."
                    ]);
                    exit;
                }

                // Check file size (max 5MB for example)
                $maxFileSize = 5 * 1024 * 1024; // 5MB
                if ($_FILES['content_img']['size'] > $maxFileSize) {
                    echo json_encode([
                        "status" => "failed",
                        "message" => "File size exceeds the limit of 5MB."
                    ]);
                    exit;
                }

                // Move the uploaded file to the desired directory
                $uploadDir = '../files/uploads/content/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true); // Create the directory if it doesn't exist
                }

                $newFileName = uniqid('content_', true) . '.' . $fileExtension;
                $uploadPath = $uploadDir . $newFileName;

                // Move the file to the uploads directory
                if (!move_uploaded_file($_FILES['content_img']['tmp_name'], $uploadPath)) {
                    echo json_encode([
                        "status" => "failed",
                        "message" => "Failed to upload the image."
                    ]);
                    exit;
                }

                // Set the content_img path to the relative file path
                $questionData['content_img'] = 'files/uploads/content/' . $newFileName;
            }

        // Convert correct choices to an array of integers
        if (!is_array($questionData['correct_choice'])) {
            $questionData['correct_choice'] = [$questionData['correct_choice']];
        }
        $questionData['correct_choice'] = array_map('intval', $questionData['correct_choice']);

        header('Content-Type: application/json');

        $result = $this->questionModel->acceptNewQuestion($questionData);

        // Return a JSON response
        if ($result) {
            echo json_encode([
                "status" => "success",
                "message" => "Question created successfully.",
                "question" => $questionData // Optionally return the data
            ]);
        } else {
            echo json_encode([
                "status" => "failed",
                "message" => "Failed to create question.",
                "question" => $questionData // Optionally return the data
            ]);
        }
        exit; // Ensure no further output is sent
    }


    public function showAllQuestions(): array
    {
        return $this->questionModel->fetchAllQuestions();
    }

    public function getQuestionsByLessonId(): void
    {
        header('Content-Type: application/json');

        $lessonId = filter_input(INPUT_POST, 'lesson_id', FILTER_VALIDATE_INT);

        if (!$lessonId) {
            error_log("Invalid lesson_id received: " . ($_POST['lesson_id'] ?? 'NULL'));
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'message' => 'Valid Lesson ID is required.'
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            return;
        }

        try {
            error_log("Fetching questions for lesson_id: $lessonId");

            $questions = $this->questionModel->fetchQuestionByLessonId($lessonId);

            if (empty($questions)) {
                error_log("No questions found for lesson_id: $lessonId");
                http_response_code(404);
                echo json_encode([
                    'status' => 'warning',
                    'message' => "No questions found for this lesson!",
                    'data' => []
                ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                return;
            }

            error_log("Fetched questions: " . json_encode($questions));

            http_response_code(200);
            echo json_encode([
                'status' => 'success',
                'message' => 'Questions fetched successfully.',
                'data' => $questions
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        } catch (Exception $e) {
            error_log('Error fetching questions: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => 'Internal Server Error. Please try again later.'
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
    }

    public function getQuestionById(): void
    {
        header('Content-Type: application/json');

        $questionId = filter_input(INPUT_POST, 'question_id', FILTER_VALIDATE_INT);

        if (!$questionId) {
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'message' => 'Valid Question ID is required.'
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            return;
        }

        try {
            $question = $this->questionModel->fetchQuestionsById($questionId);

            if (empty($question)) {
                http_response_code(404);
                echo json_encode([
                    'status' => 'warning',
                    'message' => 'Question not found!',
                    'data' => []
                ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                return;
            }

            http_response_code(200);
            echo json_encode([
                'status' => 'success',
                'message' => 'Question fetched successfully.',
                'data' => $question
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => 'Internal Server Error. Please try again later.'
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
    }
}
