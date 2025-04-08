<!DOCTYPE html>
<html lang="en">
<?php
session_start();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--css-->


    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/add_req.css">

    <title>LIFE LINE</title>
    <link rel="icon" type="image/x-icon" href="images/Logobr.png">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var dateInput = document.getElementById("date");
            var today = new Date();
            var minDate = new Date();
            minDate.setMonth(today.getMonth() + 3);
            var month = (minDate.getMonth() + 1).toString().padStart(2, '0');
            var day = minDate.getDate().toString().padStart(2, '0');
            var year = minDate.getFullYear();
            dateInput.min = `${year}-${month}-${day}`;
        });
    </script>

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

                                <a href="add_req.php"><button class="apply">Apply</button></a>
                            </li>
                            <li class="menu-item">
                                <?php
                                //To show username in btn
                                if (isset($_SESSION["username"])) {
                                    echo '<li class="menu-item"><a href ="#"  id="userName">' . $_SESSION["useruid"] . '</a></li>'; /* yet delcare href to ditec the page */
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
    <!--caption section start-->
    <div class="caption">
        <div class="row  mb-5 ">
            <div class="col-md-12">
                <h2 class="heading justify-content-center text-center">Request For The Donation</h2>
                <p class="para1 pt-5">If you are a patient seeking financial assistance for medical operations,
                    we invite you to apply for our donation program through this form. This request form is designed
                    to help us understand your needs and how we can best support you during this time. Before applying,
                    we ask that you carefully read and fully understand the terms and conditions outlined in this form.
                    It’s important that you provide accurate and complete information to ensure a smooth and transparent
                    process.</p>
                <p class="para1 pt-1">Our program aims to offer assistance to those who need it most, and by submitting
                    this request, you agree to comply with the necessary guidelines. Please make sure to review all the
                    details, as this will help us process your application more efficiently and provide the help you need
                    for your medical treatment.</p>
                <p class="para1 pt-1">We are here to support you, and we look forward to reviewing your application with
                    care and understanding.</p>

                <div class="row justify-content-center text-center mb-5 pt-4">
                    <a href="tearmsandcondition.php"><button class="btn btn-success " id="button">Tearms & Condition</button></a>
                </div>
            </div>
        </div>
    </div>
    <!--caption section end-->
    <!--requset start-->

    <section class="request-section">

        <div class="container pt-5 col-8">
            <?php
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
            }
            if (isset($_GET['s'])) {
                if ($_GET['s'] == 0) {
                    echo "
                        <div class='row mb-3'>
                            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                                <strong>Request was failed!!</strong> 
                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>
                        </div>
                        ";
                }
            }
            if (isset($_GET['s'])) {
                if ($_GET['s'] == 2) {
                    echo "
                        <div class='row mb-3'>
                            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                                <strong>Failed to upload image!</strong> 
                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>
                        </div>
                        ";
                }
            }
            if (isset($_GET['s'])) {
                if ($_GET['s'] == 4) {
                    echo "
                        <div class='row mb-3'>
                            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                                <strong>Already Registerd One user can register only one time due to high patient capacity!!</strong> 
                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>
                        </div>
                        ";
                }
            }
            if (isset($_GET['s'])) {
                if ($_GET['s'] == 5) {
                    echo "
                        <div class='row mb-3'>
                            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                                <strong>All fields must be filled!</strong> 
                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>
                        </div>
                        ";
                }
            }
            ?>

            <form class="row g-3 pb-5" method="POST" action="add_req_process.php" enctype="multipart/form-data">
                <h3 class="">Enter Patient Details</h3>
                <div class="col-md-6 pb-3">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Patient Name" required>
                </div>
                <!--                    <div class="col-md-6 pb-3">-->
                <div class=" col-6 pb-3">
                    <input type="text" class="form-control" id="nic" name="patient_nic" placeholder="Patient NIC Number" required>
                </div>

                <div class=" col-12 pb-3">
                    <input type="text" class="form-control" id="adress" placeholder="Patient's Residential Address" name="address" required>
                </div>
                <div class="col-md-6 pb-3">
                    <select id="inputState" class="form-select" name="district" required>
                        <option selected>Select Pateint's District</option>
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

                <div class="col-md-6 pb-3">
                    <select id="inputState" class="form-select" name="oparation_type" required>
                        <option selected>Select Patient's Disease</option>
                        <option value="Heart Disease">Heart Disease</option>
                        <option value="Cancer Disease">Cancer Disease</option>
                        <option value="Kidney Disease">Kidney Disease</option>
                        <option value="liver Disease">liver Disease</option>
                        <option value="Other">other</option>
                    </select>
                </div>
                <div class="col-md-6 pb-3">
                    <input type="date" class="form-control" id="date" name="days" placeholder="Estimated Date For Operation" required>
                </div>

                <div class="col-md-6 pb-3">
                    <input type="text" class="form-control" id="amount" name="amount" placeholder="Amount of Operation" required>
                </div>

                <div class="col-md-6 pb-3">
                    <input type="text" class="form-control" id="Age" name="age" placeholder="Patient's Age" required>
                </div>


                <div class="col-12 pb-3">
                    <p>Add Patient's Image</p>
                    <input type="file" class="form-control" id="image" placeholder="patient's Image" name="image" required>
                </div>



                <div class="col-12 pb-3">
                    <textarea class="form-control" id="condition" style="height: 150px" name="info" placeholder="Enter patient Condiation" required></textarea>
                </div>
                <h3 class="">Annual income</h3>
                <div class="col-md-6 pb-3">
                    <input type="text" class="form-control" id="gardinatname" name="income" placeholder="Gardiant's Annual Income" required>
                </div>


                <h3 class="">Enter Guardian's Details</h3>
                <div class="col-md-6 pb-3">
                    <input type="text" class="form-control" id="gardinatname" name="Guardianname" placeholder="Guardian's Name" required>
                </div>
                <div class="col-md-6 pb-3">
                    <input type="text" class="form-control" id="contact" name="phone" placeholder="Guardian's Contact Number" required>
                </div>
                <h3 class="">Enter Hospital Details</h3>
                <div class="col-12 pb-3">
                    <input type="text" class="form-control" id="hospital" name="hospital" placeholder="Hospital Name" required>
                </div>
                <div class="col-md-6 pb-5">
                    <a><button type="reset" class="btn-req2" name="">Reset</button></a>
                </div>
                <div class="col-md-6 pb-5">
                    <button type="submit" class="btn-req1" name="submit">Submit</button>
                </div>


            </form>


        </div>

    </section>



    <!--request section end-->


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


    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/js/bootstrap.min.js">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js"></script>
</body>

</html>