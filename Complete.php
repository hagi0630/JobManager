<?php
// タスクの官僚が押されたときの処理。Schedule.phpからPOST
require_once "DbManager.php";

session_start();
$user_id = $_SESSION["user_id"];


try{
    // タスク1の完了が押されたとき。タスク2をタスク1に、タスク3をタスク2に移動
    $db = connect();
    if ($_POST["task_number"]=="1"){
    $sql = 'SELECT task2,due2,task3,due3
            FROM company
            WHERE id = :id' ;

    $stt = $db->prepare($sql);
    $stt->bindValue(':id', $_POST["id"]);
    $stt->execute();
// １つに決まるのでforeachを使う必要はないが、そうでないやり方が分からないのでこう書いている。改良希望
    foreach ($stt as $row) {
    $task2 = $row["task2"];
    $task3 = $row["task3"];
    $due2 = $row["due2"];
    $due3 = $row["due3"];
    }
    $sql = 'UPDATE company
            SET task1=:task2,
                task2=:task3,
                task3=NULL,
                due1=:due2,
                due2=:due3,
                due3=NULL
            WHERE id = :id';

    $stt = $db->prepare($sql);

    $stt->execute(array(':task2' => $task2,
    ':task3'=> $task3,
    ':due2' => $due2,
    ':due3' => $due3,
    ':id' => intval($_POST["id"])
    ));
    }
    // タスク2の完了が押されたとき。タスク3をタスク2に移動
    if ($_POST["task_number"]=="2"){
        $sql = 'SELECT task3,due3
        FROM company
        WHERE id = :id';

$stt = $db->prepare($sql);
$stt->bindValue(':id', $_POST["id"]);
$stt->execute();
// １つに決まるのでforeachを使う必要はないが、そうでないやり方が分からないのでこう書いている。改良希望
foreach ($stt as $row) {
    $task3 = $row["task3"];
    $due3 = $row["due3"];
}

$sql = 'UPDATE company
        SET task2=:task3,
            due2=:due3,
            task3=NULL,
            due3=NULL
        WHERE id = :id';

$stt = $db->prepare($sql);

$stt->execute(array(
':task3'=> $task3,
':due3' => $due3,
':id' => intval($_POST["id"])
));

    }
    // タスク3が押されたときの処理。タスク3を削除
    if ($_POST["task_number"]=="3"){
        $sql = 'UPDATE company
        SET task3=NULL,
            due3=NULL
        WHERE id = :id';

$stt = $db->prepare($sql,array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
$stt->bindValue(':id', $_POST["id"]);
$stt->execute();

    }



} catch (PDOException $e){
    die("エラーが発生しました。:{$e->getMessage()}");
}

$db = NULL;

header('Location:http://'.$_SERVER["HTTP_HOST"].dirname($_SERVER['PHP_SELF']).'/Schedule.php');