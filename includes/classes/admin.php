<?php
class Admin {
  private $_db, $_data, $_sessionName, $_isLoggedIn, $_cookieName;
  private $_id;

  public function __construct($user = null) {
    $this->_db = Database::getInstance();
    $this->_sessionName = Config::get('session/session_name');
    $this->_cookieName = Config::get('remember/cookie_name');

    if (!$user) {
      if (Session::exists($this->_sessionName)) {
        $user = Session::get($this->_sessionName);

        if ($this->find($user)) {
          $this->_isLoggedIn = true;
        } else {
          $this->logout();
        }
      }
    } else {
      $this->find($user);
    }
  }

  public function create($table, $fields = array()) {
    if (!$this->_db->insert($table, $fields)) {
      throw new Exception("Error Occur While Creating Account");
    }
  }

  public function update($fields = array(), $id = null) {
    if (!$id && $this->isLoggedIn()) {
      $id = $this->data()->id;
    }

    if (!$this->_db->update('admin', $id, $fields)) {
      throw new Exception("Error Processing Update");
    }
  }

  // Find and Extract User
  public function find($user = null) {
    if($user) {
      $field = (is_numeric($user)) ? 'id' : 'username';
      $data = $this->_db->get('admin', array($field, '=', $user));
      if ($data->count()) {
        $this->_data = $data->first();
        return true;
      }
    }
    return false;
  }


  //Login
  public function login($username = null, $password = null) {
    if (!$username && !$password && $this->exists()) {
      Session::set($this->_sessionName, $this->data()->id);
    } else {
      $user = $this->find($username);

      if ($user) {
        if ($this->data()->password == Hash::make($password, $this->data()->salt)) {
          Session::set($this->_sessionName, $this->data()->id);
          return true;
        }
      }
    }
    return false;
  }

  public function logout() {
    $this->_db->delete('session', array('user_id', '=', $this->data()->id));
    Session::destroy($this->_sessionName);
    Cookie::destroy($this->_cookieName);
  }

  public function pull_id($user) {
    $admin = Database::getInstance()->get('`candidate`',array('`id`','=',$user));
    if(!$admin->count()) {
        throw new Exception("Error Processing Update");
      } else {
        try {
              foreach($usr->result() as $usr) {
                $this->_id = $usr->id;
              }
        } catch (Exaception $ex) {die($ex);}
      }
  }

  public function get_id($value='') {
    return $this->_id;
  }

  private function exists() {
    return (!empty($this->_data)) ? true: false;
  }

  public function data() {
    return $this->_data;
  }

  public function isLoggedIn() {
    return $this->_isLoggedIn;
  }

}
 ?>
