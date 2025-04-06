<?php

        require_once('sessionstart.php');
        if(isset($_SESSION["username"])) {
            $username = $_SESSION['username'];
            $sql = "SELECT `messagecount` FROM `users` WHERE username = '$username'";
            $result = mysqli_query($connection,$sql);
            while($row = mysqli_fetch_assoc($result)) {
                $msg = $row['messagecount'];
                $messagecount = [$msg];
            }
        }
        else {
            header('location:/rdecrewe/themancerzone/mainpage.php');
        }
        ob_end_clean();
        header('Content-type:application/json');
        echo json_encode($messagecount);
        ?>