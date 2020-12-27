<?php

require_once "model/FeederTypeModel.php";
require_once "model/FeederModel.php";
require_once "entities/FeederEntity.php";

class FeederStatsController
{
    private $feederTypeModel;
    private $feederModel;

    public function __construct()
    {
        $this->feederTypeModel = new FeederTypeModel();
        $this->feederModel = new FeederModel();
    }

    function createFeederStatsContent($size, $mechanism) {
        $table = self::createTable($this->feederModel->fetchFeedersStats($size, $mechanism));
        return $this->createFeederStatsForm($table);
    }


    function createFeederStatsForm($table)
    {
        return "
                <div class='search'>
                    <div class='search_menu'>
                        <form class='test' method='post' action=''>
                            <div class='input_field'>
                                <label>Size</label>
                                <div class='custom_select'>
                                    <select name='size' class='select'>
                                        <option value='%'>ALL</option>
                                        ".$this->createSizeTypeOptionValue($this->feederTypeModel->getFeedersSizeTypes())."
                                    </select>
                                </div>
                            </div>
                            <div class='input_field'>
                                <label>Mechanism</label>
                                <div class='custom_select'>
                                    <select name='mechanism' class='select'>
                                        <option value='%'>ALL</option>
                                        ".$this->createMechanismTypeOptionValue($this->feederTypeModel->getFeedersMechanismTypes())."
                                    </select>
                                </div>
                            </div>
                            <div class='input_field'>
                                <input type='submit' value='SEARCH' class='btn'>
                            </div>
                            <div style='clear: both'></div>
                        </form>
                    </div>
                    <div class='search_result'>".$table."</div>
                </div>";
    }

//
//    function createTable($feedersStats) {
//        $result = "<table class='stats_table'>
//                    <tr class='table_header_row'>
//                        <th>STATE</th>
//                        <th>MECHANISM</th>
//                        <th>SIZE</th>
//                        <th>COUNT</th>
//                    </tr>";
//        foreach ($feedersStats as $feedersStat) {
//            $result = $result . "
//                    <tr class='table_row'>
//                        <td>".$feedersStat['state']."</td>
//                        <td>".$feedersStat['mechanismName']."</td>
//                        <td>".$feedersStat['sizeName']."</td>
//                        <td>".$feedersStat['count']."</td>
//                    </tr>";
//        }
//        return $result . "</table>";
//    }


    function createTable($feedersStats) {
        $ok = 0;
        $damage = 0;
        $ng = 0;
        $all = 0;
        $result = "<table class='stats_table'>
                    <tr class='table_header_row'>
                        <th>MECHANISM</th>
                        <th>SIZE</th>
                        <th>OK</th>
                        <th>DAMAGE</th>
                        <th>NG</th>
                        <th>ALL</th>
                    </tr>";
        foreach ($feedersStats as $feedersStat) {
            $ok = $ok + $feedersStat['ok'];
            $damage = $damage + $feedersStat['damage'];
            $ng = $ng + $feedersStat['ng'];
            $all = $all + $feedersStat['allFeeder'];
            $result = $result . "
                    <tr class='table_row'>
                        <td>".$feedersStat['mechanismName']."</td>                        
                        <td>".$feedersStat['sizeName']."</td>                        
                        <td class='numbers'>".$feedersStat['ok']."</td>
                        <td class='numbers'>".$feedersStat['damage']."</td>
                        <td class='numbers'>".$feedersStat['ng']."</td>                        
                        <td class='numbers'>".$feedersStat['allFeeder']."</td>                        
                    </tr>";
        }
        return $result .
            "<tr class='table_total'>
                <td colspan='2'>Total Amount</td>
                <td class='numbers'>".$ok."</td>
                <td class='numbers'>".$damage."</td>
                <td class='numbers'>".$ng."</td>                        
                <td class='numbers'>".$all."</td>  
            </tr>".
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