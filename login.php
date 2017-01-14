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
$result = $con->query("SELECT regist_id, pen_name, email, password FROM `openpen`.`user` where pen_name = '$userinput' || email = '$userinput'");

//store result of sql query
$result = $result[0];

//close database connection
$con->closeConnection();

//field for authentication
$pen_name = $result['pen_name'];
$email = $result['email'];

//store registration id for session
$user_id = $result['regist_id'];

//return boolean
$keyword = AndSecurityGuard::coveredShadow($password, $result['password']);


// logic authentication

if ($userinput == $pen_name && $keyword == true) {
	session_start();	
	$_SESSION['user_id'] = $user_id;
	header('Location:' . AndPath::getHost() . AndPath::getPath() . '/home.php');
} elseif ($userinput == $email && $keyword == true){
	session_start();
	$_SESSION['user_id'] = $user_id;
	header('Location:' . AndPath::getHost() . AndPath::getPath() . '/home.php');
}else{
	session_start();
	$_SESSION['error'] = "password atau penname anda tidak terdaftar atau salah. Silahkan coba lagi";
	header('Location:' . AndPath::getHost() . AndPath::getPath() . '/index.php');
}

?>