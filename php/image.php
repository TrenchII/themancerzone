<?php
require_once 'connectDB.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $pfpid = $_GET['pfpid'];
    $sql = "SELECT `image`, `type` FROM pfp WHERE pfpid = '$pfpid'";
    $row = mysqli_fetch_assoc(mysqli_query($connection, $sql));
    $decodedimage = base64_decode($row['image']);
    $type = $row['type'];
    ob_end_clean();
    header("Content-type: " . $type);
    echo $decodedimage;
}
else {
    echo "Bad request type, wuh oh!";
}

?>