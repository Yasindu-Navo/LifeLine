<?php
require_once 'Dbh.php'; // Include database connection

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Initialize DB connection
    $dbConnector = new Db_connector();
    $conn = $dbConnector->getConnection();

    // Fetch the image binary data
    $sql = "SELECT image FROM benificiary WHERE benificiaryId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row && $row['image']) {
        // Send headers to force download
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="beneficiary_image_' . $id . '.jpg"');
        header('Content-Length: ' . strlen($row['image']));
        echo $row['image']; // Output the image data
        exit;
    } else {
        echo "Image not found.";
    }
} else {
    echo "Invalid request.";
}
