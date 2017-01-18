<?php 
require_once 'AndLib/AndCore.php';
session_start();
if (empty($_SESSION['user_id'])) {
	$isLogin = false;
	header('Location:' . AndPath::getHost() . AndPath::getPath() . '/index.php');
} else{
	$isLogin = true;
}

// jika kamu pertama kali login, kamu akan di direct untuk menyelesaikan landing page
if ($_SESSION['firstTime'] == 1) {
	header('Location:' . AndPath::getHost() . AndPath::getPath() . '/landing.php');
}

$owner = $_SESSION['user_id'];

// ---------------- handle database ------------------
$con = new AndDatabase();

$list = $con->queryObj("
	SELECT * 
	FROM `openpen`.`user` 
	WHERE `user`.`regist_id` 
	IN 
		(SELECT user_regist_id 
		FROM `openpen`.`pen_friend` 
		WHERE friend = '$owner' AND confirm = '0')");

$friendCount =  $con->queryObj("
	SELECT COUNT(friend) 
	AS lfriend 
	FROM `openpen`.`pen_friend` WHERE friend = '$owner' AND confirm = '1'");

$friendList = $con->queryObj("
	SELECT * 
	FROM `openpen`.`user` 
	WHERE `user`.`regist_id` 
	IN 
		(SELECT user_regist_id 
		FROM `openpen`.`pen_friend` 
		WHERE friend = '$owner' AND confirm = '1')
	");

require_once 'templates/counter.php';

$con->closeConnection();
// ---------------- handle database ------------------

$friendCount = $friendCount[0];
$friendCount = intval($friendCount->lfriend);

AndDevDebug::printNice($friendNotif);

?>

<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<meta charset="UTF-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
		
		<!-- navigation section -->
		<?php require_once 'templates/nav-header.php'; ?>
		<!-- navigation section -->	
		
		<h1>You have <?php echo $friendNotif; ?> partner request from:</h1>
		<?php 
			foreach ($list as $value) {
				echo $value->firstname . " " . $value->lastname . "<br>";
				echo $value->pen_name . "<br>";
				echo "<a href='confirmRequestProcessor.php?senderid=" .$value->regist_id. "'>add as partner</a><br>";
				echo "<a href='confirmRequestProcessor.php?delsenderid=" .$value->regist_id. "'>cancel</a>";
			}

		?>

		<h1>You have <?php echo $friendCount ?> Partner(s)</h1>
		<?php 
			foreach ($friendList as $flist) {

				echo "<a href='profile.php?regist_id=" . $flist->regist_id . "''>" . $flist->firstname . " " . $flist->lastname . "</a><br>";
				echo $flist->pen_name . "<br><br>";
			}

		?>


	</body>
</html>