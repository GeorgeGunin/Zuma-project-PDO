<?php

class Database {

  const MYSQL_HOST = 'localhost';
  const MYSQL_CHARSET = 'utf8';
  const MYSQL_ADMIN = 'root';

  private  $_db;
  
  static private $_connected;

  private  function __construct($database) {
    
    $dbcon = "mysql:localhost=" . self::MYSQL_HOST . ';' . "dbname=" . $database . ';' . "charset=" . self::MYSQL_CHARSET;
    $this->_db = new PDO($dbcon, self::MYSQL_ADMIN, '');
    
  }
  
  public static  function getConnected($database){
    if(is_null(self::$_connected)){
      self::$_connected = new self($database);
    }
    return self::$_connected;
  }

  public  function checkUser($email, $password) {

    $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
    $query = $this->_db->prepare($sql);
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

  public function getPosts() {
    $sql = "SELECT p.*,u.name FROM posts p  JOIN  users u on u.id = p.user_id ORDER BY date DESC";

    $posts = $this->_db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $posts;
  }

  public  function getPost($p_id, $u_id) {

    $sql = "SELECT title,article FROM posts  WHERE id=? AND user_id=?";
    $query = $this->_db->prepare($sql);
    $res = $query->execute([$p_id, $u_id]);
    if ($res) {
      $post = $query->fetch();

      return $post;
    }
    return false;
  }

  public  function setPost( $user_id, $title, $article) {
    
    
    $sql = "INSERT INTO posts VALUES('',?,?,?,NOW())";
    $query = $this->_db->prepare($sql);
    
    $res = $query->execute([$user_id, $title, $article]);
    return $res;
    
  }
  
  public  function editPost($p_id, $user_id, $title, $article) {
    
    $sql = "UPDATE posts  set title=?, article=?, date=NOW() WHERE user_id = ? AND id = ?";
    $query = $this->_db->prepare($sql);
    
    $res = $query->execute([$title,$article, $user_id, $p_id]);
    return $res;
    }

  public  function deletePost($post_id, $user_id) {
    $sql = "DELETE FROM posts WHERE id = ? AND user_id = ?";
    $query = $this->_db->prepare($sql);
    $res = $query->execute([$post_id, $user_id]);
    if ($res) {
      return true;
    }
    return false;
  }

  public function addUser($name, $email, $password) {
    $password = password_hash($password, PASSWORD_BCRYPT);
    $sql = "INSERT INTO users VALUES('',?,?,?)";
    $query = $this->_db->prepare($sql);
    $res = $query->execute([$name, $email, $password]);
    if ($res) {
      $_SESSION['user_id'] = $this->_db->lastInsertID();
      $_SESSION['user_name'] = $name;
      $_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR'];
      $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
      return true;
    }
    return false;
  }

}
