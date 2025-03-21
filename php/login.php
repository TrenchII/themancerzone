<!DOCTYPE html>
<html>


<?php

require_once 'connectDB.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $exists = false;
    echo "<p>Succesfully connected to database!</p>";
    $username = mysqli_real_escape_string($connection,$_POST['username']);
    $pword = mysqli_real_escape_string($connection,$_POST['password']);
    $sql = "SELECT COUNT(username) FROM users WHERE username = '$username'";

    $result = mysqli_query($connection, $sql);

    if (mysqli_num_rows($result = mysqli_query($connection, $sql)) != 0) {
        $exists = true;
    }

    if(!$exists) {
        echo "<p>No User Exists</p>";
        echo "<a href='" . $_SERVER['HTTP_REFERER'] . "'> Return to user entry</a>";
    }
    else {
        $sql = "SELECT password FROM users WHERE username = '$username'";
        $result = mysqli_query($connection, $sql);
        $row = mysqli_fetch_assoc($result);
        if($row['password'] = md5($pword)) {
            echo "<p> Hello, " . $username . ", you are now logged in!";
            echo "<a href='" . $_SERVER['HTTP_REFERER'] . "'> Return to user entry</a>";
        }
        else {
            echo "<p> Incorrect Pasword </p>";
            echo "<a href='" . $_SERVER['HTTP_REFERER'] . "'> Return to user entry</a>";
        }
    }
}
else {
    echo 'ERROR! Bad Request Method Detected';
}
    mysqli_close($connection);


?>
</html>
