<!DOCTYPE html>
<html>


<?php

require_once 'connectDB.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $alreadyexists = false;
    $displayname = mysqli_real_escape_string($connection,$_POST['displayname']);
    $username = mysqli_real_escape_string($connection,$_POST['username']);
    $pword = mysqli_real_escape_string($connection,$_POST['password']);
    $img = $_FILES['img']['tmp_name'];
    $filetype = $_FILES['img']['type'];
    $imgdata = base64_encode(file_get_contents($img));
    $sql = "SELECT username FROM users WHERE username = '$username'";


    if (mysqli_num_rows($result = mysqli_query($connection, $sql)) != 0) {
        $alreadyexists = true;
    }

    if($alreadyexists) {
        header("Location:/themancerzone/signuppage.php?failed=true&failtext=Sorry, an account with this name already exists, please choose a different one!");
    }
    else {
        $sql = "START TRANSACTION";
        mysqli_query($connection, $sql);

        $sql = "INSERT INTO pfp (`image`, `type`) VALUES ('$imgdata','$filetype')";
        mysqli_query($connection, $sql);
        $sql = "SELECT pfpid FROM pfp WHERE";
        $pwordhash = md5($pword);
        $pfpid = mysqli_insert_id($connection);
        $sql = "INSERT INTO users (`displayname`,`username`, `password`, `pfpid`, `privileges`) VALUES ('$displayname','$username','$pwordhash','$pfpid',0)";
        mysqli_query($connection, $sql);
        $sql = "COMMIT";
        if(mysqli_query($connection, $sql)) {
            echo "<img src='image.php?pfpid=".$pfpid."'/>";
            session_start();
            if (!isset($_SESSION['username'])) {
                $_SESSION['username'] = $username;
            }
        }
        header("Location:/themancerzone/mainpage.php");
    }
}
else {
    header("Location:/themancerzone/signuppage.php?failed=true&failtext=Incorrect Request Method, please contact website owner to report errror");
}
    mysqli_close($connection);


?>
</html>
