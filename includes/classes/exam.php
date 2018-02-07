<?php
class Exam {
  private $_db;
  private $_id, $_subject, $_time, $_limit;
  private $_answer;
  private $_result;

  public function __construct() {
    $this->_db = Database::getInstance();
  }

  public function pull_exam() {
    $exam = $this->_db->get('exam',array('id','=','id'));
    if($exam->count()) {
      try {
        foreach($exam->result() as $exam) {
          $this->_id = $exam->id;
          $this->_subject = $exam->subject;
          $this->_time = $exam->time;
          $this->_limit = $exam->q_limit;
        }
      } catch (Exception $ex) {
        throw new Exception("Error occur while customzing the exam");
      }
    }
  }

  public function pull_result($username) {
    $result = $this->_db->get('result',array('username','=',$username));
    if($result->count()) {
      try {
        foreach($result->result() as $result) {
          $this->_result = $result->mark;
        }
      } catch (Exception $ex) {
        throw new Exception("Error occur while customzing the exam");
      }
    }
  }

  public function examine($question,$option) {
    $answers = $this->_db->query("SELECT `answer` FROM `q&a` WHERE `id` = {$question}");
    if(!$answers->count()) {
      throw new Exception("Error Processing Request");
    } else {
      try {
        foreach ($answers->result() as $answer) {
          if($answer->answer === $option) {
            $this->_answer++;
          }
        }
      } catch (Exception $ex) {}
    }
  }



  private function finalize_result() {

  }

  public function customize_exam($fields=array()) {
    if (!$this->_db->update('exam', 'id', $fields)) {
      throw new Exception("Error occur while customzing the exam");
    }
  }

  public function get_id() {
    return $this->_id;
  }

  public function get_subject() {
    return $this->_subject;
  }

  public function get_time() {
    return $this->_time;
  }

  public function get_limit() {
    return $this->_limit;
  }

  public function get_answer() {
    return $this->_answer;
  }

  public function get_result() {
    return $this->_result;
  }

}
 ?>
