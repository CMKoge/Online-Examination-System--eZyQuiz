<?php
class Candidate {
  private $_db;

  public function __construct(){
      $this->_db = Database::getInstance();
  }

  public function create($fields=array()){
    if (!$this->_db->insert('`candidate`', $fields)) {
      throw new Exception("Error Occur While Adding Candidate");
    }
  }

  public function edit($id=null, $fields=array()){
    if (!$this->_db->update('`candidate`', $id, $fields)) {
      throw new Exception("Error Occur While Updating");
    }
  }

  public function remove($del) {
      if(!$this->_db->delete('`candidate`',array('`id`', '=', $del))) {
          Redirect::locate('candidate_view.php');
          throw new Exception("Error Occur While Removing Candidate");
      } else {
        Redirect::locate('candidate_view.php');
      }
    }
}

 ?>
