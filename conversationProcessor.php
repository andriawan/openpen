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
$form = $_POST;
$recieverId = $form['reciever_id'];
$messages = $form['reply'];
$time = $timeNow = date("Y-m-d H:i:s", time());
$isRead = 0;
$reply =AndSecurityGuard::defendInput($_POST['reply']);
$unreadCounter = 1;

// ---------------- handle database ------------------

$con = new AndDatabase();

$messagesFeed = $con->queryObj("
	INSERT INTO `openpen`.`messages` (`sender_id`, `reciever_id`, `message_subject`, `date_created`, `is_read` , `counter_unread`)
	VALUES ('$owner', '$recieverId', '$messages', '$time', '$isRead' , '$unreadCounter')
	");

$hasRead = $con->queryObj("
	UPDATE `openpen`.`messages` 
	SET `is_read`='1' WHERE `messages`.`sender_id` ='$recieverId' AND `messages`.`reciever_id` = '$owner' ;
	");

$con->closeConnection();

if ($messagesFeed == 1) {
	$_SESSION['message_sent'] = "Pesan berhasil dikirim";
	header('Location:' . AndPath::getHost() . AndPath::getPath() . '/conversation.php?ref=' . $recieverId);
}

AndDevDebug::printNice($form);

?>
