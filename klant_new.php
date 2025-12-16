<?php
include 'inc/header.php';
// header tags toevoegen
echo '<div class="head">';
    echo '<p>Nieuwe klant</p>';
echo '</div>'; //afsluiten div

// voor gridopmaak alvast de main-content
echo '<main class="main-content">';
    // Begin FORM
echo '<div id="frmDetail">';
?>

<div>
    <form action ="dataverwerken.php" method="POST" class="frmDetail">
        <input type="hidden" name="action" value="InsertKlant">
        <label for="fklantnaam">Naam klant:</label>
        <input type="text" name="klantnaam" value="" id="fklantnaam" placeholder="Volledige naam klant...">
        <label for="fcontactpersoon">Contactpersoon.:</label>
        <input type="text" name="contactpersoon" value="" id="fcontactpersoon" placeholder="Contactpersoon...">
        <label for="fstraat">Straat:</label>
        <input type="text" name="straat" value="" id="fstraat" placeholder="Straat klant...">
        <label for="fhuisnummer">Huisnummer:</label>
        <input type="text" name="huisnummer" value="" id="fhuisnummer" placeholder="Huisnummer klant...">
        <label for="fpostcode">Postcode:</label>
        <input type="text" name="postcode" value="" id="fpostcode" placeholder="Postcode klant...">
        <label for="fplaats">Plaats:</label>
        <input type="text" name="plaats" value="" id="fplaats" placeholder="Woonplaats klant...">
        <label for="ftelefoon">Telefoon:</label>
        <input type="text" name="telefoon" value="" id="ftelefoon" placeholder="Telefoon klant...">
        <label for="fnotitie">Notitie:</label>
        <input type="text" name="notitie" value="" id="fnotitie" placeholder="Notitie...">
        <div class="submitbtn">
            <input type="submit" name="submit" value="bewaren..." class="btnDetailSubmit">
        </div>
    </form>
</div>

<?php
echo '</div>'; //frmDetail afsluiten
include ("inc/footer.php") ;
?>