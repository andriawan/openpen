<?php 
require_once 'AndLib/AndCore.php';
session_start();
if (empty($_SESSION['user_id'])) {
	$isLogin = false;
	// header('Location:' . AndPath::getHost() . AndPath::getPath() . '/index.php');
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

$con->closeConnection();
// ---------------- handle database ------------------
$single = $single[0];

AndDevDebug::printNice($allProposal);

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
			<?php if ($isLogin) {
				if ($friendNotif == 0) {
					echo "<li><a href='writer.php'>Writer</a></li>";
				} else{
					echo "<li><a href='writer.php'>Writer (" . $friendNotif . ") </a></li>";
				}
			} ?>
			<li><a href="writerSearch.php">Search your partner</a></li>
			<li><a href="logout.php">Logout</a></li>
		</ul>
	</nav>

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