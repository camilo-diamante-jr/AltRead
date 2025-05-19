<?php

class MaterialsModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function showAllMaterials(): array
    {
        try {
            $stmt = $this->pdo->query('SELECT * FROM materials WHERE isArchived = 0');
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            return [];
        }
    }

    public function fetchAllArchivedMaterials(): array
    {
        try {
            $stmt = $this->pdo->query('SELECT * FROM materials WHERE isArchived = 1');
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            return [];
        }
    }

    public function retrievematerialsById($materialID)
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM materials WHERE materialID = :materialID');
            $stmt->bindParam(':materialID', $materialID, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            error_log("Database Query Result: " . json_encode($result)); // Log the DB response

            return $result;
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            return null;
        }
    }

    public function acceptNewMaterial(array $data): bool
    {
        try {
            $sql = "INSERT INTO materials (materialTitle, materialSubtitle, materialCategory, materialGenre, materialFiles, isArchived) 
                    VALUES (:title, :subtitle, :category, :genre, :fileName, 0)";

            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                ':title' => $data['title'],
                ':subtitle' => $data['subtitle'],
                ':category' => $data['category'],
                ':genre' => $data['genre'],
                ':fileName' => $data['fileName'],
            ]);
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            return false;
        }
    }

    public function getLastInsertedID()
    {
        // Assuming you're using PDO for database operations
        $stmt = $this->pdo->prepare("SELECT LAST_INSERT_ID() as last_id");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['last_id'];
    }


    public function acceptUpdateMaterial(array $data): bool
    {
        $sql = "UPDATE materials 
        SET
        materialTitle = :title, 
        materialSubtitle = :subtitle, 
        materialCategory = :category, 
        materialGenre = :genre, 
        materialFiles = :fileName 
        WHERE materialID = :materialID";


        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':materialID' => $data['materialID'],
            ':title' => $data['updateTitle'],
            ':subtitle' => $data['updateSubtitle'],
            ':category' => $data['updateCategory'],
            ':genre' => $data['updateGenre'],
            ':fileName' => $data['fileName'],
        ]);
    }

    public function acceptArchiveMaterial(array $materialData): bool
    {
        try {
            $sql = "UPDATE materials SET isArchived = 1 WHERE materialID = :materialID";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([':materialID' => $materialData['materialID']]);
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage()); // Logging error
            return false;
        }
    }
    public function acceptMaterialRestoration(array $materialData): bool
    {
        try {
            $sql = "UPDATE materials SET isArchived = 0 WHERE materialID = :materialID";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([':materialID' => $materialData['materialID']]);
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage()); // Logging error
            return false;
        }
    }
}
