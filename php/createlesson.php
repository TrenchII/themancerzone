<?php
require_once 'connectDB.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(!isset($_SESSION['username'])) {
        header('Location:/themancerzone/mainpage.php');
        die();
    }
    $username = $_SESSION['username'];
    $title = mysqli_real_escape_string($connection,$_POST['title']);
    $desc = mysqli_real_escape_string($connection,$_POST['desc']);
    $date = explode("/",mysqli_real_escape_string($connection,$_POST['date']));
    $time = explode (":",mysqli_real_escape_string($connection,$_POST['time']));
    $datetime = $date[2] . "-" . $date[0] . "-" . $date[1] . " " . $time[0] . ":" . $time[1] . ":00";

    $img = $_FILES['img']['tmp_name'];
    $filetype = $_FILES['img']['type'];
    $imgdata = base64_encode(file_get_contents($img));

    $keywords = "";
    $schools = "";

    foreach( $_POST as $key => $value) {
        if (!($key == 'title' || $key == 'desc' || $key == 'date'|| $key == 'time')) {
            $charArray = str_split($key);
            switch ($charArray[0]) {
                case 'k':
                    $keywords = $keywords . preg_replace('/^./', '', $key) . ", ";
                    break;
                case 's':
                    $schools =  $schools .  preg_replace('/^./', '', $key) . ", ";
                    break;
                default:
                    echo "SHOULD NOT BE SEEING!";
                    break;
            }
        }
    }
    $keywords = rtrim($keywords,", ");
    $schools = rtrim($schools,", ");
    $sql = "START TRANSACTION";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO pfp (`image`,`type`) VALUES ('$imgdata','$filetype')";
    mysqli_query($connection, $sql);
    $pfpid = mysqli_insert_id($connection);
    $sql = "INSERT INTO lesson (`title`, `description`,`keyword`,`school`,`date`,`pfpid`) VALUES ('$title','$desc','$keywords','$schools','$datetime','$pfpid')";
    mysqli_query($connection, $sql);
    $lessonid = mysqli_insert_id($connection);
    $sql = "INSERT INTO createdlessons (`lessonid`,`username`) VALUES ('$lessonid','$username')";
    mysqli_query($connection,$sql);
    $sql = "INSERT INTO enrolledlessons (`lessonid`, `username`) VALUES ('$lessonid','$username')";
    mysqli_query($connection,$sql);
    $sql = "COMMIT";
    mysqli_query($connection, $sql);
    header ('Location:/themancerzone/lesson.php?lessonid='.$lessonid);
    
}

?>