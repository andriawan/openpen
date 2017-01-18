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
$owner = $_SESSION['user_id'];

$cek = $_SESSION;
$globe = $GLOBALS;

// ---------------- handle database ------------------

$con = new AndDatabase();

require_once 'templates/counter.php';

$result = $con->queryObj("
	SELECT * 
	FROM `openpen`.`user` 
	WHERE regist_id = '$id'");

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

$result = $result[0];

if ($result->isFirstTimeLogin == 1) {
	header('Location:' . AndPath::getHost() . AndPath::getPath() . '/landing.php');
}

// AndDevDebug::printNice($GLOBALS);

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

		<h1><?php echo "Welcome " . $result->firstname . " " . $result->lastname . " (@" . $result->pen_name . ")" ; ?></h1>

		<?php foreach ($feed as $value): ?>
			
			<h1><?php echo $value->pen_name; ?></h1>
			<h2><?php echo $value->title; ?></h2>
			<p><?php echo $value->content; ?></p>
			<?php  
				$dateRaw = AndTimeUtils::setDateToTimestamp($value->date_created);
				$agoStyle = AndTimeUtils::getTimeAgoStyle($dateRaw);
				echo "<p>". $agoStyle . "</p>";
				if(intval($value->marathon_status) == 1){
					echo "<a href='proposal.php?ref=" . $value->writing_id . "'>Propose Marathon Writing</a>";
				}
			?>
		<?php endforeach ?>
	</body>
</html>