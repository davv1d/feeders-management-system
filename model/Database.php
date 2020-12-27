<?php
require_once "DbConfig.php";
class Database
{
    function getConnection() {
        try {
            $db = new PDO("mysql:host=".DbConfig::host.";port=".DbConfig::port.";dbname=".DbConfig::database.";charset=utf8", DbConfig::user, DbConfig::password,
                [
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]);
            return $db;
        } catch (PDOException $exception) {
            exit("Database error {$exception->getCode()}");
        }
    }
}