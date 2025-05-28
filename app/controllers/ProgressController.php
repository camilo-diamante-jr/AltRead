<?php

require_once '../core/Controller.php';

class ProgressController extends Controller
{

    private $progressModel;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this->progressModel = $this->loadModel('ProgressModel');
    }

    public function getStudentProgress()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {


            $studentName = isset($_GET['student_name']) ? trim($_GET['student_name']) : '';
            $moduleId = isset($_GET['module_id']) ? trim($_GET['module_id']) : '';

            header('Content-Type: application/json');

            $progressData = $this->progressModel->getStudentProgress($studentName, $moduleId);

            if ($progressData) {
                $response = [
                    'success' => true,
                    'data' => $progressData,
                    'student_name' => $studentName
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'No data found for this student/module.'
                ];
            }

            echo json_encode($response);
        }
    }
}
