<?php

class LessonsModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllLessons(): array
    {
        $sql = 'SELECT lessons.lesson_id, modules.module_id, modules.module_name, modules.module_description, lessons.lesson_name, lessons.lesson_description
                FROM lessons
                INNER JOIN modules ON lessons.module_id=modules.module_id 
                WHERE lessons.is_active = 1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Fetch lessons for a specific module
     */
    public function getLessonsForModule(int $moduleId): array
    {
        $sql = 'SELECT * FROM lessons WHERE module_id = :module_id ORDER BY module_id ASC'; // Fixed SQL
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':module_id', $moduleId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function acceptNewLesson(array $lessonData): bool
    {
        try {
            // Trim and validate inputs
            $lessonName = trim($lessonData['lessonName'] ?? '');
            $moduleID = isset($lessonData['moduleID']) ? (int) $lessonData['moduleID'] : 0;
            $lessonDescription = trim($lessonData['lessonDescription'] ?? '');
            $isActive = 1; // Default active status

            // Check for missing values
            if (empty($lessonName) || empty($moduleID) || empty($lessonDescription) || $moduleID <= 0) {
                error_log("⚠️ Validation Error: Missing or invalid fields.");
                return false;
            }

            // Check if lesson already exists
            $checkStmt = $this->pdo->prepare("
            SELECT COUNT(*) 
            FROM lessons 
            WHERE lesson_name = :name AND module_id = :moduleID
        ");
            $checkStmt->bindParam(':name', $lessonName, PDO::PARAM_STR);
            $checkStmt->bindParam(':moduleID', $moduleID, PDO::PARAM_INT);
            $checkStmt->execute();

            if ((int) $checkStmt->fetchColumn() > 0) {
                error_log("⚠️ Lesson already exists in Module ID: $moduleID (Lesson: $lessonName)");
                return false;
            }

            // Insert new lesson
            $stmt = $this->pdo->prepare("
            INSERT INTO lessons (module_id, lesson_name, lesson_description, is_active) 
            VALUES (:moduleID, :lessonName, :lessonDescription, :isActive)
        ");
            $stmt->bindParam(':moduleID', $moduleID, PDO::PARAM_INT);
            $stmt->bindParam(':lessonName', $lessonName, PDO::PARAM_STR);
            $stmt->bindParam(':lessonDescription', $lessonDescription, PDO::PARAM_STR);
            $stmt->bindParam(':isActive', $isActive, PDO::PARAM_INT);

            if ($stmt->execute()) {
                error_log("✅ Lesson Inserted Successfully: $lessonName (Module ID: $moduleID)");
                return true;
            } else {
                // Log and return SQL error details
                $errorInfo = $stmt->errorInfo();
                error_log("❌ SQL Execution Failed: " . json_encode($errorInfo));
                return false;
            }
        } catch (PDOException $e) {
            error_log("🔥 PDO Exception: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("🔥 General Exception: " . $e->getMessage());
            return false;
        }
    }

    public function acceptUpdatedLesson(array $lessonData): bool
    {
        try {
            // Validate required keys
            if (!isset($lessonData['moduleID'], $lessonData['lessonName'], $lessonData['lessonDescription'], $lessonData['lessonID'])) {
                throw new InvalidArgumentException("Missing required lesson data.");
            }

            // Prepare SQL query
            $stmt = $this->pdo->prepare("
            UPDATE lessons 
            SET module_id = :moduleID, 
                lesson_name = :lessonName, 
                lesson_description = :lessonDescription 
            WHERE lesson_id = :lessonID
        ");

            // Execute update query
            return $stmt->execute([
                ':moduleID'         => $lessonData['moduleID'],
                ':lessonName'       => $lessonData['lessonName'],
                ':lessonDescription' => $lessonData['lessonDescription'],
                ':lessonID'         => $lessonData['lessonID']
            ]);
        } catch (PDOException $e) {
            error_log("Database error in acceptUpdatedLesson: " . $e->getMessage());
            return false;
        } catch (InvalidArgumentException $e) {
            error_log("Invalid argument in acceptUpdatedLesson: " . $e->getMessage());
            return false;
        }
    }
}
