<?php

$this->router->addRoute('/admin/search-students', ['PISController', 'getStudents']);
$this->router->addRoute('/show/submissions-by-learner-id', ['SubmissionController', 'showSubmissionsByLearnerId']);
$this->router->addRoute('/admin/student-progress', ['ProgessController', 'getStudentProgress']);
