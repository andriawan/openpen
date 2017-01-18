<?php if (isset($_SESSION['reg_successfull'])): ?>

	<h3><?php echo $_SESSION['reg_successfull']; ?></h3>
	<?php unset($_SESSION['reg_successfull']); ?>

<?php endif ?>


<?php if (isset($_SESSION['empty_username_password'])): ?>
	
	<h3><?php echo $_SESSION['empty_username_password'] ?></h3>
	<?php unset($_SESSION['empty_username_password']); ?>

<?php elseif(isset($_SESSION['empty_login_name'])): ?>

	<h3><?php echo $_SESSION['empty_login_name'] ?></h3>
	<?php unset($_SESSION['empty_login_name']); ?>

<?php elseif (isset($_SESSION['empty_password'])): ?>
	
	<h3><?php echo $_SESSION['empty_password'] ?></h3>
	<?php unset($_SESSION['empty_password']); ?>

<?php elseif (isset($_SESSION['error_login'])): ?>
	
	<h3><?php echo $_SESSION['error_login'] ?></h3>
	<?php unset($_SESSION['error_login']); ?>

<?php else: ?>

<?php endif ?>