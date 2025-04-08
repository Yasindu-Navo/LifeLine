<?php

require './dbConnector.php';
session_start();

// Debugging output to check session variables
// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";

if (isset($_SESSION['userid'])) {
    $userId = $_SESSION['userid'];

   

    $dbConnector = new DbConnector();
    $conn = $dbConnector->getConnection();

    // Get the volunteerId using userId
    $query = "SELECT volunteerId FROM volunteer WHERE userId = :userId";
    $pstmt = $conn->prepare($query);
    $pstmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $pstmt->execute();

    $result = $pstmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // add volunteerId in session
        $_SESSION['volunteerId'] = $result['volunteerId'];
        $volunteerId = $_SESSION['volunteerId'];

        
        $benificiary = new Benificiary($conn, $volunteerId);
        $benificiary->fetchData();
    } else {
        echo "<p>Volunteer not found for this user.</p>";
    }

    $conn = null;
} else {
    echo "<p>User is not logged in. Please log in to view benificiary data.</p>";
}

class Benificiary {

    private $conn;
    private $volunteerId;

    public function __construct($conn, $volunteerId) {
        $this->conn = $conn;
        $this->volunteerId = $volunteerId;
    }

    public function fetchData() {
        // Query for selecting beneficiary data
        $query = "
        SELECT benificiary.benificiaryId, benificiary.patientName, benificiary.address, benificiary.district, benificiary.gardian_No
        FROM benificiary
        JOIN selectedbenificiary ON benificiary.benificiaryId = selectedbenificiary.benificiaryId
        JOIN volunteer ON volunteer.district = benificiary.district
        WHERE volunteer.volunteerId = :volunteerId 
        AND selectedbenificiary.selected IS NULL 
        AND selectedbenificiary.completed IS NULL
        ";

        $pstmt = $this->conn->prepare($query);
        $pstmt->bindParam(':volunteerId', $this->volunteerId, PDO::PARAM_INT);
        $pstmt->execute();

        if ($pstmt->rowCount() > 0) {
            // Display data
            echo "<form method='post' action='submit.php'>";
            echo "<table class='table table-bordered table-striped pb-5'>";
            echo "<thead><tr>
                    <th>Patient Name</th>
                    <th>Address</th>
                    <th>District</th>
                    <th>Guardian Contact</th>
                    <th>Select</th>
                  </tr></thead>";
            echo "<tbody>";
            while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['patientName']) . "</td>
                        <td>" . htmlspecialchars($row['address']) . "</td>
                        <td>" . htmlspecialchars($row['district']) . "</td>
                        <td>0" . htmlspecialchars($row['gardian_No']) . "</td>
                        <td><input type='radio' name='selectBenificiary' value='" . htmlspecialchars($row['benificiaryId']) . "' required></td>
                      </tr>";
            }
            echo "</tbody></table>";
//             echo "<button type='submit' class='btn btn-primary'>Submit</button>";
            echo "</form>";
        } else {
            echo "<p>No benificiaries found for your district.</p>";
        }
    }
}
?>
