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
    <title>Admin Panel | Candidate</title>
  </head>
  <body class="container-fluid">
    <!--TopNav-->
    <?php include_layout_template('top_nav.php'); ?>
    <div class="row">
      <div class="col-xs-3">
        <ul class="nav nav-pills nav-stacked navbar-fixed">
          <li><a href="candidate_view.php">View</a></li>
          <li><a href="candidate_add.php">Add</a></li>
        </ul>
      </div>
      <div class="col-xs-9">
        <div class="tbl">
          <table>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Result</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
              <?php
              $table = '`candidate`';
              $select = array('`id`', '`name`', '`username`');
              $fields = implode(",",$select);
              $cd = Database::getInstance()->Query("SELECT {$fields} FROM {$table} ORDER BY 1 DESC LIMIT 0,20");
              if($cd->count()) {
                  try {
                        foreach($cd->result() as $cd) {
               ?>
              <tr>
                <td><?php echo $cd->username; ?></td>
                <td><?php echo $cd->name; ?></td>
                <?php
                $result = Database::getInstance()->Query("SELECT `mark` FROM `result` WHERE `username` = '$cd->username'");
                $mark;
                if($result->count()) {
                  try {
                    foreach ($result->result() as $result) {
                      $mark = $result->mark;
                    }
                  } catch (Exception $ex) {die($ex);}
                }
                 ?>
                <td><?php
                  if (!empty($mark) || $mark === "0") { echo $mark; } else { echo "No Result"; }
                ?></td>
                <td><a href="candidate_edit.php?edit=<?php echo $cd->id;?>" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-edit"></span></a></td>
                <td><a href="remove.php?del_c=<?php echo $cd->id;?>" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span></a></td>
              </tr>
            <?php } } catch (Exception $ex) {die($ex);} } ?>
          </table>
        </div>
      </div>
    </div>
    <!--Footer-->
    <?php include_layout_template('footer.php'); ?>
  </body>
</html>
<?php } else { Redirect::locate('index.php'); } ?>
