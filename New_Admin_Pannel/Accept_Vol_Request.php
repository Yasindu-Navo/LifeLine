<?php

include "Dbh.php";
$dbConnector = new Db_connector();
$conn = $dbConnector->getConnection();

class Accept_Vol_Request{
    private $conn;
    private $id;

    public function __construct($conn,$id){
        $this->conn =$conn;
        $this->id=$id;
    }

    public function accept(){

        $type="Volunteer";

        $query="UPDATE user SET userType=? WHERE userId=(SELECT userId FROM volunteer WHERE volunteerId=?)";
        
        
        $pstmt=$this->conn->prepare($query);
        $pstmt->bindParam(1,$type);
        $pstmt->bindParam(2,$this->id);
        $pstmt->execute();

    }
}









if(isset($_GET['id'])){
    $id=$_GET['id'];
    $acceptReq= new Accept_Vol_Request($conn,$id);
    $acceptReq->accept();
    header("location:/New_Admin_Pannel/VolunteerReq.php");
    exit;
}else{
echo"OOPS..Volunteer Id is not found";
}




