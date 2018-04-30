<?php

class Database {

  const MYSQL_HOST = 'localhost';
  const MYSQL_CHARSET = 'utf8';
  const MYSQL_ADMIN = 'root';

  private static $db;

  public static function connect($name) {

    $dbcon = "mysql:localhost=" . self::MYSQL_HOST . ';' . "dbname=" . $name . ';' . "charset=" . self::MYSQL_CHARSET;
    $db = new PDO($dbcon, self::MYSQL_ADMIN, '');
    self::$db = $db;

    return new self();
  }

  public static function checkUser($email, $password) {

    $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
    $query = self::$db->prepare($sql);
    $query->execute([$email]);
    $user = $query->fetch(PDO::FETCH_ASSOC);
    if ($user) {
      if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        return true;
      }
      return false;
    }
  }

  public static function getPosts() {
    $sql = "SELECT p.*,u.name FROM posts p  JOIN  users u on u.id = p.user_id ORDER BY date DESC";

    $posts = self::$db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $posts;
  }
  
  public static function getPost($p_id,$u_id){
    
    $sql = "SELECT title,article FROM posts  WHERE id=? AND user_id=?";
    $query = self::$db->prepare($sql);
    $res = $query->execute([$p_id,$u_id]);
    if($res){
      $post = $query->fetchAll(PDO::FETCH_ASSOC);
      echo '<pre>';
      print_r($post);
      echo '</pre>';
      return $post;
    }
    return false;
  }

  public static function setPost($user_id, $title, $article) {
    $sql = "INSERT INTO posts VALUES('',?,?,?,NOW())";
    $query = self::$db->prepare($sql);
    $res = $query->execute([$user_id, $title, $article]);
    if ($res) {
      header('location:blog.php');
    }
  }

  public static function deletePost($post_id, $user_id) {
    $sql = "DELETE FROM posts WHERE id = ? AND user_id = ?";
    $query = self::$db->prepare($sql);
    $res = $query->execute([$post_id, $user_id]);
    if ($res) {
      return true;
    }
    return false;
  }

  public static function addUser($name, $email, $password) {
    $password = password_hash($password,PASSWORD_BCRYPT);
    $sql = "INSERT INTO users VALUES('',?,?,?)" ;
    $query = self::$db->prepare($sql);
    $res = $query->execute([$name,$email,$password]);
    if($res){
    $_SESSION['user_id'] = self::$db->lastInsertID();
    $_SESSION['user_name'] = $name;
    $_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR'];
    $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
    return true;
  }
  return false;
  }
}
