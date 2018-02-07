<?php
function output_message($message="") {
  if (!empty($message)) {
    echo "<p>{$message}</p>";
  } else {
    return "";
  }
}

function include_layout_template($template = '') {
  include SITE_ROOT.DS.'admin'.DS.'layouts'.DS.$template;
}

// Return Text
function escape_value($string) {
  return htmlentities($string, ENT_QUOTES, 'UTF-8');
}

// Attach  Display Name In Navbar
function display_username() {
  $user = New user();
  if ($user->isLoggedIn()) {
    return escape_value($user->data()->username);
  } else {
    echo "USER";
  }
}
 ?>
