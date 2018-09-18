<?php
require 'db/dbhelper.php';
Class Log extends DBHelper{
    function __construct(){
        return DBHelper::__construct();
    }
    function loginAdmin($data){
        return DBHelper::logginAdmin($data);
    }
    function loginCashier($data){
        return DBHelper::logginCashier($data);
    }
    function loginClerk($data){
        return DBHelper::logginClerk($data);
    }
    function loginDealer($data){
        return DBHelper::logginDealer($data);
    }
}