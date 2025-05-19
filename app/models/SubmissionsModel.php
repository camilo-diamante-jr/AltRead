<?php

class SubmissionsModel
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllSubmissions()
    {
        try {
            $query = "
                SELECT
                    learners.learner_id,
                    learners.first_name,
                    learners.middle_name,
                    learners.last_name,
                    GROUP_CONCAT(submissions.submission_id) AS submission_ids,
                    COUNT(submissions.submission_id) AS submission_count
                FROM submissions
                INNER JOIN learners ON submissions.learner_id = learners.learner_id
                GROUP BY learners.learner_id
            ";
            $stmt = $this->pdo->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            return [];
        }
    }

    public function getSubmissionsByLearnerId($learnerId)
    {
        try {
            $query = "
                SELECT
                    learners.learner_id,
                    learners.first_name,
                    learners.middle_name,
                    learners.last_name,
                    GROUP_CONCAT(submissions.submission_id) AS submission_ids,
                    COUNT(submissions.submission_id) AS submission_count
                FROM submissions
                INNER JOIN learners ON submissions.learner_id = learners.learner_id
                WHERE learners.learner_id = :learner_id
                GROUP BY learners.learner_id
            ";

            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['learner_id' => $learnerId]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            return [];
        }
    }

    public function saveSubmission($data)
    {
        $query = "
            INSERT INTO submissions
                (question_id, choice_id, written_answer, is_correct, learner_id, lesson_id)
            VALUES
                (:question_id, :choice_id, :written_answer, :is_correct, :learner_id, :lesson_id)
        ";

        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([
            'question_id'    => $data['question_id'],
            'choice_id'      => $data['choice_id'],
            'written_answer' => $data['written_answer'],
            'is_correct'     => $data['is_correct'],
            'learner_id'     => $data['learner_id'],
            'lesson_id'      => $data['lesson_id'],
        ]);
    }

    public function getStudentSubmissionsById($studentId)
    {
        $query = "
            SELECT
                lesson_name,
                part1,
                part2,
                part3,
                part4,
                total,
                module_id
            FROM submissions
            WHERE student_id = :id
        ";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $studentId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchYourSubmissions($learnerId)
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM pretest_submitted_answers WHERE learnerID = :learnerID
        ");
        $stmt->bindParam(':learnerID', $learnerId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function renderStudentSubmissions($learnerId)
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM submissions WHERE learnerID = :learnerID
        ");
        $stmt->bindParam(':learnerID', $learnerId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
