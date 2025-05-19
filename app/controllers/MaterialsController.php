<?php

require_once '../core/Controller.php';

class MaterialsController extends Controller
{
    private MaterialsModel $materialsModel;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this->materialsModel = $this->loadModel('MaterialsModel');
    }


    /*
     
     For retrieving Materials

     */


    public function showAllMaterials(): array
    {
        try {
            return $this->materialsModel->showAllMaterials();
        } catch (Exception $e) {
            error_log('Error fetching materials: ' . $e->getMessage());
            return [];
        }
    }

    // showing materials that was archived
    public function showAllArchivedMaterials(): array
    {
        try {
            return $this->materialsModel->fetchAllArchivedMaterials();
        } catch (Exception $e) {
            error_log('Error fetching archived materials: ' . $e->getMessage());
            return [];
        }
    }

    // Showing all materials by id
    public function getMaterialsById()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
            return;
        }

        // Retrieve JSON data from the request body
        $inputData = json_decode(file_get_contents("php://input"), true);
        $materialID = $inputData['materialID'] ?? null;

        if (!$materialID || !is_numeric($materialID)) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid material ID']);
            return;
        }

        try {
            $material = $this->materialsModel->retrievematerialsById((int) $materialID);

            if ($material) {
                error_log("Material Found: " . json_encode($material)); // Debug log
                echo json_encode(['material' => $material]);
            } else {
                error_log("No material found for ID: " . $materialID); // Debug log
                http_response_code(404);
                echo json_encode(['error' => 'Material not found']);
            }
        } catch (Exception $e) {
            error_log('Error fetching material: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error']);
        }
    }


    public function insertNewMaterial()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Prepare the data array for insertion
            $data = [
                'title' => $_POST['title'] ?? null,
                'subtitle' => $_POST['subtitle'] ?? null,
                'category' => $_POST['category'] ?? null,
                'genre' => $_POST['genre'] ?? null,
                'fileName' => null, // This will be populated with the uploaded file name
            ];

            // Check if a file is uploaded
            if (!empty($_FILES['file']['name'])) {
                $uploadDir = 'files/uploads/';

                // Use the original file name for saving
                $fileName = basename($_FILES['file']['name']); // Original file name
                $filePath = $uploadDir . $fileName; // Path where file will be saved

                $allowedMimeTypes = ['application/pdf'];
                $fileType = mime_content_type($_FILES['file']['tmp_name']);

                if (!in_array($fileType, $allowedMimeTypes)) {
                    error_log("Invalid file type: " . $fileType);
                    http_response_code(400);
                    echo json_encode(['error' => 'Invalid file type. Only PDF files are allowed.']);
                    return;
                }

                // Move the uploaded file to the desired directory
                if (!move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
                    error_log("File upload failed: " . $_FILES['file']['error']);
                    http_response_code(500);
                    echo json_encode(['error' => 'File upload failed.']);
                    return;
                }

                // Add the uploaded file name to the data array
                $data['fileName'] = $fileName;
            }

            // Insert the new material into the database
            $success = $this->materialsModel->acceptNewMaterial($data);

            // Check if the material was added successfully
            if ($success) {
                // Get the newly created material's ID (assuming your model provides this after insertion)
                $newMaterialID = $this->materialsModel->getLastInsertedID();  // Method to fetch last inserted ID

                // Send success response with the new material ID
                echo json_encode([
                    'success' => 'Material added successfully',
                    'materialID' => $newMaterialID // Include the ID of the newly inserted material
                ]);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to add material']);
            }
        }
    }

    // Update Materials
    public function updateMaterial()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $data = [
                'materialID' => $_POST['updateMaterialID'] ?? null,
                'updateTitle' => $_POST['updateTitle'] ?? null,
                'updateSubtitle' => $_POST['updateSubtitle'] ?? null,
                'updateCategory' => $_POST['updateCategory'] ?? null,
                'updateGenre' => $_POST['updateGenre'] ?? null,
                'fileName' => null,
            ];

            if (!empty($_FILES['updateFile']['name'])) {
                $uploadDir = 'files/uploads/';

                // Get original file name and sanitize it
                $originalFileName = basename($_FILES['updateFile']['name']);
                $safeFileName = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $originalFileName); // Replace unsafe chars

                $filePath = $uploadDir . $safeFileName;

                // Ensure the file type is allowed (PDF)
                $allowedMimeTypes = ['application/pdf'];
                $fileType = mime_content_type($_FILES['updateFile']['tmp_name']);

                if (!in_array($fileType, $allowedMimeTypes)) {
                    error_log("Invalid file type: " . $fileType);
                    http_response_code(400);
                    echo json_encode(['error' => 'Invalid file type. Only PDF files are allowed.']);
                    return;
                }

                // Handle duplicate file names
                $counter = 1;
                $newFilePath = $filePath;
                while (file_exists($newFilePath)) {
                    $fileInfo = pathinfo($safeFileName);
                    $newFileName = $fileInfo['filename'] . "_($counter)." . $fileInfo['extension'];
                    $newFilePath = $uploadDir . $newFileName;
                    $counter++;
                }

                // Move uploaded file
                if (!move_uploaded_file($_FILES['updateFile']['tmp_name'], $newFilePath)) {
                    error_log("File upload failed: " . $_FILES['updateFile']['error']);
                    http_response_code(500);
                    echo json_encode(['error' => 'File upload failed.']);
                    return;
                }

                $data['fileName'] = basename($newFilePath); // Store only filename
            }

            // Update material in the database
            $result = $this->materialsModel->acceptUpdateMaterial($data);

            if ($result) {
                echo json_encode(
                    [
                        'success' => true,
                        'message' => 'Material updated successfully.',
                        'fileName' => $data['fileName'] ?? null
                    ]
                );
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to update material']);
            }
        }
    }

    public function archivedMaterialById()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== "POST") {
            http_response_code(405);
            echo json_encode(['error' => 'Invalid request method']);
            exit;
        }

        $inputData = json_decode(file_get_contents("php://input"), true);

        if (!isset($inputData['materialID']) || empty($inputData['materialID'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Material ID is required']);
            exit;
        }

        $materialID = $inputData['materialID'];
        $success = $this->materialsModel->acceptArchiveMaterial(['materialID' => $materialID]);

        if ($success) {
            echo json_encode([
                'success' => true,
                'message' => 'Material successfully moved to archive',
                'materialID' => $materialID
            ]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to archive material']);
        }
    }


    /* 
     
    RESTORATION

    */
    public function restoreMaterialById()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== "POST") {
            http_response_code(405);
            echo json_encode(['error' => 'Invalid request method']);
            exit;
        }

        $inputData = json_decode(file_get_contents("php://input"), true);

        if (!isset($inputData['materialID']) || empty($inputData['materialID'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Material ID is required']);
            exit;
        }

        $materialID = $inputData['materialID'];
        $success = $this->materialsModel->acceptMaterialRestoration(['materialID' => $materialID]);

        if ($success) {
            echo json_encode([
                'success' => true,
                'message' => 'Material successfully restored', // ✅ Fixed message
                'materialID' => $materialID
            ]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to restore material']); // ✅ Fixed message
        }
    }
}
