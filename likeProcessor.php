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
$reciever = $_GET['trigger'];
$uref = $_GET['uref'];
$ureciever = $_GET['utrigger'];
AndDevDebug::printNice($_GET);
$timeNow = date("Y-m-d H:i:s", time());

// ---------------- handle database ------------------
$con = new AndDatabase();

if (isset($ref) && isset($reciever)) {

	$messagesFeed = $con->queryObj("
		INSERT INTO `openpen`.`like` (`writing_id`, `reciever`, `sender`, `counter`) 
		VALUES ('$ref', '$reciever', '$owner', '1')
	");

	if ($reciever == $owner) {
		echo NULL;
	}else{

	$broadcaster = $con->query("
		INSERT INTO `openpen`.`notifications` (`reciever`, `sender`, `activity`, `object_id`, `notif_created`, `notif_status`) 
		VALUES ('$reciever', '$owner', '3', '$ref', '$timeNow', '0')
		");
	}

	header('Location:' . AndPath::getHost() . AndPath::getPath() . '/profile.php?regist_id=' . $reciever );
}elseif (isset($uref) && isset($ureciever)) {
	
	$messagesFeed = $con->queryObj("
		DELETE FROM `openpen`.`like` WHERE `writing_id`='$uref' AND `sender`='$owner' ;
	");

	header('Location:' . AndPath::getHost() . AndPath::getPath() . '/profile.php?regist_id=' . $ureciever );

}

$con->closeConnection();

// ---------------- handle database ------------------