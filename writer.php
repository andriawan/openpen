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

$friendNotif =  $con->queryObj("
	SELECT COUNT(friend) 
	AS friend 
	FROM `openpen`.`pen_friend` WHERE friend = '$owner' AND confirm = '0'");

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

$messagesNotif = $con->queryObj("
	SELECT COUNT(*)
	AS counter
	FROM `openpen`.`messages`
	WHERE `messages`.`reciever_id` = '$owner' AND `messages`.`is_read` = '0'
	");

$con->closeConnection();
// ---------------- handle database ------------------

$friendNotif = $friendNotif[0];
$friendNotif = intval($friendNotif->friend);


$friendCount = $friendCount[0];
$friendCount = intval($friendCount->lfriend);

//retrieve numbers of messages notif
$messagesNotif = $messagesNotif[0]->counter;
$messagesNotif = intval($messagesNotif);

// AndDevDebug::printNice($friendList);

?>

<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<meta charset="UTF-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
		<nav>
			<ul>
				<li><a href="home.php">Home</a></li>
				<li><a href="profile.php?regist_id=<?php echo $owner; ?>">Profile</a></li>
				<?php 
					if ($isLogin) {
						if ($messagesNotif == 0) {
							echo "<li><a href='messages.php'>Messages</a></li>";
						} else{
							echo "<li><a href='messages.php'>Messages (" . $messagesNotif . ") </a></li>";
						}
					} 
				?>
				<li><a href="notifications.php">Notifications</a></li>
				<?php 
					if ($isLogin) {
						if ($friendNotif == 0) {
							echo "<li><a href='writer.php'>Writer</a></li>";
						} else{
							echo "<li><a href='writer.php'>Writer (" . $friendNotif . ") </a></li>";
						}
					} 
				?>
				<li><a href="writerSearch.php">Search your partner</a></li>
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</nav>
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