<?php
include 'inc/header.php';

echo '<header class="head"></header>';
echo '<main class="main-content">';
echo '<div id="frmDetail">';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = isset($_POST["action"]) ? $_POST["action"] : 'LEEG';
    switch ($action) {
        case "UpdateKlant":
            updateKlant();
            break;
        case "InsertKlant":
            insertKlant();
            break;
        case "UpdateOpdracht":
            updateOpdracht();
            break;
        case "InsertOpdracht":
            insertOpdracht();
            break;
        case "InsertGebruiker":
            insertGebruiker();
            break;
        case "UpdateGebruiker":
            updateGebruiker();
            break;
        case "LEEG":
        default:
            echo "Dat is geen geldige actie";
    }
} else {
    header('Location: index.php');
    exit();
}

function insertGebruiker() {
    global $dbconn;

    $inlognaam = $_POST["inlognaam"] ?? "";
    $wachtwoord = $_POST["wachtwoord"] ?? "";
    $rol_id = (int)($_POST["rol_id"] ?? 0);

    if ($inlognaam === "" || $wachtwoord === "" || $rol_id < 1 || $rol_id > 4) {
        echo "<p style='color: red;'>Ongeldige invoer</p>";
        header('refresh: 2; url=gebruiker_new.php');
        exit();
    }

    $qryInsertGebruiker = "
        INSERT INTO gebruiker (inlognaam, wachtwoord, rol_id, createdate, changedate)
        VALUES (?, ?, ?, NOW(), NOW())
    ";

    $arData = [$inlognaam, $wachtwoord, $rol_id];

    try {
        $stmt = $dbconn->prepare($qryInsertGebruiker);
        $stmt->execute($arData);

        echo "<p>Gebruiker {$inlognaam} is toegevoegd</p><br>";
        header('refresh: 1; url=gebruikers.php');
        exit();
    } catch (PDOException $e) {
        echo "<p style='color: red;'>Gebruiker {$inlognaam} kon niet toegevoegd worden</p><br>";
        header('refresh: 2; url=gebruiker_new.php');
        exit();
    }
}

function updateGebruiker() {
    global $dbconn;

    $id = (int)($_POST['id'] ?? 0);
    $inlognaam = $_POST['inlognaam'] ?? '';
    $wachtwoord = $_POST['wachtwoord'] ?? '';
    $rol_id = (int)($_POST['rol_id'] ?? 0);

    $qry = "
        UPDATE gebruiker
        SET inlognaam = ?, wachtwoord = ?, rol_id = ?, changedate = NOW()
        WHERE id = ?
    ";

    try {
        $stmt = $dbconn->prepare($qry);
        $stmt->execute([$inlognaam, $wachtwoord, $rol_id, $id]);
        echo "<p>Gebruiker {$inlognaam} is aangepast.</p>";
        header('refresh:1; url=gebruikers.php');
        exit();
    } catch (PDOException $e) {
        echo "<p style='color:red;'>Gebruiker kon niet aangepast worden.</p>";
        header('refresh:2; url=gebruikers.php');
        exit();
    }
}


function updateKlant() {
    global $dbconn;
    $id = isset($_POST["klantnr"]) ? (int)$_POST['klantnr'] : 0;
    $klantnaam = $_POST["klantnaam"] ?? "";
    $contactpersoon = $_POST["contactpersoon"] ?? "";
    $straat = $_POST["straat"] ?? "";
    $huisnummer = $_POST["huisnummer"] ?? "";
    $postcode = $_POST["postcode"] ?? "";
    $plaats = $_POST["plaats"] ?? "";
    $telefoon = $_POST["telefoon"] ?? "";
    $notitie = $_POST["notitie"] ?? "";

    $qryUpdateKlant = "UPDATE klant SET naam=?, cp=?, straat=?, huisnummer=?, postcode=?, plaats=?, telefoon=?, notitie=? WHERE id=?";
    $arData = [$klantnaam, $contactpersoon, $straat, $huisnummer, $postcode, $plaats, $telefoon, $notitie, $id];

    try {
        $stmt = $dbconn->prepare($qryUpdateKlant);
        $stmt->execute($arData);
        echo "<p>Klant {$klantnaam} ({$id}) is aangepast</p><br>";
        header('refresh: 1; url=klanten.php');
        exit();
    } catch (PDOException $e) {
        echo "<p style='color: red;'>Klant {$klantnaam} ({$id}) kon niet aangepast worden</p><br>";
        header('refresh: 2; url=klanten.php');
        exit();
    }
}

function insertKlant() {
    global $dbconn;
    $klantnaam = $_POST["klantnaam"] ?? "";
    $contactpersoon = $_POST["contactpersoon"] ?? "";
    $straat = $_POST["straat"] ?? "";
    $huisnummer = $_POST["huisnummer"] ?? "";
    $postcode = $_POST["postcode"] ?? "";
    $plaats = $_POST["plaats"] ?? "";
    $telefoon = $_POST["telefoon"] ?? "";
    $notitie = $_POST["notitie"] ?? "";

    $qryInsertKlant = "INSERT INTO klant (naam, cp, straat, huisnummer, postcode, plaats, telefoon, notitie) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $arData = [$klantnaam, $contactpersoon, $straat, $huisnummer, $postcode, $plaats, $telefoon, $notitie];

    try {
        $stmt = $dbconn->prepare($qryInsertKlant);
        $stmt->execute($arData);
        echo "<p>Klant {$klantnaam} is toegevoegd</p><br>";
        header('refresh: 1; url=klanten.php');
        exit();
    } catch (PDOException $e) {
        echo "<p style='color: red;'>Klant {$klantnaam} kon niet toegevoegd worden</p><br>";
        header('refresh: 2; url=klanten.php');
        exit();
    }
}

function updateOpdracht() {
    global $dbconn;
    $id = (int)($_POST['id'] ?? 0);
    $datumopdr = $_POST['datumopdr'] ?? null;
    $colli = $_POST['colli'] ?? 0;
    $kg = $_POST['kg'] ?? 0;
    $straat = $_POST['straat'] ?? '';
    $huisnummer = $_POST['huisnummer'] ?? '';
    $toevoeging = $_POST['toevoeging'] ?? '';
    $plaats = $_POST['plaats'] ?? '';
    $datumplanning = $_POST['datumplanning'] ?? null;
    $datumtransport = $_POST['datumtransport'] ?? null;
    $bedrag = $_POST['bedrag'] ?? 0;
    $notitie = $_POST['notitie'] ?? '';

    $qryUpdate = "UPDATE opdracht SET datumopdr=?, colli=?, kg=?, straat=?, huisnummer=?, toevoeging=?, plaats=?, datumplanning=?, datumtransport=?, bedrag=?, notitie=? WHERE id=?";
    $arData = [$datumopdr, $colli, $kg, $straat, $huisnummer, $toevoeging, $plaats, $datumplanning, $datumtransport, $bedrag, $notitie, $id];

    try {
        $stmt = $dbconn->prepare($qryUpdate);
        $stmt->execute($arData);
        echo "<p>Opdracht {$id} is aangepast</p><br>";
        header('refresh: 1; url=klant_opdrachten.php?id=' . $_POST['klant_id']);
        exit();
    } catch (PDOException $e) {
        echo "<p style='color: red;'>Opdracht {$id} kon niet aangepast worden</p><br>";
        header('refresh: 2; url=klant_opdrachten.php?id=' . $_POST['klant_id']);
        exit();
    }
}

function insertOpdracht() {
    global $dbconn;
    $klant_id = (int)($_POST['klant_id'] ?? 0);
    $datumopdr = $_POST['datumopdr'] ?? null;
    $colli = $_POST['colli'] ?? 0;
    $kg = $_POST['kg'] ?? 0;
    $straat = $_POST['straat'] ?? '';
    $huisnummer = $_POST['huisnummer'] ?? '';
    $toevoeging = $_POST['toevoeging'] ?? '';
    $plaats = $_POST['plaats'] ?? '';
    $datumplanning = $_POST['datumplanning'] ?? null;
    $datumtransport = $_POST['datumtransport'] ?? null;
    $bedrag = $_POST['bedrag'] ?? 0;
    $notitie = $_POST['notitie'] ?? '';

    $qryInsert = "INSERT INTO opdracht (klant_id, datumopdr, colli, kg, straat, huisnummer, toevoeging, plaats, datumplanning, datumtransport, bedrag, notitie) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $arData = [$klant_id, $datumopdr, $colli, $kg, $straat, $huisnummer, $toevoeging, $plaats, $datumplanning, $datumtransport, $bedrag, $notitie];

    try {
        $stmt = $dbconn->prepare($qryInsert);
        $stmt->execute($arData);
        echo "<p>Opdracht toegevoegd voor klant {$klant_id}</p><br>";
        header('refresh: 1; url=klant_opdrachten.php?id=' . $klant_id);
        exit();
    } catch (PDOException $e) {
        echo "<p style='color: red;'>Opdracht kon niet toegevoegd worden</p><br>";
        header('refresh: 2; url=klant_opdrachten.php?id=' . $klant_id);
        exit();
    }
}

echo '</div>';
include('inc/footer.php');
?>
