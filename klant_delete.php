<?php
require_once 'inc/database.php';
include 'inc/header.php';

if (!isset($_GET['id'])) {
    echo "Geen klant ID opgegeven.";
    exit();
}

$klant_id = (int)$_GET['id'];

// Klantnaam ophalen voor een nette boodschap
$stmt = $dbconn->prepare("SELECT naam FROM klant WHERE id = :id");
$stmt->execute(['id' => $klant_id]);
$klantNaam = $stmt->fetchColumn();

if (!$klantNaam) {
    echo "Klant niet gevonden.";
    exit();
}

// Check of de gebruiker de verwijdering heeft bevestigd
if (isset($_POST['confirm']) && $_POST['confirm'] === 'ja') {
    // Eerst controleren of er opdrachten bestaan
    $stmtCheck = $dbconn->prepare("SELECT COUNT(*) FROM opdracht WHERE klant_id = :id");
    $stmtCheck->execute(['id' => $klant_id]);
    $opdrachtenAantal = (int)$stmtCheck->fetchColumn();

    if ($opdrachtenAantal > 0) {
        echo "<p style='color:red;'>Klant <strong>{$klantNaam}</strong> kan niet verwijderd worden.</p>";
        witregel(1);
        echo "<p>Er bestaan nog {$opdrachtenAantal} opdrachten voor deze klant.</p>";
        witregel(2);
        echo "<a href='klanten.php' class='btn-action'>Terug naar klantenlijst</a>";
        witregel(3);
        echo "<a href='klant_delete_opdrachten_en_klant.php?id={$klant_id}' class='btn-action'>Alle opdrachten verwijderen en dan klant verwijderen</a>";
        exit();
    } else {
        // Geen opdrachten, veilig verwijderen
        $stmtDel = $dbconn->prepare("DELETE FROM klant WHERE id = :id");
        try {
            $stmtDel->execute(['id' => $klant_id]);
            echo "<p>Klant <strong>{$klantNaam}</strong> is verwijderd.</p>";
            header('refresh:1; url=klanten.php');
            exit();
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Klant kon niet verwijderd worden.</p>";
            header('refresh:2; url=klanten.php');
            exit();
        }
    }
}

// Als er nog geen bevestiging is, tonen we het bevestigingsformulier
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Klant verwijderen</title>
</head>
<body>
    <h2>Weet je zeker dat je klant <strong><?= htmlspecialchars($klantNaam) ?></strong> wilt verwijderen?</h2>
    <form method="POST">
        <input type="hidden" name="confirm" value="ja">
        <button type="submit" class="btn-action">Ja, verwijderen</button>
        <a href="klanten.php" class="btn-action">Nee, terug</a>
    </form>
</body>
</html>
