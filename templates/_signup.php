<?php
include_once "lib/load.php";
session::already_login();
$result=false;
$signup=false;
$error=false;
if(isset($_POST['name']) and isset($_POST['email']) and isset($_POST['phone']) and isset($_POST['pass'])){
    $name=$_POST['name'];
    $email=$_POST['email'];
    $phone=$_POST['phone'];
    $pass=$_POST['pass'];
    $signup=user::signup($name,$email,$phone,$pass);
    $result=true;
}
if($result){
    if($signup){
        ?><script>window.location="signup_success.php"</script><?php
    }else{
        $error=true;
    }
}
if($error or !$result){
  ?>
  <main class="form-signin w-100 m-auto">
 <center>
     <form action="signup.php" method="post">
    <img class="mb-4" src="<?=get_conf("documentroot")?>/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
    <h1 class="h3 mb-3 fw-normal">Please signup</h1>

    <div class="form-floating">
      <input name="name" type="text" class="form-control" id="floatingInput" placeholder="@username" required>
      <label for="floatingInput">Username</label>
    </div>
    <div class="form-floating">
      <input name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com" required>
      <label for="floatingInput">Email address</label>
    </div>
    <div class="form-floating">
      <input name="phone" type="tel" class="form-control" id="floatingInput" placeholder="1234567890" required>
      <label for="floatingInput">Phone no</label>
    </div>
    <div class="form-floating">
      <input name="pass" type="password" class="form-control" id="floatingPassword" placeholder="Password" required>
      <label for="floatingPassword">Password</label>
    </div>
    <?php
    if($error){
      ?><p style="color: red;">Username or email id is already taken</p><?php
    }
    ?>
    <button class="btn btn-primary w-100 py-2" type="submit">Signup</button>
  </form>
 </center>
</main>
  <?php
}
?>