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
                    <div class='modify_form_title'>Feeder Repair</div>
                    <form method='post' action=''>
                        <div class='modify_input_field'>
                            <label class='modify_label'>Serial number</label>        
                            <input type='text' name='serialNo' class='modify_input'>
                        </div>
                        <div class='modify_input_field'>
                            <label class='modify_label'>Status</label>        
                            <div class='modify_select_wrapper'>
                                <select name='state' class='modify_select'>
                                    <option value='OK'>OK</option>
                                    <option value='NG'>NG</option>
                                </select>
                            </div>
                        </div>
                        <div class='modify_input_field'>
                            <label class='modify_label'>Description</label>
                            <textarea name='repairDesc' class='modify_textarea'></textarea>
                        </div>
                        <div class='modify_input_field'>
                            <input type='submit' value='OK' class='modify_btn'>
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