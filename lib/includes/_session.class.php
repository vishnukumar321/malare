<?php
include_once "lib/load.php";
class session{
    public static function session_start(){
        session_start();
    }
    public static function session_delete($data){
        unset($_SESSION[$data]);
    }
    public static function session_destroy(){
        session_destroy();
    }
    public static function session_get($data){
        if(isset($_SESSION[$data])){
            return $_SESSION[$data];
        }else{
            throw new Exception("there are no data named $data in the table".__CLASS__.__METHOD__.__LINE__);
        }
    }
    public static function session_set($key,$value){
        $_SESSION[$key]=$value;
    }
    public static function session_clear(){
        session_unset();
        ?><script>window.location="index.php"</script><?php
    }
    public static function is_autherize(){
        try{
            if(session::session_get('token')){
                if(!auth::autherize(session::session_get('token'))){
                    session::session_clear();
                }
            }
        }catch(Exception $e){
            
        }
    }
    public static function main_template()
    {
        session::is_autherize();
        get_file("head");
        get_file("header");
        get_file(basename($_SERVER['PHP_SELF'],".php"));
        get_file("footer");
    }
}
?>