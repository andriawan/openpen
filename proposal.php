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

$ref = $_GET['ref'];

// ---------------- handle database ------------------
$con = new AndDatabase();
//query from table user
$single = $con->queryObj("
	SELECT * 
	FROM `openpen`.`all_user_post`
	WHERE `all_user_post`.`writing_id` = '$ref' 
	");

$allProposal = $con->queryObj("
	SELECT * FROM `openpen`.`proposal_list`
	WHERE `proposal_list`.`writing_id` = '$ref' AND `proposal_list`.`prop_status` = '0'
	");

$updateStatus = $con->queryObj("
	UPDATE `openpen`.`notifications` 
	SET `notif_status`='1' WHERE `object_id`='$ref' AND `reciever`='$owner'
	");

require_once 'templates/counter.php';

$con->closeConnection();
// ---------------- handle database ------------------
$single = $single[0];

if (intval($single) == 0) {
	$_SESSION['error_post_not_found'] = "postingan cerita tidak dapat ditemukan atau telah dihapus";
	header('Location:' . AndPath::getHost() . AndPath::getPath() . '/error.php');
}

// AndDevDebug::printNice($allProposal);

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $result[0]->firstname .' ' . $result[0]->lastname; ?></title>
	<link rel="stylesheet" href="">
</head>
<body>
	
	<!-- navigation section -->
	<?php require_once 'templates/nav-header.php'; ?>
	<!-- navigation section -->	

	<h1><?php echo $single->firstname . " " . $single->lastname ?></h1>
	<p><?php echo $single->content;?></p>
	<?php 
		$dateRaw = AndTimeUtils::setDateToTimestamp($single->date_created);
		$agoStyle = AndTimeUtils::getTimeAgoStyle($dateRaw);
		echo "<h3>". $agoStyle . "</h3>";
	?>

	<?php  
		
			if (isset($_SESSION['proposal_sent'])) {
				echo '<h3>' . $_SESSION['proposal_sent'] . '</h3>';
				unset($_SESSION['proposal_sent']);
			}

		?>

	<form action="proposalProcessor.php" method="post" accept-charset="utf-8">
		<input type="hidden" name="writing_id" value="<?php echo $ref; ?>">
		<input type="hidden" name="reciever_id" value="<?php echo $single->regist_id ;?>">
		<label for="proposal">Propose Story</label>
		<br>
		<br>
		<textarea name="proposal"></textarea>
		<br>
		<input type="submit" value="propose now">
	</form>
</body>
</html>