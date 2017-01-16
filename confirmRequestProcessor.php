<?php 
require_once 'AndLib/AndCore.php';
session_start();
if (empty($_SESSION['user_id'])) {
	$isLogin = false;
	// header('Location:' . AndPath::getHost() . AndPath::getPath() . '/index.php');
} else{
	$isLogin = true;
}

$reference = $_GET['senderid'];
$delreference = $_GET['delsenderid'];
$owner = $_SESSION['user_id'];

// AndDevDebug::printNice(isset($reference));

// ---------------- handle database ------------------
$con = new AndDatabase();

if (isset($reference)) {

	$con->query("
		INSERT INTO `openpen`.`pen_friend` (`user_regist_id`, `friend`, `confirm`) 
		VALUES ('$owner', '$reference', '1')
		");

	$con->query("
		UPDATE `openpen`.`pen_friend` 
		SET `confirm`='1' 
		WHERE user_regist_id='$reference' AND friend='$owner'
		");

} elseif (isset($delreference)) {
	
	$con->query("
		DELETE FROM `openpen`.`pen_friend` 
		WHERE user_regist_id='$delreference' AND friend='$owner'
		");
}


$con->closeConnection();
// ---------------- handle database ------------------

header('Location:' . AndPath::getHost() . AndPath::getPath() . '/writer.php');
?>
