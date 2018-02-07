<?php
require_once '../includes/init.php';
$admin = new Admin();
if ($admin->isLoggedIn()) {
$q_and_a = new QAndA();
if (Input::exists()) {
    if(Token::check(Input::get('token'))) {
      $validate = new Validate();
      $validation = $validate->check($_POST, array(
        'qus' => array(
          'required' => true
        ),
        'opt-a' => array(
          'required' => true
        ),
        'opt-b' => array(
          'required' => true
        ),
        'opt-c' => array(
          'required' => true
        ),
        'opt-d' => array(
          'required' => true
        ),
        'ans' => array(
          'required' => true,
          'max' => 1
        )
      ));
      // Validate Submit Button
      if ($validation->passed()) {
        try {
          $q_and_a->create(array(
            'question' => Input::get('qus'),
            'option_a' => Input::get('opt-a'),
            'option_b' => Input::get('opt-b'),
            'option_c' => Input::get('opt-c'),
            'option_d' => Input::get('opt-d'),
            'answer' => Input::get('ans')
          ));
          output_message("Successfully added a question");
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
        <form class="insert-form" action="question_add.php" method="post">
          <div class="insert-sec">
            <div class="element">
              <label for="qus">Question</label>
              <textarea name="qus" rows="5" cols="100"></textarea>
            </div>
            <div class="element">
              <label for="opt-a">Option A</label>
              <input type="text" name="opt-a">
            </div>
            <div class="element">
              <label for="opt-b">Option B</label>
              <input type="text" name="opt-b">
            </div>
            <div class="element">
              <label for="opt-c">Option C</label>
              <input type="text" name="opt-c">
            </div>
            <div class="element">
              <label for="opt-d">Option D:</label>
              <input type="text" name="opt-d">
            </div>
            <div class="element">
              <label for="ans">Answer</label>
              <input type="text" name="ans" style="text-transform:uppercase" placeholder="A/B/C/D">
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
