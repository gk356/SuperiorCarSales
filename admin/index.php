<?php
require_once '../core/init.php';
if(!is_logged_in()){
  header('Location: login.php');
}
include 'include/head.php';
include 'include/navigation.php';

?>
<h2 class="text-center">Admin Page</h2><hr>
<style>
body{
  background-image: url("/project/images/background.jpg");
  background-size: 50vw 50vh;
  background-attachment: fixed;
  background-repeat: no-repeat;
  background-position:center;
}
</style>


<?php include 'include/footer.php';?>
