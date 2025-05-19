<?php

require_once __DIR__ . '/config.php';

function databaseConnection()
{
    try {
        $pdo = new PDO(
            "mysql:host=" . SERVER_NAME . ";dbname=" . DB_NAME,
            USER_NAME,
            PASSWORD,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );

        return $pdo;
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
}

// Return the PDO connection
return databaseConnection();
