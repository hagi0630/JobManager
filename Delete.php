<?php
// データベースから会社を削除する処理。AllCompany.phpからPOST
session_start();
require_once "Dbmanager.php";
require_once "Escape.php";

$user_id = $_SESSION["user_id"];

try {
    $db = connect();
    $company_name = $_POST["company_name"];
// 削除
    $sql = 'DELETE FROM company
            WHERE user_id=:user_id AND name=:company_name';

$stt = $db->prepare($sql);
$stt->execute(array(':user_id' => $user_id,
                    ':company_name' => $company_name
));  

}catch(PDOException $e) {
    die("エラーが発生しました:{$e->getMessage()}");
}

$db = NULL;

header('Location:http://'.$_SERVER["HTTP_HOST"].dirname($_SERVER['PHP_SELF']).'/AllCompany.php');