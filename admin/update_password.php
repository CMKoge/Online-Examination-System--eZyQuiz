<?php
require_once '../includes/init.php';

if (Input::exists()) {
  if(Token::check(Input::get('token'))) {
    $admin = new Admin();
    $validate = new Validate();
    $validation = $validate->check($_POST, array(
      'email' => array(
        'required' => true,
        'exists' => 'admin'
      ),
      'username' => array(
         'required' => true,
         'exists' => 'admin'
       ),
       'password' => array(
         'required' => true,
         'min' => 6
       ),
       'repassword' => array(
         'required' => true,
         'matches' => 'password'
       ),
     ));
    // Validate Submit Button
    if ($validation->passed()) {
      try {
        $salt = Hash::salt(32);
        $admin->update(array(
               'password' => Hash::make(Input::get('password'), $salt),
               'salt' => $salt
             ));
        Redirect::locate('index.php');
      } catch (Exception $ex) {
        die($ex);
      }
    } else {
      foreach ($validation->errors() as $error) {
        echo $error." </br>";
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
    <title>Change Password</title>
  </head>
  <body class="container-fluid">
    <!--TopNav-->
    <?php include_layout_template('top_nav.php'); ?>
    <br><br><br>
    <form class="form-horizontal reg-form" action="update_password.php" method="post">
  <div class="form-group">
    <label class="control-label col-sm-4" for="email">Email:</label>
    <div class="col-sm-5">
      <input type="email" name="email" class="form-control" id="email" placeholder="Enter email">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-4" for="usr">Username:</label>
    <div class="col-sm-5">
      <input type="username" name="username" class="form-control" id="usr" placeholder="Enter username">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-4" for="pwd">New Password:</label>
    <div class="col-sm-5">
      <input type="password" name="password" class="form-control" id="pwd" placeholder="Enter new password">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-4" for="pwd">Reenter New Password:</label>
    <div class="col-sm-5">
      <input type="password" name="repassword" class="form-control" id="pwd" placeholder="Enter new password">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-4 col-sm-5">
      <input type="hidden" name="token" value="<?php echo Token::generate();?>">
      <button type="submit" name="update" class="btn btn-default">Update</button>
    </div>
  </div>
</form>
  </body>
</html>
