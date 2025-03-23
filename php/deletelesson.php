<?php
require_once('connectDB.php');
if($_SERVER['REQUEST_METHOD'] == 'GET') {
    if(isset($_GET['lessonid'])) {
        $lessonid = $_GET['lessonid'];
        $sql = "START TRANSACTION";
        mysqli_query($connection,$sql);

        $sql = "SELECT pfpid FROM lesson WHERE lessonid=$lessonid";
        $result = mysqli_query($connection,$sql);

        $row = mysqli_fetch_assoc($result);
        $pfpid = $row['pfpid'];
        $sql = "DELETE FROM pfpid WHERE pfpid='$pfpid";

        $sql = "DELETE FROM lesson WHERE lessonid='$lessonid'";
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