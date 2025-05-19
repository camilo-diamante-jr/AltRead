<?php

class AuthModel
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function userExists($username, $email): bool
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    public function login($username, $password): array
    {
        try {
            // Check for 'active' or 'inactive' status
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ? AND is_status IN ('active', 'inactive')");
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                return [
                    'error' => true,
                    'message' => 'User not found or inactive.',
                ];
            }

            // Use password_verify to compare the entered password with the stored hashed password
            if (!password_verify($password, $user['password'])) {
                return [
                    'error' => true,
                    'message' => 'Incorrect password',
                ];
            }

            return [
                'success' => true,
                'user_id' => $user['user_id'],
                'user_type' => $user['user_type'],
                'username' => $user['username'],
            ];
        } catch (PDOException $e) {
            return [
                'error' => true,
                'message' => 'Database error: ' . $e->getMessage(),
            ];
        }
    }
}
