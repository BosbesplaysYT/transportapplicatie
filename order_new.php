<?php
include 'inc/header.php';

// Check of klant_id is opgegeven via GET
if (!isset($_GET['id'])) {
    echo "<p>Geen klant geselecteerd. Een opdracht moet altijd bij een klant horen.</p>";
    exit();
}

$klant_id = (int)$_GET['id'];

// Optioneel: klantnaam ophalen voor referentie
require_once 'inc/database.php';
$stmt = $dbconn->prepare("SELECT naam FROM klant WHERE id = :id");
$stmt->execute(['id' => $klant_id]);
$klantNaam = $stmt->fetchColumn();
?>

<div class="head">
    <p>Nieuwe opdracht voor klant: <?= htmlspecialchars($klantNaam) ?></p>
</div>


<main class="main-content">
    <div id="frmDetail">
        <form action="dataverwerken.php" method="POST" class="fraDetail">
            <input type="hidden" name="action" value="InsertOpdracht">
            <input type="hidden" name="klant_id" value="<?= $klant_id ?>">

            <label for="fdatumopdr">Datum opdracht:</label>
            <input type="date" name="datumopdr" id="fdatumopdr" value="<?= date('Y-m-d') ?>">

            <label for="fcolli">Colli:</label>
            <input type="number" name="colli" id="fcolli" value="1" min="1">

            <label for="fkg">Gewicht (kg):</label>
            <input type="number" step="0.01" name="kg" id="fkg" value="0">

            <label for="fstraat">Straat:</label>
            <input type="text" name="straat" id="fstraat" placeholder="Straat...">

            <label for="fhuisnummer">Huisnummer:</label>
            <input type="text" name="huisnummer" id="fhuisnummer" placeholder="Huisnummer...">

            <label for="ftoevoeging">Toevoeging:</label>
            <input type="text" name="toevoeging" id="ftoevoeging" placeholder="Bijv. A, B, etc.">

            <label for="fplaats">Plaats:</label>
            <input type="text" name="plaats" id="fplaats" placeholder="Plaats...">

            <label for="fdatumplanning">Datum planning:</label>
            <input type="date" name="datumplanning" id="fdatumplanning">

            <label for="fdatumtransport">Datum transport:</label>
            <input type="date" name="datumtransport" id="fdatumtransport">

            <label for="fbedrag">Kosten:</label>
            <input type="number" step="0.01" name="bedrag" id="fbedrag" value="0">

            <label for="fnotitie">Notitie:</label>
            <input type="text" name="notitie" id="fnotitie" placeholder="Notitie...">

            <div class="submitbtn">
                <input type="submit" name="submit" value="bewaren..." class="btnDetailSubmit">
            </div>
        </form>
    </div>
</main>

<?php
include 'inc/footer.php';
?>
