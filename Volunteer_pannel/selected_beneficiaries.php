<?php
require './dbConnector.php';
session_start();

class BenificiaryViewer
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // display selected beneficiaries for a volunteer
    public function getSelectedBenificiaries($volunteerId)
    {
        if ($volunteerId === null) {
            return [];
        }

        try {


            $query = "SELECT benificiary.benificiaryId, benificiary.patientName, benificiary.district, benificiary.gardian_No
                      FROM benificiary
                      JOIN selectedbenificiary ON benificiary.benificiaryId = selectedbenificiary.benificiaryId
                      WHERE selectedbenificiary.volunteerId = :volunteerId 
                      AND selectedbenificiary.selected = TRUE
                      AND selectedbenificiary.completed IS NULL";

            $pstmt = $this->conn->prepare($query);
            $pstmt->bindParam(':volunteerId', $volunteerId, PDO::PARAM_STR);
            $pstmt->execute();

            $results = $pstmt->fetchAll(PDO::FETCH_ASSOC);
            error_log("Number of beneficiaries found: " . count($results));


            if (!empty($results)) {
                foreach ($results as $result) {
                    error_log("Fetched beneficiary: " . print_r($result, true));
                }
            }

            return $results ?: [];
        } catch (PDOException $e) {
            error_log("Error fetching beneficiaries: " . $e->getMessage());
            return [];
        }
    }

    // Method to fetch the volunteer's name
    public function getVolunteerName($volunteerId)
    {
        try {
            $sql = "SELECT userName FROM user WHERE volunteerId = :volunteerId";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':volunteerId', $volunteerId, PDO::PARAM_STR);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ? $row['userName'] : null;
        } catch (PDOException $e) {
            error_log("Error fetching volunteer name: " . $e->getMessage());
            return "Error: " . $e->getMessage();
        }
    }
}


$volunteerId = isset($_SESSION['volunteerId']) ? $_SESSION['volunteerId'] : null;

//if ($volunteerId) {
//    try {
//        $db = new DbConnector();
//        $conn = $db->getConnection();
//        $viewer = new BenificiaryViewer($conn);
//
//        // Fetch selected beneficiaries for the logged-in volunteer
//        $benificiaries = $viewer->getSelectedBenificiaries($volunteerId);
//
//        // Fetch the volunteer's name
//        $volunteerName = $viewer->getVolunteerName($volunteerId);
//
//        // Display selected beneficiaries in a table if any found
//        if (is_array($benificiaries) && count($benificiaries) > 0) {
//            // Optionally display the volunteer's name
//            // echo "<h3 class='pt-4'>Volunteer: " . htmlspecialchars($volunteerName) . "</h3>";
//
//            echo "<form method='POST' action='deselect_benificiary.php' class='pt-4'>";
//            echo "<table class='table table-bordered'>";
//            echo "<thead><tr><th>Patient Name</th><th>District</th><th>Contact Number</th><th>Details</th><th>Select</th></tr></thead><tbody>";
//
//            foreach ($benificiaries as $benificiary) {
//                echo "<tr>
//                        <td>" . htmlspecialchars($benificiary['patientName']) . "</td>
//                        <td>" . htmlspecialchars($benificiary['district']) . "</td>
//                        <td>" . htmlspecialchars($benificiary['gardian_contact']) . "</td>
//                        <td><a href='benificiary_details.php?benificiaryId=" . htmlspecialchars($benificiary['benificiaryId']) . "' class='btn btn-outline-success'>Upload Details</a></td>
//                        <td><input type='radio' name='selectedBenificiaryId' value='" . htmlspecialchars($benificiary['benificiaryId']) . "'></td>
//                      </tr>";
//            }
//
//            echo "</tbody></table>";
//            echo "<button type='submit' class='btn-remove'>Remove</button>";
//            echo "</form>";
//        } else {
//            echo "<p>No selected beneficiaries found for this volunteer.</p>";
//        }
//    } catch (PDOException $e) {
//        echo "<p class='text-danger'>Database Error: " . $e->getMessage() . "</p>";
//    } finally {
//        $conn = null; // Explicitly close connection
//    }
//} else {
//    echo "<p class='text-danger'>Volunteer not logged in.</p>";
//}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selected Beneficiaries</title>
    <!--Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"><!--        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>-->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/selected_beneficiaries.css">

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
    <!--  instruction section start-->

    <section class="instructions">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="about-text">
                        <div class="section-title ">
                            <h1 class="instruction-header">Instruction For Upload Beneficiary Details</h1>
                        </div>
                        <p class="card-text">
                        <ul>
                            <li>Images to be added must be clear</li>
                            <li>Add hospital details according to these steps<br>
                                ex:
                                <ol>
                                    <li>Hospital Name:Asiri hospital</li>
                                    <li>Name of the Bank:Peoples bank</li>
                                    <li>Account Branch:Mathara</li>
                                    <li>Bank Account Number:123456789</li>
                                </ol>

                            </li>
                        </ul>

                        </p>
                    </div>
                </div>
                <div class="col-6">
                    <div class="about-pic">
                        <div class="row">

                            <div class=" rounded float-right img2">
                                <img src="images/instruction.jpg" alt="about section">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>


    <!--          instruction section end-->

    <div class="selectedcase_section">
        <div class="container mt-5">
            <h2>Selected Beneficiaries</h2>
            <div>
                <a href="volunteerDashboard.php"><button type="button" class="btn-dashboard">Volunteer Dashboard</button></a>

                <a href="completedCases.php"><button type="button" class="btn-dashboard">Completed Cases</button></a>
            </div>
            <?php
            if ($volunteerId) {
                try {
                    $db = new DbConnector();
                    $conn = $db->getConnection();
                    $viewer = new BenificiaryViewer($conn);

                    // get selected beneficiaries for the volunteer
                    $benificiaries = $viewer->getSelectedBenificiaries($volunteerId);

                    // get the volunteer's name
                    $volunteerName = $viewer->getVolunteerName($volunteerId);


                    if (is_array($benificiaries) && count($benificiaries) > 0) {

                        //                             echo "<h3 class='pt-4'>Volunteer: " . htmlspecialchars($volunteerName) . "</h3>";

                        echo "<form method='POST' action='deselect_beneficiary.php' class='pt-4'>";
                        echo "<table class='table table-bordered'>";
                        echo "<thead><tr><th>Patient Name</th><th>District</th><th>Contact Number</th><th>Details</th><th>Select</th></tr></thead><tbody>";

                        foreach ($benificiaries as $benificiary) {
                            echo "<tr>
                                        <td>" . htmlspecialchars($benificiary['patientName']) . "</td>
                                        <td>" . htmlspecialchars($benificiary['district']) . "</td>
                                        <td>0" . htmlspecialchars($benificiary['gardian_No']) . "</td>
                                        <td><a href='beneficiary_details.php?benificiaryId=" . htmlspecialchars($benificiary['benificiaryId']) . "' id='uploadicon'><img src='image/cloud-computing.png'></a></td>
                                        <td><input type='radio' name='selectedBenificiaryId' value='" . htmlspecialchars($benificiary['benificiaryId']) . "'></td>
                                      </tr>";
                        }

                        echo "</tbody></table>";
                        echo "<button type='submit' class='btn-remove'>Remove</button>";
                        echo "</form>";
                    } else {
                        echo "<p>No selected beneficiaries found for this volunteer.</p>";
                    }
                } catch (PDOException $e) {
                    echo "<p class='text-danger'>Database Error: " . $e->getMessage() . "</p>";
                } finally {
                    $conn = null;
                }
            } else {
                echo "<p class='text-danger'>Volunteer not logged in.</p>";
            }
            ?>



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