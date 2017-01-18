<?php 
require_once 'AndLib/AndCore.php';
session_start();
if (empty($_SESSION['user_id'])) {
$isLogin = false;
	// header('Location:' . AndPath::getHost() . AndPath::getPath() . '/index.php');
} else{
	$isLogin = true;
}

$owner = $_SESSION['user_id'];
$form = $_POST;
$recieverId = $form['friendlist'];
$messages = $form['subject'];
$time = $timeNow = date("Y-m-d H:i:s", time());
$isRead = 0;
$unreadCounter = 1;

// ---------------- handle database ------------------
$con = new AndDatabase();

$messagesFeed = $con->queryObj("
	INSERT INTO `openpen`.`messages` (`sender_id`, `reciever_id`, `message_subject`, `date_created`, `is_read`, `counter_unread`)
	VALUES ('$owner', '$recieverId', '$messages', '$time', '$isRead', '$unreadCounter')
	");

$con->closeConnection();

// ---------------- handle database ------------------

AndDevDebug::printNice($messagesFeed);

if ($messagesFeed == 1) {
	$_SESSION['message_sent'] = "Pesan berhasil dikirim";
	header('Location:' . AndPath::getHost() . AndPath::getPath() . '/messages.php');
}

?>