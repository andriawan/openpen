<?php 
require_once 'AndLib/AndCore.php';
session_start();
if (isset($_SESSION['user_id'])) {
	$isLogin = true;
}else{
	header('Location:' . AndPath::getHost() . AndPath::getPath() . '/index.php');
	$isLogin = false;
}

$id = AndSecurityGuard::defendInput($_SESSION['user_id']);

// ---------------- handle database ------------------

$con = new AndDatabase();

$result = $con->queryObj("
	SELECT * 
	FROM `openpen`.`user` 
	WHERE regist_id = '$id'");

$friendNotif =  $con->queryObj("
	SELECT COUNT(friend) 
	AS friend 
	FROM `openpen`.`pen_friend` 
	WHERE friend = '$id'
	AND confirm = '0' ");

$feed = $con->queryObj("
	SELECT * 
	FROM openpen.all_user_post 
	where regist_id 
	IN 
		(SELECT user_regist_id 
		FROM openpen.pen_friend where 
		friend = '$id')
	ORDER BY date_created DESC
	");

$con->closeConnection();
// ---------------- handle database ------------------

// AndDevDebug::printNice($feed);

$result = $result[0];
$friendNotif = $friendNotif[0];
$friendNotif = intval($friendNotif->friend);

// AndDevDebug::printNice($isLogin);

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
				<li><a href="profile.php?regist_id=<?php echo $result->regist_id; ?>">Profile</a></li>
				<li><a href="message.php">Messages</a></li>
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
		<h1><?php echo "welcome " . $result->pen_name; ?></h1>
		<?php

		foreach($feed as $value){
			// var_dump($value['title']);
			// AndDevDebug::printNice($value);
			echo "<h1>". $value->pen_name. "</h1>";
			echo "<h2>". $value->title. "</h2>";
			echo "<p>". $value->content. "</p>";
			$dateRaw = AndTimeUtils::setDateToTimestamp($value->date_created);
			$agoStyle = AndTimeUtils::getTimeAgoStyle($dateRaw);
			echo "<p>". $agoStyle . "</p>";
		}

	?>
	</body>
</html>