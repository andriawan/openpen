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

$ref = $_GET['ref'];

// ---------------- handle database ------------------
$con = new AndDatabase();
//query from table user

$single = $con->queryObj("
	SELECT * 
	FROM `openpen`.`all_user_post`
	WHERE `all_user_post`.`writing_id` = '$ref' AND `all_user_post`.`regist_id` = '$owner'
	");

require_once 'templates/counter.php';

$con->closeConnection();
// ---------------- handle database ------------------

$single = $single[0];

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

		<form action="reviserProcessor.php" method="get" accept-charset="utf-8">
			<label for="title">Titel : </label>
			<input type="text" name="title" value="<?php echo $single->title; ?>" placeholder="">
			<br>
			<br>
			<label for="content">Content : </label>
			<br>
			<textarea name="content" value=""><?php echo $single->content; ?></textarea>
			<br>
			<input type="submit" value="Update">
		</form>
	</body>
</html>