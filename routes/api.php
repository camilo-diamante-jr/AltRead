<?php

$this->router->addRoute('/admin/search-students', ['PISController', 'getStudents']);
$this->router->addRoute('/show/submissions-by-learner-id', ['SubmissionController', 'showSubmissionsByLearnerId']);
$this->router->addRoute('/api/student-progress', ['ProgessController', 'getStudentProgress']);
$this->router->addRoute('/api/showLearnerById', ['AdminMainController', 'showLearnerById']);
