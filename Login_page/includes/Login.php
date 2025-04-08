<?php
require_once 'Dbh.php';
require_once 'Funtions.php';
session_start();


if (isset($_POST["submit"])) {
    $loginHandler = new LoginHandler($_POST);
    $loginHandler->handleLogin();
} else {
    header('Location:/Project1/Afterindex.php');
    exit();
}



class LoginHandler
{
    private $conn;
    private $username;
    private $password;
    private $userHandler;

    public function __construct($postData)
    {
        $this->username = $postData["username"];
        $this->password = $postData["Password"];


        $db = new Db_connector();
        $this->conn = $db->getConnection();
        $this->userHandler = new UserHandler($this->conn);
    }

    public function handleLogin()
    {
        if ($this->userHandler->emptyInputsLogin($this->username, $this->password)) {
            header("Location:/Project1/login_User.php?error=emptyInput");
            exit();
        }

        $sql = "SELECT * FROM user WHERE userEmail = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$this->username]);
        $userType = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userType) {
            if (password_verify($this->password, $userType["userPassword"])) {
                if ($userType["userType"] == "User") {
                    $this->userHandler->loginUser($this->username, $this->password);
                } elseif ($userType["userType"] == "Admin") {
                    $this->userHandler->loginAdmin($this->username, $this->password);
                } elseif ($userType["userType"] == "Volunteer") {
                    $this->userHandler->loginVolunteer($this->username, $this->password);
                } else {
                    header("Location:/Project1/login_User.php?error=wronglogin");
                    exit();
                }
            } else {
                header("Location:/Project1/login_User.php?error=wronglogin");
                exit();
            }
        } else {
            header("Location:/Project1/login_User.php?error=wronglogin");
            exit();
        }
    }
}
