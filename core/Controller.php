<?php

class Controller
{
    /**
     * @var PDO Database connection instance.
     */
    protected $pdo;

    /**
     * Controller constructor.
     * @param PDO $pdo Database connection.
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Get the current logged-in user's profile.
     * @return array|null Returns user profile data or null if not logged in.
     */
    protected function getUserProfile(): ?array
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (isset($_SESSION['user_id'])) {
            // Sanitize the user ID
            $userID = filter_var($_SESSION['user_id'], FILTER_SANITIZE_NUMBER_INT);

            try {
                $stmt = $this->pdo->prepare("SELECT * FROM users WHERE user_id = :userID");
                $stmt->execute([':userID' => $userID]);
                return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
            } catch (PDOException $e) {
                error_log("Error fetching user profile: " . $e->getMessage());
                return null;
            }
        }

        return null;
    }

    /**
     * Dynamically load a model.
     * @param string $model Name of the model to load.
     * @return object Instantiated model.
     * @throws Exception If the model file or class is not found.
     */
    protected function loadModel(string $model): object
    {
        $modelPath = __DIR__ . "/../app/models/{$model}.php";

        if (!file_exists($modelPath)) {
            throw new Exception("Model file not found: {$modelPath}");
        }

        require_once $modelPath;

        if (!class_exists($model)) {
            throw new Exception("Model class not found: {$model}");
        }

        return new $model($this->pdo);
    }

    /**
     * Redirect to another URL.
     * @param string $url URL to redirect to.
     */
    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }

    /**
     * Render a view and pass optional data to it.
     * @param string $view Path to the view file.
     * @param array $data Data to pass to the view.
     * @throws Exception If the view file is not found.
     */
    protected function renderView(string $view, array $data = []): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $data['userProfile'] = $this->getUserProfile();

        extract($data);
        $viewPath = __DIR__ . "/../app/views/{$view}.php";

        if (!file_exists($viewPath)) {
            throw new Exception("View file not found: {$viewPath}");
        }

        require_once $viewPath;
    }

    /**
     * Render an error message.
     * @param string $message Error message to display.
     */
    protected function renderError(string $message = 'Something went wrong. Please contact support if the issue persists.'): void
    {
        // Sanitize the message to prevent XSS attacks
        $safeMessage = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

        // Error data to display or pass to a view
        $data = [
            'page_title' => 'Error',
            'error_message' => $safeMessage,
        ];

        // Log the error for debugging (if a logging mechanism exists)

        // Display the error message directly (or render a view)
        echo $data['error_message'];

        // Optionally use a dedicated error view
        // $this->renderView('errors/view.error', $data);
    }
}
