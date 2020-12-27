<?php
session_start();
require_once "controller/NewFeederController.php";
require_once "controller/MenuController.php";
require_once "model/Authorization.php";
Authorization::availableForMechanic();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$menuController = new MenuController();
$newFeederController = new NewFeederController();

$title = 'New Feeder';
$menu = $menuController->chooseMenuByRole($_SESSION['roleName']);

if(isset($_POST['serialNo'])) {
    $content = $newFeederController->addNewFeeder($_POST, $_SESSION['username']);
} else {
    $content = $newFeederController->createNewFeederForm("");
}

include 'template.php';
