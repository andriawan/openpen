<?php 
require_once 'AndLib/AndCore.php';
session_start();
if (empty($_SESSION['user_id'])) {
	header('Location:' . AndPath::getHost() . AndPath::getPath() . '/index.php');
}

$reference = $_GET['reference'];
$owner = $_SESSION['user_id'];
AndDevDebug::printNice($reference);

// ---------------- handle database ------------------
$con = new AndDatabase();

$con->query("INSERT INTO `openpen`.`pen_friend` (`user_regist_id`, `friend`, `confirm`) VALUES ('$owner', '$reference', '0')");	

$con->closeConnection();
// ---------------- handle database ------------------

header('Location:' . AndPath::getHost() . AndPath::getPath() . '/profile.php?regist_id='. $reference);

?>