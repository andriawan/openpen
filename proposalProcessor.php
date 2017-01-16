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

$writing_id = $_POST['writing_id'];
$reciever_id = $_POST['reciever_id'];
$proposal = $_POST['proposal'];
$timeNow = date("Y-m-d H:i:s", time());

AndDevDebug::printNice($reciever_id);

// ---------------- handle database ------------------
$con = new AndDatabase();

$result = $con->query("
	INSERT INTO `openpen`.`act_marathon_prop` (`writing_id`, `user_proposer`, `prop_text`, `date_prop_created`, `prop_status`) 
	VALUES ('$writing_id', '$owner', '$proposal', '$timeNow', '0');

	");

$broadcaster = $con->query("INSERT INTO `openpen`.`notifications` (`reciever`, `sender`, `activity`, `object_id`, `notif_created`, `notif_status`) 
	VALUES ('$reciever_id', '$owner', '2', '$writing_id', '$timeNow', '0')
	");

if ($result == 1 && $broadcaster == 1) {
	$_SESSION['proposal_sent'] = "Konsep Lanjutan Cerita berhasil dikirim";
	header('Location:' . AndPath::getHost() . AndPath::getPath() . '/proposal.php?ref=' . $writing_id);
}

$conection->closeConnection();
// ---------------- handle database ------------------

?>