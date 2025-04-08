<?php
include_once 'Header.php';

?>

<div class="form">

    <h1>Registration form</h1>
    <form action="includes/Signup.php" method="post">



        <!-- <label for="fname">First Name</label> -->
        <input type="text" id="fname" name="name" placeholder="Name">
        <input type="text" id="lname" name="username" placeholder="Username">
        <input type="text" id="lname" name="email" placeholder="Email">
        <input type="password" id="lname" name="Password" placeholder="Password">
        <input type="password" id="lname" name="rePassword" placeholder="Re-enter password ">
        <input type="hidden" name="usertype" value="User">


        <!-- <label for="country">Country</label> -->

        <select id="country" name="country">
            <option value="australia">Australia</option>
            <option value="canada">Canada</option>
            <option value="usa">USA</option>
        </select>

        <button name="SignUp" type="submit">Register</button>

    </form>
    <?php
    if (isset($_GET["error"])) {
        if ($_GET["error"] == "emptyInput") {
            echo '<div class="error">All the feilds must be fill!</div>';
        } else if ($_GET["error"] ==  "invalidUid") {
            echo '<div class="error">Invalid username!</div>';
        } else if ($_GET["error"] == "invalidEmail") {
            echo '<div class="error">Invalid Email!</div>';
        } else if ($_GET["error"] == "pwdMatch") {
            echo '<div class="error">Invalid Password!</div>';
        } else if ($_GET["error"] == "stmt") {
            echo '<div class="error">Something went wrong!</div>';
        } else if ($_GET["error"] == "none") {
            echo '<div class="error">Account created successfully!</div>';
        } else if ($_GET["error"] == "uidExists") {
            echo '<div class="error">User already signin!</div>';
        }
    }

    ?>


    <p>Already have an account ?<a href="Login.php"> Login here..</a></p>

</div>







<?php

include_once 'Footer.php';
?>