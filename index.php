<?php require_once 'AndLib/AndCore.php';
session_start();
if (isset($_SESSION['user_id'])) {
	header('Location:' . AndPath::getHost() . AndPath::getPath() . '/home.php');
}

AndDevDebug::printNice(count($_POST));

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Openpen : Write together, Share the world</title>
		<meta charset="UTF-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>

	<body>
		
		<?php include_once 'templates/errorFormLoginValidator.php'; ?>

		<!-- for login -->

		<h1>Login</h1>

		<form action="login.php" method="post" accept-charset="utf-8">

			<label for="username">Pen Name or E-mail</label>
			<input type="text" name="username" value="<?php echo $_SESSION['username'] ?>">
			<br>

			<label for="password_login">Password</label>
			<input type="password" name="password_login">
			<br>
			<input type="submit" name="login" value="login">
			
		</form>

		<!-- for registration -->

		<h1>Register</h1>

		<?php require_once 'templates/errorFormRegisterValidation.php'; ?>

		<form action="formProcessor.php" method="post" autocomplete="on" accept-charset="utf-8">
			
			<label for="firstName">First Name</label>
			<input id="firstName" name="firstName" placeholder="First Name" type="text" autocomplete="on" value="<?php echo $_SESSION['firstName'];?>">
			<br>

			<label for="lastName">Last Name</label>
			<input id="lastName" name="lastName" placeholder="Last Name" autocomplete="on" type="text" value="<?php echo $_SESSION['lastName'];?>">
			<br>

			<label for="penName">Pen Name <i>( Unique Name as your username in a writing )</i></label>
			<input id="penName" name="penName" placeholder="Pen Name" type="text" autocomplete="on" required value="<?php echo $_SESSION['penName'];?>">
			<br>

			<label for="sex">Sex</label>
			<select id="sex" name="sex" autocomplete="on" selected="<?php echo $_SESSION['sex'];?>">
				<?php if ($_SESSION['sex'] == "Female"): ?>
					<option value="Male">Male</option> 
					<option value="Female" selected="true">Female</option>
				<?php elseif ($_SESSION['sex'] == "Male"): ?>
					<option value="Male" selected="true">Male</option> 
					<option value="Female">Female</option>
				<?php else: ?>
					<option value="Male">Male</option> 
					<option value="Female">Female</option>					
				<?php endif ?>
			</select>
			<br>

			<label for="birthDate">Birth Date</label>
			<input id="birthDate" name="birthDate" type="date" autocomplete="on" value="<?php echo $_SESSION['birthDate'];?>">
			<br>

			<label for="email">E-mail</label>
			<input id="email" name="email" placeholder="email@domain.com" type="email" autocomplete="on" value="<?php echo $_SESSION['email'];?>">
			<br>

			<label for="phone">Phone Number</label>
			<input id="phone" name="phone" type="text" maxlength="12" autocomplete="on" value="<?php echo $_SESSION['phone'];?>">
			<br>

			<label for="password">Password</label>
			<input id="password" name="password" type="password" required>
			<br>

			<input type="submit" value="Be a Writer!">

		</form>

	</body>
</html>