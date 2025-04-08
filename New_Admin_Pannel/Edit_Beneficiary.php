<?php
require_once 'Dbh.php';

$id = "";
$Name = "";
$NIC = "";
$District = "";
$Address = "";
$Age = "";
$Phone = "";
$Image = "";

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
    if (!isset($_GET['id'])) {
        header("location:/New_Admin_Pannel/Edit_Beneficiary.php?id=$id&message=4");
        exit;
    }

    $id = $_GET["id"];
    $sql = "SELECT * FROM benificiary WHERE benificiaryId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        header("location:/New_Admin_Pannel/Edit_Beneficiary.php?id=$id&message=4");
        exit;
    }

    $Name = $row["patientName"];
    $NIC = $row["nicNo"];
    $Phone = $row["gardian_No"];
    $District = $row["district"];
    $Address  = $row["address"];
    $Age = $row["age"];
    $Image = base64_encode($row["image"]);  // Convert binary to base64 for display
} elseif ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id = $_POST['id'];
    $Name = sanitize($_POST["name"]);
    $NIC = sanitize($_POST["nic"]);
    $Address = sanitize($_POST["address"]);
    $District = sanitize($_POST["district"]);
    $Phone = sanitize($_POST["phone"]);
    $Age = sanitize($_POST["age"]);

    // Handle image upload
    // $new_Image = $_FILES["editimage"]["tmp_name"];
    // $update_file = null;

    // if ($new_Image != '') {
    //     $update_file = file_get_contents($new_Image);  // Read binary content
    // }

    if (empty($Name) || empty($NIC) || empty($Phone) || empty($Address) || empty($District) || empty($Age)) {
        header("location:/New_Admin_Pannel/Edit_Beneficiary.php?id=$id&message=2");
    } else {
        $sql = "UPDATE benificiary SET patientName = ?, nicNo = ?, address = ?, district = ?, gardian_No = ?, age = ? WHERE benificiaryId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$Name, $NIC, $Address, $District, $Phone, $Age, $id]);

        if ($stmt->rowCount() > 0) {
            header("location:/New_Admin_Pannel/Edit_Beneficiary.php?id=$id&message=1");
            exit;
        } else {
            header("location:/New_Admin_Pannel/Edit_Beneficiary.php?id=$id&message=3");
        }
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

<body style="background-color: rgb(224, 232, 225);">
    <div class="container my-5" style="margin-left: 250px;">
        <h2 style="margin-bottom: 25px;">Edit Beneficiary</h2>

        <?php
        if (isset($_GET['message']) && $_GET['message'] == 1) {
            echo "
            <div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>Data updated successfully!</strong> 
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }
        if (isset($_GET['message']) && $_GET['message'] == 2) {
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>All fields must be filled!</strong> 
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }
        if (isset($_GET['s'])) {
            if ($_GET['s'] == 3) {
                echo "
                <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>Error updating data!</strong> 
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
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" value="<?php echo $Name; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">NIC NO</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="nic" value="<?php echo $NIC; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Address</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="address" value="<?php echo $Address; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Phone</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="phone" value="<?php echo $Phone; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">District</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="district" value="<?php echo $District; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Age</label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" name="age" value="<?php echo $Age; ?>">
                </div>
            </div>


            <div class="row mb-3">

                <div class="col-sm-4 d-grid">
                    <a href="/New_Admin_Pannel/Beneficiary.php" class="btn btn-outline-success">Cancel</a>
                </div>
                <div class="col-sm-4 d-grid">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>