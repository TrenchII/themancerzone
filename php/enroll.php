<?php
session_start();
require_once('connectDB.php');
if(isset($_SESSION['username']) && isset($_GET['lessonid'])) {
    $username = $_SESSION['username'];
    $lessonid = $_GET['lessonid'];
    $sql = "START TRANSACTION";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO enrolledlessons (`username`, `lessonid`) VALUES ('$username','$lessonid')";
    mysqli_query($connection,$sql);
    $sql = "COMMIT";
    if(mysqli_query($connection,$sql)) {
        header("Location:/rdecrewe/themancerzone/lesson.php?lessonid=$lessonid");
    }
    else {
        header('Location:/rdecrewe/themancerzone/mainpage.php');
    }
}
else {
    header('Location:/rdecrewe/themancerzone/mainpage.php');
}
mysqli_close($connection);
?>