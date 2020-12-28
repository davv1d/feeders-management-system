<?php
require_once "model/FeederModel.php";

class FeederRepairController
{

    private $feederModel;

    public function __construct()
    {
        $this->feederModel = new FeederModel();
    }


    function addRepairedFeeder($request, $username)
    {
        $serialNo = $request["serialNo"];
        $state = $request["state"];
        $repairDesc = ($request['repairDesc'] == "") ? null : $request['repairDesc'];
        $repairedFeederResponse = $this->feederModel->addRepairedFeeder($serialNo, $repairDesc, $state, $username);
        return self::createFeederRepairForm($repairedFeederResponse);
    }


    function createFeederRepairForm($response)
    {
        return "
                <div class='modify_form_wrapper'>
                    <div class='title'>Feeder Repair</div>
                    <form method='post' action=''>
                        <div class='input_field'>
                            <label class='label'>Serial number</label>        
                            <input type='text' name='serialNo' class='input'>
                        </div>
                        <div class='input_field'>
                            <label class='label'>Status</label>        
                            <div class='select_wrapper'>
                                <select name='state'>
                                    <option value='OK'>OK</option>
                                    <option value='NG'>NG</option>
                                </select>
                            </div>
                        </div>
                        <div class='input_field'>
                            <label class='label'>Description</label>
                            <textarea name='repairDesc' class='textarea'></textarea>
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