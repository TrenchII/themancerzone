<!DOCTYPE html>
<html>


<?php
$host = "localhost";
$database = "themancerzone";
$user = "rdecrewe";
$password = "Syndrome1234567!";

$connection = mysqli_connect($host, $user, $password, $database);


$error = mysqli_connect_error();
if($error != null)
{
    $output = "<p>Unable to connect to database!</p>";
    exit($output);
}
?>
</html>