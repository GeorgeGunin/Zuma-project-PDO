<?php
require_once 'app/helper.php';
mySessionStart('fakebook');
if (isValidUser()) {
  header('location:blog.php');
  exit;
}


$pageTitle = 'Sign up';
$error = ['email' => '', 'password' => '','confirm' => '','name' => '','confirm'=>''];
$ok = true;
if (isset($_POST['submit'])) {
  if (isset($_POST['token']) && isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token']) {

    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $name = trim($name);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $email = trim($email);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $password = trim($password);
    $cpassword = filter_input(INPUT_POST, 'cpassword', FILTER_SANITIZE_STRING);
    $cpassword = trim($cpassword);
    
    if(!$name || !preg_match('/[a-zA-Z]{2,20}/', $name)){
      $error['name']='*Please enter name 2-20 charachters';
      $ok=false;
    }
    if (!$email) {
      $error['email'] = '*Email is required';
      $ok=false;
    }
    if (!$password || strlen($password) < 5 || strlen($password) > 10) {
      $error['password'] = '*Password is required and must be 6-10 charachters';
      $ok=false;
    } 
    if($cpassword != $password){
      $error['confirm']='*Passwords are not same ';
      $ok=false;
    }
    else if($ok){
      $create = Database::connect('fakebook')->addUser($name,$email, $password);

      if ($create) {
        header('location:blog.php?ms=2');
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
  <h1> Here you can sign up</h1>
  <form method='POST' action="" novalidate="novalidate"><br>
    <label for='name'>Name:</label><br>
    <input type='text' id='name' name='name' value='<?= old('name') ?>'><br>
    <span class='error'><?= $error['name'] ?></span><br>
    
    <label for='email'>Email:</label><br>
    <input type='email' id='email' name='email' value='<?= old('email') ?>'><br>
    <span class='error'><?= $error['email'] ?></span><br>
    <input type="hidden" id='token' name="token" value='<?= $token; ?>'>
    <br>

    <label for='password'>Password:</label><br>
    <input type='password' id='password' name='password'><br>
    <span class='error'><?= $error['password'] ?></span><br>
    <label for='cpassword'>Password:</label><br>
    <input type='password' id='cpassword' name='cpassword'><br>
    <span class='error'><?= $error['confirm'] ?></span><br>
    <br>

    <input type='submit' name="submit" value="sign up">
  </form>
</main>
<?php include_once 'templates/footer.php'; ?>