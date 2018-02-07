<?php
class Session {
  public static function exists($name) {
    return (isset($_SESSION[$name])) ? true : false;
  }

  public static function get($name) {
    return $_SESSION[$name];
  }

  public static function set($name, $value) {
    return $_SESSION[$name] = $value;
  }

  public static function destroy($name) {
    if (self::exists($name)) {
      unset($_SESSION[$name]);
    }
  }

  public static function flash($name, $string = '') {
    if (self::exists($name)) {
      $session = self::get($name);
      self::destroy($name);
      return $session;
    } else {
      self::set($name, $string);
    }
  }

}
 ?>
