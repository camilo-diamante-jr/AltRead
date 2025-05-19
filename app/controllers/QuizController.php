<?php

require_once '../core/Controller.php';

class QuizController extends Controller
{
    private $quizModel;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this->quizModel = $this->loadModel('QuizModel');
    }

    // Okay nani!!!! 100%
    public function createQuizzesFunction()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            // Get the form data
            $quiz_title = isset($_POST['quiz_title']) ? trim($_POST['quiz_title']) : '';
            $quiz_type = isset($_POST['quiz_type']) ? trim($_POST['quiz_type']) : '';
            $quiz_question = isset($_POST['quiz_question']) ? trim($_POST['quiz_question']) : '';

            // Initialize sub-contents and choices arrays
            $sub_contents = [];
            $choices = [];

            // Fetch sub-content data (sub_content_1 to sub_content_6)
            for ($i = 1; $i <= 6; $i++) {
                $sub_contents["sub_content_$i"] = isset($_POST["sub_content_$i"]) ? trim($_POST["sub_content_$i"]) : NULL;
            }

            // Fetch choices data (choices_1 to choices_6)
            for ($i = 1; $i <= 6; $i++) {
                $choices["choices_$i"] = isset($_POST["choices_$i"]) ? trim($_POST["choices_$i"]) : NULL;
            }

            // Validate required fields
            if (empty($quiz_title) || empty($quiz_question) || empty($quiz_type)) {
                $response = [
                    'success' => false,
                    'message' => 'Quiz title, type, and question are required.'
                ];
                echo json_encode($response);
                exit;
            }

            // Prepare quiz data array for the model
            $quizData = [
                'quiz_title' => $quiz_title,
                'quiz_question' => $quiz_question,
                'quiz_type' => $quiz_type,
                'sub_contents' => $sub_contents,
                'choices' => $choices
            ];

            // Call the model's method to insert the quiz and get the last inserted ID
            $result = $this->quizModel->acceptNewInsertedQuiz($quizData);

            // Prepare the response based on the result
            if ($result && isset($result['quiz_id'])) {
                $response = [
                    'success' => true,
                    'message' => 'Quiz added successfully.',
                    'quiz_id' => $result['quiz_id'],
                    'quizData' => $quizData,
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Failed to add the quiz.'
                ];
            }

            // Log the response to the server's error log for debugging
            error_log(json_encode($response)); // Log response before sending

            // Send the response back to the client
            echo json_encode($response);
            exit; // Ensure nothing else is sent
        }
    }



    // Fetch all active quizzes
    public function renderAllQuizzes()
    {
        try {
            return $this->quizModel->fetchAllQuizzes();
        } catch (Exception $e) {
            error_log('Error fetching quizzes: ' . $e->getMessage());
            return [];
        }
    }

    public function renderQuizzesById()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Get the quiz ID from the POST data
            $quizID = $_POST['quiz_id']; // Assuming the field name is "quiz_id"

            // Fetch quiz data from the model
            $quizData = $this->quizModel->fetchQuizById($quizID);

            if ($quizData) {
                // Successfully fetched quiz data
                $response = [
                    'success' => true,
                    'quizData' => $quizData,  // Return the actual quiz data
                ];
            } else {
                // Handle case where quiz is not found
                $response = [
                    'success' => false,
                    'message' => 'Quiz not found.',
                ];
            }

            // Send the response as JSON
            echo json_encode($response);
        }
    }

    public function updateQuizzesFunction()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            try {
                // Extract data from POST
                $quizID = $_POST['quiz_id'];
                $quizTitle = $_POST['quiz_title'];
                $quizType = $_POST['quiz_type'];
                $quizQuestion = $_POST['quiz_question'];
                $subContents = $_POST['sub_contents']; // Array of sub-contents
                $choices = $_POST['choices']; // Array of choices

                // Basic validation
                if (empty($quizTitle) || empty($quizType) || empty($quizQuestion)) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Quiz title, type, and question are required.',
                    ]);
                    return;
                }

                // Set null for empty sub-contents or choices
                foreach ($subContents as &$content) {
                    $content = empty($content) ? null : $content;
                }
                foreach ($choices as &$choice) {
                    $choice = empty($choice) ? null : $choice;
                }

                // Call model to update the quiz
                $result = $this->quizModel->updateQuiz(
                    $quizID,
                    $quizTitle,
                    $quizType,
                    $quizQuestion,
                    $subContents,
                    $choices
                );

                // Check the result and send a response back
                if ($result) {
                    echo json_encode([
                        'success' => true,
                        'message' => 'Quiz updated successfully.',
                    ]);
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Failed to update quiz.',
                    ]);
                }
            } catch (Exception $e) {
                // Handle any errors during the process
                echo json_encode([
                    'success' => false,
                    'message' => 'An error occurred while updating the quiz: ' . $e->getMessage(),
                ]);
            }
        }
    }
}
