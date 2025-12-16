<?php
require_once 'inc/database.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Klantgegevens</title>
    <link rel="stylesheet" type="text/css" href="css/nav.css">
    <link rel="stylesheet" type="text/css" href="css/style.css"> 
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> 
</head>
<body>
    <div class="container">
    <?php

        include('inc/header.php'); 
        echo '<header class="head">';

        echo '</header>';

        echo '<main class="main-content">';
    ?>

    <a href="klant_new.php" class="btn-action">Nieuwe klant</a>

    <?php witregel(3) ?>

    <table id="customers">
        <tr>
            <th>klantnummer</th>
            <th>klantnaam</th>
            <th>contactpersoon</th>
            <th>straat</th>
            <th>huisnummer</th>
            <th>postcode</th>
            <th>plaats</th>
            <th>telefoon</th>
            <th>actie</th>
        </tr>

        <?php

        if (isset($_GET["page"])) {
            $page = $_GET["page"];
        } else {
            $page = 1;
        }

        $start_from = ($page-1) * RECORDS_PER_PAGE;
        $total_rows = fnGetPagesFromTable('klant');
        $total_pages = ceil($total_rows / RECORDS_PER_PAGE);

        // klantgegevens ophalen
        $query = "SELECT *
                    FROM klant
                    ORDER BY naam
                    LIMIT " .$start_from.",". RECORDS_PER_PAGE.";";
        $result = $dbconn->prepare($query);
        // uitvoeren maar
        $result->execute();
        $aantal=$result->rowCount();
        $contentTable = "";
        if ($aantal > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $contentTable .= "
                    <tr>
                        <td>".$row['id']."</td>
                        <td>".$row['naam']."</td>
                        <td>".$row['cp']."</td>
                        <td>".$row['straat']."</td>
                        <td>".$row['huisnummer']."</td>
                        <td>".$row['postcode']."</td>
                        <td>".$row['plaats']."</td>
                        <td>".$row['telefoon']."</td>
                        <!--<td>".$row['notitie']."</td>-->
                        <td>
                            <a href='klant_edit.php?id={$row['id']}' class='btn-edit'><i class='material-icons md-24'>edit</i></a>
                            <a href='klant_delete.php?id={$row['id']}' class='btn-delete'><i class='material-icons md-24'>delete</i></a>
                            <a href='klant_opdrachten.php?id={$row['id']}' class='btn-secondary'>transportopdrachten</a>
                        </td>
                    </tr>
                ";
            }
        } else {
            $contentTable = "
            <tr>
                <td colspan='9'>Geen gegevens om op te halen.</td>
            </tr>
            ";
        }
        $contentTable .= "</table><br>";
        echo $contentTable;

        $page_url = "klanten.php";
        include_once 'inc/paginering.php';


        echo '</main>'
        ?>

</div>
</body>
</html>