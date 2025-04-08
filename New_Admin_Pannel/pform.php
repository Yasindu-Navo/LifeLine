<?php

require 'Dbh.php';
require 'formprocess.php';

// error_reporting(E_ALL);
// ini_set('display_errors', 1);


$dbcon = new Db_connector();
$conn = $dbcon->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $content = $_POST["content"];
    $date = $_POST["date"];

    $image = $_FILES["image"]["name"];
    $tempName = $_FILES["image"]["tmp_name"];
    $targetPath = "uploads/" . $image;

    $pstory = new pastStory($title, $content, $date, $image);

    if ($pstory->validate()) {
        if (move_uploaded_file($tempName, $targetPath)) {
            if ($pstory->handleForm($conn)) {
                header("location:/New_Admin_Pannel/form.php?message=1");
            } else {
                echo "Error occurred in handleForm.";
                header("location:/New_Admin_Pannel/form.php?message=2");
                exit;
            }
        } else {
            echo "Failed to move uploaded file.";
            header("location:/New_Admin_Pannel/form.php?message=3");
            exit;
        }
    } else {
        echo "Validation failed.";
        header("location:/New_Admin_Pannel/form.php?message=4");
    }
}
