<pre>
<?php
include_once "lib/load.php";
// echo "files";
// print_r($_FILES);
// echo "post";
// print_r($_POST); 
// $n=$_FILES["file"];
// echo basename($n['type']);
// if(isset($_SESSION['token'])){
//     echo session::get_user_object()->getemail();
// }else{
//     echo "no";
// }
if(post::post_upload($_POST['text'],$_FILES['file']['tmp_name'])){
    echo "yes";
}else{
    echo "no";
}
?>
</pre>