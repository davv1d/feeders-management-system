<?php
session_start();

require_once "controller/DamageFeederController.php";
require_once "controller/MenuController.php";
require_once "model/FeederModel.php";
require_once "entities/Status.php";
require_once "model/Authorization.php";
Authorization::availableForMechanicAndOperator();

date_default_timezone_set('Europe/Berlin');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$feederModel = new FeederModel();
$feederController = new DamageFeederController();
$menuController = new MenuController();

$title = 'Damage Feeder';
$menu = $menuController->chooseMenuByRole($_SESSION['roleName']);

if(isset($_POST['serialNo']) && isset($_POST['damageCode'])) {
    $serialNo = $_POST['serialNo'];
    $damageCode = $_POST['damageCode'];
    $content = $feederController->addDamageFeeder($serialNo, $damageCode, $_SESSION['username']);
} else {
    $content = $feederController->createDamageForm("");
}


include 'template.php';
