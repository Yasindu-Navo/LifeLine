<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <style>
        .form-gap {
            padding-top: 70px;
        }
    </style>

    <title>Document</title>
</head>

<body>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">
                            <h3><i class="fa fa-lock fa-4x"></i></h3>
                            <h2 class="text-center">Change password</h2>
                            <p>You can chnage your password here.</p>

                            <?php
                            session_start();
                            if (isset($_SESSION['status'])) {
                            ?>

                                <h5> <?= $_SESSION['status']; ?></h5>
                            <?php
                                unset($_SESSION['status']);
                            }
                            ?>

                            <div class="panel-body">

                                <form id="register-form" role="form" autocomplete="off" class="form" method="POST" action="password_reset.php">
                                    <input type="hidden" name="token" value="<?php if (isset($_GET['token'])) {
                                                                                    echo $_GET['token'];
                                                                                } ?>">

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                            <input id="email" name="email" placeholder="<?php if (isset($_GET['email'])) {
                                                                                            echo $_GET['email'];
                                                                                        } ?>" class="form-control" type="email">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-unlock"></i></span>
                                            <input id="email" name="new_password" placeholder="New Password" class="form-control" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-unlock"></i></span>
                                            <input name="confirm_password" placeholder="Confirm Password" class="form-control" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input name="update_password" class="btn btn-lg btn-primary btn-block" value="Update_password" type="submit">
                                    </div>



                                    <div class="form-group">
                                        <a href="http://localhost/project1/login_User.php"><input name="update_password" class="btn btn-success" value="Back to Login" type="back"></a>
                                    </div>



                                    <!-- <input type="hidden" class="hide" name="token" id="token" value=""> -->
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



</html>