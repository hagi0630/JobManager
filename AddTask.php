<?php
// companyデータベースのtask,dueを追加するプログラム。Schedule.phpからPOST
session_start();

require_once "Dbmanager.php";
require_once "Escape.php";

$user_id = $_SESSION["user_id"];

try {
    $db = connect();
    $company_name = $_POST["company_name"];
    $task = $_POST["task"];
    $due = $_POST["due"];
// 目的の会社を見つける
    $sql = 'SELECT *
            FROM company
            WHERE user_id=:user_id AND name=:company_name';
    
    $stt = $db->prepare($sql);
    $stt->execute(array(':user_id' => $user_id,
                        ':company_name' => $company_name
    ));  
// １つに決まるのでforeachを使う必要はないが、そうでないやり方が分からないのでこう書いている。改良希望
    foreach ($stt as $row) {
        // task１に何もないときはtask1に追加
        if ($row["task1"]==NULL or $row["task1"]==""){
            $sql = 'UPDATE company
                    SET task1=:task,
                        due1=:due
                    WHERE user_id=:user_id AND name=:company_name';

            $stt = $db->prepare($sql);

            $stt->execute(array(':task' => $task,
            ':due' => $due,
            ':user_id' => $user_id,
            ':company_name' => $company_name
            ));   
        }
        // task2に何も無いときはtask2に追加
        else if ($row["task2"]==NULL or $row["task2"]==""){
            $sql = 'UPDATE company
                    SET task2=:task,
                        due2=:due
                    WHERE user_id=:user_id AND name=:company_name';

            $stt = $db->prepare($sql);

            $stt->execute(array(':task' => $task,
            ':due' => $due,
            ':user_id' => $user_id,
            ':company_name' => $company_name
            ));   

        }
        // task3に何もないときはtask3に追加
        else if ($row["task3"]==NULL or $row["task3"]==""){
            $sql = 'UPDATE company
                    SET task3=:task,
                        due3=:due
                    WHERE user_id=:user_id AND name=:company_name';

            $stt = $db->prepare($sql);

            $stt->execute(array(':task' => $task,
            ':due' => $due,
            ':user_id' => $user_id,
            ':company_name' => $company_name
            ));   

        }
        }
    





}catch(PDOException $e) {
    die("エラーが発生しました:{$e->getMessage()}");
}

$db = NULL;

header('Location:http://'.$_SERVER["HTTP_HOST"].dirname($_SERVER['PHP_SELF']).'/Schedule.php');