<?php 

/**
* 
*/
class AndDevDebug{
	
	static function printNice($val){
		
		echo "<pre>";
		print_r(var_dump($val));
		echo "</pre>";

	}
}