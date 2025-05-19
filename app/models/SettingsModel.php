<?php

class SettingsModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Fetches the account settings for a specific user by user_id.
     *
     * @param int $userId The ID of the user whose account settings are being fetched.
     * @return array The user's account settings.
     * @throws Exception If the query fails.
     */
    public function fetchYourAccountSettings(int $userId): array
    {
        try {
            $query = "SELECT * FROM users WHERE user_id = :user_id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$result) {
                throw new Exception("No account found for user_id: $userId");
            }

            return $result;
        } catch (Exception $e) {
            // Log or handle the exception as needed
            throw new Exception("Error fetching account settings: " . $e->getMessage());
        }
    }
}
