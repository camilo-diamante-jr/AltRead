<?php

require_once '../core/Controller.php';

class AuthController extends Controller
{
    protected $authModel;

    public function __construct($pdo)
    {
        parent::__construct($pdo);
        $this->authModel = $this->loadModel('AuthModel');
    }


    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = htmlspecialchars(trim($_POST['username']));
            $password = htmlspecialchars(trim($_POST['password']));

            $result = $this->authModel->login($username, $password);

            if (isset($result['success']) && $result['success']) {
                $_SESSION['user_id'] = $result['user_id'];
                $_SESSION['username'] = $result['username'];
                $_SESSION['user_type'] = $result['user_type'];

                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'user_type' => $result['user_type']]);
                exit;
            } else {
                header('Content-Type: application/json');
                echo json_encode($result);
                exit;
            }
        } else {
            require '../app/views/authentications/login.php';
        }
    }

    public function registrationForm()
    {
        $this->renderView("/authentications/registration");
    }


    public function logout()
    {
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];

            // Update user status in the database
            $stmt = $this->pdo->prepare("UPDATE users SET is_status = 'inactive' WHERE user_id = :user_id");
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();

            // Destroy PHP session
            session_unset();
            session_destroy();
            clearstatcache();

            // Send a response to instruct the browser to clear session storage
            echo '
            <script>
                sessionStorage.clear();
                window.location.href = "/login"; 
            </script>';
            exit;
        } else {
            // Redirect to the login/home page if no session exists
            header('Location: /login');
            exit;
        }
    }
}
