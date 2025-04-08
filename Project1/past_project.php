<?php
require 'Dbh.php';
session_start();

$dbcon = new Db_connector();
$conn = $dbcon->getConnection();

$query = "SELECT * FROM paststory ORDER BY storyId DESC";
$stmt = $conn->query($query);
$rs = $stmt->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--css-->


    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/past_project.css">
    <title>Stories</title>


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
                                if (isset($_SESSION["username"])) {
                                    echo '<a href="add_req.php"><button class="apply">Apply</button></a>';
                                }
                                ?>
                            </li>
                            <li class="menu-item">
                                <?php
                                //To show username in btn
                                if (isset($_SESSION["username"])) {
                                    echo '<li class="menu-item"><a href ="#" id="userName">' . $_SESSION["useruid"] . '</a></li>'; /* yet delcare href to ditec the page */
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

    <!--heading part-->

    <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2000">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="images/bg1pp.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block ">
                    <h1 class="text-center">Our Past Stories </h1>
                    <!--                    <p class="h4">We brought back their smiles</p>-->

                </div>
            </div>
            <div class="carousel-item">
                <img src="images/bg2pp.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h1 class="text-center">We’ve turned despair into joy</h1>
                    <!--                    <p class="h4">We’ve turned despair into joy</p>-->
                </div>
            </div>
            <div class="carousel-item">
                <img src="images/bg3pp.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h1 class="text-center">Your kindness rewrites destinies</h1>
                    <!--                    <p class="h4">Your kindness rewrites destinies</p>-->
                </div>
            </div>
        </div>
    </div>

    <!--heading part-->

    <!--Past stories start-->
    <div class="past_project">
        <div class="container ">
            <div class="card mb-4 border-0">
                <div class="row">
                    <?php foreach ($rs as $row): ?>
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="card h-100">
                                <img src="../New_Admin_Pannel/upload/<?php echo htmlspecialchars($row->image); ?>" class="card-img-top" alt="Image">

                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($row->title )?></h5>
                                    <p class="card-text"><?php echo htmlspecialchars($row->content); ?></p>
                                    <p class="card-text"><small class="text-muted"><?php echo htmlspecialchars($row->date); ?></small></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <!--Past stories end-->



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

    <!--footer section end-->
    <!-- Link to the external JavaScript file -->
    <script src="JavaScript/past_story.js">

    </script>


    <!--javascript-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/js/bootstrap.min.js">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js"></script>
</body>

</html>