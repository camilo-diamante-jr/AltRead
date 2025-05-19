<?php

return [

    // ───────────────────── Dashboard ───────────────────── //
    ['url' => '/dashboard',               'method' => 'showAdminDashboard'],

    // ──────────────────── Assessments ──────────────────── //
    ['url' => '/assessment/pretest',      'method' => 'showPretest'],
    ['url' => '/assessment/quiz',         'method' => 'showQuizzes'],

    // ──────────────── Data Management ───────────────── //
    ['url' => '/management/users',        'method' => 'showUsers'],
    ['url' => '/management/answerkeys',   'method' => 'showAnswerKeys'],

    // ───────────────────── Registries ───────────────────── //
    ['url' => '/registry/contents',       'method' => 'showModulesContent'],
    ['url' => '/registry/materials',      'method' => 'showMaterials'],
    ['url' => '/registry/students',       'method' => 'showStudents'],
    ['url' => '/registry/teachers',       'method' => 'showTeachers'],

    // ────────────────────── Reports ────────────────────── //
    ['url' => '/report/submissions',        'method' => 'showSubmissions'],
    ['url' => '/report/progress',        'method' => 'showProgress'],
];
