<?php
require_once('sessionstart.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['username'])) {
        $susername = $_SESSION['username'];
        $rusername = $_POST['rusername'];
        $message = $_POST['message'];
        date_default_timezone_set('America/Los_Angeles');
        $date = date('Y-m-d\TG:i');
        $sql = "START TRANSACTION";
        mysqli_query($connection,$sql);
        $sql = "INSERT INTO `message` (rusername,susername,`message`,`date`) VALUES ('$rusername','$susername','$message','$date')";
        mysqli_query($connection,$sql);
        $sql = "COMMIT";
        mysqli_query($connection,$sql);
        header ('Location:/themancerzone/profile.php?username='.$rusername);
        die();
    }
}
header ('Location:/themancerzone/mainpage.php');
?>