<?php
include("inc/header.php");
//error_reporting(0);

if ($_POST['submit']) {
    $inlognaam=isset($_POST['inlognaam']) ? $_POST['inlognaam'] : '';
    $wachtwoord=isset($_POST['wachtwoord']) ? $_POST['wachtwoord'] : '';
}
else {
    header('refresh: 1, index.php');
	exit();
}

//Selectquery opbouwen. Neem daarin al de inlognaam en wachtwoord mee!;
$query = "SELECT gebruiker.id, gebruiker.inlognaam, gebruiker.wachtwoord, rol.naam FROM gebruiker
	        INNER JOIN rol ON gebruiker.rol_id=rol.id
	        where inlognaam=:inlognaam and wachtwoord=:wachtwoord;";
//$resultaat bepalen....
$result = $dbconn->prepare($query);
$result->bindParam(':inlognaam' , $inlognaam);
$result->bindParam(':wachtwoord' , $wachtwoord);
$result->execute();
//aantal records bepalen....
$aantal=$result->rowCount();

if ($aantal==1){ 
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $rol = $row['naam'];
    }
    $_SESSION['inlognaam']=$inlognaam;
    $_SESSION['wachtwoord']=$wachtwoord;
    $_SESSION['rol']=$rol;
    $_SESSION['ingelogd']=true;
    header('refresh: 1; url=index.php');
    exit;
}
else {
    echo 'Helaas, uw inlognaam en/of wachtwoord corresponderen niet met onze gegevens. U wordt
    doorgestuurd...<br>';
    session_destroy();
    session_unset();
    header('refresh: 3; url=login.php');
    exit;
}
include("inc/footer.php");
?>