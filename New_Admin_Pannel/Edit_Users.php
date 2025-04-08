<?php
require_once 'Dbh.php';
$id = "";
$Name = "";
$Email = "";
$UserName = "";
$userType = "";

// Initialize database connection
$dbConnector = new Db_connector();
$conn = $dbConnector->getConnection();

// Function to sanitize data
function sanitize($data)
{
    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = stripslashes($data);
    return $data;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    // Validate and fetch beneficiary details based on ID from GET parameter
    if (!isset($_GET['id'])) {
        header("location:/New_Admin_Pannel/Edit_Users.php?id=$id&message=4");
        exit;
    }
    $id = $_GET["id"];
    $sql = "SELECT * FROM user WHERE userId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        header("location:/New_Admin_Pannel/Edit_Users.php?id=$id&message=4");
        exit;
    }


    $Name = $row["userName"];
    $Email = $row["userEmail"];
    $UserName = $row["userUid"];
    $userType = $row["userType"];
} elseif ($_SERVER['REQUEST_METHOD'] == "POST") {

    $id = sanitize($_POST["id"]);
    $Name = sanitize($_POST["name"]);
    $Email = sanitize($_POST["email"]);
    $UserName = sanitize($_POST["username"]);
    $userType = sanitize($_POST["update_usertype"]);

    if (empty($Name) || empty($Email) || empty($UserName) || empty($userType)) {
        header("location:/New_Admin_Pannel/Edit_Users.php?id=$id&message=2");
    } else {
        $sql = "UPDATE user SET userName = ?, userEmail = ?, userUid  = ?, userType = ?  WHERE userId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$Name, $Email, $UserName, $userType, $id]);

        if ($stmt->rowCount() > 0) {
            header("location:/New_Admin_Pannel/Edit_Users.php?id=$id&message=1");
            exit;
        } else {
            header("location:/New_Admin_Pannel/Edit_Users.php?id=$id&message=0");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Volunteer</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body style="background-color: rgb(224, 232, 225);">
    <div class="container my-5" style="margin-left: 250px;">
        <h2 style="margin-bottom: 25px;">Edit Users</h2>
        <?php

        if (isset($_GET['s'])) {
            if ($_GET['s'] == 0) {
                echo "
        <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>Error updating data!</strong> 
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
            }
        }
        if (isset($_GET['s'])) {
            if ($_GET['s'] == 2) {
                echo "
        <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>All fields must be filled!</strong> 
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
            }
        }
        if (isset($_GET['message'])) {
            if ($_GET['message'] == 1) {
                echo "
    <div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Data updated successfully!</strong> 
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
            }
        }
        if (isset($_GET['s'])) {
            if ($_GET['s'] == 4) {
                echo "
        <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>Oops! Something went wrong!</strong> 
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
            }
        }


        ?>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value=" <?php echo $id ?>">

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" value="<?php echo $Name ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="email" value="<?php echo $Email ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">User name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="username" value="<?php echo  $UserName ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">User Role</label>
                <div class="col-sm-6">
                    <select name="update_usertype" class="col-sm-3 col-form-label">
                        <option value="Admin">Admin</option>
                        <option value="User">User</option>
                        <option value="Volunteer">Volunteer</option>
                    </select>
                </div>
            </div>


            <?php
            if (!empty($Sucsses_mesage)) {
                echo "
                <div class='row mb-3'>
                    <div class='alert alert-success alert-dismissible fade show' role='alert'>
                        <strong>$Sucsses_mesage</strong> 
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>
                </div>";
            }
            ?>

            <br>
            <div class=" row mb-3">

                <div class="offset-sm-0 col-sm-4 d-grid">
                    <a type="submit" class="btn btn-outline-success" href="/New_Admin_Pannel/Users_control.php" role="button">Cancel</a>
                </div>
                <div class="col-sm-4 d-grid">

                    <button type="submit" class="btn btn-success" name="resubmit">Submit</button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>