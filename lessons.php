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
        <?php     require_once("php/sessionstart.php"); ?>
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
                echo "<a href='modpage.php?search='''>Moderator Tools</a>";
            }
            echo "<a href='php/logout.php'>Logout</a>";
        }
        else {
            header("location:mainpage.php");
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
            ?>
            </section>
            <?php
        //Variable Declaration for the 3 slideshows
        $myLessonsLessonID = [];
        $myLessonsTitle = [];
        $myLessonspfpID = [];
        $myLessonsDesc = [];

        $enrolledLessonsLessonID = [];
        $enrolledLessonsTitle = [];
        $enrolledLessonspfpID = [];
        $enrolledLessonsDesc = [];


        //For myLessons, selects lessonid if we are the creator, then saves their title, id, and pfpid into arrays
        $anyResults = false;
        $sql = "SELECT lessonid FROM createdlessons where username = '$username'";
        $result = mysqli_query($connection,$sql);
        while($row = mysqli_fetch_assoc($result)) {
            $anyResults = true;
            $lessonId = $row['lessonid'];
            $myLessonsLessonID[] = $lessonId;
            $sql = "SELECT `title`,`pfpid`, `description` FROM lesson where lessonid = '$lessonId'";
            $lessonRow = mysqli_fetch_assoc(mysqli_query($connection, $sql));
            $myLessonsTitle[] = $lessonRow['title'];
            $myLessonspfpID[] = $lessonRow['pfpid'];
            $myLessonsDesc[] = $lessonRow['description'];
        }
        //if no results detected, show error

        //For Enrolled, selects lessonid if we are enrolled, then saves their title, id, and pfpid into arrays
        $anyResults = false;
        $sql = "SELECT `lessonid` FROM enrolledlessons WHERE username = '$username'";
        $result = mysqli_query($connection,$sql);
        while($row = mysqli_fetch_assoc($result)) {
            $anyResults = true;
            $lessonId = $row['lessonid'];
            $enrolledLessonsLessonID[] = $lessonId;
            $sql = "SELECT `title`,`pfpid`,`description` FROM lesson where lessonid = '$lessonId'";
            $lessonRow = mysqli_fetch_assoc(mysqli_query($connection, $sql));
            $enrolledLessonsTitle[] = $lessonRow['title'];
            $enrolledLessonspfpID[] = $lessonRow['pfpid'];
            $enrolledLessonsDesc[] = $lessonRow['description'];
        }
        $enrolledLessonsLessonID = array_values(array_diff($enrolledLessonsLessonID,$myLessonsLessonID));
        $enrolledLessonsTitle = array_values(array_diff($enrolledLessonsTitle,$myLessonsTitle));
        $enrolledLessonspfpID = array_values(array_diff($enrolledLessonspfpID,$myLessonspfpID));
        $enrolledLessonsDesc = array_values(array_diff($enrolledLessonsDesc,$myLessonsDesc));
        //if no results detected, show error
        echo "<h1 style='color:#FAF3E0'>My Lessons</h1>";
        $run = false;
        for($i = 0; $i < count($myLessonsLessonID); $i++) {
            $run = true;
            echo("
            <section class='infopanel-small'>
            <a href = 'lesson.php?lessonid=".$myLessonsLessonID[$i]."'>
            <img class='cImage' src='/rdecrewe/themancerzone/php/image.php?pfpid=".$myLessonspfpID[$i]."' alt='pfp'>
            </a>
            <div class='textpanel'>
                <div class='nameheader'>
                    <h1><a href = 'lesson.php?lessonid=".$myLessonsLessonID[$i]."'>$myLessonsTitle[$i]</a></h1>
                </div>
                <p>$myLessonsDesc[$i]</p>
            </div>
        </section>");
        }
        if(!$run){
            echo"<h2 style='color:#FAF3E0'>No currently created lessons, go to your profile and created some!</h2>";
        }
        $run = false;
        echo "<h1 style='color:#FAF3E0'>Enrolled Lessons</h1>";
        for($i = 0; $i < count($enrolledLessonsLessonID); $i++) {
            $run = true;
            echo("
            <section class='infopanel-small'>
            <a href = 'lesson.php?lessonid=".$enrolledLessonsLessonID[$i]."'>
            <img class='cImage' src='/rdecrewe/themancerzone/php/image.php?pfpid=".$enrolledLessonspfpID[$i]."' alt='pfp'>
            </a>
            <div class='textpanel'>
                <div class='nameheader'>
                    <h1><a href = 'lesson.php?lessonid=".$enrolledLessonsLessonID[$i]."'>$enrolledLessonsTitle[$i]</a></h1>
                </div>
                <p>$enrolledLessonsDesc[$i]</p>
            </div>
        </section>");}
        if(!$run){
            echo"<h2 style='color:#FAF3E0'>No currently enrolled lessons, go find one you are interested in!</h2>";
        }
        ?>
        </main>
    </div>
    <footer class = "footer">
        <h2>Wizard Co.</h2>
    </footer>
    </body>
</html>
