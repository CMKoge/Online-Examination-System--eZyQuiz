<?php
require '../includes/init.php';

$user = new User();
if($user->isLoggedIn()) {
  $user->logout();
  Redirect::locate('index.php');
}else {Redirect::locate('login.php');}
 ?>
