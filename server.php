<?php
if(isset($_GET['add'])){
  $name = ((isset($_POST['name']))? $_POST['name']:'');
  $email = ((isset($_POST['email']))? $_POST['email']:'');
  $password = ((isset($_POST['password']))? $_POST['password']:'');
  $confirm = ((isset($_POST['confirm']))? $_POST['confirm']:'');
  $permissions = ((isset($_POST['permissions']))? $_POST['permissions']:'');
  $errors = array();
  if($_POST){
      $emailQuery = $db->query("SELECT * FROM users WHERE email='$email'");
      $emailCount = mysqli_num_rows($emailQuery);

      if($emailCount != 0){
        $errors[] = "Email already exist";
      }
  $required = array('name','email','password', 'confirm','permissions');
  foreach($required as $f){
    if(empty($_POST[$f])){
      $errors[] = 'All fields are required.';
      break;
    }
  }
  if($password != $confirm){
    $errors[] = 'Password didnot match';
  }
  if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
    $errors[] = "Invalid Email Format";
  }

  if(!empty($errors)){
    echo display_errors($errors);

  }else{
    //add user
    $hashed = password_hash($password,PASSWORD_DEFAULT);
    $db->query("INSERT INTO users (fullname,email, password,permission) VALUES('$name', '$email', '$hashed', '$permissions')");
    $_SESSION['success_flash'] ="User has been added.";
    header('Location: users.php');
  }
}
}
?>
