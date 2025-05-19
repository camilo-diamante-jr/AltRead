<?php

class ModuleModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }


    /* Create */
    public function acceptNewModule(array $moduleData): bool
    {
        try {
            // Check if module name already exists
            $checkStmt = $this->pdo->prepare("SELECT COUNT(*) FROM modules WHERE module_name = :name");
            $checkStmt->bindParam(':name', $moduleData['name'], PDO::PARAM_STR);
            $checkStmt->execute();

            if ($checkStmt->fetchColumn() > 0) {
                error_log("⚠️ Module name already exists: " . $moduleData['name']);
                return false;
            }

            // Insert module
            $query = "INSERT INTO modules (module_name, module_description, is_active) VALUES (:name, :description, :is_active)";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':name', $moduleData['name'], PDO::PARAM_STR);
            $stmt->bindParam(':description', $moduleData['description'], PDO::PARAM_STR);
            $stmt->bindValue(':is_active', 1, PDO::PARAM_INT);

            if (!$stmt->execute()) {
                error_log("❌ SQL Execution Failed: " . print_r($stmt->errorInfo(), true));
                return false;
            }

            error_log("✅ Module Inserted Successfully: " . $moduleData['name']);
            return true;
        } catch (Exception $e) {
            error_log("🔥 Exception: " . $e->getMessage());
            return false;
        }
    }

    /* READ */
    public function showAllModules(): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM modules WHERE is_active = 1 ORDER BY module_id ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /*
        UPDATE
    */
    public function acceptUpdatedModule(array $moduleData): bool
    {
        try {
            $sql = "UPDATE modules SET module_name = :name, module_description = :description WHERE module_id = :id";
            $stmt = $this->pdo->prepare($sql);

            $stmt->bindParam(":id", $moduleData['id'], PDO::PARAM_INT);
            $stmt->bindParam(":name", $moduleData['name'], PDO::PARAM_STR);
            $stmt->bindParam(":description", $moduleData['description'], PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error updating module: " . $e->getMessage());
            return false;
        }
    }

    /* DELETE(ARCHIVED) */
    public function deactivateModule(int $moduleId): bool
    {
        try {
            error_log("Attempting to deactivate module with ID: " . $moduleId); // Log ID

            $stmt = $this->pdo->prepare("UPDATE modules SET is_active = 0 WHERE module_id = :id");
            $stmt->bindParam(":id", $moduleId, PDO::PARAM_INT);

            if (!$stmt->execute()) {
                error_log("SQL Execution Failed!");
                return false;
            }

            error_log("Module successfully deactivated!");
            return true;
        } catch (PDOException $e) {
            error_log("Error deactivating module: " . $e->getMessage());
            return false;
        }
    }
}
