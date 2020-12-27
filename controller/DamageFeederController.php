<?php
require_once "model/FeederModel.php";

class DamageFeederController
{
    private $feederModel;

    public function __construct()
    {
        $this->feederModel = new FeederModel();
    }

    function addDamageFeeder($serialNo, $damageCode, $username)
    {
        $response = $this->feederModel->addDamagedFeeder($serialNo, $damageCode, $username);
        return $this->createDamageForm($response);
    }

    function createDamageForm($response)
    {
        return "<div class='form'>
                    <div class='title'>Damage Feeder</div>
                    <form method='post' action=''>
                        <div class='input_field'>
                            <label>Serial number</label>        
                            <input type='text' name='serialNo' class='input'>
                        </div>
                        <div class='input_field'>
                            <label>Damage code</label>        
                            <input type='text' name='damageCode' class='input'>
                        </div>
                        <div class='input_field'>
                            <input type='submit' value='OK' class='btn'>
                        </div>
                    </form>
                    " . self::createResponseDiv($response) . "
                </div>";
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

?>