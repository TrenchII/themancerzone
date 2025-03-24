<?php
require_once 'connectDB.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $pfpid = $_GET['pfpid'];
    $sql = "SELECT `imagename` FROM pfp WHERE pfpid = '$pfpid'";
    $row = mysqli_fetch_assoc(mysqli_query($connection, $sql));
    $imagename = $row['imagename'];
    $type = '';
    $ext = strtolower(explode('.',$imagename)[1]);
    if ($ext == "jpg" || $ext == "jpeg") {
      $type = "image/jpeg";
    } else if ($ext == "png") {
      $type = "image/png";
    }
    ob_end_clean();
    header("Content-type: " . $type);
    echo file_get_contents("/home/rdecrewe/public_html/themancerzone/img/site/".$imagename);
}
else {
    echo "Bad request type, wuh oh!";
}
mysqli_close($connection);
?>