<?php
require_once 'Dbh.php';
session_start();

$dbConnector = new Db_connector();
$conn = $dbConnector->getConnection();

class DonationHandler
{
    private $dbConnection;

    public function __construct()
    {
        $this->dbConnection = (new Db_connector())->getConnection();
    }

    // Save donations in donations table
    public function savedonation($userId, $benificiaryId, $amount, $blessingMessage, $donateName)
    {
        $query = "INSERT INTO donation(userId, benificiaryId, amountOfDonate, blessingMassage, donateName)
                  VALUES (:userId, :benificiaryId, :amount, :blessingMessage, :donateName)";
        $stmt = $this->dbConnection->prepare($query);

        // Bind the correct parameters
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':benificiaryId', $benificiaryId);
        $stmt->bindParam(':amount', $amount);  // Updated to match SQL query
        $stmt->bindParam(':blessingMessage', $blessingMessage);  // Updated to match SQL query
        $stmt->bindParam(':donateName', $donateName);

        $result = $stmt->execute();

       // echo 'Data saved successfully';

        if ($result) {
            $this->updateDeposite($benificiaryId, $amount);
        }

        return $result;
    }

    // update the Deposite value in beneficiarydetails table
    public function updateDeposite($benificiaryId, $amount)
    {
        $query = "UPDATE selectedbenificiary 
                  SET currentAmount = currentAmount + :amount 
                  WHERE benificiaryId = :benificiaryId";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':benificiaryId', $benificiaryId);

        //echo 'Amount updated successfully';
        return $stmt->execute();
    }
}


    $query = "SELECT userId FROM user WHERE userEmail = ?";
    $pstmt = $conn->prepare($query);
    $pstmt->bindParam(1, $_SESSION["username"]);
    $pstmt->execute();
    $userId = $pstmt->fetch(PDO::FETCH_COLUMN);

   

// Fetch user ID based on session username
if (isset($_SESSION["username"])) {
    $query = "SELECT userId FROM user WHERE userEmail = ?";
    $pstmt = $conn->prepare($query);
    $pstmt->bindParam(1, $_SESSION["username"]);
    $pstmt->execute();
    $userId = $pstmt->fetch(PDO::FETCH_COLUMN);

    // Get values from the URL query string
    $benificiaryId = $_GET['id'];
    $amount = $_GET['amount'];
    $message = $_GET['message'];
    $name = $_GET['name'];

    // Save donation and update deposit
    $donationHandler = new DonationHandler();
    $donationHandler->savedonation($userId, $benificiaryId, $amount, $message, $name);
    header("Location: patient_details.php?id=" . urlencode($benificiaryId));
    exit();  // Important to stop further script execution
}


























