<?php
session_start();
require_once "model/Authorization.php";
Authorization::ifLogged();
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <link href='http://fonts.googleapis.com/css?family=Lato:400,900&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="styles/login.css" type="text/css"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Login form</title>
</head>
<body>
<div id="container">
    <div class="rectangle">Feeders management system</div>
    <div id="content">
        <form action="login.php" method="post">
            <label for="username"></label><input type="text" id="username" name="username" placeholder="username"/>
            <label for="password"></label><input type="password" id="password" name="password" placeholder="password"/>
            <input type="submit" value="Sign in"/>
        </form>
        <div id="error">
            <?php
//                echo $error;
                if (isset($_SESSION['login_error'])) echo $_SESSION['login_error'];
            ?>
        </div>
    </div>
</div>
</body>
</html>