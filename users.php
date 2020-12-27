<?php
session_start();

require_once "controller/MenuController.php";
require_once "model/Authorization.php";
Authorization::availableForAuthenticated();

date_default_timezone_set('Europe/Berlin');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$menuController = new MenuController();

$title = $_SESSION['roleName'];

$menu = $menuController->chooseMenuByRole($_SESSION['roleName']);
$content = "<div class='welcome'>Welcome ". $_SESSION['username'] . "</div>";

include 'template.php';
?>