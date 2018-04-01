<?php

ini_set('error_reporting', ~E_NOTICE);

defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
defined('SITE_ROOT') ? null : define('SITE_ROOT', dirname(__DIR__));
defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT.DS.'includes');

session_start();

$GLOBALS['config'] = array(
  'mysql' => array(
    'host' => '127.0.0.1',
    'username' => '',
    'password' => '',
    'db' => 'ezyquiz',
  ),
  'remember' => array(
    'cookie_name' => 'hash',
    'cookie_expiry' => 604800,
  ),
  'session' => array(
    'session_name' => 'admin',
    'token_name' => 'token'
  ),
);
// Class Files
spl_autoload_register(function($class) {
  require_once LIB_PATH.DS.'classes'.DS.$class.'.php';
});

// General Files
require_once LIB_PATH.DS.'functions.php';
require_once LIB_PATH.DS.'general_link.php';

 ?>
