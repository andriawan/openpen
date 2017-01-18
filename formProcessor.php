<?php
require_once 'AndLib/AndCore.php';
session_start();
$form = $_POST;
/*	
	this if condition, handle logic when someone try to access this script directly
	from url such http://localhost/formProcessor.php
*/
if(count($form , COUNT_RECURSIVE) != 0){
	header('Location:' . AndPath::getHost() . AndPath::getPath() . '/x.php');
}

//just enable for debug
// AndErrReport::enableErrorMessage();

$penName = AndSecurityGuard::defendInput($form['penName']);
$_SESSION['penName'] = $penName;

$firstName = AndSecurityGuard::defendInput($form['firstName']);
$_SESSION['firstName'] = $firstName;

$lastName = AndSecurityGuard::defendInput($form['lastName']);
$_SESSION['lastName'] = $lastName;

$sex = $form['sex'];
$_SESSION['sex'] = $sex;

$email = AndSecurityGuard::defendInput(strtolower($form['email']));
$_SESSION['email'] = $email;

$phone = AndSecurityGuard::defendInput($form['phone']);
$_SESSION['phone'] = $phone;

$rawpass = $form['password'];

$password = AndSecurityGuard::shadowSword($rawpass);

$timeNow = date("Y-m-d H:i:s", time());

$birth = AndTimeUtils::setDateToTimestamp($form['birthDate']);
$_SESSION['birthDate'] = $form['birthDate'];

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


// form Validation
//empty Validation
if (empty($firstName)) {
	$_SESSION['error_firstname_empty'] = "First Name tidak boleh kosong";
	header('Location:' . AndPath::getHost() . AndPath::getPath() . '/index.php');
}elseif (empty($lastName)) {
	$_SESSION['error_lastname_empty'] = "Last Name tidak boleh kosong";
	header('Location:' . AndPath::getHost() . AndPath::getPath() . '/index.php');
}elseif (empty($penName)) {
	$_SESSION['error_pen_name_empty'] = "Pen name tidak boleh kosong";
	header('Location:' . AndPath::getHost() . AndPath::getPath() . '/index.php');
}elseif (empty($email)) {
	$_SESSION['error_email_empty'] = "Email tidak boleh kosong";
	header('Location:' . AndPath::getHost() . AndPath::getPath() . '/index.php');
}elseif (empty($rawpass)) {
	$_SESSION['error_password_empty'] = "Password tidak boleh kosong";
	header('Location:' . AndPath::getHost() . AndPath::getPath() . '/index.php');
//isExist
}elseif ($isExistPenName > 0) {
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
// end of form validation 
}else{

	$conection->query("
	INSERT INTO `openpen`.`user` 
	(`pen_name`, `firstname`, `lastname`, `age`, `sex`, `email`, `phone_number`, `password`, `gen_time`, `date_birth`, `isFirstTimeLogin`) 
	VALUES
	('$penName' , '$firstName', '$lastName', '$age', '$sex', '$email', '$phone', '$password', '$timeNow', '$cleanBirth', '1')
	");

	$_SESSION['reg_successfull'] = "Anda berhasil registrasi, silahkan login";
	unset($_SESSION['penName']);
	unset($_SESSION['firstName']);
	unset($_SESSION['lastName']);
	unset($_SESSION['sex']);
	unset($_SESSION['email']);
	unset($_SESSION['phone']);
	unset($_SESSION['birthDate']);
	header('Location:' . AndPath::getHost() . AndPath::getPath() . '/index.php');

}

$conection->closeConnection();
// ---------------- end of handle database ------------------

?>