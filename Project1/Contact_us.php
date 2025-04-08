<?php
require_once 'Dbh.php';
session_start(); // Start the session to use session variables
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--css-->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/Contact_us.css">

    <title>LIFE LINE</title>
    <link rel="icon" type="image/x-icon" href="images/Logobr.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

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
                                if (isset($_SESSION["username"])) {
                                    echo '<a href="add_req.php"><button class="apply">Apply</button></a>';
                                }
                                ?>
                            </li>
                            <li class="menu-item">
                                <?php
                                //To show username in btn
                                if (isset($_SESSION["username"])) {
                                    echo  '<li class="menu-item"><a href ="#"  id="userName">' . $_SESSION["useruid"] . '</a></li>'; /*yet delcare href to ditec the page*/
                                    echo '<li class="menu-item"><a href ="Logout.php"><img src="images/logout.png" id="logout"> <a/></li>';
                                }
                                ?>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </nav>
    </div>


    <!--navigation end-->

    <!--icon section start-->
    <div>
    <div class="serviceicon">
        <div class="">
            <div class="row justify-content-center p-5">
                <!-- First Column -->
                <div class="col-12 col-sm-6 col-md-4 mb-4">
                    <div class="text-center" id="c1">
                        <div class="icon">
                            <img alt="email" class="img-fluid" src="images/email.png" style="max-width: 100px;">
                            <p class="content1 mt-3">
                                Just send us your questions<br>or concerns by starting a new<br>case and we will give<br>you the help you need.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Second Column -->
                <div class="col-12 col-sm-6 col-md-4 mb-4">
                    <div class="text-center" id="c2">
                        <div class="icon">
                            <img alt="callcenter" class="img-fluid" src="images/callcenter.png" style="max-width: 100px;">
                            <p class="content1 mt-3">
                                Questions about this donation<br>system can be resolved using<br>our phone numbers:<br>+94 768663035<br>+94 776626075
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Third Column -->
                <div class="col-12 col-sm-6 col-md-4 mb-4">
                    <div class="text-center" id="c3">
                        <div class="icon">
                            <img alt="socialmedia" class="img-fluid" src="images/socialmedia.png" style="max-width: 100px;">
                            <p class="content1 mt-3">
                                You can resolve all issues<br>regarding this donation system by<br>contacting us on all our<br>social media platforms.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    <!--icon section start-->



    <!--contact form start-->
    <section class="contact-section">
        <div class="container">
            <h1 class="caption">Contact Us</h1>

            <form class="row g-4" id="contact-form" method="POST" action="ContactUsProcess.php">

                <div class="form-floating col-md-4">

                    <input type="text" class="form-control" id="fname" name="fname" placeholder=" First Name">
                    <label for="fname" class="ms-2"> First Name</label>
                </div>
                <div class="form-floating col-md-4">

                    <input type="text" class="form-control" id="lname" name="lname" placeholder=" Last Name">
                    <label for="lname" class="ms-2"> Last Name</label>
                </div>
                <div class="form-floating col-md-8">
                    <input type="text" class="form-control" id="inputAddress2" name="email" placeholder=" Email">
                    <label for="inputAddress2" class="ms-2"> Email</label>
                </div>

                <div class="form-floating col-md-8">

                    <textarea class="form-control" id="floatingTextarea2" style="height: 150px" name=" message" placeholder="Massage"></textarea>
                    <label for="floatingTextarea2" class="ms-2"> Message</label>
                </div>

                <div class="form-floating col-md-8">
                    <button type="submit" class="button" name="submit">Send Message</button>
                </div>
                <div class="form-floating col-md-8">
                    <?php
                    if (isset($_GET['s'])) {

                        if (isset($_GET['s']) == 1) {
                            echo 'Massage sent successfully!!';
                        }
                        if (isset($_GET['s']) == 0) {
                            echo 'OOps something when wrong!!';
                        }
                    }

                    ?>
                </div>


            </form>

        </div>
    </section>

    <!--contact form  end -->

    <!--footer section start-->
    <div class="content">
        <div class="container">
            <div class="single-content">

            </div>
        </div>
    </div>

    <footer>
        <div class="container">
            <div class="row row-cols-1 row-cols-xl-4 g-0">
                <div class="col-lg-6 col-sm-6">
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


    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/js/bootstrap.min.js">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js"></script>

</body>

</html>