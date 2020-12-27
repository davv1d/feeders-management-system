<?php
session_start();

require_once "controller/MenuController.php";
require_once "model/Authorization.php";
require_once "model/FeederModel.php";
require_once "controller/SpecifisStatsController.php";

Authorization::availableForMechanicAndManager();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$feederModel = new FeederModel();
$menuController = new MenuController();
$specifisStatsController = new SpecifisStatsController();
$title = 'Specific Feeder Stats';
$menu = $menuController->chooseMenuByRole($_SESSION['roleName']);



if(isset($_POST['size'])) {
    $content = $specifisStatsController->createContent($_POST['serialNo'], $_POST['state'], $_POST['size'], $_POST['mechanism']);
} else {
    $content = $specifisStatsController->createContent('%', '%', '%', '%');
}

include 'template.php';
