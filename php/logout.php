<?php
session_start();
session_unset();
session_destroy();
$redirect = "/themancerzone/mainpage.php";
header('Location: '.$redirect);
die();
?>