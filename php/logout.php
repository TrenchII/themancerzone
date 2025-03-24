<?php
session_start();
session_unset();
session_destroy();
$redirect = "/rdecrewe/themancerzone/mainpage.php";
header('Location: '.$redirect);
die();
?>