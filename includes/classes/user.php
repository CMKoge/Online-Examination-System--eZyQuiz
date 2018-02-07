<?php
class User {
  private $_db, $_data, $_sessionName, $_isLoggedIn, $_cookieName;

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

  // Find and Extract User
  public function find($user = null) {
    if($user) {
      $field = (is_numeric($user)) ? 'id' : 'username';
      $data = $this->_db->get('candidate', array($field, '=', $user));
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
