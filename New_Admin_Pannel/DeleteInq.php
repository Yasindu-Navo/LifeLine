<?php
include "Dbh.php";
$dbConnector = new Db_connector();
$conn = $dbConnector->getConnection();

if (isset($_GET['id'])) {

    $id = $_GET['id'];
    $sql = "DELETE FROM contact_us WHERE messageId  = $id";
    $conn->query($sql);
}
header('location:/New_Admin_Pannel/Inquiries.php');
exit;
