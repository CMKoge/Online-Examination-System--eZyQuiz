<?php
require_once '../includes/init.php';
$admin = new Admin();
if ($admin->isLoggedIn()) {
if (Input::exists()) {
    if(Token::check(Input::get('token'))) {
      $validate = new Validate();
      $validation = $validate->check($_POST, array(
        'username' => array(
          'required' => true,
          'unique' => 'candidate',
          'min' => 2,
          'max'=> 10
        ),
        'name' => array(
          'required' => true
        ),
        'password' => array(
          'required' => true,
          'min' => 4
        )
      ));
      // Validate Submit Button
      if ($validation->passed()) {
        $cd = new Candidate();
        $salt = Hash::salt(32);

        try {
          $cd->create(array(
            'name' => Input::get('name'),
            'username' => Input::get('username'),
            'password' => Hash::make(Input::get('password'), $salt),
            'salt' => $salt
          ));
          output_message("Successfully added a candidate");
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
    <title>Admin Panel | Candidate</title>
  </head>
  <body class="container-fluid">
    <!--TopNav-->
    <?php include_layout_template('top_nav.php'); ?>
    <div class="row">
      <div class="col-xs-3">
        <ul class="nav nav-pills nav-stacked navbar-fixed">
          <li><a href="Candidate_view.php">View</a></li>
          <li><a href="Candidate_add.php">Add</a></li>
        </ul>
      </div>
      <div class="col-xs-9">
        <form class="insert-form" action="Candidate_add.php" method="post">
          <div class="insert-sec">
            <div class="element">
              <label for="username">ID</label>
              <input type="text" name="username">
            </div>
            <div class="element">
              <label for="name">Name</label>
              <input type="text" name="name">
            </div>
            <div class="element">
              <label for="password">Password</label>
              <input type="text" name="password">
            </div>
          </div>
          <input type="hidden" name="token" value="<?php echo Token::generate();?>">
          <div class="btn-insert">
            <button type="submit" name="Save" class="btn btn-primary btn-lg">Save</button>
          </div>
        </form>
      </div>
    </div>
    <!--Footer-->
    <?php include_layout_template('footer.php'); ?>
  </body>
</html>
<?php } else { Redirect::locate('index.php'); } ?>
