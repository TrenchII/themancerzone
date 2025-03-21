<!DOCTYPE html>
<html>


<?php

require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $alreadyexists = false;
    echo "<p>Succesfully connected to database!</p>";
    $username = mysqli_real_escape_string($connection,$_POST['username']);
    $pword = md5(mysqli_real_escape_string($connection,$_POST['password']));

    $sql = "SELECT COUNT(username) FROM users WHERE username = '$username' and `password` = '$pword'";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);
    if ($row['COUNT(username)'] != 0) {
        echo "<p> User had a valid account </p>";
    }
    else {
        echo "<p> Username and/or password are invalid";
    }

}
else {
    echo 'ERROR! Bad Request Method Detected';
}
    mysqli_close($connection);


?>
</html>
