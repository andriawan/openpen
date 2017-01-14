<?php 

/**
* 
*/
class AndGenerator{
	
	static function generateString(){

		$identifier = 'OPP';
		$cur_date = date('d').date('m').date('y');
		$identifier .= $cur_date;
		$customer_id = rand(00000 , 99999);
		$id = $identifier . $customer_id;
		
		return $id;

		// echo $uRefNo . "<br>";
		
	}


	static function generateServerInfo(){

		$server = $_SERVER;
		return $server;
	}
		
}