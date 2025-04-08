
<?php
include "Dbh.php";
$dbConnector = new Db_connector();
$conn = $dbConnector->getConnection();

if (isset($_GET['id'])) {

    $id = $_GET['id'];
    $sql = "DELETE FROM paststory WHERE storyId  = $id";
    $conn->query($sql);
}
header('location:/New_Admin_Pannel/past_story.php');
exit;
