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
          'min' => 2,
          'max'=> 10
        ),
        'name' => array(
          'required' => true
        )
      ));
      // Validate Submit Button
      if ($validation->passed()) {
        $cd = new Candidate();
        try {
          $cd->edit(Input::get('id'),array(
            'name' => Input::get('name'),
            'username' => Input::get('username')
          ));
          Redirect::locate('candidate_view.php');
        } catch (Exception $ex) {
          die($ex);
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
    <?php //include_layout_template('top_nav.php'); ?>
    <div class="row">
      <div class="col-xs-3">
        <ul class="nav nav-pills nav-stacked navbar-fixed">
          <li><a href="candidate_view.php">View</a></li>
          <li><a href="candidate_add.php">Add</a></li>
        </ul>
      </div>
      <div class="col-xs-9">
        <form class="insert-form" action="candidate_edit.php" method="post">
          <?php
          $edit = Input::get('edit');
          $cd = Database::getInstance()->get('`candidate`',array('`id`','=',$edit));

          if($cd->count()) {
              try {
                    foreach($cd->result() as $cd) {
           ?>
          <div class="insert-sec">
            <input type="hidden" name="id" value="<?php echo $cd->id; ?>">
            <div class="element">
              <label for="username">ID:</label>
              <input type="text" name="username" value="<?php echo $cd->username; ?>">
            </div>
            <div class="element">
              <label for="name">Name:</label>
              <input type="text" name="name" value="<?php echo $cd->name; ?>">
            </div>
          </div>
          <?php } } catch (Exception $ex) {die();} } ?>
          <input type="hidden" name="token" value="<?php echo Token::generate();?>">
          <div class="btn-insert">
            <button type="submit" name="update" class="btn btn-primary btn-lg">Update</button>
          </div>
        </form>
      </div>
    </div>
    <!--Footer-->
    <?php include_layout_template('footer.php'); ?>
  </body>
</html>
<?php } else { Redirect::locate('index.php'); } ?>
