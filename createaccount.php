<?php
require_once '../core/init.php';
if(!is_logged_in()){
  header('Location: login.php');
}
include 'include/head.php';
include 'include/navigation.php';

?>
