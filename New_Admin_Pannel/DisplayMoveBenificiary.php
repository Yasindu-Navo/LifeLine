<?php
include "Dbh.php";
$dbConnector = new Db_connector();
$conn = $dbConnector->getConnection();

class DisplayMoveBenificiary{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function display(){

        try {
            if (isset($_GET['search'])) {
                $search = $_GET['search'];
                $sql = "SELECT * FROM completedcases  WHERE name LIKE ? OR email LIKE ?";
                $stmt = $this->conn->prepare($sql);
                $searchTerm = "%$search%";
                $stmt->bindValue(1, $searchTerm);
                $stmt->bindValue(2, $searchTerm);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $sql5="SELECT * FROM completedcases";
                $pstmt5=$this->conn->prepare($sql5);
                $pstmt5->execute();
                return $pstmt5->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {

            echo "Error: " . $e->getMessage();
            return [];
        }










 

    }
}

$displayData=new DisplayMoveBenificiary($conn);
$rs=$displayData->display();
?>

<!-- html start -->





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/slide_bar_content.css">
    <title>Completed Cases dashboard</title>
</head>

<body>
    <div class="sidebar-trigger"></div>
    <div class="sidebar">
        <div class="sidebar-header">
            Life Line
        </div>
        <?php
        session_start();
       // $addBeneficiary = "/New_Admin_Pannel/AddBeneficiary.php?email=" . $_SESSION["username"];
        ?>
        <a href="/Project1/Afterindex.php"><i class="fa-solid fa-house"></i> Home Page</a>
        <a href="/New_Admin_Pannel/Admin_conrol.php"><i class="fa-solid fa-handshake-angle"></i> Check Volunteer</a>
        <a href="Beneficiary.php" ><i class="fa-solid fa-hospital-user"></i>Check Beneficiary</a>
        <a href="Users_control.php"><i class="fa-solid fa-users"></i>Check Users</a>
        <a href="DisplayMoveBenificiary.php" class="active"><i class="fa-solid fa-list-check"></i>Completed case</a>
        <a href="/New_Admin_Pannel/Inquiries.php"><i class="fas fa-clipboard"></i> Inquiries</a>
        <a href="past_story.php"><i class="fas fa-calendar-alt"></i> Past Story</a>
    </div>
            <!-- search button -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <form class="form-inline d-flex" action="DisplayMoveBenificiary.php" method="GET">
            <input class="form-control" type="search" placeholder="Patient name or Email" aria-label="Search" name="search">
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
            <h3 class="text-center">Manage Completed Cases</h3>
            <div class="d-flex justify-content-between mb-3">
                <!-- <a href="<?php echo $addBeneficiary ?>"> <button class="btn btn-success"><i
                            class="fas fa-plus-circle"></i> Add New Beneficiary</button></a> -->
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th class="col-1">No</th>
                        <th class="col-1">Name</th>
                        <th class="col-1">NIC</th>
                        <th class="col-3">Address</th>
                        <th class="col-1">Operation Type</th>
                        <th class="col-1">Donation Amount</th>
                       
                        <!-- <th class="col-1">Email</th> -->
                        <th class="col-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($rs)) {
                        foreach ($rs as $index => $row): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($row['name']) ?></td>
                                <td><?= htmlspecialchars($row['nic']) ?></td>
                                <td><?= htmlspecialchars($row['address']) ?></td>
                                <td><?= htmlspecialchars($row['operationType']) ?></td>
                                <td><?= htmlspecialchars(number_format($row['amount'], 2)) ?></td>

                                <!-- <td><?= htmlspecialchars($row['oprationType']) ?></td> -->
                                <!-- <td><img src="upload/<?= htmlspecialchars($row['image']) ?>" class="img-fluid"
                                        style="width: 80px;"></td> -->
                                <!-- <td><?= htmlspecialchars($row['created_At']) ?></td> -->
                                <!-- <td><?= htmlspecialchars($row['userEmail']) ?></td> -->

                                <!-- action section -->
                                <td>
                                    <a href='Edit_completedCases.php?id=<?= htmlspecialchars($row['caseId']) ?>'
                                        class='btn btn-outline-primary btn-sm' title="Edit" style="margin-bottom: 5px;"><i
                                            class="fas fa-edit"></i></a>


                                    <a href='Delete_completedCase.php?id=<?= htmlspecialchars($row['caseId']) ?>'
                                        class='btn btn-outline-danger btn-sm' title="Delete" style="margin-bottom: 5px;"
                                        onclick="return confirm('Are you sure you want to delete this beneficiary?');"><i
                                            class="fas fa-trash-alt"></i></a>

                                    <a href='Email.php?CompletedId=<?= htmlspecialchars($row['caseId']) ?>'
                                        class='btn btn-outline-secondary btn-sm' title="Send Email"
                                        style="margin-bottom: 5px;"><i class="fa-solid fa-envelope"></i></a>

                                    

                                </td>
                            </tr>
                        <?php endforeach;
                    } else {
                        echo "<tr><td colspan='10' class='text-center'>No cases found.</td></tr>";
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