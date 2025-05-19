<?php 
class ChoicesModel{
    
        private PDO $pdo;
    
        public function __construct(PDO $pdo)
        {
            $this->pdo = $pdo;
        }


        public function fetchChoicesByQuestionId(int $lessonId): array{
        $sql = "SELECT * FROM choices WHERE is_active = 1 ORDER BY  question_id = :question_id ";
            
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':lesson_id', $lessonId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
}