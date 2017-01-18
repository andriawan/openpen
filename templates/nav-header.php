<nav>
	<ul>
		<li><a href="home.php">Home</a></li>
		<li><a href="profile.php?regist_id=<?php echo $_SESSION['user_id']; ?>">Profile</a></li>
		<?php 
			if ($isLogin) {
				if ($messagesNotif == 0) {
					echo "<li><a href='messages.php'>Messages</a></li>";
				} else{
					echo "<li><a href='messages.php'>Messages (" . $messagesNotif . ") </a></li>";
				}
			} 
		?>
		<?php 
			if ($isLogin) {
				if ($notifCount == 0) {
					echo "<li><a href='notifications.php'>Notifications</a></li>";
				} else{
					echo "<li><a href='notifications.php'>Notifications (" . $notifCount . ") </a></li>";
				}
			} 
		?>
		<?php 
			if ($isLogin) {
				if ($friendNotif == 0) {
					echo "<li><a href='writer.php'>Writer</a></li>";
				} else{
					echo "<li><a href='writer.php'>Writer (" . $friendNotif . ") </a></li>";
				}
			} 
		?>
		<li><a href="writerSearch.php">Find your partner</a></li>
		<li><a href="logout.php">Logout</a></li>
	</ul>
</nav>