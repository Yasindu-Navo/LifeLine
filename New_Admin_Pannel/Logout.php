<?php
session_start();
session_unset();
session_destroy();
header("Location:../Project1/index.php"); //change index.php to Login.php
exit();
