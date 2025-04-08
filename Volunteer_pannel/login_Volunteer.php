<?php
require './dbConnector.php';

session_start();

if (isset($_SESSION['uname'])) {
    header("location:index.php");
    exit();
} else {
    ?>


    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <!--css-->
            <link rel="stylesheet" href="css/login_volunteer.css">


            <title>LIFE LINE</title>
            <link rel="icon" type="image/x-icon" href="images/logo3.png">

            <!--bootstrap-->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        </head>
        <body>
            <!--logging form start-->
            <section class="login-form">
                <div class="container py-5 h-100">
                    <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="col col-xl-10">
                            <div class="card" >
                                <div class="row g-0">
                                    <div class="col-md-6 col-lg-5 d-none d-md-block">
                                        <img src="image/vol.jpg" alt="login form" class="img-fluid">
                                    </div>
                                    <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                        <div class="card-body p-4 p-lg-5 text-black">

                                            <form action="loginProcess.php" method="POST">

                                                <h5 class=" mb-2 pb-3">Get Access to your Account</h5>

                                                <div class="form-outline mb-2">
                                                    <input type="text" id="vol_email" class="form-control form-control-lg" />
                                                    <label class="form-label" for="vol_email" name="uname">User Name</label>
                                                </div>

                                                <div  class="form-outline mb-2">
                                                    <input type="password" id="vol_password" class="form-control form-control-lg" />
                                                    <label class="form-label" for="vol_password" name="pwd">Password</label>
                                                </div>

                                                <div class="mb-2">
                                                    <button type="submit" class="btn btn-success" name="btnSubmit">Login</button>
                                                </div>

                                                <div>
                                                    <a href="#" class="text-decoration-none">Forgot password?</a>
                                                    <p class="mb-0 pb-lg-2" >Don't have an account? <a href="Volunteer.php" class="text-decoration-none">Register here</a></p>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <!--logging form end-->


            <!--javascript-->
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>      

        </body>
    </html>
    <?php
}
?>
