<?php 

session_start();

// include database.php 

require_once 'inc/database.php'; 

include 'fun/functions.php';

// controle ingelogd: 

include 'inc/check_login.php';

include_once 'inc/config.php';

// include menu 

include('inc/menu.php'); 

?> 