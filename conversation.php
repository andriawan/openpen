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

$owner = AndSecurityGuard::defendInput($_SESSION['user_id']);

$ref = $_GET['ref'];

// ---------------- handle database ------------------
$con = new AndDatabase();

$hasRead = $con->queryObj("
	UPDATE `openpen`.`messages` 
	SET `is_read`='1', `counter_unread`='0' WHERE `messages`.`sender_id` ='$ref' AND `messages`.`reciever_id` = '$owner' ;
	");

$conversationList = $con->queryObj("
	SELECT *
	FROM `openpen`.`messages_list`
	WHERE `messages_list`.`sender_id` IN ('$ref',$owner) AND `messages_list`.`reciever_id` IN ('$owner','$ref')
	ORDER BY `messages_list`.`date_created` ASC
	");

require_once 'templates/counter.php';

$con->closeConnection();

// ---------------- handle database ------------------

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