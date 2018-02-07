<?php
require '../includes/init.php';
if (Input::exists()) {
   if (Token::check(Input::get('token'))) {
     $validate = new Validate();
     $validataion = $validate->check($_POST, array(
       'usr' => array('required' => true),
       'password' => array('required' => true)
     ));
     if ($validataion->passed()) {
       $user = new User();
       $login = $user->login(Input::get('usr'), Input::get('password'));

       if ($login) {
         Redirect::locate('index.php');
       } else {
         echo "<script>alert('Failed')</script>";
       }
     } else {
       foreach ($validataion->errors() as $error) {
         echo $error."<br>";
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
    <title>Login</title>
  </head>
  <body class="container-fluid">
    <form class="form-inline login-form" action="login.php" method="post">
  <div class="form-group">
    <label for="usr">Candidate ID:</label>
    <input type="text" name="usr" class="form-control" id="usr" placeholder="Enter candidate ID">
  </div>
  <div class="form-group">
    <label for="pwd">Password:</label>
    <input type="password" name="password" class="form-control" id="pwd" placeholder="Enter password">
  </div>
  <input type="hidden" name="token" value="<?php echo Token::generate()?>">
  <button type="submit" class="btn btn-default">Submit</button>
</form>
<table align="center">
  <?php
  $exam = new Exam();
  $exam->pull_exam();
  $subject = $exam->get_subject();
  $time = $exam->get_time();
  $limit = $exam->get_limit();
   ?>
  <tr>
    <td><header>subject</header></td>
    <td><header><?php echo $subject; ?></header></td>
  </tr>
  <tr>
    <td><header>number of question</header></td>
    <td><header><?php echo $limit; ?></header></td>
  </tr>
  <tr>
    <td><header>time</header></td>
    <td><header><time><?php echo $time; ?></time><span>Minutes</span></header></td>
  </tr>
</table>
<footer>
  eZyQuiz online examination system is a free to use, open source.<br>
  eZyQuiz online examination system created by CHARUNA MADUBASHA KOTWALAGEDARA
</footer>
  </body>
</html>
