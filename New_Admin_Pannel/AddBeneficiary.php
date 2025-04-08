<?php
session_start();
include_once 'Dbh.php';
$dbConnector = new Db_connector();
$conn = $dbConnector->getConnection();
class BeneficiaryForm
{
    private $name = "";
    private $NIC = "";
    private $District = "";
    private $Address = "";
    private $Age = "";
    private $Phone = "";
    private $Brands = "";
    private $image  = "";

    private $Gname = "";
    // private $GPhone = "";
    private $Gnic = "";
    private $Info = "";
    private $Hospital = "";
    private $Date = "";
    private $cost = "";


    private $errorMessage = "";
    private $successMessage = "";

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
            empty($this->name) || empty($this->NIC) || empty($this->District) || empty($this->Address) || empty($this->Age) || empty($this->Phone) || empty($this->Brands) || empty($this->image)
            || empty($this->Gname) || empty($this->Gnic) || empty($this->Info) || empty($this->Hospital) || empty($this->Date) || empty($this->cost)
        ) {
            $this->errorMessage = "All fields must be filled!";
            return false;
        }
        return true;
    }

    public function handleForm()
    {
        if (isset($_POST['resubmit'])) {
            $this->name = $this->sanitize($_POST["name"]);
            $this->NIC = $this->sanitize($_POST["nic"]);
            $this->District = $this->sanitize($_POST["district"]);
            $this->Phone = $this->sanitize($_POST["phone"]);
            $this->Address = $this->sanitize($_POST["address"]);
            $this->Age = $this->sanitize($_POST["age"]);
            // $this->usertype = $this->sanitize($_POST["usertype"]);
            $this->Brands = implode(",", $_POST["oparation_type"]); //check again
            $this->Gname = $this->sanitize($_POST["Guardianname"]);
            $this->Gnic = $this->sanitize($_POST["Guardian_nic"]);
            $this->Info = $this->sanitize($_POST["info"]);
            $this->Hospital = $this->sanitize($_POST["hospital"]);
            $this->Date = $this->sanitize($_POST["days"]);
            $this->cost = $this->sanitize($_POST["amount"]);

            $this->image = $_FILES["image"]["name"];
            $tempName = $_FILES["image"]["tmp_name"];
            $targetPath = "upload/" . $this->image;

            if ($this->validate()) {
                if (move_uploaded_file($tempName, $targetPath)) {
                    // $sql = "INSERT INTO beneficiary(`PatientName`,`NICno`,`Address`, `District`, `Oparation_Type`,`Estimated_Date`,`Amount`,`Age`,`Guardian_No`,`Guardian_Name`,`Hospital_Name`,`Intro`,`image`) 
                    //         VALUES('$this->name','$this->NIC','$this->Address','$this->District','$this->Brands','$this->Date','$this->cost','$this->Age','$this->Phone','$this->Gname','$this->Hospital','$this->Info','$this->image')";
                    // $result = $this->conn->query($sql);
                    $email = $_SESSION["username"];
                    $quary = "SELECT userId FROM user WHERE userEmail = ?";
                    $stmt = $this->conn->prepare($quary);
                    $stmt->bindParam(1, $email);
                    $stmt->execute();

                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    $result = $stmt->fetch();

                    if ($result) {
                        $userId = $result['userId'];

                        $quary = "SELECT userId FROM benificiary WHERE userId = ?";
                        $stmt = $this->conn->prepare($quary);
                        $stmt->bindParam(1, $userId);
                        $stmt->execute();

                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                        $result1 = $stmt->fetch();

                        if ($result1) {

                            $this->errorMessage = "Already Registerd One user can register only one time due to high patient capacity!!";
                            return false;
                        } else {

                            $sql = "INSERT INTO benificiary (`userId`,`patientName`,`nicNo`,`address`,`district`,`oprationType`,`estimatedDate`,`amount`,`age`,`gardian_No`,`gardian_Name`, `hospital_Name`,`intro`,`image`) 
                        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";


                            $stmt = $this->conn->prepare($sql);


                            $stmt->bindParam(1, $userId);
                            $stmt->bindParam(2, $this->name);
                            $stmt->bindParam(3, $this->NIC);
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
                            $stmt->bindParam(14, $this->image);


                            $result = $stmt->execute();


                            if ($result) {
                                $this->successMessage = "Data added successfully!";
                                header("location:/New_Admin_Pannel/Beneficiary.php");
                                exit;
                            } else {
                                $this->errorMessage = "Failed to add data!";
                            }
                        }
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
    // public function getGuardianPhone()
    // {
    //     return $this->GPhone;
    // }
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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body style="background-color: rgb(224, 232, 225);">
    <div class="container my-5" style="margin-left: 250px;">
        <div class="row mb-3" >
            <h2 style="margin-bottom: 25px;">New Beneficiary Details</h2>
            
        </div>

        <form method="post" enctype="multipart/form-data">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($volunteerForm->getName()); ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">NIC NO</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="nic" value="<?php echo htmlspecialchars($volunteerForm->getNic()); ?>" required>
                </div>
            </div>
            <!-- <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Address</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="address" value="">
                </div>
            </div> -->
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Phone</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="phone" value="<?php echo htmlspecialchars($volunteerForm->getPhone()); ?>" required>
                </div>
            </div>
            <!-- <div class="row mb-3">
                <label class="col-sm-3 col-form-label">District</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="district" value="<?php echo htmlspecialchars($volunteerForm->getDistrict()); ?>" required>
                </div>
            </div> -->

            <div class="row mb-3">
            <label class="col-sm-3 col-form-label">District</label>
            <div class="col-sm-6">
                            <select id="inputState" class="form-select" name="district" required>

                                <option selected>  </option>
                                <option value="Ampara">Ampara</option>
                                <option value="Anuradhapura">Anuradhapura</option>
                                <option value="Badulla">Badulla</option>
                                <option value="Batticaloa">Batticaloa</option>
                                <option value="Colombo">Colombo</option>
                                <option value="Galle">Galle</option>
                                <option value="Gampaha">Gampaha</option>
                                <option value="Hambantota">Hambantota</option>
                                <option value="Jaffna">Jaffna</option>
                                <option value="Kalutara">Kalutara</option>
                                <option value="Kandy">Kandy</option>
                                <option value="Kegalle">Kegalle</option>
                                <option value="Kilinochchi">Kilinochchi</option>
                                <option value="Kurunegala">Kurunegala</option>
                                <option value="Mannar">Mannar</option>
                                <option value="Matale">Matale</option>
                                <option value="Matara">Matara</option>
                                <option value="Monaragala">Monaragala</option>
                                <option value="Mullaitivu">Mullaitivu</option>
                                <option value="Nuwara Eliya">Nuwara Eliya</option>
                                <option value="Polonnaruwa">Polonnaruwa</option>
                                <option value="Puttalam">Puttalam</option>
                                <option value="Ratnapura">Ratnapura</option>
                                <option value="Trincomalee">Trincomalee</option>
                                <option value="Vavuniya">Vavuniya</option>
                            </select>
                            </div>
                        </div>


            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Oparation type</label>
                <div class="col-sm-6">

                <div class="form-check-inline" style="padding: 3px;">
                    <input type="radio" class="btn-check" id="btn-check-1"  value="Heart disease" name=oparation_type[] autocomplete="off">
                    <label class="btn btn-outline-success" for="btn-check-1" >Heart disease</label>
                </div>

                <div class="form-check-inline" style="padding: 3px;">
                    <input type="radio" class="btn-check" id="btn-check-2" value="Cancer disease" name=oparation_type[] autocomplete="off">
                    <label class="btn btn-outline-success" for="btn-check-2">Cancer disease</label>
                </div>
                
                <div class="form-check-inline" style="padding: 3px;">
                    <input type="radio" class="btn-check" id="btn-check-3" value="Kidney disease" name=oparation_type[] autocomplete="off">
                    <label class="btn btn-outline-success" for="btn-check-3">Kidney disease</label>
                </div>

                <div class="form-check-inline" style="padding: 3px;">
                    <input type="radio" class="btn-check" id="btn-check-4" value="liver disease" name=oparation_type[] autocomplete="off">
                    <label class="btn btn-outline-success" for="btn-check-4">Liver disease</label>
                </div>

                <div class="form-check-inline" style="padding: 3px;">
                    <input type="radio" class="btn-check" id="btn-check-5" value="other" name=oparation_type[] autocomplete="off">
                    <label class="btn btn-outline-success" for="btn-check-5">Other</label>
                </div>


                    <!-- <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="Heart disease" name=oparation_type[]>
                        <label class="form-check-label" for="inlineCheckbox1">heart disease</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="Cancer disease" name=oparation_type[]>
                        <label class="form-check-label" for="inlineCheckbox2">Cancer disease</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="Kidney disease" name=oparation_type[]>
                        <label class="form-check-label" for="inlineCheckbox2">Kidney disease</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="liver disease" name=oparation_type[]>
                        <label class="form-check-label" for="inlineCheckbox2">Liver disease</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="other" name=oparation_type[]>
                        <label class="form-check-label" for="inlineCheckbox2">Other</label>
                    </div> -->
                </div>
            </div>





            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Address</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="address" value="<?php echo htmlspecialchars($volunteerForm->getAddress()); ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Age</label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" id="" name="age" value="<?php echo htmlspecialchars($volunteerForm->getAge()); ?>" required>
                </div>
            </div>


            <div class="row mb-3">
                <label class=" col-sm-3 col-form-label">Description About Present medical Condition</label>
                <div class="col-sm-6">
                    <textarea class="form-control" id="condition" style="height: 150px" name="info" value="<?php echo htmlspecialchars($volunteerForm->getInfo()); ?>" required></textarea>
                </div>
            </div>

            <div class="row mb-3">
                <label class=" col-sm-3 col-form-label">The hospital where the surgery is to be preformed</label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" id="" name="hospital" value="<?php echo htmlspecialchars($volunteerForm->getHospital()); ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <label class=" col-sm-3 col-form-label">Surgery Date</label>
                <div class="col-sm-6">
                    <input class="form-control" type="date" id="date" name="days" value="<?php echo htmlspecialchars($volunteerForm->getDate()); ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <label class=" col-sm-3 col-form-label">Estimation cost of surgery</label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" id="" name="amount" value="<?php echo htmlspecialchars($volunteerForm->getCost()); ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <label class=" col-sm-3 col-form-label">Guardian's Full Name</label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" id="" name="Guardianname" value="<?php echo htmlspecialchars($volunteerForm->getGuardianName()); ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <label class=" col-sm-3 col-form-label">Guardian's Contact Number</label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" id="" name="Guardian_number" value="<?php echo htmlspecialchars($volunteerForm->getPhone()); ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <label class=" col-sm-3 col-form-label">Guardian's NIC Number</label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" id="" name="Guardian_nic" value="<?php echo htmlspecialchars($volunteerForm->getGuardianNic()); ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Image</label>
                <div class="col-sm-6">
                    <input class="form-control" type="file" id="image" name="image" value="<?php echo htmlspecialchars($volunteerForm->getImage()); ?>" required>
                </div>
            </div>

            <div class='row mb-3'>
                <?php

                if (!empty($volunteerForm->getErrorMessage())) {
                    echo '<div class="alert alert-warning">' . $volunteerForm->getErrorMessage() . '</div>';
                }
                if (!empty($volunteerForm->getSuccessMessage())) {
                    echo '<div class="alert alert-success">' . $volunteerForm->getSuccessMessage() . '</div>';
                }
                ?>
            </div>
<br><br>
            <div class=" row mb-3">

                <div class="offset-sm-3 col-sm-3 d-grid" style="margin-left: 35px; margin-right:200px;">
                    <button type="submit" class="btn btn-outline-success" name="resubmit">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a type="submit" class="btn btn-outline-success" href="/New_Admin_Pannel/Beneficiary.php" role="button">Cancel</a>
                </div>
            </div>

            <br>
        </form>
    </div>
</body>

</html>