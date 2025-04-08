<?php
require './dbConnector.php';

session_start();




if (isset($_SESSION['name'])) {
    header("location:index.php");
    exit();
} else {
    $username = $_POST['uname'];
    $password = $_POST['pwd'];

    $dbcon = new DbConnector();
    $con = $dbcon->getConnection();

    // Displaying records using prepared statements
    $query = "SELECT * FROM volunteer WHERE username = ?";

    try {
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $username);
        $pstmt->execute();

        $row = $pstmt->fetch(PDO::FETCH_OBJ);
        if (!empty($row)) {
            $pwdhash = $row->password;

            if (password_verify($password, $pwdhash)) {         
                // Setting the session variables for correct username and password
                $_SESSION['uname'] = $username;
                $_SESSION['name'] = $row->name;
                $_SESSION['district'] = $row->district;
                $_SESSION['volunteerId'] = $row->volunteerId;
                header("location:index.php");
                exit();
            } else {
                echo "Login unsuccessful<br>";
                echo "<a href='login_Volunteer.php'>Back to Login</a>";
            }
        } else {
            header("location:login_Volunteer.php");
            exit();
        }

    } catch (PDOException $exc) {
        die($exc->getMessage());
    }
}
?>
