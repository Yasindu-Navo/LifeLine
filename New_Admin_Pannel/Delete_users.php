<?php
include "Dbh.php";
$dbConnector = new Db_connector();
$conn = $dbConnector->getConnection();

if (isset($_GET['id'])) {

    $id = $_GET['id'];
    $benificiaryId = null;


    $sql = "DELETE FROM user WHERE userId  = $id";
    $conn->query($sql);
}
header('location:/New_Admin_Pannel/Users_control.php');
exit;
