<?php
require_once('connectDB.php');
if($_SERVER['REQUEST_METHOD'] == 'GET') {
    if(isset($_GET['messageid'])) {
        $lessonid = $_GET['messageid'];
        $sql = "START TRANSACTION";
        mysqli_query($connection,$sql);

        $sql = "DELETE FROM message WHERE messageid='$messageid'";
        mysqli_query($connection,$sql);

        $sql = "COMMIT";
        mysqli_query($connection,$sql);

        header('location:/rdecrewe/themancerzone/modpage.php');
        mysqli_close($connection);
        die();
    }
}
header('location:/rdecrewe/themancerzone/modpage.php');
mysqli_close($connection);
?>
