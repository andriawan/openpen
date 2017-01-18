<?php 

require_once 'AndLib/AndCore.php';

//store all global field from $_POST
$form = $_POST;

//store username and password input from user's form
//sinitize by AndSecurityGuard Library
$userinput = AndSecurityGuard::defendInput($form['username']);
$password = AndSecurityGuard::defendInput($form['password_login']);

//open database via AndDatabase Library
$con = new AndDatabase();

//query from username & email. woul return array of array
$result = $con->query("
	SELECT regist_id, pen_name, email, isFirstTimeLogin, password 
	FROM `openpen`.`user` 
	WHERE pen_name = '$userinput' || email = '$userinput'
	");

//store result of sql query
$result = $result[0];

//close database connection
$con->closeConnection();

//field for authentication
$pen_name = $result['pen_name'];
$email = $result['email'];

//check if user is login in the first time
$firstTime = $result['isFirstTimeLogin'];

//store registration id for session
$user_id = $result['regist_id'];

//return boolean
$keyword = AndSecurityGuard::coveredShadow($password, $result['password']);


// logic authentication

if ($userinput == $pen_name && $keyword == true) {
	session_start();
	session_destroy();
	session_start();
	$_SESSION['user_id'] = $user_id;
	if (intval($firstTime) == 1) {
		$_SESSION['firstTime'] = 1;
		header('Location:' . AndPath::getHost() . AndPath::getPath() . '/landing.php');
	}else{
		header('Location:' . AndPath::getHost() . AndPath::getPath() . '/home.php');
	}

} elseif ($userinput == $email && $keyword == true){
	session_start();
	$_SESSION['user_id'] = $user_id;
	header('Location:' . AndPath::getHost() . AndPath::getPath() . '/home.php');

}elseif (empty($form['password_login']) && empty($form['username'])) {
	session_start();
	$_SESSION['empty_username_password'] = "mohon isi username atau email dan password anda";
	header('Location:' . AndPath::getHost() . AndPath::getPath() . '/index.php');

}elseif (empty($form['username'])) {
	session_start();
	$_SESSION['empty_login_name'] = "mohon isi username anda";
	header('Location:' . AndPath::getHost() . AndPath::getPath() . '/index.php');

}elseif (empty($form['password_login'])) {
	session_start();
	$_SESSION['username'] = $_POST['username'];
	$_SESSION['empty_password'] = "mohon isi password anda";
	header('Location:' . AndPath::getHost() . AndPath::getPath() . '/index.php');

}else{
	session_start();
	$_SESSION['username'] = $_POST['username'];
	$_SESSION['error_login'] = "password atau penname anda tidak terdaftar atau salah. Silahkan coba lagi";
	header('Location:' . AndPath::getHost() . AndPath::getPath() . '/index.php');
}

?>