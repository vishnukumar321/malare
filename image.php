<?php
include_once "lib/load.php";
if (isset($_GET['name'])) {
    $name = $_GET['name'];
    $name=str_replace("..","",$name);
    $file_path = get_conf("post_move_path") . $name;
    if (is_file($file_path)) {
        // header("Content-Length: " . filesize($file_path));
        // header("Content-Type: image/png");
        // header("Content-Type:".mime_content_type($file_path));
        // echo file_get_contents($file_path);
        header("Content-Type:" . mime_content_type($file_path));
        header("Content-Length:" . filesize($file_path));
        echo file_get_contents($file_path);
    } else {
        echo "no file";
    }
}
