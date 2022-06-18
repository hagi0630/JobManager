<?php
session_start();

require_once "Dbmanager.php";
require_once "Escape.php";

$db=connect();
$stt = $db->prepare('SELECT * FROM company');
$stt->execute();
$cnt=0;
while ($row=$stt->fetch(PDO::FETCH_ASSOC)){
    $cnt++;
}

$user_id = $_SESSION["user_id"];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = connect();
    $sql = 'INSERT INTO company VALUES(:id,:user_id, :name,:url,:mypage_id,:pwd,NULL,NULL,NULL,NULL,NULL,NULL)';
  
    $stt = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $stt->execute(array(':id' => $cnt,
                        ':user_id' => $user_id,
                        ':name' => $_POST['company_name'],
                        ':url' => $_POST["mypage_url"],
                        ':mypage_id' => $_POST['mypage_id'],
                        ':pwd' => $_POST["mypage_pwd"],
                        // ':task1' => $_POST["task1"],
                        // ':due1' => $_POST["due1"],                    
                        // ':task2' => $_POST["task2"],
                        // ':due2' => $_POST["due2"],                    
                        // ':task3' => $_POST["task3"],
                        // ':due3' => $_POST["due3"],                    
                        ));  
    $db = NULL;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>企業一覧</title>
</head>
<body>
    <a href = "Schedule.php">スケージュール画面へ</a>
    <form method="POST" action='AllCompany.php'>
        <p>
            <input type="hidden" name="id" value=<?php print $cnt; ?>>
        </p>
        <p>
            新規登録会社名 <br />
            <input type="text" name="company_name" size="20" maxlength="20" />
        </p><p>
            マイページURL <br />
            <input type="text" name="mypage_url" size="20" maxlength="100" style="width:500px"/>
        </p><p>
            マイページID <br />
            <input type="text" name="mypage_id" size="20" maxlength="20" />
            </p><p>
            マイページパスワード <br />
            <input type="text" name="mypage_pwd" size="20" maxlength="20" />
        <!-- <p>
            タスク1 <br />
            <input type="text" name="task1" size="20" maxlength="20" />
        </p><p>
            期限１ <br />
            <input type="date" name="due1" size="20" maxlength="20" />
        </p><p>
            タスク2 <br />
            <input type="text" name="task2" size="20" maxlength="20" />
        </p><p>
            期限2 <br />
            <input type="date" name="due2" size="20" maxlength="20" />
        </p><p>
            タスク3 <br />
            <input type="text" name="task3" size="20" maxlength="20" />
        </p><p>
            期限3 <br />
            <input type="date" name="due3" size="20" maxlength="20" />
        </p> -->
        
        <p>
            <input type="submit" value="新規登録" />
    </p>
    </form>
<br>
<br>
<br>

    <form method="POST" action="Refresh.php">
        <input type="submit" value="最新の状態に更新">
  <table border="1">
    <tr>
        <th></th><th>企業名</th><th>  マイページID  </th><th>マイページパスワード</th><th>タスク1</th><th>期限1</th><th>タスク2</th><th>期限2</th><th>タスク3</th><th>期限3</th>
    </tr>
    <?php
    try {
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
            ?>
        <tr>
        <td><input type="hidden" name="id_<?php print ($cnt); ?>"  value="<?php print es($row["id"]); ?>" /></td>
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
        //  //empty()関数でチェック
        // $mypage_id = @$_POST["mypage_id_".$cnt];
        // $mypage_pwd = @$_POST["mypage_pwd_".$cnt];
        // $task1 = @$_POST["task1_".$cnt];
        // $due1 = @$_POST["due1_".$cnt];
        // $task2 = @$_POST["task2_".$cnt];
        // $due2 = @$_POST["due2_".$cnt];
        // $task3 = @$_POST["task3_".$cnt];
        // $due3 = @$_POST["due3_".$cnt];

        // if (empty($mypage_id)) {
        //     @$_POST["mypage_id_".$cnt] = NULL;
        // }
        // if (empty($mypage_pwd)){
        //     @$_POST["mypage_pwd_".$cnt]=NULL;
        // }
        // if (empty($task1)){
        //     @$_POST["task1_".$cnt]=NULL;           
        // }
        // if (empty($due1)){
        //     @$_POST["due1_".$cnt] = NULL;
        // }
        // if (empty($task2)){
        //     @$_POST["task2_".$cnt]=NULL;           
        // }
        // if (empty($due2)){
        //     @$_POST["due2_".$cnt] = NULL;
        // }
        // if (empty($task3)){
        //     @$_POST["task3_".$cnt]=NULL;           
        // }
        // if (empty($due3)){
        //     @$_POST["due3_".$cnt] = NULL;
        // }
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