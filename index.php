<?php require_once 'AndLib/AndCore.php';
session_start();
if (isset($_SESSION['user_id'])) {
	header('Location:' . AndPath::getHost() . AndPath::getPath() . '/home.php');
}

// AndDevDebug::printNice($$_SESSION['user_id']);

// ---------------- handle database ------------------

$con = new AndDatabase();

$genre = $con->queryObj("
	SELECT * 
	FROM `openpen`.`genre` 
	");


$con->closeConnection();
// ---------------- handle database ------------------

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Openpen : Write together, Share the world</title>
		<meta charset="UTF-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>

	<body>

		<?php  
		
			if (isset($_SESSION['error'])) {
				echo '<h3>' . $_SESSION['error'] . '</h3>';
				session_destroy();
			}

		?>

		<?php  
		
			if (isset($_SESSION['reg_successfull'])) {
				echo '<h3>' . $_SESSION['reg_successfull'] . '</h3>';
				session_destroy();
			}

		?>

		<!-- for login -->

		<h1>Login</h1>

		<form action="login.php" method="post" accept-charset="utf-8">

			<label for="username">Pen Name or E-mail</label>
			<input type="text" name="username" required>
			<br>

			<label for="password_login">Password</label>
			<input type="password" name="password_login" required>
			<br>
			<input type="submit" name="login" value="login">
			
		</form>

		<!-- for register -->

		<h1>Register</h1>

		<?php  

			if (!empty($_SESSION['error_pen_name']) || !empty($_SESSION['error_email'])) {
				echo '<h2>' . $_SESSION['error_pen_name'] . '</h2>';
				echo '<h2>' . $_SESSION['error_email'] . '</h2>';
				session_destroy();
			}elseif (isset($_SESSION['error_length_pen_name']) || isset($_SESSION['error_length_password'])){
				echo '<h2>' . $_SESSION['error_length_pen_name'] . '</h2>';
				echo '<h2>' . $_SESSION['error_length_password'] . '</h2>';
				session_destroy();
			}

		?>

		<form action="formProcessor.php" method="post" autocomplete="on" accept-charset="utf-8">
			
			<label for="firstName">First Name</label>
			<input id="firstName" name="firstName" placeholder="First Name" type="text" autocomplete="on" required>
			<br>

			<label for="lastName">Last Name</label>
			<input id="lastName" name="lastName" placeholder="Last Name" autocomplete="on" type="text">
			<br>

			<label for="penName">Pen Name <i>( Unique Name as your username in a writing )</i></label>
			<input id="penName" name="penName" placeholder="Pen Name" type="text" autocomplete="on" required>
			<br>

			<label for="sex">Sex</label>
			<select id="sex" name="sex" autocomplete="on">
			  <option value="Male">Male</option> 
			  <option value="Female">Female</option>
			</select>
			<br>

			<label for="birthDate">Birth Date</label>
			<input id="birthDate" name="birthDate" type="date" autocomplete="on">
			<br>

			<label for="email">E-mail</label>
			<input id="email" name="email" placeholder="email@domain.com" type="email" autocomplete="on">
			<br>

			<label for="phone">Phone Number</label>
			<input id="phone" name="phone" type="text" maxlength="12" autocomplete="on">
			<br>

			<label for="password">Password</label>
			<input id="password" name="password" type="password" required>
			<br>
			<label for="genre">Select your favorite genre</label>
			<br>
			<?php 
				foreach ($genre as $value) {
					echo '<input type="radio" name="'. $value->genre . '" value="'. $value->genre_id . '">' . $value->genre . '<br>';
				}

			?>
			<input type="submit" value="Be a Writer!">

		</form>

	</body>
</html>