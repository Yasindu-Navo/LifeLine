<?php
session_start();
require_once 'Dbh.php';

$id = "";
$Title = "";
$Content = "";
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
    // Validate and fetch beneficiary details based on ID from GET parameter
    if (!isset($_GET['id'])) {
        header("location:/New_Admin_Pannel/Edit_past_story.php?id=$id&message=4");
        exit;
    }
    $id = $_GET["id"];
    $sql = "SELECT * FROM paststory WHERE storyId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {

        header("location:/New_Admin_Pannel/Edit_Beneficiary.php?id=$id&message=4");
        exit;
    }

    $Title = $row["title"];
    $Content = $row["content"];
    $Image = $row["image"];
} elseif ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id = $_POST['id'];
    $Title = sanitize($_POST["title"]);
    $Content = sanitize($_POST["content"]);

    $new_Image = $_FILES["editimage"]["name"];
    $current_Image = $_POST["editmage"];

    if ($new_Image != '') {
        $update_file = $new_Image;
    } else {
        $update_file = $current_Image;
    }

    // Validate required fields
    if (empty($Title) || empty($Content)) {
        header("location:/New_Admin_Pannel/Edit_past_story.php?id=$id&message=2");
    } else {
        $sql = "UPDATE paststory SET title = ?, content = ?, image = ? WHERE storyId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$Title, $Content, $update_file, $id]);

        if ($stmt->rowCount() > 0) {
            if ($new_Image != '') {
                move_uploaded_file($_FILES["editimage"]["tmp_name"], "upload/" . $new_Image);
                if ($current_Image && file_exists("upload/" . $current_Image)) {
                    unlink("upload/" . $current_Image);
                }
            }

            header("location:/New_Admin_Pannel/Edit_past_story.php?id=$id&message=1");
            exit;
        } else {
            header("location:/New_Admin_Pannel/Edit_past_story.php?id=$id&message=3");
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

        <h2 style="margin-bottom: 25px;">Edit Past Stories</h2>
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
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $id ?>">
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Title</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="title" value="<?php echo $Title ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Content</label>
                <div class="col-sm-6">
                    <textarea name="content" class="form-control" value="" id=""><?php echo $Content; ?></textarea>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Image</label>
                <div class="col-sm-6">
                    <input class="form-control" type="file" name="editimage">
                    <input type="hidden" name="editmage" value="<?php echo $Image ?>">
                    <?php if (!empty($Image)) : ?>
                        <img src="<?php echo "upload/" . $Image; ?>" width="75" alt="Current image">
                    <?php endif; ?>
                </div>
            </div>

            <!-- <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3">
                    <button type="submit" class="btn btn-primary" name="resubmit">Submit</button>
                </div>
                <div class="col-sm-3">
                    <a href="/New_Admin_Pannel/past_story.php" class="btn btn-outline-primary">Cancel</a>
                </div>
            </div> -->

            <br>
            <div class=" row mb-3">

                <div class="offset-sm-0 col-sm-4 d-grid">
                    <a type="submit" class="btn btn-outline-success" href="/New_Admin_Pannel/past_story.php" role="button">Cancel</a>

                </div>
                <div class="col-sm-4 d-grid">
                    <button type="submit" class="btn btn-success" name="resubmit">Submit</button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>