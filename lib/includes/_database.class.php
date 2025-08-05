<?php
class database
{
    public static $conn;
    public static function get_conn()
    {
        if (!database::$conn) {
            $sname = "mysql.selfmade.ninja:3306";
            $uname = "db_photogram";
            $pass = "password";
            $db = "db_photogram_photogram";
            $conn= new mysqli($sname,$uname,$pass,$db);
            if($conn->connect_error){
                die("database connection error".$conn->connect_error);
            }else{
                return database::$conn=$conn;
            }
        }else{
            return database::$conn;
        }
    }
}
