<?php
include_once 'Dbh.php';
$dbConnector = new Db_connector();
$conn = $dbConnector->getConnection();
if (isset($_GET['search'])) {
    $sql = "SELECT volunteer.volunteerId,volunteer.phone,volunteer.address,volunteer.imageOfResult,user.userName,user.userEmail,user.created_At,user.userId  FROM volunteer WHERE (userName LIKE '%{}%')JOIN user ON volunteer.userId = user.userId ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
