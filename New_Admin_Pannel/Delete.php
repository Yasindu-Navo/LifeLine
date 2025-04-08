<?php
include "Dbh.php";
$dbConnector = new Db_connector();
$conn = $dbConnector->getConnection();

if (isset($_GET['id'])) {

    $id = $_GET['id'];
    $sql = "DELETE FROM volunteer WHERE volunteerId = $id";
    $conn->query($sql);
    header('location:/New_Admin_Pannel/Admin_conrol.php');
exit;
}



if (isset($_GET['reqId'])) {

    $id = $_GET['reqId'];
    $sql = "DELETE FROM volunteer WHERE volunteerId = $id";
    $conn->query($sql);
    header('location:/New_Admin_Pannel/VolunteerReq.php');
exit;
}