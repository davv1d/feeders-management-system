<?php
session_start();

require_once "controller/MenuController.php";
require_once "controller/GeneralStatsController.php";
require_once "model/Authorization.php";

Authorization::availableForMechanicAndManager();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$menuController = new MenuController();
$feederStatsController = new GeneralStatsController();
$title = 'General Feeder Stats';
$menu = $menuController->chooseMenuByRole($_SESSION['roleName']);


if(isset($_POST['size'])) {
    $content = $feederStatsController->createFeederStatsContent($_POST['size'], $_POST['mechanism']);
} else {
    $content = $feederStatsController->createFeederStatsContent("%", '%');
}

include 'template.php';
