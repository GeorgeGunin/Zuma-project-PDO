<?php
require_once 'app/helper.php';
mySessionStart('fakebook');
if (isValidUser()) {
  header('location:blog.php');
  exit;
}


$pageTitle = 'Sign in';
$error = ['email' => '', 'password' => ''];
if (isset($_POST['submit'])) {
  if (isset($_POST['token']) && isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token']) {

    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $email = trim($email);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $password = trim($password);

    if (!$email) {
      $error['email'] = '*Email is required';
    }
    if (!$password || strlen($password) < 5 || strlen($password) > 10) {
      $error['password'] = '*Password is required and must be 6-10 charachters';
    } else {
      $passed = $DB->checkUser($email, $password);

      if ($passed) {
        header('location:blog.php?ms=1');
        exit;
      } else {
        $error['password'] = '*Worng email and password combination';
      }
    }
  }
  $token = token();
} else {
  $token = token();
}
?>

<?php include_once 'templates/header.php'; ?>
<main>
  <h1> Here you can sign in</h1>
  <form method='POST' action="" novalidate="novalidate"><br>
    <label for='email'>Email:</label><br>
    <input type='email' id='email' name='email' value='<?= old('email') ?>'><br>
    <span class='error'><?= $error['email'] ?></span><br>
    <input type="hidden" id='token' name="token" value='<?= $token; ?>'>
    <br>

    <label for='password'>Password:</label><br>
    <input type='password' id='password' name='password'><br>
    <span class='error'><?= $error['password'] ?></span><br>
    <br>

    <input type='submit' name="submit" value="sign in">
  </form>
</main>
<?php include_once 'templates/footer.php'; ?>