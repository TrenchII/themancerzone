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
    <script src="./js/createlesson.js" defer></script>
    <script src="./js/toggle.js" defer></script>
    <script src="./js/newmessage.js" defer></script>
</head>

<body>
    <?php require_once('php/sessionstart.php'); ?>
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
                    echo "<a href='modpage.html'>Moderator Tools</a>";
                }
                echo "<a href='php/logout.php'>Logout</a>";
            }
            ?>
        </div>
        <main id="main">
            <section class="main-heading">
                <button class="sidebar-btn" onclick="openNav()"><i class="fa-solid fa-bars"></i></button>
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
            <form id="form" action="php/createlesson.php" method="post" enctype="multipart/form-data" novalidate
                style="margin-top:-1em; width:60%;">

                <section class="formbox">
                    <h1>Create Lesson</h1>
                    <div class="formboxlabel">
                        <p class='inputlabel'>Title</p>
                        <div style="width:100%">
                            <input type="text" class="formcontrol" name='title' placeholder="Enter a title" required>
                        </div>
                        <p class='inputlabel'>Description</p>
                        <div style="width:100%">
                            <input type="text" class="desc" name='desc'
                                placeholder="Enter a short summary of your lesson" required>
                        </div>
                        <p class='chitinputlabel'>Keywords</p>
                        <div class="chitmatrix">
                            <input type="checkbox" class='hiddencheck' name='kBeginner' id='Beginner'>
                            <button class="chitlight chit-btn" id='Beginner'>Beginner</button>
                            <input type="checkbox" class='hiddencheck' name='kMedium' id='Medium'>
                            <button class="chitlight chit-btn" id='Medium'>Medium</button>
                            <input type="checkbox" class='hiddencheck' name='kDifficult' id='Difficult'>
                            <button class="chitlight chit-btn" id='Difficult'>Difficult</button>
                            <input type="checkbox" class='hiddencheck' name='kExpert' id='Expert'>
                            <button class="chitlight chit-btn" id='Expert'>Expert</button>
                        </div>
                        <div class="chitmatrix">
                            <input type="checkbox" class='hiddencheck' name='kSpellwork' id='Spellwork'>
                            <button class="chitlight chit-btn" id='Spellwork'>Spellwork</button>
                            <input type="checkbox" class='hiddencheck' name='kAlchemy' id='Alchemy'>
                            <button class="chitlight chit-btn" id='Alchemy'>Alchemy</button>
                            <input type="checkbox" class='hiddencheck' name='kBrewing' id='Brewing'>
                            <button class="chitlight chit-btn" id='Brewing'>Brewing</button>
                            <input type="checkbox" class='hiddencheck' name='kApplied' id='Applied'>
                            <button class="chitlight chit-btn" id='Applied'>Applied</button>
                        </div>
                        <p class='chitinputlabel'>School</p>
                        <div class="chitmatrix">
                            <input type="checkbox" class='hiddencheck' name='sAbjuration' id='Abjuration'>
                            <button class="chitlight chit-btn" id='Abjuration'>Abjuration</button>
                            <input type="checkbox" class='hiddencheck' name='sConjuration' id='Conjuration'>
                            <button class="chitlight chit-btn" id='Conjuration'>Conjuration</button>
                            <input type="checkbox" class='hiddencheck' name='sDivination' id='Divination'>
                            <button class="chitlight chit-btn" id='Divination'>Divination</button>
                            <input type="checkbox" class='hiddencheck' name='sEnchantment' id='Enchantment'>
                            <button class="chitlight chit-btn" id='Enchantment'>Enchantment</button>
                        </div>
                        <div class="chitmatrix">
                            <input type="checkbox" class='hiddencheck' name='sEvocation' id='Evocation'>
                            <button class="chitlight chit-btn" id='Evocation'>Evocation</button>
                            <input type="checkbox" class='hiddencheck' name='sIllusion' id='Illusion'>
                            <button class="chitlight chit-btn" id='Illusion'>Illusion</button>
                            <input type="checkbox" class='hiddencheck' name='sNecromancy' id='Necromancy'>
                            <button class="chitlight chit-btn" id='Necromancy'>Necromancy</button>
                            <input type="checkbox" class='hiddencheck' name='sTransmutation' id='Transmutation'>
                            <button class="chitlight chit-btn" id='Transmutation'>Transmutation</button>
                        </div>
                        <p class='inputlabel'>Date</p>
                        <div style="width:100%">
                            <input type="datetime-local" class="formcontrol" name="datetime" min="<?php date_default_timezone_set('America/Los_Angeles'); echo date('Y-m-d\TG:i'); ?>" required>
                        </div>
                        <div id="filesubmit">
                            <p class='inputlabel'>Lesson Photo</p>
                            <input type="file" id="img" name="img" accept="image/png,image/jpeg" required>
                        </div>
                    </div>
                    <input type="submit" class="toolbutton submit" value="Submit">
            </form>
            </section>
        </main>
    </div>
    <footer class="footer">
        <h2>Wizard Co.</h2>
    </footer>
</body>

</html>