 <?php

    require_once '../core/Controller.php';

    class TeachersMainController extends Controller
    {
        private $answerKeyModel;
        private $teachersModel;
        private $pretestModel;
        private $quizController;
        private $answerKeyController;

        // Registries
        private $moduleModel;
        private $lessonsController;
        private $partsController;
        private $questionController;
        private $pisModel;

        /**
         * Constructor to initialize the TeachersMainController
         * 
         * @param PDO $pdo The PDO connection instance
         */
        public function __construct(PDO $pdo)
        {
            parent::__construct($pdo);
            $this->answerKeyModel = $this->loadModel('AnswerKeyModel');
            $this->teachersModel = $this->loadModel('TeachersModel');
            $this->pretestModel = $this->loadModel('PretestModel');
            $this->quizController = new QuizController($pdo);
            $this->answerKeyController = new AnswerKeyController($pdo);

            $this->moduleModel = $this->loadModel("ModuleModel");
            $this->lessonsController = new LessonsController($pdo);
            $this->partsController = new PartsController($pdo);
            $this->questionController = new QuestionController($pdo);
            $this->pisModel = $this->loadModel('PISModel');
        }


        public function insertTeacher()
        {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                try {
                    $teacherData = [
                        'firstName'      => $_POST['first_name'] ?? '',
                        'middleName'     => $_POST['middle_name'] ?? null,
                        'lastName'       => $_POST['last_name'] ?? '',
                        'email'          => $_POST['email'] ?? '',
                        'contactNumber'  => $_POST['contact_number'] ?? null,
                        'position'       => $_POST['position'] ?? null,
                        'address'        => $_POST['address'] ?? '',
                        'dateOfBirth'    => $_POST['date_of_birth'] ?? '',
                        'isActive'       => isset($_POST['is_active']) ? 1 : 0
                    ];

                    $inserted = $this->teachersModel->acceptInsertedTeachers($teacherData);

                    if ($inserted['success']) {
                        $teacherData['id'] = $inserted['last_id']; // Append ID to send back

                        echo json_encode([
                            'success' => true,
                            'message' => "Teacher added successfully",
                            'teacherData' => $teacherData
                        ]);
                    } else {
                        echo json_encode([
                            'success' => false,
                            'message' => $inserted['message']
                        ]);
                    }
                } catch (Exception $e) {
                    echo json_encode([
                        'success' => false,
                        'message' => "An error occurred: " . $e->getMessage()
                    ]);
                }
            }
        }

        public function fetchTeacherByID()
        {
            if (isset($_POST['teacher_id']) && is_numeric($_POST['teacher_id'])) {
                $teacher_id = $_POST['teacher_id'];
                header("Content-type: application/json");
                $teacher = $this->teachersModel->renderTeachersByID($teacher_id);

                // Return the teacher data as JSON
                if ($teacher) {
                    echo json_encode([
                        'status' => 200,
                        'teacher' => $teacher
                    ]);
                } else {
                    echo json_encode([
                        'status' => 404,
                        'message' => "Teacher not found",

                    ]);
                }
            } else {
                echo json_encode(['error' => 'Invalid teacher ID']);
            }
        }

        public function updateTeacher()
        {
            header('Content-Type: application/json');

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Ensure required fields are provided
                if (!empty($_POST['teacher_id']) && !empty($_POST['edit_first_name']) && !empty($_POST['edit_last_name']) && !empty($_POST['edit_email'])) {

                    // Prepare the data to update (use snake_case to match DB fields)
                    $updateData = [
                        'teacher_id'     => $_POST['teacher_id'],
                        'first_name'     => $_POST['edit_first_name'],
                        'middle_name'    => $_POST['edit_middle_name'] ?? null,
                        'last_name'      => $_POST['edit_last_name'],
                        'email'          => $_POST['edit_email'],
                        'contact_number' => $_POST['edit_contact_number'] ?? null,
                        'position'       => $_POST['edit_position'] ?? null,
                        'address'        => $_POST['edit_address'] ?? null,
                        'date_of_birth'  => $_POST['edit_date_of_birth'] ?? null,
                    ];


                    $teacherId = $updateData['teacher_id'];

                    // Fetch current data from the database
                    $currentData = $this->teachersModel->getTeacherById($teacherId);

                    if (!$currentData) {
                        echo json_encode([
                            'success' => false,
                            'message' => 'Teacher not found.'
                        ]);
                        return;
                    }

                    // Detect changes
                    $changesDetected = false;
                    foreach ($updateData as $key => $value) {
                        if ($key !== 'teacher_id' && $value !== null && $currentData[$key] != $value) {
                            $changesDetected = true;
                            break;
                        }
                    }

                    if (!$changesDetected) {
                        echo json_encode([
                            'success' => false,
                            'message' => 'No changes detected. Update not performed.'
                        ]);
                        return;
                    }

                    // Proceed with update
                    $updated = $this->teachersModel->acceptUpdatedTeacher($updateData);

                    if ($updated['success']) {
                        echo json_encode([
                            'success' => true,
                            'message' => "Teacher data was successfully updated!",
                            'teacherUpdatedData' => $updateData
                        ]);
                    } else {
                        echo json_encode([
                            'success' => false,
                            'message' => $updated['message']
                        ]);
                    }
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Missing required fields (teacher ID, first name, last name, email).'
                    ]);
                }
            }
        }

        public function removeTeacher()
        {
            // Check if the request is POST
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Get the teacher ID from the POST data
                $teacherId = $_POST['teacher_id'] ?? null;

                if ($teacherId) {
                    // Call the model method to archive (set is_active = 0)
                    $result = $this->teachersModel->archiveTeacher($teacherId);

                    // Send success or failure response
                    if ($result) {
                        echo json_encode([
                            'success' => true,
                            'message' => 'The teacher has been archived successfully.',
                        ]);
                    } else {
                        echo json_encode([
                            'success' => false,
                            'message' => 'Failed to archive the teacher.',
                        ]);
                    }
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'No teacher ID provided.',
                    ]);
                }
            } else {
                // If the request isn't POST, return an error
                echo json_encode([
                    'success' => false,
                    'message' => 'Invalid request method.',
                ]);
            }
        }



        /** 
         * THIS IS FOR BROWSING PAGES
         */

        public function viewTeachersDashboard()
        {
            $totalModules = $this->pdo->query("SELECT COUNT(*) as count FROM modules")->fetch()['count'];
            $totalLessons = $this->pdo->query("SELECT COUNT(*) as count FROM lessons")->fetch()['count'];
            $totalStudents = $this->pdo->query("SELECT COUNT(*) as count FROM learners")->fetch()['count'];
            $totalSubmissions = $this->pdo->query("SELECT COUNT(*) as count FROM submissions")->fetch()['count'];
            $data =
                [
                    'page_title' => "Teachers | Dashboard",
                    'brandText' => "Teachers Portal",
                    'totalModules' => $totalModules,
                    'totalLessons' => $totalLessons,
                    'totalStudents' => $totalStudents,
                    'totalSubmissions' => $totalSubmissions,
                ];

            $this->renderView('/pages/Teacher/teacher.dashboard', $data);
        }



        public function viewAllPretest()
        {

            $pretest = $this->pretestModel->getAllPretest();

            $data = [
                'page_title' => 'Teacher | Pretest',
                'brandText' => 'Teacher Portal',
                'breadcrumb_title' => 'Manage Pretest',
                'breadcrumb_go_back_home_text' => 'Home',
                'breadcrumb_current_link_text' => 'Pretest',
                'pretests' => $pretest,
                'footer' => "AltRead"

            ];

            $this->renderView('pages/Teacher/assessments/pretest/pretest', $data);
        }

        public function viewQuizzes()
        {

            $quizzes = $this->quizController->renderAllQuizzes();


            $data =
                [
                    'page_title' => "Teachers | Dashboard",
                    'brandText' => "Teachers Portal",
                    'breadcrumb_title' => "Quizzes",
                    'breadcrumb_go_back_home_text' => 'Home',
                    'breadcrumb_current_link_text' => 'Quizzes',
                    'quizzes' => $quizzes,
                ];
            $this->renderView('/pages/Teacher/assessments/quizzes/quiz', $data);
        }



        public function renderAnswerkeys()
        {
            $answerKeys = $this->answerKeyController->showAllAnswerkeys();

            $data =
                [
                    'page_title' => "Teachers | Dashboard",
                    'brandText' => "Teachers Portal",
                    'breadcrumb_title' => "Answer Keys",
                    'answerKeys' => $answerKeys,
                ];
            $this->renderView('/pages/Teacher/data_management/answerkeys/answerkeys', $data);
        }


        public function renderArchives()
        {


            $data =
                [
                    'page_title' => "Teachers | Dashboard",
                    'brandText' => "Teachers Portal",
                    'breadcrumb_title' => "Answer Keys",

                ];
            $this->renderView('/pages/Teacher/data_management/archived/archived', $data);
        }



        public function viewAllStudentSubmissions()
        {
            $pretest = $this->pretestModel->getAllPretest();


            $data = [
                'page_title' => 'Teacher | Pretest',
                'brandText' => 'Teacher Portal',
                'breadcrumb_title' => 'Manage Pretest',
                'breadcrumb_go_back_home_text' => 'Home',
                'breadcrumb_current_link_text' => 'Pretest',
                'pretests' => $pretest,
                'footer' => "AltRead"

            ];

            $this->renderView('pages/Teacher/reports/submissions/main-submissions', $data);
        }



        public function viewContentRegistry()
        {
            $modules = $this->moduleModel->showAllModules();
            $lessons = $this->lessonsController->showAllLessons();
            $parts = $this->partsController->showAllParts();
            $questions = $this->questionController->showAllQuestions();


            $data = [
                'page_title' => 'Teacher | Contents',
                'brandText' => 'Teacher Portal',
                'breadcrumb_title' => 'Contents',
                'breadcrumb_go_back_home_text' => 'Home',
                'breadcrumb_current_link_text' => 'Contents',
                'modules' => $modules,
                'lessons' => $lessons,
                'parts' => $parts,
                'questions' => $questions,
            ];

            $this->renderView('./pages/Teacher/registries/contents/main-content-registry', $data);
        }


        public function viewStudentRegistry()
        {
            $learners = $this->pisModel->showAllLearners();

            $data = [
                'page_title' => 'Manage Students',
                'breadcrumb_title' => 'Manage Students',
                'brandText' => 'Teacher Portal',
                'breadcrumb_go_back_home_text' => 'Home',
                'breadcrumb_current_link_text' => 'Students',
                'learners' => $learners
            ];

            $this->renderView('./pages/Teacher/registries/student/student-registry', $data);
        }
    }
