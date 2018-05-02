<?php


$ms = [
    1 => 'Welcome back',
    2 => 'Congratulations you  signed up, enjoy !!!',
    3 => 'New Post is added',
    4 => 'Your post is updated',
    5 => 'Post is deleted'
];

spl_autoload_register(function($filename) {
  $file = "app/$filename.php";
  if (file_exists($file)) {
    require_once $file;
  }
});

$DB = Database::getConnected('fakebook');

if (!function_exists('old')) {

  function old($field) {
    return $_POST[$field] ?? '';
  }

}

if (!function_exists('token')) {

  function token() {
    $token = sha1('Zooma' . date("F j, Y, g:i a") . rand(1, 1000));
    $_SESSION['token'] = $token;
    return $token;
  }

}
if (!function_exists('mySessionStart')) {

  function mySessionStart($name = null) {
    if ($name != null) {
      session_name($name);
      session_start();
      session_regenerate_id();
    }
  }

}

if (!function_exists('isValidUser')) {

  function isValidUser() {
    if (isset($_SESSION['user_id']) && isset($_SESSION['user_agent']) && $_SESSION['user_agent'] == $_SERVER['HTTP_USER_AGENT']) {
      if (isset($_SESSION['user_ip']) && $_SESSION['user_ip'] == $_SERVER['REMOTE_ADDR']) {
        return true;
      }
    }
    return false;
  }

}