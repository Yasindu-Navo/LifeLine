<?php
header('Content-Type: application/json');
// Error handling for development
ini_set('display_errors', 0);  // Don't display PHP errors in the response
ini_set('log_errors', 1);      // Log errors instead
ini_set('error_log', '/path/to/php-error.log');  // Adjust this to your server's error log location

require_once 'Dbh.php';
$dbConnector = new Db_connector();
$conn = $dbConnector->getConnection();
$id = $_GET['id']; //get benificiary Id

session_start();

if (isset($_SESSION["username"])) {
    $query = "SELECT * FROM benificiary WHERE benificiaryId = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$id]); // Pass the benificiaryId to the query
    $benificiary = $stmt->fetch(PDO::FETCH_ASSOC); // Use fetch() to get a single row

    if ($benificiary) {

        $benificiaryName = $benificiary["patientName"];
        $amount = $_GET['amount'];
        $benificiaryId=$benificiary["benificiaryId"];
      

        $email=$_SESSION["username"];

        $merchant_id ="1228342";
        $order_id=$benificiaryId;
        $currency="LKR";
        $merchant_secret="MzYzNzgwNTk0Mjc1MzMwNzkzMTE5NDc5MTY5MzM0NTExODMxMQ==";


        $hash = strtoupper(
            md5(
                $merchant_id . 
                $order_id . 
                number_format($amount, 2, '.', '') . 
                $currency .  
                strtoupper(md5($merchant_secret)) 
            ) 
        );

         $array=[];
        $array['id']=$order_id;
        $array['item']=$benificiaryName;
        $array['amount']=$amount;
        $array['email']=$email;
        $array['hash']=$hash;
        echo json_encode($array);



    } else {
        echo '2'; // Invalid benificiaryId
    }
}else{  //if user is not signin
    echo '3';
}


