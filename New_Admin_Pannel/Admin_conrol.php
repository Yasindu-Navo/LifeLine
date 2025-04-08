<?php
session_start();

// Include the database connection class
include_once 'Dbh.php';

class VolunteerList
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getVolunteers()
    {
        try {
            if (isset($_GET['search'])) {
                $search = $_GET['search'];
                $sql = "SELECT volunteer.volunteerId, volunteer.phone, volunteer.address,volunteer.age,volunteer.nic, volunteer.imageOfResult, 
                user.userName, user.userEmail, user.created_At, user.userId 
         FROM volunteer 
         JOIN user ON volunteer.userId = user.userId  
         WHERE (user.userName LIKE ? OR user.userEmail LIKE ?) 
         AND user.userType = 'Volunteer'";

                $stmt = $this->conn->prepare($sql);
                $searchTerm = "%$search%";
                $stmt->bindValue(1, $searchTerm);
                $stmt->bindValue(2, $searchTerm);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $sql = "SELECT volunteer.volunteerId, volunteer.phone, volunteer.address, volunteer.nic,volunteer.age, 
                user.userName, user.userEmail, user.created_At, user.userId 
         FROM volunteer 
         JOIN user ON volunteer.userId = user.userId
         WHERE user.userType = 'Volunteer'";

                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            // Display an error message if there is an issue with the database query
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
}

// Initialize the database connection
$dbConnector = new Db_connector();
$conn = $dbConnector->getConnection();

// Instantiate the VolunteerList class
$volunteerList = new VolunteerList($conn);
$volunteers = $volunteerList->getVolunteers();



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/slide_bar_content.css">
    <link rel="stylesheet" href="css/footer.css">
    <title>Volunteer Management Dashboard</title>
</head>

<body>

    <div class="sidebar-trigger"></div>
    <div class="sidebar">
        <div class="sidebar-header">
            Life Line
        </div>
        <?php
        $addBeneficiary = "/New_Admin_Pannel/Beneficiary.php?email=" . $_SESSION["username"];
        ?>
        <a href="/Project1/Afterindex.php"><i class="fa-solid fa-house"></i> Home Page</a>
        <a href="/New_Admin_Pannel/Admin_conrol.php" class="active"><i class="fa-solid fa-handshake-angle"></i> Check
            Volunteer</a>
        <a href="Beneficiary.php"><i class="fa-solid fa-hospital-user"></i>Check Beneficiary</a>
        <a href="Users_control.php"><i class="fa-solid fa-users"></i>Check Users</a>
        <a href="DisplayMoveBenificiary.php"><i class="fa-solid fa-list-check"></i>Completed case</a>
        <a href="/New_Admin_Pannel/Inquiries.php"><i class="fas fa-clipboard"></i> Inquiries</a>
        <a href="past_story.php"><i class="fas fa-calendar-alt"></i> Past Story</a>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light">
        <form class="form-inline d-flex" action="Admin_conrol.php" method="GET">
            <input class="form-control" type="search" placeholder="Username or Email" aria-label="Search" name="search">
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

    <div class="content container-fluid">
        <div class="table-container">
            <?php

            $addVolunterr = "/New_Admin_Pannel/VolunteerReq.php";


            ?>
            <h3 class="text-center">Manage Volunteer</h3>
            <div class="d-flex justify-content-between mb-3">
                <a href="<?php echo $addVolunterr ?>"> <button class="btn btn-success"><i
                            class="fas fa-plus-circle"></i> Check Volunteer Requests</button></a>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th class="col-1">No</th>
                        <th class="col-2">Name</th>
                        <th class="col-1">Age</th>
                        <th class="col-3">Address</th>
                        <th class="col-2">Phone</th>
                        <th class="col-2">NIC</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($volunteers)) {
                        foreach ($volunteers as $index => $row): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($row['userName']) ?></td>
                                <td><?= htmlspecialchars($row['age']) ?></td>
                                <td><?= htmlspecialchars($row['address']) ?></td>
                                <td><?= htmlspecialchars($row['phone']) ?></td>
                                <td><?= htmlspecialchars($row['nic']) ?></td>
                                <td>


                                    <a href='Edit.php?id=<?= htmlspecialchars($row['volunteerId']) ?>'
                                        class='btn btn-outline-primary btn-sm' title="Edit" style="margin-bottom: 5px;"><i
                                            class="fas fa-edit"></i></a>

                                    <a href='Delete.php?id=<?= htmlspecialchars($row['volunteerId']) ?>'
                                        class='btn btn-outline-danger btn-sm' title="Delete" style="margin-bottom: 5px;"
                                        onclick="return confirm('Are you sure you want to delete this volenteer?');"><i
                                            class="fas fa-trash-alt"></i></a>

                                    <a href='Email.php?VolId=<?= htmlspecialchars($row['volunteerId']) ?>'
                                        class='btn btn-outline-secondary btn-sm' title="Send Email"
                                        style="margin-bottom: 5px;"><i class="fa-solid fa-envelope"></i></a>

                                </td>
                            </tr>
                    <?php endforeach;
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>No Volunteer found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

        </div>
    </div>
    <!-- Font Awesome JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"
        integrity="sha512-Fo3rlrZj/k7ujTTXRN2e8XVR1xFO6IwFykT6qHBx8sF1Yh0NVEqXx3Yg5eZKcfkXZmLZqgUgB88GpDniR1EJLg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="css/script.js"></script>

</body>
<?php
include 'footer.php';
?>

</html>