<?php
require_once '../includes/init.php';
$admin = new Admin();
if ($admin->isLoggedIn()) {
$exam = new Exam();
if (Input::exists()) {
    if(Token::check(Input::get('token'))) {
      $validate = new Validate();
      $validation = $validate->check($_POST, array(
        'sbj' => array(
          'required' => true
        ),
        'limit' => array(
          'required' => true
        )
      ));
      // Validate Submit Button
      if ($validation->passed()) {
        try {
          $exam->customize_exam(array(
            'subject' => Input::get('sbj'),
            'time' => Input::get('time'),
            'q_limit' => Input::get('limit')
          ));
          Redirect::locate('exam_customize.php');
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
    <title>Admin Panel | Exam</title>
  </head>
  <body class="container-fluid">
    <!--TopNav-->
    <?php include_layout_template('top_nav.php'); ?>
    <div class="row">
      <div class="col-xs-2">
      </div>
      <div class="col-xs-8">
        <form class="insert-form" action="exam_customize.php" method="post">
          <?php
          $exam->pull_exam();
          $id = $exam->get_id();
          $subject = $exam->get_subject();
          $time = $exam->get_time();
          $limit = $exam->get_limit();
           ?>
          <div class="insert-sec">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="element">
              <label for="sbj">Subject</label>
              <input type="text" name="sbj" value="<?php echo $subject; ?>">
            </div>
            <div class="element">
              <label for="time">Duration</label>
              <input type="number" name="time" min="1" value="<?php echo $time; ?>">
            </div>
            <div class="element">
              <label for="limit">Question Limit</label>
              <input type="number" name="limit" min="1" value="<?php echo $limit; ?>">
            </div>
          </div>
          <input type="hidden" name="token" value="<?php echo Token::generate();?>">
          <div class="btn-insert">
            <button type="submit" name="save" class="btn btn-primary btn-lg">Save</button>
          </div>
        </form>
      </div>
      <div class="col-xs-2">
      </div>
    </div>
    <!--Footer-->
    <?php include_layout_template('footer.php'); ?>
  </body>
</html>
<?php } else { Redirect::locate('index.php'); } ?>
