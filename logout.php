<?php
require_once 'app/helper.php';
  mySessionStart('fakebook');
  session_destroy();
  header('location:signin.php');

