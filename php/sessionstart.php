<?php
require_once("connectDB.php");
session_start();
if(isset($_SESSION["username"])) {
    $curuser = $_SESSION["username"];
    $sql = "SELECT COUNT(username) FROM users where username = '$curuser'";
    $row = mysqli_fetch_assoc(mysqli_query($connection,$sql));
    if($row['COUNT(username)'] == 0) {
        session_unset();
    }
}
?>