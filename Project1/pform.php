<?php

require './DbConnector.php';
require './formprocess.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);


$dbcon = new DbConnector();
$conn = $dbcon->getConnection();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $_POST["title"];
            $content =$_POST["content"];
            $date =$_POST["date"];

            $image = $_FILES["image"]["name"];
            $tempName = $_FILES["image"]["tmp_name"];
            $targetPath = "upload/" . $image;

           $pstory=new pastStory($title,$content,$date,$image);

           if ($pstory->validate()) {
        if (move_uploaded_file($tempName, $targetPath)) {
            if ($pstory->handleForm($conn)) {
                echo '<script>alert("Story Added Successfully");</script>';
            } else {
                echo "Error occurred in handleForm.";
            }
        } else {
            echo "Failed to move uploaded file.";
        }
    } else {
        echo "Validation failed.";
    }
    }
    
    ?>