<?php
require_once 'inc/database.php';

if (!isset($_GET['user_id'])) {
    echo "Geen gebruiker ID opgegeven.";
    exit();
}

$gebruikerId = (int)$_GET['user_id'];

// Gebruiker ophalen
$stmt = $dbconn->prepare("SELECT inlognaam FROM gebruiker WHERE id = :id");
$stmt->execute(['id' => $gebruikerId]);
$gebruikerinlognaam = $stmt->fetchColumn();

if (!$gebruikerinlognaam) {
    echo "Gebruiker niet gevonden.";
    exit();
}

// Verwijderen na bevestiging
if (isset($_POST['confirm']) && $_POST['confirm'] === 'ja') {
    try {
        $stmtDel = $dbconn->prepare("DELETE FROM gebruiker WHERE id = :id");
        $stmtDel->execute(['id' => $gebruikerId]);

        echo "<p>Gebruiker {$gebruikerinlognaam} is verwijderd.</p>";
        header('refresh:1; url=gebruikers.php');
        exit();
    } catch (PDOException $e) {
        echo "<p style='color:red;'>Gebruiker kon niet verwijderd worden.</p>";
        header('refresh:2; url=gebruikers.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Gebruiker verwijderen</title>
</head>
<body>
<?php
    include 'inc/header.php';

    if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'beheerder') {
        header('Location: index.php');
        exit();
    }
?>

<h2>Weet je zeker dat je gebruiker <strong><?= htmlspecialchars($gebruikerinlognaam) ?></strong> wilt verwijderen?</h2>

<form method="POST">
    <input type="hidden" name="confirm" value="ja">
    <button type="submit">Ja, verwijderen</button>
    <a href="gebruikers.php">Nee, terug</a>
</form>

</body>
</html>
