<?php
session_start();
require_once 'DbManager.php';
try {
  $db = connect();
  $user_id = $_POST['id'];
  $_SESSION['user_id'] = $user_id;
  $sql = 'INSERT INTO user(id,pwd)
  VALUES(:id, :pwd)';

  $stt = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
  $stt->execute(array(':id' => $_POST['id'],
                      ':pwd' => $_POST['pwd'],
                      ));
  $db = NULL;
} catch (PDOException $e) {
  exit("エラーが発生しました。{$e->getMessage()}");
}
header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/AllCompany.php');