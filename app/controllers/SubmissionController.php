<?php

class SubmissionController extends Controller
{
    private $submissionsModel;

    public function __construct($pdo)
    {
        parent::__construct($pdo);
        $this->submissionsModel = $this->loadModel('SubmissionsModel');
    }


    public function renderAllSubmissions(): array
    {
        try {
            return $this->submissionsModel->getAllSubmissions();
        } catch (Exception $e) {
            error_log('Error fetching submissions: ' . $e->getMessage());
            return [];
        }
    }


    public function showSubmissionsByLearnerId()
    {
        $learnerId = filter_input(INPUT_POST, 'learner_id', FILTER_SANITIZE_NUMBER_INT);

        header('Content-Type: application/json');

        // Basic validation
        if (!$learnerId) {
            echo json_encode([
                "success" => false,
                "message" => "Invalid learner ID provided.",
                "learnerSubmissions" => [],
            ]);
            return;
        }

        $result = $this->submissionsModel->getSubmissionsByLearnerId($learnerId);

        if (!empty($result)) {
            echo json_encode([
                "success" => true,
                "message" => "Student submissions successfully fetched!",
                "learnerSubmissions" => $result,
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "No submissions found for this learner.",
                "learnerSubmissions" => [],
            ]);
        }
    }


    public function submitExaminations() {}
}
