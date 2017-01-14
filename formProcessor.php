<?php
require_once 'AndLib/AndCore.php';
session_start();
//just enable for debug
// AndErrReport::enableErrorMessage();

$form = $_POST;

if(empty($form)){
	header('Location:' . AndPath::getHost() . AndPath::getPath() . '/home.php');
}

$rawpass = AndSecurityGuard::defendInput($form['password']);
$penName = AndSecurityGuard::defendInput($form['penName']);
$firstName = AndSecurityGuard::defendInput($form['firstName']);
$lastName = AndSecurityGuard::defendInput($form['lastName']);
$sex = $form['sex'];
$email = AndSecurityGuard::defendInput(strtolower($form['email']));
$phone = AndSecurityGuard::defendInput($form['phone']);
$password = AndSecurityGuard::shadowSword(AndSecurityGuard::defendInput($form['password']));
$timeNow = date("Y-m-d H:i:s", time());
$birth = AndTimeUtils::setDateToTimestamp($form['birthDate']);

$age = time() - $birth;
$age = round($age/31104000);

$cleanBirth = date("Y-m-d H:i:s", $birth);

// ---------------- handle database ------------------
$conection = new AndDatabase();

$isExistPenName = $conection->queryObj("
	SELECT COUNT(pen_name)
	AS counter
	FROM `openpen`.`user`
	WHERE pen_name = '$penName'
	");

$isExistEmail = $conection->queryObj("
	SELECT COUNT(email)
	AS email
	FROM `openpen`.`user`
	WHERE email = '$email'
	");

$isExistPenName = $isExistPenName[0];
$isExistPenName = intval($isExistPenName->counter);

$isExistEmail = $isExistEmail[0];
$isExistEmail = intval($isExistEmail->email);


// validasi form

if ($isExistPenName > 0) {
	$_SESSION['error_pen_name'] = "pen name yang anda masukan telah terdaftar";
	header('Location:' . AndPath::getHost() . AndPath::getPath() . '/index.php');

}elseif ($isExistEmail > 0) {
	$_SESSION['error_email'] = "email yang anda masukan telah terdaftar";
	header('Location:' . AndPath::getHost() . AndPath::getPath() . '/index.php');
}elseif (strlen($penName) <= 5 || strlen($rawpass) <= 7 ) {

	if (strlen($penName) <= 5 && strlen($rawpass) <= 7 ) {
		$_SESSION['error_length_password'] = "password harus lebih dari atau 8 karakter";
		$_SESSION['error_length_pen_name'] = "pen name harus lebih dari atau 6 karakter";
		header('Location:' . AndPath::getHost() . AndPath::getPath() . '/index.php');
	}elseif (intval(strlen($penName)) <= 5) {
		$_SESSION['error_length_pen_name'] = "pen name harus lebih dari atau 6 karakter";
		header('Location:' . AndPath::getHost() . AndPath::getPath() . '/index.php');
	}elseif (intval(strlen($rawpass)) <= 7) {
		$_SESSION['error_length_password'] = "password harus lebih dari atau 8 karakter";
		header('Location:' . AndPath::getHost() . AndPath::getPath() . '/index.php');
	}
// validasi form 
}else{
	$conection->query("
	INSERT INTO `openpen`.`user` (`pen_name`, `firstname`, `lastname`, `age`, `sex`, `email`, `phone_number`, `password`, `gen_time`,`date_birth`) 
	VALUES('$penName' , '$firstName', '$lastName', '$age', '$sex', '$email', '$phone', '$password', '$timeNow', '$cleanBirth')
	");

	$_SESSION['reg_successfull'] = "Anda berhasil registrasi, silahkan login";
	header('Location:' . AndPath::getHost() . AndPath::getPath() . '/index.php');

}

$conection->closeConnection();
// ---------------- handle database ------------------

?>