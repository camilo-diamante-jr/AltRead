<?php

require_once '../core/Controller.php';

class StudentMainController extends Controller
{
    private  $validationController;
    private  $pretestController;
    private  $quizController;
    private  $materialsController;
    private  $lessonsController;
    private  $partsController;
    private  $questionController;

    // Initializations for models
    private  $pisModel;
    private  $moduleModel;
    // private  $submissionsModel;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);

        // load all controllers here
        $this->validationController = new ValidationController($pdo);
        $this->pretestController = new PretestController($pdo);
        $this->materialsController = new MaterialsController($pdo);
        $this->lessonsController = new LessonsController($pdo);
        $this->pretestController = new PretestController($pdo);
        $this->quizController = new QuizController($pdo);
        $this->partsController = new PartsController($pdo);
        $this->questionController = new QuestionController($pdo);

        // Load model here
        $this->pisModel = $this->loadModel('PISModel');
        $this->moduleModel = $this->loadModel('ModuleModel');
        // $this->submissionsModel = $this->loadModel('SubmissionsModel');
    }

    public function studentDashboard(): void
    {
        if (!$this->validationController->validateAccess()) {
            return;
        }

        $data = [
            'page_title' => 'Dashboard',
            'brand_text' => 'Student Portal',
        ];

        $this->renderView('./pages/Student/view.dashboard', $data);
    }

    public function viewAssessments(): void
    {
        if (!$this->validationController->validateAccess()) {
            return;
        }


        try {
            // Fetching learner id, pretest, modules, parts, and lessons
            $learnerID = $this->pisModel->fetchLearnersIdByUserId();

            $pretest = $this->pretestController->showAllPretest();
            $quizzes = $this->quizController->renderAllQuizzes();

            $modules = $this->moduleModel->showAllModules();
            $lessons = $this->lessonsController->showAllLessons();
            $parts = $this->partsController->showAllParts();
            $questions = $this->questionController->showAllQuestions();


            $checkPretestSubmission = $this->pretestController->pretestSubmission();
            $pretesTotalScore = $this->pretestController->getAllPretestScores();


            // Render assessments page
            $data = [
                'page_title' => 'Assessments',
                'brand_text' => 'Student Portal',
                'learnerID' => $learnerID,
                'pre_assessments' => $pretest,
                'quizzes' => $quizzes,
                'modules' => $modules,
                'lessons' => $lessons,
                'questions' => $questions,
                'submitted_pretest' => $checkPretestSubmission,
                'perfectScore' => 10,
                'passingScore' => 7,
                'pretest_total_score' => $pretesTotalScore,

                // For parts
                'parts' => $parts,
            ];

            $this->renderView('./pages/Student/view.assessments', $data);
        } catch (Exception $e) {
            print("Error loading assessments: " . $e->getMessage());
            $this->renderError();
        }
    }





    public function viewLearningMaterials(): void
    {
        if (!$this->validationController->validateAccess()) {
            return;
        }


        $materials = $this->materialsController->showAllMaterials();

        $data = [
            'page_title' => 'Learning Materials',
            'brand_text' => 'Student Portal',
            'materials' => $materials
        ];

        $this->renderView('/pages/Student/view.materials', $data);
    }

    public function viewYourSubmissions(): void
    {
        if (!$this->validationController->validateAccess()) {
            return;
        }
        $learnerID = $this->pisModel->fetchLearnersIdByUserId();
        $pis = $this->pisModel->showAllLearnersById($learnerID);
        $checkPretestSubmission = $this->pretestController->pretestSubmission();


        $data = [
            'page_title' => 'Submissions',
            'brand_text' => 'Student Portal',
            'personal_info' => $pis,
            'pretest_submissions' => $checkPretestSubmission,
        ];

        $this->renderView('/pages/Student/view.submissions', $data);
    }
}
