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
</head>

<body>
    <?php session_start();
    require_once 'php/connectDB.php';
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
    }
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (isset($_GET['username'])) {
            $profileusername = $_GET['username'];
            $sql = "SELECT COUNT(username) FROM users WHERE username = '$profileusername'";
            $result = mysqli_query($connection, $sql);
            $row = mysqli_fetch_assoc($result);
            if ($row['COUNT(username)'] == 0) {
                header("Location:/themancerzone/mainpage.php");
            }
            $sql = "SELECT `displayname`, `pfpid` FROM users WHERE username = '$profileusername'";
            $result = mysqli_query($connection, $sql);
            $row = mysqli_fetch_assoc($result);
            $displayname = $row['displayname'];
            $pfpid = $row['pfpid'];

            $sql = "SELECT lessonid FROM createdlessons WHERE username = '$profileusername'";
            $result = mysqli_query($connection, $sql);
        } else {
            header("Location:/themancerzone/mainpage.php");
        }
    } else {
        header("Location:/themancerzone/mainpage.php");
    } ?>
    <div class="maincontent">
        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <a href="profile.php?username=<?php echo $username ?>">Profile</a>
            <a href="lessons.html">Lessons</a>
            <a href="inbox.html">Inbox</a>
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
                    <img class="onetoone" <?php echo "src='/themancerzone/php/image.php?pfpid=" . $pfpid . "'"; ?>
                        alt="pfp">
                </div>
                <div class="textpanel">
                    <?php
                    echo "<div class='nameheader'><h1>$profileusername</h1>";
                    if (isset($username)) {
                        if ($username == $profileusername) {
                            echo "<p class='toolbutton'><a href='profiledit.php?username=" . $username . "'>Edit</a></p>";
                        }
                        if ($privileges == 1) {
                            echo "<p class='toolbutton'><a href='modpage.html'>Moderator Tools</a></p>";
                        }
                    }
                    echo "</div>";
                    ?>
                </div>
            </section>
            <?php
            //Variable Declaration for the 3 slideshows
            $lessonsPopularLessonID = [];
            $lessonsPopularTitle = [];
            $lessonsPopularpfpID = [];

            //For Popular, selects lessonid by total amount of enrollments, then saves their title, id, and pfpid into arrays
            $anyResults = false;
            $sql = "SELECT COUNT(lessonid), lessonid FROM createdlessons WHERE username = '$profileusername' GROUP BY lessonid ORDER BY COUNT(lessonid) DESC LIMIT 12";
            $result = mysqli_query($connection, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $anyResults = true;
                $lessonId = $row['lessonid'];
                $lessonsPopularLessonID[] = $lessonId;
                $sql = "SELECT `title`,`pfpid` FROM lesson where lessonid = '$lessonId'";
                $lessonRow = mysqli_fetch_assoc(mysqli_query($connection, $sql));
                $lessonsPopularTitle[] = $lessonRow['title'];
                $lessonsPopularpfpID[] = $lessonRow['pfpid'];
            }
            //if no results detected, show error
            if (!$anyResults) {
                echo"<h1 style='color:white'>No Lessons created, yet....?</h1>";
            }
            else{
            //When less than 12 records returned, duplicates given records until we have 12 (enough to fill slideshow)
            $length = count($lessonsPopularLessonID);
            while ($length < 12) {
                for ($i = 0; $i < $length; $i++) {
                    $lessonsPopularLessonID[] = $lessonsPopularLessonID[$i];
                    $lessonsPopularpfpID[] = $lessonsPopularpfpID[$i];
                    $lessonsPopularTitle[] = $lessonsPopularTitle[$i];
                }
                $length = count($lessonsPopularLessonID);
            }
            ;

            //Due to overshoot when doubling, slice back down to 12 
            $lessonsPopularLessonID = array_slice($lessonsPopularLessonID, 0, 12);
            $lessonsPopularpfpID = array_slice($lessonsPopularpfpID, 0, 12);
            $lessonsPopularTitle = array_slice($lessonsPopularTitle, 0, 12);
            echo ("<section class = 'main-gallery-small'>
                <div id='carouselControl1' class='carousel slide' data-interval='0'>
                    <h1>Popular Lessons</h1>
                    <div class='carousel-inner'>
                    <div class='carousel-item active'>
                        <div class='multislide'>
                            <div class='captionpair'>
                                <a href = 'lesson.php?lessonid=" . $lessonsPopularLessonID[0] . "'><img class='cImage' src='/themancerzone/php/image.php?pfpid=" . $lessonsPopularpfpID[0] . "' alt='" . $lessonsPopularTitle[0] . "'></a>
                                <p>" . $lessonsPopularTitle[0] . "</p>
                            </div>
                            <div class='captionpair'>
                                <a href = 'lesson.php?lessonid=" . $lessonsPopularLessonID[1] . "'><img class='cImage' src='/themancerzone/php/image.php?pfpid=" . $lessonsPopularpfpID[1] . "' alt='" . $lessonsPopularTitle[1] . "'></a>
                                <p>" . $lessonsPopularTitle[1] . "</p>
                            </div>
                            <div class='captionpair'>
                                <a href = 'lesson.php?lessonid=" . $lessonsPopularLessonID[2] . "'><img class='cImage' src='/themancerzone/php/image.php?pfpid=" . $lessonsPopularpfpID[2] . "' alt='" . $lessonsPopularTitle[2] . "'></a>
                                <p>" . $lessonsPopularTitle[2] . "</p>
                            </div>
                            <div class='captionpair'>
                                <a href = 'lesson.php?lessonid=" . $lessonsPopularLessonID[3] . "'><img class='cImage' src='/themancerzone/php/image.php?pfpid=" . $lessonsPopularpfpID[3] . "' alt='" . $lessonsPopularTitle[3] . "'></a>
                                <p>" . $lessonsPopularTitle[3] . "</p>
                            </div>
                        </div>
                      </div>
                      <div class='carousel-item'>
                        <div class='multislide'>
                            <div class='captionpair'>
                                <a href = 'lesson.php?lessonid=" . $lessonsPopularLessonID[4] . "'><img class='cImage' src='/themancerzone/php/image.php?pfpid=" . $lessonsPopularpfpID[4] . "' alt='" . $lessonsPopularTitle[4] . "'></a>
                                <p>" . $lessonsPopularTitle[4] . "</p>
                            </div>
                            <div class='captionpair'>
                                <a href = 'lesson.php?lessonid=" . $lessonsPopularLessonID[5] . "'><img class='cImage' src='/themancerzone/php/image.php?pfpid=" . $lessonsPopularpfpID[5] . "' alt='" . $lessonsPopularTitle[5] . "'></a>
                                <p>" . $lessonsPopularTitle[5] . "</p>
                            </div>
                            <div class='captionpair'>
                                <a href = 'lesson.php?lessonid=" . $lessonsPopularLessonID[6] . "'><img class='cImage' src='/themancerzone/php/image.php?pfpid=" . $lessonsPopularpfpID[6] . "' alt='" . $lessonsPopularTitle[6] . "'></a>
                                <p>" . $lessonsPopularTitle[6] . "</p>
                            </div>
                            <div class='captionpair'>
                                <a href = 'lesson.php?lessonid=" . $lessonsPopularLessonID[7] . "'><img class='cImage' src='/themancerzone/php/image.php?pfpid=" . $lessonsPopularpfpID[7] . "' alt='" . $lessonsPopularTitle[7] . "'></a>
                                <p>" . $lessonsPopularTitle[7] . "</p>
                            </div>
                        </div>
                      </div>
                      <div class='carousel-item'>
                        <div class='multislide'>
                            <div class='captionpair'>
                                <a href = 'lesson.php?lessonid=" . $lessonsPopularLessonID[8] . "'><img class='cImage' src='/themancerzone/php/image.php?pfpid=" . $lessonsPopularpfpID[8] . "' alt='" . $lessonsPopularTitle[8] . "'></a>
                                <p>" . $lessonsPopularTitle[8] . "</p>
                            </div>
                            <div class='captionpair'>
                                <a href = 'lesson.php?lessonid=" . $lessonsPopularLessonID[9] . "'><img class='cImage' src='/themancerzone/php/image.php?pfpid=" . $lessonsPopularpfpID[9] . "' alt='" . $lessonsPopularTitle[9] . "'></a>
                                <p>" . $lessonsPopularTitle[9] . "</p>
                            </div>
                            <div class='captionpair'>
                                <a href = 'lesson.php?lessonid=" . $lessonsPopularLessonID[10] . "'><img class='cImage' src='/themancerzone/php/image.php?pfpid=" . $lessonsPopularpfpID[10] . "' alt='" . $lessonsPopularTitle[10] . "'></a>
                                <p>" . $lessonsPopularTitle[10] . "</p>
                            </div>
                            <div class='captionpair'>
                                <a href = 'lesson.php?lessonid=" . $lessonsPopularLessonID[11] . "'><img class='cImage' src='/themancerzone/php/image.php?pfpid=" . $lessonsPopularpfpID[11] . "' alt='" . $lessonsPopularTitle[11] . "'></a>
                                <p>" . $lessonsPopularTitle[11] . "</p>
                            </div>
                        </div>
                      </div>
                    </div>
                            <a class='carousel-control-prev' href='#carouselControl1' role='button' data-slide='prev'>
                              <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                              <span class='sr-only'>Previous</span>
                            </a>
                            <a class='carousel-control-next' href='#carouselControl1' role='button' data-slide='next'>
                              <span class='carousel-control-next-icon' aria-hidden='true'></span>
                              <span class='sr-only'>Next</span>
                            </a>
                </div>             
            </section>"); }?>
            <section>
                <?php
                if(isset($username)) {
                    if($username == $profileusername) {
                        echo "<form action='createlesson.html'>";
                        echo"<button class='actionbutton' onclick='submit'>Create a Lesson</button>";
                        echo "</form>";
                    }
                }
                ?>
            </section>
        </main>
    </div>
    <footer class="footer">
        <h2>Wizard Co.</h2>
    </footer>
</body>

</html>