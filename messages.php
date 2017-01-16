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

$messagesNotif = $con->queryObj("
	SELECT COUNT(*)
	AS counter
	FROM `openpen`.`messages`
	WHERE `messages`.`reciever_id` = '$owner' AND `messages`.`is_read` = '0'
	");

$messagesFeed = $con->queryObj("
	SELECT *
	FROM `openpen`.`messages`
	WHERE `messages`.`reciever_id` = '$owner'
	");

$messagesList = $con->queryObj("
	SELECT DISTINCTROW sender_id, pen_name, firstname, lastname, date_created
	FROM openpen.messages_list where reciever_id='$owner'
	ORDER BY date_created DESC
	");

$friendList = $con->queryObj("
	SELECT *
	FROM `openpen`.`friend_list`
	WHERE `friend_list`.`friend` = '$owner' and `friend_list`.`confirm` = '1'
	");

$con->closeConnection();

// ---------------- handle database ------------------

$messagesNotif = $messagesNotif[0]->counter;
$messagesNotif = intval($messagesNotif);

// $unique = array_unique($messagesList);

// AndDevDebug::printNice($a);

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

		<h1>You have <?php echo $messagesNotif; ?> unread Message(s)</h1>
		<?php  
			foreach ($messagesList as $value) {
				echo "<h2>" . $value->firstname . " " . $value->lastname . " (@" . $value->pen_name . ")</h2>";
				echo "<a href='conversation.php?ref=" . $value->sender_id . "'>See conversation</a>";
			}
		?>

		<h1>Send Messages</h1>

		<?php  
		
			if (isset($_SESSION['message_sent'])) {
				echo '<h3>' . $_SESSION['message_sent'] . '</h3>';
				unset($_SESSION['message_sent']);
			}

		?>


		<form action="messageProcessor.php" method="post" accept-charset="utf-8">
			<label for="reciever">select your partner</label>
			<select name="friendlist" id="friendlist">
				<?php 
				foreach ($friendList as $value) {
						echo "<option value='" . $value->user_regist_id . "'>" . $value->pen_name . "</option>";
					}
				?>
				
			</select>
			<br>
			<br>
			<label for="subject">Subject:</label>
			<textarea name="subject"></textarea>
			<br>
			<br>
			<input type="submit" value="Send message">

			
		</form>

	</body>
</html>