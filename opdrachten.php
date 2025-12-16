<?php
require_once 'inc/database.php';

// Header output
include('inc/header.php');

// Titel
echo '<header class="head">';
echo '    <h2>Transportopdrachten</h2>';
echo '</header>';

echo '<div class="container">';

echo '<main class="main-content">';

// -------------------------------
// Paginering
// -------------------------------
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) {
    $page = 1;
}

$start_from = ($page - 1) * RECORDS_PER_PAGE;

// Totaal aantal opdrachten ophalen
$total_rows = fnGetPagesFromTable('opdracht');
$total_pages = ceil($total_rows / RECORDS_PER_PAGE);

// -------------------------------
// Opdrachten ophalen
// -------------------------------
$query = "
    SELECT o.*, k.naam AS klantnaam
    FROM opdracht o
    LEFT JOIN klant k ON o.klant_id = k.id
    ORDER BY o.datumopdr DESC
    LIMIT :start_from, :limit
";

$stmt = $dbconn->prepare($query);
$stmt->bindValue(':start_from', $start_from, PDO::PARAM_INT);
$stmt->bindValue(':limit', RECORDS_PER_PAGE, PDO::PARAM_INT);
$stmt->execute();

$opdrachten = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<table id="customers">
    <tr>
        <th>Opdracht ID</th>
        <th>Datum</th>
        <th>Klant</th>
        <th>Colli</th>
        <th>Gewicht (kg)</th>
        <th>Adres</th>
        <th>Plaats</th>
        <th>Datum planning</th>
        <th>Datum transport</th>
        <th>Bedrag</th>
        <th>Actie</th>
    </tr>

<?php
if ($opdrachten) {
    foreach ($opdrachten as $row) {

        $adres = $row['straat'] . ' ' . $row['huisnummer'];
        if (!empty($row['toevoeging'])) {
            $adres .= ' ' . $row['toevoeging'];
        }

        echo "
        <tr>
            <td>{$row['id']}</td>
            <td>{$row['datumopdr']}</td>
            <td>" . htmlspecialchars($row['klantnaam']) . "</td>
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
    echo "<tr><td colspan='11'>Geen opdrachten gevonden.</td></tr>";
}
?>
</table>



<?php
// Paginering
$page_url = "opdrachten.php";
include 'inc/paginering.php';

// Main content sluiten
echo '</main>';

// Footer
include('inc/footer.php');
?>

</div>
</body>
</html>
