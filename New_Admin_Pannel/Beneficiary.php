<?php

include_once 'Dbh.php';
// Include the benificiary sort class
include_once 'BenificiarySort.php';

$dbConnector = new Db_connector();
$conn = $dbConnector->getConnection();

$ben = new BenificiarySort($conn);
$ben->getBenificiary();
$ben->insertUniqueBenificiaryIdsByWeight();







class BenificiaryList
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getBenificiaries()
    {
        try {
            if (isset($_GET['search'])) {
                $search = $_GET['search'];
                // $sql = "SELECT benificiary.patientName,benificiary.benificiaryId,benificiary.nicNo,benificiary.address,benificiary.district,benificiary.age,benificiary.oprationType,benificiary.oprationType,benificiary.image,benificiary.created_At,user.userEmail FROM benificiary JOIN user ON benificiary.userId = user.userId WHERE user.userName LIKE ? OR user.userEmail LIKE ?";
                $sql = "SELECT benificiary.patientName,benificiary.estimatedDate,benificiary.amount,benificiary.annual_Income,benificiary.benificiaryId,benificiary.nicNo,benificiary.address,benificiary.district,benificiary.age,benificiary.oprationType,benificiary.image,benificiary.created_At,selectedbenificiary.imageofAnnualIncome,selectedbenificiary.imageofmedicalcertificate,selectedbenificiary.information,selectedbenificiary.paymentDetails FROM benificiary JOIN  selectedbenificiary ON benificiary.benificiaryId = selectedbenificiary.benificiaryId WHERE benificiary.patientName LIKE ? OR benificiary.nicNo LIKE ?";
                $stmt = $this->conn->prepare($sql);
                $searchTerm = "%$search%";
                $stmt->bindValue(1, $searchTerm);
                $stmt->bindValue(2, $searchTerm);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $sql = "SELECT benificiary.patientName,benificiary.estimatedDate,benificiary.amount,benificiary.annual_Income,benificiary.benificiaryId,benificiary.nicNo,benificiary.address,benificiary.district,benificiary.age,benificiary.oprationType,benificiary.image,benificiary.created_At,selectedbenificiary.imageofAnnualIncome,selectedbenificiary.imageofmedicalcertificate,selectedbenificiary.information,selectedbenificiary.paymentDetails FROM benificiary JOIN  selectedbenificiary ON benificiary.benificiaryId = selectedbenificiary.benificiaryId ORDER BY benificiary.weightedValue DESC LIMIT 20";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {

            echo "Error: " . $e->getMessage();
            return [];
        }
    }
}



$benificiaryList = new BenificiaryList($conn);
$benificiary = $benificiaryList->getBenificiaries();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/slide_bar_content.css">
    <title>Beneficiary Management Dashboard</title>
</head>

<body>

    <div class="sidebar-trigger"></div>
    <div class="sidebar">
        <div class="sidebar-header">
            Life Line
        </div>
        <?php
        session_start();
        $addBeneficiary = "/New_Admin_Pannel/AddBeneficiary.php?email=" . $_SESSION["username"];
        ?>
        <a href="/Project1/Afterindex.php"><i class="fa-solid fa-house"></i> Home Page</a>
        <a href="/New_Admin_Pannel/Admin_conrol.php"><i class="fa-solid fa-handshake-angle"></i> Check Volunteer</a>
        <a href="Beneficiary.php" class="active"><i class="fa-solid fa-hospital-user"></i>Check Beneficiary</a>
        <a href="Users_control.php"><i class="fa-solid fa-users"></i>Check Users</a>
        <a href="DisplayMoveBenificiary.php"><i class="fa-solid fa-list-check"></i>Completed case</a>
        <a href="/New_Admin_Pannel/Inquiries.php"><i class="fas fa-clipboard"></i> Inquiries</a>
        <a href="past_story.php"><i class="fas fa-calendar-alt"></i> Past Story</a>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light">
        <form class="form-inline d-flex" action="Beneficiary.php" method="GET">
            <input class="form-control" type="search" placeholder="Username or NIC" aria-label="Search" name="search">
            <button class="btn btn-outline-success btn-custom" type="submit">Search</button>
        </form>
        <div class="profile-dropdown">
            <a class="navbar-brand me-3" href="/Project1/Afterindex.php">
                <img src="images/Logobr.png" alt="Life Line Logo">
                <a href="Logout.php" class="text-decoration-none"><i class="fa-solid fa-right-from-bracket fa-1x"></i>
                    Log Out</a>
            </a>

        </div>
    </nav>
    <!-- end of nav bar -->
    <div class="content container-fluid">
        <div class="table-container">
            <h3 class="text-center">Top 20 Beneficiary Cases</h3>
            <div class="d-flex justify-content-between mb-3">
                <a href="<?php echo $addBeneficiary ?>"> <button class="btn btn-success"><i
                            class="fas fa-plus-circle"></i> Add New Beneficiary</button></a>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th class="col-1">No</th>
                        <th class="col-1">Name</th>
                        <!-- <th class="col-1">NIC</th> -->
                        <th class="col-2">Address</th>
                        <!-- <th class="col-1">District</th> -->
                        <th class="col-1">Age</th>
                        <th class="col-1">Type</th>
                        <th class="col-1">Estimated date</th>
                        <th class="col-1">Amount</th>
                        <th class="col-1">Annual Income</th>
                        <th class="col-1">Image of Income</th>
                        <th class="col-1">Medical certificate</th>
                        <th class="col-1">Image of patient</th>
                        <th class="col-1">Current states</th>
                        <th class="col-1">Payment details</th>
                        <th class="col-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($benificiary)) {
                        foreach ($benificiary as $index => $row):
                            $imageData = base64_encode($row['image']); // Convert binary data to base64
                            $imageSrc = "data:image/jpeg;base64,$imageData";



                    ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($row['patientName']) ?></td>
                                <!-- <td><?= htmlspecialchars($row['nicNo']) ?></td> -->
                                <td><?= htmlspecialchars($row['address']) ?></td>
                                <!-- <td><?= htmlspecialchars($row['district']) ?></td> -->
                                <td><?= htmlspecialchars($row['age']) ?></td>
                                <td><?= htmlspecialchars($row['oprationType']) ?></td>
                                <td><?= htmlspecialchars($row['estimatedDate']) ?></td>
                                <td><?= htmlspecialchars($row['amount']) ?></td>
                                <td><?= htmlspecialchars($row['annual_Income']) ?></td>

                                <td>
                                    <?php if (!empty($row['imageofAnnualIncome'])) {
                                        $imageData1 = base64_encode($row['imageofAnnualIncome']); // Encode BLOB
                                        $imageSrc1 = "data:image/jpeg;base64,$imageData1"; // Create data URI
                                    ?>
                                        <!-- Wrap the image in an anchor tag with download attribute -->
                                        <a href="<?= $imageSrc1 ?>" download="Annual_Income_Image.jpg">
                                            <img src="<?= $imageSrc1 ?>" class="img-fluid" style="width: 80px;">
                                        </a>
                                    <?php } else { ?>
                                        <span>Under verification</span>
                                    <?php } ?>
                                </td>

                                <td>
                                    <?php if (!empty($row['imageofmedicalcertificate'])) {
                                        $imageData2 = base64_encode($row['imageofmedicalcertificate']); // Encode BLOB
                                        $imageSrc2 = "data:image/jpeg;base64,$imageData2"; // Create data URI
                                    ?>
                                        <!-- Wrap the image in an anchor tag with download attribute -->
                                        <a href="<?= $imageSrc2 ?>" download="Medical_Certificate_Image.jpg">
                                            <img src="<?= $imageSrc2 ?>" class="img-fluid" style="width: 80px;">
                                        </a>
                                    <?php } else { ?>
                                        <span>Under verification</span>
                                    <?php } ?>
                                </td>


                                <td>
                                    <?php if (!empty($row['image'])) {
                                        $imageData2 = base64_encode($row['image']); // Encode BLOB
                                        $imageSrc2 = "data:image/jpeg;base64,$imageData2"; // Create data URI
                                    ?>
                                        <!-- Wrap the image in an anchor tag with download attribute -->
                                        <a href="<?= $imageSrc2 ?>" download="User_Image.jpg">
                                            <img src="<?= $imageSrc2 ?>" class="img-fluid" style="width: 80px;">
                                        </a>
                                    <?php } else { ?>
                                        <span>Under verification</span>
                                    <?php } ?>
                                </td>

                                <!-- <td>
                                    <a href="download_image.php?id=<?= htmlspecialchars($row['image']) ?>"
                                        class="btn btn-outline-info btn-sm" title="Download Image">
                                        <img src="<?= $imageSrc ?>" class="img-fluid" style="width: 80px;">
                                    </a>
                                </td> -->

                                <td><?= htmlspecialchars($row['information']) ?></td>
                                <td><?= htmlspecialchars($row['paymentDetails']) ?></td>


                                <!-- <td><?= htmlspecialchars($row['userEmail']) ?></td> -->
                                <td>
                                    <a href='Edit_Beneficiary.php?id=<?= htmlspecialchars($row['benificiaryId']) ?>'
                                        class='btn btn-outline-primary btn-sm' title="Edit" style="margin-bottom: 5px;"><i
                                            class="fas fa-edit"></i></a>


                                    <a href='DeleteBeneficiary.php?id=<?= htmlspecialchars($row['benificiaryId']) ?>'
                                        class='btn btn-outline-danger btn-sm' title="Delete" style="margin-bottom: 5px;"
                                        onclick="return confirm('Are you sure you want to delete this beneficiary?');"><i
                                            class="fas fa-trash-alt"></i></a><br>

                                    <a href='Email.php?BeniId=<?= htmlspecialchars($row['benificiaryId']) ?>'
                                        class='btn btn-outline-secondary btn-sm' title="Send Email"
                                        style="margin-bottom: 5px;"><i class="fa-solid fa-envelope"></i></a>

                                    <a href='Movebeneficiary.php?id=<?= htmlspecialchars($row['benificiaryId']) ?>' class='btn btn-outline-success btn-sm' title="Move to completed cases"
                                        style="margin-bottom: 5px;" onclick="return confirm('Are you sure you want to move this beneficiary to completed cases?');"><i class="fa-solid fa-square-check"></i></a>

                                </td>
                            </tr>
                    <?php endforeach;
                    } else {
                        echo "<tr><td colspan='10' class='text-center'>No beneficiaries found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"
        integrity="sha512-Fo3rlrZj/k7ujTTXRN2e8XVR1xFO6IwFykT6qHBx8sF1Yh0NVEqXx3Yg5eZKcfkXZmLZqgUgB88GpDniR1EJLg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="css/script.js"></script>
</body>
<?php
include 'footer.php';
?>

</html>