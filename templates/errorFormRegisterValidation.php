<?php 

if (isset($_SESSION['error_firstname_empty'])) {
	echo '<h2>' . $_SESSION['error_firstname_empty'] . '</h2>';
	unset($_SESSION['error_firstname_empty']);

}elseif (isset($_SESSION['error_lastname_empty'])) {
	echo '<h2>' . $_SESSION['error_lastname_empty'] . '</h2>';
	unset($_SESSION['error_lastname_empty']);

}elseif (isset($_SESSION['error_pen_name_empty']) || isset($_SESSION['error_email_empty'])) {
	echo '<h2>' . $_SESSION['error_pen_name_empty'] . '</h2>';
	echo '<h2>' . $_SESSION['error_email_empty'] . '</h2>';
	unset($_SESSION['error_pen_name_empty']);
	unset($_SESSION['error_email_empty']);

}
elseif (isset($_SESSION['error_password_empty'])) {
	echo '<h2>' . $_SESSION['error_password_empty'] . '</h2>';
	unset($_SESSION['error_password_empty']);	

}elseif (isset($_SESSION['error_length_pen_name']) || isset($_SESSION['error_length_password'])){
	echo '<h2>' . $_SESSION['error_length_pen_name'] . '</h2>';
	echo '<h2>' . $_SESSION['error_length_password'] . '</h2>';
	unset($_SESSION['error_length_pen_name']);
	unset($_SESSION['error_length_password']);

}elseif (isset($_SESSION['error_pen_name'])) {
	echo '<h2>' . $_SESSION['error_pen_name'] . '</h2>';
	unset($_SESSION['error_pen_name']);
}

elseif (isset($_SESSION['error_email'])) {
	echo '<h2>' . $_SESSION['error_email'] . '</h2>';
	unset($_SESSION['error_email']);
}

?>