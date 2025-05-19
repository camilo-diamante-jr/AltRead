<?php

require_once '../core/Controller.php';

class UserController extends Controller
{
    private $userModel;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this->userModel = $this->loadModel('UserModel');
    }



    public function addUser(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userData = [
                'name' => htmlspecialchars(trim($_POST['name'])),
                'username' => htmlspecialchars(trim($_POST['username'])),
                'email' => htmlspecialchars(trim($_POST['email'])),
                'password' => $_POST['password'],
                'user_type' => $_POST['userType'],
                'avatar' => 'default-profile.png',
                'is_status' => 'inactive',
            ];

            $userData['avatar'] = $this->handleAvatarUpload($userData['avatar']);
            $result = $this->userModel->createUser($userData);

            echo json_encode([
                'success' => $result,
                'message' => $result ? 'User added successfully.' : 'Failed to add user.',
            ]);
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
        }
    }

    public function editUser(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['userID']) || empty($_POST['userID'])) {
                echo json_encode(['success' => false, 'message' => 'User ID is required.']);
                exit;
            }

            $userID = intval($_POST['userID']);
            $editedUserData = [
                'name' => htmlspecialchars(trim($_POST['name'])),
                'username' => htmlspecialchars(trim($_POST['username'])),
                'email' => htmlspecialchars(trim($_POST['email'])),
                'user_type' => $_POST['userType'],
                'avatar' => 'default-avatar.jpg',
            ];

            $editedUserData['avatar'] = $this->handleAvatarUpload($editedUserData['avatar']);
            $currentUserData = $this->userModel->getUserById($userID);

            if (!$this->isDataChanged($currentUserData, $editedUserData)) {
                echo json_encode(['success' => false, 'message' => 'No changes detected.']);
                exit;
            }

            $result = $this->userModel->updateUser($userID, $editedUserData);
            echo json_encode([
                'success' => $result,
                'message' => $result ? 'User updated successfully.' : 'Failed to update user.',
            ]);
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
        }
    }

    private function isDataChanged(array $currentUserData, array $userData): bool
    {
        foreach ($userData as $key => $value) {
            $currentValue = $currentUserData[$key] ?? '';
            if ($currentValue !== $value) {
                return true;
            }
        }
        return false;
    }

    // Archived Users

    public function deleteUser(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate user ID
            if (!isset($_POST['userID']) || empty($_POST['userID'])) {
                echo json_encode(['success' => false, 'message' => 'User ID is required.']);
                exit;
            }

            $userId = intval($_POST['userID']); // Sanitize input

            try {
                // Attempt to delete user via the model
                $result = $this->userModel->deleteUser($userId);

                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'User archived successfully.']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to archive user.']);
                }
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
        }
    }


    private function handleAvatarUpload(string $defaultAvatar): string
    {
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $avatarTmpPath = $_FILES['avatar']['tmp_name'];
            $avatarName = basename($_FILES['avatar']['name']);
            $avatarUploadPath = 'files/uploads/avatars/' . $avatarName;

            if (move_uploaded_file($avatarTmpPath, $avatarUploadPath)) {
                return $avatarName;
            }
        }
        return $defaultAvatar;
    }
}
