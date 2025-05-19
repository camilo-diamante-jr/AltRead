<?php

require_once '../core/Controller.php';

class PartsController extends Controller
{
    private $partsModel;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this->partsModel = $this->loadModel('PartsModel');
    }

    // Fetch all exams (not used in this code, but here for completeness)
    public function showAllParts(): array
    {
        return $this->partsModel->fetchAllParts();
    }
}
