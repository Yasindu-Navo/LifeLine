<?php
require './dbConnector.php';

session_start();

if(isset($_SESSION['uname'])){
    header("location:index.php");
    exit();
}else{
?>

<html>
    <head>
        <title>title</title>
    </head>
    <body>
        <h3>Volunteer Login</h3><br>  
        <form action="loginProcess.php" method="POST">
            Username: <input type="text" name="uname"><br>
            password: <input type="password" name="pwd"><br>
            <input type="submit" name="btnSubmit">
            <input type="reset" name="btnreset">
        </form>
    </body>
</html>

<?php
}
?>

