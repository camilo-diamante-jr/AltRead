<?php

define("TMC", "TeachersMainController");

/**  
 * 🔹 Teachers Portal 
 */

//  Dashboard
$this->router->addRoute('/teacher/dashboard', [TMC, 'teachersDashboard']);

// Assessment
$this->router->addRoute('/teacher/assessment/pretest', [TMC, 'pretest']);

// Management
$this->router->addRoute('/teacher/management/answerkeys', [TMC, 'answerkeys']);

// Registry
$this->router->addRoute('/teacher/registry/contents', [TMC, 'content']);
$this->router->addRoute('/teacher/registry/materials', [TMC, 'materials']);
$this->router->addRoute('/teacher/registry/student', [TMC, 'students']);

// Reports
$this->router->addRoute('/teacher/report/submissions', [TMC, 'submissions']);
$this->router->addRoute('/teacher/report/submissions', [TMC, 'progress']);
