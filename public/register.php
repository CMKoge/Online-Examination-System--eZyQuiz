<?php
require_once '../includes/init.php';
$db = Database::getInstance()->Query("SELECT * FROM `admin`");
if(!$db->count()) {
if (Input::exists()) {
  if(Token::check(Input::get('token'))) {
    $validate = new Validate();
    $validation = $validate->check($_POST, array(
      'email' => array(
        'required' => true,
        'unique' => 'admin'
      ),
      'username' => array(
        'required' => true,
        'min' => 3,
        'max' => 25,
        'unique' => 'admin'
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
      $admin = new Admin();
      $salt = Hash::salt(32);

      try {
        $admin->create('admin',array(
          'email' => Input::get('email'),
          'username' => Input::get('username'),
          'password' => Hash::make(Input::get('password'), $salt),
          'salt' => $salt,
          'date' => date('Y-m-d H:i:s')
        ));
        Redirect::locate('index.php');
      } catch (Exception $ex) {
        die($ex->getMessage());
      }
    } else {
      foreach ($validation->errors() as $error) {
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
    <title>Register</title>
  </head>
  <body class="container-fluid">
    <form class="form-horizontal reg-form" action="register.php" method="post">
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
    <label class="control-label col-sm-4" for="pwd">Password:</label>
    <div class="col-sm-5">
      <input type="password" name="password" class="form-control" id="pwd" placeholder="Enter password">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-4" for="pwd">Reenter Password:</label>
    <div class="col-sm-5">
      <input type="password" name="repassword" class="form-control" id="pwd" placeholder="Enter password">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-4 col-sm-5">
      <input type="hidden" name="token" value="<?php echo Token::generate();?>">
      <button type="submit" name="register" class="btn btn-default">Register</button>
    </div>
  </div>
</form>
  </body>
</html>
<?php } else {
  Redirect::locate('index.php');
}
  ?>
