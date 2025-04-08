<?php
session_start();

require_once 'Dbh.php';
$dbconnector = new Db_connector();
$conn = $dbconnector->getConnection();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

function send_password_reset($get_name, $get_email, $token)
{

    $mail = new PHPMailer(true);


    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';             // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                         // Enable SMTP authentication
        $mail->Username   = 'gamageellewala99@gmail.com'; // SMTP username
        $mail->Password   = 'wibuqwmkkcjuanfu';           // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  // Enable SSL encryption
        $mail->Port       = 465;                          // TCP port to connect to

        // Recipients
        $mail->setFrom('gamageellewala99@gmail.com', 'Your Name');
        $mail->addAddress($get_email); // Add recipient's email address

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = "Reset Password Notification";

        // Email template
        $email_template = "
            <h2>Hello $get_name,</h2>
            <p>You requested to reset your password. Click the link below to reset your password:</p>
            <a href='http://localhost/Login_page/includes/password_change.php?token=$token&email=$get_email'>Click here to reset your password</a>
            <p>If you did not request this, please ignore this email.</p>
        ";

        $mail->Body = $email_template;

        // Send email
        $mail->send();
    } catch (Exception $e) {
        $_SESSION['status'] = "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

if (isset($_POST['recover-submit'])) {
    $email = $_POST['email'];
    $token = md5(rand());

    // Check if the email exists in the database
    $check_email = "SELECT userName, userEmail FROM user WHERE userEmail = ?";
    $stmt = $conn->prepare($check_email);
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $get_name = $row['userName'];
        $get_email = $row['userEmail'];

        // Update the token in the database
        $update_token = "UPDATE user SET verify_token = ? WHERE userEmail = ?";
        $update_stmt = $conn->prepare($update_token);
        $update_run = $update_stmt->execute([$token, $get_email]);

        if ($update_run) {
            // Send password reset email

            send_password_reset($get_name, $get_email, $token);
            $_SESSION['status'] = "Check your email for the password reset link.";
            header("Location: ../../Project1/password_reset.php");

            // echo
            // " 
            // <script> 
            //  alert('Message was sent successfully!');
            //  document.location.href = 'Admin_conrol.php';
            // </script>
            // ";
            exit(0);
        } else {
            $_SESSION['status'] = "Something went wrong!";
            header("Location: password_reset.php");
            exit(0);
        }
    } else {
        $_SESSION['status'] = "No Email found!";
        header("Location: password_reset.php");
        exit(0);
    }
}

//2nd process


if (isset($_POST['update_password'])) {
    $email = $_POST['email'];
    $new_password =  $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $token = $_POST['token'];

    if (!empty($token)) {
        if (!empty($token) && !empty($new_password) && !empty($confirm_password)) {
            //check token valid or not
            $check_token = "SELECT verify_token from user WHERE verify_token=?";
            $stmt = $conn->prepare($check_token);
            $token_run = $stmt->execute([$token]);
            if ($stmt->rowCount() > 0) {
                if ($new_password == $confirm_password) {
                    $update_password = "UPDATE user SET userPassword = ? WHERE verify_token = ?";
                    $hashedPwd = password_hash($new_password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare($update_password);
                    $password_run = $stmt->execute([$hashedPwd, $token]);

                    if ($password_run) {
                        $_SESSION['status'] = "New password successfully updated!";
                        header("Location:password_change.php");
                        exit(0);
                    } else {
                        $_SESSION['status'] = "Did not update password!!";
                        header("Location: password_change.php?token=$token&email=$email");
                        exit(0);
                    }
                } else {
                    $_SESSION['status'] = "Password and Confirmed password does not match!!";
                    header("Location: password_change.php?token=$token&email=$email");
                    exit(0);
                }
            } else {
                $_SESSION['status'] = "Invalid token!";
                header("Location: password_change.php?token=$token&email=$email");
                exit(0);
            }
        } else {
            $_SESSION['status'] = "All the feild requre!";
            header("Location: password_change.php?token=$token&email=$email");
            exit(0);
        }
    } else {
        $_SESSION['status'] = "No Token found!";
        header("Location: password_change.php");
        exit(0);
    }
}
