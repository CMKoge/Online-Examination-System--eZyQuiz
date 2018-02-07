<?php
require '../includes/init.php';

$admin = new Admin();
if ($admin->isLoggedIn()) {
  $admin->logout();
  Redirect::locate('index.php');
} else { Redirect::locate('index.php'); }
 ?>
