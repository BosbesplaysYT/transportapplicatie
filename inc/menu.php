<?php 

// ophalen rol gebruiker 

$authRol = isset($_SESSION["rol"]) ? strtolower($_SESSION["rol"]) : '';
$inlognaam = isset($_SESSION["inlognaam"]) ? $_SESSION['inlognaam'] : '';

echo '<link rel="stylesheet" type="text/css" href="css/style.css"> ';
echo '<link rel="stylesheet" type="text/css" href="css/nav.css"> ';

// samenstellen menu 

$menu=''; 

// op basis van rol menu tonen 
switch ($authRol) {
    case 'beheerder':

        $menu = '<nav> 
                        <ul> 
                            <li><a href="index.php">Home</a></li> 
                            <li><a href="klanten.php">Klantgegevens</a></li> 
                            <li><a href="opdrachten.php">Opdrachten</a></li> 
                            <li> 
                                <a href="gebruikers.php" class="dropbtn">Beheer</a> 
                                <ul>
                                    <li><a href="gebruiker_new.php">Nieuwe gebruiker</a></li> 
                                    <li><a href="gebruikers.php">Gebruikersoverzicht</a></li> 
                                </ul> 
                            </li> 
                            <li><a href="#">Contact</a></li> 
                            <li><a href="uitloggen.php">Uitloggen</a></li> 
                        </ul> 
                        </nav>'; 
        break;
    case 'administratie':
        $menu = '<nav>
                    <ul>
                        <li><a href="index.php">Home</a></li> 
                        <li><a href="klanten.php">Klantgegevens</a></li> 
                        <li><a href="opdrachten.php">Opdrachten</a></li> 
                        <li><a href="#">Contact</a></li> 
                        <li><a href="uitloggen.php">Uitloggen</a></li> 
                    </ul>
                  </nav>
        ';
        break;
    case 'planner':
        $menu = '<nav>
                        <ul>
                            <li><a href="index.php">Home</a></li> 
                            <li><a href="klanten.php">Klantgegevens</a></li> 
                            <li><a href="opdrachten.php">Opdrachten</a></li> 
                            <li><a href="#">Contact</a></li> 
                            <li><a href="uitloggen.php">Uitloggen</a></li> 
                        </ul>
                    </nav>
            ';
        break;
    case 'klantrelaties':
        $menu = '<nav>
                        <ul>
                            <li><a href="index.php">Home</a></li> 
                            <li><a href="klanten.php">Klantgegevens</a></li> 
                            <li><a href="opdrachten.php">Opdrachten</a></li> 
                            <li><a href="#">Contact</a></li> 
                            <li><a href="uitloggen.php">Uitloggen</a></li> 
                        </ul>
                    </nav>
            ';
        break;
    default:
        $menu = '';
}

echo $menu; 

?> 