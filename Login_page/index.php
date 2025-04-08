<?php
include_once 'Header.php';

?>

<h1>Hello <?php

            //To show username in window
            if (isset($_SESSION["username"])) {
                echo $_SESSION["username"];
            } else {
                echo "user!!";
            }

            ?></h1>



<?php
include_once 'Footer.php';
?>