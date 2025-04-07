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
    <script src="./js/sendmessage.js" defer></script>
    <script src="./js/messagecount.js" defer></script>
    <script src="./js/sparkle_effect.js" defer></script>
</head>

<body>
    <div class="maincontent">
        <div id="mySidenav" class="sidenav">
            <?php
            require_once('php/sessionstart.php');
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
            <section class='filler'></section>
            <form id="form" action="php/message.php" method="post" novalidate>
                <section class="formbox">
                    <h1>Send a Message</h1>
                    <div class="formboxlabel">
                        <p class='inputlabel'>Your Message</p>
                        <div style="width:100%">
                            <input type="text" class="desc" name='message' placeholder="Send a quick message!" required>
                        </div>
                        <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                            if (isset($_GET['rusername'])) {
                                echo "<input type='hidden' name='rusername' value='" . $_GET['rusername'] . "'>";
                            } else {
                                header("location:" . $_SERVER['HTTP_REFERER']);
                            }

                        } else {
                            header("location:" . $_SERVER['HTTP_REFERER']);
                        }
                        ?>

                    </div>
                    <input type="submit" class="toolbutton submit" value="Submit">
            </form>
            </section>
        </main>
    </div>
    <footer class="footer">
        <h2>Wizard Co.</h2>
    </footer>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/db5bcca7bf.js" crossorigin="anonymous"></script>
    <script src="./js/main.js"></script>
    <script src="./js/message.js"></script>
</body>
</html>
