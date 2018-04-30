<?php
require_once 'app/helper.php';
mySessionStart('fakebook');

if (!isValidUser()) {
  header('location:signin.php');
  exit;
}
$pageTitle = 'Add Post';
$error='';

$posts = Database::connect('fakebook')->getPosts();

if(isset($_POST['submit'])){
  $article = filter_input(INPUT_POST,'article',FILTER_SANITIZE_STRING);
  $title = filter_input(INPUT_POST,'title',FILTER_SANITIZE_STRING);
  $article = trim($article);
  $title = trim($title);
  echo $article.' '.$title;
   if (!$title) {
  $error = '*Title is required';
}
  elseif(!$article){
    $error = '*Article is required';
  }
 
else{
  Database::setPost($_SESSION['user_id'],$title,$article);
}
}

?>

<?php include_once 'templates/header.php'; ?>
<main>
  <h1>Add your Post </h1>
  <p>Here you can add your post</p>
  <form method="POST" action="" >
    <label for="title">Title:</label><br>
    <input type="text" name="title" id="title" value="<?= old('title')?>" size="50"><br>
    <label for="article">Article:</label><br>
    <textarea id="article" name="article" rows="12" cols="51"><?= old('article')?></textarea><br><br>
    <input type="button" value="Cancel" onclick="window.location= 'blog.php'">
    <input type="submit" name="submit" value="Add post">
    <span class="error"><?=$error?></span>
  </form>
</main>
<?php include_once 'templates/footer.php'; ?>