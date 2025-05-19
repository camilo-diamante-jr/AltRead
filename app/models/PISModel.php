<?php

class PISModel
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Show all learners in the database.
     * 
     * @return array
     */
    public function showAllLearners(): array
    {
        try {
            $stmt = $this->pdo->query("SELECT * FROM learners");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching all learners: " . $e->getMessage());
            return [];
        }
    }

    public function renderAllStudents(): array
    {
        $query = "SELECT learner_id, first_name, middle_name, last_name FROM learners";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Format names properly
        return array_map(function ($student) {
            $middleInitial = $student['middle_name'] ? strtoupper($student['middle_name'][0]) . '.' : '';
            $fullName = "{$student['first_name']} {$middleInitial} {$student['last_name']}";
            return [
                'learner_id' => $student['learner_id'],
                'name' => trim($fullName)
            ];
        }, $students);
    }


    /**
     * Show learner details by ID.
     * 
     * @param int $learnerID
     * @return array|null
     */
    public function showAllLearnersById(int $learnerID): ?array
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM learners WHERE learner_id = :learner_id');
            $stmt->bindParam(':learner_id', $learnerID, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            error_log("Error fetching learner by ID: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get learner ID by user ID from session.
     * 
     * @return string|null
     */
    public function fetchLearnersIdByUserId(): ?string
    {
        if (!isset($_SESSION['user_id'])) {
            error_log("Error: User ID is not set in session.");
            return null;
        }

        $userID = $_SESSION['user_id'];

        try {
            $stmt = $this->pdo->prepare("SELECT learner_id FROM learners WHERE user_id = :user_id");
            $stmt->bindParam(':user_id', $userID, PDO::PARAM_INT);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['learner_id'] ?? null;
        } catch (PDOException $e) {
            error_log("Error fetching learner ID for user ID $userID: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get the enrollment status of a learner.
     * 
     * @param int $userID
     * @return string|null
     */
    public function getEnrollmentStatus(int $userID): ?string
    {
        try {
            $stmt = $this->pdo->prepare("SELECT enrollment_status FROM learners WHERE user_id = :user_id");
            $stmt->bindParam(':user_id', $userID, PDO::PARAM_INT);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['enrollment_status'] ?? null;
        } catch (PDOException $e) {
            error_log("Error fetching enrollment status for user ID $userID: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Accept and insert a new learner into the database.
     * 
     * @param int $userId
     * @param array $data
     * @return bool
     */
    public function acceptNewLearner(int $userId, array $data): bool
    {
        try {
            $query = "INSERT INTO learners (user_id, first_name, middle_name, last_name, sex, birthdate, address, religion, marital_status, occupation, educational_attainment, personal_statement, enrollment_status) 
                      VALUES (:user_id, :first_name, :middle_name, :last_name, :sex, :birthdate, :address, :religion, :marital_status, :occupation, :education, :personal_statement, 'pending')";

            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':first_name', $data['first_name'], PDO::PARAM_STR);
            $stmt->bindParam(':middle_name', $data['middle_name'], PDO::PARAM_STR);
            $stmt->bindParam(':last_name', $data['last_name'], PDO::PARAM_STR);
            $stmt->bindParam(':sex', $data['sex'], PDO::PARAM_STR);
            $stmt->bindParam(':birthdate', $data['birthdate'], PDO::PARAM_STR);
            $stmt->bindParam(':address', $data['address'], PDO::PARAM_STR);
            $stmt->bindParam(':religion', $data['religion'], PDO::PARAM_STR);
            $stmt->bindParam(':marital_status', $data['marital_status'], PDO::PARAM_STR);
            $stmt->bindParam(':occupation', $data['occupation'], PDO::PARAM_STR);
            $stmt->bindParam(':education', $data['education'], PDO::PARAM_STR);
            $stmt->bindParam(':personal_statement', $data['personal_statement'], PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error inserting new learner: " . $e->getMessage());
            return false;
        }
    }
    public function acceptUpdatePersonalInformationSubmissionStatus($learnerID, $status, $rejectionReason = null)
    {
        try {
            $query = "UPDATE learners SET enrollment_status = :status, reason_for_rejection = :rejectionReason WHERE learner_id = :learnerID";
            $stmt = $this->pdo->prepare($query);

            $stmt->bindValue(':status', $status, PDO::PARAM_STR);
            $stmt->bindValue(':learnerID', $learnerID, PDO::PARAM_INT);
            $stmt->bindValue(':rejectionReason', $rejectionReason, PDO::PARAM_STR);

            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error updating learner status: " . $e->getMessage());
            return false;
        }
    }
}
