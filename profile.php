<?php 
require_once 'AndLib/AndCore.php';
session_start();
if (empty($_SESSION['user_id'])) {
	$isLogin = false;
	// header('Location:' . AndPath::getHost() . AndPath::getPath() . '/index.php');
} else{
	$isLogin = true;
}

// jika kamu pertama kali login, kamu akan di direct untuk menyelesaikan landing page
if ($_SESSION['firstTime'] == 1) {
	header('Location:' . AndPath::getHost() . AndPath::getPath() . '/landing.php');
}

$owner = $_SESSION['user_id'];
// using get method to retrieve data from table
$input = $_GET;
// make int value from get method
$regist_id = intval(AndSecurityGuard::defendInput($input['regist_id']));

// ---------------- handle database ------------------
$con = new AndDatabase();
//query from table user
$result = $con->queryObj("
	SELECT * 
	FROM `openpen`.`all_user_post`  
	WHERE `all_user_post`.`regist_id` = '$regist_id'
	ORDER BY date_created DESC
	");
//query from table act_writing
$writer = $con->queryObj("
	SELECT COUNT(user_regist_id) 
	AS counter 
	FROM `openpen`.`act_writing` 
	WHERE user_regist_id = '$regist_id' 
	");

$friend =  $con->queryObj("
	SELECT COUNT(*) 
	AS counter FROM `openpen`.`pen_friend` 
	WHERE user_regist_id = '$owner' AND friend ='$regist_id'
	");

$isYourFriend = $con->queryObj("
	SELECT user_regist_id
	AS user
	FROM `openpen`.`pen_friend` 
	WHERE user_regist_id = '$regist_id' AND friend ='$owner'
	");

require 'templates/counter.php';

$con->closeConnection();
// ---------------- handle database ------------------

$writer = $writer[0];
//for form
$val = $result[0]->regist_id;
//for validate if friend request has been sent or not
$isYourFriend = $isYourFriend[0];
//retrieve numbers of messages notif

$isSent = $friend[0]->counter;
$isSent = intval($friend[0]->counter);
$writer = intval($writer->counter);
$isYourFriend = intval($isYourFriend->user);

//AndDevDebug::printNice($isSent);

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
	<?php 

		if (isset($_SESSION['must_login'])) {
			echo '<h3>' . $_SESSION['must_login'] . '</h3>';
			unset($_SESSION['must_login']);
		}

	?>


	<!-- navigation section -->
	<?php require_once 'templates/nav-header.php'; ?>
	<!-- navigation section -->
	
	<?php if ($_SESSION['user_id'] == $regist_id && $isLogin): ?>

		<?php if ($writer >= 1): ?>
			<h1>Write Your Story</h1>
		<?php else: ?>
			<h1>Write your first story</h1>
		<?php endif ?>

		<form accept-charset='utf-8' action='formWritingProcessor.php' method='post'>
			<!-- hidden section -->
			<input type='hidden' name='userid' value='<?php echo $regist_id; ?>'>
			<label for='toc'>Table of Content</label>

			<?php if ($writer >= 1): ?>
				<select name='toc' id='toc'>
					<option value='Introduction'>Introduction</option>
					<option value='Prologue'>Prologue</option>
					<option value='chapter1'>Chapter 1</option>
					<option value='chapter2'>Chapter 2</option>
					<option value='chapter3'>Chapter 3</option>
					<option value='chapter4'>Chapter 4</option>
					<option value='chapter5'>Chapter 5</option>
					<option value='chapter6'>Chapter 6</option>
				</select>
			<?php else: ?>
				<select name='toc' id='toc'>
					<option value='Introduction'>Introduction</option>
				</select>
			<?php endif ?>
		<br>
		<br>
		<label for='title'>Title</label>
		<br>
		<input type='text' name='title' placeholder='your title's story' required>
		<br>
		<br>
		<label for='content'>Content</label>
		<textarea name='content' required></textarea>
		<br>
		<label for='marathon'>Marathon (do you want others writers contribute to your story?)</label>
		<select name='status' id='status' required>
			<option value='1'>yes</option>
			<option value='0'>no</option>
		</select>
		<br>
		<input type='submit' value='Write it Out!'>

		</form>

	<?php else: ?>

		<?php if (isLogin == true && !empty($regist_id)): ?>

			<?php if (!$isYourFriend == $regist_id): ?>

				<?php if (intval($isSent) == 0): ?>
					<h2><a href=partnerRequestProcessor.php?reference=<?php echo $regist_id ;?>>add as a partner</a></h2>
				<?php else: ?>
					<h2>Request has been sent</h2>
				<?php endif ?>

			<?php else: ?>
				<?php echo NULL ?>
			<?php endif ?>
				
		<?php endif ?>
	
	<?php endif ?>

	<?php foreach ($result as $value): ?>

		<h1><?php echo $value->pen_name ?></h1>
		<h2><?php echo $value->title ?></h2>
		<p><?php echo $value->content ?></p>

		<?php 
			$dateRaw = AndTimeUtils::setDateToTimestamp($value->date_created);
			$agoStyle = AndTimeUtils::getTimeAgoStyle($dateRaw);
		?>

		<p><?php echo $agoStyle ?></p>

		<?php if ($owner == $regist_id): ?>
			<a href="single.php?ref=<?php echo $value->writing_id ?>">Edit</a>	
		<?php else: ?>
			<a href="proposal.php?ref=<?php echo $value->writing_id?>" title=""></a>		
		<?php endif ?>

		<?php include 'templates/counterLike.php'; ?>

		<?php if (intval($isLike) > 0): ?>
			<a href="likeProcessor.php?uref=<?php echo $value->writing_id ?>&utrigger=<?php echo $regist_id ?>">Unlike</a>
		<?php else: ?>
			<a href="likeProcessor.php?ref=<?php echo $value->writing_id ?>&trigger=<?php echo $regist_id ?>" title="Like">Like</a>
		<?php endif ?>

		

		<?php if ($likeCounter == 0): ?>
			<?php echo null ?>
		<?php else: ?>
			<span><b><?php echo $likeCounter ?> like</b></span>
		<?php endif ?>

	<?php endforeach ?>

</body>
</html>