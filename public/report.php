<?php
require '../includes/init.php';
$user = new User();
if($user->isLoggedIn()) {
$exam = new Exam();
$exam->pull_exam();
$sbj = $exam->get_subject();
$limit = $exam->get_limit();

$username = display_username();
$exam->pull_result($username);
$result = $exam->get_result();
 ?>
<!DOCTYPE html>
<html>
  <script type="text/javascript">
  function printPage() {
    window.print();
  }
  </script>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Report | <?php echo display_username(); ?></title>
  </head>
  <body>
    <table class="report" align="center">
      <tr>
        <?php
          $name = Database::getInstance()->get('`candidate`',array('`username`','=',$username));
          if($name->count()) {
              try {
                    foreach($name->result() as $name) {
         ?>
        <td>candidate name</td>
        <td><?php echo $name->name; ?></td>
        <?php } } catch (Exception $ex) {die();} } ?>
      </tr>
      <tr>
        <td>candidate ID</td>
        <td><?php echo display_username(); ?></td>
      </tr>
      <tr>
        <td>subject</td>
        <td><?php echo $sbj; ?></td>
      </tr>
      <tr>
        <td>number of questions</td>
        <td><?php echo $limit; ?></td>
      </tr>
      <tr>
        <td>marks</td>
        <td><?php echo $result; ?></td>
      </tr>
    </table>
    <div id="btn-holder">
      <button onclick="printPage()" class="btn btn-default">Print</button>
    </div>
  </body>
  <footer><h4><a href="logout.php">Start a New Session</a></h4></footer>
</html>
<?php }else {Redirect::locate('login.php');} ?>
