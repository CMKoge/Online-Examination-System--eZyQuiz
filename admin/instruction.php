<?php
require_once '../includes/init.php';
$admin = new Admin();
if ($admin->isLoggedIn()) {
 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel | Instructions</title>
  </head>
  <body class="container-fluid">
    <!--TopNav-->
    <?php include_layout_template('top_nav.php'); ?>
    <div class="row">
      <div class="col-xs-1">
      </div>
      <div class="col-xs-10">
        <div class="jumbotron">
          <h1>Before You Start</h1>

      </div>
        <div class="alert alert-info">
          <strong><span class="label label-primary">1</span></strong> Use <b>alphanumeric</b> word as candidate <i><b>username(Candidate ID)</b></i>.<br><br>
          <strong><span class="label label-primary">2</span></strong> <b>Minimum</b> length for <i><b>username</b></i> is 2 characters and <b>Maximum</b> length for <i><b>username</b></i> is 10 characters.<br><br>
          <strong><span class="label label-primary">3</span></strong> <b>Minimum</b> length for <i><b>password</b></i> is 4 characters.<br><br>
          <strong><span class="label label-primary">4</span></strong> Insert exam duration in <b>minitues</b>.<br>
        </div>
      </div>
      <div class="col-xs-1">
      </div>
    </div>
    <!--Footer-->
    <?php include_layout_template('footer.php'); ?>
  </body>
</html>
<?php } else { Redirect::locate('index.php'); } ?>
