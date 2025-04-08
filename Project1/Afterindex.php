<?php
include_once 'dbConnector.php';
session_start();
//echo "<script>
//        alert('Session Data: " . json_encode($_SESSION) . "');
//      </script>";

class Review
{
    private $conn;

    public $reviewId;
    public $userId;
    public $name;
    public $comment;
    public $rating;
    public $commentedTime;

    public function __construct()
    {
        $database = new DbConnector();
        $this->conn = $database->getConnection();
    }

    // Save review to database
    public function saveReview($userId, $name, $comment, $rating)
    {
        $query = "INSERT INTO system_review (userId, comment, rating, reviewName, commentedTime) 
                  VALUES (:userId, :comment, :rating, :reviewName, NOW())";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':reviewName', $name);
        $stmt->bindParam(':comment', $comment);
        $stmt->bindParam(':rating', $rating);

        return $stmt->execute();
    }

    // Retrieve the latest 3 reviews
    public function getLatestReviews()
    {
        $query = "SELECT reviewName, comment, rating, commentedTime FROM system_review ORDER BY commentedTime DESC LIMIT 3";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Calculate the overall average rating
    public function getAverageRating()
    {
        $query = "SELECT AVG(rating) as averageRating FROM system_review";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['averageRating'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $comment = $_POST['comment'];
    $rating = $_POST['rating'];


    if (isset($_SESSION['userid'])) {
        $userId = $_SESSION['userid'];

        $review = new Review();
        if ($review->saveReview($userId, $name, $comment, $rating)) {
            header("Location: Afterindex.php?success=1");
            exit();
        } else {
            header("Location: Afterindex.php?error=1");
            exit();
        }
    } else {

        header("Location: Afterindex.php?error=2");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--css-->

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/review.css">



    <title>LIFE LINE</title>
    <link rel="icon" type="image/x-icon" href="images/Logobr.png">

    <!--Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.carousel.min.css">




</head>

<body id="body">
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
                <div class="sidebar offcanvas offcanvas-start " tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                    <!--sidebarbody-->
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasNavbarLabel"><img src="images/Logobr.png" alt="Logo" class="logoL"></h5>
                        <button type="button" class="btn-close pt-5" data-bs-dismiss="offcanvas" aria-label="Close" id="button_dismiss"></button>
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



                            <?php
                            if (isset($_SESSION["username"])) {
                                $volunteer = "Volunteer.php?email=" . $_SESSION["username"];
                            } else {
                                $volunteer = "Volunteer.php?email=";
                            }
                            ?>

                            <li class="menu-item">
                                <a class="navlink" href="<?php echo $volunteer ?>">Volunteer</a>
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
                                    echo  '<li class="menu-item" ><a href ="#" id="userName">' . $_SESSION["useruid"] . '</a></li>'; /*yet delcare href to ditec the page*/
                                    echo '<li class="menu-item"><a href ="Logout.php"><img src="images/logout.png" id="logout" title="Logout"> <a/></li>';

                                    //to go back admin pannel when admin visit home page
                                    require_once 'Dbh.php';
                                    $dbConnector = new Db_connector();
                                    $conn = $dbConnector->getConnection();
                                    $email = $_SESSION['username'];
                                    $sql = "SELECT userType FROM user WHERE userEmail =?";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bindParam(1, $email);
                                    $stmt->execute();
                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                    $result = $stmt->fetch();

                                    if ($result) {
                                        $userType = $result['userType'];
                                        if ($userType == 'Admin') {
                                            echo '<li class="menu-item"><a href ="/New_Admin_Pannel/Admin_conrol.php"> <img src="images/profile_Admin.png" id="logout"  title="Admin Profile"><a/></li>';
                                        }
                                    }
                                    if ($result) {
                                        $userType = $result['userType'];
                                        if ($userType == 'Volunteer') {
                                            echo '<li class="menu-item"><a href ="/Volunteer_pannel/volunteerDashboard.php"> <img src="images/profile_Admin.png" id="logout" title="Volunteer Profile"><a/></li>';
                                        }
                                    }
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




    <!--cover images-->
    <div class="cover">
        <div id="carouselExampleCaptions" class="carousel slide">
            <!--            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                            </div>-->
            <div class="carousel-inner">
                <div class="carousel-item active " id="coveritem">
                    <img src="images/coverimage1.jpg" class="d-block w-100" alt="..." id="coverimage">
                    <div class="gradient-overlay"></div>
                    <div class="carousel-caption ">
                        <h5 class="text-light fw-bolder ">This Is The Mission To<br>Help The Helpless</h5>
                        <p class="text-light">Help Us Make a Difference,Your Generosity Can Change Lives</p>

                        <?php
                        // To show the username in the window
                        if (isset($_SESSION["username"])) { ?>
                            <div class="welcome-message text-light">
                                <p>Hello, <strong><?php echo htmlspecialchars($_SESSION["useruid"]); ?></strong>!</p>
                            </div>
                        <?php
                        }
                        ?>

                        <div clsss="enter">
                            <?php
                            if (!isset($_SESSION['username'])) {
                                echo '<a href="login_User.php"><button type="button" class="apply">Log In</button></a>  <span>&nbsp;&nbsp;&nbsp;</span>';

                                echo '<a href="user_signin2.php"><button type="button" class="apply">Sign In</button></a>';
                            }
                            ?>
                        </div>

                    </div>


                </div>
                <div class="carousel-item" id="coveritem">
                    <img src="images/Hope1.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption ">
                        <h5>Show Your Love For The Humanity</h5>
                        <p>Lets Chenge The Sri Lanka With Humanity</p>
                        <h3>Hello <?php
                                    //To show username in window
                                    if (isset($_SESSION["username"])) {
                                        echo $_SESSION["username"];
                                    }
                                    ?></h3>
                    </div>
                </div>
                <div class="carousel-item" id="coveritem">
                    <img src="images/bg_1.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption">
                        <h5>Your Donation Is Others Inspiration</h5>
                        <p>Doing Nothing Is Not An Option Of Our Life</p>
                        <h3>Hello <?php
                                    //To show username in window
                                    if (isset($_SESSION["username"])) {
                                        echo $_SESSION["username"];
                                    }
                                    ?></h3>
                    </div>
                </div>
            </div>
            <!--            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>-->
        </div>
    </div>
    <!-- cover section end-->



    <!-- service icon section strat-->
    <div style="padding-left: 10%; padding-right: 10%;" class="service">
        <div class="container my-5 pt-4">
            <div class="row text-center">
                <div class="col-md-3">
                    <div class="service-icon">
                        <img style="width:80px; height: 80px;" src="images/charity services.png" alt="Service 1" class="img-fluid">
                    </div>
                    <div class="service-text fw-bold">Charity Service</div>
                </div>
                <div class="col-md-3">
                    <div class="service-icon">
                        <img style="width:80px; height: 80px;" src="images/securiy.png" alt="Service 2" class="img-fluid">
                    </div>
                    <div class="service-text fw-bold">Security</div>
                </div>
                <div class="col-md-3">
                    <div class="service-icon">
                        <img style="width:80px; height:80px;" src="images/donete1.png" alt="Service 3" class="img-fluid">
                    </div>
                    <div class="service-text fw-bold">Make Donations</div>
                </div>
                <div class="col-md-3">
                    <div class="service-icon">
                        <img style="width:80px; height: 80px;" src="images/volunteer_1.png" alt="Service 4" class="img-fluid">
                    </div>
                    <div class="service-text fw-bold ">Be a Volunteer</div>
                </div>
            </div>
        </div>
    </div>
    <!-- service icon section end-->


    <!--  counter section start-->
    <div class="countersection">
        <div class="container">
            <div class="row row-cols-1 row-cols-xl-3 g-0">
                <!-- Counter Box -->
                <div class="col-lg-12">
                    <div class="counter-box1">
                        <h3>Served Over</h3>
                        <h1 id="counter">0</h1>

                        <h3>People's Life in Sri Lanka</h3>

                    </div>
                </div>
                <!-- Description Box -->
                <div class="col-lg-6">
                    <div class="counter-box2">
                        <h3>Donate Money</h3>
                        <p>Your donation can make a big difference in someone's life. Every contribution counts!</p>
                        <a href="Stories.php"><button class="btn btn-light">Donate Now</button></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="counter-box3">
                        <h3>Be a Volunteer</h3>

                        <p>Make a difference—be a volunteer and help others in need.</p>
                        <a href="Volunteer.php"><button class=" btn btn-light">Be a Volunteer</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--counter section end-->

    <!--why us? start-->
    <div class="whyus">
        <div class="row justify-content-center text-center  ">
            <div class="row justify-content-center text-center">
                <h2 class="whyus-caption">Why LIFE LINE ?</h2>
            </div>
            <div>
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <div class="col">
                        <div class="card " id="whyus-card">
                            <div class="card-body">
                                <img src="images/secure.png" alt="">
                                <h5 class="whyus-card-title">Secure And Trustworthy</h5>
                                <p class="card-text">Select those in who need help and use secure money transfer methods.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-250" id="whyus-card">

                            <div class="card-body">
                                <img src="images/anyone.png" alt="">
                                <h5 class="whyus-card-title">Any One Can Apply</h5>
                                <p class="card-text">Ability to request help and apply to join the volunteer group for anyone registered with the system.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-250" id="whyus-card">
                            <div class="card-body">
                                <img src="images/volunteer.png" alt="">
                                <h5 class="whyus-card-title">Volunteer Community</h5>
                                <p class="card-text">Island wide volunteer community,will verify the authenticity of applicant information.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="whyus-bottom pb-5">
                <p class="pt-4">For More Information</p>
                <a href="tearmsandcondition.php"><button class="btn btn-success ">Terms & Conditions</button></a>
            </div>
        </div>
    </div>
    <!--why us ? end-->


    <!--about section start-->
    <div>
        <section class="aboutus-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="about-text">
                            <div class="section-title ">
                                <span>About Us</span>
                                <h2>The LIFE LINE</h2>
                            </div>
                            <p class="f-para">We – the concerned citizens of Sri Lanka – initiated this campaign with the support
                                of the Sri Lanka College of Paediatricians to gather funds to expedite the construction.</p>
                            <p class="s-para">The Cardiac and Critical Care Complex is a government-approved project deemed a
                                national priority. If we go through the usual process,</p>
                            <a href="About.php" class="btn btn-success about-btn">Read More</a>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="about-pic">
                            <div class="row">

                                <div class="rounded float-right img2">
                                    <img src="images/index-about.jpeg" alt="about section">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!--about section end-->

    <!--our donations section start-->
    <section style="padding-left: 10%; padding-right: 10%; padding-bottom: 50px;" id="testimonial_area" class="section_padding ">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-center">
                        <h1>Life Line's Donations</h1>
                    </div>
                    <div class="testmonial_slider_area  owl-carousel ">
                        <div class="card">
                            <img src="images/Donation1.jpg" class="card-img-top" alt="...">
                            <div class="card-body ">

                                <p class="card-text fw-bold">A stock of essential equipment and dry food items and equipment needed for clinic work to Karapitiya Hospital.</p>
                                <p class="card-text fw-bold">Date:23/July/2023</p>

                            </div>
                        </div>

                        <div class="card">
                            <img src="images/Donation2.jpg" class="card-img-top" alt="...">
                            <div class="card-body">

                                <p class="card-text fw-bold">Rs.2000000 worth of childern sport equipment and childern milk powerd,a stock of essential items to the General Hospital,Colombo.</p>
                                <p class="card-text fw-bold">Date:23/May/2024</p>
                            </div>
                        </div>

                        <div class="card">
                            <img src="images/Donation3.jpg" class="card-img-top" alt="...">
                            <div class="card-body">

                                <p class="card-text fw-bold">A stock of modern medical equipment worth Rs.12000000 to Apeksha Hospital.</p>
                                <p class="card-text fw-bold">Date:23/May/2024</p>
                            </div>
                        </div>

                        <div class="card">
                            <img src="images/Donation4.jpg" class="card-img-top" alt="...">
                            <div class="card-body">

                                <p class="card-text fw-bold">A stock of modern medical equipment worth Rs.36000000 to Matara General Hospital.</p>
                                <p class="card-text fw-bold">Date:23/May/2024</p>
                            </div>
                        </div>

                        <div class="card">
                            <img src="images/Donation5.jpg" class="card-img-top" alt="...">
                            <div class="card-body">

                                <p class="card-text fw-bold">A stock of intensive care unit equipment worth 10 million rupees to te Kandy General hospital.</p>
                                <p class="card-text fw-bold">Date:21/April/2024</p>
                            </div>
                        </div>

                        <div class="card">
                            <img src="images/Donation.jpg" class="card-img-top" alt="...">
                            <div class="card-body">

                                <p class="card-text fw-bold">A stock of essential equipment for patient clinics to jaffna General Hospital.</p>
                                <p class="card-text fw-bold">Date:04/August/2024</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--our donations section end-->




    <!--bank statement section start-->
    <div class="pt-5">
        <div class="statement pt-5">
            <div class="caption container">
                <h1>We Guarantee Complete Transparency Regarding Your Contribution</h1>
                <p>We are committed to give all the monetary donations made by you to the persons
                    who need it at the right time.All those money receipts and payments are done through
                    one bank account that we own, and you can get a report of all those transactions monthly
                    through our website,</p>
                <a href="bankstatement.php"><button class="btn btn-dark">Bank Statement</button></a>
            </div>

        </div>
    </div>
    <!-- bank statement section end-->

    <!--Success Stories start-->
    <div class="successstories">
        <div class="container pt-5 ">
            <div class="successstories-heading text-center ">
                <h3 class="pt-5">Success of Life Line</h3>
            </div>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <div class="col">
                    <div class="card h-100">
                        <img src="images/R_patient2.jpg" class="card-img-top" alt="...">
                        <div class="card-body">

                            <p class="card-text fw-bold">Senuri Aditya is a 1.5 year old girl, she was suffering from breast cancer and we were able to collect 1200000.00 rupees for her surgery.</p>
                            <p>Date:02-August-2024</p>

                        </div>

                    </div>
                </div>
                <div class="col">
                    <div class="card h-100">
                        <img src="images/R_patient3.jpg" class="card-img-top" alt="...">
                        <div class="card-body">

                            <p class="card-text fw-bold">Supipi Perera is a 4-year-old Sigithi girl. We were able to find 1000000.00 rupees in a very short time for her foot surgery.</p>
                            <p>Date:04-January-2024</p>

                        </div>

                    </div>
                </div>
                <div class="col">
                    <div class="card h-100">
                        <img src="images/R_patient4.jpg" class="card-img-top" alt="...">
                        <div class="card-body">

                            <p class="card-text fw-bold">Aditya Punchiheva is a 1-year-old child. We have found an amount of Rs. 2400000.00 for the cancer surgery he was suffering from.</p>
                            <p>Date:23-July-2024</p>

                        </div>

                    </div>
                </div>


            </div>
            <div class="d-flex justify-content-center align-items-center">
                <div class="whyus-bottom pb-5 text-center">
                    <p class="pt-2">For More Information</p>
                    <a href="past_project.php">
                        <button class="btn btn-success">Read More</button>
                    </a>
                </div>
            </div>

        </div>
    </div>

    <!--Success Stories end-->


    <!--vission section start-->
    <div class="pt-5">
        <div class="vission pt-5">
            <div class="vissioncaption container">
                <h1>Vission Of Life Line Team</h1>
                <p>Sri Lanka has been a country with very low per capita income for many years, which means that there are
                    very few people in this country who have money saved to get life insurance or an emergency.
                    Because of this, a large number of us die prematurely due to non-communicable diseases.
                    This platform is for them. How do you usually get money for a surgery? By getting on the buses
                    and talking and handing out pamphlets. It is a question whether the patient will get the money from
                    these methods, this is the perfect solution to all these things. We take responsibility for all money.</p>

            </div>

        </div>
    </div>
    <!-- vission section end-->
    <!--review section start-->
    <div class="comment-section">
        <div class="container mt-5 col-12 ">
            <div class="row">
                <h2 class="pb-4">Your Feedback Matters</h2>

                <!-- Review Form -->
                <div class="col-6 pt-2">
                    <h4 class="">Add Reviews</h4>
                    <form action="" method="POST">
                        <div class="mb-3 pt-2">

                            <input type="text" class="form-control" id="name" name="name" required placeholder="Name">
                        </div>
                        <div class="mb-3">

                            <textarea class="form-control" id="comment" name="comment" rows="3" required placeholder="Add Review "></textarea>
                        </div>
                        <div class="mb-3">
                            <h4>Rate Us!</h4>
                            <div class="star-rating pb-5" style="justify-content: left;">
                                <i class="fa fa-star" data-rating="1"></i>
                                <i class="fa fa-star" data-rating="2"></i>
                                <i class="fa fa-star" data-rating="3"></i>
                                <i class="fa fa-star" data-rating="4"></i>
                                <i class="fa fa-star" data-rating="5"></i>
                            </div>
                            <input type="hidden" name="rating" id="rating" value="0" required>
                        </div>
                        <button type="submit" class="apply">Submit Review</button>
                    </form>
                </div>
                <div class="col-6 ps-5">
                    <h3 class="pb-4">Latest Reviews</h3>
                    <div id="overall-rating">
                        <!-- This will display the overall average rating -->
                        <?php
                        include_once 'Afterindex.php';
                        $review = new Review();
                        $averageRating = $review->getAverageRating();
                        echo "<h5>Overall Rating: " . number_format($averageRating, 1) . "/5</h5>";
                        ?>
                    </div>

                    <div id="reviews">
                        <?php
                        $latestReviews = $review->getLatestReviews();
                        if ($latestReviews) {
                            foreach ($latestReviews as $rev) {
                                echo "<div class='review'>";
                                echo "<h5>" . htmlspecialchars($rev['reviewName']) . " " . generateStars(htmlspecialchars($rev['rating'])) . "</h5>";
                                echo "<p>" . htmlspecialchars($rev['comment']) . "</p>";
                                //                                    echo "<small>Posted on: " . htmlspecialchars($rev['commentedTime']) . "</small>";

                                echo "</div>";
                            }
                        } else {
                            echo "<p>No reviews yet.</p>";
                        }

                        // Function to generate star ratings
                        function generateStars($rating)
                        {
                            $fullStars = floor($rating); // Full stars
                            $halfStar = ($rating - $fullStars >= 0.5) ? 1 : 0; // Half star
                            $emptyStars = 5 - ($fullStars + $halfStar); // Empty stars

                            $output = '';

                            // Output full stars
                            for ($i = 0; $i < $fullStars; $i++) {
                                $output .= '<i class="fa fa-star" style="color: #FFD700;"></i>';
                            }

                            // Output half star if applicable
                            if ($halfStar) {
                                $output .= '<i class="fa fa-star-half-alt" style="color: #FFD700;"></i>';
                            }

                            // Output empty stars
                            for ($i = 0; $i < $emptyStars; $i++) {
                                $output .= '<i class="fa fa-star" style="color: gray;"></i>';
                            }

                            return $output;
                        }
                        ?>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <!--review section end-->



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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/js/bootstrap.min.js">
    <script>
        $(".testmonial_slider_area").owlCarousel({
            autoplay: true,
            slideSpeed: 500,
            items: 3,
            loop: true,
            nav: true,
            navText: ['<i class="fa fa-arrow-left"></i>', '<i class="fa fa-arrow-right"></i>'],
            margin: 30,
            dots: true,
            responsive: {
                320: {
                    items: 1
                },
                767: {
                    items: 2
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 3
                }
            }

        });

        // Handle star rating selection
        //            let stars = document.querySelectorAll('.star-rating .fa');
        //            let ratingInput = document.getElementById('rating');
        //
        //            stars.forEach(star => {
        //                star.addEventListener('click', function () {
        //                    let rating = this.getAttribute('data-rating');
        //                    ratingInput.value = rating;
        //                    // Reset all stars
        //                    stars.forEach(s => s.classList.remove('checked'));
        //                    // Highlight selected stars
        //                    for (let i = 0; i < rating; i++) {
        //                        stars[i].classList.add('checked');
        //                    }
        //                });
        //            });
    </script>
    <!--javascript-->
    <script src="JavaScript/style.js"></script>
    <script src="javascript/scripts.js"></script>

</body>

</html>