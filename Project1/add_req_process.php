<?php
session_start();
include_once 'Dbh.php';
$dbConnector = new Db_connector();
$conn = $dbConnector->getConnection();
class BeneficiaryForm
{
    private $name = "";
    private $District = "";
    private $Address = "";
    private $Age = "";
    private $Phone = "";
    private $Brands = "";
    private $image  = "";
    private $income = "";

    private $Gname = "";
    private $Gnic = "";
    private $Info = "";
    private $Hospital = "";
    private $Date = "";
    private $cost = "";



    private $conn;



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
        if (
            empty($this->name) ||  empty($this->District) || empty($this->Address) || empty($this->Age) || empty($this->Phone) || empty($this->Brands) || empty($this->image)
            || empty($this->Gname) || empty($this->Gnic) || empty($this->Info) || empty($this->Hospital) || empty($this->Date) || empty($this->cost) || empty($this->income)
        ) {

            header("location:add_req.php?s=5");
        }
        return true;
    }

    public function handleForm()
    {
        if (isset($_POST['submit'])) {
            $this->name = $this->sanitize($_POST["name"]);
            $this->District = $this->sanitize($_POST["district"]);
            $this->Phone = $this->sanitize($_POST["phone"]);
            $this->Address = $this->sanitize($_POST["address"]);
            $this->Age = $this->sanitize($_POST["age"]);
            $this->Brands = $_POST["oparation_type"];
            $this->Gname = $this->sanitize($_POST["Guardianname"]);
            $this->Gnic = $this->sanitize($_POST["Guardian_nic"]);
            $this->Info = $this->sanitize($_POST["info"]);
            $this->Hospital = $this->sanitize($_POST["hospital"]);
            $this->Date = $this->sanitize($_POST["days"]);
            $this->cost = $this->sanitize($_POST["amount"]);
            $this->income = $this->sanitize($_POST["income"]);

            // Get the image content as BLOB
            if (isset($_FILES["image"]["tmp_name"])) {
                $this->image = file_get_contents($_FILES["image"]["tmp_name"]);
            } else {
                header("location:add_req.php?s=2");
                exit;
            }

            if ($this->validate()) {
                $email = $_SESSION["username"];

                // Get userId from user table
                $stmt = $this->conn->prepare("SELECT userId FROM user WHERE userEmail = ?");
                $stmt->bindParam(1, $email);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result) {
                    $userId = $result['userId'];

                    // Check if user already registered a beneficiary
                    $stmt = $this->conn->prepare("SELECT userId FROM benificiary WHERE userId = ?");
                    $stmt->bindParam(1, $userId);
                    $stmt->execute();
                    $result1 = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($result1) {
                        header("location:add_req.php?s=4");
                        exit;
                    } else {
                        // Insert the beneficiary data along with the image as BLOB
                        $sql = "INSERT INTO benificiary 
                        (userId, patientName, nicNo, address, district, oprationType, 
                        estimatedDate, amount, age, gardian_No, gardian_Name, 
                        hospital_Name, intro, annual_Income, image) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                        $stmt = $this->conn->prepare($sql);
                        $stmt->bindParam(1, $userId);
                        $stmt->bindParam(2, $this->name);
                        $stmt->bindParam(3, $this->Gnic);
                        $stmt->bindParam(4, $this->Address);
                        $stmt->bindParam(5, $this->District);
                        $stmt->bindParam(6, $this->Brands);
                        $stmt->bindParam(7, $this->Date);
                        $stmt->bindParam(8, $this->cost);
                        $stmt->bindParam(9, $this->Age);
                        $stmt->bindParam(10, $this->Phone);
                        $stmt->bindParam(11, $this->Gname);
                        $stmt->bindParam(12, $this->Hospital);
                        $stmt->bindParam(13, $this->Info);
                        $stmt->bindParam(14, $this->income);
                        $stmt->bindParam(15, $this->image, PDO::PARAM_LOB);  // Bind BLOB

                        if ($stmt->execute()) {
                            header("location:add_req.php?s=1");
                            exit;
                        } else {
                            header("location:add_req.php?s=0");
                        }
                    }
                }
            }
        }
    }

    public function getName()
    {
        return $this->name;
    }

    public function getNic()
    {
        return $this->NIC;
    }
    public function getPhone()
    {
        return $this->Phone;
    }


    public function getAddress()
    {
        return $this->Address;
    }

    public function getImage()
    {
        return $this->image;
    }
    public function getAge()
    {
        return $this->Age;
    }
    public function getDistrict()
    {
        return $this->District;
    }
    public function getBrand()
    {
        return $this->Brands;
    }
    public function getGuardianName()
    {
        return $this->Gname;
    }
    public function getGuardianNic()
    {
        return $this->Gnic;
    }
    public function getInfo()
    {
        return $this->Info;
    }
    public function getHospital()
    {
        return $this->Hospital;
    }
    public function getDate()
    {
        return $this->Date;
    }
    public function getCost()
    {
        return $this->cost;
    }
}

$volunteerForm = new BeneficiaryForm($conn);
$volunteerForm->handleForm();
