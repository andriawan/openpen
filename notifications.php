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

$notif = $con->queryObj("
	SELECT *
	FROM `openpen`.`notifications_list`
	WHERE reciever = '$owner'
	ORDER BY `notifications_list`.`notif_created` DESC
	");

require_once 'templates/counter.php';

$con->closeConnection();
// ---------------- handle database ------------------

// AndDevDebug::printNice($notif);

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

		<h1>Notifications</h1>

		<?php foreach ($notif as $value): ?>
			
			<?php if (intval($value->sender) == intval($owner)): ?>
				<?php echo null ?>
			<?php else: ?>
				<p><?php
					if (intval($value->notif_status == 0)) {
						echo "(unread) ";
					}
					echo $value->firstname . " " . $value->lastname; 
					if (intval($value->activity) == 1) {
						echo " wrote messages";
					}elseif (intval($value->activity) == 2) {
						echo " proposed story in ";
					}elseif (intval($value->activity) == 3) {
						echo " is interested in your story";
					}
				?>
				<a href="proposal.php?ref=<?php echo $value->object_id; ?>">your Story</a>
				<b> <?php 
						$dateRaw = AndTimeUtils::setDateToTimestamp($value->notif_created);
						$agoStyle = AndTimeUtils::getTimeAgoStyle($dateRaw);
						echo $agoStyle;

					?>					
				</b>				
			</p>

			<?php endif ?>

		<?php endforeach ?>

	</body>
</html>