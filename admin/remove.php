<?php
require_once '../includes/init.php';
$del_q = Input::get('del_q');
$del_c = Input::get('del_c');
if($del_q) {
  $q_and_a = new QandA();
  $q_and_a->remove($del_q);
}
if($del_c) {
  $cd = new Candidate();
  $cd->remove($del_c);
}
 ?>
