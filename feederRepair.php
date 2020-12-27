<?php
session_start();
require_once "controller/FeederRepairController.php";
require_once "controller/MenuController.php";
require_once "model/Authorization.php";
Authorization::availableForMechanic();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$menuController = new MenuController();
$feederRepairController = new FeederRepairController();

$title = 'Feeder repair';
$menu = $menuController->chooseMenuByRole($_SESSION['roleName']);

if(isset($_POST['serialNo'])) {
    var_dump($_POST);
    $content = $feederRepairController->addRepairedFeeder($_POST, $_SESSION['username']);
} else {
    $content = $feederRepairController->createFeederRepairForm("");
}

include 'template.php';
