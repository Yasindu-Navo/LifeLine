<?php
require_once 'Dbh.php';
session_start();
?>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--css-->

    <link rel="stylesheet" href="css/stories.css">
    <link rel="stylesheet" href="css/style.css">

    <title>LIFE LINE</title>
    <link rel="icon" type="image/x-icon" href="images/Logobr.png">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body style="background-color: #e9f5ed">
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
                                    echo '<li class="menu-item"><a href ="#" id="userName">' . $_SESSION["useruid"] . '</a></li>';
                                    echo '<li class="menu-item"><a href ="Logout.php"><img src="images/logout.png" id="logout"> </a></li>';
                                }
                                ?>
                                <!--                                    <a href ="logout.php"><img src="images/logout.png" style="width:40px; height:40px;"></a>-->
                            </li>







                        </ul>

                    </div>
                </div>
            </div>

        </nav>
    </div>
    <!--navigation end-->

    <!--about section start-->
    <div>
        <section class="stories-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="about-text">
                            <div class="section-title ">

                                <h1 class="stories-header">Support Life-Saving Medical Care for Those in Need</h1>
                            </div>
                            <p class="stories-para">Your contribution can make a world of difference in someone's life.
                                By donating essential medical supplies or funds, you help provide critical treatments
                                and resources to individuals who otherwise may not have access. Together, we can ensure
                                that every person, regardless of their financial situation, receives the care they deserve.
                                Let's bring hope and healing to those in need, one donation at a time.s</p>


                        </div>
                    </div>
                    <div class="col-6">
                        <div class="about-pic">
                            <div class="row">

                                <div class=" rounded float-right img2">
                                    <img src="images/image4.jpg" alt="about section" id="storiesimg">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </div>
    <!--about section end-->

    <div class="container1">
        <div class="heading">
            <h1>Meet the Individuals Who Need Your Help</h1>
        </div>
        <?php

        class BenificiaryDetails
        {

            private $db;

            public function __construct($dbConnection)
            {
                $this->db = $dbConnection;
            }

            public function displayDetails()
            {
                try {
                    //  get data from the beneficiary and selectedbeneficiary tables
                    $query = "SELECT 
                        benificiary.benificiaryId, 
                        benificiary.patientName, 
                        benificiary.address, 
                        benificiary.intro, 
                        benificiary.amount, 
                        selectedbenificiary.currentAmount, 
                        benificiary.estimatedDate, 
                        benificiary.image, 
                        benificiary.age 
                    FROM 
                        benificiary 
                    INNER JOIN 
                        selectedbenificiary 
                    ON 
                        benificiary.benificiaryId = selectedbenificiary.benificiaryId
                    WHERE 
                        selectedbenificiary.completed = True";


                    $stmt = $this->db->prepare($query);
                    $stmt->execute();


                    $benificiaries = $stmt->fetchAll(PDO::FETCH_ASSOC);


                    echo '<div class="row  g-3">';
                    foreach ($benificiaries as $benificiary) {
                        $this->makeCards($benificiary);
                    }
                    echo '</div>';
                } catch (PDOException $e) {

                    echo "Error: " . $e->getMessage();
                }
            }

            private function makeCards($benificiary)
            {

                $amount = (int) $benificiary['amount'] ? $benificiary['amount'] : 1;
                $currentAmount = $benificiary['currentAmount'] ? $benificiary['currentAmount'] : 0;

                $depositePercentage = ($currentAmount / $amount) * 100;

                // Convert binary image data to Base64
                if (!empty($benificiary['image'])) {
                    $imageData = base64_encode($benificiary['image']);
                    $imageSrc = 'data:image/jpeg;base64,' . $imageData;
                } else {

                    $imageSrc = 'image/default.jpg';
                }
        ?>
                <div class="col-4">
                    <div class="card h-100 " id="patient_card">
                        <!-- Display the image using Base64 -->

                        <img src="<?php echo $imageSrc; ?>" class="card-img-top" alt="Benificiary Image">
                        <div class="card-body d-flex flex-column">
                            <h3 class="card-title1"><?php echo htmlspecialchars($benificiary['intro']); ?></h3>
                            <p class="card-text1"><?php echo htmlspecialchars($benificiary['patientName']); ?></p>
                            <p class="card-text1" id="text1">Raised: LKR. <?php echo number_format($benificiary['currentAmount'], 2, '.', ','); ?>
                            <p class="card-text1" id="text2">Goal: LKR.<?php echo number_format($benificiary['amount'], 2, '.', ','); ?></p>
                            <p class="card-text1"><small class="text-muted">Operation Date: <?php echo htmlspecialchars($benificiary['estimatedDate']); ?></small></p>

                            <!-- Progress Bar for Deposit -->
                            <div class="progress mb-3">
                                <div class="progress-bar" role="progressbar" style="width: <?php echo round($depositePercentage); ?>%;" aria-valuenow="<?php echo round($depositePercentage); ?>" aria-valuemin="0" aria-valuemax="100">
                                    <?php echo round($depositePercentage); ?>%
                                </div>
                            </div>

                            <!-- Details Button -->
                            <a href="patient_details.php?id=<?php echo $benificiary['benificiaryId']; ?>"><button class="btn-donate" type="button">Donate</button></a>
                        </div>

                    </div>
                </div>
        <?php
            }
        }

        $dbConnector = new Db_connector();
        $connection = $dbConnector->getConnection();
        $benificiaryDetails = new BenificiaryDetails($connection);
        $benificiaryDetails->displayDetails();
        ?>


    </div>








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
    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/js/bootstrap.min.js">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js"></script>
</body>

</html>