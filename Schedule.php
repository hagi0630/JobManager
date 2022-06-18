<?php
session_start();

require_once "Dbmanager.php";
require_once "Escape.php";

$user_id = $_SESSION["user_id"];

