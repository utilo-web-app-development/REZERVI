<?php

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 

define("MONTAG","MO");
define("DIENSTAG","DI");
define("MITTWOCH","MI");
define("DONNERSTAG","DO");
define("FREITAG","FR");
define("SAMSTAG","SA");
define("SONNTAG","SO");

/**
 * author:coster
 * date:28.12.05
 * liefert den tag aus einem sql datum
 * */
 function getTagFromSQLDate($sqldate){
 	$datum = explode("-",$sqldate);
 	return $datum[2];
 }
 /**
 * author:coster
 * date:28.12.05
 * liefert das Monat aus einem sql datum
 * */
 function getMonatFromSQLDate($sqldate){
 	$datum = explode("-",$sqldate);
 	return $datum[1];
 }
  /**
 * author:coster
 * date:28.12.05
 * liefert das Monat aus einem sql datum
 * */
 function getJahrFromSQLDate($sqldate){
 	$datum = explode("-",$sqldate);
 	return $datum[0];
 }
/**
 * author:coster
 * date:8.11.05
 * convertiert das datum des date pickers (DD/MM/YYYY) 
 * in ein array mit DD,MM,YYYY
 * */
 function convertDatePickerDate($datepicer){
 	
 	$date = explode("/",$datepicer);
 	return $date;
 }
/**
author:coster
date:29.9.05
prüft ob das datum bereits abgelaufen ist
*/
function isDatumAbgelaufen($tagVon,$monatVon,$jahrVon,$tagBis,$monatBis,$jahrBis){

	$von=mktime(0,0,0,$monatVon,$tagVon,$jahrVon);
	$bis=mktime(0,0,0,$monatBis,$tagBis,$jahrBis);
	$today = getdate(); 
	$heute = mktime(0,0,0,$today['mon'],$today['mday'],$today['year']);
	if ($von < $heute || $bis < $heute){
		return true;
	}
	return false;
}

/**
ermittelt die anzahl der tage 
author: coster
date: 2.sep.2005
*/
function numberOfDays($month,$day,$year,$month1,$day1,$year1){
	
	$date1 = mktime(0,0,0,$month,$day,$year); //Gets Unix timestamp for current date
	$date = mktime(0,0,0,$month1,$day1,$year1); //Gets Unix timestamp for date set
	
	$difference = $date-$date1; //Calcuates Difference
	$days2 = floor($difference /60/60/24); //Calculates Days Old
		
	return $days2;

}

//--------------------------------------------
//funktion die das ausgewählte datum aus den
//formularfeldern in ein SQL-Datum parst
function parseDateFormular($tag,$monat,$jahr){

	if ($monat < 10 && strlen($monat)<=1) {
		$monat = "0".($monat);
	}
	if ($tag < 10 && strlen($tag)<=1) {
		$tag = "0".($tag);
	}

	$date = $jahr."-".$monat."-".$tag;

	return $date;

} //ende parseDate

/**--------------------------------------------
//funktion die einen monatsnamen in die
//monats-zahl parst
*/
function parseMonthNumber($monat){
	
	$mon = 0;

	if ($monat == "Januar")
		$mon = 1;
	elseif ($monat == "Februar")
		$mon = 2;
	elseif ($monat == "März")
		$mon = 3;
	elseif ($monat == "April")
		$mon = 4;
	elseif ($monat == "Mai")
		$mon = 5;
	elseif ($monat == "Juni")
		$mon = 6;
	elseif ($monat == "Juli")
		$mon = 7;
	elseif ($monat == "August")
		$mon = 8;
	elseif ($monat == "September")
		$mon = 9;
	elseif ($monat == "Oktober")
		$mon = 10;
	elseif ($monat == "November")
		$mon = 11;
	elseif ($monat == "Dezember")
		$mon = 12;
	
	return $mon;

} //ende parseDateNumber

/**--------------------------------------------
//funktion die ein monat in ziffern in den
//monats-namen parst
*/
function parseMonthName($month){			

		switch($month){
		case 1:
				$month = "Januar";
			break;
		case 2:
				$month = "Februar";
			break;
		case 3:
				$month = "März";
			break;
		case 4:
				$month = "April";
			break;
		case 5:
				$month = "Mai";
			break;
		case 6:
				$month = "Juni";
			break;
		case 7:
				$month = "Juli";
			break;
		case 8:
				$month = "August";
			break;
		case 9:
				$month = "September";
			break;
		case 10:
				$month = "Oktober";
			break;
		case 11:
				$month = "November";
			break;
		case 12:
				$month = "Dezember";								
	} //ende switch
	
	return $month;

} //ende parseMonthName


//-----------------------------------------------
//prüft ob das von-datum kleiner als das bis-datum
//ist, übergeben werden integer-werte:
function isDatumEarlier($vonTag, $vonMonat, $vonJahr, $bisTag, $bisMonat, $bisJahr){	

	//so jetzt mit einem schmäh, einen integer draus machen, falls dieser keiner
	//sein sollte. der +_operator übernimmt dies für mich...
	$vonJahr+=1;$bisJahr+=1;$vonMonat+=1;$bisMonat+=1;$vonTag+=1;$bisTag+=1;
	$vonJahr-=1;$bisJahr-=1;$vonMonat-=1;$bisMonat-=1;$vonTag-=1;$bisTag-=1;
	
	$tagKleiner = ($vonTag < $bisTag);
	$monKleiner = ($vonMonat < $bisMonat);
	$jahKleiner = ($vonJahr < $bisJahr);
	$tagGleich  = ($vonTag == $bisTag);
	$monGleich  = ($vonMonat == $bisMonat);
	$jahGleich  = ($vonJahr == $bisJahr);
	
	if ($jahKleiner){
		return TRUE;
	}
	if ($jahGleich && $monKleiner){
		return TRUE;
	} 
	if ($jahGleich && $monGleich && $tagKleiner){
		return TRUE;
	}
	if ($jahGleich && $monGleich && $tagGleich){
		return TRUE;
	}
	
	return FALSE;

}//ende isDatumEarlier

//-------------------------------------
//gibt heutigen tag zurück:
function getTodayDay(){

	$today = getdate(); 	
	$mday = $today['mday']; 
	
	switch($mday){
		case 1:
		case 2:
		case 3:
		case 4:
		case 5:
		case 6:
		case 7:
		case 8:
		case 9:
			$mday = "0".$mday;						
	}
	return $mday;
}

//-------------------------------------
//gibt heutiges monat zurück:
function getTodayMonth(){

	$today = getdate(); 
	$month = $today['mon']; 
	switch($month){
		case 1:
			$month = "Januar";
			break;
		case 2:
			$month = "Februar";
			break;
		case 3:
			$month = "März";
			break;
		case 4:
			$month = "April";
			break;
		case 5:
			$month = "Mai";
			break;
		case 6:
			$month = "Juni";
			break;
		case 7:
			$month = "Juli";
			break;
		case 8:
			$month = "August";
			break;
		case 9:
			$month = "September";
			break;
		case 10:
			$month = "Oktober";
			break;
		case 11:
			$month = "November";
			break;
		case 12:
			$month = "Dezember";								
	} //ende switch
	
	return $month;
} //ende getTodayMonth

//-------------------------------------
//gibt aktuelles jahr zurück:
function getTodayYear(){

	$today = getdate(); 
	$year = $today['year']; 	
	return $year;

} //ende getTodayYear

//------------------------------------
//gibt anzahl der tage eines monats zurück
function getNumberOfDays($monat,$jahr){

	$days = 31;
	if ($monat == 4 || $monat == 6 || $monat == 9 || $monat == 11 ) {
		$days = 30;
	}
	if ($monat == 2){
		$days = 28;
		 //schaltjahr?
		 if($jahr%4 == 0) $days = 29;
  	     if($jahr%100 == 0) $days = 29;
         if($jahr%400 == 0) $days = 29;
	}
	return $days;	
} //ende getNumberOfDays

//---------------------------------------------------
//gibt zurück welcher tag der 1.im monat ist:
function getFirstDayOfMonth($month,$year){	
	
	//int mktime (int Stunde, int Minute, int Sekunde, int Monat, int Tag, int Jahr [, int is_dst])
	$day = date("D", mktime(0, 0, 0, $month, 1, $year));
	return $day;

} //ende getFirstDayOfMonth

/**----------------------------------------------------
//gibt den wochentag zurück:
*/
function getDayName($tag,$monat,$jahr){	
	
	$day = date("D", mktime(0, 0, 0, $monat, $tag, $jahr));	
		
		if ($day == "Mon")
			$day = MONTAG;
		elseif ($day == "Tue")
			$day = DIENSTAG;
		elseif ($day == "Wed")
			$day = MITTWOCH;
		elseif ($day == "Thu")
			$day = DONNERSTAG;
		elseif ($day == "Fri")
			$day = FREITAG;
		elseif ($day == "Sat")
			$day = SAMSTAG;
		elseif ($day == "Sun")
			$day = SONNTAG;
			
	return $day;
	
} //ende getDayName
/**
 * author:coster
 * date:7.11.05
 * gibt ein array mit allen wochentagen in kurzform zurück
 * */
 function getWochentage(){
 	$arr = array();
 	$arr[]=MONTAG;
 	$arr[]=DIENSTAG;
 	$arr[]=MITTWOCH;
 	$arr[]=DONNERSTAG;
 	$arr[]=FREITAG;
 	$arr[]=SAMSTAG;
 	$arr[]=SONNTAG;
 	return $arr;
 	
 }

/**----------------------------------------------------
//gibt den wochentag zurück:
*/
function getFullDayName($tag,$monat,$jahr){	
	
	$day = getDayName($tag,$monat,$jahr);		

		if ($day == "Mon")
			$day = "Montag";
		elseif ($day == "Tue")
			$day = "Dienstag";
		elseif ($day == "Wed")
			$day = "Mittwoch";
		elseif ($day == "Thu")
			$day = "Donnerstag";
		elseif ($day == "Fri")
			$day = "Freitag";
		elseif ($day == "Sat")
			$day = "Samstag";
		elseif ($day == "Sun")
			$day = "Sonntag";
				
	return $day;
	
} //ende getFullDayName


?>
