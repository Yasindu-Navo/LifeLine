<?php
include "Dbh.php";
$dbConnector = new Db_connector();
$conn = $dbConnector->getConnection();

if (isset($_GET['id'])) {

    $id = $_GET['id'];
    $sql = "DELETE FROM selectedbenificiary WHERE benificiaryId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $id);
    $stmt->execute();

    $sql = "DELETE FROM benificiary WHERE benificiaryId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $id);
    $stmt->execute();
}
header('location:/New_Admin_Pannel/Beneficiary.php');
exit;
