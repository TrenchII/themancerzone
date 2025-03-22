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
        <div class = "maincontent">
            <div id="mySidenav" class="sidenav">
                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                <a href="profile.html">Profile</a>
                <a href="lessons.html">Lessons</a>
                <a href="inbox.html">Inbox</a>
                <a href="modpage.html">Moderator Tools</a>
              </div>
            <main id = "main">
                <section class="main-heading">
                    <button class="sidebar-btn" onclick="openNav()"><i class="fa-solid fa-bars"></i></button>
                    <h1 class="header-text"><a href='mainpage.html'>The 'Mancer Zone</a></h1>
                    <div class="logsign">
                        <p><a href='loginpage.html'>Login</a></p>
                        <p>|</p>
                        <p><a href='signuppage.html'>Signup</a></p>
                    </div>
                </section>
            </section>
            <section class="infopanel">
                <img class="pImage" src="./img/placeholder.jpg" alt="pfp">
                <div class="textpanel">
                    <div class="nameheader">
                        <h1>CoolWizardDisplayName99</h1>
                        <p class="toolbutton"><a href='profiledit.html'>Edit</a></p>
                        <p class="toolbutton"><a href='modpage.html'>Moderator Tools</a></p>
                        <p class ="toolbutton"><a href="sendmessage.html">Send a Message</a></p>
                    </div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas ut ex consequat, tristique nibh et, 
                        bibendum nisl. Phasellus eleifend est quis dapibus viverra. Mauris aliquet semper rutrum. Sed vitae diam 
                        ac erat convallis sagittis. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus 
                        mus. Sed ut augue vestibulum, pellentesque nunc nec, mattis turpis. Quisque pharetra consectetur augue vel porta. 
                        In varius nunc quis molestie interdum. </p>
                    <div class="echit">
                        <p style="font-weight: bold;">Expertise:</p>
                        <button class="chit-btn">Magic Type 1</button>
                        <button class="chit-btn">Magic Type 2</button>
                        <button class="chit-btn">Magic Type 3</button>
                        <button class="chit-btn">Magic Type 4</button>
                        <button class="chit-btn">Magic Type 5</button>
                    </div>
                </div>
            </section>
            <section class = "main-gallery-small">
                <div id="carouselControl1" class="carousel slide" data-interval='0'>
                        <h1>Popular Lessons</h1>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="multislide">
                                    <div class="captionpair">
                                        <a href = 'lesson.html'><img class="cImage" src="./img/placeholder.jpg" alt="1s1m"></a>
                                        <p>Slide 1 Image 1</p>
                                    </div>
                                    <div class="captionpair">
                                        <a href = 'lesson.html'><img class="cImage" src="./img/placeholder.jpg" alt="1s2m"></a>
                                        <p>Slide 1 Image 2</p>
                                    </div>
                                    <div class="captionpair">
                                        <a href = 'lesson.html'><img class="cImage" src="./img/placeholder.jpg" alt="1s3m"></a>
                                        <p>Slide 1 Image 3</p>
                                    </div>
                                    <div class="captionpair">
                                        <a href = 'lesson.html'><img class="cImage" src="./img/placeholder.jpg" alt="1s4m"></a>
                                        <p>Slide 1 Image 4</p>
                                    </div>
                                </div>
                              </div>
                              <div class="carousel-item">
                                <div class="multislide">
                                    <div class="captionpair">
                                        <a href = 'lesson.html'><img class="cImage" src="./img/placeholder.jpg" alt="2s1m"></a>
                                        <p>Slide 2 Image 1</p>
                                    </div>
                                    <div class="captionpair">
                                        <a href = 'lesson.html'><img class="cImage" src="./img/placeholder.jpg" alt="2s2m"></a>
                                        <p>Slide 2 Image 2</p>
                                    </div>
                                    <div class="captionpair">
                                        <a href = 'lesson.html'><img class="cImage" src="./img/placeholder.jpg" alt="2s3m"></a>
                                        <p>Slide 2 Image 3</p>
                                    </div>
                                    <div class="captionpair">
                                        <a href = 'lesson.html'><img class="cImage" src="./img/placeholder.jpg" alt="2s4m"></a>
                                        <p>Slide 2 Image 4</p>
                                    </div>
                                </div>
                              </div>
                              <div class="carousel-item">
                                <div class="multislide">
                                    <div class="captionpair">
                                        <a href = 'lesson.html'><img class="cImage" src="./img/placeholder.jpg" alt="3s1m"></a>
                                        <p>Slide 3 Image 1</p>
                                    </div>
                                    <div class="captionpair">
                                        <a href = 'lesson.html'><img class="cImage" src="./img/placeholder.jpg" alt="3s2m"></a>
                                        <p>Slide 3 Image 2</p>
                                    </div>
                                    <div class="captionpair">
                                        <a href = 'lesson.html'><img class="cImage" src="./img/placeholder.jpg" alt="3s3m"></a>
                                        <p>Slide 3 Image 3</p>
                                    </div>
                                    <div class="captionpair">
                                        <a href = 'lesson.html'><img class="cImage" src="./img/placeholder.jpg" alt="3s4m"></a>
                                        <p>Slide 3 Image 4</p>
                                    </div>
                                </div>
                              </div>
                        </div>
                            <a class="carousel-control-prev" href="#carouselControl1" role="button" data-slide="prev">
                              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                              <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselControl1" role="button" data-slide="next">
                              <span class="carousel-control-next-icon" aria-hidden="true"></span>
                              <span class="sr-only">Next</span>
                            </a>
                    </div>                    
            </section>
            <section>
                <button class="actionbutton" onclick="location.href='createlesson.html'">Create a Lesson</button>
            </section>
        </main>
    </div>
    <footer class = "footer">
        <h2>Wizard Co.</h2>
    </footer>
    </body>
</html>