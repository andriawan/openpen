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

// ---------------- handle database ------------------
$con = new AndDatabase();
//query from table user
$result = $con->queryObj("SELECT * from `openpen`.`user` where pen_name like '$src%' ORDER BY pen_name DESC");

$con->closeConnection();
// ---------------- handle database ------------------

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