<?php
include_once '../Login_page/includes/Dbh.php';
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
    private $errorMessage = "";
    private $successMessage = "";
    private $conn;

    private $age = "";
    private $nic = "";
    private $district = "";
    private $pre = "";
    // private $result = "";



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
        if (empty($this->name) || empty($this->email) || empty($this->phone) || empty($this->address) || empty($this->image)) {
            $this->errorMessage = "All fields must be filled!";
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
            // $this->result = $this->sanitize($_POST["result"]);


            $this->image = $_FILES["image"]["name"];
            $tempName = $_FILES["image"]["tmp_name"];
            $targetPath = "upload/" . $this->image;

            if ($this->validate()) {
                if (move_uploaded_file($tempName, $targetPath)) {
                    $sql = "INSERT INTO volunteer(`Name`,`Email`,`Phone`,`Address`,`Usertype`,`image`,`age`,`nic`,`pre_task`,`district`) 
                            VALUES('$this->name','$this->email','$this->phone','$this->address','$this->usertype','$this->image','$this->age','$this->nic','$this->pre','$this->district')";
                    $result = $this->conn->query($sql);
                    if ($result) {
                        $this->successMessage = "Data added successfully!";
                        header("Location:../Project1/Afterindex.php");
                        exit;
                    } else {
                        $this->errorMessage = "Failed to add data!";
                    }
                } else {
                    $this->errorMessage = "Failed to upload image!";
                }
            }
        }
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    public function getSuccessMessage()
    {
        return $this->successMessage;
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
