<?php

class UserModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllUsers(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM users WHERE is_status IN ('active', 'inactive')");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createUser(array $userData): bool
    {
        $currentDate = date('Y-m-d H:i:s');
        $hashedPassword = password_hash($userData['password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name, username, email, password, user_type, avatar, is_status, date_created) 
                VALUES (:name, :username, :email, :password, :user_type, :avatar, :is_status, :date_created)";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':name' => $userData['name'],
            ':username' => $userData['username'],
            ':email' => $userData['email'],
            ':password' => $hashedPassword,
            ':user_type' => $userData['user_type'],
            ':avatar' => $userData['avatar'] ?? 'default-profile.png',
            ':is_status' => $userData['is_status'],
            ':date_created' => $currentDate,
        ]);
    }

    public function getUserById(int $userId): array
    {
        $sql = "SELECT name, username, email, user_type, avatar FROM users WHERE user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    public function updateUser(int $userId, array $userData): bool
    {
        $currentData = $this->getUserById($userId);

        $fieldsToUpdate = [];
        $queryParams = [':user_id' => $userId];

        foreach ($userData as $key => $value) {
            if (isset($currentData[$key]) && $currentData[$key] !== $value) {
                $fieldsToUpdate[] = "$key = :$key";
                $queryParams[":$key"] = $value;
            }
        }

        if (empty($fieldsToUpdate)) {
            return true; // No changes detected
        }

        $sql = "UPDATE users SET " . implode(', ', $fieldsToUpdate) . " WHERE user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute($queryParams);
    }

    public function deleteUser(int $userId): bool
    {
        $stmt = $this->pdo->prepare("UPDATE users SET is_status = 'archived' WHERE user_id = :user_id");
        return $stmt->execute([':user_id' => $userId]);
    }
}
