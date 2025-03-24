<!DOCTYPE html>
<html>


<?php

require_once 'connectDB.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $alreadyexists = false;
    $displayname = mysqli_real_escape_string($connection,$_POST['displayname']);
    $email = mysqli_real_escape_string($connection,$_POST['email']);
    $username = mysqli_real_escape_string($connection,$_POST['username']);
    $pword = mysqli_real_escape_string($connection,$_POST['password']);
    $img = $_FILES['img']['tmp_name'];
    $filetext = $_FILES['img']['type'];
    $filetype = explode('/',$filetext)[1];
    $sql = "SELECT username FROM users WHERE username = '$username'";
    $uniqueid = '';

    if (mysqli_num_rows($result = mysqli_query($connection, $sql)) != 0) {
        $alreadyexists = true;
    }

    if($alreadyexists) {
        header("Location:/rdecrewe/themancerzone/signuppage.php?failed=true&failtext=Sorry, an account with this name already exists, please choose a different one!");
    }
    else {
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
        file_put_contents(realpath("../img/site/".$imagename),$imagedata);


        $sql = "START TRANSACTION";
        mysqli_query($connection, $sql);

        $sql = "INSERT INTO pfp (`imagename`) VALUES ('$imagename')";
        mysqli_query($connection, $sql);
        $pfpid = mysqli_insert_id($connection);
        $pwordhash = md5($pword);
        $pfpid = mysqli_insert_id($connection);
        $sql = "INSERT INTO users (`displayname`,`username`,`email`, `password`, `pfpid`, `privileges`) VALUES ('$displayname','$username','$email','$pwordhash','$pfpid',0)";
        mysqli_query($connection, $sql);
        $sql = "COMMIT";
        if(mysqli_query($connection, $sql)) {
            session_start();
            if (!isset($_SESSION['username'])) {
                $_SESSION['username'] = $username;
            }
        }

        header("Location:/rdecrewe/themancerzone/mainpage.php");
    }
}
else {
    header("Location:/rdecrewe/themancerzone/signuppage.php?failed=true&failtext=Incorrect Request Method, please contact website owner to report errror");
}

    mysqli_close($connection);


?>
</html>
