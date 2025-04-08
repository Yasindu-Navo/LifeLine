<?php
session_start();
session_unset();
session_destroy();
header("Location:../Login.php"); //change index.php to Login.php
exit();
