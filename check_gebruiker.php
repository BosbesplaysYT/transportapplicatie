<?php
require_once 'inc/database.php';

header('Content-Type: application/json');

$inlognaam = $_GET['inlognaam'] ?? '';

if ($inlognaam === '') {
    echo json_encode(['bestaat' => false]);
    exit();
}

$sql = "SELECT COUNT(*) FROM gebruiker WHERE inlognaam = :inlognaam";
$stmt = $dbconn->prepare($sql);
$stmt->execute(['inlognaam' => $inlognaam]);

$bestaat = $stmt->fetchColumn() > 0;

echo json_encode([
    'bestaat' => $bestaat
]);
