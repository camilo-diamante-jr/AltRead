<?php




// return [








// ];
$this->router->addRoute('/', ['LandingPageController', 'homepage']);
$this->router->addRoute('/navbar', ['LandingPageController', 'navbar']);
$this->router->addRoute('/hero', ['LandingPageController', 'hero']);
$this->router->addRoute('/features', ['LandingPageController', 'features']);
$this->router->addRoute('/how-it-works', ['LandingPageController', 'howItWorks']);
$this->router->addRoute('/about', ['LandingPageController', 'about']);
$this->router->addRoute('/contact', ['LandingPageController', 'contact']);




/** 
 * 🔹 Learners Registry 
 */
$this->router->addRoute('/ajax/showLearnerById', ['AdminMainController', 'showLearnerById']);
$this->router->addRoute('/viewStudent', ['PISController', 'viewStudent']);
$this->router->addRoute('/insertstudent', ['PISController', 'insertStudent']);
$this->router->addRoute('/updateStudent', ['PISController', 'updateStudent']);
$this->router->addRoute('/removeStudent', ['PISController', 'removeStudent']);

/** 
 * 🔹 Teachers Registry
 */
$this->router->addRoute('/admin/teachers', ['AdminMainController', 'teacherRegistry']);
$this->router->addRoute('/admin/teachers/update', ['TeachersController', 'updateTeachers']);
$this->router->addRoute('/admin/teachers/insert', ['TeachersController', 'insertTeachers']);
$this->router->addRoute('/admin/teachers/import', ['TeachersController', 'importTeachers']);



/** 
 * 🔹 Materials Registry 
 */
$this->router->addRoute('/getMaterialById', ["MaterialsController", 'getMaterialsById']);
$this->router->addRoute('/insertMaterial', ["MaterialsController", 'insertNewMaterial']);
$this->router->addRoute('/updateMaterial', ["MaterialsController", 'updateMaterial']);
$this->router->addRoute('/archiveMaterial', ["MaterialsController", 'archivedMaterialById']);
$this->router->addRoute('/restoreMaterial', ["MaterialsController", 'restoreMaterialById']);

/** 
 * 🔹 AJAX User Management 
 */
$this->router->addRoute('/ajax/addUser', ['UserController', 'addUser']);
$this->router->addRoute('/ajax/updateUser', ['UserController', 'editUser']);
$this->router->addRoute('/ajax/archiveUser', ['UserController', 'deleteUser']);
$this->router->addRoute('/ajax/new-password', ['UserController', 'changeCurrentPassword']);

/** 
 * 🔹 Pretest Route'PretestController'
 */
$this->router->addRoute('/createPretest', ['PretestController', 'insertPretestFunction']);
$this->router->addRoute('/updatePretest', ['PretestController', 'updatePretestFunction']);
$this->router->addRoute('/removePretest', ['PretestController', 'archivePretestFunction']);
$this->router->addRoute('/restorePretest', ['PretestController', 'restorePretestFunction']);
$this->router->addRoute('/submitPretest', ['PretestController', 'submitPretestAnswersFunction']);

/** 
 * 🔹 Quizzes 
 */
$this->router->addRoute('/admin/quizzes', ['AdminMainController', 'manageQuizzes']);
$this->router->addRoute('/teacher/assessment/quizzes', ['TeachersMainController', 'viewQuizzes']);
$this->router->addRoute('/createQuizzes', ['QuizController', 'createQuizzesFunction']);
$this->router->addRoute('/renderQuizById', ['QuizController', 'renderQuizzesById']);
$this->router->addRoute('/updateQuizzes', ['QuizController', 'updateQuizzesFunction']);
$this->router->addRoute('/removeQuizzes', ['QuizController', 'removeQuizzesFunction']);


/** 
 * 🔹 Answer Keys 
 */
$this->router->addRoute('/answerkeysFilePreview', ['AnswerKeyController', 'handleAnswerKeysFilePreview']);
$this->router->addRoute('/uploadAnswerKeys', ['AnswerKeyController', 'handleAnswerKeysUpload']);
$this->router->addRoute('/updateAnswerKeys', ['AnswerKeyController', 'handleFileChanges']);
$this->router->addRoute('/removeAnswerKeys', ['AnswerKeyController', 'handleArchiveAnswerKeys']);
/** 
 * 🔹 Module Registry 
 */
$this->router->addRoute("/ajax/getModules", ['ModuleController', 'readAllModules']);
$this->router->addRoute("/ajax/insertModule", ['ModuleController', 'createNewModule']);
$this->router->addRoute("/ajax/updateModule", ['ModuleController', 'updateCurrentModule']);
$this->router->addRoute("/ajax/removeModule", ['ModuleController', 'removeCurrentModule']);



/** 
 * 🔹 Lesson Registry 
 */

$this->router->addRoute("/ajax/insertLesson", ['LessonsController', 'createNewLesson']);
$this->router->addRoute("/ajax/updateLesson", ['LessonsController', 'updateCurrentLesson']);
$this->router->addRoute("/ajax/removeLesson", ['LessonsController', 'removeCurrentLesson']);

/** 
 * 🔹 Question Registry 
 */

$this->router->addRoute('/questions/getById', ['QuestionController', 'getQuestionById']);
$this->router->addRoute('/admin/createQuestion', ['QuestionController', 'createQuestionFunction']);

/** 
 * 🔹 Teacher Registry 
 */
$this->router->addRoute('/admin/teachers/insert', ['TeachersMainController', 'insertTeacher']);
$this->router->addRoute('/admin/teachers/fetchTeacherByID', ['TeachersMainController', 'fetchTeacherByID']);
$this->router->addRoute('/admin/teachers/update', ['TeachersMainController', 'updateTeacher']);
$this->router->addRoute('/admin/teachers/remove',  ['TeachersMainController', 'removeTeacher']);
/** 
 * 🔹 Personal Information Sheet 
 */
$this->router->addRoute('/ajax/insertNewLearner', ["PISController", 'CreateLearner']);
$this->router->addRoute('/ajax/updatePersonalStatus', ['PISController', 'updatePersonalInfoStatus']);
$this->router->addRoute('/ajax/renderLearners', ["PISController", 'fetchAllStudents']);
/** 
 * 🔹 Examinations 
 */
$this->router->addRoute('/ajax/showLessonsPerModule', ['LessonsController', 'lessonsPerModuleFunction']);
$this->router->addRoute('/ajax/showQuestionsPerLesson', ['QuestionController', 'getQuestionsByLessonId']);
$this->router->addRoute('/admin/answer-keys', ['AdminMainController', 'viewAnswerKeys']);


/** 
 * 🔹 Reports 
 */
$this->router->addRoute('/admin/submissions', ['AdminMainController', 'viewSubmissions']);
$this->router->addRoute('/admin/progress', ['AdminMainController', 'viewProgress']);
$this->router->addRoute('/admin/viewStudentSubmissions', ['SubmissionController', 'viewAllSubmissions']);





/** 
 * 🔹 Student Portal 
 */
$this->router->addRoute('/dashboard', ['StudentMainController', 'studentDashboard']);
$this->router->addRoute('/assessments', ['StudentMainController', 'viewAssessments']);
$this->router->addRoute('/materials', ['StudentMainController', 'viewLearningMaterials']);
$this->router->addRoute('/submissions', ['StudentMainController', 'viewYourSubmissions']);
$this->router->addRoute('/ajax/submitExamination', ['SubmissionController, submitExaminations']);


/** 
 * 🔹 Settings 
 */
$this->router->addRoute('/settings', ['SettingsController', 'fetchAccountSettings']);
$this->router->addRoute('/update-general-account-settings', ['SettingsController', 'updateGeneralAccountSettings']);
$this->router->addRoute('/update-personal-information', ['SettingsController', 'updatePersonalInformation']);

/** 
 * 🔹 Archives & Restoration 
 */
$this->router->addRoute('/admin/archives', ['ArchiveController', "archiveFunction"]);
$this->router->addRoute('/restore', ['ArchiveController', "restoreFunction"]);



$this->router->addRoute('/ajax/renderStudentSubmissions', ['SubmissionController', 'renderStudentSubmissions']);
