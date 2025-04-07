<!DOCTYPE html>
<html lang="en">
   <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>The 'Mancer Zone</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Josefin Sans' rel='stylesheet'>
    <link rel="stylesheet" href="./css/reset.css" />
    <link rel="stylesheet" href="./css/main.css" />
    <script src="./js/sparkle_effect.js" defer></script>
   </head>
    <body>
        <?php 
        session_start();
    session_unset();
    session_destroy();?>
        <div class = "maincontent">
        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <a href="profile.php">Profile</a>
            <a href="lessons.php">Lessons</a>
            <a href="inbox.php">Inbox</a>
            <a href="modpage.php">Moderator Tools</a>
          </div>
        <main id = "main">
            <section class="main-heading">
                <button class='sidebar-btn' style='opacity:0%; cursor:auto;'><i class='fa-solid fa-bars'></i></button>
                <h1 class="header-text"><a href='mainpage.php'>The 'Mancer Zone</a></h1>
                <div class="logsign">
                    <p><a href='loginpage.html'></a></p>
                    <p></p>
                    <p><a href='signuppage.php'>Signup</a></p>
                </div>
            </section>
            <section class = 'filler'></section>
            <form
            id="form"
            action="php/login.php"
            method="post"
            novalidate>
            <section class="formbox">
                <h1>Login</h1>
                <div class="formboxlabel">
                    <p class = 'inputlabel'>Username</p>
                    <div style="width:100%">
                        <input type="text" class="formcontrol" name="username" placeholder="Enter your Username" required>
                    </div>
                    <p class = 'inputlabel'>Password</p>
                    <div style="width:100%">
                        <input type="password" class="formcontrol" name="password" placeholder="Enter your Password" required>
                    </div>                  
                </div>
                <?php 
                if(isset($_GET['failed'])) {
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
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/db5bcca7bf.js" crossorigin="anonymous"></script>
        <script src="./js/main.js"></script>
        <script src="./js/login.js"></script>
    </body>
</html>
