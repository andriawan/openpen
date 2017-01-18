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

$likeCounter = $con->queryObj("
	SELECT SUM(counter)
	AS counter
	FROM `openpen`.`like`
	WHERE `like`.`writing_id` = '$value->writing_id' 
	");

$isLike = $con->queryObj("
	SELECT COUNT(*)
	AS counter
	FROM `openpen`.`like`
	WHERE `like`.`writing_id` = '$value->writing_id' AND `like`.`sender` = $owner
	");

$con->closeConnection();

$likeCounter = $likeCounter[0]->counter;
$isLike = $isLike[0]->counter;

// ---------------- handle database ------------------

?>