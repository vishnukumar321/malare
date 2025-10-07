<?php
include_once "lib/load.php";
include_once __DIR__ . "/../lib/traits/SQLgettersetter.trait.php";
class post
{
    use SQLgettersetter;
    public $table;
    public $id;
    public $conn;
    public $data;
    public $element;
    public static function post_upload($post_text, $image_tmp)
    {
        try {
            if (is_file($image_tmp) and exif_imagetype($image_tmp) != false) {
                $owner = session::get_user_object()->getemail();
                $post_name = md5($owner . time()) . image_type_to_extension(exif_imagetype($image_tmp));
                $image_path = get_conf('post_move_path') . $post_name;
                if (move_uploaded_file($image_tmp, $image_path)) {
                    $conn = database::get_conn();
                    $sql = "INSERT INTO `posts` (`post_text`, `multiple_images`, `image_url`, `like_count`, `uploaded_time`, `owner`)
VALUES ('$post_text', '0', '/image.php?name=$post_name', '1', now(), '$owner');";
                    if ($conn->query($sql) == true) {
                        $post = new post(mysqli_insert_id($conn));
                        return true;
                    } else {
                        throw new Exception("can't upload post in " . __CLASS__ . __METHOD__ . __LINE__);
                    }
                } else {
                    throw new Exception("that uploaded is not image" . __CLASS__ . __METHOD__ . __LINE__);
                }
            }
        } catch (Exception $e) {
            return false;
        }
    }
    public function __construct($id)
    {
        try {
            if (!$this->conn) {
                $this->conn = database::get_conn();
            }
            $this->element='id';
            $this->table='posts';
            $this->id = $id;
            $sql = "SELECT * FROM `posts` WHERE `id` = '$id'";
            $result = $this->conn->query($sql);
            if ($result->num_rows == 1) {
                $this->data = $result->fetch_assoc();
            } else {
                throw new Exception("can't construct in" . __CLASS__ . __METHOD__ . __LINE__);
            }
        } catch (Exception $e) {
            return false;
        }
    }
    public static function getallposts(){
        $conn=database::get_conn();
        $sql="SELECT `id` FROM `posts` ORDER BY `uploaded_time` DESC";
        $result=$conn->query($sql);
        return iterator_to_array($result);
    }
}
