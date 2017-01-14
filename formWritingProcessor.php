<?php 
require_once 'AndLib/AndCore.php';
session_start();
if (empty($_SESSION['user_id'])) {
	header('Location:' . AndPath::getHost() . AndPath::getPath() . '/index.php');
}

//AndErrReport::enableErrorMessage();

$form = $_POST;
//extract array form and sanitize it
$userid = AndSecurityGuard::defendInput($form['userid']);
$activityid = 1;
$toc = AndSecurityGuard::defendInput($form['toc']);
$title = AndSecurityGuard::defendInput($form['title']);
$content = AndSecurityGuard::defendInput($form['content']);
$status = $form['status'];
$timeNow = date("Y-m-d H:i:s", time());

// ---------------- handle database ------------------
$con = new AndDatabase();

$result = $con->query("
	INSERT INTO `openpen`.`act_writing` (`user_regist_id`, `title`, `content`, `date_created`, `marathon_status`, `toc_status`, `activity_id`) 
	VALUES ('$userid', '$title', '$content', '$timeNow', '$status', '$toc', '$activityid')
	");

if ($result == 1) {
	header('Location:' . AndPath::getHost() . AndPath::getPath() . '/profile.php?regist_id=' . $userid);
}

$conection->closeConnection();
// ---------------- handle database ------------------

?>