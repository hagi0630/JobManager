<?php
require_once "DbManager.php";

session_start();
$user_id = $_SESSION["user_id"];


try{
    $db = connect();
    $sql = 'UPDATE company
            SET mypage_id = :mypage_id,
                pwd = :pwd,
                task1 = :task1,
                due1 = :due1,
                task2 = :task2,
                due2 = :due2,
                task3 = :task3,
                due3 = :due3
            WHERE id = :id';

    $stt = $db->prepare($sql,array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));

    for ($i=1;$i<=$_POST["cnt"];$i++){
        $stt->execute(array(':mypage_id' => $_POST['mypage_id_'.$i],
                            ':pwd'=> $_POST['mypage_pwd_'.$i],
                            ':task1' => $_POST["task1_".$i],
                            ':due1' => $_POST["due1_".$i],
                            ':task2' => $_POST["task2_".$i],
                            ':due2' => $_POST["due2_".$i],
                            ':task3' => $_POST["task3_".$i],
                            ':due3' => $_POST["due3_".$i],
                            ':id' => $_POST["id_".$i]
    ));
    }

} catch (PDOException $e){
    die("エラーが発生しました。:{$e->getMessage()}");
}

$db = NULL;

header('Location:http://'.$_SERVER["HTTP_HOST"].dirname($_SERVER['PHP_SELF']).'/AllCompany.php');