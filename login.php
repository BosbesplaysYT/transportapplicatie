<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transportapplicatie</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<?php
    include 'inc/header.php';
?>
<body>
    <main class="main-content">
        <div id="login"><h2>Transportapplicatie</h2></div>
        <div id="login">
            <div>
                <form action="authorisatie.php" method="POST" class="frmlogin">
                    <label for="fInlog">Inlognaam:</label><input type="text" name="inlognaam" id="fInlog" size="25" placeholder="inlognaam..."><br>
                    <label for="fWachtwoord">Wachtwoord:</label><input type="password" id="fWachtwoord" name="wachtwoord" size="25" placeholder="wachtwoord..."><br>
                    <input type="submit" name="submit" value="login"><br>
                </form>
            </div>
        </div>
    </main>
    <style>
        main {
            height: 80vh;
        }
    </style>
</body>

<?php
    include 'inc/footer.php';
?>
</html>