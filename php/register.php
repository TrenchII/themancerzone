<!DOCTYPE html>
<html>


<?php

require_once 'connectDB.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $alreadyexists = false;
    echo "<p>Succesfully connected to database!</p>";
    $displayname = mysqli_real_escape_string($connection,$_POST['displayname']);
    $username = mysqli_real_escape_string($connection,$_POST['username']);
    $pword = mysqli_real_escape_string($connection,$_POST['password']);
    $img = mysqli_real_escape_string($connection,$_FILES['pfpupload']['tmp_name']);
    $imgdata = file_get_contents($img);

    $sql = "SELECT COUNT(username) FROM users WHERE username = '$username'";

    $result = mysqli_query($connection, $sql);

    $row = mysqli_fetch_assoc($result);

    if ($row['COUNT(username)'] != 0) {
        $alreadyexists = true;
    }

    if($alreadyexists) {
        echo "<p>User already exists with this name and/or email</p>";
        echo "<a href='" . $_SERVER['HTTP_REFERER'] . "'> Return to user entry</a>";
    }
    else {
        $pwordhash = md5($pword);
        $sql = "INSERT INTO users (`username`, `email`, `password`, `firstname`, `lastname`) VALUES ('$username','$email','$pwordhash','$firstname','$lastname')";
        if (mysqli_query($connection, $sql)) {
            echo "An account for the user " . $username . " has been created!";
        }
        else {
            echo "An error in adding your account has been detected!";
        }
    }
}
else {
    echo 'ERROR! Bad Request Method Detected';
}
    mysqli_close($connection);


?>
</html>
