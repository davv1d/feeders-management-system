<?php

class Authorization
{
    static function availableForAdmin() {
        self::availableForAuthenticated();
        if (isset($_SESSION['logged']) && ($_SESSION['roleName'] == 'manager' || $_SESSION['roleName'] == 'operator' || $_SESSION['roleName'] == 'mechanic')) {
            header("Location: users.php");
        }
    }

    static function availableForMechanic() {
        self::availableForAuthenticated();
        if (isset($_SESSION['logged']) && ($_SESSION['roleName'] == 'manager' || $_SESSION['roleName'] == 'operator')) {
            header("Location: users.php");
        }
    }

    static function availableForMechanicAndManager() {
        self::availableForAuthenticated();
        if (isset($_SESSION['logged']) && $_SESSION['roleName'] == 'operator') {
            header("Location: users.php");
        }
    }

    static function availableForManager() {
        self::availableForAuthenticated();
        if (isset($_SESSION['logged']) && ($_SESSION['roleName'] == 'mechanic' || $_SESSION['roleName'] == 'operator')) {
            header("Location: users.php");
        }
    }


    static function availableForMechanicAndOperator() {
        self::availableForAuthenticated();
        if (isset($_SESSION['logged']) && $_SESSION['roleName'] == 'manager') {
            header("Location: users.php");
        }
    }

    static function authorizeDamageFeeder() {
        self::availableForAuthenticated();
        if (isset($_SESSION['logged']) && $_SESSION['roleName'] == 'manager') {
            header("Location: users.php");
        }
    }



    static function authorizeNewFeeder() {
        self::availableForAuthenticated();
        if (isset($_SESSION['logged']) && ($_SESSION['roleName'] == 'manager' || $_SESSION['roleName'] == 'operator')) {
            header("Location: users.php");
        }
    }

    static function authorizeFeederRepair() {
        self::availableForAuthenticated();
        if (isset($_SESSION['logged']) && ($_SESSION['roleName'] == 'manager' || $_SESSION['roleName'] == 'operator')) {
            header("Location: users.php");
        }
    }

    static function availableForAuthenticated() {
        if (!isset($_SESSION['logged'])) {
            header("Location: index.php");
        }
    }

    static function ifLogged() {
        if (isset($_SESSION['logged']) && ($_SESSION['logged'] == true)) {
            header("Location: users.php");
        }
    }
}