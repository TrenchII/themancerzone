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
   </head>
   <body>
    <?php session_start(); require_once 'php/connectDB.php';?>
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
            file_put_contents("./test.txt","hi");
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
        <section class = "search">
            <form 
            id = "searchform"
            action="/rdecrewe/themancerzone/search.php"
            method='POST' 
            novalidate>
            <input type="text" id = "searchbox" name="search" placeholder="Start your Wizarding Search Today">
            <button type="submit" form="searchform" class="searchbtn"><i class="fa-solid fa-arrow-right"></i></button>
            </form>
        </section>
        <?php
        //Variable Declaration for the 3 slideshows
        $lessonsPopularLessonID = [];
        $lessonsPopularTitle = [];
        $lessonsPopularpfpID = [];

        $lessonsSoonLessonID = [];
        $lessonsSoonTitle = [];
        $lessonsSoonpfpID = [];

        $creatorsuserName = [];
        $creatorsdisplayName = [];
        $creatorspfpID = [];

        //For Popular, selects lessonid by total amount of enrollments, then saves their title, id, and pfpid into arrays
        $anyResults = false;
        $sql = "SELECT COUNT(lessonid), lessonid FROM enrolledlessons GROUP BY lessonid ORDER BY COUNT(lessonid) DESC LIMIT 12";
        $result = mysqli_query($connection,$sql);
        while($row = mysqli_fetch_assoc($result)) {
            $anyResults = true;
            $lessonId = $row['lessonid'];
            $lessonsPopularLessonID[] = $lessonId;
            $sql = "SELECT `title`,`pfpid` FROM lesson where lessonid = '$lessonId'";
            $lessonRow = mysqli_fetch_assoc(mysqli_query($connection, $sql));
            $lessonsPopularTitle[] = $lessonRow['title'];
            $lessonsPopularpfpID[] = $lessonRow['pfpid'];
        }
        //if no results detected, show error
        if(!$anyResults) {
            die("<p style='color:white'>NO DATA IN DATABASE, ADD DATA TO DATABASE</p>");
        }

        //For Soon, gets title pfpid and lessonid sorted by their date ASC (ie. oldest (closest to now, dates first)) and puts them into arrays
        $anyResults = false;
        $sql = "SELECT `title`, `pfpid`, `lessonid` FROM lesson ORDER BY `date` ASC LIMIT 12";
        $result = mysqli_query($connection,$sql);
        while($row = mysqli_fetch_assoc($result)) {
            $anyResults = true;
            $lessonsSoonLessonID[] = $row['lessonid'];
            $lessonsSoonTitle[] = $row['title'];
            $lessonsSoonpfpID[] = $row['pfpid'];
        }
        //if no results detected, show error
        if(!$anyResults) {
            die("<p style='color:white'>NO DATA IN DATABASE, ADD DATA TO DATABASE</p>");
        }

        //For Soon, gets title pfpid and lessonid sorted by their date ASC (ie. oldest (closest to now, dates first)) and puts them into arrays
        $anyResults = false;
        $sql = "SELECT COUNT(lessonid), username FROM createdlessons GROUP BY username ORDER BY COUNT(lessonid) DESC LIMIT 12";
        $result = mysqli_query($connection,$sql);
        while($row = mysqli_fetch_assoc($result)) {
            $anyResults = true;
            $username = $row['username'];
            $creatorsuserName[] = $username;
            $sql = "SELECT `displayname`,`pfpid` FROM users where username = '$username'";
            $userRow = mysqli_fetch_assoc(mysqli_query($connection, $sql));
            $creatorsdisplayName[] = $userRow['displayname'];
            $creatorspfpID[] = $userRow['pfpid'];
        }
        //if no results detected, show error
        if(!$anyResults) {
            die("<p style='color:white'>NO DATA IN DATABASE, ADD DATA TO DATABASE</p>");
        }

        //When less than 12 records returned, duplicates given records until we have 12 (enough to fill slideshow)
        $length = count($creatorsuserName);
        while($length < 12) {
            for ($i = 0 ; $i < $length; $i++) {
                $lessonsPopularLessonID[] = $lessonsPopularLessonID[$i];
                $lessonsPopularpfpID[] = $lessonsPopularpfpID[$i];
                $lessonsPopularTitle[] = $lessonsPopularTitle[$i];

                $lessonsSoonLessonID[] = $lessonsSoonLessonID[$i];
                $lessonsSoonTitle[] = $lessonsSoonTitle[$i];
                $lessonsSoonpfpID[] = $lessonsSoonpfpID[$i];

                $creatorsuserName[] = $creatorsuserName[$i];
                $creatorsdisplayName[] = $creatorsdisplayName[$i];
                $creatorspfpID[] = $creatorspfpID[$i];

            }
                $length = count($creatorsuserName);
            
        };
        //Due to overshoot when doubling, slice back down to 12 
        $lessonsPopularLessonID = array_slice($lessonsPopularLessonID,0,12);
        $lessonsPopularpfpID = array_slice($lessonsPopularpfpID,0,12);
        $lessonsPopularTitle = array_slice($lessonsPopularTitle,0,12);

        $lessonsSoonLessonID = array_slice($lessonsSoonLessonID,0,12);
        $lessonsSoonTitle = array_slice($lessonsSoonTitle,0,12);
        $lessonsSoonpfpID = array_slice($lessonsSoonpfpID,0,12);

        $creatorsuserName = array_slice($creatorsuserName,0,12);
        $creatorsdisplayName = array_slice($creatorsdisplayName,0,12);
        $creatorspfpID = array_slice($creatorspfpID,0,12);

        echo("
            <section class = 'main-gallery'>
            <div id='carouselControl1' class='carousel slide' data-interval='0'>
                <h1>Popular Lessons</h1>
                <div class='carousel-inner'>
                    <div class='carousel-item active'>
                        <div class='multislide'>
                            <div class='captionpair'>
                                <a href = 'lesson.php?lessonid=".$lessonsPopularLessonID[0] ."'><img class='cImage' src='/rdecrewe/themancerzone/php/image.php?pfpid=".$lessonsPopularpfpID[0]."' alt='".$lessonsPopularTitle[0]."'></a>
                                <p>".$lessonsPopularTitle[0]."</p>
                            </div>
                            <div class='captionpair'>
                                <a href = 'lesson.php?lessonid=".$lessonsPopularLessonID[1] ."'><img class='cImage' src='/rdecrewe/themancerzone/php/image.php?pfpid=".$lessonsPopularpfpID[1]."' alt='".$lessonsPopularTitle[1]."'></a>
                                <p>".$lessonsPopularTitle[1]."</p>
                            </div>
                            <div class='captionpair'>
                                <a href = 'lesson.php?lessonid=".$lessonsPopularLessonID[2] ."'><img class='cImage' src='/rdecrewe/themancerzone/php/image.php?pfpid=".$lessonsPopularpfpID[2]."' alt='".$lessonsPopularTitle[2]."'></a>
                                <p>".$lessonsPopularTitle[2]."</p>
                            </div>
                            <div class='captionpair'>
                                <a href = 'lesson.php?lessonid=".$lessonsPopularLessonID[3] ."'><img class='cImage' src='/rdecrewe/themancerzone/php/image.php?pfpid=".$lessonsPopularpfpID[3]."' alt='".$lessonsPopularTitle[3]."'></a>
                                <p>".$lessonsPopularTitle[3]."</p>
                            </div>
                        </div>
                      </div>
                      <div class='carousel-item'>
                        <div class='multislide'>
                            <div class='captionpair'>
                                <a href = 'lesson.php?lessonid=".$lessonsPopularLessonID[4] ."'><img class='cImage' src='/rdecrewe/themancerzone/php/image.php?pfpid=".$lessonsPopularpfpID[4]."' alt='".$lessonsPopularTitle[4]."'></a>
                                <p>".$lessonsPopularTitle[4]."</p>
                            </div>
                            <div class='captionpair'>
                                <a href = 'lesson.php?lessonid=".$lessonsPopularLessonID[5] ."'><img class='cImage' src='/rdecrewe/themancerzone/php/image.php?pfpid=".$lessonsPopularpfpID[5]."' alt='".$lessonsPopularTitle[5]."'></a>
                                <p>".$lessonsPopularTitle[5]."</p>
                            </div>
                            <div class='captionpair'>
                                <a href = 'lesson.php?lessonid=".$lessonsPopularLessonID[6] ."'><img class='cImage' src='/rdecrewe/themancerzone/php/image.php?pfpid=".$lessonsPopularpfpID[6]."' alt='".$lessonsPopularTitle[6]."'></a>
                                <p>".$lessonsPopularTitle[6]."</p>
                            </div>
                            <div class='captionpair'>
                                <a href = 'lesson.php?lessonid=".$lessonsPopularLessonID[7] ."'><img class='cImage' src='/rdecrewe/themancerzone/php/image.php?pfpid=".$lessonsPopularpfpID[7]."' alt='".$lessonsPopularTitle[7]."'></a>
                                <p>".$lessonsPopularTitle[7]."</p>
                            </div>
                        </div>
                      </div>
                      <div class='carousel-item'>
                        <div class='multislide'>
                            <div class='captionpair'>
                                <a href = 'lesson.php?lessonid=".$lessonsPopularLessonID[8] ."'><img class='cImage' src='/rdecrewe/themancerzone/php/image.php?pfpid=".$lessonsPopularpfpID[8]."' alt='".$lessonsPopularTitle[8]."'></a>
                                <p>".$lessonsPopularTitle[8]."</p>
                            </div>
                            <div class='captionpair'>
                                <a href = 'lesson.php?lessonid=".$lessonsPopularLessonID[9] ."'><img class='cImage' src='/rdecrewe/themancerzone/php/image.php?pfpid=".$lessonsPopularpfpID[9]."' alt='".$lessonsPopularTitle[9]."'></a>
                                <p>".$lessonsPopularTitle[9]."</p>
                            </div>
                            <div class='captionpair'>
                                <a href = 'lesson.php?lessonid=".$lessonsPopularLessonID[10] ."'><img class='cImage' src='/rdecrewe/themancerzone/php/image.php?pfpid=".$lessonsPopularpfpID[10]."' alt='".$lessonsPopularTitle[10]."'></a>
                                <p>".$lessonsPopularTitle[10]."</p>
                            </div>
                            <div class='captionpair'>
                                <a href = 'lesson.php?lessonid=".$lessonsPopularLessonID[11] ."'><img class='cImage' src='/rdecrewe/themancerzone/php/image.php?pfpid=".$lessonsPopularpfpID[11]."' alt='".$lessonsPopularTitle[11]."'></a>
                                <p>".$lessonsPopularTitle[11]."</p>
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

              <div id='carouselControl2' class='carousel slide' data-interval='0'>
                <h1>Lessons Starting Soon</h1>
                <div class='carousel-inner'>
                    <div class='carousel-item active'>
                        <div class='multislide'>
                            <div class='captionpair'>
                                <a href = 'lesson.php?lessonid=".$lessonsSoonLessonID[0] ."'><img class='cImage' src='/rdecrewe/themancerzone/php/image.php?pfpid=".$lessonsSoonpfpID[0]."' alt='".$lessonsSoonTitle[0]."'></a>
                                <p>".$lessonsSoonTitle[0]."</p>
                            </div>
                            <div class='captionpair'>
                                <a href = 'lesson.php?lessonid=".$lessonsSoonLessonID[1] ."'><img class='cImage' src='/rdecrewe/themancerzone/php/image.php?pfpid=".$lessonsSoonpfpID[1]."' alt='".$lessonsSoonTitle[1]."'></a>
                                <p>".$lessonsSoonTitle[1]."</p>
                            </div>
                            <div class='captionpair'>
                                <a href = 'lesson.php?lessonid=".$lessonsSoonLessonID[2] ."'><img class='cImage' src='/rdecrewe/themancerzone/php/image.php?pfpid=".$lessonsSoonpfpID[2]."' alt='".$lessonsSoonTitle[2]."'></a>
                                <p>".$lessonsSoonTitle[2]."</p>
                            </div>
                            <div class='captionpair'>
                                <a href = 'lesson.php?lessonid=".$lessonsSoonLessonID[3] ."'><img class='cImage' src='/rdecrewe/themancerzone/php/image.php?pfpid=".$lessonsSoonpfpID[3]."' alt='".$lessonsSoonTitle[3]."'></a>
                                <p>".$lessonsSoonTitle[3]."</p>
                            </div>
                        </div>
                      </div>
                      <div class='carousel-item'>
                        <div class='multislide'>
                            <div class='captionpair'>
                                <a href = 'lesson.php?lessonid=".$lessonsSoonLessonID[4] ."'><img class='cImage' src='/rdecrewe/themancerzone/php/image.php?pfpid=".$lessonsSoonpfpID[4]."' alt='".$lessonsSoonTitle[4]."'></a>
                                <p>".$lessonsSoonTitle[4]."</p>
                            </div>
                            <div class='captionpair'>
                                <a href = 'lesson.php?lessonid=".$lessonsSoonLessonID[5] ."'><img class='cImage' src='/rdecrewe/themancerzone/php/image.php?pfpid=".$lessonsSoonpfpID[5]."' alt='".$lessonsSoonTitle[5]."'></a>
                                <p>".$lessonsSoonTitle[5]."</p>
                            </div>
                            <div class='captionpair'>
                                <a href = 'lesson.php?lessonid=".$lessonsSoonLessonID[6] ."'><img class='cImage' src='/rdecrewe/themancerzone/php/image.php?pfpid=".$lessonsSoonpfpID[6]."' alt='".$lessonsSoonTitle[6]."'></a>
                                <p>".$lessonsSoonTitle[6]."</p>
                            </div>
                            <div class='captionpair'>
                                <a href = 'lesson.php?lessonid=".$lessonsSoonLessonID[7] ."'><img class='cImage' src='/rdecrewe/themancerzone/php/image.php?pfpid=".$lessonsSoonpfpID[7]."' alt='".$lessonsSoonTitle[7]."'></a>
                                <p>".$lessonsSoonTitle[7]."</p>
                            </div>
                        </div>
                      </div>
                      <div class='carousel-item'>
                        <div class='multislide'>
                            <div class='captionpair'>
                                <a href = 'lesson.php?lessonid=".$lessonsSoonLessonID[8] ."'><img class='cImage' src='/rdecrewe/themancerzone/php/image.php?pfpid=".$lessonsSoonpfpID[8]."' alt='".$lessonsSoonTitle[8]."'></a>
                                <p>".$lessonsSoonTitle[8]."</p>
                            </div>
                            <div class='captionpair'>
                                <a href = 'lesson.php?lessonid=".$lessonsSoonLessonID[9] ."'><img class='cImage' src='/rdecrewe/themancerzone/php/image.php?pfpid=".$lessonsSoonpfpID[9]."' alt='".$lessonsSoonTitle[9]."'></a>
                                <p>".$lessonsSoonTitle[9]."</p>
                            </div>
                            <div class='captionpair'>
                                <a href = 'lesson.php?lessonid=".$lessonsSoonLessonID[10] ."'><img class='cImage' src='/rdecrewe/themancerzone/php/image.php?pfpid=".$lessonsSoonpfpID[10]."' alt='".$lessonsSoonTitle[10]."'></a>
                                <p>".$lessonsSoonTitle[10]."</p>
                            </div>
                            <div class='captionpair'>
                                <a href = 'lesson.php?lessonid=".$lessonsSoonLessonID[11] ."'><img class='cImage' src='/rdecrewe/themancerzone/php/image.php?pfpid=".$lessonsSoonpfpID[11]."' alt='".$lessonsSoonTitle[11]."'></a>
                                <p>".$lessonsSoonTitle[11]."</p>
                            </div>
                        </div>
                      </div>
                </div>
                <a class='carousel-control-prev' href='#carouselControl2' role='button' data-slide='prev'>
                  <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                  <span class='sr-only'>Previous</span>
                </a>
                <a class='carousel-control-next' href='#carouselControl2' role='button' data-slide='next'>
                  <span class='carousel-control-next-icon' aria-hidden='true'></span>
                  <span class='sr-only'>Next</span>
                </a>
              </div>
              <div id='carouselControl3' class='carousel slide' data-interval='0''>
                <h1>Popular Creators</h1>
                <div class='carousel-inner'>
                  <div class='carousel-item active'>
                    <div class='multislide'>
                            <div class='captionpair'>
                                <a href = 'profile.php?username=".$creatorsuserName[0] ."'><img class='cImage' src='/rdecrewe/themancerzone/php/image.php?pfpid=".$creatorspfpID[0]."' alt='".$creatorsdisplayName[0]."'></a>
                                <p>".$creatorsdisplayName[0]."</p>
                            </div>
                            <div class='captionpair'>
                                <a href = 'profile.php?username=".$creatorsuserName[1] ."'><img class='cImage' src='/rdecrewe/themancerzone/php/image.php?pfpid=".$creatorspfpID[1]."' alt='".$creatorsdisplayName[1]."'></a>
                                <p>".$creatorsdisplayName[1]."</p>
                            </div>
                            <div class='captionpair'>
                                <a href = 'profile.php?username=".$creatorsuserName[2] ."'><img class='cImage' src='/rdecrewe/themancerzone/php/image.php?pfpid=".$creatorspfpID[2]."' alt='".$creatorsdisplayName[2]."'></a>
                                <p>".$creatorsdisplayName[2]."</p>
                            </div>
                            <div class='captionpair'>
                                <a href = 'profile.php?username=".$creatorsuserName[3] ."'><img class='cImage' src='/rdecrewe/themancerzone/php/image.php?pfpid=".$creatorspfpID[3]."' alt='".$creatorsdisplayName[3]."'></a>
                                <p>".$creatorsdisplayName[3]."</p>
                            </div>
                    </div>
                  </div>
                  <div class='carousel-item'>
                    <div class='multislide'>
                            <div class='captionpair'>
                                <a href = 'profile.php?username=".$creatorsuserName[4] ."'><img class='cImage' src='/rdecrewe/themancerzone/php/image.php?pfpid=".$creatorspfpID[4]."' alt='".$creatorsdisplayName[4]."'></a>
                                <p>".$creatorsdisplayName[4]."</p>
                            </div>
                            <div class='captionpair'>
                                <a href = 'profile.php?username=".$creatorsuserName[5] ."'><img class='cImage' src='/rdecrewe/themancerzone/php/image.php?pfpid=".$creatorspfpID[5]."' alt='".$creatorsdisplayName[5]."'></a>
                                <p>".$creatorsdisplayName[5]."</p>
                            </div>
                            <div class='captionpair'>
                                <a href = 'profile.php?username=".$creatorsuserName[6] ."'><img class='cImage' src='/rdecrewe/themancerzone/php/image.php?pfpid=".$creatorspfpID[6]."' alt='".$creatorsdisplayName[6]."'></a>
                                <p>".$creatorsdisplayName[6]."</p>
                            </div>
                            <div class='captionpair'>
                                <a href = 'profile.php?username=".$creatorsuserName[7] ."'><img class='cImage' src='/rdecrewe/themancerzone/php/image.php?pfpid=".$creatorspfpID[7]."' alt='".$creatorsdisplayName[7]."'></a>
                                <p>".$creatorsdisplayName[7]."</p>
                            </div>
                    </div>
                  </div>
                  <div class='carousel-item'>
                    <div class='multislide'>
                            <div class='captionpair'>
                                <a href = 'profile.php?username=".$creatorsuserName[8] ."'><img class='cImage' src='/rdecrewe/themancerzone/php/image.php?pfpid=".$creatorspfpID[8]."' alt='".$creatorsdisplayName[8]."'></a>
                                <p>".$creatorsdisplayName[8]."</p>
                            </div>
                            <div class='captionpair'>
                                <a href = 'profile.php?username=".$creatorsuserName[9] ."'><img class='cImage' src='/rdecrewe/themancerzone/php/image.php?pfpid=".$creatorspfpID[9]."' alt='".$creatorsdisplayName[9]."'></a>
                                <p>".$creatorsdisplayName[9]."</p>
                            </div>
                            <div class='captionpair'>
                                <a href = 'profile.php?username=".$creatorsuserName[10] ."'><img class='cImage' src='/rdecrewe/themancerzone/php/image.php?pfpid=".$creatorspfpID[10]."' alt='".$creatorsdisplayName[10]."'></a>
                                <p>".$creatorsdisplayName[10]."</p>
                            </div>
                            <div class='captionpair'>
                                <a href = 'profile.php?username=".$creatorsuserName[11] ."'><img class='cImage' src='/rdecrewe/themancerzone/php/image.php?pfpid=".$creatorspfpID[11]."' alt='".$creatorsdisplayName[11]."'></a>
                                <p>".$creatorsdisplayName[11]."</p>
                            </div>
                    </div>
                  </div>
                </div>
                <a class='carousel-control-prev' href='#carouselControl3' role='button' data-slide='prev'>
                  <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                  <span class='sr-only'>Previous</span>
                </a>
                <a class='carousel-control-next' href='#carouselControl3' role='button' data-slide='next'>
                  <span class='carousel-control-next-icon' aria-hidden='true'></span>
                  <span class='sr-only'>Next</span>
                </a>
              </div>
        </section>
        ");
        ?>
    </main>
</div>
<footer class = "footer">
    <h2>Wizard Co.</h2>
</footer>
   </body>
   <?php mysqli_close($connection);?>
</html>