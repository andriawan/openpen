<?php 
require_once 'AndLib/AndCore.php';
session_start();
if (empty($_SESSION['user_id'])) {
	$isLogin = false;
	// header('Location:' . AndPath::getHost() . AndPath::getPath() . '/index.php');
} else{
	$isLogin = true;
}

$form = $_GET;
$src = $form['search'];
$owner = $_SESSION['user_id'];

// ---------------- handle database ------------------
$con = new AndDatabase();
//query from table user
$result = $con->queryObj("SELECT * from `openpen`.`user` where pen_name like '$src%' ORDER BY pen_name DESC");

$messagesNotif = $con->queryObj("
	SELECT COUNT(*)
	AS counter
	FROM `openpen`.`messages`
	WHERE `messages`.`reciever_id` = '$owner' AND `messages`.`is_read` = '0'
	");

$con->closeConnection();
// ---------------- handle database ------------------

//retrieve numbers of messages notif
$messagesNotif = $messagesNotif[0]->counter;
$messagesNotif = intval($messagesNotif);
// AndDevDebug::printNice($form);

?>

<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<meta charset="UTF-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
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

		<form action="writerSearch.php" method="get" accept-charset="utf-8">
			<label for="search">Search your Partner</label>
			<input type="text" name="search" required>
			<br>
			<input type="submit" value="Search">
		</form>

		<?php
			if ($src == "") {
				echo "enter email or pen name";
			}else{

				foreach ($result as $value) {
					echo "<h3><a href=profile.php?regist_id=". $value->regist_id . ">" . $value->pen_name . "</a></h3>";
				}
			} 
		?>

	</body>
</html>