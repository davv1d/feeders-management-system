<?php


class FeederLogsEntity
{
    private $feedersLogsId;
    private $date;
    private $feederId;
    private $serialNo;
    private $stateName;
    private $damageName;
    private $repairDesc;
    private $username;
    private $actionType;

    /**
     * FeederLogsEntity constructor.
     * @param $feedersLogsId
     * @param $date
     * @param $feederId
     * @param $serialNo
     * @param $stateName
     * @param $damageName
     * @param $repairDesc
     * @param $username
     * @param $actionType
     */
    public function __construct($feedersLogsId, $date, $feederId, $serialNo, $stateName, $damageName, $repairDesc, $username, $actionType)
    {
        $this->feedersLogsId = $feedersLogsId;
        $this->date = $date;
        $this->feederId = $feederId;
        $this->serialNo = $serialNo;
        $this->stateName = $stateName;
        $this->damageName = $damageName;
        $this->repairDesc = $repairDesc;
        $this->username = $username;
        $this->actionType = $actionType;
    }

    /**
     * @return mixed
     */
    public function getFeedersLogsId()
    {
        return $this->feedersLogsId;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return mixed
     */
    public function getFeederId()
    {
        return $this->feederId;
    }

    /**
     * @return mixed
     */
    public function getSerialNo()
    {
        return $this->serialNo;
    }

    /**
     * @return mixed
     */
    public function getStateName()
    {
        return $this->stateName;
    }

    /**
     * @return mixed
     */
    public function getDamageName()
    {
        return $this->damageName;
    }

    /**
     * @return mixed
     */
    public function getRepairDesc()
    {
        return $this->repairDesc;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getActionType()
    {
        return $this->actionType;
    }
}