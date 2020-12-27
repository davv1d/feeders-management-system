<?php

require_once "Database.php";

class FeederTypeModel
{
    private $db;

    public function __construct()
    {
        $data = new Database();
        $this->db = $data->getConnection();
    }

    function getFeedersSizeTypes()
    {
        $sizeQuery = $this->db->prepare('select * from sizes');
        $sizeQuery->execute();
        return $sizeQuery->fetchAll();
    }

    function getFeedersMechanismTypes()
    {
        $mechanismsQuery = $this->db->prepare('select * from mechanisms');
        $mechanismsQuery->execute();
        return $mechanismsQuery->fetchAll();
    }
}