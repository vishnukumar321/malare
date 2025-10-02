<?php
include_once "lib/load.php";
include_once __DIR__ . "/../traits/SQLgettersetter.trait.php";
class auth
{
    use SQLgettersetter;
    public $conn;
    public $id;
    public $element;
    public $table;
    public function __construct($token)
    {
        $this->element = "uid";
        $this->table = "user_session";
        $this->conn = database::get_conn();
        $sql = "SELECT * FROM `user_session` WHERE `token` = '$token'";
        $result = $this->conn->query($sql);
        if ($result->num_rows == true) {
            $row = $result->fetch_assoc();
            $this->id = $row['uid'];
        } else {
            throw new Exception("auth contruct error in :" . __CLASS__ . __METHOD__ . __LINE__);
        }
    }
    public static function authenticate($name, $pass)
    {
        try {
            $username = user::login($name, $pass);
            if ($username) {
                $user = new user($username);
                $conn = database::get_conn();
                $agent = $_SERVER['HTTP_USER_AGENT'];
                $ip = $_SERVER['REMOTE_ADDR'];
                date_default_timezone_set('asia/kolkata');
                $time = time();
                $token = md5(rand(0, 99999) . $agent . $ip . time());
                $main_sql = "SELECT * FROM `user_session` WHERE `uid` = '$user->id'";
                $result = $conn->query($main_sql);
                if ($result->num_rows != 1) {
                    $sql = "INSERT INTO `user_session` (`uid`, `ip`, `agent`, `token`, `time`, `active`)
VALUES ('$user->id', '$ip', '$agent', '$token', '$time', '1');";
                    if ($conn->query($sql) == true) {
                        if (session::session_get("error")) {
                            session::session_value_delete(session::session_get("error"));
                        }
                        session::session_set("token", $token);
                        session::$token = $token;
                        return true;
                    } else {
                        throw new Exception("user authentication error in :" . __CLASS__ . __FUNCTION__ . __LINE__);
                    }
                } else {
?><script>
                        alert("you can not login this account.because this <?= $username ?> user account is already logged by another person...")
                    </script>
                    <script>
                        // window.location = "login.php"
                    </script><?php
                            }
                        }
                    } catch (Exception $e) {
                        return false;
                    }
                }
                public static function autherize($token)
                {
                    try {
                        $auth = new auth($token);
                        if ($token == $auth->gettoken()) {
                            if ($_SERVER['HTTP_USER_AGENT'] == $auth->getagent()) {
                                if ($_SERVER['REMOTE_ADDR'] == $auth->getip()) {
                                    if ($auth->getactive() == 1) {
                                        if ($auth->is_valid($auth->gettime())) {
                                            return true;
                                        } else {
                                            throw new Exception("session expired in :" . __CLASS__ . __FUNCTION__ . __LINE__);
                                        }
                                    } else {
                                        throw new Exception("session expired in :" . __CLASS__ . __FUNCTION__ . __LINE__);
                                    }
                                } else {
                                    throw new Exception("different ip address in :" . __CLASS__ . __FUNCTION__ . __LINE__);
                                }
                            } else {
                                throw new Exception("different user agent in :" . __CLASS__ . __FUNCTION__ . __LINE__);
                            }
                        } else {
                            throw new Exception("different session token in :" . __CLASS__ . __FUNCTION__ . __LINE__);
                        }
                    } catch (Exception $e) {
                        return false;
                    }
                }
                public function is_valid($time)
                {
                    date_default_timezone_set('asia/kolkata');
                    $diff=time()-$time;
                    if($diff<2592000){ // 2592000 means one month 
                        return true;
                    }else{
                        return false;
                    }
                }
            }
