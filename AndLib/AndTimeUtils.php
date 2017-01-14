<?php
	/*
	--------------------------
	documented by Andriawan on January 5, 2017
	--------------------------
	AndTimeUtils class menyediakan akses untuk memudahkan dalam pengelolaan waktu

	berisi:

	Time Ago style merupakan style time saat waktu berlalu. contohnya seperti
	- just now (Baru saja)
	- 2 hours ago (2 jam yang lalu)
	- dan lainnya

	Parameter merupakan variabel $timestamp dimana dapat dihasilkan dari fungsi
	time() pada php


	*/
	
class AndTimeUtils{

	static function getTimeAgoStyle($timestamp){

		$about = 'about ';
		$just = 'just now';
		$sec = ' seconds ago';
		$a_min = 'a minute ago';
		$mins = ' minutes ago';
		$a_hour = 'an hour ago';
		$hours = ' hours ago';
		$a_day = 'a day ago';
		$days = ' days ago';
		$a_week = 'a week ago';
		$weeks = ' weeks ago';
		$a_month = 'a month ago';
		$months = ' months ago';
		$a_year = 'a year';
		$years = ' years ago';

		$_minute = 60; // 60 = 1 minute
		$_hour = 3600; // 3600 = 1 hours
		$_day = 86400; // 86400 = 3600 (1 hours) * 24 = 24 hours
		$_week = 604800; // 604800 = 86400 (24 hours or a day) * 7 = a week
		$_month = 2592000; // 2592000 = 3600 * 24 * 30 = a month
		$_year = 31104000; // 31104000 = 2592000 (a month) * 12 = a year
		$_3years = 93312000; // 3 years
		
		$time = time() - $timestamp; // mendapatkan selisih waktu

		/*
		jika variabel $time lebih kecil dari $_minute
		maka akan dihitung sebagai satuan sekon
		*/

		if ($time < $_minute){

			return ($time > 1) ?  $about . $time . $sec : $just;

		} 

		/*
		jika variabel $time lebih kecil dari $_hour
		maka akan dihitung sebagai satuan menit
		*/

		elseif ($time < $_hour){

			$t_time = round($time/60);
			return ($t_time > 1) ? $about . $t_time . $mins : $a_min;
			
		} 

		/*
		jika variabel $time lebih kecil dari $_day
		maka akan dihitung sebagai satuan jam
		*/

		elseif ($time < $_day) {
			
			$t_time = round($time/3600);
			return ($t_time > 1) ? $about . $t_time . $hours : $a_hour;

		}

		/*
		jika variabel $time lebih kecil dari $_week
		maka akan dihitung sebagai satuan hari
		*/

		elseif ($time < $_week) {

			$t_time = round($time/86400);
			return ($t_time > 1) ? $about . $t_time . $days : $a_day;

		}

		/*
		jika variabel $time lebih kecil dari $_month
		maka akan dihitung sebagai satuan minggu
		*/

		elseif ($time < $_month) {

			$t_time = round($time / 86400);
			return ($t_time > 1) ? $about . $t_time . $weeks : $a_week;

		}

		/*
		jika variabel $time lebih kecil dari $_year
		maka akan dihitung sebagai satuan bulan
		*/

		elseif ($time < $_year) {
			
			$t_time = round($time / 2592000);
			return ($t_time > 1) ? $about . $t_time . $months : $a_month;

		}

		/*
		jika variabel $time lebih besar dari $_year
		maka akan dihitung sebagai satuan tahun
		*/

		elseif ($time > $_year && $time < $_3years) {
			
			$t_time = round($time / $_year);
			return ($t_time > 1) ? $about . $t_time . $years : $a_year;

		}

		/*
		jika variabel $time lebih kecil dari $_month
		maka akan dihitung tanggal
		*/ 

		elseif ($time > $_3years) { // 3 years over
			return date("j M Y h:i A", $timestamp);
		}
	}

	static function getDayInd(){

		$arrHari = array(1=>"Senin","Selasa","Rabu","Kamis","Jumat", "Sabtu","Minggu");
		$hari = $arrHari[date("N")];
		return $hari;
	}

	static function getDayEng(){

		$arrDay = array(1=>"Monday","Tuesday","Wednesday","Thursday","Friday", "Saturday","Sunday");
		$today = $arrDay[date("N")];
		return $today;
	}

	static function getDate(){

		$date = date("j");
		return $date;
	}

	static function getMonthInd(){

		$arrBulan = array(1=>"Januari","Februari","Maret", "April", "Mei", "Juni","Juli","Agustus","September","Oktober", "November","Desember");
		$bulan = $arrBulan[date("n")];
		return $bulan;
	}

	static function getMonthEng(){

		$arrMonth = array(1=>"January","February","March", "April", "Mei", "June","July","August","September","October", "November","Desember");
		$month = $arrMonth[date("n")];
		return $month;
	}

	static function getYear(){

		$year = date("Y");
		return $year;
	}

	static function getHour(){

		$hour = date("h:i:sa");
		return $hour;
	}

	static function getFullDateInd(){

		$space = ' ';
		$comma = ',';
		$full = AndTimeUtils::getDayInd() . $comma . $space . AndTimeUtils::getDate() . $space . AndTimeUtils::getMonthInd() .$space. AndTimeUtils::getYear();
		return $full;
	}

	static function setDateToTimestamp($date){

		$timestamp = strtotime($date);
		return $timestamp;
	}

}