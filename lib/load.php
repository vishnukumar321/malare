<?php
include_once "lib/includes/_database.class.php";
include_once "lib/includes/_user.class.php";
include_once "lib/includes/_session.class.php";
include_once "lib/includes/_auth.class.php";
include_once "app/_post.class.php";
session::session_start();
global $conf;
$conf = file_get_contents($_SERVER['DOCUMENT_ROOT']."/../project/malareconfigfile.json");
function get_conf($name){
    global $conf;
    $arr=json_decode($conf, true);
    if(isset($arr[$name])){
        return $arr[$name];
    }else{
        throw new Exception("there are no $name value in config file reffered to:".__FUNCTION__.__LINE__);
    }
}
function get_file($file_name){
    include $_SERVER['DOCUMENT_ROOT'].get_conf("documentroot")."/templates/_$file_name.php";
}
?>