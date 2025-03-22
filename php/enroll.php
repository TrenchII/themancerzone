<?php
require_once('connectDB.php');
if(isset($_GET['username']) && isset($_GET['lessonid'])) {
    $username = $_GET['username'];
    $lessonid = $_GET['lessonid'];
    $sql = "START TRANSACTION";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO createdlessons (`username`, `lessonid`) VALUES ('$username','$lessonid')";
    mysqli_query($connection,$sql);
    $sql = "COMMIT";
    if(mysqli_query($connection,$sql)) {
        header("Location:/themancerzone/lesson.php?lessonid='$lessonid");
    }
    else {
        header('Location:/themancerzone/mainpage.php');
    }
}
else {
    header('Location:/themancerzone/mainpage.php');
}
?>