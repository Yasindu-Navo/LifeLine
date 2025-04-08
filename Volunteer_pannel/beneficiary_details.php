<?php
require './dbConnector.php';
session_start();

class BenificiaryDetails
{

    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Display the selected benificiaries details
    public function getBenificiaryDetails($benificiaryId)
    {
        try {
            $query = "SELECT * 
                    FROM benificiary 
                    WHERE benificiaryId = :benificiaryId";
            $pstmt = $this->conn->prepare($query);
            $pstmt->bindParam(':benificiaryId', $benificiaryId, PDO::PARAM_STR);
            $pstmt->execute();

            return $pstmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // Update the database
    public function uploadBenificiaryDetails($benificiaryId, $incomeCertificate, $medicalCertificate, $medicalCondition, $hospitalDetails)
    {
        try {
            // Read file contents as binary for both files
            $incomeData = file_get_contents($incomeCertificate['tmp_name']);
            $medicalData = file_get_contents($medicalCertificate['tmp_name']);

            $query = "UPDATE selectedbenificiary 
                  SET imageofAnnualIncome = :income_certificate, 
                      imageofmedicalcertificate = :medical_certificate,
                      information = :medical_condition, 
                      paymentDetails = :hospital_details, 
                      completed = TRUE
                  WHERE benificiaryId = :benificiaryId";

            $pstmt = $this->conn->prepare($query);
            $pstmt->bindParam(':income_certificate', $incomeData, PDO::PARAM_LOB);
            $pstmt->bindParam(':medical_certificate', $medicalData, PDO::PARAM_LOB);
            $pstmt->bindParam(':medical_condition', $medicalCondition, PDO::PARAM_STR);
            $pstmt->bindParam(':hospital_details', $hospitalDetails, PDO::PARAM_STR);
            $pstmt->bindParam(':benificiaryId', $benificiaryId, PDO::PARAM_STR);

            if ($pstmt->execute()) {
                return true;
            } else {
                // Return detailed error message
                $errorInfo = $pstmt->errorInfo();
                return "SQL Error: " . $errorInfo[2];
            }
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }
}

$benificiaryId = isset($_GET['benificiaryId']) ? $_GET['benificiaryId'] : null;

if ($benificiaryId === null) {
    echo "<p class='text-danger'>No benificiary ID provided.</p>";
    exit;
}

try {
    $dbConnector = new DbConnector();
    $conn = $dbConnector->getConnection();

    $benificiaryDetails = new BenificiaryDetails($conn);
    $details = $benificiaryDetails->getBenificiaryDetails($benificiaryId);

    if (!$details) {
        echo "<p class='text-danger'>Benificiary details not found.</p>";
        exit;
    }

    // If form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $incomeCertificate = $_FILES['incomecertificate'];
        $medicalCertificate = $_FILES['medicalcertificate'];
        $medicalCondition = $_POST['medical_condition'];
        $hospitalDetails = $_POST['hospital_details'];

        // Check if file uploads are successful
        if ($incomeCertificate['error'] !== UPLOAD_ERR_OK) {
            echo "<p class='text-danger pt-5'>Error uploading the income certificate.</p>";
            exit;
        }

        if ($medicalCertificate['error'] !== UPLOAD_ERR_OK) {
            echo "<p class='text-danger pt-5'>Error uploading the medical certificate.</p>";
            exit;
        }

        // Call the method to upload details
        $result = $benificiaryDetails->uploadBenificiaryDetails($benificiaryId, $incomeCertificate, $medicalCertificate, $medicalCondition, $hospitalDetails);

        // Check if the update was successful
        if ($result === true) {
            echo "<script>
                    alert('Details uploaded successfully.');
                    window.location.href = 'volunteerDashboard.php';
                  </script>";
        } else {
            // Display detailed error message
            echo "<p class='text-danger'>Failed to upload details: $result</p>";
        }
    }
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
    <title>Upload Details About Beneficiary</title>

    <link rel="stylesheet" href="css/UploadDetails.css">
    <link rel="stylesheet" href="css/style.css">
    <!--Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"><!--        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>-->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body style="font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;">
    <!--navigation start-->

    <div>
        <nav class="navbar navbar-expand-lg  vh-10 overflow-hidden fixed-top" id="nav-color">

            <a href="../Project1/Afterindex.php" id="logo-img"><img src="images/Logobr.png" alt=""></a>
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
                        <button type="button" class="btn-close pt-5" data-bs-dismiss="offcanvas" aria-label="Close" id="button_dismiss"></button>
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

    <div class="formsection pt-5 " style="padding-left: 20%;padding-right: 20%;">
        <h1 class="text-center pt-5 pt-3">Upload Details About Beneficiary</h1>
        <div class="container ">
            <div class="heading">
                <h2>Patient's Details</h2>

            </div>


            <form class="row g-5 col-12 ">

                <div class="col-md-6">
                    <p>Patinet Name</p>
                    <input type="text" class="form-control" id="patientName" value="<?php echo htmlspecialchars($details['patientName']); ?>" readonly>
                </div>
                <div class="col-md-6">
                    <p>Patinet's NIC Number</p>
                    <input type="text" class="form-control" id="nic" value="<?php echo htmlspecialchars($details['nicNo']); ?>" readonly>
                </div>
                <div class="col-12">
                    <p>Patinet's Residential Address</p>
                    <input type="text" class="form-control" id="address" value="<?php echo htmlspecialchars($details['address']); ?>" readonly>
                </div>

                <div class="col-md-6">
                    <p>Patinet's District</p>
                    <input type="text" class="form-control" id="district" value="<?php echo htmlspecialchars($details['district']); ?>" readonly>
                </div>
                <div class="col-md-6">
                    <p>Estimated Cost For Surgery</p>
                    <input type="text" class="form-control" id="cost" value="Rs.<?php echo htmlspecialchars($details['amount']); ?>.00" readonly>
                </div>
                <div class="col-md-6">
                    <p>Estimated Date For Surgery</p>
                    <input type="text" class="form-control" id="date" value="<?php echo htmlspecialchars($details['estimatedDate']); ?>" readonly>
                </div>
                <div class="col-md-6">
                    <p>Annual Income</p>
                    <input type="text" class="form-control" id="date" value="Rs.<?php echo htmlspecialchars($details['annual_Income']); ?>.00" readonly>
                </div>

            </form>

            <div class="heading">
                <h2 class="">Guardian's Details</h2>

            </div>
            <from class="row g-5 col-12">
                <div class="col-md-6">
                    <p>Guardiant's Name</p>
                    <input type="text" class="form-control" id="guardiantName" value="<?php echo htmlspecialchars($details['gardian_Name']); ?>" readonly>
                </div>
                <div class="col-md-6">
                    <p>Guardiant's Contact Number</p>
                    <input type="text" class="form-control" id="contactNumber" value="0<?php echo htmlspecialchars($details['gardian_No']); ?>" readonly>
                </div>

            </from>
            <div class="heading">
                <h2 class="">Hospital Details</h2>
            </div>
            <from class="row g-3 col-12">

                <div class="col-md-12">
                    <p>Hospital Name</p>
                    <input type="text" class="form-control" id="contactNumber" value="<?php echo htmlspecialchars($details['hospital_Name']); ?>" readonly>
                </div>

            </from>
            <div class="heading">
                <h2 class="">Details You Need Upload</h2>
            </div>
            <form class="row g-3 col-12 uploaddetails" action="" method="POST" enctype="multipart/form-data">


                <div class="col-md-6">
                    <p>Image of Annual Income</p>
                    <input type="file" class="form-control" id="incomecertificate" name="incomecertificate" required>
                </div>
                <div class="col-md-6">
                    <p>Image of Medical Certificate</p>
                    <input type="file" class="form-control" id="medicalcertificate" name="medicalcertificate" required>
                </div>
                <div class="col-md-12">
                    <p>Present Medical Condition of Patient</p>
                    <textarea class="form-control" id="condition" style="height: 100px" id="medical_condition" name="medical_condition" required></textarea>
                </div>
                <div class="col-md-12">
                    <p>Hospital Details</p>
                    <textarea class="form-control" id="hospital_details" style="height: 100px" id="hospital_details" name="hospital_details" required></textarea>
                </div>

                <div class="col-md-2 pt-3 pb-5 pe-3">
                    <button type="reset" class="button-reset ">Reset</button>
                </div>
                <div class="col-md-2 pt-3 pb-5 ps-5">
                    <button type="submit" class="button-submit ">SUBMIT DETAILS</button>
                </div>

            </form>

        </div>
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
            <div class="row row-cols-1 row-cols-xl-4 g-0">
                <div class="col-lg-6 col-sm-6">
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