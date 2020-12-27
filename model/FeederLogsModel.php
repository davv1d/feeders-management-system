<?php


class FeederLogsModel
{
    private $db;

    public function __construct()
    {
        $data = new Database();
        $this->db = $data->getConnection();
    }

    function saveLog(FeederLogsEntity $feederLogsEntity) {
        $feederLogsQuery = $this->db->prepare('insert into feeders_logs values (
                                 null, 
                                 :currentDate,
                                 :feederId,
                                 :serialNo,
                                 :stateName,
                                 :damageName,
                                 :repairDesc,
                                 :username,
                                 :actionType)');
        $feederLogsQuery->bindValue(':currentDate', $feederLogsEntity->getDate(), PDO::PARAM_STR);
        $feederLogsQuery->bindValue(':feederId', $feederLogsEntity->getFeederId(), PDO::PARAM_STR);
        $feederLogsQuery->bindValue(':serialNo', $feederLogsEntity->getSerialNo(), PDO::PARAM_STR);
        $feederLogsQuery->bindValue(':stateName', $feederLogsEntity->getStateName(), PDO::PARAM_STR);
        $feederLogsQuery->bindValue(':damageName', $feederLogsEntity->getDamageName(), PDO::PARAM_STR);
        $feederLogsQuery->bindValue(':repairDesc', $feederLogsEntity->getRepairDesc(), PDO::PARAM_STR);
        $feederLogsQuery->bindValue(':username', $feederLogsEntity->getUsername(), PDO::PARAM_STR);
        $feederLogsQuery->bindValue(':actionType', $feederLogsEntity->getActionType(), PDO::PARAM_STR);
        return $feederLogsQuery->execute();
    }
}