<?php
session_start();
include_once 'Dbh.php';
$dbConnector = new Db_connector();
$conn = $dbConnector->getConnection();
class VolunteerForm
{
    private $name = "";
    private $email = "";
    private $phone = "";
    private $address = "";
    private $image = "";
    private $usertype = "";
    private $policeImg = "";
    private $result = "";

    private $conn;

    private $age = "";
    private $nic = "";
    private $district = "";
    private $pre = "";




    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    private function sanitize($data)
    {
        $data = trim($data);
        $data = htmlspecialchars($data);
        $data = stripcslashes($data);
        return $data;
    }

    private function validate()
    {
        if (empty($this->name) || empty($this->email) || empty($this->phone) || empty($this->address) || empty($this->image) || empty($this->result) || empty($this->policeImg)) {
            header("location:/Project1/vol_reg.php?s=3");
            return false;
        }
        return true;
    }

    public function handleForm()
    {
        if (isset($_POST['submit'])) {
            $this->name = $this->sanitize($_POST["name"]);
            $this->email = $this->sanitize($_POST["email"]);
            $this->phone = $this->sanitize($_POST["phone"]);
            $this->address = $this->sanitize($_POST["address"]);
            $this->usertype = $this->sanitize($_POST["usertype"]);

            $this->age = $this->sanitize($_POST["age"]); //add bellow form
            $this->nic = $this->sanitize($_POST["nic"]);
            $this->district = $this->sanitize($_POST["district"]);
            $this->pre = $this->sanitize($_POST["pre"]);
            $this->result = $this->sanitize($_POST["result"]);


            $this->image = $_FILES["image"]["name"];
            $tempName = $_FILES["image"]["tmp_name"];
            $targetPath = "upload/" . $this->image;

            $this->policeImg = $_FILES["policeimage"]["name"];
            $tempName = $_FILES["policeimage"]["tmp_name"];
            $targetPath = "upload/" . $this->policeImg;

            if ($this->validate()) {
                if (move_uploaded_file($tempName, $targetPath)) {

                    $email = $_SESSION['username']; //changed username
                    $quary = "SELECT userId FROM user WHERE userEmail = ?";
                    $stmt = $this->conn->prepare($quary);
                    $stmt->bindParam(1, $email);
                    $stmt->execute();
                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    $result = $stmt->fetch();

                    if ($result) {
                        $userId = $result['userId'];

                        if ($result) {
                            $userId = $result['userId'];

                            $quary = "SELECT userId FROM volunteer WHERE userId = ?";
                            $stmt = $this->conn->prepare($quary);
                            $stmt->bindParam(1, $userId);
                            $stmt->execute();
                            $stmt->setFetchMode(PDO::FETCH_ASSOC);
                            $result1 = $stmt->fetch();

                            if ($result1) {
                                header("location:/Project1/vol_reg.php?s=2");
                                return false;
                            } else {
                                $sql = "INSERT INTO volunteer (`userId`, `phone`, `address`,`imageOfResult`,`userType`,`age`,`nic`,`district`,`pre`,`imageOfPloiceReport`,`result`) 
                            VALUES (?,?,?,?,?,?,?,?,?,?,?)";


                                $stmt = $this->conn->prepare($sql);

                                $stmt->bindParam(1, $userId);

                                $stmt->bindParam(2, $this->phone);
                                $stmt->bindParam(3, $this->address);
                                $stmt->bindParam(4, $this->image);
                                $stmt->bindParam(5, $this->usertype);
                                $stmt->bindParam(6, $this->age);
                                $stmt->bindParam(7, $this->nic);
                                $stmt->bindParam(8, $this->district);
                                $stmt->bindParam(9, $this->pre);
                                $stmt->bindParam(10, $this->policeImg);
                                $stmt->bindParam(11, $this->result);


                                $result = $stmt->execute();

                                if ($result) {

                                    header("location:/Project1/vol_reg.php?s=1");

                                    exit;
                                } else {


                                    header("location:/Project1/vol_reg.php?s=0");
                                }
                            }
                        }
                    } else {

                        header("location:/Project1/vol_reg.php?s=0");
                    }
                } else {

                    header("location:/Project1/vol_reg.php?s=0");
                }
            }
        }
    }



    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getAge()
    {

        return $this->age;
    }
    public function getNic()
    {

        return $this->nic;
    }
    public function getDistrict()
    {
        return $this->district;
    }
    public function getPre()
    {

        return $this->pre;
    }
}

$volunteerForm = new VolunteerForm($conn);
$volunteerForm->handleForm();
