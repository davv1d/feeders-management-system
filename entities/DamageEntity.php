<?php


class DamageEntity
{
    private $damageId;
    private $damageName;
    private $barcodeNumber;

    /**
     * DamageEntity constructor.
     * @param $damageId
     * @param $damageName
     * @param $barcodeNumber
     */
    public function __construct($damageId, $damageName, $barcodeNumber)
    {
        $this->damageId = $damageId;
        $this->damageName = $damageName;
        $this->barcodeNumber = $barcodeNumber;
    }

    /**
     * @return mixed
     */
    public function getDamageId()
    {
        return $this->damageId;
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
    public function getBarcodeNumber()
    {
        return $this->barcodeNumber;
    }


}