<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/project/core/init.php';
unset($_SESSION['SCUser']);
header('Location: login.php');
?>
