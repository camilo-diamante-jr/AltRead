<?php

require_once '../core/Controller.php';

class PISController extends Controller
{
    private $pisModel;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this->pisModel = $this->loadModel('PISModel');
    }

    public function createLearner()
    {
        try {
            $userId = $_SESSION['user_id'] ?? null;
            if (!$userId) {
                throw new Exception("User not logged in.");
            }

            // Format Address
            $addressParts = [
                $_POST['address_street'] ?? '',
                $_POST['address_barangay'] ?? '',
                $_POST['address_city'] ?? '',
                $_POST['address_province'] ?? ''
            ];
            $address = implode(', ', array_filter($addressParts));

            // Format Birthdate
            $birthdate = sprintf(
                '%04d-%02d-%02d',
                $_POST['birth_year'] ?? 0,
                $_POST['birth_month'] ?? 0,
                $_POST['birth_day'] ?? 0
            );

            $data = [
                'first_name' => trim($_POST['first_name'] ?? ''),
                'middle_name' => trim($_POST['middle_name'] ?? ''),
                'last_name' => trim($_POST['last_name'] ?? ''),
                'sex' => $_POST['sex'] ?? '',
                'birthdate' => $birthdate,
                'address' => $address,
                'religion' => $_POST['religion'] ?? '',
                'marital_status' => $_POST['marital_status'] ?? '',
                'occupation' => $_POST['occupation'] ?? '',
                'educational_attainment' => $_POST['education'] ?? '',
                'personal_statement' => $_POST['about'] ?? '',
                'enrollment_status' => 'pending' // Default status
            ];

            if ($this->pisModel->acceptNewLearner($userId, $data)) {
                echo json_encode(['status' => 'success', 'message' => 'Learner information saved successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to save learner information.']);
            }
        } catch (Exception $e) {
            error_log("Error creating learner PIS: " . $e->getMessage());
            echo json_encode(['status' => 'error', 'message' => 'An error occurred. Please try again.']);
        }
    }


    public function fetchEnrollmentStatus(int $userID): ?string
    {
        try {
            return $this->pisModel->getEnrollmentStatus($userID) ?? 'not enrolled';
        } catch (Exception $e) {
            error_log("Error fetching enrollment status: " . $e->getMessage());
            return 'error';
        }
    }

    public function getStudents()
    {
        header('Content-Type: application/json');

        $query = isset($_POST['query']) ? strtolower(trim($_POST['query'])) : '';

        $students = $this->pisModel->showAllLearners();

        if (!empty($students)) {
            // Filter students based on full name
            $filteredStudents = array_filter($students, function ($student) use ($query) {
                $fullName = strtolower(trim($student['first_name'] . ' ' . $student['middle_name'] . ' ' . $student['last_name']));
                return strpos($fullName, $query) !== false;
            });

            // Map filtered students to send only necessary data
            $studentsList = array_map(function ($student) {
                return [
                    "learner_id" => $student['learner_id'], // include the ID
                    "full_name" => trim($student['first_name'] . ' ' . $student['middle_name'] . ' ' . $student['last_name'])
                ];
            }, array_values($filteredStudents)); // reindex array

            echo json_encode([
                "success" => true,
                "students" => $studentsList
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "students" => [],
                "message" => "No students found."
            ]);
        }
    }


    public function fetchAllStudents()
    {
        header('Content-Type: application/json');

        $students = $this->pisModel->renderAllStudents();



        if (!empty($students)) {
            echo json_encode(["success" => true, "students" => $students]);
        } else {
            echo json_encode(["success" => false, "students" => [], "message" => "No students found."]);
        }
    }


    public function updatePersonalInfoStatus()
    {
        try {
            // Log POST data to check values
            error_log("POST Data: " . print_r($_POST, true));

            // Validate input
            $learnerID = isset($_POST['learnerID']) ? trim($_POST['learnerID']) : null;
            $personalStatus = isset($_POST['personalStatus']) ? trim($_POST['personalStatus']) : null;
            $rejectionReason = isset($_POST['rejectionReason']) ? trim($_POST['rejectionReason']) : null;

            if (empty($learnerID) || empty($personalStatus)) {
                echo json_encode(['success' => false, 'message' => 'Invalid input. Missing learnerID or personalStatus.']);
                return;
            }

            // Ensure rejection reason is only saved if the status is 'rejected'
            if ($personalStatus !== 'rejected') {
                $rejectionReason = null;
            }

            // Call model to update database
            $result = $this->pisModel->acceptUpdatePersonalInformationSubmissionStatus($learnerID, $personalStatus, $rejectionReason);

            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Enrollment status updated successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update enrollment status.']);
            }
        } catch (Exception $e) {
            error_log("Error updating personal info status: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'An error occurred while updating status.']);
        }
    }
}
