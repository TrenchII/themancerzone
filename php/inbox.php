<?php
        require_once('sessionstart.php');
        $messages = [];
        $sUsername = [];
        $message = [];
        $date = [];
        if(isset($_SESSION["username"])) {
            $username = $_SESSION['username'];
            $sql = "SELECT `susername`, `message`, `date` FROM `message` WHERE rusername = '$username'";
            $result = mysqli_query($connection,$sql);
            while($row = mysqli_fetch_assoc($result)) {
                $sUsername[] = $row['susername'];
                $message[] = $row['message'];
                $date[] = $row['date'];
            }
        }
        else {
            header('location:/rdecrewe/themancerzone/mainpage.php');
        }
        $length = count($sUsername);
        for ($i = 0; $i < $length; $i++) {
            $messages[$i] = [
                "sUsername" => $sUsername[$i],
                "message" => $message[$i],
                "date" => $date[$i],
            ];
        }
        ob_end_clean();
        header('Content-type:application/json');
        echo json_encode($messages );
        ?>