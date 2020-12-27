<?php

require_once "model/FeederTypeModel.php";
require_once "model/FeederModel.php";
require_once "entities/FeederEntity.php";
class NewFeederController
{
    private $feederTypeModel;
    private $feederModel;

    public function __construct()
    {
        $this->feederTypeModel = new FeederTypeModel();
        $this->feederModel = new FeederModel();
    }


    function addNewFeeder($request, $username) {
        $feederEntity = new FeederEntity(null, $request["serialNo"], $request["mechanism"], $request["size"], $request["state"]);
        $addNewFeederResponse = $this->feederModel->addNewFeeder($feederEntity, $username);
        return self::createNewFeederForm($addNewFeederResponse);
    }



    function createNewFeederForm($response)
    {
        return "
                <div class='form'>
                    <div class='title'>New Feeder</div>
                    <form method='post' action=''>
                        <div class='input_field'>
                            <label>Serial number</label>        
                            <input type='text' name='serialNo' class='input'>
                        </div>
                        <div class='input_field'>
                            <label>Status</label>        
                            <div class='custom_select'>
                                <select name='state' class='select'>
                                    <option value='OK'>OK</option>
                                    <option value='NG'>NG</option>
                                </select>
                            </div>
                        </div>
                        <div class='input_field'>
                            <label>Size</label>        
                            <div class='custom_select'>
                                <select name='size' class='select'>
                                    ".$this->createSizeTypeOptionValue($this->feederTypeModel->getFeedersSizeTypes())."
                                </select>
                            </div>
                        </div>
                        <div class='input_field'>
                            <label>Mechanism</label>        
                            <div class='custom_select'>
                                <select name='mechanism' class='select'>
                                    ".$this->createMechanismTypeOptionValue($this->feederTypeModel->getFeedersMechanismTypes())."
                                </select>
                            </div>
                        </div>
                        <div class='input_field'>
                            <input type='submit' value='OK' class='btn'>
                        </div>
                    </form>
                    ".self::createResponseDiv($response)."
                </div>";
    }

    function createSizeTypeOptionValue(array $sizesValues)
    {
        $result = "";
        foreach ($sizesValues as $value) {
            $result = $result . "<option value=" . $value['sizeId'] . ">" . $value['sizeName'] . "</option>";
        }
        return $result;
    }

    function createMechanismTypeOptionValue(array $mechanismsValues)
    {
        $result = "";
        foreach ($mechanismsValues as $value) {
            $result = $result . "<option value=" . $value['mechanismId'] . ">" . $value['mechanismName'] . "</option>";
        }
        return $result;
    }

    function createResponseDiv($response)
    {
        if (!$response) {
            return "<div></div>";
        } else if ($response['error']) {
            return "<div class='error'>" . $response['info'] . "</div>";
        } else {
            return "<div class='success'>" . $response['info'] . "</div>";
        }
    }
}