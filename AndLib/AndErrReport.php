<?php

/**
* 
*/
class AndErrReport{

	//just in development mode
	static function enableErrorMessage(){

		error_reporting(E_ALL); 
		ini_set("display_errors", 1); 
	}
	
}