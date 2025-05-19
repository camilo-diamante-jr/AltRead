<?php

require_once '../core/Controller.php';

class PretestController extends Controller
{
    private $pretestModel;
    private $pisModel;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this->pretestModel = $this->loadModel('PretestModel');
        $this->pisModel = $this->loadModel('PISModel');
    }

    public function showAllPretest()
    {
        try {
            return $this->pretestModel->getAllPretest();
        } catch (Exception $e) {
            error_log('Error fetching pretests: ' . $e->getMessage());
            return [];
        }
    }
    public function getAllPretestScores()
    {
        try {
            $learnerID = $this->pisModel->fetchLearnersIdByUserId();
            return $this->pretestModel->pretestScores($learnerID);
        } catch (Exception $e) {
            error_log('Error fetching pretest scores: ' . $e->getMessage());
            return 0;
        }
    }


    public function pretestSubmission()
    {
        try {
            $learnerID = $this->pisModel->fetchLearnersIdByUserId();
            return $this->pretestModel->fetchAllSubmittedPretest($learnerID);
        } catch (Exception $e) {
            error_log('Error fetching submitted pretests: ' . $e->getMessage());
            return [];
        }
    }

    public function viewAllPretestSubmission()
    {
        try {
            return $this->pretestModel->getAllSubmittedPretest();
        } catch (Exception $e) {
            error_log('Error fetching submitted pretests: ' . $e->getMessage());
            return [];
        }
    }

    public function insertPretestFunction()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== "POST") {
            echo json_encode(['success' => false, 'message' => "Invalid request method."]);
            return;
        }

        $pretestType = $_POST['pretest_type'] ?? null;
        $question = $_POST['question'] ?? null;
        $context = $_POST['context'] ?? null;

        $subContexts = [
            'first' => $_POST['sub_context_1'] ?? '',
            'second' => $_POST['sub_context_2'] ?? '',
            'third' => $_POST['sub_context_3'] ?? '',
            'fourth' => $_POST['sub_context_4'] ?? '',
        ];

        $choices = $this->handleChoicesUpload();
        if ($choices === false) return;

        $correctAnswer = $_POST['correct_answer'] ?? null;

        $result = $this->pretestModel->acceptNewPretest($pretestType, $question, $context, $subContexts, $choices, $correctAnswer);

        echo json_encode($result);
    }

    private function handleChoicesUpload()
    {
        $choices = ['A' => '', 'B' => '', 'C' => '', 'D' => ''];
        $uploadDir = "files/uploads/pretest_choices/";
        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0777, true) && !is_dir($uploadDir)) {
            echo json_encode(['success' => false, 'message' => "Failed to create upload directory"]);
            return false;
        }

        foreach (['a', 'b', 'c', 'd'] as $label) {
            $inputName = "choice_$label";
            if (!empty($_POST[$inputName])) {
                $choices[strtoupper($label)] = $_POST[$inputName];
            } elseif (!empty($_FILES[$inputName]) && $_FILES[$inputName]['error'] === 0) {
                $imageName = basename($_FILES[$inputName]['name']);
                $imagePath = $uploadDir . $imageName;
                if (move_uploaded_file($_FILES[$inputName]['tmp_name'], $imagePath)) {
                    $choices[strtoupper($label)] = $imageName;
                } else {
                }
                echo json_encode(['success' => false, 'message' => "Failed to upload image for choice $label"]);
                return false;
            }
        }
        return $choices;
    }

    public function updatePretestFunction()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== "POST") {
            echo json_encode(["status" => "error", "message" => "Invalid request"]);
            return;
        }

        if (empty($_POST['pretest_id'])) {
            echo json_encode(["status" => "error", "message" => "Pretest ID is required"]);
            return;
        }

        $data = [
            "pretest_id" => $_POST['pretest_id'],
            "question" => $_POST['edit_question'] ?? '',
            "pretest_type" => $_POST['edit_pretest_type'] ?? '',
            "context" => $_POST['edit_context'] ?? '',
            "correct_answer" => $_POST['correct_answer'] ?? '',
            "first_sub" => $_POST['edit_first_sub_context'] ?? '',
            "second_sub" => $_POST['edit_second_sub_context'] ?? '',
            "third_sub" => $_POST['edit_third_sub_context'] ?? '',
            "fourth_sub" => $_POST['edit_fourth_sub_context'] ?? '',
            "choice_a" => $_POST['edit_choice_a'] ?? '',
            "choice_b" => $_POST['edit_choice_b'] ?? '',
            "choice_c" => $_POST['edit_choice_c'] ?? '',
            "choice_d" => $_POST['edit_choice_d'] ?? ''
        ];

        $response = $this->pretestModel->acceptUpdatePretest($data);
        echo json_encode($response);
    }



    public function submitPretestAnswersFunction(): void
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $learnerID = $_POST['learner_id'] ?? null;
            $answers = $_POST['pretest_answer'] ?? [];

            // $correct_answer = $_POST['correct_answer'] ?? [];


            if ($learnerID && !empty($answers)) {
                try {
                    // Prepare the answers for each pretest question
                    $pretestAnswers = [];
                    foreach ($answers as $pretestID => $answer) {
                        // Make sure to map each answer to its corresponding pretestID
                        $pretestAnswers[] = [
                            'learnerID' => $learnerID,
                            'pretestID' => $pretestID,
                            'pretest_answer' => $answer, // Assumes 'answer' contains the actual answer
                        ];
                    }

                    // Submit the answers to the database
                    $this->pretestModel->acceptPretestSubmission($pretestAnswers);
                    echo json_encode(['status' => 'success', 'message' => 'Pretest submitted successfully']);
                } catch (Exception $e) {
                    error_log("Error submitting pretest: " . $e->getMessage());
                    echo json_encode(['status' => 'error', 'message' => 'Failed to submit pretest: ' . $e->getMessage()]);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid input data']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
        }
    }
}
