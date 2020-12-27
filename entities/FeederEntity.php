<?php

class FeederEntity
{
    private $id;
    private $serialNo;
    private $mechanismType;
    private $sizeType;
    private $state;

    /**
     * FeederEntity constructor.
     * @param $id
     * @param $serialNo
     * @param $mechanismType
     * @param $sizeType
     * @param $state
     */
    public function __construct($id, $serialNo, $mechanismType, $sizeType, $state)
    {
        $this->id = $id;
        $this->serialNo = $serialNo;
        $this->mechanismType = $mechanismType;
        $this->sizeType = $sizeType;
        $this->state = $state;
    }





    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getSerialNo()
    {
        return $this->serialNo;
    }

    /**
     * @param mixed $serialNo
     */
    public function setSerialNo($serialNo)
    {
        $this->serialNo = $serialNo;
    }

    /**
     * @return mixed
     */
    public function getMechanismType()
    {
        return $this->mechanismType;
    }

    /**
     * @param mixed $mechanismType
     */
    public function setMechanismType($mechanismType)
    {
        $this->mechanismType = $mechanismType;
    }

    /**
     * @return mixed
     */
    public function getSizeType()
    {
        return $this->sizeType;
    }

    /**
     * @param mixed $sizeType
     */
    public function setSizeType($sizeType)
    {
        $this->sizeType = $sizeType;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }



}