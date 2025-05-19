async function loadModule(modulePath) {
  const timestamp = new Date().getTime();
  const moduleUrl = `${modulePath}?v=${timestamp}`;
  return import(moduleUrl);
}

$(document).ready(async () => {
  try {
    // Load Pretest modules
    const createPretestModule = await loadModule(
      "./Admin/assessments/pretest/create.pretest.js"
    );
    const updatePretestModule = await loadModule(
      "./Admin/assessments/pretest/update.pretest.js"
    );
    const takePretestModule = await loadModule("./Student/take.pretest.js");

    const createQuizModule = await loadModule(
      "./Admin/assessments/quizzes/createQuiz.js"
    );
    const updateQuizModule = await loadModule(
      "./Admin/assessments/quizzes/updateQuiz.js"
    );

    // Load Uploading Answer Key
    const answerkeysModule = await loadModule(
      "./Admin/management/answer_keys/uploadAnswerKeys.js"
    );

    // Load Student modules
    const addStudentModule = await loadModule(
      "./Admin/registries/students/add.student.js"
    );
    const activeStudentModule = await loadModule(
      "./Admin/registries/students/active.student.js"
    );
    const updateStudentModule = await loadModule(
      "./Admin/registries/students/update.student.js"
    );
    const archiveStudentModule = await loadModule(
      "./Admin/registries/students/archive.student.js"
    );
    const restoreStudentModule = await loadModule(
      "./Admin/registries/students/restore.student.js"
    );

    // Load Material modules
    const addMaterialModule = await loadModule(
      "./Admin/registries/materials/add.material.js"
    );
    const activeMaterialsModule = await loadModule(
      "./Admin/registries/materials/active.material.js"
    );
    const updateMaterialModule = await loadModule(
      "./Admin/registries/materials/update.material.js"
    );
    const archiveMaterialModule = await loadModule(
      "./Admin/registries/materials/archive.material.js"
    );
    const restoreMaterialModule = await loadModule(
      "./Admin/registries/materials/restore.material.js"
    );

    const tabManagerModule = await loadModule("./layouts/tabManager.js");
    // Load Module Management modules
    const dataTableModule = await loadModule(
      "./Admin/registries/contents/modules/dataTableHandler.js"
    );
    const insertModule = await loadModule(
      "./Admin/registries/contents/modules/insertModule.js"
    );

    const updateModule = await loadModule(
      "./Admin/registries/contents/modules/updateModule.js"
    );

    const removeModule = await loadModule(
      "./Admin/registries/contents/modules/removeModule.js"
    );

    /** 
      => Lessons 
    */
    const lessonTableModule = await loadModule(
      "./Admin/registries/contents/lessons/lessonTable.js"
    );

    const createLessonModule = await loadModule(
      "./Admin/registries/contents/lessons/createLesson.js"
    );

    const updateLessonModule = await loadModule(
      "./Admin/registries/contents/lessons/updateLesson.js"
    );

    const removeLessonModule = await loadModule(
      "./Admin/registries/contents/lessons/removeLesson.js"
    );

    // Questions
    const questionActionsModule = await loadModule(
      "./Admin/registries/contents/questions/questionActions.js"
    );

    const createQuestionModule = await loadModule(
      "./Admin/registries/contents/questions/insertQuestion.js"
    );

    const initializeLessons = await loadModule("./Student/lessons.js");
    const initializeExaminations = await loadModule(
      "./Student/examinations.js"
    );

    const teachersTableModule = await loadModule(
      "./Admin/registries/teachers/table-teacher.js"
    );

    const insertTeacherModule = await loadModule(
      "./Admin/registries/teachers/insert-teacher.js"
    );

    const removeTeacherModule = await loadModule(
      "./Admin/registries/teachers/archive-teacher.js"
    );

    const renderTeacherModule = await loadModule(
      "./Admin/registries/teachers/fetch-teacher.js"
    );

    const exportTeachersModule = await loadModule(
      "./Admin/registries/teachers/export-teacher.js"
    );

    const updateTeacherModule = await loadModule(
      "./Admin/registries/teachers/update-teacher.js"
    );

    // Initialize Pretest functionalities
    createPretestModule.createNewPretest();
    updatePretestModule.updatePretest();
    takePretestModule.takePretest();

    // Initialize Quiz
    createQuizModule.initializeCreateQuizzes();
    updateQuizModule.initializeUpdateQuizzes();

    answerkeysModule.initializeUploadingAnswerKeys();

    // Initialize Student functionalities
    addStudentModule.addStudent();
    activeStudentModule.activeStudent();
    updateStudentModule.updateStudent();
    archiveStudentModule.archiveStudent();
    restoreStudentModule.restoreStudent();

    // Initialize Material functionalities
    addMaterialModule.addNewMaterial();
    activeMaterialsModule.initializeActiveMaterials();
    updateMaterialModule.updateMaterial();
    archiveMaterialModule.archiveMaterial();
    restoreMaterialModule.restoreMaterial();

    // Initialize Module Management functionalities
    tabManagerModule.manageTabs();

    dataTableModule.initDataTable();
    insertModule.insertModuleSubmitForm();
    updateModule.updateModuleSubmitForm();
    removeModule.removeCurrentModule();

    lessonTableModule.lessonTable();
    createLessonModule.createLesson();
    updateLessonModule.updateLessonSubmitForm();
    removeLessonModule.removeCurrentLesson();

    initializeLessons.initializeLessons();
    initializeExaminations.initializeExaminations();

    questionActionsModule.questionActions();
    createQuestionModule.createQuestion();

    // Teacher registries
    renderTeacherModule.initializeRenderingTeacher();
    insertTeacherModule.insertTeacher();
    const table = teachersTableModule.teachersTable();
    exportTeachersModule.exportTeachers(table);
    updateTeacherModule.updateTeacher();
    removeTeacherModule.initializeArchiveTeacher();
  } catch (error) {
    console.error("Error loading modules:", error);
    Swal.fire({
      icon: "error",
      title: "Error",
      text: "Failed to load modules. Please try again.",
    });
  }
});
