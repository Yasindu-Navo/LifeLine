<?php
require_once 'Dbh.php';

$id = "";
$Name = "";
$NIC = "";
$Address = "";
$operationType = "";
$amount = "";
$email = "";



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

// Validate and sanitize email
function validateEmail($email)
{
    // Remove illegal characters from the email
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false; // Return false if email is invalid
    }
    return $email; // Return the sanitized email if valid
}


// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    // Validate and fetch beneficiary details based on ID from GET parameter
    if (!isset($_GET['id'])) {
        header("location:/New_Admin_Pannel/Edit_completedCases.php?id=$id&message=4");
        exit;
    }
    $id = $_GET["id"];
    $sql = "SELECT * FROM completedcases WHERE caseId  = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {

        header("location:/New_Admin_Pannel/Edit_completedCases.php?id=$id&message=4");
        exit;
    }

    // Assign fetched data to variables
    $Name = $row["name"];
    $NIC = $row["nic"];
    $Address  = $row["address"];
    $operationType = $row["operationType"];
    $amount = $row["amount"];
    $email = $row["email"];
} elseif ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Process form submission
    $id = $_POST['id'];
    $Name = sanitize($_POST["name"]);
    $NIC = sanitize($_POST["nic"]);
    $Address = sanitize($_POST["address"]);
    $operationType  = sanitize($_POST["operationType"]);
    $amount = sanitize($_POST["amount"]);
    $email = validateEmail($_POST["email"]);

    // If email is invalid, redirect with an error message
    if (!$email) {
        header("location:/New_Admin_Pannel/Edit_completedCases.php?id=$id&message=3");
        exit;
    }




    // Validate required fields
    if (empty($Name) || empty($NIC) || empty($operationType) || empty($Address) || empty($amount) || empty($email)) {
        header("location:/New_Admin_Pannel/Edit_completedCases.php?id=$id&message=2");
    } else {
        $sql = "UPDATE completedcases SET name = ?, nic = ?, address = ?, operationType = ?, amount = ?, email = ? WHERE caseId  = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$Name, $NIC, $Address, $operationType, $amount, $email, $id]);

        header("location:/New_Admin_Pannel/Edit_completedCases.php?id=$id&message=1");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Beneficiary</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container my-5">
        <h2>Edit Complted Benificiary Details</h2>
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
        if (isset($_GET['message'])) {
            if ($_GET['message'] == 3) {
                echo "
    <div class='alert alert-warning alert-dismissible fade show' role='alert'>
        <strong>Invalid Email!</strong> 
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
            <input type="hidden" name="id" value="<?php echo $id ?>">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" value="<?php echo $Name ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">NIC NO</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="nic" value="<?php echo $NIC ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Address</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="address" value="<?php echo $Address ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Operation Type</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="operationType" value="<?php echo $operationType ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Amount</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="amount" value="<?php echo $amount ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" name="email" value="<?php echo $email ?>">
                </div>
            </div>



            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3">
                    <a href="/New_Admin_Pannel/DisplayMoveBenificiary.php"
                        class="btn btn-outline-success"
                        style="width: 260px;">Cancel</a>
                </div>
                <div class="col-sm-3">
                    <button type="submit" class="btn btn-success"
                        name="resubmit"
                        style="width: 260px;">Submit</button>
                </div>
            </div>

        </form>
    </div>
</body>

</html>