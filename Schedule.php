<!-- スケジュール一覧。期限が短い順に並べる。AllCompany.phpから飛べる -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule</title>
</head>
<body>
    <a href="AllCompany.php">一覧ページへ</a>

    <form method="POST" action='AddTask.php'>
        <p>
            会社名 <br />
            <input type="text" name="company_name" size="20" maxlength="20" />
        </p><p>
            タスク <br />
            <input type="text" name="task" size="20" maxlength="20"/>
        </p><p>
            期日 <br />
            <input type="date" name="due" />
            </p>
        <p>
            <input type="submit" value="タスク新規登録" />
    </p>
    </form>
<br>
<br>
<?php
session_start();

require_once "Dbmanager.php";
require_once "Escape.php";

$user_id = $_SESSION["user_id"];

try {
    $db = connect();
    $sql = "SELECT * 
            FROM company
            WHERE user_id = :user_id
            ORDER BY name ASC";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':user_id', $user_id);
    $stmt->execute();
    $due_array=[];
     foreach ($stmt as $row) {
        // タスク1、タスク2、タスク3は別々にarrayに入れて、それを期限順に並べる
        $add_array = [
             [
              "id" => $row["id"],
              "name" => $row["name"],
              "url" =>$row["url"],
              "mypage_id" => $row["mypage_id"],
              "mypage_pwd" => $row["pwd"],
              "task" => $row["task1"],
              "due" => $row["due1"],
              "task_number" => 1
            ],
         [
            "id" => $row["id"],
            "name" => $row["name"],
            "url" =>$row["url"],
            "mypage_id" => $row["mypage_id"],
            "mypage_pwd" => $row["pwd"],
            "task" => $row["task2"],
            "due" => $row["due2"],
            "task_number" => 2
        ],
         [
            "id" => $row["id"],
            "name" => $row["name"],
            "url" =>$row["url"],
            "mypage_id" => $row["mypage_id"],
            "mypage_pwd" => $row["pwd"],
            "task" => $row["task3"],
            "due" => $row["due3"],
            "task_number" => 3
        ]
            ];
            $due_array = array_merge($due_array,$add_array);
     }
// ソート
     array_multisort( array_map( "strtotime", array_column( $due_array, "due" ) ), SORT_ASC, $due_array ) ;

     ?>
       <table border="1">
    <tr>
        <th>企業名</th><th>マイページID</th><th>マイページパスワード</th><th>タスク</th><th>期限</th>
    </tr>

     <?php
     foreach ($due_array as $row_array) {
        // 期限が入っていない物はcontinue
        if ($row_array["due"]=="0000-00-00" or $row_array["due"]==NULL){
            continue;
        }
        ?>
        <!-- 一覧表示 -->
        <tr>
            <td><a href="<?php es($row_array["url"]); ?>" target="_blank"><?php es($row_array["name"]); ?></td>
            <td><?php print es($row_array["mypage_id"]); ?></td>
            <td><?php print es($row_array["mypage_pwd"]); ?></td>
            <td><?php print es($row_array["task"]); ?></td>
            <td><?php print es($row_array["due"]); ?></td>
            <form method="POST" action="Complete.php">
            <input type="hidden" name="id" value="<?php es($row_array["id"]); ?>">
            <input type="hidden" name="task" value="<?php es($row_array["task"]); ?>">
            <input type="hidden" name="due" value="<?php es($row_array["due"]); ?>">
            <input type="hidden" name="task_number" value="<?php es($row_array["task_number"]); ?>">
            <td><input type="submit" name="complete" value="完了"></td>
            </form>
        </tr>
<?php
     }

    $db = NULL;
} catch(PDOException $e) {
    die("エラーが発生しました:{$e->getMessage()}");
}
?>   
</body>
</html>
