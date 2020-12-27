<?php

require_once "entities/FeederEntity.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "Database.php";
require_once "DamageModel.php";
require_once "entities/Status.php";
require_once "FeederLogsModel.php";
require_once "FeederLogsMapper.php";

class FeederModel
{

    private $db;
    private $damageModel;
    private $feederLogsModel;
    private $feederLogsMapper;

    public function __construct()
    {
        $data = new Database();
        $this->db = $data->getConnection();
        $this->damageModel = new DamageModel();
        $this->feederLogsModel = new FeederLogsModel();
        $this->feederLogsMapper = new FeederLogsMapper();
    }


    function addRepairedFeeder($serialNo, $repairDesc, $state, $username)
    {
        $feederBySerialNo = $this->getFeederBySerialNo($serialNo);
        if ($feederBySerialNo) {
            $feederBySerialNo->setState($state);
            $feederLogsEntity = $this->feederLogsMapper->mapToRepairFeederLogs($feederBySerialNo, $repairDesc, $username);
            $changeFeederStatus = $this->changeFeederStatus($feederBySerialNo->getId(), $feederBySerialNo->getState());
            $log = $this->feederLogsModel->saveLog($feederLogsEntity);
            if ($changeFeederStatus && $log) {
                return ["error" => false, "info" => "Change state feeder by serial no " . $feederBySerialNo->getSerialNo()];
            } else {
                return ["error" => true, "info" => "Feeder not added"];
            }
        } else {
            return ["error" => true, "info" => "feeder not found"];
        }
    }


    function addNewFeeder(FeederEntity $feederEntity, $username)
    {
        $feederBySerialNo = $this->getFeederBySerialNo($feederEntity->getSerialNo());
        if (!$feederBySerialNo) {
            $isSaved = self::saveFeeder($feederEntity);
            if ($isSaved) {
                $feederEntity = self::getFeederBySerialNo($feederEntity->getSerialNo());
                $newFeederLogsEntity = $this->feederLogsMapper->mapToNewFeederLogs($feederEntity, $username);
                $feederLog = $this->feederLogsModel->saveLog($newFeederLogsEntity);
                if ($feederLog) {
                    return ["error" => false, "info" => "Added Feeder By Serial No: " . $feederEntity->getSerialNo()];
                } else {
                    return ["error" => true, "info" => "Feeder Log Not Added"];
                }
            } else {
                return ["error" => true, "info" => "Feeder does not save"];
            }
        } else {
            return ["error" => true, "info" => "feeder exists"];
        }
    }


    function addDamagedFeeder($serialNo, $damageCode, $username)
    {
        $feederBySerialNo = $this->getFeederBySerialNo($serialNo);
        $damageByBarcodeNumber = $this->damageModel->getDamageByBarcodeNumber($damageCode);
        if ($feederBySerialNo) {
            if ($damageByBarcodeNumber) {
                $feederLogsEntity = $this->feederLogsMapper->mapToDamageFeederLogs($feederBySerialNo, $damageByBarcodeNumber, $username);
                $changeFeederStatus = $this->changeFeederStatus($feederBySerialNo->getId(), Status::DAMAGE);
                $log = $this->feederLogsModel->saveLog($feederLogsEntity);
                if ($changeFeederStatus && $log) {
                    return ["error" => false, "info" => "Added feeder by serial no " . $feederBySerialNo->getSerialNo()];
                } else {
                    return ["error" => true, "info" => "Feeder not added"];
                }
            } else {
                return ["error" => true, "info" => "Damage code not found"];
            }
        } else {
            return ["error" => true, "info" => "feeder not found"];
        }
    }


    function getFeederBySerialNo($serialNo)
    {
        $feederQuery = $this->db->prepare('select * from feeders where serialNo = :serialNo');
        $feederQuery->bindValue(':serialNo', $serialNo, PDO::PARAM_STR);
        $feederQuery->execute();
        $row = $feederQuery->fetch();

        if ($row) {
            return new FeederEntity($row["feederId"], $row["serialNo"], $row["mechanismId"], $row["sizeId"], $row["state"]);
        }
        return $row;
    }

    function changeFeederStatus($feederId, $status)
    {
//        $this->db->beginTransaction();
        $query = $this->db->prepare('update feeders set state = :status WHERE feederId = :feederId;');
        $query->bindValue(":feederId", $feederId, PDO::PARAM_INT);
        $query->bindValue(":status", $status, PDO::PARAM_STR);
        $execute = $query->execute();
//        $this->db->commit();
        return $execute;
    }

    function saveFeeder(FeederEntity $feederEntity)
    {
        $feederQuery = $this->db->prepare('insert into feeders values (
                                 null, 
                                 :serialNo,
                                 :stateName,
                                 :sizeId,
                                 :mechanismId)');
        $feederQuery->bindValue(":serialNo", $feederEntity->getSerialNo());
        $feederQuery->bindValue(":stateName", $feederEntity->getState());
        $feederQuery->bindValue(":sizeId", $feederEntity->getSizeType());
        $feederQuery->bindValue(":mechanismId", $feederEntity->getMechanismType());
        return $feederQuery->execute();
    }

//SELECT mechanismName, sizeName,
//COUNT(case feeders.state when 'OK' then 1 else null end) as ok,
//COUNT(case feeders.state when 'DAMAGE' then 1 else null end) as damage,
//COUNT(case feeders.state when 'NG' then 1 else null end) as ng,
//COUNT(*) as aaa
//FROM ((feeders INNER join mechanisms on feeders.mechanismId = mechanisms.mechanismId)
//INNER JOIN sizes on feeders.sizeId = sizes.sizeId)
//GROUP by feeders.mechanismId, feeders.sizeId



    function fetchFeedersStats($size, $mechanism)
    {
        $statsQuery = $this->db->prepare('
            SELECT mechanismName, sizeName, 
                COUNT(case feeders.state when "OK" then 1 else null end) as ok, 
                COUNT(case feeders.state when "DAMAGE" then 1 else null end) as damage, 
                COUNT(case feeders.state when "NG" then 1 else null end) as ng, 
                COUNT(*) as allFeeder 
            FROM ((feeders 
                INNER join mechanisms on feeders.mechanismId = mechanisms.mechanismId) 
                INNER JOIN sizes on feeders.sizeId = sizes.sizeId) 
            WHERE feeders.sizeId LIKE :sizeId
                AND feeders.mechanismId LIKE :mechanismId 
            GROUP by feeders.mechanismId, feeders.sizeId');
        $statsQuery->bindValue(":sizeId", $size);
        $statsQuery->bindValue(":mechanismId", $mechanism);
        $statsQuery->execute();
        return $statsQuery->fetchAll();
    }
//
//    function fetchAllFeedersStatse($state, $size, $mechanism)
//    {
//        $statsQuery = $this->db->prepare('SELECT state, mechanismName, sizeName, COUNT(state) as count
//                                  FROM ((feeders
//                                  INNER join mechanisms on feeders.mechanismId = mechanisms.mechanismId)
//                                  INNER JOIN sizes on feeders.sizeId = sizes.sizeId)
//                                  WHERE state LIKE :state
//                                      AND feeders.sizeId LIKE :sizeId
//                                      AND feeders.mechanismId LIKE :mechanismId
//                                        GROUP by state, feeders.mechanismId, feeders.sizeId');
//        $statsQuery->bindValue(":state", $state);
//        $statsQuery->bindValue(":sizeId", $size);
//        $statsQuery->bindValue(":mechanismId", $mechanism);
//        $statsQuery->execute();
//        return $statsQuery->fetchAll();
//    }
}

?>