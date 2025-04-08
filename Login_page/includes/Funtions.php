<?php
session_start();
class UserHandler
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function emptyInputSignup($name, $username, $email, $password, $rePassword)
    {
        return empty($name) || empty($email) || empty($username) || empty($password) || empty($rePassword);
    }

    public function invalidUid($username)
    {
        return !preg_match("/^[a-zA-Z0-9]*$/", $username);
    }

    public function invalidEmail($email)
    {
        return !filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public function pwdMatch($password, $rePassword)
    {
        return $password !== $rePassword;
    }

    public function uidExists($username, $email)
    {
        $sql = "SELECT * FROM user WHERE userUid = ? OR userEmail = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$username, $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createUser($name, $email, $username, $password, $userType)
    {
        $sql = "INSERT INTO user(userName, userEmail, userUid, userPassword,userType) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
        $stmt->execute([$name, $email, $username, $hashedPwd, $userType]);
    }

    public function emptyInputsLogin($username, $password)
    {
        return empty($username) || empty($password);
    }

    public function loginUser($username, $password)
    {
        $uidExists = $this->uidExists($username, $username);
        if ($uidExists === false) {
            header("Location:../Project1/user_signin2.php?error=wronglogin"); //Location:../Signup.php?error=wronglogin
            exit();
        }

        $pwdHashed = $uidExists["userPassword"];
        $checkPassword = password_verify($password, $pwdHashed);

        if ($checkPassword === false) {
            header('Location:../Project1/login_User.php?error=WorngLogin');
            exit();
        } else if ($checkPassword === true) {
            session_start();
            $_SESSION["userid"] = $uidExists["userId"];
            $userId =$_SESSION["userid"];
            $_SESSION["useruid"] = $uidExists["userUid"];
            $_SESSION["username"] = $uidExists["userEmail"];
            // $_SESSION[$username];
            header("Location:/Project1/Afterindex.php?email=$username&userId=$userId");
            exit();
        }
    }

    public function loginAdmin($username, $password)
    {
        $uidExists = $this->uidExists($username, $username);
        if ($uidExists === false) {
            header("Location:../Project1/user_signin2.php?error=wronglogin"); //Location:../Signup.php?error=wronglogin
            exit();
        }

        $pwdHashed = $uidExists["userPassword"];
        $checkPassword = password_verify($password, $pwdHashed);

        if ($checkPassword === false) {
            header('Location:../Project1/login_User.php?error=WorngLogin');
            exit();
        } else if ($checkPassword === true) {
            session_start();

            $_SESSION["userid"] = $uidExists["userId"];
            $_SESSION["useruid"] = $uidExists["userUid"];
            $_SESSION["username"] = $uidExists["userEmail"]; //changed userName to userEmail
            header("location:/New_Admin_Pannel/Admin_conrol.php?email=$username");
            exit();
        }
    }
    public function loginVolunteer($username, $password)
    {
        $uidExists = $this->uidExists($username, $username);
        if ($uidExists === false) {
            header("Location:../Project1/user_signin2.php?error=wronglogin"); //Location:../Signup.php?error=wronglogin
            exit();
        }

        $pwdHashed = $uidExists["userPassword"];
        $checkPassword = password_verify($password, $pwdHashed);

        if ($checkPassword === false) {
            header('Location:../Project1/login_User.php?error=WorngLogin');
            exit();
        } else if ($checkPassword === true) {
            session_start();

            $_SESSION["userid"] = $uidExists["userId"];
            $userId =$_SESSION["userid"];
            $_SESSION["useruid"] = $uidExists["userUid"];
            $_SESSION["username"] = $uidExists["userEmail"]; //changed userName to userEmail
            header("location:../../Volunteer_pannel/volunteerDashboard.php?id=$userId");
            exit();
        }
    }
}
