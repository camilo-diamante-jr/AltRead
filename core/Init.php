<?php

$coreClasses = ['Route', 'App', 'Controller', 'View'];

foreach ($coreClasses as $class) {
    $filePath = __DIR__ . "/{$class}.php";
    if (!file_exists($filePath)) {
        die("Core file missing: {$class}.php");
    }
    require_once $filePath;
}

$controllerDir = __DIR__ . '/../app/controllers';
if (is_dir($controllerDir)) {
    foreach (glob("{$controllerDir}/*.php") as $controllerFile) {
        require_once $controllerFile;
    }
} else {
    die("Controllers directory is missing: {$controllerDir}");
}

$databaseFile = __DIR__ . '/Database.php';
if (!file_exists($databaseFile)) {
    die("Database configuration file is missing.");
}

$pdo = require_once $databaseFile;
if (!$pdo instanceof PDO) {
    die("Failed to initialize database connection.");
}


$sessionHelper = __DIR__ . '/../app/helpers/session.php';
if (file_exists($sessionHelper)) {
    require_once $sessionHelper;
} else {
    die("Session helper file is missing.");
}


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
