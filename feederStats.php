<?php
session_start();

require_once "controller/MenuController.php";
require_once "controller/FeederStatsController.php";
require_once "model/Authorization.php";
require_once "model/FeederModel.php";
Authorization::availableForMechanicAndManager();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$feederModel = new FeederModel();
$menuController = new MenuController();
$feederStatsController = new FeederStatsController();
$title = 'Feeder Stats';
$menu = $menuController->chooseMenuByRole($_SESSION['roleName']);


if(isset($_POST['size'])) {
    $content = $feederStatsController->createFeederStatsContent($_POST['size'], $_POST['mechanism']);
} else {
    $content = $feederStatsController->createFeederStatsContent("%", '%');
}

include 'template.php';
