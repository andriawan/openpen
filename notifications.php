<?php 
require_once 'AndLib/AndCore.php';
session_start();
if (empty($_SESSION['user_id'])) {
	$isLogin = false;
	header('Location:' . AndPath::getHost() . AndPath::getPath() . '/index.php');
} else{
	$isLogin = true;
}

$form = $_GET;
$friendNotif = $form['friendNotif'];
$owner = $_SESSION['user_id'];

// ---------------- handle database ------------------
$con = new AndDatabase();

$notifCount = $con->queryObj("
	SELECT COUNT(reciever) 
	AS counter 
	FROM `openpen`.`notifications_list` 
	WHERE reciever = '$owner' AND notif_status = '0'
	");

$notif = $con->queryObj("
	SELECT *
	FROM `openpen`.`notifications_list`
	WHERE reciever = '$owner' AND notif_status = '0'
	");

$con->closeConnection();
// ---------------- handle database ------------------

AndDevDebug::printNice($notif);

?>

<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<meta charset="UTF-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
		<?php foreach ($notif as $value): ?>
			<p><?php echo $value->firstname . " " . $value->lastname; 
				if (intval($value->activity) == 1) {
					echo " writes messages";
				}elseif (intval($value->activity) == 2) {
					echo " proposes story in ";
				}elseif (intval($value->activity) == 3) {
					echo " interested in your story";
				}
				?>
				<a href="proposal.php?ref=<?php echo $value->object_id; ?>">your Story</a>				
			</p>

		<?php endforeach ?>

	</body>
</html>