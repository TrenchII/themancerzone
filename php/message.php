<?php
require_once('sessionstart.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['username'])) {
        $susername = mysqli_real_escape_string($_SESSION['username']);
        $rusername = mysqli_real_escape_string($_POST['rusername']);
        $message = mysqli_real_escape_string($_POST['message']);
        date_default_timezone_set('America/Los_Angeles');
        $date = date('Y-m-d\TG:i');
        $sql = "START TRANSACTION";
        mysqli_query($connection,$sql);
        $sql = "INSERT INTO `message` (rusername,susername,`message`,`date`) VALUES ('$rusername','$susername','$message','$date')";
        mysqli_query($connection,$sql);
        $sql = "COMMIT";
        mysqli_query($connection,$sql);
        header ('Location:/rdecrewe/themancerzone/profile.php?username='.$rusername);
        die();
    }
}
header ('Location:/rdecrewe/themancerzone/mainpage.php');
?>