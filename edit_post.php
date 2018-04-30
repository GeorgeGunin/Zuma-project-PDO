<?php
require_once 'app/helper.php';
mySessionStart('fakebook');
if (!isValidUser()) {
  header('location:signin.php');
  exit;
}

$error='';

if (isset($_GET['p_id']) && isset($_GET['u_id'])) {
  $p_id = filter_input(INPUT_GET, 'p_id', FILTER_SANITIZE_STRING);
  $p_id = trim($p_id);
  $u_id = filter_input(INPUT_GET, 'u_id', FILTER_SANITIZE_STRING);
  $u_id = trim($u_id);
  
  if (is_numeric($p_id) && is_numeric($u_id)) {
    if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $u_id) {
      echo $_SESSION['user_id'];
      $res = Database::getPost($p_id, $u_id);
      
    }
  }
}
if (isset($_POST['submit'])) {
    
  }
  ?>

  <?php include_once 'templates/header.php'; ?>
  <main>
    <h1>Edit your Post?</h1>
    <form method="POST" action="">

      <label for="title">Title:</label><br>
      <input type="text" name="title" id="title" value="<?= $res['title'] ?>" size="50"><br>
      <label for="article">Article:</label><br>
      <textarea id="article" name="article" rows="12" cols="51"><?= $res['article'] ?></textarea><br><br>
      

      <span class="error"><?= $error ?></span>


      <input type="button" value='Cancel' onclick="window.location = 'blog.php'"> <input type='submit' name='submit' value='Edit'>
    </form>
  </main>
  <?php include_once 'templates/footer.php'; ?>