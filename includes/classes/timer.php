<?php
class Timer {
  private $_db, $_sessionName, $_duration;

  public function __construct() {
    $this->_db = Database::getInstance();
  }

  public function pull_duration() {
    $time = $this->_db->get('exam',array('id','=','id'));
    if($time->count()) {
      try {
        foreach($time->result() as $time) {
          $this->_duration = $time->time;
        }
      } catch (Exception $ex) {
        throw new Exception("Error occur while process");
      }
    }
  }

  public function set_time() {
    Session::set('duration',$this->_duration);
    Session::set('start_time',date("Y-m-d H:i:s"));
    $end_time = date('Y-m-d H:i:s', strtotime('+'.Session::get('duration').'minutes', strtotime(Session::get('start_time'))));

    Session::set('end_time', $end_time);
  }

}
 ?>
