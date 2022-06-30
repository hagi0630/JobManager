<?php
// データベースに接続。ユーザーネームとパスワードは変更必要
function connect(){
    $dsn = "mysql:dbname=job;host=localhost;charset=utf8";
    $usr = "root";
    $passwd = "*****";

    try{
    $db = new PDO($dsn,$usr,$passwd);
    } catch (PDOException $e){
        exit("データベースに接続できません.:{$e->getMessage()}");
    }
    return $db;
}
