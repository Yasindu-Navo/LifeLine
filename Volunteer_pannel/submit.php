<?php
require './dbConnector.php';
session_start();

class BenificiaryUpdater {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function updateBenificiary($benificiaryId, $volunteerId) {
    try {
        // Check the benificiary  is not already selected
        $checkSql = "SELECT selected FROM selectedbenificiary WHERE benificiaryId = :benificiaryId";
        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->bindParam(':benificiaryId', $benificiaryId, PDO::PARAM_STR);
        $checkStmt->execute();

        $row = $checkStmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return "Benificiary does not exist.";
        }

        if ($row['selected']) {
            return "Benificiary is already selected.";
        }

        // Check the volunteerId  in the volunteer table
        $volunteerCheckSql = "SELECT volunteerId FROM volunteer WHERE volunteerId = :volunteerId";
        $volunteerCheckStmt = $this->conn->prepare($volunteerCheckSql);
        $volunteerCheckStmt->bindParam(':volunteerId', $volunteerId, PDO::PARAM_STR);
        $volunteerCheckStmt->execute();

        if ($volunteerCheckStmt->rowCount() == 0) {
            return "Volunteer ID does not exist.";
        }

        // Update the selected and volunteerId for the relevent benificiaryId
        $updateSql = "UPDATE selectedbenificiary SET selected = TRUE, volunteerId = :volunteerId WHERE benificiaryId = :benificiaryId";
        $updateStmt = $this->conn->prepare($updateSql);
        $updateStmt->bindParam(':benificiaryId', $benificiaryId, PDO::PARAM_STR);
        $updateStmt->bindParam(':volunteerId', $volunteerId, PDO::PARAM_STR);
        $updateStmt->execute();

  

        if ($updateStmt->rowCount() > 0) {
            return "Benificiary updated successfully.";
        } else {
            return "No changes made. Benificiary may already be selected or does not exist.";
        }
    } catch (PDOException $e) {
        return "Error: " . $e->getMessage();
    }
}

}

// Check if a beneficiary was selected and update it
if (isset($_POST['selectBenificiary'])) {
    $benificiaryId = $_POST['selectBenificiary'];
    $volunteerId = isset($_SESSION['volunteerId']) ? $_SESSION['volunteerId'] : null;

    if ($volunteerId !== null) {
        try {
            $dbConnector = new DbConnector(); 
            $conn = $dbConnector->getConnection();

            $benificiaryUpdater = new BenificiaryUpdater($conn);
            $message = $benificiaryUpdater->updateBenificiary($benificiaryId, $volunteerId);

            echo htmlspecialchars($message); 
        } catch (PDOException $e) {
            echo "Database Error: " . htmlspecialchars($e->getMessage());
        } finally {
            $conn = null; 
        }
    } else {
        echo "No benificiary selected or user not logged in.";
    }
} else {
    echo "No benificiary selected.";
}
?>
