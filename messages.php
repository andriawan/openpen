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

$messagesFeed = $con->queryObj("
	SELECT *
	FROM `openpen`.`messages`
	WHERE `messages`.`reciever_id` = '$owner'
	");

$messagesList = $con->queryObj("
	SELECT DISTINCTROW sender_id, pen_name, firstname, lastname, is_read
	FROM `openpen`.`messages_list` WHERE `reciever_id`='$owner'
	ORDER BY `date_created` DESC
	");

$friendList = $con->queryObj("
	SELECT *
	FROM `openpen`.`friend_list`
	WHERE `friend_list`.`friend` = '$owner' and `friend_list`.`confirm` = '1'
	");

require_once 'templates/counter.php';

$con->closeConnection();

// ---------------- handle database ------------------

// $unique = array_unique($messagesList);

// AndDevDebug::printNice($messagesList);

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

		<h1>You have <?php echo $messagesNotif; ?> unread Message(s)</h1>
		<?php 
			foreach ($messagesList as $value) {
				if (intval($value->is_read == 0)){
					include 'templates/counterUnreadMessage.php';
					echo "<h2>(" . $counterUnread . " unread) " . $value->firstname . " " . $value->lastname . " (@" . $value->pen_name . ")</h2>";
					echo "<a href='conversation.php?ref=" . $value->sender_id . "'>See conversation</a>";
				} elseif (intval($value->is_read == 1)) {
					echo "<h2>" . $value->firstname . " " . $value->lastname . " (@" . $value->pen_name . ")</h2>";
					echo "<a href='conversation.php?ref=" . $value->sender_id . "'>See conversation</a>";
				}
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