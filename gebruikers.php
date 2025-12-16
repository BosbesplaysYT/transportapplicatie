<?php
require_once 'inc/database.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gebruikers</title>
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
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'beheerder') {
            header('Location: index.php');
            exit();
        }
    ?>

    <table id="customers">
        <tr>
            <th>id</th>
            <th>inlognaam</th>
            <th>rol</th>
            <th>createdate</th>
            <th>changedate</th>
            <th>actie</th>
        </tr>

        <?php

        if (isset($_GET["page"])) {
            $page = $_GET["page"];
        } else {
            $page = 1;
        }

        $start_from = ($page - 1) * RECORDS_PER_PAGE;
        $total_rows = fnGetPagesFromTable('gebruiker');
        $total_pages = ceil($total_rows / RECORDS_PER_PAGE);

        // gebruikers ophalen
        $query = "
            SELECT 
                g.id,
                g.inlognaam,
                g.wachtwoord,
                g.rol_id,
                g.createdate,
                g.changedate
            FROM gebruiker g
            ORDER BY g.id
            LIMIT " . $start_from . "," . RECORDS_PER_PAGE . ";
        ";

        $result = $dbconn->prepare($query);
        $result->execute();

        $aantal = $result->rowCount();
        $contentTable = "";

        if ($aantal > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

                switch ($row['rol_id']) {
                    case 1: $rol = 'Beheerder'; break;
                    case 2: $rol = 'Administratie'; break;
                    case 3: $rol = 'Planner'; break;
                    case 4: $rol = 'Klantrelaties'; break;
                    default: $rol = 'Onbekend';
                }

                $contentTable .= "
                    <tr>
                        <td>".$row['id']."</td>
                        <td>".$row['inlognaam']."</td>
                        <td>".$rol."</td>
                        <td>".$row['createdate']."</td>
                        <td>".$row['changedate']."</td>
                        <td>
                            <a href='gebruiker_edit.php?id={$row['id']}' class='btn-edit'>
                                <i class='material-icons md-24'>edit</i>
                            </a>
                            <a href='gebruiker_delete.php?user_id={$row['id']}' class='btn-delete'>
                                <i class='material-icons md-24'>delete</i>
                            </a>
                        </td>

                    </tr>
                ";
            }
        } else {
            $contentTable = "
                <tr>
                    <td colspan='6'>Geen gegevens om op te halen.</td>
                </tr>
            ";
        }

        $contentTable .= "</table><br>";
        echo $contentTable;

        $page_url = "gebruikers.php";
        include_once 'inc/paginering.php';

        echo '</main>';
        ?>

    </div>
</body>
</html>
