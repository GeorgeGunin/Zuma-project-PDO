<?php
require_once 'app/helper.php';
mySessionStart('fakebook');
if (!isValidUser()) {
  header('location:signin.php');
  exit;
}
$pageTitle = 'Edit post';
$error='';

if (isset($_GET['p_id']) && isset($_GET['u_id']) && $_GET['u_id'] == $_SESSION['user_id']) {
  $p_id = filter_input(INPUT_GET, 'p_id', FILTER_SANITIZE_STRING);
  $p_id = trim($p_id);
  $u_id = filter_input(INPUT_GET, 'u_id', FILTER_SANITIZE_STRING);
  $u_id = trim($u_id);
  
  if (is_numeric($p_id) && is_numeric($u_id) && $u_id == $_SESSION['user_id']) {
    if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $u_id) {
      $res = $DB->getPost($p_id, $u_id);
    }
        if(isset($_POST['submit'])){
          $title = filter_input(INPUT_POST,'title', FILTER_SANITIZE_STRING);
          $title = trim($title);
          $article = filter_input(INPUT_POST,'article', FILTER_SANITIZE_STRING);
          $article = trim($article);
          
          if(!$title){
            $error = '*Title is required';
          }
          else if(!$article){
            $error = '*Article is required';
          }
          else{
          $result = $DB->editPost($p_id, $u_id, $title, $article);
          
          if($result){
            header('location:blog.php?ms=4');
            exit;
          }
     
        }
        }
    
    }
  }
  else{
    header('location:blog.php');
    exit;
  }


  ?>

  <?php include_once 'templates/header.php'; ?>
  <main>
    <h1>Edit your Post?</h1>
    <form method="POST" action="">

      <label for="title">Title:</label><br>
      <input type="text" name="title" id="title" value="<?= str_replace("\n",'<br>',htmlentities($res['title'])) ?>" size="50"><br>
      <label for="article">Article:</label><br>
      <textarea id="article" name="article" rows="12" cols="51"><?= str_replace("\n",'<br>',htmlentities($res['article'])) ?></textarea><br><br>
      <input type="button" value='Cancel' onclick="window.location = 'blog.php'"> <input type='submit' name='submit' value='Edit'>
       <span class="error"><?= $error ?></span>
    </form>
  </main>
  <?php include_once 'templates/footer.php'; ?>