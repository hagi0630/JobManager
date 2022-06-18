<?php
session_start();
require_once 'DbManager.php';
//③データが渡ってきた場合の処理
try {
    $db = connect();
    $id = $_POST["id"];
    $pwd = $_POST["pwd"];
    $user_id = $id;
    $sql = 'SELECT * FROM user WHERE id = :id';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $member = $stmt->fetch();
    if ($_POST['pwd'] == $member['pwd']) {
        // DBのユーザー情報をセッションに保存
        $_SESSION['user_id'] = $member['id'];
        $msg = 'ログインしました。';
        $link = '<a href="AllCompany.php">ホーム</a>';
        header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/AllCompany.php');

    } else {
        $msg = 'メールアドレスもしくはパスワードが間違っています。';
        $link = '<a href="login.php">戻る</a>';
        ?>
        <h1><?php echo $msg; ?></h1>
        <?php echo $link;        
    }
    
$db = NULL;
} catch (PDOException $e) {
  exit("エラーが発生しました。{$e->getMessage()}");
  ?>
<h1><?php echo $msg; ?></h1>
<?php echo $link;
}