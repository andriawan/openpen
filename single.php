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

$ref = $_GET['ref'];

// ---------------- handle database ------------------
$con = new AndDatabase();
//query from table user
$single = $con->queryObj("
	SELECT * 
	FROM `openpen`.`act_writing`
	WHERE `act_writing`.`writing_id` = '$ref' 
	");

$con->closeConnection();
// ---------------- handle database ------------------

AndDevDebug::printNice($single);

?>