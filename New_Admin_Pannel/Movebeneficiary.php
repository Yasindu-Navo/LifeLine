<?php
include "Dbh.php";
$dbConnector = new Db_connector();
$conn = $dbConnector->getConnection();

class Movebeneficiary
{

    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function move()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // First query: SELECT the beneficiary by ID
            $sql = "SELECT * FROM benificiary WHERE benificiaryId = ?";
            $pstmt = $this->conn->prepare($sql);
            $pstmt->bindValue(1, $id, PDO::PARAM_INT);  // Assuming $id is an integer
            $pstmt->execute();
            $benificiary = $pstmt->fetch(PDO::FETCH_ASSOC);

            $name = $benificiary["patientName"];
            $nic = $benificiary["nicNo"];
            $address = $benificiary["address"];
            $operationType = $benificiary["oprationType"];
            $amount = $benificiary["amount"];
          
            //get benificiary email

            $query="SELECT userEmail FROM user WHERE userId=(SELECT userId FROM benificiary WHERE benificiaryId=?)";
            try {
            
                $pstmt = $this->conn->prepare($query);
                $pstmt->bindParam(1, $id);
               
                $pstmt->execute();
                $email= $pstmt->fetch(PDO::FETCH_COLUMN);
            }catch (PDOException $exc) {
                die("Error occured when getting email address" . $exc->getMessage());
            
            }

            if ($benificiary) {

                $sql2 = "INSERT INTO completedcases(name,nic,address,operationType,amount,email) VALUES (?,?,?,?,?,?)";
                $pstmt2 = $this->conn->prepare($sql2);
                $pstmt2->bindValue(1, $name);
                $pstmt2->bindValue(2, $nic);
                $pstmt2->bindValue(3, $address);
                $pstmt2->bindValue(4, $operationType);
                $pstmt2->bindValue(5, $amount);
                $pstmt2->bindValue(6, $email);
                $pstmt2->execute();


                // Delete related rows in selectedbenificiary
                $sql3 = "DELETE FROM selectedbenificiary WHERE benificiaryId = ?";
                $pstmt3 = $this->conn->prepare($sql3);
                $pstmt3->bindValue(1, $id, PDO::PARAM_INT);
                $pstmt3->execute();

                // Third query: Delete the beneficiary from benificiary table
                $sql4 = "DELETE FROM benificiary WHERE benificiaryId = ?";
                $pstmt4 = $this->conn->prepare($sql4);
                $pstmt4->bindValue(1, $id, PDO::PARAM_INT);
                $pstmt4->execute();

                header('Location: /New_Admin_Pannel/Beneficiary.php');
                exit;



            } else {
                echo "Beneficiary not found.";
            }

        } else {
            echo "No ID specified.";
        }
    }

  
}


$moveBeneficiary = new Movebeneficiary($conn);
$moveBeneficiary->move();






