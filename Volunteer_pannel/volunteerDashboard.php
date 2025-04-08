<?php
require './dbConnector.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Dashboard</title>
    <!--Bootstrap-->
    <!--Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"><!--        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>-->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/volunteer_dashboard.css">

</head>

<body>
    <!--navigation start-->

    <div>
        <nav class="navbar navbar-expand-lg  vh-10 overflow-hidden fixed-top" id="nav-color">

            <a href="index.php" id="logo-img"><img src="images/Logobr.png" alt=""></a>
            <div class="container ">
                <!--button-->

                <button class="navbar-toggler shadow-none border-0 ms-auto" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" id="toggler_button">
                    <span class="navbar-toggler-icon pt-5"></span>
                </button>
                <!--sidebar-->
                <div class="sidebar offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                    <!--sidebarbody-->
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasNavbarLabel"><img src="images/logo3.png" alt="Logo" class="logoL"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>

                    <div div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                            <li class="menu-item">
                                <a class="navlink" href="../Project1/Afterindex.php">Home </a>
                            </li>
                            <li class="menu-item">
                                <a class="navlink" href="../Project1/Stories.php">Stories </a>
                            </li>
                            <li class="menu-item">
                                <a class="navlink" href="../Project1/past_project.php">Past Projects</a>
                            </li>
                            <li class="menu-item">
                                <a class="navlink" href="../Project1/Volunteer.php">Volunteer</a>
                            </li>
                            <li class="menu-item">
                                <a class="navlink" href="../Project1/About.php">About Us</a>
                            </li>
                            <li class="menu-item">
                                <a class="navlink" href="../Project1/Contact_us.php">Contact Us</a>
                            </li>
                            <!--                                <li class="menu-item">
                                
                                                                    <a href="add_req.php"><button class="apply">Apply</button></a>
                                                                </li>-->
                            <li class="menu-item">
                                <?php
                                //To show username in btn
                                if (isset($_SESSION["username"])) {
                                    echo '<li class="menu-item"><a href ="#"  id="userName">' . $_SESSION["useruid"] . '</a></li>'; /* yet delcare href to ditec the page */
                                    echo '<li class="menu-item"><a href ="Logout.php"><img src="image/logout.png" id="logout" > <a/></li>';
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
    <!--  vol-welcome section start-->
    <div>
        <section class="selectionsection">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="about-text">
                            <div class="section-title ">

                                <h1 class="stories-header">Together, we can make a difference</h1>
                            </div>
                            <p class="stories-para pt-5">Every act of kindness, no matter how small, creates a ripple of change.
                                As a volunteer, you have the power to brighten lives, strengthen communities, and make a
                                lasting impact. By giving your time and heart, you become a beacon of hope for those in need.
                                Together, we can build a world where compassion and care lead the way. Join us in this
                                rewarding journey of making a difference—one step, one smile, one life at a time.</p>


                        </div>
                    </div>
                    <div class="col-6">
                        <div class="about-pic">
                            <div class="row">

                                <div class=" rounded float-right img2">
                                    <img src="images/vol01.jpg" alt="about section">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </div>
    <!--  vol-welcome section end-->


    <!-- beneficiary list table start-->
    <div class="ben-table">
        <div class="container">
            <h2 class="mt-5">Volunteer Dashboard</h2>

            <a href="selected_beneficiaries.php"><button type="button" class="btn-selected">Selected Cases</button></a>
            <a href="completedCases.php"><button type="button" class="btn-selected">Completed Cases</button></a>
            <form id="submitForm">
                <table class="table table-bordered mt-3" id="beneficiaryTable">
                    <thead>
                        <!--                            <tr>

                                <th>Patient Name</th>
                                <th>Address</th>
                                <th>District</th>
                                <th>Contact Number</th>
                                <th>Select</th>
                            </tr>-->
                    </thead>
                    <tbody>
                        <!-- Data will be inserted here  -->
                    </tbody>
                </table>
                <button type="submit" class="btn-submit">Submit</button>
            </form>
        </div>
    </div>

    <!-- beneficiary list table end-->
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
                            <li><a href="../Project1/Afterindex.php">Home</a></li>
                            <li><a href="../Project1/Stories.php">Stories</a></li>
                            <li><a href="../Project1/past_project.php">Past Projects</a></li>
                            <li><a href="../Project1/Volunteer.php">Volunteers</a></li>
                            <li><a href="../Project1/tearmsandcondition.php">Terms and Conditions</a></li>
                            <li><a href="../Project1/About.php">About Us</a></li>
                            <li><a href="../Project1/Contact_us.php">Contact Us</a></li>
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
    <script>
        $(document).ready(function() {
            function fetch_data() {
                $.ajax({
                    url: "fetchdata.php",
                    method: "GET",
                    success: function(data) {
                        $('#beneficiaryTable tbody').html(data);
                    }
                });
            }

            fetch_data(); // Initial fetch

            setInterval(fetch_data, 5000); // Update every 5 seconds

            $('#submitForm').on('submit', function(event) {
                event.preventDefault();
                $.ajax({
                    url: "submit.php",
                    method: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        alert(response);
                        fetch_data();
                    }
                });
            });
        });
    </script>
</body>

</html>