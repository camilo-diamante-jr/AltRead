<?php

require_once '../core/Controller.php';

class LessonsController extends Controller
{
    private $lessonsModel;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this->lessonsModel = $this->loadModel('LessonsModel'); // Load the LessonsModel
    }

    /**
     * Fetch all lessons
     */
    public function showAllLessons(): array
    {
        return $this->lessonsModel->getAllLessons();
    }

    /**
     * Fetch lessons by module ID
     */
    public function lessonsPerModuleFunction(): void
    {
        // Set the response header for JSON
        header('Content-Type: application/json');

        // Ensure module_id exists in POST data
        if (isset($_POST['module_id'])) {
            $moduleId = $_POST['module_id'];

            // Fetch lessons for the specific module
            $lessons = $this->lessonsModel->getLessonsForModule($moduleId);

            if (!empty($lessons)) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Lessons retrieved successfully.',
                    'data' => $lessons
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'No lessons found!',
                    'data' => []
                ]);
            }
        } else {
            // If module_id is not provided, send an error message
            echo json_encode([
                'status' => 'error',
                'message' => 'Module ID is required.',
                'data' => []
            ]);
        }
    }

    public function createNewLesson()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
            exit;
        }

        // Validate input
        $moduleID = isset($_POST['moduleID']) ? (int) $_POST['moduleID'] : 0;
        $lessonName = isset($_POST['lessonName']) ? trim($_POST['lessonName']) : '';
        $lessonDescription = isset($_POST['lessonDescription']) ? trim($_POST['lessonDescription']) : '';

        if ($moduleID <= 0 || empty($lessonName) || empty($lessonDescription)) {
            echo json_encode(['success' => false, 'message' => 'All fields are required.']);
            exit;
        }

        $lessonData = [
            'moduleID'           => $moduleID,
            'lessonName'         => htmlspecialchars($lessonName),
            'lessonDescription'  => htmlspecialchars($lessonDescription),
            'is_active'          => 1,
        ];

        if (!$this->lessonsModel || !method_exists($this->lessonsModel, 'acceptNewLesson')) {
            echo json_encode(['success' => false, 'message' => 'Internal server error.']);
            exit;
        }

        $result = $this->lessonsModel->acceptNewLesson($lessonData);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Lesson added successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add lesson. Please try again.']);
        }
        exit;
    }
    public function updateCurrentLesson()
    {
        header('Content-Type: application/json');

        // Get the raw POST data and decode JSON
        $rawData = file_get_contents("php://input");
        $data = json_decode($rawData, true);

        // Check if JSON is valid
        if (!$data) {
            echo json_encode(['success' => false, 'message' => 'Invalid JSON data.']);
            exit;
        }

        $lessonID = isset($data['lessonID']) ? (int) $data['lessonID'] : 0;
        $moduleID = isset($data['moduleID']) ? (int) $data['moduleID'] : 0;
        $lessonName = isset($data['lessonName']) ? trim($data['lessonName']) : '';
        $lessonDescription = isset($data['lessonDescription']) ? trim($data['lessonDescription']) : '';

        if ($lessonID <= 0 || $moduleID <= 0 || empty($lessonName) || empty($lessonDescription)) {
            echo json_encode(['success' => false, 'message' => 'All fields are required.']);
            exit;
        }

        $lessonData = [
            'lessonID'          => $lessonID,
            'moduleID'          => $moduleID,
            'lessonName'        => htmlspecialchars($lessonName),
            'lessonDescription' => htmlspecialchars($lessonDescription),
        ];

        if (!$this->lessonsModel || !method_exists($this->lessonsModel, 'acceptUpdatedLesson')) {
            echo json_encode(['success' => false, 'message' => 'Internal server error.']);
            exit;
        }

        $result = $this->lessonsModel->acceptUpdatedLesson($lessonData);

        echo json_encode([
            'success' => $result,
            'message' => $result ? 'Lesson updated successfully.' : 'Failed to update lesson.'
        ]);
        exit;
    }


    /**
     * Remove lessons by lesson id
     */
    public function removeCurrentLesson()
    {

        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            http_response_code(400);
            die(json_encode(["success" => false, "message" => "Invalid request method."]));
        }

        $data = json_decode(file_get_contents("php://input"), true);

        if ($data === null) {
            http_response_code(400);
            die(json_encode(["success" => false, "message" => "Invalid JSON format."]));
        }

        $lessonID = $data['lessonID'] ?? null;

        if (empty($lessonID)) {
            http_response_code(400);
            die(json_encode(["success" => false, "message" => "Lesson ID is required."]));
        }

        error_log("🗑 Removing Lesson ID: " . $lessonID);

        $updated = $this->lessonsModel->deactivateLesson($lessonID);

        if ($updated) {
            echo json_encode(["success" => true, "message" => "Lesson deactivated successfully."]);
        } else {
            error_log("❌ Deactivation Failed for Lesson ID: " . $lessonID);
            http_response_code(500);
            die(json_encode(["success" => false, "message" => "Error removing lesson. Please try again."]));
        }
    }
}
