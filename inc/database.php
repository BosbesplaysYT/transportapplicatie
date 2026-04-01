<?php

// Database connectie
define('HOST', 'localhost');
define('DATABASE', 'transportbedrijf');
define('USER', 'root');
define('PASSWORD', '');
$dbconn = '';

try {
    $dbconn = new PDO(
        "mysql:host=" . HOST . ";dbname=" . DATABASE . ";charset=utf8mb4",
        USER,
        PASSWORD
    );
    $dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connectie mislukt: " . $e->getMessage());
}