<?php
session_start();
Class DBHelper{
    	//properties
		private $hostname='localhost'; //127.0.0.1
		private $username='root';
		private $password='';
		private $database='inventory';
		private $conn;
// Constructor
function __construct(){
    try{
        $this->conn=new PDO("mysql:host=$this->hostname;dbname=$this->database",$this->username,$this->password);
    }catch(PDOException $e){ echo $e->getMessage();}
}
// Login
    function logginAdmin($data){
        $flag=false;
        $sql = "SELECT * FROM admin WHERE ADMIN_USERNAME = ? AND ADMIN_PASSWORD = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($data);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($stmt->rowCount() > 0)
        {
            $_SESSION['admin'] = $row['admin_lastname'].','.$row['admin_firstname'];
            $_SESSION['admin_id'] = $row['admin_id'];
            $flag = true;
        }
        else{
            echo "<script> alert('Error'); </script>";
        }
        $this->conn = null;
        return $flag;   
    }

    function logginCashier($data){
        $flag=false;
        $sql = "SELECT * FROM cashier WHERE CASHIER_USERNAME = ? AND CASHIER_PASSWORD = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($data);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($stmt->rowCount() > 0)
        {
            $_SESSION['cashier'] = $row['cashier_lastname'].','.$row['cashier_firstname'];
            $_SESSION['cashier_id'] = $row['cashier_id'];
            $flag = true;
        }
        else{
            echo "<script> alert('Error'); </script>";
        }
        $this->conn = null;
        return $flag;   
    }

    function logginClerk($data){
        $flag=false;
        $sql = "SELECT * FROM clerk WHERE CLERK_USERNAME = ? AND CLERK_PASSWORD = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($data);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($stmt->rowCount() > 0)
        {
            $_SESSION['clerk'] = $row['clerk_lastname'].','.$row['clerk_firstname'];
            $_SESSION['clerk_id'] = $row['clerk_id'];
            $flag = true;
        }
        else{
            echo "<script> alert('Error'); </script>";
        }
        $this->conn = null;
        return $flag;   
    }

    function logginDealer($data){
        $flag=false;
        $sql = "SELECT * FROM dealer WHERE DEALER_USERNAME = ? AND DEALER_PASSWORD = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($data);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($stmt->rowCount() > 0)
        {
            $_SESSION['dealer'] = $row['dealer_lastname'].','.$row['dealer_firstname'];
            $_SESSION['dealer_id'] = $row['dealer_id'];
            $flag = true;
        }
        else{
            echo "<script> alert('Error'); </script>";
        }
        $this->conn = null;
        return $flag;   
    }

// Create
    function insertRecord($data,$fields,$table){
        $ok;
        $fld=implode(",",$fields);
        $q=array();
        foreach($data as $d) $q[]="?";
        $plc=implode(",",$q);
        $sql="INSERT INTO $table($fld) VALUES($plc)";
        try{
            $stmt=$this->conn->prepare($sql);
            $ok=$stmt->execute($data);				
        }catch(PDOException $e){ echo $e->getMessage();}
        return $ok;
    }
// Retrieve
function getAllRecord($table){
        $rows;
        $sql="SELECT * FROM $table";
        try{
            $stmt=$this->conn->prepare($sql);
            $stmt->execute();
            $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){ echo $e->getMessage();}
        return $rows;
    }
    //-----
    function getRecordById($table,$field_id,$ref_id){
        $sql = "SELECT * FROM $table WHERE $field_id = ?";
        try{
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(array($ref_id));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        }catch(PDOException $e){ echo $e->getMessage();}
        return $row;
       // $this->conn = null;
    }
    //---
function getRecord($table,$field_id,$ref_id){
    $row;
    $sql="SELECT * FROM $table WHERE $field_id = ?";
    try{
        $stmt=$this->conn->prepare($sql);
        $stmt->execute(array($ref_id));
        $row=$stmt->fetchAll(PDO::FETCH_ASSOC);
    }catch(PDOException $e){ echo $e->getMessage();}
    return $row;
}
// Update
function updateRecord($table,$fields,$data,$field_id,$ref_id){
    $ok;
    $flds=implode("=?,",$fields)."=?";
    $sql="UPDATE $table SET $flds WHERE $field_id=$ref_id";
    try{
        $stmt=$this->conn->prepare($sql);
        $ok=$stmt->execute($data);
    }catch(PDOException $e){ echo $e->getMessage();}
    return $ok;
}
 
// Delete
function deleteRecord($table,$field_id,$ref_id){
    $ok;
    $sql="DELETE FROM $table WHERE $field_id=?";
    try{
        $stmt=$this->conn->prepare($sql);
        $ok=$stmt->execute(array($ref_id));				
    }catch(PDOException $e){ echo $e->getMessage();}
    return $ok;
}
  
// Some functions
    function countRecord($field,$table){
        $sql = "SELECT count($field) FROM $table";
        try{
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchColumn();
    }catch(PDOException $e){ echo $e->getMessage();}
        return $row;
       // $this->conn = null;
    }
    function countRecordGroup($field,$other,$countName,$table,$ref_id){
        $sql = "SELECT $other,count($field) AS $countName  FROM $table group by $ref_id";
        try{
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }catch(PDOException $e){ echo $e->getMessage();}
        return $row;
       // $this->conn = null;
    }
    
    //
    // function destroy(){
    //     $this->conn=null;
    // }
    function getByRelation($table,$fields_id,$ref_id,$data){
        // $tables = implode(",",$table);
        $sql = "SELECT * FROM $table WHERE $fields_id = $ref_id AND $fields_id  = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($data);
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }
    function getAllRecordId($field,$table){
        $rows;
        $sql="SELECT $field FROM $table";
        try{
            $stmt=$this->conn->prepare($sql);
            $stmt->execute();
            $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){ echo $e->getMessage();}
        return $rows;
    }

    //----- STORED PROCEDure
    function getProcedure($table){
        $rows;
        $sql="call display".$table."()";
        try{
            $stmt=$this->conn->prepare($sql);
            $stmt->execute();
            $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){ echo $e->getMessage();}
        return $rows;
    }
}
