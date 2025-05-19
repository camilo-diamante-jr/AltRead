<?php


class RegisterModel
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function register($username, $password, $email, $user_type)
    {
        // Validate input
        if (empty($username) || empty($password) || empty($email) || empty($user_type)) {
            return ['error' => true, 'message' => 'All fields are required.'];
        }

        // Check if the username or email already exists
        $stmt = $this->pdo->prepare("SELECT * FROM user_tbl WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        if ($stmt->rowCount() > 0) {
            return ['error' => true, 'message' => 'Username or email already exists.'];
        }

        // Hash the password
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        // Insert the new user into the database
        $stmt = $this->pdo->prepare("INSERT INTO user_tbl (username, password_hash, email, user_type) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$username, $password_hash, $email, $user_type])) {
            return ['success' => true, 'message' => 'Registration successful!'];
        } else {
            return ['error' => true, 'message' => 'Registration failed. Please try again.'];
        }
    }
}
