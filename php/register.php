<!DOCTYPE html>
<html>


<?php

require_once 'connectDB.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $alreadyexists = false;
    //echo "<p>Succesfully connected to database!</p>";
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
        echo "<p>User already exists with this name and/or email</p>";
        echo "<a href='" . $_SERVER['HTTP_REFERER'] . "'> Return to user entry</a>";
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
        mysqli_query($connection, $sql);
        /*  $sql = "SELECT `image`,`type` FROM pfp WHERE pfpid = '$pfpid'";
        $result = mysqli_query($connection, $sql);
        $row = mysqli_fetch_assoc($result);
        ob_end_clean();
        header("Content-type: " . $row['type']);
        $di = base64_decode($row['image']);
        echo($di);
        */
        echo "<img src='image.php?pfpid=".$pfpid."'/>";
    }
}
else {
    //echo 'ERROR! Bad Request Method Detected';
}
    mysqli_close($connection);


?>
</html>
