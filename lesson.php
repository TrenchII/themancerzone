<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>The 'Mancer Zone</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Josefin Sans' rel='stylesheet'>
    <link rel="stylesheet" href="./css/reset.css" />
    <link rel="stylesheet" href="./css/main.css" />
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"
        defer></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"
        defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"
        defer></script>
    <script src="https://kit.fontawesome.com/db5bcca7bf.js" crossorigin="anonymous" defer></script>
    <script src="./js/main.js" defer></script>
    <script src="./js/signup.js" defer></script>
    <script src="./js/messagecount.js" defer></script>
    <script src="./js/sparkle_effect.js" defer></script>
</head>

<body>
    <?php 
    require_once("php/sessionstart.php");
    if(isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
    }
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (isset($_GET['lessonid'])) {
            $lessonid = $_GET['lessonid'];
            $sql = "SELECT COUNT(lessonid) FROM lesson WHERE lessonid = '$lessonid'";
            $result = mysqli_query($connection, $sql);
            $row = mysqli_fetch_assoc($result);
            if ($row['COUNT(lessonid)'] == 0) {
                header("Location:/rdecrewe/themancerzone/mainpage.php");
            }
            $sql = "SELECT `title`, `description`, `keyword`, `school`, `date`, `pfpid` FROM lesson WHERE lessonid = '$lessonid'";
            $result = mysqli_query($connection, $sql);
            $row = mysqli_fetch_assoc($result);
            $title = $row["title"];
            $description = $row["description"];
            $keywords = $row["keyword"];
            $school = $row["school"];
            $date = $row["date"];
            $pfpid = $row["pfpid"];

            $sql = "SELECT username FROM createdlessons WHERE lessonid = '$lessonid'";
            $result = mysqli_query($connection, $sql);
            $row = mysqli_fetch_assoc($result);

            $lessonusername = $row["username"];

            $sql = "SELECT displayname FROM users where username = '$lessonusername'";
            $result = mysqli_query($connection, $sql);
            $row = mysqli_fetch_assoc($result);
            $displayname = $row['displayname'];
        } else {
            header("Location:/rdecrewe/themancerzone/mainpage.php");
        }
    } else {
        header("Location:/rdecrewe/themancerzone/mainpage.php");
    } ?>
    <div class="maincontent">
        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <a href="profile.php?username=<?php echo $username?>">Profile</a>
            <a href="lessons.php">Lessons</a>
            <a href="inbox.php">Inbox</a>
            <?php
            if (isset($username)) {
                $sql = "SELECT privileges FROM users WHERE username = '$username'";
                $result = mysqli_query($connection, $sql);
                $row = mysqli_fetch_assoc($result);
                $privileges = $row['privileges'];
                if ($privileges == 1) {
                    echo "<a href='modpage.html'>Moderator Tools</a>";
                }
                echo "<a href='php/logout.php'>Logout</a>";
            } ?>
        </div>
        <main id="main">
            <section class="main-heading">
                <?php
                if (isset($username)) {
                    echo "<button class='sidebar-btn' onclick='openNav()'><i class='fa-solid fa-bars'></i></button>";
                } else {
                    echo "<button class='sidebar-btn' style='opacity:0%; cursor:auto;'><i class='fa-solid fa-bars'></i></button>";
                }
                ?>
                <h1 class="header-text"><a href='mainpage.php'>The 'Mancer Zone</a></h1>
                <?php
                if (isset($username)) {
                    echo ("       
                <div class='logsign'>
                    <p><a href ='profile.php'></a></p>
                    <p></p>
                    <p><a href ='profile.php?username=$username'>Hello, " . $username . "</a></p></div>");
                } else {
                    echo ("       
                <div class='logsign'>
                    <p><a href='loginpage.php'>Login</a></p>
                    <p>|</p>
                    <p><a href='signuppage.php'>Signup</a></p>
                </div>");
                }
                ?>
            </section>
            <section class="infopanel">
                <div class="onetoonediv">
                    <img class="onetoone" <?php echo "src='/rdecrewe/themancerzone/php/image.php?pfpid=" . $pfpid . "'"; ?>
                        alt="pfp">
                </div>
                <div class="textpanel">                
                        <?php
                        echo "<div class='nameheader'><h1>$title</h1>";
                        if (isset($username)) {
                            if ($username == $lessonusername) {
                                echo "<p class = 'toolbutton' style='color:red'><a href='php/deletelesson.php?lessonid=".$lessonid."'>Delete Lesson</a></p>";
                            }
                            if ($privileges == 1 && $username == $lessonusername) {
                                echo "<p class='toolbutton'><a href='modpage.html'>Moderator Tools</a></p>";
                            }
                            else if ($privileges == 1) {
                                echo "<p class='toolbutton'><a href='modpage.html'>Moderator Tools</a></p>";
                                echo "<p class = 'toolbutton' style='color:red'><a href='php/deletelesson.php?lessonid=".$lessonid."'>Delete Lesson</a></p>";
                            }
                        }
                        echo "</div>";
                        echo "<p>$description</p>";
                        ?>
                </div>
            </section>
            <section class="lessoninfo">
                <p><span style="font-weight: bold;">Instructor:</span>
                    <?php echo "<a href='profile.php?username=" . $lessonusername . "'>" . $displayname . "</a>"; ?></p>
                <?php
                if (isset($keywords)) {
                    if(strlen($keywords) > 0) {
                        echo "<p><span style='font-weight: bold;'>Keywords:</span> " . $keywords . "</p>";
                    }else {
                        echo "<p><span style='font-weight: bold;'>Keywords:</span> None</p>";
                    }
                    
                }
                if (isset($school)) {
                    if(strlen($school) > 0) {
                        echo "<p><span style='font-weight: bold;'>Schools:</span> " . $school . "</p>";
                    }
                    else {
                        echo "<p><span style='font-weight: bold;'>Schools:</span> None</p>";
                    }
                }
                $formattedDate = date("F jS, Y | g:i A", strtotime($date));
                echo "<p><span style='font-weight: bold;'>Date:</span> " . $formattedDate . "</p>"; ?>
            </section>
            <section>
                <?php
                echo "<form";
                if (isset($username)) {
                    $sql = "SELECT lessonid FROM createdlessons WHERE username = '$username' AND lessonid='$lessonid'";
                    $result = mysqli_query($connection, $sql);
                    $sql = "SELECT lessonid FROM enrolledlessons WHERE username = '$username' AND lessonid='$lessonid'";
                    $result1 = mysqli_query($connection, $sql);
                    if (mysqli_num_rows($result) == 0 && mysqli_num_rows($result1) == 0) {
                        echo " action='php/enroll.php'";
                        echo " method='get' novalidate>";
                        echo"<input type = 'hidden' name='lessonid' value ='".$lessonid."'>";
                        echo "<input type='submit' class='actionbutton submit'  value='Enroll'>";
                    }
                } else {
                    echo " action='loginpage.php'";
                    echo "method='get' novalidate>";
                    echo "<input type='submit' class='actionbutton submit'  value='Enroll'>";

                }
                echo "</form>";
                ?>
            </section>
        </main>
    </div>
    <footer class="footer">
        <h2>Wizard Co.</h2>
    </footer>
</body>

</html>