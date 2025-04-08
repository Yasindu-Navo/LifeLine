<?php
require './dbConnector.php';
session_start();

class CompletedCases
{

    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // display the completed cases for logged-in volunteer
    public function getCompletedCasesByVolunteer($volunteerId)
    {
        try {
            $query = "
                SELECT benificiary.benificiaryId, benificiary.patientName, benificiary.address, benificiary.gardian_No
                FROM benificiary 
                INNER JOIN selectedbenificiary  ON benificiary.benificiaryId = selectedbenificiary.benificiaryId
                WHERE selectedbenificiary.volunteerId = :volunteerId AND selectedbenificiary.completed = TRUE
            ";
            $pstmt = $this->conn->prepare($query);
            $pstmt->bindParam(':volunteerId', $volunteerId, PDO::PARAM_STR);
            $pstmt->execute();

            return $pstmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }
}

// Check if volunteer is logged in
if (!isset($_SESSION['volunteerId'])) {
    echo "<p class='text-danger'>You must be logged in as a volunteer to view this page.</p>";
    exit;
}

try {
    $volunteerId = $_SESSION['volunteerId'];

    // Connect to the database
    $dbConnector = new DbConnector();
    $conn = $dbConnector->getConnection();

    $completedCases = new CompletedCases($conn);
    $cases = $completedCases->getCompletedCasesByVolunteer($volunteerId);
} catch (PDOException $e) {
    echo "<p class='text-danger'>Database Error: " . $e->getMessage() . "</p>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completed Cases</title>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/completedcases.css">

    <!--Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"><!--        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>-->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


</head>

<body id="body">
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
                        <h5 class="offcanvas-title" id="offcanvasNavbarLabel"><img src="images/Logobr.png" alt="Logo" class="logoL"></h5>
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

    <div class="complete">

        <div class="complete-caption ">

            <p>
            <h2 class="fw-bold ">Welcome to your completed cases dashboard!</h2><br> As a dedicated volunteer, the cases listed below represent
            the impact of your hard work and commitment. Each patient has successfully completed their journey
            through our support system, thanks to your efforts. This section provides a summary of those cases,
            including the patient’s name, their address, and their guardian’s contact information. Your continued
            support ensures that more individuals receive the care they need, and we are grateful for your
            invaluable contributions.</p>



        </div>
    </div>

    <!--        welcome section end-->

    <!--table section start-->
    <div class="container_cc">
        <h2 class="pt-5 pb-3">Completed Cases Overview:</h2>
        <div class="" style="padding-bottom: 20px;">
            <a href="volunteerDashboard.php"><button type="button" class="btn-selected ">Volunteer Dashboard</button></a><br>
        </div>
        <?php if (!$cases): ?>
            <div class="alert alert-warning text-center" role="alert">
                No completed cases found for this volunteer.
            </div>
        <?php else: ?>

            <table class="table table-bordered table-striped pt-5">
                <thead>
                    <tr class="text-center">
                        <th>Patient Name</th>
                        <th>Address</th>
                        <th>Guardian Contact</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cases as $case): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($case['patientName']); ?></td>
                            <td><?php echo htmlspecialchars($case['address']); ?></td>
                            <td>0<?php echo htmlspecialchars($case['gardian_No']); ?></td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        <?php endif; ?>
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
</body>

</html>