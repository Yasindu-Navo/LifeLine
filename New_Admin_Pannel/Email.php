<?php

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


//required files
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

//newly added
class Email
{
    private $conn;
    private $id;


    public function __construct($con, $id)
    {
        $this->conn = $con;
        $this->id = $id;
    }

    public function getBenificiaryEmail()
    {
        // $benificiaryId = isset($_GET['id']) ? $_GET['id'] : null;
        $query = "SELECT userEmail FROM user WHERE userId=(SELECT userId FROM benificiary WHERE benificiaryId=?)";
        try {

            $pstmt = $this->conn->prepare($query);
            $pstmt->bindParam(1, $this->id);

            $pstmt->execute();
            return $pstmt->fetch(PDO::FETCH_COLUMN);

            // echo 'value added Successfully<br>';


        } catch (PDOException $exc) {
            die("Error occured when getting email address" . $exc->getMessage());
        }
    }



    public function getUserEmail()
    {
        $query = "SELECT userEmail FROM user WHERE userId=?";
        try {

            $pstmt = $this->conn->prepare($query);
            $pstmt->bindParam(1, $this->id);

            $pstmt->execute();
            return $pstmt->fetch(PDO::FETCH_COLUMN);

            // echo 'value added Successfully<br>';


        } catch (PDOException $exc) {
            die("Error occured when getting email address" . $exc->getMessage());
        }
    }

    public function getVolunteerEmail()
    {
        $query = "SELECT userEmail FROM user WHERE userId=(SELECT userId FROM volunteer WHERE volunteerId=?)";
        try {

            $pstmt = $this->conn->prepare($query);
            $pstmt->bindParam(1, $this->id);

            $pstmt->execute();
            return $pstmt->fetch(PDO::FETCH_COLUMN);
        } catch (PDOException $exc) {
            die("Error occured when getting email address" . $exc->getMessage());
        }
    }

    public function getCompletedCaseEmail()
    {
        $query = "SELECT email FROM completedcases WHERE caseId=?";
        try {

            $pstmt = $this->conn->prepare($query);
            $pstmt->bindParam(1, $this->id);

            $pstmt->execute();
            return $pstmt->fetch(PDO::FETCH_COLUMN);
        } catch (PDOException $exc) {
            die("Error occured when getting email address" . $exc->getMessage());
        }
    }

    public function getInqEmail()
    {
        try {
            //code...
            $query = "SELECT email FROM contact_us WHERE messageId=?";
            $pstmt = $this->conn->prepare($query);
            $pstmt->bindParam(1, $this->id);
            $pstmt->execute();
            return $pstmt->fetch(PDO::FETCH_COLUMN);
        } catch (PDOException $exc) {
            die("Error getting Inquiry email" . $exc->getMessage());
        }
    }
}

// Include the database connection class
include_once 'Dbh.php';
// Include the benificiary sort class
include_once 'Email.php';

$dbConnector = new Db_connector();
$conn = $dbConnector->getConnection();

$message = "Type your message here.";
$subject = "Type your subject";

if (isset($_GET['BeniId'])) {   //get Benificiary Email
    $id = $_GET['BeniId'];
    $cancelLink = "/New_Admin_Pannel/Beneficiary.php";
    $message = "We are pleased to inform you that you have been selected as a beneficiary of Life Line. One of our team members will be in touch with you shortly to guide you through the verification process.

We are committed to supporting you, and we look forward to assisting you soon.

Warm regards,  

Life Line";
    $subject = "Congratulations! You Have Been Selected as a Life Line Beneficiary";
    $email = new Email($conn, $id);
    $userEmail = $email->getBenificiaryEmail();
}


if (isset($_GET['UserId'])) {   //get User Email
    $id = $_GET['UserId'];
    $cancelLink = "/New_Admin_Pannel/Users_control.php";
    $email = new Email($conn, $id);
    $userEmail = $email->getUserEmail();
}

if (isset($_GET['VolId'])) {   //get volunteer Email
    $id = $_GET['VolId'];
    $cancelLink = "/New_Admin_Pannel/Admin_conrol.php";

    $email = new Email($conn, $id);
    $userEmail = $email->getUserEmail();
}

if (isset($_GET['reqId'])) {   //get volunteer Request  Email
    $id = $_GET['reqId'];
    $cancelLink = "/New_Admin_Pannel/VolunteerReq.php";
    $message = "Congratulations! We are delighted to inform you that you have been selected as a volunteer of Life Line. You can now log in to your account using the same credentials you used when signing up.

We look forward to the valuable contributions you will bring to our mission and are excited to have you as part of our team!

Warm regards,  
Life Line";

    $subject = "Welcome to the Life Line Volunteer Team!";

    $email = new Email($conn, $id);
    $userEmail = $email->getVolunteerEmail();
}

if (isset($_GET['CompletedId'])) {   //get volunteer Email
    $id = $_GET['CompletedId'];
    $cancelLink = "/New_Admin_Pannel/DisplayMoveBenificiary.php";
    $email = new Email($conn, $id);
    $userEmail = $email->getCompletedCaseEmail();
}

if (isset($_GET['InqId'])) {
    $id = $_GET['InqId'];
    $cancelLink = "/New_Admin_Pannel/Inquiries.php";
    $email = new Email($conn, $id);
    $userEmail = $email->getInqEmail();
}







//Create an instance; passing `true` enables exceptions
if (isset($_POST["send"])) {

    $mail = new PHPMailer(true);

    //Server settings
    $mail->isSMTP();                              //Send using SMTP
    $mail->Host = 'smtp.gmail.com';       //Set the SMTP server to send through
    $mail->SMTPAuth = true;             //Enable SMTP authentication
    $mail->Username = 'gamageellewala99@gmail.com';   //SMTP write your email
    $mail->Password = 'wibuqwmkkcjuanfu';      //SMTP password
    $mail->SMTPSecure = 'ssl';            //Enable implicit SSL encryption
    $mail->Port = 465;

    //Recipients
    $mail->setFrom($_POST["email"], $_POST["name"]); // Sender Email and name
    $mail->addAddress($_POST["email"]);     //Add a recipient email  
    $mail->addReplyTo($_POST["email"], $_POST["name"]); // reply to sender email

    //Content
    $mail->isHTML(true);               //Set email format to HTML
    $mail->Subject = $_POST["subject"];   // email subject headings
    $mail->Body = $_POST["message"]; //email message

    // Success sent message alert
    $mail->send();
    echo
    " 
    <script> 
     alert('Message was sent successfully!');
     document.location.href = 'Admin_conrol.php';
    </script>
    ";
} //change the location above
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>
    <div class="container my-5">

        <form method="post" enctype="multipart/form-data">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" value="Life Line">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="email"
                        value="<?php echo htmlspecialchars($userEmail); ?>">
                </div>
            </div>
            <!-- 
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Phone</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="phone">
                </div>
            </div> -->

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Enter subject here:</label>
                <div class="col-sm-6">
                    <input placeholder="Type your subject line" class="form-control" type="text" name="subject"
                        tabindex="4" value="<?php echo htmlspecialchars($subject); ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Message: </label>
                <div class="col-sm-6">
                    <textarea name="message" class="form-control" tabindex="5"
                        rows="10"><?php echo htmlspecialchars($message); ?> </textarea>


                </div>
            </div>


            <div class=" row mb-3">

                <div class="offset-sm-3 col-sm-3 d-grid">

                    <a type="cancel" class="btn btn-outline-success" href="<?php echo htmlspecialchars($cancelLink); ?>"
                        role="button">Cancel</a>
                </div>


                <div class="col-sm-3 d-grid">
                    <button type="submit" class="btn btn-success" name="send">Send</button>
                </div>
            </div>

    </div>

</body>

</html>