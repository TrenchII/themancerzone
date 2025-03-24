<?php
require_once 'connectDB.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(!isset($_SESSION['username'])) {
        header('Location:/rdecrewe/themancerzone/mainpage.php');
        mysqli_close($connection);
        die();
    }
    $username = $_SESSION['username'];
    $title = mysqli_real_escape_string($connection,$_POST['title']);
    $desc = mysqli_real_escape_string($connection,$_POST['desc']);
    $datetime = str_replace("T"," ", mysqli_real_escape_string($connection,$_POST['datetime']));
    $img = $_FILES['img']['tmp_name'];
    $filetext = $_FILES['img']['type'];
    $filetype = explode('/',$filetext)[1];
    $sql = "SELECT username FROM users WHERE username = '$username'";
    $uniqueid = '';
    do {
        $found = false;
        $uniqueid = uniqid();
        $sql = "SELECT COUNT(imagename) from pfp WHERE imagename='$uniqueid'";
        $result = mysqli_query($connection, $sql);
        $row = mysqli_fetch_assoc($result);
        if($row['COUNT(imagename)'] == 0) {
            $found = true;
        }
    }
    while(!$found);
    $imagename = $uniqueid . "." . $filetype;
    $imagedata = file_get_contents($img);
    file_put_contents("/home/rdecrewe/public_html/themancerzone/img/site/".$imagename,$imagedata);


    $keywords = "";
    $schools = "";

    foreach( $_POST as $key => $value) {
        if (!($key == 'title' || $key == 'desc' || $key == 'datetime')) {
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
    $sql = "INSERT INTO pfp (`imagename`) VALUES ('$imagename')";
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
    header ('Location:/rdecrewe/themancerzone/lesson.php?lessonid='.$lessonid);
    
}
mysqli_close($connection);
?>