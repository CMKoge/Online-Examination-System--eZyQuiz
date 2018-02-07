<?php
session_start();
$from_time = date('Y-m-d H:i:s');
$to_time = $_SESSION["end_time"];

$time_first = strtotime($from_time);
$time_second = strtotime($to_time);

$diffrence = $time_second - $time_first;
if($diffrence < 0) {
  echo ("Time is out");
} else {
  echo gmdate("H:i:s", $diffrence);
}
 ?>
