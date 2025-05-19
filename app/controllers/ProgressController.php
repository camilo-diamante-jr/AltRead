<?php
class ProgressController
{
    public function index()
    {
        global $pdo;
        $stmt = $pdo->prepare('SELECT lessons.lesson_name, progress.score, progress.completed FROM progress JOIN lessons ON progress.lesson_id = lessons.lesson_id WHERE progress.user_id = ?');
        $stmt->execute([$_SESSION['user_id']]);
        $progress = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require 'app/views/progress.php';
    }
}
