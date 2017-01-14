<?php

/**
* 
*/
class AndSecurityGuard{
	
	static function defendInput($input){
		
		$filtered = htmlspecialchars(htmlentities(strip_tags($input)));
		return $filtered;
	}

	static function shadowSword($shadow){

		$coster = self::testCost();

		$cost = $coster;

		$deeper = array(
			"cost" => $cost
			);
		
		$sword = password_hash($shadow, PASSWORD_DEFAULT, $deeper);

		return $sword;

	}


	static function coveredShadow($yourSword, $hashMaster){

		$auth = password_verify($yourSword, $hashMaster);

		return $auth;

	}

	// forked from php official documentation
	static function testCost(){
		
		$timeTarget = 0.05; // 50 milliseconds 

		$cost = 8;
		do {
		    $cost++;
		    $start = microtime(true);
		    password_hash("test", PASSWORD_BCRYPT, ["cost" => $cost]);
		    $end = microtime(true);
		} while (($end - $start) < $timeTarget);

		return $cost;

	}


	// generate cost table for testing . forked from php official documentation
	static function generateTableCost(){

	    for( $cost = 0; $cost <= 10; $cost=$cost+0.1){

	        $start = microtime(true);
	        password_hash("test".$cost, PASSWORD_BCRYPT, ["cost" => $cost]);
	        $end = microtime(true);
	        echo  $cost . ' ' . ( $end - $start ). '<br>';

	    }

	}
}