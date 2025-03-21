<?php
require_once 'connectDB.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $title = $_POST['title'];
    $desc = $_POST['desc'];
    $date = explode("/",$_POST['date']);
    $time = explode (":",$_POST['time']);
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
                    $keywords = $keywords . $key . ",";
                    break;
                case 's':
                    $schools =  $schools . $key . ",";
                    break;
                default:
                    echo "SHOULD NOT BE SEEING!";
                    break;
            }
        }
    }
    $sql = "START TRANSACTION";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO pfp (`image`,`type`) VALUES ('$imgdata','$filetype')";
    mysqli_query($connection, $sql);
    $pfpid = mysqli_insert_id($connection);
    $sql = "INSERT INTO lesson (`title`, `description`,`keyword`,`school`,`date`,`pfpid`) VALUES ('$title','$desc','$keywords','$schools','$datetime','$pfpid')";
    mysqli_query($connection, $sql);
    $sql = "COMMIT";
    mysqli_query($connection, $sql);
    
}

?>