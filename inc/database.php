<?php

// Database connectie
define('HOST', 'localhost');
define('DATABASE', 'transportbedrijf');
define('USER', 'mutationuser');
define('PASSWORD', '1234');
$dbconn = '';

try {
    $dbconn = new PDO("mysql:host=" . HOST . ";dbname=" . DATABASE . ";charset=utf8mb4", USER, PASSWORD);
} catch(exception $e) {
    $dbconn = $e;
}