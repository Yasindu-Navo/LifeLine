<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        * {
            margin: 0;
        }

        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #333;
        }

        li {
            float: left;
        }

        li a {
            display: inline-block;
            color: white;
            text-align: center;
            padding: 10px 10px;
            text-decoration: none;
        }

        li a:hover:not(.active) {
            background-color: #111;
        }

        .active {
            background-color: #04AA6D;
        }



        /* css for form */

        input[type=text],
        input[type=password],
        select {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            width: 25%;
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 20px;
        }

        button:hover {
            background-color: #45a049;
        }

        .form {
            width: 70%;
            margin-left: auto;
            margin-right: auto;
            text-align: center;
            /*form did not centerd cheak again -done */

        }

        .error {

            color: red;
            padding: 12px;
            border: 1px solid red;
            font-size: 22px;
            margin-bottom: 10px;
            margin-top: 10px;

        }
    </style>
</head>

<body>


    <ul>
        <li><a class="active" href="index.php">Home</a></li>
        <li><a href="news">News</a></li>
        <li><a href="contact">Contact</a></li>

        <!-- <li style="float:right"><a class="active" href="Login.php"> -->
        <!-- <li style="float:right"> moving in to echo msg -->
        <?php

        //To show username in btn
        if (isset($_SESSION["username"])) {
            echo '<li style="float:right"><a href ="#">' /*css*/ . $_SESSION["username"] . '</a></li>'; /*yet delcare href to ditec the page*/
            echo '<li style="float:right"><a href ="includes/Logout.php"> Logout <a/></li>';
        } else {
            echo '<li style="float:right"><a class="active" href="Login.php">Login</a></li>';
        }

        ?>
        </li>
    </ul>
    <div class="container" style="margin:20px">