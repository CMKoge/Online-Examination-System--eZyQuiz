<?php
class Token {

  public static function generate() {
    return Session::set(Config::get('session/token_name'),md5(uniqid()));
  }

  public static function check($token) {
    $token_index = Config::get('session/token_name');

    if (Session::exists($token_index) && $token == Session::get($token_index)) {
      Session::destroy($token_index);
      return true;
    }
    return false;
  }

}
 ?>
