<?php

require_once "model/FeederTypeModel.php";
require_once "model/FeederModel.php";

class SpecifisStatsController
{
    private $ok = 0;
    private $damage = 0;
    private $ng = 0;
    private $all = 0;
    private $feederTypeModel;
    private $feederModel;

    public function __construct()
    {
        $this->feederTypeModel = new FeederTypeModel();
        $this->feederModel = new FeederModel();
    }

    function createContent($serialNo, $state, $size, $mechanism)
    {
        $specificFeedersStats = $this->feederModel->fetchSpecificFeedersStats($serialNo, $state, $size, $mechanism);
        $table = self::createTable($specificFeedersStats);
        return self::createSpecificStatsForm($table);
    }

    function createSpecificStatsForm($table)
    {
        return "
                <div class='specific_search'>
                    <div class='specific_search_menu'>
                        <form method='post' action=''>
                            <div class='specific_search_input_field'>      
                                <input type='text' name='serialNo' class='specific_search_input' placeholder='SERIAL NO'>
                            </div>
                            <div class='specific_search_input_field'>
                                <label class='specific_search_label'>State</label>        
                                    <div class='specific_search_select_wrapper'>
                                        <select name='state' class='specific_search_select'>
                                            <option value='%'>ALL</option>
                                            <option value='OK'>OK</option>
                                            <option value='DAMAGE'>DAMAGE</option>
                                            <option value='NG'>NG</option>
                                        </select>
                                    </div>
                                </div>
                            <div class='specific_search_input_field'>
                                <label class='specific_search_label'>Size</label>
                                <div class='specific_search_select_wrapper'>
                                    <select name='size' class='specific_search_select'>
                                        <option value='%'>ALL</option>
                                        " . $this->createSizeTypeOptionValue($this->feederTypeModel->getFeedersSizeTypes()) . "
                                    </select>
                                </div>
                            </div>
                            <div class='specific_search_input_field'>
                                <label class='specific_search_label'>Mechanism</label>
                                <div class='specific_search_select_wrapper'>
                                    <select name='mechanism' class='specific_search_select'>
                                        <option value='%'>ALL</option>
                                        " . $this->createMechanismTypeOptionValue($this->feederTypeModel->getFeedersMechanismTypes()) . "
                                    </select>
                                </div>
                            </div>
                            <div class='specific_search_input_field'>
                                <input type='submit' value='SEARCH' class='btn_search'>
                            </div>
                            <div style='clear: both'></div>
                        </form>
                    </div>
                    <div class='specific_search_table_wrapper'>" . $table . "</div>
                    <div class='specific_search_table_resume_wrapper'>".self::createTable2()."</div>
                </div>";
    }

    function createTable($feedersStats)
    {

        $result = "<table class='stats_table'>
                    <tr class='table_header_row'>
                        <th class='search_table_header_serialNo'>SERIAL NO</th>
                        <th class='search_table_header_mechanism'>MECHANISM</th>
                        <th class='search_table_header_size'>SIZE</th>
                        <th class='search_table_header_state'>STATE</th>
                    </tr>";
        foreach ($feedersStats as $feedersStat) {
            $this->countState($feedersStat['state']);
            $result = $result . "
                    <tr class='table_row'>
                        <td>" . $feedersStat['serialNo'] . "</td>
                        <td>" . $feedersStat['mechanismName'] . "</td>
                        <td>" . $feedersStat['sizeName'] . "</td>
                        <td>" . $feedersStat['state'] . "</td>
                    </tr>";
        }
        return $result . "</table>";
    }


    function countState($state) {
        if ($state == Status::OK) {
            $this->ok++;
        } elseif ($state == Status::DAMAGE) {
            $this->damage++;
        } elseif ($state == Status::NG) {
            $this->ng++;
        }
        $this->all++;
    }



    function createTable2()
    {
        return "<table>
                    <tr class='table_header_row'>
                        <th id='test' colspan='2'></th>
                        <th>OK</th>
                        <th>DAMAGE</th>
                        <th>NG</th>
                        <th>ALL</th>
                    </tr>
                    <tr class='table_total'>
                        <td colspan='2'>Total Amount</td>
                        <td class='numbers'>".$this->ok."</td>
                        <td class='numbers'>".$this->damage."</td>
                        <td class='numbers'>".$this->ng."</td>                        
                        <td class='numbers'>".$this->all."</td>  
                    </tr>" .
            "</table>";

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

}