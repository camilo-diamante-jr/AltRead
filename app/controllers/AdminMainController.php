<?php

require_once '../core/Controller.php';

class AdminMainController extends Controller
{
    private $controllers = [];
    private $models = [];

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);

        // Controllers
        $controllerClasses = [
            'materialsController' => MaterialsController::class,
            'pretestController' => PretestController::class,
            'quizController' => QuizController::class,
            'lessonsController' => LessonsController::class,
            'partsController' => PartsController::class,
            'questionController' => QuestionController::class,
            'submissionController' => SubmissionController::class,
        ];

        foreach ($controllerClasses as $key => $class) {
            $this->controllers[$key] = new $class($pdo);
        }

        // Models
        $modelNames = [
            'pisModel' => 'PISModel',
            'pretestModel' => 'PretestModel',
            'answerKeyModel' => 'AnswerKeyModel',
            'moduleModel' => 'ModuleModel',
            'userModel' => "UserModel",
            'teachersModel' => 'TeachersModel',
        ];
        foreach ($modelNames as $key => $model) {
            $this->models[$key] = $this->loadModel($model);
        }
    }

    public function showAdminDashboard(): void
    {
        $data = [
            'totalModules' => $this->countFromTable('modules'),
            'totalLessons' => $this->countFromTable('lessons'),
            'totalStudents' => $this->countFromTable('learners'),
            'totalSubmissions' => $this->countFromTable('submissions'),
            'footer' => "AltRead"
        ];
        $this->renderAdminView('Dashboard', 'admin.dashboard', $data);
    }

    public function showPretest(): void
    {
        $this->renderAdminView('Pretest', 'assessments/pretest/pretest', [
            'pretests' => $this->models['pretestModel']->getAllPretest(),
            'footer' => 'Readify'
        ]);
    }

    public function showQuizzes(): void
    {
        $this->renderAdminView('Quizzes', 'assessments/quizzes/quiz', [
            'quizzes' => $this->controllers['quizController']->renderAllQuizzes()
        ]);
    }

    public function showAnswerKeys(): void
    {
        $this->renderAdminView('Answer Keys', 'data_management/answer_keys/answer_keys', [
            'answerKeys' => $this->models['answerKeyModel']->fetchAllAnswerKeys()
        ]);
    }

    public function showUsers(): void
    {
        try {
            $users = $this->models['userModel']->getAllUsers();
            $this->renderAdminView('Manage Users', 'data_management/users/users', [
                'users' => $users
            ], 'Users');
        } catch (Exception $e) {
            $this->renderError($e->getMessage());
        }
    }


    public function showStudents(): void
    {
        $this->renderAdminView('Student Registry', 'registries/student/student-registry', [
            'learners' => $this->models['pisModel']->showAllLearners()
        ]);
    }

    public function showMaterials(): void
    {
        $this->renderAdminView('Materials', 'registries/materials/material-registry', [
            'materials' => $this->controllers['materialsController']->showAllMaterials()
        ]);
    }


    public function showTeachers(): void
    {
        $this->renderAdminView('Teachers Registry', 'registries/teachers/teacher-registry', [
            'teachers' => $this->models['teachersModel']->showAllTeachers()
        ]);
    }


    public function showModulesContent(): void
    {
        $this->renderAdminView('Content Registry', 'registries/contents/main-content-registry', [
            'modules' => $this->models['moduleModel']->showAllModules(),
            'lessons' => $this->controllers['lessonsController']->showAllLessons(),
            'parts' => $this->controllers['partsController']->showAllParts(),
            'questions' => $this->controllers['questionController']->showAllQuestions()
        ], 'Modules');
    }

    public function showSubmissions(): void
    {
        $this->renderAdminView('Submission Reports', 'reports/submissions/submissions', [
            'pretestSubmissions' => $this->controllers['pretestController']->viewAllPretestSubmission(),
            'learners' => $this->models['pisModel']->showAllLearners(),
            'modules' => $this->models['moduleModel']->showAllModules(),
            'submissions' => $this->controllers['submissionController']->renderAllSubmissions()
        ], 'Submissions');
    }

    public function showProgress(): void
    {
        $this->renderAdminView('Students Progress', 'reports/progress/progress', [
            'pretestSubmissions' => $this->controllers['pretestController']->viewAllPretestSubmission()
        ], 'Progress');
    }

    /** Helper: Render standardized admin view */
    private function renderAdminView(string $title, string $viewPath, array $data = [], ?string $breadcrumb = null): void
    {
        $data = array_merge([
            'page_title' => "Admin | {$title}",
            'breadcrumb_title' => $title,
            'breadcrumb_go_back_home_text' => 'Home',
            'breadcrumb_current_link_text' => $breadcrumb ?? $title
        ], $data);

        $this->renderView("portals/Admin/{$viewPath}", $data);
    }


    /** Helper: Count rows in table */
    private function countFromTable(string $table): int
    {
        return (int)$this->pdo->query("SELECT COUNT(*) as count FROM {$table}")->fetch()['count'];
    }
}
