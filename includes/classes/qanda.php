<?php
class QAndA {
  private $_db;

  public function __construct(){
      $this->_db = Database::getInstance();
  }

  public function create($fields=array()){
    if (!$this->_db->insert('`q&a`', $fields)) {
      throw new Exception("Error Occur While Adding Question");
    }
  }

  public function edit($id=null, $fields=array()){
    if (!$this->_db->update('`q&a`', $id, $fields)) {
      throw new Exception("Error Occur While Updating");
    }
  }

  public function remove($del) {
      if(!$this->_db->delete('`q&a`',array('`id`', '=', $del))) {
          Redirect::locate('question_view.php');
          throw new Exception("Error Occur While Removing Question");
      } else {
        Redirect::locate('question_view.php');
      }
    }

  }

 ?>
