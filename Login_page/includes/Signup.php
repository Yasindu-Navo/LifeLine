<?php
require_once 'Dbh.php';
require_once 'Funtions.php';


if (isset($_POST["SignUp"])) {
    $signupHandler = new SignupHandler($_POST);
    $signupHandler->handleSignup();
} else {
    header('Location:/Project1/index.php');
    exit();
}

class SignupHandler
{
    private $conn;
    private $name;
    private $username;
    private $email;
    private $password;
    private $rePassword;
    private $userType;
    private $userHandler;

    public function __construct($postData)
    {
        $this->name = $postData["name"];
        $this->username = $postData["username"];
        $this->email = $postData["email"];
        $this->password = $postData["Password"];
        $this->rePassword = $postData["rePassword"];
        $this->userType = $postData["usertype"];

        $db = new Db_connector();
        $this->conn = $db->getConnection();
        $this->userHandler = new UserHandler($this->conn);
    }

    public function handleSignup()
    {
        if ($this->userHandler->emptyInputSignup($this->name, $this->username, $this->email, $this->password, $this->rePassword)) {
            header("Location:/Project1/user_signin2.php?error=emptyInput");
            exit();
        }
        if ($this->userHandler->invalidUid($this->username)) {
            header("Location:/Project1/user_signin2.php?error=invalidUid");
            exit();
        }
        if ($this->userHandler->invalidEmail($this->email)) {
            header("Location:/Project1/user_signin2.php?error=invalidEmail");
            exit();
        }
        if ($this->userHandler->pwdMatch($this->password, $this->rePassword)) {
            header("Location:/Project1/user_signin2.php?error=pwdMatch");
            exit();
        }
        if ($this->userHandler->uidExists($this->username, $this->email)) {
            header("Location:/Project1/user_signin2.php?error=uidExists");
            exit();
        }

        $this->userHandler->createUser($this->name, $this->email, $this->username, $this->password, $this->userType);

        header("Location:/Project1/index.php"); //correcct afterindex.php
        exit();
    }
}
