<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--css-->
        <link rel="stylesheet" href="css/login_volunteer.css">
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
                <div class="container ">
                    <a href="Afterindex.php" id="logo-img"><img src="images/Logobr.png" alt=""></a>
                    <!--button-->
                    <button class="navbar-toggler shadow-none border-0 ms-auto" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar"  id="toggler_button">
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

                            </ul>

                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <!--navigation end-->

        <!--logging form start-->

        <section class="login-form">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center vh-100">
                    <div class="col col-xl-10">
                        <div class="card">
                            <div class="row g-0">
                                <div class="col-md-6 col-lg-5 d-none d-md-block" id="limage">
                                    <a href="Afterindex.php"><img src="images/Logobr.png" alt="login form" class="limg"></a>
                                    <p class="plogin text-center">Your efforts save lives together,<br> we make hope possible</p>
                                </div>

                                <div class="col-md-6 col-lg-7 d-flex align-items-center" id="flogin">
                                    <div class="card-body p-4 p-lg-5 text-black">

                                        <form method="POST" action="../Login_page/includes/Login.php">



                                            <h5 class=" mb-2 pb-3">Get Access to your Account(Volunteer)</h5>

                                            <div class="form-floating  form-outline mb-2">
                                                <!--                      <label class="form-label" for="vol_email">User Name</label>-->
                                                <input type="text" id="uname" name="username" placeholder="Email" class="form-control form-control-lg" />
                                                <label for="uname" class="ms-2"> User Name</label>
                                            </div>

                                            <div class="form-floating  form-outline mb-2">
                                                <!--                      <label class="form-label" for="vol_password">Password</label>-->
                                                <input type="password" id="password" name="Password" placeholder="Password" class="form-control form-control-lg" />
                                                <label for="password" class="ms-2">Password</label>
                                            </div>



                                            <div class="d-grid gap-2 col-12 mx-auto mt-3 " id="blogin">
                                                <button class="btn btn-success" name="submit" type="submit">Login</button>
                                            </div>




                                            <br>




                                            <div>
                                                <a href="#!" class="text-decoration-none">Forgot password?</a>
                                                <p class="mb-0 pb-lg-2">Don't have an account? <a href="vol_reg.php" class="text-decoration-none">Register here</a></p>
                                            </div>
                                        </form>

                                        <?php
                                        if (isset($_GET["error"])) {
                                            if ($_GET["error"] == "emptyInput") {
                                                echo '
                      <div class="alert alert-danger" role="alert">
                             All the feilds must be fill!
                      </div>
                      ';
                                            } else if ($_GET["error"] == "wronglogin") {
                                                echo '
                      <div class="alert alert-danger" role="alert">
                             Incorrect password!
                      </div>
                      ';
                                            } else if ($_GET["error"] == "invalidEmail") {
                                                echo '
                       <div class="alert alert-danger" role="alert">
                             Invalid Email!
                      </div>
                      ';
                                            }
                                            //  else if ($_GET["error"] == "pwdMatch") {
                                            //     echo '<div class="error">Invalid Password!</div>';
                                            // } 
                                            else if ($_GET["error"] == "stmt") {
                                                echo '
                        <div class="alert alert-danger" role="alert">
                             Something went wrong!
                      </div>
                      ';
                                            }
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!--logging form end-->

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
                            <h3>We Accect</h3>
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