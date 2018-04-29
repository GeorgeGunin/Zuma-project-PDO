<?php
require_once 'app/helper.php';
mySessionStart('fakebook');

if (!isValidUser()) {
  header('location:signin.php');
  exit;
}
$pageTitle = 'Home Page';

spl_autoload_register(function($filename) {
  $file = "app/$filename.php";
  if (file_exists($file)) {
    require_once $file;
  }
});
$posts = Database::connect('fakebook')->getPosts();
?>

<?php include_once 'templates/header.php'; ?>
<main>
  <h1>Well come to BLOG</h1>
  <p>Here you can blog with other registered people !</p>
  <input type ="button" id="post-btn" value="+Add Post" onclick="window.location = 'add_blog.php'">

  <?php if ($posts): ?>
    <div class="posts-box">
      <?php foreach ($posts as $post): ?>
        <div class="box-post">
          <h3><?= str_replace("\n",'<br>',htmlentities( $post['title'])) ?></h3>
          <p><?= str_replace ("\n", "<br>",htmlentities($post['article'])) ?></p>
          <div class="btn-prd">
            <div>
              <p>posted by<b> <?= htmlentities($post['name']) ?></b>| Time: <?= $post['date'] ?></p>
            </div>
            <div class="link">
              <a href='delete_post.php?p_id=<?=$post['id']?>'>Delete Post</a> | <a href="edit_post.php?p_id=<?=$post['id']?>">Edit Post</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

</main>
<?php include_once 'templates/footer.php'; ?>