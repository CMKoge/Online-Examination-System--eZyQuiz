<?php
require '../includes/init.php';
$admin = new Admin();
if ($admin->isLoggedIn()) {
 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel | Question</title>
  </head>
  <body class="container-fluid">
    <!--TopNav-->
    <?php include_layout_template('top_nav.php'); ?>
    <div class="row">
      <div class="col-xs-3">
        <ul class="nav nav-pills nav-stacked navbar-fixed">
          <li><a href="question_view.php">View</a></li>
          <li><a href="question_add.php">Add</a></li>
        </ul>
      </div>
      <div class="col-xs-9">
        <div class="tbl">
          <table>
            <tr>
              <th>Question</th>
              <th>Option A</th>
              <th>Option B</th>
              <th>Option C</th>
              <th>Option D</th>
              <th>Answer</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
              <?php
              $table = '`q&a`';
              $q_and_a = Database::getInstance()->Query("SELECT * FROM {$table} ORDER BY 1 DESC LIMIT 0,20");

              if($q_and_a->count()) {
                  try {
                        foreach($q_and_a->result() as $q_and_a) {
               ?>
              <tr>
                <td><?php echo $q_and_a->question; ?></td>
                <td><?php echo $q_and_a->option_a; ?></td>
                <td><?php echo $q_and_a->option_b; ?></td>
                <td><?php echo $q_and_a->option_c; ?></td>
                <td><?php echo $q_and_a->option_d; ?></td>
                <td style="text-transform:uppercase"><?php echo $q_and_a->answer; ?></td>
                <td><a href="question_edit.php?edit=<?php echo $q_and_a->id;?>" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-edit"></span></a></td>
                <td><a href="remove.php?del_q=<?php echo $q_and_a->id;?>" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span></a></td>
              </tr>
            <?php } } catch (Exception $ex) {die();} } ?>
          </table>
        </div>
      </div>
    </div>
    <!--Footer-->
    <?php include_layout_template('footer.php'); ?>
  </body>
</html>
<?php } else { Redirect::locate('index.php'); } ?>
