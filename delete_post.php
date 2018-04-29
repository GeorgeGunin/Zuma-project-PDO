<?php

require_once 'app/helper.php';
mySessionStart('fakebook');
if(!isValidUser()){
  header('location:signin.php'); 
  exit;
}

if(isset($_GET['p_id'])){
$p_id = filter_input(INPUT_GET,'p_id', FILTER_SANITIZE_STRING);
$p_id = trim($p_id);
echo $p_id;
if(isset($_POST['submit'])){
  
 
}
}
?>

<?php include 'templates/header.php';?>
<main>
  <h1>Are you sure , you want to delete this post ?</h1>
  <form>
    <input type="button" value='Cancel' onclick="window.location = 'blog.php'"> <input type='submit' name='submit' value='Delete'>
  </form>
</main>
<?php include'templates/footer.php';?>