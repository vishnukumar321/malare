<?php
include_once "lib/load.php";
include_once __DIR__."/../traits/SQLgettersetter.trait.php";
class user{
    use SQLgettersetter;
    public $conn;
    public $id;
    public $username;
    public $element;
    public $table;
    public function __construct($id){
        $this->conn=database::get_conn();
        $sql="SELECT * FROM `user` WHERE `username` = '$id' OR `email` = '$id' OR `id` = '$id'";
        $result=$this->conn->query($sql);
        if($result->num_rows==1){
            $row=$result->fetch_assoc();
            $this->table="user";
            $this->element="id";
            $this->id=$row['id'];
            $this->username=$row['username'];
        }else{
            throw new Exception("user class construct error".__CLASS__.__LINE__);
        }
    }
    public static function signup($name,$email,$phone,$pass){
        try{
            $conn=database::get_conn();
        $pass=password_hash($pass,PASSWORD_BCRYPT);
        $sql="INSERT INTO `user` (`username`, `email`, `phone`, `password`)
VALUES ('$name', '$email', '$phone', '$pass');";
        if($conn->query($sql)==true){
            return true;
        }else{
            throw new Exception("signup error in :".__CLASS__.__LINE__);
        }
        }catch(Exception $e){
            return false;
        }
    }
    public static function login($name,$pass){
        try{
            $conn=database::get_conn();
            $sql="SELECT * FROM `user` WHERE `username` = '$name'";
            $result=$conn->query($sql);
            if($result->num_rows==1){
                $row=$result->fetch_assoc();
                if(password_verify($pass,$row['password'])){
                    return $row['username'];
                }else{
                    throw new Exception("login error in :".__FUNCTION__.__LINE__);
                }
            }

        }catch(Exception $e){
            return false;
        }
    }
}
?>