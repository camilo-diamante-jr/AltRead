<?php

$this->router->addRoute('/get/students', ['PISController', 'getStudents']);
$this->router->addRoute('/show/submissions-by-learner-id', ['SubmissionController', 'showSubmissionsByLearnerId']);
