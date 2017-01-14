<?php 
/*
	--------------------------
	documented by Andriawan on January 6, 2017
	--------------------------
	AndPath class menyediakan akses untuk memudahkan dalam pengelolaan path

	berisi:

	- getDirName
	- setIncludeFile

	Parameter merupakan variabel $timestamp dimana dapat dihasilkan dari fungsi
	time() pada php


	*/

class AndPath{

	private static $separator = '/';


	//- getDirName -> mengembalikan nilai string path utama secara dinamis
	public static function getDirName(){
		$separator = '/';
		return dirname(__FILE__) . AndPath::$separator;
	}

	public static function echoHost(){

		$separator = AndPath::$separator;
		$host = $_SERVER['SERVER_NAME'];
		echo $host . $separator;

	}

	public static function getHost(){

		$host = $_SERVER['SERVER_NAME'];
		return 'http://' . $host . AndPath::$separator;
	}


	static function getPath(){

		$path = $_SERVER["REQUEST_URI"];
		$certain = explode("/", $path);
		// var_dump($certain);
		return $certain[1];
	}

	static function setPath($dirname, $file, $echo = false){

		$path = self::getPath();
		$fullPath = $path . self::$separator . $dirname . self::$separator . $file;

		if (!$echo){

			echo $fullPath;

		} else{

			return $fullPath;
		}
		
	}
}