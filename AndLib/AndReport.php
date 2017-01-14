<?php
/*
	------------------------------------------
	documented by Andriawan on January 6, 2017
	------------------------------------------

	Name file 	: AndReport.php
	Nama kelas 	: AndReport
	Field 		: $dirReport
	Method 		: __construct(), writeReport(), editReport()
	
	Deskripsi:
	Kelas ini merupakan kelas yang digunakan untuk memproses report atau laporan
	dari error yang terjadi. error tersebut bersumber dari pembentukan koneksi
	ke database menggunakan PDO. setiap error yang terjadi, akan dilempar menggunakan
	try catch untuk setelahnya ditampilkan dan dibuat laporan dalam folder khusus
	dengan nama report. file report tersebut dibuat dengan nama error_report_(tanggal).txt

	Changelog:
	- pembuatan file - tanggal 6 Januari 2017

	Maintainer:
	Muhammad Irwan Andriawan -> https://github.com/andriawan

	forked from (di ambil dan dimodifikasi):

	@author		Author: Vivek Wicky Aswal. (https://twitter.com/#!/VivekWickyAswal)
 	@git 		https://github.com/indieteq/PHP-MySQL-PDO-Database-Class
 	@version    0.2ab

 	thanks for Vivek Wicky Aswal

*/

require_once 'AndPath.php';
require_once 'AndTimeUtils.php';

class AndReport{

	//Nama Direktori yang akan digunakan untuk menyimpan report
	private $dirReport = 'report/';
	
	/*
		Ketika kelas diinstansiasi atau dibentuk, maka akan:

		- menetapkan default timezone
		- membentuk string path yang mengarah ke folder report lalu menyimpannya
		ke variabel $dirReport

	*/
	function __construct(){
		
		date_default_timezone_set('Asia/Jakarta');
		$this->dirReport = AndPath::getDirName() . $this->dirReport;

	}

	/*
		method ini berfungsi menangani penulisan report error dengan mengambil
		parameter $message dan menuliskannya disebuah file di folder ../report/

	*/

	function writeReport($message){
		
		$date = new DateTime();
		$reportFile = $this->dirReport . "error_report_" . $date->format('d-m-Y').".txt";

		if (is_dir($this->dirReport)){
			
			if (!file_exists($reportFile)){
				
				$fop = fopen($reportFile, "a+") or die("Something goes wrong!");
				$reportContent = "Time: " . $date->format('H:i:s') . "\r\n" . $message . "\r\n";

				fwrite($fop, $reportContent);
				fclose($fop);

			} else{

				$this->editReport($reportFile, $date, $message);

			}

		} else{

			if(mkdir($this->dirReport,0755) === true){
				
				$this->writeReport($message);  

		  	}	

		}
	}

	/*
		method ini berfungsi menangani file yang sudah ditulis menggunakan method writeReport() untuk 
		ditulis kembali tanpa membuat file baru. Method ini digunakan di dalam method writeReport().
	*/

	function editReport($reportFile, $date, $message){

		$reportContent = "Time : " . $date->format('H:i:s')."\r\n" . $message ."\r\n\r\n";
		$reportContent = $reportContent . file_get_contents($reportFile);
		file_put_contents($reportFile, $reportContent);

	}
}