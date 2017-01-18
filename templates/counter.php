<?php

$friendNotif =  $con->queryObj("
	SELECT COUNT(friend) 
	AS friend 
	FROM `openpen`.`pen_friend` 
	WHERE friend = '$owner'
	AND confirm = '0' ");

$messagesNotif = $con->queryObj("
	SELECT COUNT(*)
	AS counter
	FROM `openpen`.`messages`
	WHERE `messages`.`reciever_id` = '$owner' AND `messages`.`is_read` = '0'
	");

$notifCount = $con->queryObj("
	SELECT COUNT(reciever) 
	AS counter 
	FROM `openpen`.`notifications_list` 
	WHERE reciever = '$owner' AND notif_status = '0'
	");

$friendNotif = $friendNotif[0];
$friendNotif = intval($friendNotif->friend);

$notifCount = $notifCount[0];
$notifCount = intval($notifCount->counter);

//retrieve numbers of messages notif
$messagesNotif = $messagesNotif[0]->counter;
$messagesNotif = intval($messagesNotif);

?>