<?php
class Database {
  private static $_instance = null;
  private $_pdo, $_query, $_error = false, $_result, $_count = 0;

  private function __construct() {
    try {
      $this->_pdo = new PDO('mysql::host=' . Config::get('mysql/host') . ';dbname=' . Config::get('mysql/db'),Config::get('mysql/username'),Config::get('mysql/password'));
    } catch (PDOException $ex) {
        die($ex->getMessage());
    }
  }

  # Get Instance Database
  public static function getInstance() {
    if(!isset(self::$_instance)) {
      self::$_instance = new Database();
    }
    return self::$_instance;
  }

  # Execute Query
  public function query($sql, $params = array()) {
    $this->_error = false;
    if ($this->_query = $this->_pdo->prepare($sql)) {
      $pos = 1;
      if (count($params)) {
        foreach ($params as $param) {
          $this->_query->bindValue($pos, $param);
          $pos++;
        }
      }
      if ($this->_query->execute()) {
        $this->_result = $this->_query->fetchAll(PDO::FETCH_OBJ);
        $this->_count = $this->_query->rowCount();
      } else {
        $this->_error = true;
      }
    }
    return $this;
  }

  public function action($action, $table, $where = array()) {
    if (count($where) === 3) {
      $operators = array('=','>','<','>=','<=');
      $field    = $where[0];
      $operator = $where[1];
      $value    = $where[2];
      if (in_array($operator, $operators)) {
        $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
        if (!$this->query($sql, array($value))->error()) {
          return $this;
        }
      }
    }
    return false;
  }

  public function insert($table, $field = array()) {
    if (count($field)) {
      $keys = array_keys($field);
      $value = '';
      $pos = 1;
      foreach ($field as $fields) {
        $value .= '?';
        if ($pos < count($field)) {
          $value .= ', ';
        }
        $pos ++;
      }
      $sql = "INSERT INTO {$table} (`" . implode('`, `',$keys). "`) VALUES ({$value})";
      if (!$this->query($sql, $field)->error()) {
        return true;
      }
    }
    return false;
  }

  public function update($table, $id, $field = array()) {
    if (count($field)) {
      $keys = array_keys($field);
      $set = '';
      $pos = 1;
      foreach ($field as $name => $value) {
        $set .= "{$name} = ?";
        if ($pos < count($field)) {
          $set .= ', ';
        }
        $pos ++;
      }
      $sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";
      if (!$this->query($sql, $field)->error()) {
        return true;
      }
    }
    return false;
  }

  public function delete($table, $where) {
    return $this->action('DELETE', $table, $where);
  }

  public function get($table, $where) {
    return $this->action('SELECT *', $table, $where);
  }

  public function result() {
    return $this->_result;
  }

  public function first() {
    return $this->result()[0];
  }

  # Check Field Avalability
  public function count($value='') {
    return $this->_count;
  }

  public function error() {
    return $this->_error;
  }

}

 ?>
