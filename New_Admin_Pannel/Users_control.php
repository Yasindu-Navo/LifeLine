<?php
session_start();


include_once 'Dbh.php';

class UserList
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getUsers()
    {
        try {
            if (isset($_GET['search'])) {
                $search = $_GET['search'];
                $sql = "SELECT * FROM user WHERE userName LIKE ? OR userEmail LIKE ?";
                $stmt = $this->conn->prepare($sql);
                $searchTerm = "%$search%";
                $stmt->bindValue(1, $searchTerm);
                $stmt->bindValue(2, $searchTerm);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $sql = "SELECT * FROM user";
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


$userList = new UserList($conn);
$users = $userList->getUsers();


if (!isset($_SESSION["username"])) {
    header("Location: Login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management Dashboard</title>
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
        <?php
        $addBeneficiary = "/New_Admin_Pannel/Beneficiary.php?email=" . urlencode($_SESSION["username"]);
        $addUser = "/New_Admin_Pannel/Add_User.php?email=" . urlencode($_SESSION["username"]);
        ?>
          <a href="/Project1/Afterindex.php"><i class="fa-solid fa-house"></i> Home Page</a>
        <a href="/New_Admin_Pannel/Admin_conrol.php" ><i class="fa-solid fa-handshake-angle"></i> Check Volunteer</a>
        <a href="Beneficiary.php" ><i class="fa-solid fa-hospital-user"></i>Check Beneficiary</a>
        <a href="Users_control.php" class="active"><i class="fa-solid fa-users"></i>Check Users</a>
        <a href="DisplayMoveBenificiary.php"><i class="fa-solid fa-list-check"></i>Completed case</a>
        <a href="/New_Admin_Pannel/Inquiries.php"><i class="fas fa-clipboard"></i> Inquiries</a>
        <a href="past_story.php"><i class="fas fa-calendar-alt"></i> Past Story</a>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <form class="d-flex" action="Users_control.php" method="GET">
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
            <?php
            $addUser = "/New_Admin_Pannel/Add_User.php?email=" . urlencode($_SESSION["username"]);
            ?>
            <h3 class="text-center">Manage Users</h3><br>
           

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th class="col-1">No</th>
                        <th class="col-2">Name</th>
                        <th class="col-1">Email</th>
                        <th class="col-1">User Name</th>
                        <th class="col-1">User Type</th>
                        <th class="col-2">Registered Date</th>
                        <th class="col-1">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($users)) {
                        foreach ($users as $index => $row) : ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($row['userName']) ?></td>
                                <td><?= htmlspecialchars($row['userEmail']) ?></td>
                                <td><?= htmlspecialchars($row['userUid']) ?></td>
                                <td><?= htmlspecialchars($row['userType']) ?></td>
                                <td><?= htmlspecialchars($row['created_At']) ?></td>
                                <td>
                                    <a href='Edit_Users.php?id=<?= htmlspecialchars($row['userId']) ?>'  class='btn btn-outline-primary btn-sm' title="Edit" style="margin-bottom: 5px;"><i
                                    class="fas fa-edit"></i></a>

                                    <a href='Delete_users.php?id=<?= htmlspecialchars($row['userId']) ?>'class='btn btn-outline-danger btn-sm' title="Delete" style="margin-bottom: 5px;" onclick="return confirm('Are you sure you want to delete this user?');"><i class="fas fa-trash-alt"></i></a>
                                    <a href='Email.php?UserId=<?= htmlspecialchars($row['userId']) ?>' class='btn btn-outline-secondary btn-sm' title="Send Email"
                                    style="margin-bottom: 5px;"><i class="fa-solid fa-envelope"></i></a>
                                </td>
                            </tr>
                    <?php endforeach;
                    } else {
                        echo "<tr><td colspan='7' class='text-center'>No users found.</td></tr>";
                    }
                    ?>
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