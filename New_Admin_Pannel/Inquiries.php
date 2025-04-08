<?php
session_start();

include_once 'Dbh.php';

if (!isset($_SESSION["username"])) {
    header("Location: Login.php");
    exit();
}

class InquiryList
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getInquiries()
    {
        try {
            if (isset($_GET['search'])) {
                $search = $_GET['search'];
                $sql = "SELECT * FROM contact_us 
                        WHERE firstName LIKE ? OR lastName LIKE ? OR email LIKE ?";
                $stmt = $this->conn->prepare($sql);
                $searchTerm = "%$search%";
                $stmt->bindValue(1, $searchTerm);
                $stmt->bindValue(2, $searchTerm);
                $stmt->bindValue(3, $searchTerm);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $sql = "SELECT * FROM contact_us";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {

            error_log("Database Query Error: " . $e->getMessage());
            return [];
        }
    }
}


$dbConnector = new Db_connector();
$conn = $dbConnector->getConnection();


$inquiryList = new InquiryList($conn);
$inquiries = $inquiryList->getInquiries();


$addBeneficiary = "/New_Admin_Pannel/Beneficiary.php?email=" . urlencode($_SESSION["username"]);
$addVolunteer = "/New_Admin_Pannel/Add_volunteer.php?email=" . urlencode($_SESSION["username"]);
$addUser = "/New_Admin_Pannel/Add_User.php?email=" . urlencode($_SESSION["username"]);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inquiries Management Dashboard</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/slide_bar_content.css">
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar-trigger"></div>
    <div class="sidebar">
        <div class="sidebar-header">
            Life Line
        </div>
        <a href="/Project1/Afterindex.php"><i class="fa-solid fa-house"></i> Home Page</a>
        <a href="/New_Admin_Pannel/Admin_conrol.php" ><i class="fa-solid fa-handshake-angle"></i> Check Volunteer</a>
        <a href="Beneficiary.php" ><i class="fa-solid fa-hospital-user"></i>Check Beneficiary</a>
        <a href="Users_control.php"><i class="fa-solid fa-users"></i>Check Users</a>
        <a href="DisplayMoveBenificiary.php"><i class="fa-solid fa-list-check"></i>Completed case</a>
        <a href="/New_Admin_Pannel/Inquiries.php" class="active"><i class="fas fa-clipboard"></i> Inquiries</a>
        <a href="past_story.php"><i class="fas fa-calendar-alt"></i> Past Story</a>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <form class="d-flex" action="Inquiries.php" method="GET">
                <input class="form-control me-2" type="search" placeholder="Search by Name or Email" aria-label="Search" name="search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                <button class="btn btn-outline-success btn-custom" type="submit">Search</button>
            </form>
            <div class="profile-dropdown">
                <a class="navbar-brand me-3" href="/Project1/Afterindex.php">
                    <img src="images/Logobr.png" alt="Life Line Logo">
                    <a href="Logout.php" class="text-decoration-none"><i class="fa-solid fa-right-from-bracket fa-1x"></i> Log Out</a>
                </a>

            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="content container-fluid">
        <div class="table-container">
            <h3 class="text-center">Manage Inquiries</h3>


            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th class="col-1">No</th>
                        <th class="col-2">First Name</th>
                        <th class="col-2">Last Name</th>
                        <th class="col-3">Email</th>
                        <th class="col-3">Message</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($inquiries)) {
                        foreach ($inquiries as $index => $row) : ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($row['firstName']) ?></td>
                                <td><?= htmlspecialchars($row['lastName']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td><?= htmlspecialchars($row['message']) ?></td>
                                <td>

                                    <a href='DeleteInq.php?id=<?= htmlspecialchars($row['messageId']) ?>' class='btn btn-outline-danger btn-sm' title="Delete" style="margin-bottom: 5px;" onclick="return confirm('Are you sure you want to delete this inquiry?');"><i class="fas fa-trash-alt"></i></a>
                                    <a href='Email.php?InqId=<?= htmlspecialchars($row['messageId']) ?>' class='btn btn-outline-secondary btn-sm' title="Send Email"
                                    style="margin-bottom: 5px;"><i class="fa-solid fa-envelope"></i></a>
                                </td>
                            </tr>
                    <?php endforeach;
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>No Inquiries found.</td></tr>";
                    } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Font Awesome JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js" integrity="sha512-Fo3rlrZj/k7ujTTXRN2e8XVR1xFO6IwFykT6qHBx8sF1Yh0NVEqXx3Yg5eZKcfkXZmLZqgUgB88GpDniR1EJLg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="css/script.js"></script>
</body>

<?php
include 'footer.php';
?>

</html>