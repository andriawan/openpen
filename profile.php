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
// using get method to retrieve data from table
$input = $_GET;
// make int value from get method
$regist_id = intval(AndSecurityGuard::defendInput($input['regist_id']));

// ---------------- handle database ------------------
$con = new AndDatabase();
//query from table user
$result = $con->queryObj("
	SELECT * 
	FROM `openpen`.`user`, `openpen`.`act_writing`  
	WHERE `user`.`regist_id` = '$regist_id' AND `act_writing`.`user_regist_id` = '$regist_id' 
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

$friendNotif =  $con->queryObj("
	SELECT COUNT(friend) 
	AS friend 
	FROM `openpen`.`pen_friend` 
	WHERE friend = '$owner' AND confirm = '0'");

$isYourFriend = $con->queryObj("
	SELECT user_regist_id
	AS user
	FROM `openpen`.`pen_friend` 
	WHERE user_regist_id = '$regist_id' AND friend ='$owner'
	");

$messagesNotif = $con->queryObj("
	SELECT COUNT(*)
	AS counter
	FROM `openpen`.`messages`
	WHERE `messages`.`reciever_id` = '$owner' AND `messages`.`is_read` = '0'
	");

$con->closeConnection();
// ---------------- handle database ------------------

$writer = $writer[0];
//for form
$val = $result[0]->regist_id;
//for validate if friend request has been sent or not
$friend = $friend[0];
$friendNotif = $friendNotif[0];
$isYourFriend = $isYourFriend[0];
//retrieve numbers of messages notif
$messagesNotif = $messagesNotif[0]->counter;
$messagesNotif = intval($messagesNotif);

$isSent = intval($friend->counter);
$writer = intval($writer->counter);
$friendNotif = intval($friendNotif->friend);
$isYourFriend = intval($isYourFriend->user);

// AndDevDebug::printNice($result);

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
	 <?php 

		 if ($_SESSION['user_id'] == $regist_id && $isLogin) {

		 	if ($writer >= 1) {
		 		echo "<h1>Write your story</h1>";	
		 	} else {
		 		echo "<h1>Write your first story</h1>";
		 	}

		 	echo "<form accept-charset='utf-8' action='formWritingProcessor.php' method='post'>
			<!-- hidden section -->
			<input type='hidden' name='userid' value='". $regist_id . "'>
			<label for='toc'>Table of Content</label>";

			 if ($writer >= 1) {
				echo "<select name='toc' id='toc'>
					<option value='Introduction'>Introduction</option>
					<option value='Prologue'>Prologue</option>
					<option value='chapter1'>Chapter 1</option>
					<option value='chapter2'>Chapter 2</option>
					<option value='chapter3'>Chapter 3</option>
					<option value='chapter4'>Chapter 4</option>
					<option value='chapter5'>Chapter 5</option>
					<option value='chapter6'>Chapter 6</option>
					</select>";
	 		} else {
		 		echo "<select name='toc' id='toc'>
					<option value='Introduction'>Introduction</option>
					</select>";	
	 		}

	 		echo "<br>
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
			</form>";

	 	}else{

	 		if(isLogin == true && !empty($regist_id) ){

	 			if(!$isYourFriend == $regist_id){

	 				if ($isSent == 0) {
		 			echo "<h2><a href=partnerRequestProcessor.php?reference=" . $regist_id . ">add as a partner</a></h2>";
			 		}else{
			 			echo "<h2>Request has been sent</h2>";
			 		}

	 			} else{
	 				echo NULL;
	 			}

	 			

	 		} else{
	 			echo NULL;
	 		}

	 		
	 	}



	 ?>
	<?php

		foreach($result as $value){
			// var_dump($value['title']);
			echo "<h1>". $value->pen_name. "</h1>";
			echo "<h2>". $value->title. "</h2>";
			echo "<p>". $value->content. "</p>";
			$dateRaw = AndTimeUtils::setDateToTimestamp($value->date_created);
			$agoStyle = AndTimeUtils::getTimeAgoStyle($dateRaw);
			echo "<p>". $agoStyle . "</p>";
			if ($owner == $regist_id ) {
				echo "<a href='single.php?ref=" . $value->writing_id . "'>Edit</a>";
			} elseif($value->marathon_status == 1){
				echo "<a href='proposal.php?ref=" . $value->writing_id . "'>Propose Marathon Writing</a>";
			}
		}

	?>
	
</body>
</html>