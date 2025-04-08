<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--css-->

    <link rel="stylesheet" href="css/Volunteer.css">
    <link rel="stylesheet" href="css/style.css">

    <title>LIFE LINE</title>
    <link rel="icon" type="image/x-icon" href="images/Logobr.png">


    <!--Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"><!--        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>-->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>
    <!--navigation start-->

    <div>
        <nav class="navbar navbar-expand-lg  vh-10 overflow-hidden fixed-top" id="nav-color">

            <a href="Afterindex.php" id="logo-img"><img src="images/Logobr.png" alt=""></a>
            <div class="container ">
                <!--button-->
                <button class="navbar-toggler shadow-none border-0 ms-auto" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" id="toggler_button">
                    <span class="navbar-toggler-icon pt-5"></span>
                </button>
                <!--sidebar-->
                <div class="sidebar offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                    <!--sidebarbody-->
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasNavbarLabel"><img src="images/Logobr.png" alt="Logo" class="logoL"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>

                    <div div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                            <li class="menu-item">
                                <a class="navlink" href="Afterindex.php">Home </a>
                            </li>
                            <li class="menu-item">
                                <a class="navlink" href="Stories.php">Stories </a>
                            </li>
                            <li class="menu-item">
                                <a class="navlink" href="past_project.php">Past Projects</a>
                            </li>
                            <li class="menu-item">
                                <a class="navlink" href="Volunteer.php">Volunteer</a>
                            </li>
                            <li class="menu-item">
                                <a class="navlink" href="About.php">About Us</a>
                            </li>
                            <li class="menu-item">
                                <a class="navlink" href="Contact_us.php">Contact Us</a>
                            </li>
                            <li class="menu-item">
                                <?php
                                session_start();
                                if (isset($_SESSION["username"])) {
                                    echo '<a href="add_req.php"><button class="apply">Apply</button></a>';
                                }
                                //To show username in btn
                                if (isset($_SESSION["username"])) {
                                    echo '<li class="menu-item"><a href ="#"  id="userName">' . $_SESSION["useruid"] . '</a></li>'; /* yet delcare href to ditec the page */
                                    echo '<li class="menu-item"><a href ="Logout.php"><img src="images/logout.png" id="logout"> <a/></li>';
                                }
                                ?>
                            </li>
                            <li class="menu-item">
                                <?php

                                ?>
                            </li>






                        </ul>

                    </div>
                </div>
            </div>
        </nav>
    </div>
    <!--navigation end-->
    <!--cover section-->
    <div>
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="images/volunteering.jpeg" class="d-block w-100" alt="volunteering image">
                    <div class="carousel-caption d-md-block ">
                        <h5 class="text-center">Becoming a Volunteer with Us</h5>
                        <p class="text-center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            Apply now to work with our network of volunteers across Sri Lanka.</p>
                        <div clsss="enter">
                        
                            <?php
                            if (isset($_SESSION['username'])) {
                                $addvolunteer = "vol_reg.php?email=" . $_SESSION["username"];
                                echo '<a href="login_Volunteer.php"><button type="button" class="apply">Log In</button></a><span>&nbsp;&nbsp;&nbsp;</span>';
                                echo '<a href="' . $addvolunteer . '"><button type="button" class="apply">Sign In</button></a>';
                            } else {
                                $addvolunteer = "vol_reg.php?email=";
                            }
              ?>
                            
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    </div>

    <!--cover section end-->

    <!--caption section start-->
    <div class="caption">
        <div class="row  mb-5 ">
            <div class="col-md-12">
                <h2 class="heading justify-content-center text-center">Now You can Join Our Island Wide Volunteer Community</h2>
                <p class="para1 pt-5">If you’re someone who believes in the power of kindness and wants to
                    make a real difference in the lives of those who need it most, we invite you to be part of our mission.
                    We are dedicated to supporting communities across the country, and we’re looking for people who are willing
                    o invest their time, energy, and compassion to help uplift others. Whether you can give a little or a lot,
                    every effort counts and contributes to making the world a better place. </p>
                <p class="para1 pt-1">By coming together and offering our skills, talents, and support, we can bring hope to
                    individuals and families who are facing difficult times. The challenges may be big, but with many hands
                    and open hearts, we can achieve remarkable things. Your involvement, no matter the size, will help build stronger,
                    more caring communities.</p>
                <div class="row justify-content-center text-center mb-5 pt-4">
                    <a href="vol_reg.php"><button class="btn btn-success " id="button">To Be A Volunteer</button></a>
                </div>
            </div>
        </div>
    </div>
    <!--caption section end-->


    <!--why-volunteers start-->
    <div class="volunteers-contribution">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">To Join as a Volunteer</h3>
                <p class="card-text">If you are also interested in joining as a volunteer,please send us your educational qualifications and volunteer activities you have joined as a volunteer.
                    Your application will be scrutinized by our team and the selection details will be sent to you.
                    We care not only about your educational qualification but also about your character traits and we want a very honest and reliable person.</p>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Contribution as a Volunteer</h3>
                <p class="card-text">After you get the permission to access the list of people who are applying for our service who reside in your district, you will have the ability to choose one of them. You have to contact them and visit them and get the details of those people and update the system</p>

            </div>
        </div>



        <div>
            <div class="volunteers-info row justify-content-center text-center mb-5">
                <p class="pt-4 ">For More Information</p>
                <a href="tearmsandcondition.php"><button class="btn btn-success">Terms & Conditions</button></a>
            </div>
        </div>
    </div>
    <!--why-volunteers end-->




    <!-- -->





    <!-- footer section start -->
    <div class="content">
        <div class="container">
            <div class="single-content">

            </div>
        </div>
    </div>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="single-box">
                        <img src="images/Logobr.png" alt="">
                        <h3>We Accept</h3>
                        <div class="card-area">
                            <i class="fa fa-cc-visa"></i>
                            <i class="fa fa-credit-card"></i>
                            <i class="fa fa-cc-mastercard"></i>
                            <i class="fa fa-cc-paypal"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single-box">
                        <h2>Useful Links</h2>
                        <ul>
                            <li><a href="Afterindex.php">Home</a></li>
                            <li><a href="Stories.php">Stories</a></li>
                            <li><a href="past_project.php">Past Projects</a></li>
                            <li><a href="Volunteer.php">Volunteers</a></li>
                            <li><a href="tearmsandcondition.php">Terms and Conditions</a></li>
                            <li><a href="About.php">About Us</a></li>
                            <li><a href="Contact_us.php">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single-box">
                        <h2>For More Details</h2>
                        <ul>
                            <li><a href="#">Email: lifeline@gmail.com</a></li>
                            <li><a href="#">Phone: +94 71 294 6743</a></li>
                            <li><a href="#">Phone: +94 76 594 6543</a></li>

                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single-box">

                        <h2>Follow us on</h2>
                        <p class="socials">
                            <i class="fa fa-facebook"></i>
                            <i class="fa fa-dribbble"></i>
                            <i class="fa fa-pinterest"></i>
                            <i class="fa fa-twitter"></i>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- footer section end -->


    <!--javascript-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/js/bootstrap.min.js">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js"></script>
</body>

</html>