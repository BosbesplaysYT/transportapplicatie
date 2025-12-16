<?php
require_once 'inc/database.php';
include 'inc/header.php';

echo '<header class="head"><h2>Opdracht bewerken</h2></header>';
echo '<main class="main-content">';
echo '<div id="frmDetail">';

if (!isset($_GET["id"])) {
    echo "Geen opdracht ID opgegeven.";
    exit();
}

$opdrachtId = (int)$_GET["id"];

// Opdracht ophalen
$sql = "SELECT * FROM opdracht WHERE id=:opdrachtId";
$stmt = $dbconn->prepare($sql);
$stmt->bindParam(':opdrachtId', $opdrachtId, PDO::PARAM_INT);
$stmt->execute();

if ($stmt->rowCount() != 1) {
    echo "Opdracht niet gevonden.";
    exit();
}

$opdracht = $stmt->fetch(PDO::FETCH_ASSOC);

$sqlKlant = "SELECT naam FROM klant WHERE id=:klantId";
$stmtKlant = $dbconn->prepare($sqlKlant);
$stmtKlant->execute(['klantId' => $opdracht['klant_id']]);
$klantNaam = $stmtKlant->fetchColumn();
?>

<form action="dataverwerken.php" method="POST" class="fraDetail">
    <input type="hidden" name="action" value="UpdateOpdracht">
    <input type="hidden" name="id" value="<?= $opdrachtId ?>">
    <input type="hidden" name="klant_id" value="<?= $opdracht['klant_id'] ?>">

    <label for="fklant">Klant:</label>
    <input type="text" id="fklant" value="<?= htmlspecialchars($klantNaam) ?>" disabled>

    <label for="fdatumopdr">Datum opdracht:</label>
    <input type="date" name="datumopdr" id="fdatumopdr" value="<?= $opdracht['datumopdr'] ?>">

    <label for="fcolli">Colli:</label>
    <input type="number" name="colli" id="fcolli" value="<?= $opdracht['colli'] ?>">

    <label for="fkg">Gewicht (kg):</label>
    <input type="number" step="0.01" name="kg" id="fkg" value="<?= $opdracht['kg'] ?>">

    <label for="fstraat">Straat:</label>
    <input type="text" name="straat" id="fstraat" value="<?= $opdracht['straat'] ?>">

    <label for="fhuisnummer">Huisnummer:</label>
    <input type="text" name="huisnummer" id="fhuisnummer" value="<?= $opdracht['huisnummer'] ?>">

    <label for="ftoevoeging">Toevoeging:</label>
    <input type="text" name="toevoeging" id="ftoevoeging" value="<?= $opdracht['toevoeging'] ?>">

    <label for="fplaats">Plaats:</label>
    <input type="text" name="plaats" id="fplaats" value="<?= $opdracht['plaats'] ?>">

    <label for="fdatumplanning">Datum planning:</label>
    <input type="date" name="datumplanning" id="fdatumplanning" value="<?= $opdracht['datumplanning'] ?>">

    <label for="fdatumtransport">Datum transport:</label>
    <input type="date" name="datumtransport" id="fdatumtransport" value="<?= $opdracht['datumtransport'] ?>">

    <label for="fbedrag">Kosten:</label>
    <input type="number" step="0.01" name="bedrag" id="fbedrag" value="<?= $opdracht['bedrag'] ?>">

    <label for="fnotitie">Notitie:</label>
    <input type="text" name="notitie" id="fnotitie" value="<?= htmlspecialchars($opdracht['notitie']) ?>">

    <div class="submitbtn">
        <input type="submit" name="submit" value="bewaren..." class="btnDetailSubmit">
    </div>
</form>

<?php
echo '</div>'; // Einde frmDetail
include 'inc/footer.php';
?>
