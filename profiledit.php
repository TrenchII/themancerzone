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
    <?php require_once("php/sessionstart.php");
    if (!isset($_SESSION['username'])) {
        header('location:/rdecrewe/themancerzone/mainpage.php');
    }
    ?>


        <div class = "maincontent">
            <div id="mySidenav" class="sidenav">
                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                <?php
        if(isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
            echo "<a href='profile.php?username=$username'?>Profile</a>";
            echo "<a href='lessons.php'>Lessons</a>";
            echo "<a href='inbox.php'>Inbox</a>";
            $sql = "SELECT privileges FROM users WHERE username = '$username'";
            $result = mysqli_query($connection, $sql);
            $row = mysqli_fetch_assoc($result);
            if ($row['privileges'] == 1) {
                echo "<a href='modpage.html'>Moderator Tools</a>";
            }
            echo "<a href='php/logout.php'>Logout</a>";
        }
        ?>
              </div>
            <main id = "main">
                <section class="main-heading">
                <?php
            if(isset($_SESSION['username'])) {
                echo"<button class='sidebar-btn' onclick='openNav()'><i class='fa-solid fa-bars'></i></button>";
            }
            else {
                echo"<button class='sidebar-btn' style='opacity:0%; cursor:auto;'><i class='fa-solid fa-bars'></i></button>";
            }
            ?>
            <h1 class="header-text"><a href='mainpage.php'>The 'Mancer Zone</a></h1>
            <?php
            if(isset($_SESSION['username'])) {
                echo("       
                <div class='logsign'>
                    <p><a href ='profile.php?username=$username'></a></p>
                    <p></p>
                    <p><a href ='profile.php?username=$username'>Hello, ".$_SESSION['username']."</a></p>
                </div>");
            }
            else {
                echo("       
                <div class='logsign'>
                    <p><a href='loginpage.php'>Login</a></p>
                    <p>|</p>
                    <p><a href='signuppage.php'>Signup</a></p>
                </div>");
            }
            $sql = "SELECT `displayname`,`email`,`pfpid` FROM users WHERE username = '$username'";
            $result = mysqli_query($connection, $sql);
            $row = mysqli_fetch_assoc($result);
            $displayname = $row['displayname'];
            $email = $row['email'];
            echo "
                </section>
            </section>
            <section class = 'filler'></section>
            <form
            id='form'
            action='php/editprofile.php'
            method='post'
            enctype='multipart/form-data'
            novalidate>
            <section class='formbox'>
                <h1>Edit Profile</h1>
                <div class='formboxlabel'>
                    <p class = 'inputlabel'>Display Name</p>
                    <div style='width:100%'>
                        <input type='text' class='formcontrol' name='displayname' value='$displayname' required>
                    </div>
                    <p class = 'inputlabel'>Username</p>
                    <div style='width:100%'>
                        <input type='text' class='formcontrol' name='username' value='$username' required>
                    </div>
                    <p class = 'inputlabel'>Email</p>
                    <div style='width:100%'>
                        <input type='email' class='formcontrol' name='email' value='$email' required>
                    </div>
                    <p class = 'inputlabel'>Password</p>
                    <div style='width:100%'>
                        <input type='password' class='formcontrol'  name='password' placeholder='Enter your password' required>
                    </div>
                    <p class = 'inputlabel'>Re-enter Password</p>
                    <div style='width:100%'>
                        <input type='password' class='formcontrol' name='confirm_password' placeholder='Re-enter your password' required>
                    </div>
                    <div id='filesubmit'>
                        <p class = 'inputlabel'>Profile Picture</p>
                        <input type='file' id = 'img' name = 'img' accept='image/png,image/jpeg' required>
                    </div>               
                </div>
                "
                ?>
                <?php if(isset($_GET['failed'])) {
                    echo "<p style='color:red; font-weight:bold; text-align:center;'>".$_GET['failtext']."</p>";
                }?>
                <input type="submit" class="toolbutton submit" value="Submit">
            </form>
            </section>
        </main>
            </div>
    <footer class = "footer">
        <h2>Wizard Co.</h2>
    </footer>
    </body>
</html>
