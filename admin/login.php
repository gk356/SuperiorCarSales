<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/project/core/init.php';
include 'include/head.php';
$email = ((isset($_POST['email']))?$_POST['email']:'');
$email = trim($email);
$password = ((isset($_POST['password']))?$_POST['password']:'');
$password = trim($password);
$errors = array();
?>

<style>
body{
  background-image: url("/project/images/background.jpg");
  background-size: 100vh 100vw;
  background-attachment: fixed;
  
}
</style>
<div id = "login-form">
  <div >
    <?php
    if($_POST){
      //form validation
      if(empty($_POST['email']) || empty($_POST['password'])){
        $errors[] = "You must provide email and password.";
      }
      // validate Email
      if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
          $errors[] = "Invalid Email Format";
      }

      if(strlen($password)<3){
        $errors[] = "Password must be atleast 3 characters long.";
      }


      //users exist on database
      $equery = "SELECT * FROM users WHERE email = '$email'";
      $query = $db->query($equery);
      $user = mysqli_fetch_assoc($query);
      $userCount = mysqli_num_rows($query);
      if($userCount < 1){
        $errors[] = "Email does not exist.";
      }

      if(!password_verify($password, $user['password'])){
        $errors[] = "Incorrect password";
      }

      if(!empty($errors)){
        echo display_errors($errors);
      }else{
        //log user in
        $user_id = $user['id'];
        login($user_id);
      }
    }
    ?>
  </div>
  <h2 class ="text-center">Login</h2><hr/>
  <form action ="login.php" method ="post">
    <div class="form-group">
      <label for="email">Email: </label>
      <input type ="email" name="email" id="email" class="form-control" value="<?=$email;?>">
    </div>
    <div class="form-group">
      <label for="password">Password: </label>
      <input type ="password" name="password" id="password" class="form-control" value="<?=$password;?>">
    </div>
    <div class="from-group">
      <input type ="submit" value="Login"  class="btn btn-primary"/>
    </div>
  </form>
  <p class ="text-right"><a href="/project/index.php" alt="home">Visit Site</a></a></p>
</div>

<?php include 'include/footer.php'; ?>
