<?php
session_start();
?>

<?php
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
  public function getErrorMessage()
  {
    return $this->errorMessage;
  }
  // public function setErrorMessage()
  // {
  //   return $this->errorMessage;
  // }

  public function getSuccessMessage()
  {
    return $this->successMessage;
  }

  private function validate()
  {
    if (
      empty($this->name) || empty($this->NIC) || empty($this->District) || empty($this->Address) || empty($this->Age) || empty($this->Phone) || empty($this->Brands) || empty($this->image)
      || empty($this->Gname) || empty($this->Gnic) || empty($this->Info) || empty($this->Hospital) || empty($this->Date) || empty($this->cost)
    ) {
      $this->errorMessage = "All fields must be filled!";

      return false;
      // header("Location:/Project1/add_req.php?error=emptyInput");
      // exit();
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
          $sql = "INSERT INTO beneficiary(`PatientName`,`NICno`,`Address`, `District`, `Oparation_Type`,`Estimated_Date`,`Amount`,`Age`,`Guardian_No`,`Guardian_Name`,`Hospital_Name`,`Intro`,`image`) 
                            VALUES('$this->name','$this->NIC','$this->Address','$this->District','$this->Brands','$this->Date','$this->cost','$this->Age','$this->Phone','$this->Gname','$this->Hospital','$this->Info','$this->image')";
          $result = $this->conn->query($sql);
          if ($result) {
            $this->successMessage = "Data added successfully!";
            header("location:../Project1/add_req.php");
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
  <!--css-->


  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/add_req.css">

  <title>LIFE LINE</title>
  <link rel="icon" type="image/x-icon" href="images/logo3.png">


  <!--Bootstrap-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      var dateInput = document.getElementById("days");
      var today = new Date();
      var minDate = new Date();
      minDate.setMonth(today.getMonth() + 3);
      var month = (minDate.getMonth() + 1).toString().padStart(2, '0');
      var day = minDate.getDate().toString().padStart(2, '0');
      var year = minDate.getFullYear();
      dateInput.min = `${year}-${month}-${day}`;
    });
  </script>

</head>

<body>
  <!--navigation start-->

  <div>
    <nav class="navbar navbar-expand-lg bg-white vh-10 overflow-hidden fixed-top">
      <div class="container ">
        <a href="index.php" id="logo-img"><img src="images/logo3br.png" alt=""></a>
        <!--button-->
        <button class="navbar-toggler shadow-none border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
          <span class="navbar-toggler-icon"></span>
        </button>
        <!--sidebar-->
        <div class="sidebar offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
          <!--sidebarbody-->
          <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasNavbarLabel"><img src="images/logo3.png" alt="Logo" class="logoL"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>

          <div div class="offcanvas-body">
            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
              <li class="menu-item">
                <a class="navlink" href="Afterindex.php">Home </a>
              </li>
              <li class="menu-item">
                <a class="navlink" href="Stories.php">Stories </a>
              </li>
              <li class="menu-item">
                <a class="navlink" href="past_project.php">Past-Projects</a>
              </li>
              <li class="menu-item">
                <a class="navlink" href="Volunteer.php">Volunteer</a>
              </li>
              <li class="menu-item">
                <a class="navlink" href="About.php">About_Us</a>
              </li>
              <li class="menu-item">
                <a class="navlink" href="Contact_us.php">Contact_Us</a>
              </li>
              <li class="menu-item">
                <?php

                //To show username in btn
                if (isset($_SESSION["username"])) {
                  echo  '<li class="menu-item"><a href ="#"  id="userName">' . $_SESSION["useruid"] . '</a></li>'; /*yet delcare href to ditec the page*/
                  echo '<li class="menu-item"><a href ="Logout.php"> Logout <a/></li>';
                }

                ?>
              </li>


            </ul>

          </div>
        </div>
      </div>
    </nav>
  </div>
  <!--navigation end-->
  <!--requset start-->

  <section class="request-section">
    <h1 class="caption">Request For The Donation</h1>
    <div class="container pt-5 col-8">

      <?php
      if (!empty($volunteerForm->getErrorMessage())) {
        echo '<div class="alert alert-warning">' . $volunteerForm->getErrorMessage() . '</div>';
      }
      if (!empty($volunteerForm->getSuccessMessage())) {
        echo '<div class="alert alert-success">' . $volunteerForm->getSuccessMessage() . '</div>';
      }

      ?>


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
            <input type="text" class="form-control" name="district" value="" required>
          </div>
        </div> -->
        <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Patient's District</label>
          <div class="col-sm-6">
            <select id="inputState" class="form-select" name="district" value="<?php echo htmlspecialchars($volunteerForm->getDistrict()); ?>" required>
              <option selected>Select Your District</option>
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

            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="Heart disease" name=oparation_type[]>
              <label class="form-check-label" for="inlineCheckbox1">heart disease</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="Cancer disease" name=oparation_type[]>
              <label class="form-check-label" for="inlineCheckbox2">Cancer disease</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="Kidney disease" name=oparation_type[]>
              <label class="form-check-label" for="inlineCheckbox2">Kidney disease</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="inlineCheckbox4" value="liver disease" name=oparation_type[]>
              <label class="form-check-label" for="inlineCheckbox2">Liver disease</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="inlineCheckbox5" value="other" name=oparation_type[]>
              <label class="form-check-label" for="inlineCheckbox2">Other</label>
            </div>
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
            <!-- <input class="form-control" type="text" id="" name="days" value=" ?>" required> -->
            <input type="date" class="form-control" id="days" name="days" value="<?php echo htmlspecialchars($volunteerForm->getDate()); ?>" required>
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





        <div class="row mb-3 justify-content-center">
          <div class="col-sm-3 d-grid mt-2">
            <a><button type="submit" class="btn btn-outline-success" name="resubmit">Submit</button></a>
            <!-- <a name="resubmit" class="btn btn-outline-success" role="button" aria-pressed="true">Submit</a> -->
          </div>
          <div class="col-sm-3 d-grid mt-2 ">
            <!-- <button class="btn btn-outline-danger" href="Afterindex.php">Cancel</button> -->
            <a href="Afterindex.php" class="btn btn-outline-danger" role="button" aria-pressed="true">Cancel</a>
          </div>
        </div>








    </div>


    </form>


    </div>

  </section>



  <!--request section end-->


  <!--footer section start-->
  <footer class="footer">
    <div class="container">
      <div class="row">

        <div class="col-lg-2">
          <div class="footer-logo">
            <div>
              <a href="">
                <img src="images/logo3ii.png" alt="footer logo">
              </a>
            </div>

          </div>
        </div>
        <div class="col-lg-2 offset-lg-1">
          <div class="footer-link">
            <P>Important Links</P>
            <ul>
              <li><a href="index.php">Home</a></li>
              <li><a href="Stories.php">Stories</a></li>
              <li><a href="">Past-Projects</a></li>
              <li><a href="Volunteer.php">Volunteer</a></li>
              <li><a href="About.php">About_Us</a></li>
              <li><a href="Contact_us.php">Contact_Us</a></li>
            </ul>
          </div>
        </div>
        <div class="col-lg-2 offset-lg-1">
          <div class="footer-contact">
            <p>Contact Info</p>
            <ul>
              <li>Phone:<br>&nbsp;&nbsp;+94768663035<br>&nbsp;&nbsp;+94776626075</li>
              <li>Email:<br>&nbsp;&nbsp;abc@gmail.com</li>
            </ul>
          </div>
        </div>
        <div class="col-lg-2 offset-lg-1">
          <div class="footer-media">
            <p>Social Media</p>
            <ul>
              <li><a href=" "><img src="images/facebook.png"></a></li>
              <li><a href=" "><img src="images/twitter.png"></a></li>
              <li><a href=" "><img src="images/instagram.png"></a></li>
            </ul>
          </div>
        </div>

      </div>

    </div>
  </footer>
  <div class="back-to-top d-flex flex-row-reverse">
    <div>
      <a href=""><img src="images/back to top.png" alt="" class="p-1"></a>
    </div>
  </div>

  <!--footer section end-->


  <!--javascript-->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>