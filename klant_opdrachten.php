<?php
require_once 'inc/database.php';

if (!isset($_GET['id'])) {
    die("Geen klant ID opgegeven.");
}

$klant_id = (int)$_GET['id'];

// Klantgegevens ophalen
$queryKlant = "SELECT * FROM klant WHERE id = :id";
$stmtKlant = $dbconn->prepare($queryKlant);
$stmtKlant->execute(['id' => $klant_id]);
$klant = $stmtKlant->fetch(PDO::FETCH_ASSOC);

if (!$klant) {
    die("Klant niet gevonden.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Opdrachten van klant <?= htmlspecialchars($klant['naam']) ?></title>
    <link rel="stylesheet" type="text/css" href="css/nav.css">
    <link rel="stylesheet" type="text/css" href="css/style.css"> 
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> 
</head>
<body>
<div class="container">
    <?php include('inc/header.php'); ?>
    <header class="head">
        <h2>Opdrachten van <?= htmlspecialchars($klant['naam']) ?></h2>
    </header>

    <main class="main-content">
        <!-- Kleine tabel met klantgegevens -->
        <table id="klantinfo">
            <tr><th>Klantnummer</th><td><?= $klant['id'] ?></td></tr>
            <tr><th>Naam</th><td><?= htmlspecialchars($klant['naam']) ?></td></tr>
            <tr><th>Contactpersoon</th><td><?= htmlspecialchars($klant['cp']) ?></td></tr>
            <tr><th>Telefoon</th><td><?= htmlspecialchars($klant['telefoon']) ?></td></tr>
            <tr><th>Plaats</th><td><?= htmlspecialchars($klant['plaats']) ?></td></tr>
        </table>
        <br>
        <a href="order_new.php?id=<?php echo $klant_id ?>" class="btn-action">Nieuwe transportopdracht</a>

        <?php witregel(2); ?>

        <!-- Opdrachten tabel -->
        <table id="customers">
            <tr>
                <th>Order ID</th>
                <th>Datum opdracht</th>
                <th>Colli</th>
                <th>Gewicht (kg)</th>
                <th>Adres</th>
                <th>Plaats</th>
                <th>Datum planning</th>
                <th>Datum transport</th>
                <th>Kosten</th>
                <th>Actie</th>
            </tr>

<?php
// Paginering
if (isset($_GET["page"])) {
    $page = (int)$_GET["page"];
} else {
    $page = 1;
}

$start_from = ($page-1) * RECORDS_PER_PAGE;

// Totaal aantal opdrachten van deze klant
$queryCount = "SELECT COUNT(*) FROM opdracht WHERE klant_id = :klant_id";
$stmtCount = $dbconn->prepare($queryCount);
$stmtCount->execute(['klant_id' => $klant_id]);
$total_rows = $stmtCount->fetchColumn();
$total_pages = ceil($total_rows / RECORDS_PER_PAGE);

// Opdrachten ophalen
$queryOpdrachten = "
    SELECT * 
    FROM opdracht
    WHERE klant_id = :klant_id
    ORDER BY datumopdr DESC
    LIMIT $start_from,".RECORDS_PER_PAGE;
$stmtOpdrachten = $dbconn->prepare($queryOpdrachten);
$stmtOpdrachten->execute(['klant_id' => $klant_id]);
$opdrachten = $stmtOpdrachten->fetchAll(PDO::FETCH_ASSOC);

if ($opdrachten) {
    foreach ($opdrachten as $row) {
        $adres = $row['straat'] . ' ' . $row['huisnummer'] . ($row['toevoeging'] ? ' ' . $row['toevoeging'] : '');
        echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['datumopdr']}</td>
            <td>{$row['colli']}</td>
            <td>{$row['kg']}</td>
            <td>{$adres}</td>
            <td>{$row['plaats']}</td>
            <td>{$row['datumplanning']}</td>
            <td>{$row['datumtransport']}</td>
            <td>{$row['bedrag']}</td>
            <td>
                <a href='opdracht_edit.php?id={$row['id']}' class='btn-edit'><i class='material-icons md-24'>edit</i></a>
                <a href='opdracht_delete.php?id={$row['id']}' class='btn-delete'><i class='material-icons md-24'>delete</i></a>
            </td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='10'>Geen opdrachten gevonden voor deze klant.</td></tr>";
}
?>

        </table>
        <br>

<?php
// Paginering includen (zelfde logica als bij klanten.php)
$page_url = "klant_opdrachten.php?id=" . $klant_id;
include_once 'inc/paginering.php';
?>

    </main>
</div>
</body>
</html>
