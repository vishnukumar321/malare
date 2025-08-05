<?php
include_once "lib/load.php";
$result=false;
$login=false;
$error=false;
if(isset($_POST['name']) and isset($_POST['pass'])){
    $name=$_POST['name'];
    $pass=$_POST['pass'];
    $login=auth::authenticate($name,$pass);
    $result=true;
}
if($result){
    if($login){
        ?><script>window.location="index.php"</script><?php
    }else{
        $error=true;
    }
}
if($error or !$result){
  ?>
  <main class="form-signin w-100 m-auto">
 <center>
     <form action="login.php" method="post">
    <img class="mb-4" src="<?=get_conf("documentroot")?>/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
    <h1 class="h3 mb-3 fw-normal">Please Login</h1>
    <div class="form-floating">
      <input name="name" type="text" class="form-control" id="floatingInput" placeholder="@username" required>
      <label for="floatingInput">Username</label>
    </div>
    <div class="form-floating">
      <input name="pass" type="password" class="form-control" id="floatingPassword" placeholder="Password" required>
      <label for="floatingPassword">Password</label>
    </div>
    <?php
    if($error){
      ?><p style="color: red;">Invalid email or password</p><?php
    }
    ?>
    <button class="btn btn-primary w-100 py-2" type="submit">Login</button>
  </form>
 </center>
</main>
  <?php
}
?>