<?php

require_once 'app/helper.php';
mySessionStart('fakebook');
if(!isValidUser()){
  header('location:signin.php'); 
  exit;
}
$pageTitle = 'Delete post';

if(isset($_GET['p_id']) && isset($_GET['u_id'])){
$p_id = filter_input(INPUT_GET,'p_id', FILTER_SANITIZE_STRING);
$p_id = trim($p_id);
$u_id = filter_input(INPUT_GET,'u_id', FILTER_SANITIZE_STRING);
$u_id = trim($u_id);

if(isset($_POST['submit'])){
if(is_numeric($p_id) && is_numeric($u_id)){
  if(isset($_SESSION['user_id']) && $_SESSION['user_id']==$u_id ){
  $res=Database::connect('fakebook')->deletePost($p_id,$u_id);
  if($res){
    header('location:blog.php?ms=5');
    exit;
  }
  header('location:blog.php');
  exit;
}
header('location:blog.php');
  exit;
}
}
}
?>

<?php include_once 'templates/header.php';?>
<main>
  <h1>Are you sure , you want to delete this post ?</h1>
  <form method="POST" action="">
    <input type="button" value='Cancel' onclick="window.location = 'blog.php'"> <input type='submit' name='submit' value='Delete'>
  </form>
</main>
<?php include_once 'templates/footer.php';?>