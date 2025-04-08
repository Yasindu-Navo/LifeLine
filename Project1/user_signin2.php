<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--css-->
    <link rel="stylesheet" href="css/user_signin.css">
    <link rel="stylesheet" href="css/style.css">
    <title>LIFE LINE</title>
    <link rel="icon" type="image/x-icon" href="images/Logobr.png">

    <title>Sign Up</title>
    <!--bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        /* Password strength feedback styling */
        .password-feedback {
            font-size: 0.9em;
            color: red;
            margin-top: 5px;
        }

        .password-feedback.valid {
            color: green;
        }
    </style>
</head>

<body>
    <!--navigation start-->
    <div>
        <nav class="navbar navbar-expand-lg vh-10 overflow-hidden fixed-top" id="nav-color">
            <div class="container ">
                <a href="Afterindex.php" id="logo-img"><img src="images/Logobr.png" alt=""></a>
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
    <section class="signin-form ">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                    <div class="card mt-5">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 d-none d-md-block" id="signin1">
                                <a href="index.php">
                                    <img src="images/Logobr.png" alt="sign-in form" class="img-fluid">
                                </a>
                                <p class="psignin text-center">This Is The Mission</p>
                                <p class="psignin text-center"> To Help The Helpless</p>
                            </div>

                            <div class="col-md-6 col-lg-7 d-flex align-items-center" id="form1">
                                <div class="card-body p-4 p-lg-5 text-black">
                                    <form class="row g-3" method="POST" action="../Login_page/includes/Signup.php" onsubmit="return validatePassword();">
                                        <div class="fheader text-center">
                                            <h1>User Sign Up</h1>
                                        </div>
                                        <div class="form-floating col-12">
                                            <input type="text" class="form-control" id="inputname" name="name" placeholder="Name" required>
                                            <label for="inputname" class="ms-2">Name</label>
                                        </div>

                                        <div class="form-floating col-12">
                                            <input type="text" class="form-control" id="inputuser" name="username" placeholder="Username" required>
                                            <label for="inputuser" class="ms-2">User Name</label>
                                        </div>

                                        <div class="form-floating col-12">
                                            <input type="email" class="form-control" id="inputEmail4" name="email" placeholder="Email" required>
                                            <label for="inputEmail4" class="ms-2">Email</label>
                                        </div>

                                        <div class="form-floating col-12">
                                            <input type="password" class="form-control" id="inputpw" name="Password" placeholder="Password" onkeyup="checkPasswordStrength();" required>
                                            <label for="inputpw">Password</label>
                                            <div class="password-feedback" id="password-feedback"></div>
                                        </div>

                                        <div class="form-floating col-12">
                                            <input type="password" class="form-control" id="rePassword" name="rePassword" placeholder="Re-enter password" required>
                                            <label for="rePassword">Re-enter Password</label>
                                        </div>

                                        <input type="hidden" name="usertype" value="User">
                                        <div class="d-grid gap-2 col-12 mx-auto mt-3 " id="blogin">
                                            <button class="btn btn-success " name="SignUp" type="submit" id="btnsignup">Sign Up</button>
                                        </div>

                                        <div class="ffooter"></div>
                                    </form>

                                    <div class="row justify-content-center">
                                        <?php
                                        if (isset($_GET["error"])) {
                                            if ($_GET["error"] == "emptyInput") {
                                                echo '<div class="alert alert-danger" role="alert">All the fields must be filled!</div>';
                                            } else if ($_GET["error"] == "invalidUid") {
                                                echo '<div class="alert alert-danger" role="alert">Invalid username!</div>';
                                            } else if ($_GET["error"] == "invalidEmail") {
                                                echo '<div class="alert alert-danger" role="alert">Invalid Email!</div>';
                                            } else if ($_GET["error"] == "pwdMatch") {
                                                echo '<div class="alert alert-danger" role="alert">Passwords do not match!</div>';
                                            } else if ($_GET["error"] == "stmt") {
                                                echo '<div class="alert alert-danger" role="alert">Something went wrong!</div>';
                                            } else if ($_GET["error"] == "none") {
                                                echo '<div class="alert alert-success" role="alert">Account created successfully!</div>';
                                            } else if ($_GET["error"] == "uidExists") {
                                                echo '<div class="alert alert-danger" role="alert">User already exists!</div>';
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
        </div>
    </section>
    <!--logging form end-->
    <!-- footer section start -->
    <div class="content">
        <div class="container">
            <div class="single-content"></div>
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
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single-box">
                        <h3>About Us</h3>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem, quas.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single-box">
                        <h3>Contact</h3>
                        <p>+00 123 456 789</p>
                        <p>info@example.com</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single-box">
                        <h3>Follow Us</h3>
                        <div class="social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gyb9kZq1V2FlW0pS4g6w3fMZMLDPT1uFmI68Wl0GTVZZKON6U8" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-9Xx+0Q+3Q8T0N6OBoNEO2b7Nm0Bzmg21Z65n41C2UOnlAgOsYxrOQyU5f+6u3I1Y" crossorigin="anonymous"></script>

    <script>
        function checkPasswordStrength() {
            const password = document.getElementById('inputpw').value;
            const feedback = document.getElementById('password-feedback');
            let strength = '';

            // Check password criteria
            if (password.length < 8) {
                strength = 'Password must be at least 8 characters long.';
            } else if (!/[A-Z]/.test(password)) {
                strength = 'Password must contain at least one uppercase letter.';
            } else if (!/[a-z]/.test(password)) {
                strength = 'Password must contain at least one lowercase letter.';
            } else if (!/[0-9]/.test(password)) {
                strength = 'Password must contain at least one digit.';
            } else if (!/[^A-Za-z0-9]/.test(password)) {
                strength = 'Password must contain at least one special character.';
            } else {
                strength = 'Strong password!';
                feedback.classList.add('valid');
            }

            feedback.textContent = strength;
            feedback.classList.remove('valid');
        }

        function validatePassword() {
            const password = document.getElementById('inputpw').value;
            const feedback = document.getElementById('password-feedback');
            // Check password strength again before submission
            if (password.length < 8 || !/[A-Z]/.test(password) || !/[a-z]/.test(password) || !/[0-9]/.test(password) || !/[^A-Za-z0-9]/.test(password)) {
                feedback.textContent = 'Please ensure your password meets all the strength requirements.';
                return false; // Prevent form submission
            }
            return true; // Allow form submission
        }
    </script>
</body>

</html>