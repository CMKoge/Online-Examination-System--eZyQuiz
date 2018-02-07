<?php
require '../includes/init.php';
if (Input::exists()) {
   if (Token::check(Input::get('token'))) {
     $validate = new Validate();
     $validataion = $validate->check($_POST, array(
       'username' => array('required' => true),
       'password' => array('required' => true)
     ));
     if ($validataion->passed()) {
       $admin = new Admin();
       $login = $admin->login(Input::get('username'), Input::get('password'));
       if ($login) {
         Redirect::locate('instruction.php');
       } else {
         output_message("Username or Password is incorrect");
       }
     } else {
       foreach ($validataion->errors() as $error) {
         output_message("$error");
       }
     }
   }
 }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
  </head>
  <body class="container-fluid">
  <form class="form-inline login-form" action="index.php" method="post">
  <div class="form-group">
    <label for="usr">Username</label>
    <input type="username" class="form-control" id="usr" placeholder="Enter username" name="username">
  </div>
  <div class="form-group">
    <label for="pwd">Password:</label>
    <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="password">
  </div>
  <input type="hidden" name="token" value="<?php echo Token::generate()?>">
  <button type="submit" name="login" class="btn btn-default">Login</button>
  </form>
  <div class="divide">
    <h3>or</h3>
  </div>
  <div class="register">
    <h4><a href="register.php"><span class="glyphicon glyphicon-hand-right"></span>Register</a></h4>
  </div>
  </body>
</html>
