<?php
session_start();
require_once("connectDB.php");
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $alreadyexists = false;
        $newusername = mysqli_real_escape_string($connection,$_POST['username']);
        $displayname = mysqli_real_escape_string($connection,$_POST['displayname']);
        $email = mysqli_real_escape_string($connection,$_POST['email']);
        $pword = md5(mysqli_real_escape_string($connection,$_POST['password']));


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
        file_put_contents("../img/site/".$imagename,$imagedata);


        $sql = "START TRANSACTION";
        mysqli_query($connection, $sql);
        $sql = "SELECT `pfpid` FROM users WHERE username = '$username'";
        $result = mysqli_query($connection, $sql);
        $row = mysqli_fetch_assoc($result);
        $pfpid = $row['pfpid'];

        $sql = "SELECT imagename from pfp where pfpid = '$pfpid'";
        $result = mysqli_query($connection, $sql);
        $oldimagename = mysqli_fetch_assoc($result)['imagename'];
        unlink("../img/site/".$oldimagename);
        $sql = "UPDATE pfp SET `imagename` = '$imagename' WHERE pfpid = '$pfpid'";
        mysqli_query($connection, $sql);

        $sql = "UPDATE users SET username = '$newusername', displayname = '$displayname', email='$email', `password`='$pword' WHERE username = '$username'";
        mysqli_query($connection, $sql);

        $sql = "COMMIT";
        mysqli_query($connection, $sql);

        session_unset();
        $_SESSION['username'] = $newusername;
        header('location:/themancerzone/profile.php?username='.$newusername);
    }
}
header('location:/themancerzone/mainpage.php');
mysqli_close($connection);
?>