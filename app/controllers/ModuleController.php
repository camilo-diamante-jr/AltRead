<?php

require_once '../core/Controller.php';

class ModuleController extends Controller
{
    private $moduleModel;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this->moduleModel = $this->loadModel('ModuleModel');
    }

    public function readAllModules()
    {
        $modules = $this->moduleModel->showAllModules();
        header('Content-Type: application/json');

        if (!empty($modules)) {
            echo json_encode(["success" => true, "data" => $modules]);
        } else {
            echo json_encode(["success" => false, "data" => [], "message" => "No modules found."]);
        }
    }


    public function createNewModule()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            error_log("🚫 Invalid Request Method");
            echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
            exit;
        }

        // Decode JSON input
        $inputJSON = file_get_contents("php://input");
        $inputData = json_decode($inputJSON, true);

        if (!isset($inputData['moduleName'], $inputData['moduleDescription'])) {
            error_log("⚠️ Missing Required Fields");
            echo json_encode(['success' => false, 'message' => 'All fields are required.']);
            exit;
        }

        // Sanitize input
        $moduleData = [
            'name' => htmlspecialchars(trim($inputData['moduleName'])),
            'description' => htmlspecialchars(trim($inputData['moduleDescription'])),
            'is_active' => 1, // Default value
        ];

        if (empty($moduleData['name']) || empty($moduleData['description'])) {
            error_log("⚠️ Validation Failed: Empty fields.");
            echo json_encode(['success' => false, 'message' => 'All fields are required.']);
            exit;
        }

        $result = $this->moduleModel->acceptNewModule($moduleData);

        if ($result) {
            error_log("✅ Module Successfully Created: " . json_encode($moduleData));
            echo json_encode(['success' => true, 'message' => 'Module added successfully.']);
        } else {
            error_log("❌ Module Creation Failed: " . json_encode($moduleData));
            echo json_encode(['success' => false, 'message' => 'Failed to add module.']);
        }
        exit;
    }



    public function updateCurrentModule()
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

        $moduleId = $data['moduleId'] ?? null;
        $name = trim($data['moduleName'] ?? '');
        $description = trim($data['moduleDescription'] ?? '');

        if (empty($moduleId) || empty($name) || empty($description)) {
            http_response_code(400);
            die(json_encode(["success" => false, "message" => "All fields are required."]));
        }

        $moduleData = ['id' => $moduleId, 'name' => $name, 'description' => $description];

        error_log("🔄 Updating Module: " . print_r($moduleData, true));

        $updated = $this->moduleModel->acceptUpdatedModule($moduleData);

        if ($updated) {
            echo json_encode(["success" => true, "message" => "Module updated successfully."]);
        } else {
            error_log("❌ Update Failed for module: " . print_r($moduleData, true));
            http_response_code(500);
            die(json_encode(["success" => false, "message" => "Error updating module. Please try again."]));
        }
    }

    public function removeCurrentModule()
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

        $moduleId = $data['moduleId'] ?? null;

        if (empty($moduleId)) {
            http_response_code(400);
            die(json_encode(["success" => false, "message" => "Module ID is required."]));
        }

        error_log("🗑 Removing Module ID: " . $moduleId);

        $updated = $this->moduleModel->deactivateModule($moduleId);

        if ($updated) {
            echo json_encode(["success" => true, "message" => "Module deactivated successfully."]);
        } else {
            error_log("❌ Deactivation Failed for Module ID: " . $moduleId);
            http_response_code(500);
            die(json_encode(["success" => false, "message" => "Error deactivating module. Please try again."]));
        }
    }
}
