<?php
require './dbConnector.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $benificiaryId = isset($_POST['selectedBenificiaryId']) ? $_POST['selectedBenificiaryId'] : null;
    $volunteerId = isset($_SESSION['volunteerId']) ? $_SESSION['volunteerId'] : null;

    // Print the volunteerId and beneficiaryId
//    echo "Volunteer ID: " . htmlspecialchars($volunteerId) . "<br>";
//    echo "Benificiary ID: " . htmlspecialchars($benificiaryId) . "<br>";

    if ($benificiaryId && $volunteerId) {
        $db = new DbConnector();
        $conn = $db->getConnection();
        $viewer = new BenificiaryViewer($conn);
        $viewer->deselectBenificiary($benificiaryId, $volunteerId);
        $conn = null; // Close connection
    }
}

header('Location: selected_beneficiaries.php');
exit();

class BenificiaryViewer {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    //  deselect a beneficiary
    public function deselectBenificiary($benificiaryId, $volunteerId) {
        try {
            
            $query = "UPDATE selectedbenificiary SET selected = NULL AND volunteerId = NULL WHERE benificiaryId = :benificiaryId AND volunteerId = :volunteerId";
            $pstmt = $this->conn->prepare($query);
            $pstmt->bindParam(':benificiaryId', $benificiaryId, PDO::PARAM_INT);
            $pstmt->bindParam(':volunteerId', $volunteerId, PDO::PARAM_STR);
            $pstmt->execute();
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }
}
?>
