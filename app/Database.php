<?php

class Database{
 
  const MYSQL_HOST = 'localhost';
  const MYSQL_CHARSET = 'utf8';
  const MYSQL_ADMIN = 'root';
  private static $db;
 
  
  public static function connect($name){
  
    $dbcon = "mysql:localhost=".self::MYSQL_HOST.';'."dbname=".$name.';'."charset=".self::MYSQL_CHARSET;
    $db = new PDO($dbcon, self::MYSQL_ADMIN,'');
    self::$db = $db;
    return new self();
  }
  
  public static function checkUser($email,$password){
    
    $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
    $query = self::$db->prepare($sql);
    $query->execute([$email]);
    $user = $query->fetch(PDO::FETCH_ASSOC);
    if($user){ 
      if(password_verify($password,$user['password'])){
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        return true;
      }
      return false;
    }
    
  }
  
  public static function getPosts(){
    $sql = "SELECT * ,u.name FROM posts p JOIN users  u on p.user_id = u.id ORDER BY date DESC";
    
    $posts = self::$db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $posts;
  }
  
  public static function setPost($user_id,$title,$article){
    $sql = "INSERT INTO posts VALUES('',?,?,?,NOW())";
    $query = self::$db->prepare($sql);
    $res = $query->execute([$user_id,$title,$article]);
    if($res){
      header('location:blog.php');
    }
  } 
}

