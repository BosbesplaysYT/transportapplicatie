<?php
require_once 'inc/database.php';
include 'inc/header.php';

if (!isset($_GET['id'])) {
    echo "Geen opdracht ID opgegeven.";
    exit();
}

$opdracht_id = (int)$_GET['id'];

// Eerst de klant_id ophalen zodat we terug kunnen redirecten
$stmt = $dbconn->prepare("SELECT klant_id FROM opdracht WHERE id = :id");
$stmt->execute(['id' => $opdracht_id]);
$klant_id = $stmt->fetchColumn();

if (!$klant_id) {
    echo "Opdracht niet gevonden.";
    exit();
}

// Check of er een bevestiging is gegeven
if (isset($_POST['confirm']) && $_POST['confirm'] === 'ja') {
    // Verwijderen
    $stmtDel = $dbconn->prepare("DELETE FROM opdracht WHERE id = :id");
    try {
        $stmtDel->execute(['id' => $opdracht_id]);
        echo "<p>Opdracht {$opdracht_id} is verwijderd.</p>";
        header("refresh:1; url=klant_opdrachten.php?id={$klant_id}");
        exit();
    } catch (PDOException $e) {
        echo "<p style='color:red;'>Opdracht kon niet verwijderd worden.</p>";
        header("refresh:2; url=klant_opdrachten.php?id={$klant_id}");
        exit();
    }
}

// Als er nog geen bevestiging is, tonen we het bevestigingsformulier
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Opdracht verwijderen</title>
</head>
<body>
    <h2>Weet je zeker dat je deze opdracht wilt verwijderen?</h2>
    <form method="POST">
        <input type="hidden" name="confirm" value="ja">
        <button type="submit" class="btn-action">Ja, verwijderen</button>
        <a href="klant_opdrachten.php?id=<?= $klant_id ?>" class="btn-action">Nee, terug</a>
    </form>
</body>
</html>
