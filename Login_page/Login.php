<?php
include_once 'Header.php';
?>


<div class="form">

    <h1>Registration form</h1>
    <form action="includes/Login.php" method="post">

        <input type="text" id="fname" name="username" placeholder="Email">
        <input type="password" id="lname" name="Password" placeholder="password">
        <select id="country" name="country">
            <option value="australia">Australia</option>
            <option value="canada">Canada</option>
            <option value="usa">USA</option>
        </select>

        <button name="submit" type="submit">Login</button>

    </form>


    <?php
    if (isset($_GET["error"])) {
        if ($_GET["error"] == "emptyInput") {
            echo '<div class="error">All the feilds must be fill!</div>';
        } else if ($_GET["error"] == "wronglogin") {
            echo '<div class="error">Incorrect password!</div>';
        } else if ($_GET["error"] == "invalidEmail") {
            echo '<div class="error">Invalid Email!</div>';
        }
        //  else if ($_GET["error"] == "pwdMatch") {
        //     echo '<div class="error">Invalid Password!</div>';
        // } 
        else if ($_GET["error"] == "stmt") {
            echo '<div class="error">Something went wrong!</div>';
        }
    }

    ?>

    <p>New user ?<a href="Signup.php"> Register here..</a></p>

</div>







<?php

include_once 'Footer.php';
?>