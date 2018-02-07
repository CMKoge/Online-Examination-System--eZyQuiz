<?php
require_once '../includes/init.php';
$user = new User();
$cd = Database::getInstance()->get('`result`',array('`username`','=',display_username()));
if($user->isLoggedIn() && !$cd->count()) {
$timer = new Timer();
$timer->pull_duration();
$timer->set_time();

$exam = new Exam();
$exam->pull_exam();
$limit = $exam->get_limit();
$time = $exam->get_time();
if(Input::exists()) {
  try {
        $option = Input::get('opt');
        foreach($option as $question_id => $option_val) {
          $exam->examine($question_id,$option_val);
        }
    } catch (Exception $ex) {die();}
  if(Token::check(Input::get('token'))) {
    try {
      $table = '`result`';
      $select = array('`username`', '`mark`');
      $fields = implode(",",$select);
      $username = display_username();
      $answer = $exam->get_answer();

      $save_result = Database::getInstance()->Query("INSERT INTO $table($fields) VALUES ('$username','$answer')");

      if(!$save_result->count()) {
        throw new Exception("Error Occur While Creating Account");
      } else {
        Redirect::locate('report.php');
      }
    } catch (Exception $ex) {die($ex);}
  }
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Paper</title>
      <script type="text/javascript">
        // Load Timer
        setInterval(function() {
          var xmlhttp = new XMLHttpRequest();
          xmlhttp.open("GET", "response.php", false);
          xmlhttp.send(null);
          var timeText = xmlhttp.responseText;
          if (timeText != null) {
            document.getElementById('exam-time').innerHTML = timeText;
            if(timeText === "Time is out") {
              document.getElementById('submit').click();
              document.getElementById("frm-ppr").submit();
            }
          }
        },1000);
      </script>
  </head>
  <body class="container-fluid">
  <!--Navbar-->
  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
    <div class="navbar-brand cnd-detail">
      <label for="cnd-num">candidate ID:</label>
      <label id="cnd-num"><?php echo display_username(); ?></label>
    </div>
      <div class="navbar-brand navbar-right exam-detail">
        <section>
          <label for="qus-no">number of question:</label>
          <label id="qus-no"><?php echo $limit; ?></label>
        </section>
        <section>
          <label for="exam-time">time:</label>
          <time id="exam-time"></time>
        </section>
      </div>
    </div>
  </nav>
  <!--Paper-->
  <div class="row box">
    <div class="col-xs-12">
        <form action="index.php" method="post" id="frm-ppr">
          <?php
            $table = '`q&a`';
            $select = array('`id`', '`question`', '`option_a`', '`option_b`', '`option_c`', '`option_d`');
            $fields = implode(",",$select);

            $q_and_a = Database::getInstance()->Query("SELECT {$fields} FROM {$table} ORDER BY RAND() LIMIT 0,{$limit}");
              if($q_and_a->count()) {
                $i=1;
                do {
                  try {
                        foreach($q_and_a->result() as $q_and_a) {
          ?>
          <section class="single-question">
            <!--Display Question-->
            <div class="question-division">
              <span class="badge"><?php echo $i++ ; ?></span>
              <label class="qus"><?php echo $q_and_a->question; ?></label>
            </div>
            <!--Display Answer-->
            <div class="answer-division">
              <section class="radio">
                <b>a. </b><label><input type="radio" name="opt[<?php echo $q_and_a->id; ?>]" value="a"><?php echo $q_and_a->option_a; ?></label>
              </section>
              <section class="radio">
                <b>b. </b><label><input type="radio" name="opt[<?php echo $q_and_a->id; ?>]" value="b"><?php echo $q_and_a->option_b; ?></label>
              </section>
              <section class="radio">
                <b>c. </b><label><input type="radio" name="opt[<?php echo $q_and_a->id; ?>]" value="c"><?php echo $q_and_a->option_c; ?></label>
              </section>
              <section class="radio">
                <b>d. </b><label><input type="radio" name="opt[<?php echo $q_and_a->id; ?>]" value="d"><?php echo $q_and_a->option_d; ?></label>
              </section>
            </div>
          </section>
        <?php } } catch (Exception $ex) {die();} } while ($i <= $limit); } ?>
          <section id="btn-holder">
            <input type="hidden" name="token" value="<?php echo Token::generate();?>">
            <button type="submit" name="submit" class="btn btn-primary" id="submit">submit</button>
          </section>
        </form>
    </div>
  </div>
  <footer>
    eZyQuiz online examination system is a free to use, open source.<br>
    eZyQuiz online examination system created by CHARUNA MADUBASHA KOTWALAGEDARA
  </footer>
  </body>
  <!--Bootstrap-->
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <!--JQuery-->
  <script src="../js/jquery-3.2.1.js"></script>
</html>
<?php
}else {Redirect::locate('login.php');}
 ?>
