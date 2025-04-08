<?php
require_once 'Dbh.php';

$id = "";
$Name = "";
$Email = "";
$Phone = "";
$Address = "";
$Image = "";


$dbConnector = new Db_connector();
$conn = $dbConnector->getConnection();


function sanitize($data)
{
    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = stripslashes($data);
    return $data;
}


if ($_SERVER['REQUEST_METHOD'] == "GET") {

    if (!isset($_GET['id'])) {
        header("location:/New_Admin_Pannel/Edit.php?id=$id&message=4");
        exit;
    }
    $id = $_GET["id"];
    $sql = "SELECT volunteer.phone, volunteer.address, volunteer.imageOfResult, user.userName, user.userEmail 
            FROM volunteer 
            JOIN user ON volunteer.userId = user.userId  
            WHERE volunteer.volunteerId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        header("location:/New_Admin_Pannel/Edit.php?id=$id&message=4");
        exit;
    }


    $Name = $row["userName"];
    $Email = $row["userEmail"];
    $Phone = $row["phone"];
    $Address = $row["address"];
    $Image = $row["imageOfResult"];
} elseif ($_SERVER['REQUEST_METHOD'] == "POST") {

    $id = sanitize($_POST["id"]);
    $Name = sanitize($_POST["name"]);
    $Email = sanitize($_POST["email"]);
    $Phone = sanitize($_POST["phone"]);
    $Address = sanitize($_POST["address"]);


    $new_Image = $_FILES["editimage"]["name"];
    $current_Image = $_POST["editmage"];


    if ($new_Image != '') {
        $update_file = $new_Image;
        $target_directory = "upload/" . $new_Image;
    } else {
        $update_file = $current_Image;
    }


    if (empty($Name) || empty($Email) || empty($Phone) || empty($Address)) {

        header("location:/New_Admin_Pannel/Edit.php?id=$id&message=2");
    } else {

        $sql = "UPDATE volunteer 
                JOIN user ON volunteer.userId = user.userId 
                SET volunteer.phone = ?, volunteer.imageOfResult = ?, volunteer.address = ?, user.userName = ?, user.userEmail = ? 
                WHERE volunteer.volunteerId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $Phone);
        $stmt->bindParam(2, $update_file);
        $stmt->bindParam(3, $Address);
        $stmt->bindParam(4, $Name);
        $stmt->bindParam(5, $Email);
        $stmt->bindParam(6, $id);
        $stmt->execute();



        if ($stmt->rowCount() > 0) {

            if ($new_Image != '') {
                move_uploaded_file($_FILES["editimage"]["tmp_name"], "upload/" . $new_Image);
                if ($current_Image && file_exists("upload/" . $current_Image)) {
                    unlink("upload/" . $current_Image);
                }
            } else {

                header("location:/New_Admin_Pannel/Edit.php?id=$id&message=3");
            }


            header("location:/New_Admin_Pannel/Edit.php?id=$id&message=1");

            exit;
        } else {

            header("location:/New_Admin_Pannel/Edit.php?id=$id&message=0");
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
        <h2 style="margin-bottom: 25px;">Edit Volunteer</h2>


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
                <strong>Error updating Image!</strong> 
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
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" value="<?php echo $Name ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="email" value="<?php echo $Email ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Phone</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="phone" value="<?php echo $Phone ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Address</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="address" value="<?php echo $Address ?>">
                </div>
            </div>
            <!-- image remove -->

            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">

                    <a type="submit" class="btn btn-outline-success" href="/New_Admin_Pannel/Admin_conrol.php" role="button">Cancel</a>
                </div>
                <div class="col-sm-3 d-grid">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>