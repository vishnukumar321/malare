<?php
include_once "lib/load.php";
trait SQLgettersetter{
    public function __call($name,$args){
        $element=substr($name,3);
        if(substr($name,0,3)=="get"){
           return $this->get_data($element); 
        }elseif(substr($name,0,3)=="set"){
            return $this->set_data($element,$args[0]);
        }
    }
    public function get_data($name){
        if(!$this->conn){
            $this->conn= database::get_conn();
        } 
        $sql="SELECT * FROM `$this->table` WHERE `$this->element` = '$this->id'";
        $result=$this->conn->query($sql);
        if($result->num_rows==true){
            $row=$result->fetch_assoc();
            if($row[$name]){
                return $row[$name];
            }else{
                 throw new Exception("there no $name named data in the $this->table table");
            }
        }else{
            throw new Exception("there are no data named $name in the $this->table table");
        }
    }
    public function set_data($name,$args){
        if(!$this->conn){
            $this->conn=database::get_conn();
        }
        $sql="UPDATE `$this->table` SET `$name` = '$args' WHERE `$this->element` = '$this->id';";
        if($this->conn->query($sql)==true){
            return true;
        }else{
            throw new Exception("can not set data to $this->table table".__LINE__);
        }
    }
}
?>