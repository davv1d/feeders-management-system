<?php
session_start();

require_once "./model/Database.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$username = $_POST["username"];
$password = $_POST["password"];

$username = htmlentities($username, ENT_QUOTES, "UTF-8");
$password = htmlentities($password, ENT_QUOTES, "UTF-8");

$database = new Database();
$pdo = $database->getConnection();
$userQuery = $pdo->prepare("SELECT * FROM users as u INNER JOIN roles as r
					 ON u.roleId = r.roleId 
                     where u.username = :username AND u.password = :password");

$userQuery->bindValue(":username", $username);
$userQuery->bindValue(":password", $password);
$userQuery->execute();
$user = $userQuery->fetch();
if ($user) {
    $_SESSION['logged'] = true;
    $_SESSION['roleName'] = $user['roleName'];
    $_SESSION['userId'] = $user['userId'];
    $_SESSION['username'] = $user['username'];
    unset($_SESSION['login_error']);
    header("Location: users.php");
} else {
    $_SESSION['login_error'] = '<span style="color:red">Incorrect name or password!</span>';
    $error = '<span style="color:red">Incorrect name or password!</span>';
    header("Location: index.php");
}

//include "index.php";