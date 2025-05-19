<?php

require_once '../core/Controller.php';

class AnswerKeyController extends Controller
{
    private $answerKeyModel;

    public function __construct($pdo)
    {
        parent::__construct($pdo);
        $this->answerKeyModel = $this->loadModel('AnswerKeyModel');
    }

    // Preview uploaded files
    public function handleAnswerKeysFilePreview()
    {
        $files = [];

        if (!empty($_FILES['file']['name'][0])) {
            foreach ($_FILES['file']['name'] as $key => $fileName) {
                $files[] = [
                    'name' => htmlspecialchars($fileName, ENT_QUOTES, 'UTF-8'),
                ];
            }
        }

        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'message' => 'Files successfully rendered',
            'files' => $files
        ]);
    }

    // Handle file upload
    public function handleAnswerKeysUpload()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $uploadDir = __DIR__ . '/../../public/files/uploads/answer_keys/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $uploadedFiles = [];

            if (!empty($_FILES['file']['name'][0])) {
                foreach ($_FILES['file']['name'] as $key => $name) {
                    $tmpName = $_FILES['file']['tmp_name'][$key];
                    $error = $_FILES['file']['error'][$key];
                    $size = $_FILES['file']['size'][$key];
                    $fileExt = strtolower(pathinfo($name, PATHINFO_EXTENSION));

                    // Only allow PDF files
                    if ($fileExt !== 'pdf') continue;

                    if ($error === UPLOAD_ERR_OK && is_uploaded_file($tmpName)) {
                        // Sanitize original file name (remove dangerous characters)
                        $safeName = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $name);
                        $destination = $uploadDir . $safeName;

                        // Handle filename collision
                        $i = 1;
                        while (file_exists($destination)) {
                            $fileBase = pathinfo($safeName, PATHINFO_FILENAME);
                            $fileExt = pathinfo($safeName, PATHINFO_EXTENSION);
                            $safeName = $fileBase . "_{$i}." . $fileExt;
                            $destination = $uploadDir . $safeName;
                            $i++;
                        }

                        // Move the file
                        if (move_uploaded_file($tmpName, $destination)) {
                            $fileData = [
                                'original_name' => $name,
                                'stored_name'   => $safeName,
                                'file_path'     => '/files/uploads/answer_keys/' . $safeName,
                                'file_size'     => $size,
                                'uploaded_at'   => date('Y-m-d H:i:s')
                            ];

                            // Insert file data into the database
                            $lastInsertedId = $this->answerKeyModel->insertAnswerKey($fileData);

                            // Add to the uploaded files array with the last inserted ID
                            $uploadedFiles[] = [
                                'id'             => $lastInsertedId,
                                'original_name'  => htmlspecialchars($name, ENT_QUOTES, 'UTF-8'),
                                'uploaded_at'    => $fileData['uploaded_at']
                            ];
                        }
                    }
                }
            }

            // Send response back with uploaded files information and last inserted ID
            header('Content-Type: application/json');
            echo json_encode([
                'status'   => 'success',
                'uploaded' => $uploadedFiles
            ]);
        } else {
            // Handle invalid request method (not POST)
            http_response_code(405);
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid request method.'
            ]);
        }
    }
    public function handleFileChanges()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json');

            $answerkey_id = filter_input(INPUT_POST, 'answerkey_id', FILTER_VALIDATE_INT);
            $new_file = $_FILES['new_file'] ?? null;

            if (!$answerkey_id || !$new_file) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Invalid or missing file ID or file.',
                ]);
                return;
            }

            $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/files/uploads/answer_keys/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0775, true);
            }

            $original_name = basename($new_file['name']);
            $file_extension = pathinfo($original_name, PATHINFO_EXTENSION);

            if (strtolower($file_extension) !== 'pdf') {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Only PDF files are allowed.',
                ]);
                return;
            }

            $new_file_path = $upload_dir . $original_name;

            if (!move_uploaded_file($new_file['tmp_name'], $new_file_path)) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Error uploading the file.',
                ]);
                return;
            }

            // Update DB with the original file name
            $updated = $this->answerKeyModel->updateFile($answerkey_id, $original_name);

            if ($updated) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'File successfully updated.',
                    'updated_file' => [
                        'id' => $answerkey_id,
                        'original_name' => $original_name,
                        'uploaded_at' => date('Y-m-d H:i:s'),
                    ],
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Failed to update the file in the database.',
                ]);
            }
        } else {
            http_response_code(405);
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid request method.',
            ]);
        }
    }


    // Archive file
    public function handleArchiveAnswerKeys()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate and sanitize the input
            $answerkey_id = filter_input(INPUT_POST, 'answerkey_id', FILTER_VALIDATE_INT);

            header('Content-Type: application/json');

            if ($answerkey_id === false || $answerkey_id === null) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Invalid or missing file ID.',
                ]);
                return;
            }

            // Call the model to archive the file
            $success = $this->answerKeyModel->acceptArchivingAnswerkeys($answerkey_id);

            if ($success) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'File successfully archived.',
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'File failed to archive!',
                ]);
            }
        } else {
            // Handle non-POST requests
            http_response_code(405); // Method Not Allowed
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid request method.',
            ]);
        }
    }


    public function showAllAnswerkeys(): array
    {
        try {
            return $this->answerKeyModel->fetchAllAnswerKeys();
        } catch (Exception $e) {
            error_log('Error fetching materials: ' . $e->getMessage());
            return [];
        }
    }
}
