<?php
require_once 'Dbh.php';
session_start();

class selectedBenificiaryDetails
{

    private $dbConnection;
    private $benificiaryId;

    public function __construct($benificiaryId)
    {
        $this->dbConnection = (new Db_connector())->getConnection();
        $this->benificiaryId = $benificiaryId;
    }

    public function getDetails()
    {
        $query = "SELECT benificiary.benificiaryId, benificiary.patientName, benificiary.address, benificiary.intro, benificiary.amount, selectedbenificiary.currentAmount, benificiary.estimatedDate, benificiary.image 
                  FROM 
                        benificiary 
                  INNER JOIN 
                        selectedbenificiary  
                  ON benificiary.benificiaryId = selectedbenificiary.benificiaryId
                  WHERE benificiary.benificiaryId = :benificiaryId";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':benificiaryId', $this->benificiaryId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

class DonationHandler
{

    private $dbConnection;

    public function __construct()
    {
        $this->dbConnection = (new Db_connector())->getConnection();
    }

    // Save donations in donations table
    // update the Deposite value in beneficiarydetails table
    // display blessing messages, donor names, and dates
    public function getBlessingMessages($benificiaryId)
    {
        $query = "SELECT donateName, blessingMassage
                    FROM donation
                    WHERE benificiaryId = :benificiaryId
                    ORDER BY donationId DESC
                    LIMIT 2";

        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':benificiaryId', $benificiaryId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

if (isset($_GET['id']) && !empty($_GET['id'])) {  //display Benifciary details
    $benificiaryId = $_GET['id'];
    $benificiaryDetails = new selectedBenificiaryDetails($benificiaryId);
    $benificiary = $benificiaryDetails->getDetails();
} else {

    // header("Location: Stories.php");
    //exit();
}


// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $donorName = $_POST['donatename'];
// //    $donorEmail = $_POST['donar_email'];
//     $amount = $_POST['amountofdonate'];
//     $blessingmassage = $_POST['blessingmassage'];
//     $donationHandler = new DonationHandler();
//     $result = $donationHandler->savedonation($donorName, $amount, $blessingmassage, $benificiaryId);
//     if ($result) {
//         echo "Donation saved successfully!";
//     } else {
//         echo "Failed to save the donation. Please try again.";
//     }
// }
// Fetch blessing messages if beneficiary ID is set
$donationHandler = new DonationHandler();
$blessingMessages = $donationHandler->getBlessingMessages($benificiaryId);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIFE LINE</title>
    <link rel="icon" type="image/x-icon" href="images/Logobr.png">

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/patient_details.css">
    <!--Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!--  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>-->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- payment Gateway -->
    <script src="javascript/donate.js"></script>
    <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>


    <script type="text/javascript">
        // Function to validate form input
        function validateForm() {
            // Get form inputs
            const name = document.getElementById('donorName').value;
            const message = document.getElementById('blessingmassage').value;
            const amount = document.getElementById('amount').value;

            // check if fields are filled
            if (name === "" || message === "" || amount === "") {
                alert("Please fill out all the fields before donating.");
                return false;
            }

            // if amount is a positive number
            if (isNaN(amount) || amount <= 0) {
                alert("Please enter a valid donation amount.");
                return false;
            }

            return true;
        }



        function handleDonate(beneficiaryId) {
            if (validateForm()) {
                const amount = document.getElementById('amount').value;
                const message = document.getElementById('blessingmassage').value;
                const name = document.getElementById('donorName').value;
                buynow(beneficiaryId, amount, message, name);

            }
        }
    </script>










</head>

<body style="background-color: #f2f7f4">
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

    <!--selected patient and donation form section start-->
    <div class="container2 mt-5 ">
        <div class="row justify-content-center">

            <div class="col-md-12 col-lg-12 d-flex flex-wrap">
                <!-- selected patinet details Section -->
                <div class="col-md-6 p-2">
                    <div class="card " id="patient_card">
                        <img src="<?php echo !empty($benificiary['image']) ? 'data:image/jpeg;base64,' . base64_encode($benificiary['image']) : 'image/default.jpg'; ?>" class="card-img-top" alt="Beneficiary Image">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($benificiary['intro']); ?></h5>
                            <p class="card-text1"><strong>Name:</strong> <?php echo htmlspecialchars($benificiary['patientName']); ?></p>
                            <p class="card-text1"><strong>Address:</strong> <?php echo htmlspecialchars($benificiary['address']); ?></p>
                            <p class="card-text1"><strong>Goal: LKR.</strong><?php echo number_format($benificiary['amount'], 2, '.', ','); ?></p>
                            <p class="card-text1"><strong>Raised: LKR.</strong><?php echo number_format($benificiary['currentAmount'], 2, '.', ','); ?></p>
                            <p class="card-text1"><small class="text-muted">Operation Date: <?php echo htmlspecialchars($benificiary['estimatedDate']); ?></small></p>
                        </div>
                    </div>
                </div>

                <!-- donation form Section -->
                <div class="col-md-6 p-2">
                    <div class="donation-form">
                        <h3>Make Your Donation</h3>
                        <p>Your generosity helps drive positive change and support important causes. Whether you’re
                            contributing to a project, community effort, or charitable organization, every donation counts.
                            Our secure and user-friendly interface ensures that your payment process is smooth and efficient.
                            Thank you for making a difference with your contribution!</p>
                        <form>
                            <div class="mb-3">
                                <input type="text" class="form-control" id="donorName" name="donatename" placeholder="Donor's Name">
                            </div>
                            <!--                                <div class="mb-3">
                                
                                                                    <input type="email" class="form-control" id="donorEmail" name="donar_email" required placeholder="Donor's Email">
                                                                </div>-->
                            <div class="mb-3">

                                <input type="text" class="form-control" id="amount" name="amountofdonate" placeholder="Amount">
                            </div>
                            <div class="mb-3">

                                <textarea class="form-control" id="blessingmassage" name="blessingmassage" placeholder="Add Your Blessing" rows="3" cols="50"></textarea>
                            </div>
                            <div>

                            </div>
                            <div>

                                <!-- <button type="Reset" class="btn-clear ">Clear</button> -->

                            </div>
                        </form>
                        <button class="btn-donate " onclick="handleDonate(<?php echo $benificiaryId ?>);">Donate</button><br><br>
                    </div>
                </div>
                <!-- donation form Section end-->
            </div>
        </div>
    </div>
    <!--selected patient and donation form section end-->

    <!--blessing massage sectin start-->

    <div class="container3 mt-5 ">
        <div class="row justify-content-center">
            <div class="blessing">
                <h1>Your Blesings Are Very Precious To Them</h1>
                <p>Blessings hold a profound significance for those who are ill, offering emotional and spiritual support
                    during challenging times. They provide comfort, instill hope, and create a sense of connection,
                    reminding individuals that they are not alone in their struggle. A simple blessing can uplift spirits,
                    foster resilience, and inspire healing, making a meaningful difference in the lives of those facing
                    health challenges.</p>

            </div>

            <div class="col-md-12 col-lg-12 d-flex flex-wrap addblessing">
                <div class="col-md-6 p-2">
                    <form action="" method="">

                        <div class="mb-3 ">
                            <h3>Recent Blessing</h3>
                            <?php if (!empty($blessingMessages)): ?>
                                <ul class="list-group">
                                    <?php foreach ($blessingMessages as $message): ?>
                                        <li class="list-group-item border-0" id="recentblessing">
                                            <strong><?php echo htmlspecialchars($message['donateName']); ?></strong>
                                            <p><?php echo htmlspecialchars($message['blessingMassage']); ?></p>
                                            <!-- <small class="text-muted"><?php echo htmlspecialchars($message['donationdate']); ?></small> -->
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <p>No blessings yet. Be the first to make a donation and add blessing!</p>
                            <?php endif; ?>

                        </div>

                    </form>
                </div>
                <div class="col-md-6 p-2">
                    <div>
                        <h3></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- blessing massage sectin end -->





    <!-- footer section start -->
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
    <!-- footer section end -->

    <!--javascript-->
    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/js/bootstrap.min.js">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js"></script>

</body>

</html>