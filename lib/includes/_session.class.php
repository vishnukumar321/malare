<?php
include_once "lib/load.php";
class session{
    public static $conn;
    public static $token;
    public static $id;
    public static $multi_account;
    public static function session_start(){
        session_start();
    }
    public static function session_value_delete($data){
        unset($_SESSION[$data]);
    }
    public static function session_destroy(){
        session_destroy();
    }
    public static function session_get($data){
        try{
            if(isset($_SESSION[$data])){
            return $_SESSION[$data];
        }else{
            throw new Exception("there are no data named $data in the table".__CLASS__.__METHOD__.__LINE__);
        }
        }catch(Exception $e){
            return false;
        }
    }
    public static function session_set($key,$value){
        $_SESSION[$key]=$value;
    }
    public static function session_clear(){
        session_unset();
        ?>
        <script>window.location="index.php"</script>
        <?php
    }
    public static function is_autherize(){
        try{
            if(session::session_get('token')){
                if(!auth::autherize(session::session_get('token'))){
                    ?><script>alert("session expired.please login again...")</script><?php
                    session::session_delete();
                }
            }
        }catch(Exception $e){
            
        }
    }
    public static function get_auth_object(){
        $auth=new auth(session::session_get('token'));
        return $auth;
    }
    public static function session_delete(){
        if(!session::$conn){
            session::$conn=database::get_conn();
        }
        $id=session::get_id();
        $sql="DELETE FROM `user_session` WHERE `uid` = '$id'";
        if(session::$conn->query($sql)==true){
            session::session_clear();
        }else{
            throw new Exception("can't delete user session:".__CLASS__.__METHOD__.__LINE__);
        }

    }
    public static function get_id(){
        $auth=new auth(session::session_get('token'));
        session::$id=$auth->getuid();
        return $auth->getuid();
    }
    public static function main_template()
    {
        session::is_autherize();
        get_file("head");
        get_file("header");
        get_file(basename($_SERVER['PHP_SELF'],".php"));
        get_file("footer");
    }
    public static function ensurelogin(){
        if(!session::session_get('token')){
            session::session_set('redirect',$_SERVER['REQUEST_URI']);
            ?><script>window.location="login.php"</script><?php
        }
    }
    public static function already_login(){
        if(session::session_get('token')){
            ?><script>window.location="<?=get_conf('documentroot')?>"</script><?php
        }
    }
}
?>