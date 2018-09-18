<?php
    include '../../model/loginModel.php';
    
    $log = new Log();
    if(isset($_POST['login']))
    {
        $user = htmlentities($_POST['username']);
        $pass = htmlentities($_POST['password']);
        $ok=$log->loginAdmin(array($user,$pass));
        $ok=$log->loginCashier(array($user,$pass));
        $ok=$log->loginClerk(array($user,$pass));
        $ok=$log->loginDealer(array($user,$pass));
        if($ok){
        header("location:../../view/index.php");
        }
        else {
            echo "error";
        }
    }
?>