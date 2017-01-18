<?php 
require_once 'AndLib/AndCore.php';
session_start();
if (isset($_SESSION['user_id'])) {
	$isLogin = true;
}else{
	header('Location:' . AndPath::getHost() . AndPath::getPath() . '/index.php');
	$isLogin = false;
}

$owner = $_SESSION['user_id'];

// ---------------- handle database ------------------

$con = new AndDatabase();

$genre = $con->queryObj("
	SELECT * 
	FROM `openpen`.`genre` 
	");

$result = $con->queryObj("
	SELECT *
	FROM `openpen`.`user` 
	WHERE `user`.`regist_id` = '$owner'
	");


$con->closeConnection();
// ---------------- handle database ------------------

$result = $result[0];

?>


<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<meta charset="UTF-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
		<h1>Selamat Datang <?php echo $result->firstname . " " . $result->lastname ?></h1>
		<h2>Selamat, Anda sekarang adalah seorang penulis dengan nama pena <?php echo $result->pen_name ?></h2>
		<h3>Tulis kisah anda, jadikan setiap moment menjadi hal yang paling mengesankan bagi anda. Bagikan kisah serta inspirasi anda. Bersama menulis, menulis bersama</h3>

		<h1>Apa itu openpen?</h1>
		<p>Openpen merupakan Media bagi komunitas penulis Indonesia untuk bersama-sama menulis, menggali inspirasi dan berbagi pengalaman. Terkadang kebuntuan menjadi hal paling besar yang membuat penulis sulit menyelesaikan cerita mereka. Jadi mengapa tidak menulis bersama orang lain? saling menyambung ide cerita? menggali inspirasi lebih?</p>

		<h1>Tunggu Apa Lagi?</h1>
		<p>Tulis sekarang dan temukan partnermu dalam menulis</p>

		<h4>Openpen : Write together, Share the world</h5>

		<h2>Pilih Genre Favoritmu!</h2>

		<?php foreach ($genre as $value): ?>

		<input type="radio" name="<?php echo $value->genre; ?>" value="<?php echo $value->genre; ?>">
		<?php echo $value->genre; ?>
		<br>
	
<?php endforeach ?>
	</body>
</html>

