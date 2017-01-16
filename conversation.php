<?php 
require_once 'AndLib/AndCore.php';
session_start();
if (empty($_SESSION['user_id'])) {
	$isLogin = false;
	header('Location:' . AndPath::getHost() . AndPath::getPath() . '/index.php');
} else{
	$isLogin = true;
}

$owner = AndSecurityGuard::defendInput($_SESSION['user_id']);

$ref = $_GET['ref'];

// ---------------- handle database ------------------
$con = new AndDatabase();

$hasRead = $con->queryObj("
	UPDATE `openpen`.`messages` 
	SET `is_read`='1' WHERE `messages`.`sender_id` ='$ref' AND `messages`.`reciever_id` = '$owner' ;
	");

$messagesNotif = $con->queryObj("
	SELECT COUNT(*)
	AS counter
	FROM `openpen`.`messages`
	WHERE `messages`.`reciever_id` = '$owner' AND `messages`.`is_read` = '0'
	");

$conversationList = $con->queryObj("
	SELECT *
	FROM `openpen`.`messages_list`
	WHERE `messages_list`.`sender_id` IN ('$ref',$owner) AND `messages_list`.`reciever_id` IN ('$owner','$ref')
	ORDER BY `messages_list`.`date_created` ASC
	");

$con->closeConnection();

// ---------------- handle database ------------------

$messagesNotif = $messagesNotif[0]->counter;
$messagesNotif = intval($messagesNotif);

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

		<?php 
			foreach ($conversationList as $value) {
				echo "<h2>" . $value->firstname . " " . $value->lastname . " (@" . $value->pen_name . ")</h2>";
				echo "<p>" . $value->message_subject . "</p>";
				echo "<h4>" . AndTimeUtils::getTimeAgoStyle(AndTimeUtils::setDateToTimestamp($value->date_created)) . "</h4>";
			}
		?>

		<form action="conversationProcessor.php" method="post" accept-charset="utf-8">
			<input type="hidden" name="reciever_id" value='<?php echo $ref; ?>'
			<br>
			<br>
			<label for="subject">Reply:</label>
			<br>
			<br>
			<textarea name="reply"></textarea>
			<br>
			<br>
			<input type="submit" value="Send message">

			
		</form>

	</body>
</html>