<?php
require_once('sessionstart.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['username'])) {
        $susername = mysqli_real_escape_string($connection,$_SESSION['username']);
        $rusername = mysqli_real_escape_string($connection,$_POST['rusername']);
        $message = mysqli_real_escape_string($connection,$_POST['message']);
        date_default_timezone_set('America/Los_Angeles');
        $date = date('Y-m-d\TG:i');
        $sql = "START TRANSACTION";
        mysqli_query($connection,$sql);
        $sql = "INSERT INTO `message` (rusername,susername,`message`,`date`) VALUES ('$rusername','$susername','$message','$date')";
        mysqli_query($connection,$sql);
        $sql = "SELECT `messagecount` FROM `users` WHERE `username` = '$rusername";
        $result = mysqli_query($connection,$sql);
        $row = mysqli_fetch_assoc($result);
        while($row) {
            $messagecount = $row['messagecount'];
        } 
        $messagecount = $messagecount + 1;
        $sql = "UPDATE users SET `messagecount` = '$messagecount' WHERE `username` = '$rusername'";
        mysqli_query($connection,$sql);
        $sql = "COMMIT";
        mysqli_query($connection,$sql);
        header ('Location:/rdecrewe/themancerzone/profile.php?username='.$rusername);
        die();
    }
}
header ('Location:/rdecrewe/themancerzone/mainpage.php');
?>