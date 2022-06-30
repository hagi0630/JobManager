<?php
// companyデータベースに新しく追加するプログラム。AllCompany.phpよりPOST
session_start();
// pythonで言うimport
require_once "Dbmanager.php";
require_once "Escape.php";

// companyのデータベースで一番IDが大きいものを見つけ、それに１増やす。companyの新規insertで使う
$db=connect();
$stt = $db->prepare('SELECT * FROM company');
$stt->execute();
$max_id = 0;
while ($row=$stt->fetch(PDO::FETCH_ASSOC)){
    $max_id = max($max_id,$row["id"]);
}
$max_id++;

// セッション変数
$user_id = $_SESSION["user_id"];
try{
    if (!$_POST['company_name']==""){
// company新規登録
    $db = connect();
    $sql = 'INSERT INTO company VALUES(:id,:user_id, :name,:url,:mypage_id,:pwd,NULL,NULL,NULL,NULL,NULL,NULL)';
    $stt = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $stt->execute(array(':id' => $max_id,
                        ':user_id' => $user_id,
                        ':name' => $_POST['company_name'],
                        ':url' => $_POST["mypage_url"],
                        ':mypage_id' => $_POST['mypage_id'],
                        ':pwd' => $_POST["mypage_pwd"],
                        ));  
    $db = NULL;
                    }
} catch (PDOException $e){
    die("エラーが発生しました。:{$e->getMessage()}");
}


header('Location:http://'.$_SERVER["HTTP_HOST"].dirname($_SERVER['PHP_SELF']).'/AllCompany.php');