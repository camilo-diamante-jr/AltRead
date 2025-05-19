<?php

class AnswerKeyModel
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Insert new answer key file into the database
    public function insertAnswerKey($fileData)
    {
        $sql = "INSERT INTO answer_keys 
            (original_name, stored_name, file_path, file_size, uploaded_at)
            VALUES (:original_name, :stored_name, :file_path, :file_size, :uploaded_at)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':original_name' => $fileData['original_name'],
            ':stored_name'   => $fileData['stored_name'],
            ':file_path'     => $fileData['file_path'],
            ':file_size'     => $fileData['file_size'],
            ':uploaded_at'   => $fileData['uploaded_at']
        ]);

        return $this->pdo->lastInsertId();  // Return last inserted ID
    }

    // Fetch all active answer keys
    public function fetchAllAnswerKeys(): array
    {
        $sql = 'SELECT * FROM answer_keys WHERE is_active = 1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Archive the answer key by updating its status
    public function acceptArchivingAnswerkeys(int $answerkey_id): bool
    {
        $sql = "UPDATE answer_keys SET is_active = 0 WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        // Execute the query and return success or failure
        return $stmt->execute(['id' => $answerkey_id]);
    }

    public function updateFile(int $answerkey_id, string $new_file_name): bool
    {
        $sql = "UPDATE answer_keys SET original_name = :original_name WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'id' => $answerkey_id,
            'original_name' => $new_file_name,
            // 'updated_at' => date('Y-m-d H:i:s')
        ]);

        return $stmt->rowCount() > 0;
    }
}
