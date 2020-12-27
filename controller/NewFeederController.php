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
                <div class='modify_form_wrapper'>
                    <div class='modify_form_title'>New Feeder</div>
                    <form method='post' action=''>
                        <div class='modify_input_field'>
                            <label class='modify_label'>Serial number</label>        
                            <input type='text' name='serialNo' class='modify_input'>
                        </div>
                        <div class='modify_input_field'>
                            <label class='modify_label'>State</label>        
                            <div class='modify_select_wrapper'>
                                <select name='state' class='modify_select'>
                                    <option value='OK'>OK</option>
                                    <option value='NG'>NG</option>
                                </select>
                            </div>
                        </div>
                        <div class='modify_input_field'>
                            <label class='modify_label'>Size</label>        
                            <div class='modify_select_wrapper'>
                                <select name='size' class='modify_select'>
                                    ".$this->createSizeTypeOptionValue($this->feederTypeModel->getFeedersSizeTypes())."
                                </select>
                            </div>
                        </div>
                        <div class='modify_input_field'>
                            <label class='modify_label'>Mechanism</label>        
                            <div class='modify_select_wrapper'>
                                <select name='mechanism' class='modify_select'>
                                    ".$this->createMechanismTypeOptionValue($this->feederTypeModel->getFeedersMechanismTypes())."
                                </select>
                            </div>
                        </div>
                        <div class='modify_input_field'>
                            <input type='submit' value='OK' class='modify_btn'>
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