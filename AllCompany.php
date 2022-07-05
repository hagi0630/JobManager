<?php
require_once "Dbmanager.php";
        require_once "Escape.php";
        session_start();
        $user_id = $_SESSION["user_id"];
//次のID用にcompanyに登録しているmaxidを調べる
                $db = connect();
        $sql = "SELECT * 
                FROM company";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $cnt=0;

         foreach ($stmt as $row) {
            $cnt = max($cnt,$row["id"]);
         }

?>
<!-- 全ての企業を一覧表示する。 -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>企業一覧</title>
</head>
<body>
    <a href = "Schedule.php">スケージュール画面へ</a>
    <form method="POST" action='AddCompany.php'>
        <p>
            <input type="hidden" name="id" value=<?php print $cnt; ?>>
        </p>
        <p>
            新規登録会社名 
            <input type="text" name="company_name" size="20" maxlength="20" />
        </p><p>
            マイページURL 
            <input type="text" name="mypage_url" size="20" maxlength="100" style="width:500px"/>
        </p><p>
            マイページID 
            <input type="text" name="mypage_id" size="20" maxlength="20" />
            </p><p>
            マイページパスワード
            <input type="text" name="mypage_pwd" size="20" maxlength="20" />
        
        <p>
            <input type="submit" value="新規登録" />
    </p>
    </form>
<br>

<!-- 削除機能。できれば下の会社一覧の各会社の横に削除機能をつけたいが、全体をRefresh.phpに送るformにしてしまっているのでどうすればいいか不明 -->
<form method="POST" action="Delete.php">
削除したい企業名
<input type="text" name="company_name" size="20" maxlength="20" />

<input type="submit" value="削除" />
</form>

<br>
<br>
<!-- 「最新の状態に更新」でRefresh.phpに送る -->
    <form method="POST" action="Refresh.php">
        <input type="submit" value="最新の状態に更新">
    
  <table border="1">
    <tr>
        <th>企業名</th><th>  マイページID  </th><th>マイページパスワード</th><th>タスク1</th><th>期限1</th><th>タスク2</th><th>期限2</th><th>タスク3</th><th>期限3</th>
    </tr>
    <?php
    try {
        require_once "Dbmanager.php";
        require_once "Escape.php";
//         session_start();
        $user_id = $_SESSION["user_id"];
// そのユーザーが登録しているcompanyを持ってくる
        $db = connect();
        $sql = "SELECT * 
                FROM company
                WHERE user_id = :user_id
                ORDER BY name ASC";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':user_id', $user_id);
        $stmt->execute();
        $cnt=0;

         foreach ($stmt as $row) {
            $cnt++;
            // $cntで上から順番に番号振る。Refresh.phpで区別するため
            ?>
        <tr>
        <input type="hidden" name="id_<?php print ($cnt); ?>"  value="<?php print es($row["id"]); ?>" />
            <td><a href="<?php es($row["url"]); ?>" target="_blank"><?php es($row["name"]); ?></td>
            <td><input type="text" name="mypage_id_<?php print ($cnt); ?>" value="<?php print es($row["mypage_id"]); ?>" size=15/></td>
            <td><input type="text" name="mypage_pwd_<?php print ($cnt); ?>" value="<?php print es($row["pwd"]); ?>" size=15/></td>
            <td><input type="text" name="task1_<?php print ($cnt); ?>" value="<?php print es($row["task1"]); ?>" size=15/></td>
            <td><input type="date" name="due1_<?php print ($cnt); ?>" value="<?php print es($row["due1"]); ?>" /></td>
            <td><input type="text" name="task2_<?php print ($cnt); ?>" value="<?php print es($row["task2"]); ?>" size=15/></td>
            <td><input type="date" name="due2_<?php print ($cnt); ?>" value="<?php print es($row["due2"]); ?>" /></td>
            <td><input type="text" name="task3_<?php print ($cnt); ?>" value="<?php print es($row["task3"]); ?>" size=15 /></td>
            <td><input type="date" name="due3_<?php print ($cnt); ?>" value="<?php print es($row["due3"]); ?>" /></td>
            
        </tr>
        <?php
    }
        ?>
        <input type="hidden" name="cnt" value="<?php print $cnt; ?>" />
        </form>
<?php

 

        $db = NULL;
} catch(PDOException $e) {
    die("エラーが発生しました:{$e->getMessage()}");
}
?>
  </table>    
</body>
</html>
