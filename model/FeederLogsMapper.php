<?php

require_once "entities/FeederEntity.php";
require_once "entities/DamageEntity.php";
require_once "entities/FeederLogsEntity.php";
require_once "entities/Status.php";

class FeederLogsMapper
{
    function mapToDamageFeederLogs(FeederEntity $feederEntity, DamageEntity $damageEntity, $username) {
        return new FeederLogsEntity(
            null,
            date('Y-m-d H:i:s'),
            $feederEntity->getId(),
            $feederEntity->getSerialNo(),
            Status::DAMAGE,
            $damageEntity->getDamageName(),
            null,
            $username,
            "DAMAGE"
        );
    }

    function mapToNewFeederLogs(FeederEntity $feederEntity, $username) {
        return new FeederLogsEntity(
            null,
            date('Y-m-d H:i:s'),
            $feederEntity->getId(),
            $feederEntity->getSerialNo(),
            $feederEntity->getState(),
            null,
            null,
            $username,
            "NEW"
        );
    }

    function mapToRepairFeederLogs(FeederEntity $feederEntity, $repairDesc , $username) {
        return new FeederLogsEntity(
            null,
            date('Y-m-d H:i:s'),
            $feederEntity->getId(),
            $feederEntity->getSerialNo(),
            $feederEntity->getState(),
            null,
            $repairDesc,
            $username,
            "REPAIR"
        );
    }

}