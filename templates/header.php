<?php
 
?>
<!DOCTYPE html>
<link href="css/style.css" rel="stylesheet" type="text/css"/>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Zooma | <?=$pageTitle?></title>
  
  </head>
  <body>
    <div class='wrapper'>
      <div class='ms-box'>
        <?php if(!empty($_GET['ms'])&& array_key_exists($_GET['ms'], $ms)):?>
        <p><?=$ms[$_GET['ms']]?></p>
        <?php endif;?>
      </div>
      <header>
        <nav>
          <ul>
            <li><a href="./">Zooma</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href='blog.php'>Blog</a></li>
            <?php if(!isset($_SESSION['user_id'])):?>
            <li><a href='signin.php'>Sign in</a></li>
            <li><a href='signup.php'>Sign up</a></li>
            <?php else:?>
            <li>Welcome back <?= htmlentities($_SESSION['user_name']);?></li>
            <li><a href="logout.php">Log out</a></li>
            <?php endif;?>
          </ul>
        </nav>
      </header>

