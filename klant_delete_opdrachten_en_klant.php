<?php
require_once 'inc/database.php';
include 'inc/header.php';

if (!isset($_GET['id'])) {
    echo "Geen klant ID opgegeven.";
    exit();
}

$klant_id = (int)$_GET['id'];
global $klant_id;

// Klantnaam ophalen
$stmt = $dbconn->prepare("SELECT naam FROM klant WHERE id = :id");
$stmt->execute(['id' => $klant_id]);
$klantNaam = $stmt->fetchColumn();

if (!$klantNaam) {
    echo "Klant niet gevonden.";
    exit();
}

// Check of de gebruiker de verwijdering heeft bevestigd
if (isset($_POST['confirm']) && $_POST['confirm'] === 'ja') {
    try {
        $dbconn->beginTransaction();

        // Alle opdrachten van deze klant verwijderen
        $stmtOpdrachten = $dbconn->prepare("DELETE FROM opdracht WHERE klant_id = :id");
        $stmtOpdrachten->execute(['id' => $klant_id]);

        // Klant verwijderen
        $stmtKlant = $dbconn->prepare("DELETE FROM klant WHERE id = :id");
        $stmtKlant->execute(['id' => $klant_id]);

        $dbconn->commit();

        echo "<p>Klant <strong>{$klantNaam}</strong> en alle bijbehorende opdrachten zijn verwijderd.</p>";
        header('refresh:2; url=klanten.php');
        exit();
    } catch (PDOException $e) {
        $dbconn->rollBack();
        echo "<p style='color:red;'>Er is een fout opgetreden bij het verwijderen van de klant of opdrachten.</p>";
        header('refresh:3; url=klanten.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Alle opdrachten en klant verwijderen</title>
</head>
<body>
    <h2>Weet je zeker dat je alle opdrachten en klant <strong><?= htmlspecialchars($klantNaam) ?></strong> wilt verwijderen?</h2>
    <form method="POST">
        <input type="hidden" name="confirm" value="ja">
        <button type="submit" class="btn-action">Ja, verwijderen</button>
        <a href="klant_delete.php?id=<?php $klant_id; ?>" class="btn-action">Nee, terug</a>
    </form>
</body>
</html>
