<?php



class BenificiarySort
{
    private $conn;


    public function __construct($con)
    {
        $this->conn = $con;
    }

    public function getBenificiary()
    {

        $query1 = "SELECT * FROM benificiary";
        $stmt = $this->conn->prepare($query1);
        $stmt->execute();

        $rs = $stmt->fetchAll(PDO::FETCH_OBJ);     //get all benificiaries

        $operationScore=0;
        $dateScore = "";
        $incomeScore = "";


        foreach ($rs as $row) {

            //calculate operation score
            switch ($row->oprationType) {
                case "Heart disease":
                    $operationScore = 5;
                    break;
                case "Cancer disease":
                    $operationScore = 4;
                    break;
                case "Kidney disease":
                    $operationScore = 3;
                    break;
                case "Transplants":
                    $operationScore = 2;
                    break;
                case "Other":
                    $operationScore = 1;
                    break;

            }

            // echo 'Operation type Score is: ';
            //echo $oparationScore;
            //echo'<br>';

            // Get today's date
            $today = new DateTime();

            // Get the operation date from the database
            $operationDate = new DateTime($row->estimatedDate);


            // Calculate the number of days from today to the operation date
            $interval = $today->diff($operationDate);
            $daysToOperation = $interval->days;

            $dateScore = 1 / $daysToOperation;

            //calculate annual income score


            $incomeScore = 1 / ((int) $row->annual_Income + 1);

            // echo 'income Score is: ';
            //echo $incomeScore;

            $weight = ($operationScore * 0.5 + $incomeScore * 0.2 + $dateScore * 0.3);

            //echo 'Weighted value is:';
            //echo $weight;


            $query2 = "UPDATE benificiary set weightedValue=? WHERE benificiaryId =?";

            try {

                $pstmt = $this->conn->prepare($query2);
                $pstmt->bindParam(1, $weight);
                $pstmt->bindParam(2, $row->benificiaryId);
                $pstmt->execute();
               // echo 'value added Successfully<br>';


            } catch (PDOException $exc) {
                die("Error occured when adding weight" . $exc->getMessage());

            }




        } //end of foreach


    }

 

    public function insertUniqueBenificiaryIdsByWeight()
{
    // Step 1: Get the current number of rows in the selectedbenificiary table
    $queryCheckCount = "SELECT COUNT(*) FROM selectedbenificiary";
    $stmtCheckCount = $this->conn->prepare($queryCheckCount);
    $stmtCheckCount->execute();
    $rowCount = $stmtCheckCount->fetchColumn();

    // Step 2: Only proceed if the number of rows is less than 20
    if ($rowCount >= 20) {
       //echo "The selectedbenificiary table already has 20 rows. No more entries can be added.";
        return;
    }

    // Step 3:  fetch only benificiaryId and weightedValue sorted by highest weightedValue
    $query1 = "SELECT benificiaryId, weightedValue FROM benificiary ORDER BY weightedValue DESC";
    $stmt1 = $this->conn->prepare($query1);
    $stmt1->execute();
    $benificiaryIds = $stmt1->fetchAll(PDO::FETCH_ASSOC);

    foreach ($benificiaryIds as $benificiary) {
        $benificiaryId = $benificiary['benificiaryId'];

        // Step 4: Check if the benificiaryId already exists in the selectedbenificiary table
        $query2 = "SELECT COUNT(*) FROM selectedbenificiary WHERE benificiaryId = ?";
        $stmt2 = $this->conn->prepare($query2);
        $stmt2->bindParam(1, $benificiaryId);
        $stmt2->execute();
        $count = $stmt2->fetchColumn();

        // Step 5: Insert the benificiaryId only if it's not already present and row count is less than 20
        if ($count == 0 && $rowCount < 20) {
            $query3 = "INSERT INTO selectedbenificiary (benificiaryId) VALUES (?)";
            $stmt3 = $this->conn->prepare($query3);
            $stmt3->bindParam(1, $benificiaryId);
            try {
                $stmt3->execute();
                $rowCount++; // Increment the count after each successful insertion
                //echo "Inserted benificiaryId: $benificiaryId successfully.<br>";

                // Break the loop if 20 entries are reached
                if ($rowCount >= 20) {
                    echo "The selectedbenificiary table now has 20 rows. Stopping insertion.";
                    break;
                }
            } catch (PDOException $e) {
                //echo "Failed to insert benificiaryId: $benificiaryId. Error: " . $e->getMessage() . "<br>";
            }
        } else {
            //echo "benificiaryId: $benificiaryId already exists in selectedbenificiary table or row limit reached. Skipping.<br>";
        }
    }
}




}//end of class







