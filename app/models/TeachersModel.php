<?php

class TeachersModel
{
    public $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function acceptInsertedTeachers($teacherData)
    {
        try {
            // Ensure required fields are provided
            if (!empty($teacherData['firstName']) && !empty($teacherData['lastName']) && !empty($teacherData['email'])) {

                // Prepare the SQL query to insert the teacher into the database
                $sql = "INSERT INTO teachers (first_name, middle_name, last_name, email, contact_number, position, address, date_of_birth, is_active) 
                VALUES (:first_name, :middle_name, :last_name, :email, :contact_number, :position, :address, :date_of_birth, :is_active)";

                // Prepare the statement
                $stmt = $this->pdo->prepare($sql);

                // Bind the parameters
                $stmt->bindParam(':first_name', $teacherData['firstName']);
                $stmt->bindParam(':middle_name', $teacherData['middleName']);
                $stmt->bindParam(':last_name', $teacherData['lastName']);
                $stmt->bindParam(':email', $teacherData['email']);
                $stmt->bindParam(':contact_number', $teacherData['contactNumber']);
                $stmt->bindParam(':position', $teacherData['position']);
                $stmt->bindParam(':address', $teacherData['address']);
                $stmt->bindParam(':date_of_birth', $teacherData['dateOfBirth']);
                $stmt->bindParam(':is_active', $teacherData['isActive'], PDO::PARAM_INT);

                // Execute the query
                if ($stmt->execute()) {
                    // Retrieve the last inserted ID
                    $lastId = $this->pdo->lastInsertId();

                    return [
                        'success' => true,
                        'message' => 'Teacher added successfully',
                        'last_id' => $lastId
                    ];
                } else {
                    return ['success' => false, 'message' => 'Failed to add teacher. Please try again.'];
                }
            } else {
                return ['success' => false, 'message' => 'Missing required fields'];
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()];
        }
    }
    public function renderTeachersByID(int $teacher_id)
    {
        $sql = "SELECT teacher_id, first_name, middle_name, last_name, email, contact_number, position, address, date_of_birth FROM teachers WHERE teacher_id = :teacher_id";

        // Prepare the query
        $stmt = $this->pdo->prepare($sql);

        // Bind the teacher_id parameter (using PDO)
        $stmt->bindParam(':teacher_id', $teacher_id, PDO::PARAM_INT);

        // Execute the query
        $stmt->execute();

        // Fetch the result
        $teacher = $stmt->fetch(PDO::FETCH_ASSOC);

        // Return the result if teacher found, otherwise return null
        return $teacher ?: null;
    }

    public function showAllTeachers()
    {
        $stmt = $this->pdo->query('SELECT * FROM teachers WHERE is_active = 1');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function acceptUpdatedTeacher($updateData)
    {
        try {
            // Prepare SQL (no need to compare again, controller already did that)
            $sql = "UPDATE teachers SET 
            first_name = :first_name,
            middle_name = :middle_name,
            last_name = :last_name,
            email = :email,
            contact_number = :contact_number,
            position = :position,
            address = :address,
            date_of_birth = :date_of_birth
            WHERE teacher_id = :teacher_id";

            $stmt = $this->pdo->prepare($sql);

            // Bind values
            $stmt->bindParam(':first_name', $updateData['first_name']);
            $stmt->bindParam(':middle_name', $updateData['middle_name']);
            $stmt->bindParam(':last_name', $updateData['last_name']);
            $stmt->bindParam(':email', $updateData['email']);
            $stmt->bindParam(':contact_number', $updateData['contact_number']);
            $stmt->bindParam(':position', $updateData['position']);
            $stmt->bindParam(':address', $updateData['address']);
            $stmt->bindParam(':date_of_birth', $updateData['date_of_birth']);
            $stmt->bindParam(':teacher_id', $updateData['teacher_id'], PDO::PARAM_INT);

            $stmt->execute();

            // ✅ Check if any row was actually updated
            if ($stmt->rowCount() > 0) {
                return ['success' => true, 'message' => 'Teacher data updated successfully.'];
            } else {
                return ['success' => false, 'message' => 'No data was changed.'];
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()];
        }
    }



    public function getTeacherById($teacherId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM teachers WHERE teacher_id = :teacher_id");
        $stmt->bindParam(':teacher_id', $teacherId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function archiveTeacher($teacherId)
    {
        // Prepare the SQL query to update the teacher's is_active status
        $sql = "UPDATE teachers SET is_active = 0 WHERE teacher_id = :teacher_id";

        try {
            // Prepare the query
            $stmt = $this->pdo->prepare($sql);

            // Bind the teacher_id parameter to the query
            $stmt->bindParam(":teacher_id", $teacherId, PDO::PARAM_INT);

            // Execute the query and return true if successful
            if ($stmt->execute()) {
                return true;
            } else {
                return false; // Return false if execution fails
            }
        } catch (Exception $e) {
            // Log or handle the exception if there's an error
            error_log("Error in archiveTeacher: " . $e->getMessage());
            return false;
        }
    }
}
