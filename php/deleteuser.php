<?php
require_once('connectDB.php');
if($_SERVER['REQUEST_METHOD'] == 'GET') {
    if(isset($_GET['username'])) {
        $lessonid = $_GET['lessonid'];

        $sql = "START TRANSACTION";
        mysqli_query($connection,$sql);

        $sql = "SELECT pfpid FROM users WHERE username=$username";
        $result = mysqli_query($connection,$sql);

        $row = mysqli_fetch_assoc($result);
        $pfpid = $row['pfpid'];
        $sql = "DELETE FROM pfpid WHERE pfpid='$pfpid";
        mysqli_query($connection,$sql);

        $sql = "DELETE FROM users WHERE username='$username'";
        mysqli_query($connection,$sql);

        $sql = "COMMIT";
        mysqli_query($connection,$sql);
        
        header('location:/themancerzone/mainpage.php');
        mysqli_close($connection);
        die();
    }
}
header('location:'.$_SERVER['HTTP_REFERER']);
mysqli_close($connection);
?>