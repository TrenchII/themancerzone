<!DOCTYPE html>
<html>


<?php

require_once 'connectDB.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $exists = false;
    $username = mysqli_real_escape_string($connection,$_POST['username']);
    $pword = mysqli_real_escape_string($connection,$_POST['password']);
    $sql = "SELECT username FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);
    $pulledUsername = $row['username'];
    if (isset($row['username'])) {
        $exists = true;
    }
    if(!$exists) {
        header("Location:/themancerzone/loginpage.php?failed=true&failtext=Sorry, no account exists with this username, please try again!");
    }
    else {
        $sql = "SELECT `password` FROM users WHERE username = '$username'";
        $result = mysqli_query($connection, $sql);
        $row = mysqli_fetch_assoc($result);
        if($row['password'] == md5($pword)) {
            session_start();
            if (!isset($_SESSION['username'])) {
                $_SESSION['username'] = $pulledUsername;
            } 
            header('Location:/themancerzone/mainpage.php');
        }
        else {
            header("Location:/themancerzone/loginpage.php?failed=true&failtext=Sorry, this password does not match the username, please try again!");
        }
    }
}
else {
    header("Location:/themancerzone/signuppage.php?failed=true&failtext=Incorrect Request Method, please contact website owner to report errror");
}
    mysqli_close($connection);

?>
</html>
