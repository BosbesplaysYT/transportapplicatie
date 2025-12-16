<?php
include("inc/header.php");
session_destroy();
session_unset();
header('refresh: 0; url=login.php');
exit();
?>