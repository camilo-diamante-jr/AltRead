<?php

/** 
 * 🔹 Student Portal 
 */


return  [

    ['url' => '/dashboard', 'method' => 'studentDashboard'],
    ['url' => '/assessments', 'method' => 'viewAssessments'],
    ['url' => '/materials', 'method' => 'viewLearningMaterials'],
    ['url' => '/submissions', 'method' => 'viewYourSubmissions'],


];

// $this->router->addRoute('/ajax/submitExamination', ['SubmissionController, submitExaminations']);
