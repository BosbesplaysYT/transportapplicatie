<?php
include 'inc/header.php';

echo '<header class="head"></header>';

echo '<main class="main-content">';

echo '<div id="frmDetail">';

if (isset($_GET["id"])) {
    $klantId = $_GET["id"];
} else {
    header('refresh: 2; url=klanten.php');
    exit();
}

$sql = "SELECT * FROM klant WHERE id=:klantId;";
$resultKlant = $dbconn->prepare($sql);
$resultKlant->bindParam(':klantId', $klantId, PDO::PARAM_INT);
$resultKlant->execute();

if ($resultKlant->rowCount() != 1) {
    header('refresh: 2; url=klanten.php');
    exit();
}

$klant = $resultKlant->fetch(PDO::FETCH_ASSOC);
?>

<div>
    <form action="dataverwerken.php" method="POST" class="fraDetail">
        <input type="hidden" name="action" value="UpdateKlant">
        <label for="fklantnr">Klantnr:</label>
        <input type="text" name="klantnr" value="<?php echo $klantId;?>" id="fklantnr">
        
        <label for="fklantnaam">Naam klant:</label>
        <input type="text" name="klantnaam" value="<?php echo $klant["naam"];?>" id="fklantnaam">
        
        <label for="fcontactpersoon">Contactpersoon:</label>
        <input type="text" name="contactpersoon" value="<?php echo $klant["cp"];?>" id="fcontactpersoon">
        
        <label for="fstraat">Straat:</label>
        <input type="text" name="straat" value="<?php echo $klant["straat"];?>" id="fstraat">
        
        <label for="fhuisnummer">Huisnummer:</label>
        <input type="text" name="huisnummer" value="<?php echo $klant["huisnummer"];?>" id="fhuisnummer">
        
        <label for="fpostcode">Postcode:</label>
        <input type="text" name="postcode" value="<?php echo $klant["postcode"];?>" id="fpostcode">
        
        <label for="fplaats">Plaats:</label>
        <input type="text" name="plaats" value="<?php echo $klant["plaats"];?>" id="fplaats">
        
        <label for="ftelefoon">Telefoon:</label>
        <input type="text" name="telefoon" value="<?php echo $klant["telefoon"];?>" id="ftelefoon">
        
        <label for="fnotitie">Notitie:</label>
        <input type="text" name="notitie" value="<?php echo $klant["notitie"];?>" id="fnotitie">
        
        <div class="submitbtn">
            <input type="submit" name="submit" value="bewaren..." class="btnDetailSubmit">
        </div>
    </form>
</div>

<?php
echo '</div>'; // Einde frmDetail
include 'inc/footer.php';
?>
