<?php
        require_once('../connectDB.php');
        //Variable Declaration for the 3 slideshows
        $lessonsPopularLessonID = [];
        $lessonsPopularTitle = [];
        $lessonsPopularImage = [];

        $lessonsSoonLessonID = [];
        $lessonsSoonTitle = [];
        $lessonsSoonImage = [];

        $creatorsuserName = [];
        $creatorsdisplayName = [];
        $creatorsImage = [];

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
            $pfpid = $lessonRow['pfpid'];
            $lessonsPopularImage[] = "/themancerzone/php/image.php?pfpid=".$pfpid;

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
            $pfpid = $row['pfpid'];
            $lessonsSoonImage[] =  "/themancerzone/php/image.php?pfpid=".$pfpid;
        }
        //if no results detected, show error
        if(!$anyResults) {
            die("<p style='color:white'>NO DATA IN DATABASE, ADD DATA TO DATABASE</p>");
        }

        //For Soon, gets title pfpid and lessonid sorted by their date ASC (ie. oldest (closest to now, dates first)) and puts them into arrays
        $anyResults = false;
        $sql = "SELECT COUNT(lessonid), username FROM createdlessons GROUP BY username ORDER BY COUNT(lessonid) DESC";
        $result = mysqli_query($connection,$sql);
        while($row = mysqli_fetch_assoc($result)) {
            $anyResults = true;
            $username = $row['username'];
            $creatorsuserName[] = $username;
            $sql = "SELECT `displayname`,`pfpid` FROM users where username = '$username'";
            $userRow = mysqli_fetch_assoc(mysqli_query($connection, $sql));
            $creatorsdisplayName[] = $userRow['displayname'];
            $pfpid = $userRow['pfpid'];
            $creatorsImage[] =  "/themancerzone/php/image.php?pfpid=".$pfpid;
        }
        //if no results detected, show error
        if(!$anyResults) {
            die("<p style='color:white'>NO DATA IN DATABASE, ADD DATA TO DATABASE</p>");
        }

        //When less than 12 records returned, duplicates given records until we have 12 (enough to fill slideshow)
        $length = count($lessonsPopularLessonID);
        while($length < 12) {
            for ($i = 0 ; $i < $length; $i++) {
                $lessonsPopularLessonID[] = $lessonsPopularLessonID[$i];
                $lessonsPopularTitle[] = $lessonsPopularTitle[$i];
                $lessonsPopularImage[] = $lessonsPopularImage[$i];

                $lessonsSoonLessonID[] = $lessonsSoonLessonID[$i];
                $lessonsSoonTitle[] = $lessonsSoonTitle[$i];
                $lessonsSoonImage[] = $lessonsSoonImage[$i];

                $creatorsuserName[] = $creatorsuserName[$i];
                $creatorsdisplayName[] = $creatorsdisplayName[$i];
                $creatorsImage[] = $creatorsImage[$i];

            }
            if(count($lessonsPopularLessonID) < count($creatorsuserName)) {
                $length = count($lessonsPopularLessonID);
            }
            else {
                $length = count($creatorsuserName);
            }
            
        };

        //Due to overshoot when doubling, slice back down to 12 
        $lessonsPopularLessonID = array_slice($lessonsPopularLessonID,0,12);
        $lessonsPopularTitle = array_slice($lessonsPopularTitle,0,12);
        $lessonsPopularImage = array_slice($lessonsPopularImage,0,12);

        $lessonsSoonLessonID = array_slice($lessonsSoonLessonID,0,12);
        $lessonsSoonTitle = array_slice($lessonsSoonTitle,0,12);
        $lessonsSoonImage = array_slice($lessonsSoonImage,0,12);

        $creatorsuserName = array_slice($creatorsuserName,0,12);
        $creatorsdisplayName = array_slice($creatorsdisplayName,0,12);
        $creatorsImage= array_slice($creatorsImage,0,12);

        $popularLessons = [];
        $soonLessons = [];
        $popularCreators = [];
        $length = count($lessonsPopularLessonID);
        for ($i = 0; $i < $length; $i++) {
            $popularLessons[$i] = [
                "lessonid" => $lessonsPopularLessonID[$i],
                "title" => $lessonsPopularTitle[$i],
                "image" => $lessonsPopularImage[$i],

            ];
            $soonLessons[$i] = [
                "lessonid" => $lessonsSoonLessonID[$i],
                "title" => $lessonsSoonTitle[$i],
                "image" => $lessonsSoonImage[$i],

            ];
            $popularCreators[$i] = [
                "username" =>  $creatorsuserName[$i],
                "displayname" => $creatorsdisplayName[$i],
                "image" => $creatorsImage [$i],

            ];
        }
        ob_end_clean();
        header('Content-type:application/json');
        echo json_encode(
            [
                "popularLessons" => $popularLessons,
                "soonLessons" => $soonLessons,
                "popularCreators" => $popularCreators,
            ]
            );
        ?>