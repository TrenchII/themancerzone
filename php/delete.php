<?php
require_once('connectDB.php');
if($_SERVER['REQUEST_METHOD'] == 'GET') {
    if(isset($_GET['lessonid'])) {
        $lessonid = $_GET['lessonid'];
        $sql = "START TRANSACTION";
        mysqli_query($connection,$sql);
        $sql = "DELETE FROM createdlessons WHERE lessonid='$lessonid'";
        mysqli_query($connection,$sql);
        $sql = "DELETE FROM enrolledlessons WHERE lessonid='$lessonid'";
        mysqli_query($connection,$sql);
        $sql = "COMMIT";
        mysqli_query($connection,$sql);
        $sql = "START TRANSACTION";
        mysqli_query($connection,$sql);
        $sql = "DELETE FROM lesson WHERE lessonid='$lessonid'";
        mysqli_query($connection,$sql);
        $sql = "COMMIT";
        mysqli_query($connection,$sql);
        header('location:/themancerzone/mainpage.php');
        die();
    }
}
header('location:'.$_SERVER['HTTP_REFERER']);
?>