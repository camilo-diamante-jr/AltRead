<?php

class PretestModel
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllPretest()
    {
        $stmt = $this->pdo->query('SELECT * FROM pretest WHERE is_active = 1');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllArhcivePretest()
    {
        $stmt = $this->pdo->query('SELECT * FROM pretest WHERE is_active = 0');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCorrectAnswer($pretestID)
    {
        $stmt = $this->pdo->prepare('SELECT correct_answer FROM pretest WHERE pretest_id = :pretestID');
        $stmt->execute([':pretestID' => $pretestID]);
        return $stmt->fetchColumn();
    }
    public function getAllSubmittedPretest()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM pretest_submitted_answers");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function fetchAllSubmittedPretest($learnerID)
    {
        $stmt = $this->pdo->prepare("SELECT ps.pretestID, p.question, p.pretest_type, ps.pretestAnswer, ps.pretestScore 
          FROM pretest_submitted_answers ps
          JOIN pretest p ON ps.pretestID = p.pretest_id
          WHERE ps.learnerID = :learnerID");
        $stmt->execute([':learnerID' => $learnerID]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function pretestScores($learnerID): int
    {
        $stmt = $this->pdo->prepare("SELECT SUM(pretestScore) AS total_score FROM pretest_submitted_answers WHERE learnerID = :learner_id");
        $stmt->execute([':learner_id' => $learnerID]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) ($result['total_score'] ?? 0);
    }

    public function acceptNewPretest($pretestType, $question, $context, $subContexts, $choices, $correctAnswer)
    {
        $sql = 'INSERT INTO pretest (
            pretest_type, question, context, 
            first_sub_context, second_sub_context, third_sub_context, fourth_sub_context, 
            choice_a, choice_b, choice_c, choice_d, correct_answer
        ) VALUES (
            :pretest_type, :question, :context, 
            :first_sub_context, :second_sub_context, :third_sub_context, :fourth_sub_context, 
            :choice_a, :choice_b, :choice_c, :choice_d, :correct_answer
        )';

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':pretest_type' => $pretestType,
            ':question' => $question,
            ':context' => $context,
            ':first_sub_context' => $subContexts['first'] ?? '',
            ':second_sub_context' => $subContexts['second'] ?? '',
            ':third_sub_context' => $subContexts['third'] ?? '',
            ':fourth_sub_context' => $subContexts['fourth'] ?? '',
            ':choice_a' => $choices['A'] ?? '',
            ':choice_b' => $choices['B'] ?? '',
            ':choice_c' => $choices['C'] ?? '',
            ':choice_d' => $choices['D'] ?? '',
            ':correct_answer' => $correctAnswer
        ]) ? ['success' => true] : ['success' => false, 'message' => 'Failed to insert pretest.'];
    }

    public function acceptUpdatePretest($data)
    {
        try {
            $sql = "UPDATE pretest SET 
                question=?, pretest_type=?, context=?, 
                first_sub_context=?, second_sub_context=?, third_sub_context=?, fourth_sub_context=?, 
                choice_a=?, choice_b=?, choice_c=?, choice_d=?, correct_answer=? 
                WHERE pretest_id=?";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                $data['question'],
                $data['pretest_type'],
                $data['context'],
                $data['first_sub'],
                $data['second_sub'],
                $data['third_sub'],
                $data['fourth_sub'],
                $data['choice_a'],
                $data['choice_b'],
                $data['choice_c'],
                $data['choice_d'],
                $data['correct_answer'],
                $data['pretest_id']
            ]);

            return ["status" => "success"];
        } catch (Exception $e) {
            return ["status" => "error", "message" => $e->getMessage()];
        }
    }

    public function acceptPretestSubmission(array $pretestAnswers)
    {
        $this->pdo->beginTransaction();
        try {
            foreach ($pretestAnswers as $answer) {
                $correctAnswer = $this->getCorrectAnswer($answer['pretestID']);
                $score = ($answer['pretest_answer'] === $correctAnswer) ? 1 : 0;

                $sql = 'INSERT INTO pretest_submitted_answers (learnerID, pretestID, pretestAnswer, pretestScore)
                    VALUES (:learner_id, :pretest_id, :pretest_answer, :score)';
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([
                    ':learner_id' => $answer['learnerID'],
                    ':pretest_id' => $answer['pretestID'],
                    ':pretest_answer' => $answer['pretest_answer'],
                    ':score' => (int) $score
                ]);
            }
            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log("Error submitting pretest answers: " . $e->getMessage());
            throw $e;
        }
    }
}
