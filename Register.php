<?php
session_start();
require_once 'DbManager.php';
try {
  $db = connect();
  $user_id = $_POST['id'];
  $_SESSION['user_id'] = $user_id;

  $sql = 'SELECT *
          FROM user
          WHERE id=:id';

$stt = $db->prepare($sql);
$stt->execute(array(':id' => $user_id,
));  
if (empty($stt)){



  $sql = 'INSERT INTO user(id,pwd)
  VALUES(:id, :pwd)';

  $stt = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
  $stt->execute(array(':id' => $_POST['id'],
                      ':pwd' => $_POST['pwd'],
                      ));
                      header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/AllCompany.php');
                    }
else{
  $msg = '既に登録されたユーザーIDです。';
  $link = '<a href="UserRegist.html">戻る</a>';
  ?>
  <h1><?php echo $msg; ?></h1>
  <?php echo $link;        

}
  $db = NULL;

} catch (PDOException $e) {
  exit("エラーが発生しました。{$e->getMessage()}");
}
