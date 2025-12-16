<?php

include 'inc/header.php';


$aantalKlanten = 0;
$aantalOpdrachten = 0;

try {
    // tel aantal klanten
    $qryKlanten = $dbconn->prepare("SELECT COUNT(*) AS totaal FROM Klant");
    $qryKlanten->execute();
    $aantalKlanten = $qryKlanten->fetch(PDO::FETCH_ASSOC)['totaal'];

    // tel aantal opdrachten
    $qryOpdrachten = $dbconn->prepare("SELECT COUNT(*) AS totaal FROM Opdracht");
    $qryOpdrachten->execute();
    $aantalOpdrachten = $qryOpdrachten->fetch(PDO::FETCH_ASSOC)['totaal'];

} catch (Exception $e) {
    // bij een fout iets simpels tonen zodat de pagina alsnog kan renderen
    $aantalKlanten = '-';
    $aantalOpdrachten = '-';
}

echo '<div class="head">';
echo '</div>';

echo '<main class="main-content">';

?>

<!-- Start een div met id login om een mooie gecentreerde box te krijgen -->
<div id="login">
    <div>
        <div id="login">
            <div>
                <p><?php echo "Welkom " . htmlspecialchars($inlognaam, ENT_QUOTES) . "!"; ?></p>
                <p>Je bent succesvol ingelogd met rol <?php echo $authRol?></p>
            </div>
        </div> 

        <h3>Overzicht</h3>
        <ul>
            <li>Totaal aantal klanten: <strong><?php echo $aantalKlanten; ?></strong></li>
            <li>Totaal aantal opdrachten: <strong><?php echo $aantalOpdrachten; ?></strong></li>
        </ul>

        <?php witregel(1) ?>

        <p>Gelijk naar:</p>
        <?php witregel(1) ?>

        <a href="klanten.php" class="btn-action">Klantenoverzicht</a>
        <?php witregel(3) ?>

        <a href="opdrachten.php" class="btn-action">Transportopdrachten</a>
    </div>
</div>

</main>

<?php
include 'inc/footer.php';
?>
