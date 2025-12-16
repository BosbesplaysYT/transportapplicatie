<?php
require_once 'inc/database.php';

if (!isset($_GET['id'])) {
    echo "Geen gebruiker ID opgegeven.";
    exit();
}

$gebruikerId = (int)$_GET['id'];

// Gebruiker ophalen
$sql = "SELECT * FROM gebruiker WHERE id = :id";
$stmt = $dbconn->prepare($sql);
$stmt->bindParam(':id', $gebruikerId, PDO::PARAM_INT);
$stmt->execute();

if ($stmt->rowCount() !== 1) {
    echo "Gebruiker niet gevonden.";
    exit();
}

$gebruiker = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Gebruiker bewerken</title>
    <link rel="stylesheet" type="text/css" href="css/nav.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<div class="container">
<?php
    include 'inc/header.php';

    if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'beheerder') {
        header('Location: index.php');
        exit();
    }

    echo '<header class="head"><p>Gebruiker bewerken</p></header>';
    echo '<main class="main-content">';
    if ((int)$gebruikerId === (int)$_SESSION['userid']) {
        echo "<p style='color:orange; text-align:center;'>De geselecteerde gebruiker ben je zelf! Let op dat dit voor problemen kan zorgen als je bijvoorbeeld je rol aanpast</p>";
    }
    witregel(10);
    echo '<div id="frmDetail">';
?>

<form action="dataverwerken.php" method="POST" class="frmDetail">
    <input type="hidden" name="action" value="UpdateGebruiker">
    <input type="hidden" name="id" value="<?= $gebruikerId ?>">

    <label for="finlognaam">Inlognaam:</label>
    <input type="text" name="inlognaam" id="finlognaam" value="<?= htmlspecialchars($gebruiker['inlognaam']) ?>" required>

    <label for="fwachtwoord">Wachtwoord:</label>
    <input type="text" name="wachtwoord" id="fwachtwoord" value="<?= htmlspecialchars($gebruiker['wachtwoord']) ?>" required>

    <label for="frol">Rol:</label>
    <select name="rol_id" id="frol" required>
        <option value="1" <?= $gebruiker['rol_id'] == 1 ? 'selected' : '' ?>>Beheerder</option>
        <option value="2" <?= $gebruiker['rol_id'] == 2 ? 'selected' : '' ?>>Administratie</option>
        <option value="3" <?= $gebruiker['rol_id'] == 3 ? 'selected' : '' ?>>Planner</option>
        <option value="4" <?= $gebruiker['rol_id'] == 4 ? 'selected' : '' ?>>Klantrelaties</option>
    </select>

    <div class="submitbtn">
        <input type="submit" value="bewaren..." class="btnDetailSubmit">
    </div>
</form>

<?php
    echo '</div>'; // frmDetail
    echo '</main>';
    include 'inc/footer.php';
?>
</div>
</body>
</html>
