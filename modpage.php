<!DOCTYPE html>
<html lang="en">
   <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>The 'Mancer Zone</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Josefin Sans' rel='stylesheet'>
    <link rel="stylesheet" href="./css/reset.css" />
    <link rel="stylesheet" href="./css/main.css" />
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous" defer></script>
    <script src="https://kit.fontawesome.com/db5bcca7bf.js" crossorigin="anonymous" defer></script>
    <script src="./js/main.js" defer></script>
    <script src="./js/signup.js" defer></script>
    <script src="./js/messagecount.js" defer></script>
    <script src="./js/sparkle_effect.js" defer></script>
   </head>
    <body>
    <div>
    <?php require_once("php/sessionstart.php"); ?>
    <div class="maincontent">
        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <?php
            if (isset($_SESSION['username'])) {
                $username = $_SESSION['username'];
                echo "<a href='profile.php?username=$username'?>Profile</a>";
                echo "<a href='lessons.php'>Lessons</a>";
                echo "<a href='inbox.php'>Inbox</a>";
                $sql = "SELECT privileges FROM users WHERE username = '$username'";
                $result = mysqli_query($connection, $sql);
                $row = mysqli_fetch_assoc($result);
                if ($row['privileges'] == 1) {
                    echo "<a href='modpage.php'>Moderator Tools</a>";
                }
                echo "<a href='php/logout.php'>Logout</a>";
            }
            ?>
        </div>
        <main id="main">
            <section class="main-heading">
                <?php
                if (isset($_SESSION['username'])) {
                    echo "<button class='sidebar-btn' onclick='openNav()'><i class='fa-solid fa-bars'></i></button>";
                } else {
                    echo "<button class='sidebar-btn' style='opacity:0%; cursor:auto;'><i class='fa-solid fa-bars'></i></button>";
                }
                ?>
                <h1 class="header-text"><a href='mainpage.php'>The 'Mancer Zone</a></h1>
                <?php
                if (isset($_SESSION['username'])) {
                    echo ("       
                <div class='logsign'>
                    <p><a href ='profile.php?username=$username'></a></p>
                    <p></p>
                    <p><a href ='profile.php?username=$username'>Hello, " . $_SESSION['username'] . "</a></p>
                </div>");
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
            <section class="search">
                <form id="searchform" action="/rdecrewe/themancerzone/modpage.php" method='POST' novalidate>
                    <input type="text" id="searchbox" name="search" placeholder="Start your Wizarding Search Today">
                    <button type="submit" form="searchform" class="searchbtn"><i
                            class="fa-solid fa-arrow-right"></i></button>
                </form>
            </section>
            <div id="lessons">
                <h1>Lessons</h1>
            </div>
            <?php
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                if (isset($_POST['search'])) {
                    $search = $_POST['search'];
                    $sql = "SELECT `lessonid`,`title`,`description`,`pfpid` FROM lesson WHERE title LIKE '%" . $search . "%'";
                    $result = mysqli_query($connection, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $lessonID = $row['lessonid'];
                            $title = $row['title'];
                            $description = $row['description'];
                            $pfpID = $row['pfpid'];
                            echo ("
                            <section class='infopanel-small'>
                            <a href = 'lesson.php?lessonid=" . $lessonID . "'>
                            <img class='cImage' src='/rdecrewe/themancerzone/php/image.php?pfpid=" . $pfpID . "' alt='pfp'>
                            </a>
                            <div class='textpanel'>
                                <div class='nameheader'>
                                    <h1><a href = 'lesson.php?lessonid=" . $lessonID . "'>$title</a></h1>
                                    <p class = 'toolbutton' style='color:red'><a href='php/deletelesson.php?lessonid=".$lessonID."'>Delete Lesson</a></p>
                                </div>
                                <p>$description</p>
                            </div>
                        </section>");
                        }
                    } else {
                        echo ("<h2 style='color:#FAF3E0'>No lessons found, are you sure you spelled everything correctly?</h2>");
                    }
                }
            }
            ?>

            <div id="teachers">
                <h1>Creators</h1>
            </div>
            <?php
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                if (isset($_POST['search'])) {
                    $search = $_POST['search'];
                    $sql = "SELECT `displayname`,`username`,`pfpid` FROM users WHERE displayname LIKE '%" . $search . "%'";
                    $result = mysqli_query($connection, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $profileusername = $row['username'];
                            $displayname = $row['displayname'];
                            $pfpID = $row['pfpid'];
                            echo ("
                            <section class='infopanel-small'>
                            <a href = 'profile.php?username=" . $profileusername . "'>
                            <img class='cImage' src='/rdecrewe/themancerzone/php/image.php?pfpid=" . $pfpID . "' alt='pfp'>
                            </a>
                            <div class='textpanel'>
                                <div class='nameheader'>
                                    <h1><a href = 'profile.php?username=" . $profileusername . "'>$displayname</a></h1>
                                    <p class = 'toolbutton' style='color:red'><a href='php/deleteuser.php?username=".$profileusername."'>Delete User</a></p>
                                </div>
                            </div>
                        </section>");
                        }
                    } else {
                        echo ("<h2 style='color:#FAF3E0'>No creators found, are you sure you spelled everything correctly?</h2>");
                    }
                }
            }
            ?>
            <div id="teachers">
                <h1>Messages</h1>
            </div>
            <?php
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                if (isset($_POST['search'])) {
                    $search = $_POST['search'];
                    $sql = "SELECT `rusername`,`susername`,`message`,`date` FROM `message` WHERE susername LIKE '%" . $search . "%'";
                    $result = mysqli_query($connection, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $rUserName = $row["rusername"];
                            $sUserName = $row["susername"];
                            $message = $row["message"];
                            $date = $row["date"];
                            echo ("<section class = 'message'>");
                            echo("<div class = 'infopanel-small'>
                                    <div style='text-align:left'>
                                    <p><a href='/rdecrewe/themancerzone/profile.php?username=".$rUserName."'><span style='font-weight: bold;'>From: </span>".$sUserName."</a>
                                    <span class = 'toolbutton' style='color:red'><a href='php/deletelesson.php?lessonid=".$lessonID."'>Delete Lesson</a></span></p>
                                    <p style='font-style:italic'>".$message."</p>
                                    <p style='color:#ada99b; font-style: italic;'>".$date."</div></div>");
                                    echo("
                                    </section>");
                        }
                    } else {
                        echo ("<h2 style='color:#FAF3E0,text-align:center'>No messages from this user found, are you sure you spelled everything correctly?</h2>");
                    }
                    echo("/div>");
                }
            }
            ?>

</div>
<footer class = "footer">
    <h2>Wizard Co.</h2>
</footer>
   </body>
</html>
