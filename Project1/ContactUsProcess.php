<?php
include_once 'Dbh.php';
$dbConnector = new Db_connector();
$conn = $dbConnector->getConnection();
class ContactUsProcess
{
    private $fname = "";
    private  $lname = "";
    private $email = "";
    private $message = "";

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
        if (empty($this->fname) || empty($this->lname) || empty($this->email) || empty($this->message)) {
            $this->errorMessage = "All fields must be filled!";
            return false;
        }
        return true;
    }

    public function handleForm()
    {
        if (isset($_POST['submit'])) {
            $this->fname = $this->sanitize($_POST["fname"]);
            $this->lname = $this->sanitize($_POST["lname"]);
            $this->email = $this->sanitize($_POST["email"]);
            $this->message = $this->sanitize($_POST["message"]);

            if ($this->validate()) {

                $sql = "INSERT INTO contact_us(`firstName`, `lastName`,`email`,`message`) 
                    VALUES(?,?,?,?)";
                try {
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bindValue(1, $this->fname);
                    $stmt->bindValue(2, $this->lname);
                    $stmt->bindValue(3, $this->email);
                    $stmt->bindValue(4, $this->message);

                    $a = $stmt->execute();
                    if ($a > 0) {
                        $this->successMessage = "Data added successfully!";
                        header('Location:Contact_us.php?s=1');
                    } else {
                        $this->errorMessage = "Failed to add data!";
                        header('Location:Contact_us.php?s=0');
                    }
                } catch (Exception $ex) {
                    die($ex->getMessage());
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
    public function getLname()
    {
        return $this->lname;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getFname()
    {
        return $this->fname;
    }
}

$ContactUsProcess = new ContactUsProcess($conn);
$ContactUsProcess->handleForm();
