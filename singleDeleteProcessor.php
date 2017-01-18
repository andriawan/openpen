<?php 
require_once 'AndLib/AndCore.php';
session_start();
if (empty($_SESSION['user_id'])) {
	$isLogin = false;
	header('Location:' . AndPath::getHost() . AndPath::getPath() . '/index.php');
} else{
	$isLogin = true;
}

$owner = $_SESSION['user_id'];

$ref = $_GET['ref'];

// ---------------- handle database ------------------
$con = new AndDatabase();
//query from table user
$single = $con->queryObj("
	DELETE FROM `openpen`.`act_writing` WHERE `writing_id`='$ref';
	");
$con->closeConnection();
// ---------------- handle database ------------------

if ($single == 1) {
	header('Location:' . AndPath::getHost() . AndPath::getPath() . '/profile.php?regist_id=' . $owner);
}