<?php

require_once "Database.php";
require_once "entities/DamageEntity.php";
class DamageModel
{
    private $db;

    public function __construct()
    {
        $data = new Database();
        $this->db = $data->getConnection();
    }

    function getDamageByBarcodeNumber($damageCode) {
        $damageQuery = $this->db->prepare('select * from damages where barcodeNumber = :damageCode');
        $damageQuery->bindValue(':damageCode', $damageCode, PDO::PARAM_STR);
        $damageQuery->execute();
        $row = $damageQuery->fetch();
        if ($row) {
            return new DamageEntity($row["damageId"], $row["damageName"], $row["barcodeNumber"]);
        }
        return $row;
    }
}