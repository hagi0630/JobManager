<?php
// ログイン確認。Login.htmlよりPOST
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
    // IDが無い
    if(empty($member)){
        $msg = '存在しないユーザーＩＤです';
        $link = '<a href="login.html">戻る</a>';
        ?>
        <h1><?php echo $msg; ?></h1>
        <?php echo $link;        

    }
    // IDとパスワードが一致
    else if ($_POST['pwd'] == $member['pwd']) {
        // DBのユーザー情報をセッションに保存
        $_SESSION['user_id'] = $member['id'];
        $msg = 'ログインしました。';
        $link = '<a href="AllCompany.php">ホーム</a>';
        header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/AllCompany.php');

    } 
    // IDはあるがパスワードが不一致
    else {
        $msg = 'ユーザーIDもしくはパスワードが間違っています。';
        $link = '<a href="login.html">戻る</a>';
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