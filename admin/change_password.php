<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/project/core/init.php';
if(!is_logged_in()){
  login_error_redirect();
}
include 'include/head.php';

$hashed = $user_data['password'];
$old_password = ((isset($_POST['old_password']))?$_POST['old_password']:'');
$old_password = trim($old_password);
$password = ((isset($_POST['password']))?$_POST['password']:'');
$password = trim($password);
$confirm = ((isset($_POST['confirm']))?$_POST['confirm']:'');
$confirm = trim($confirm);
$new_hashed = password_hash($password, PASSWORD_DEFAULT);
$user_id = $user_data['id'];
$errors = array();
?>
<style>
body{
  background-image: url("/project/images/background.jpg");
  background-size: 100vw 100vh;
  background-attachment: fixed;
}
</style>
<div id = "login-form">
  <div >
    <?php
    if($_POST){
      //form validation
      if(empty($_POST['old_password']) || empty($_POST['password']) || empty($_POST['confirm'])){
        $errors[] = "All fields are required.";
      }

      if(strlen($password)<3){
        $errors[] = "Password must be atleast 3 characters long.";
      }

      //if new pw matches old_password
      if($password != $confirm){
        $errors[] = "Passwords does not match!!!";
      }

      if(!password_verify($old_password, $hashed)){
        $errors[] = "Incorrect Old password";
      }

      if(!empty($errors)){
        echo display_errors($errors);
      }else{
        //change_password
        $db->query("UPDATE users SET password = '$new_hashed' WHERE id = '$user_id'");
        $_SESSION['success_flash'] = 'Password Change Successful.';
        header('Location: index.php');

      }
    }
    ?>
  </div>
  <h2 class ="text-center">Change Password</h2><hr/>
  <form action ="change_password.php" method ="post">
    <div class="form-group">
      <label for="old_password">Old Password: </label>
      <input type ="password" name="old_password" id="old_password" class="form-control" value="<?=$old_password;?>">
    </div>
    <div class="form-group">
      <label for="password">New Password: </label>
      <input type ="password" name="password" id="password" class="form-control" value="<?=$password;?>">
    </div>
    <div class="form-group">
      <label for="confirm">Confirm Password: </label>
      <input type ="password" name="confirm" id="confirm" class="form-control" value="<?=$confirm;?>">
    </div>
    <div class="from-group">
      <a href="index.php" class="btn btn-default">Cancel</a>
      <input type ="submit" value="Login"  class="btn btn-primary"/>
    </div>
  </form>
  <p class ="text-right"><a href="/project/index.php" alt="home">Visit Site</a></a></p>
</div>

<?php include 'include/footer.php'; ?>
