<?php


class MenuController
{
    function chooseMenuByRole($roleName) {
        switch ($roleName) {
            case 'operator':
                $result = '<div class="option"><a href="/feed/damageFeeder.php">Damage Feeder</a></div>
                           <div class="option" id="logout"><a href="./logout.php">Logout</a></div>
                           <div style="clear:both;"></div>';
                break;
            case 'mechanic':
                $result = '<div class="option"><a href="/feed/damageFeeder.php">Damage Feeder</a></div>
                           <div class="option"><a href="/feed/newFeeder.php">New Feeder</a></div>
                           <div class="option"><a href="/feed/feederRepair.php">Repair Feeder</a></div>
                           <div class="option"><a href="/feed/specificStats.php">Specific Stats</a></div>
                           <div class="option" id="logout"><a href="./logout.php">Logout</a></div>
                           <div style="clear:both;"></div>';
                break;
            default:
                $result = 'nothing';
                break;
        }
        return $result;
    }
}