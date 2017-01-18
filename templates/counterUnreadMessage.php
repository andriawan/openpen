<?php
session_start();
if (empty($_SESSION['user_id'])) {
	$isLogin = false;
	header('Location:' . AndPath::getHost() . AndPath::getPath() . '/index.php');
} else{
	$isLogin = true;
}

// ---------------- handle database ------------------

$con = new AndDatabase();

$counterUnread = $con->queryObj("
	SELECT SUM(counter_unread)
	AS counter
	FROM `openpen`.`messages_list`
	WHERE `messages_list`.`reciever_id` = '$owner' AND `messages_list`.`sender_id` = '$value->sender_id'
	");

$con->closeConnection();

$counterUnread = $counterUnread[0]->counter;

// ---------------- handle database ------------------

?>