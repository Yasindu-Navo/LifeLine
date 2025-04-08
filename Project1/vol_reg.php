<!DOCTYPE html>
<html lang="en">
<?php
require '../New_Admin_Pannel/Add_volenteer.php';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--css-->

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/vol_reg.css">



    <title>LIFE LINE</title>
    <link rel="icon" type="image/x-icon" href="images/Logobr.png">

    <!--Bootstrap-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>



</head>

<body>

    <!--navigation start-->

    <div id="navbar">
        <nav class="navbar navbar-expand-lg  vh-10 overflow-hidden fixed-top" id="nav-color">
            <div class="container ">
                <a href="index.php" id="logo-img"><img src="images/Logobr.png" alt=""></a>
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
                                <a class="navlink" href="index.php">Home </a>
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

                                <a href="add_req.php"><button class="apply">Apply</button></a>
                            </li>





                        </ul>

                    </div>
                </div>
            </div>
        </nav>
    </div>
    <!--navigation end-->
    <!--application start-->

    <section class="request-section row  ">

        <div id="bimg" class="col-md-6 align-items-center justify-content-center ">
            <a href="Volunteer.php"><img src="images/Logobr.png" alt=""></a>
            <h2>Hey, We are glad to have you as a Volunteer!</h2>
            <br>
            <br>
            <div id="carouselExampleSlidesOnly" class="carousel slide  " data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <h4>Let's Build a Community of Compassion ! </h4>
                        <br>

                        <h5>
                            <li>A vibrant, supportive volunteer community</li>
                        </h5>
                        <h5>
                            <li>Become part of a family of caring individuals</li>
                        </h5>

                    </div>
                    <div class="carousel-item">
                        <h4>To Make a Real Difference and Impact !</h4>
                        <br>

                        <h5>
                            <li>Help create positive change in the community</li>
                        </h5>
                        <h5>
                            <li>Impact the lives through meaningful action</li>
                        </h5>

                    </div>
                    <div class="carousel-item">
                        <h4>Enhance New Skills & Career Prospects !</h4>
                        <br>
                        <h5>
                            <li>Showcase commitment and compassion</li>
                        </h5>
                        <h5>
                            <li>Discover new interests and passions</li>
                        </h5>

                    </div>
                </div>
            </div>

        </div>


        <div class="pt-2 col-md-6" id="details">


            <div class="col-md-12 text-center">
                <h3>Applicant's Details</h3>
                <br>
                <small class="form-text text-muted"><img src="images/icon1.png" alt="icon"> Please review the <a href="tearmsandcondition.php">terms and conditions</a> before filling out the form. Fill in all the Details</small>
            </div>

            <form class="g-4" id="req-form" method="POST" action="../New_Admin_Pannel/Add_volenteer.php" enctype="multipart/form-data">


                <!-- enter the link to term & cond -->
                <?php
                if (isset($_GET['s'])) {
                    if ($_GET['s'] == 3) {

                        echo "
                            <div class='row mb-3'>
                                <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                                    <strong>All the fields must be filled!</strong> 
                                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                </div>
                            </div>
                            ";
                    }
                }
                if (isset($_GET['s'])) {
                    if ($_GET['s'] == 1) {

                        echo "
                            <div class='row mb-3'>
                                <div class='alert alert-success alert-dismissible fade show' role='alert'>
                                    <strong>Data added successfully!</strong> 
                                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                </div>
                            </div>
                            ";
                    }
                    if ($_GET['s'] == 0) {

                        echo "
                            <div class='row mb-3'>
                                <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                                    <strong>Failed to add data!</strong> 
                                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                </div>
                            </div>
                            ";
                    }
                    if ($_GET['s'] == 2) {

                        echo "
                            <div class='row mb-3'>
                                <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                                    <strong>Already Registerd !!</strong> 
                                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                </div>
                            </div>
                            ";
                    }
                }
                ?>


                <div class=" col-12 entryarea">

                    <input type="text" class="form-control" id="name-vol" name="name">
                    <div class="labelline">Your Name</div>
                </div>

                <div class="col-12 entryarea">

                    <input type="text" class="form-control" id="Address-vol" name="address">
                    <div class="labelline">Your Address</div>
                </div>
                <div class="row">
                    <div class="col-md-4 entryarea">
                        <input type="text" class="form-control" id="age-vol" name="age">
                        <div class="labelline">Your Age</div>
                    </div>
                    <div class="col-md-7 entryarea">
                        <input type="text" class="form-control" id="nic-vol" name="nic">
                        <div class="labelline">Your NIC</div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-5 entryarea">

                        <input type="text" class="form-control" id="contact-vol" name="phone">
                        <div class="labelline">Your contact</div>
                    </div>



                    <div class="col-md-6 entryarea">

                        <input type="text" class="form-control" id="email-vol" name="email">
                        <div class="labelline">Your email</div>
                    </div>
                </div>

                <div class="col-md-6" style="margin-bottom: 30px;">

                    <select style="height: 40px; color: gray;" id="inputState" class="form-select" name="district">
                        <option selected>Select Your District</option>
                        <option value="Ampara">Ampara</option>
                        <option value="Anuradhapura">Anuradhapura</option>
                        <option value="Badulla">Badulla</option>
                        <option value="Batticaloa">Batticaloa</option>
                        <option value="Colombo">Colombo</option>
                        <option value="Galle">Galle</option>
                        <option value="Gampaha">Gampaha</option>
                        <option value="Hambantota">Hambantota</option>
                        <option value="Jaffna">Jaffna</option>
                        <option value="Kalutara">Kalutara</option>
                        <option value="Kandy">Kandy</option>
                        <option value="Kegalle">Kegalle</option>
                        <option value="Kilinochchi">Kilinochchi</option>
                        <option value="Kurunegala">Kurunegala</option>
                        <option value="Mannar">Mannar</option>
                        <option value="Matale">Matale</option>
                        <option value="Matara">Matara</option>
                        <option value="Monaragala">Monaragala</option>
                        <option value="Mullaitivu">Mullaitivu</option>
                        <option value="Nuwara Eliya">Nuwara Eliya</option>
                        <option value="Polonnaruwa">Polonnaruwa</option>
                        <option value="Puttalam">Puttalam</option>
                        <option value="Ratnapura">Ratnapura</option>
                        <option value="Trincomalee">Trincomalee</option>
                        <option value="Vavuniya">Vavuniya</option>
                    </select>
                </div>

                <div class="col-12 entryarea">

                    <input type="text" class="form-control" id="days" name="result">
                    <div class="labelline">Your A/l Results & Result sheet</div>
                </div>


                <div class="col-12 entryarea">
                    <input type="file" class="form-control" id="a/l" name="image">
                </div>

                <div class="col-12 entryarea">
                    <p class="text-muted"> Add the Police Report of yours</p>
                    <input type="file" class="form-control" id="police_rep" name="policeimage">
                </div>
                <br>
                <br>

                <div class="col-12 entryarea">

                    <textarea class="form-control" id="pre-vol" style="height: 100px;" name="pre"></textarea>
                    <div class="labelline">Your Previous Volunteerings Eg: Task-Organization(Year)</div>
                </div><br><br>

                <div class="col-12">
                    <div class="col-sm-6">
                        <input type="hidden" class="form-control" name="usertype" value="volenteer">
                    </div>
                </div>



                <br>
                <div class="col-12">
                    <button type="submit" class="button" name="submit">Send Request</button>
                </div><br>
            </form>

        </div>

    </section>



    <!--application end-->
    <!-- footer section start -->
    <div id="footer" style="padding-top: 250px;">
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
                                <li><a href="#">Home</a></li>
                                <li><a href="#">Stories</a></li>
                                <li><a href="#">Past Projects</a></li>
                                <li><a href="#">Volunteers</a></li>
                                <li><a href="#">Terms and Conditions</a></li>
                                <li><a href="#">About Us</a></li>
                                <li><a href="#">Contact Us</a></li>
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
    </div>
    <!-- footer section end -->
    <!--javascript-->

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>