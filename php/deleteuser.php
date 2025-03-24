<?php
require_once('connectDB.php');
session_start();
if($_SERVER['REQUEST_METHOD'] == 'GET') {
    if(isset($_GET['username'])) {

        $username = $_GET['username'];

        $sql = "START TRANSACTION";
        mysqli_query($connection,$sql);


        $sql = "SELECT lessonid FROM createdlessons WHERE username='$username'";
        $result = mysqli_query($connection,$sql);
        while($row = mysqli_fetch_assoc($result)) {
            $lessonid = $row['lessonid'];

            $sql = "SELECT pfpid FROM lesson WHERE lessonid = '$lessonid'";
            $row2 = mysqli_fetch_assoc(mysqli_query($connection,$sql));
            $lessonpfpid=$row2['pfpid'];

            

            $sql = "SELECT imagename from pfp WHERE pfpid='$lessonpfpid'";
            $row3 = mysqli_fetch_assoc(mysqli_query($connection,$sql));

            unlink(realpath("../img/site/".$row3['imagename']));

            $sql = "DELETE FROM pfp WHERE pfpid='$lessonpfpid'";
            mysqli_query($connection,$sql);

            $sql = "DELETE FROM lesson WHERE lessonid = '$lessonid'";
            mysqli_query($connection,$sql);
        }

        $sql = "SELECT pfpid FROM users WHERE username='$username'";
        $result = mysqli_query($connection,$sql);
        $row = mysqli_fetch_assoc($result);
        $pfpid = $row['pfpid'];

        $sql = "SELECT imagename FROm pfp WHERE pfpid = '$pfpid'";
        $result= mysqli_query($connection,$sql);
        $row = mysqli_fetch_assoc($result);
        unlink(realpath("../img/site/".$row['imagename']));

        $sql = "DELETE FROM pfp WHERE pfpid='$pfpid'";
        mysqli_query($connection,$sql);

        $sql = "DELETE FROM users WHERE username='$username'";
        mysqli_query($connection,$sql);

        $sql = "COMMIT";
        mysqli_query($connection,$sql);
        if(isset($_SESSION['username'])) {
            if($_SESSION['username'] == $username){
                require_once('logout.php');
            }
        } 
        header('location:/rdecrewe/themancerzone/mainpage.php');
        mysqli_close($connection);
        die();
    }
}
header('location:'.$_SERVER['HTTP_REFERER']);
mysqli_close($connection);
?>