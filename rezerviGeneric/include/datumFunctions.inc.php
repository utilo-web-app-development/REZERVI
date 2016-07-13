<?php
//kurzform für tage:
define("KURZFORM_MONTAG","MO");
define("KURZFORM_DIENSTAG","DI");
define("KURZFORM_MITTWOCH","MI");
define("KURZFORM_DONNERSTAG","DO");
define("KURZFORM_FREITAG","FR");
define("KURZFORM_SAMSTAG","SA");
define("KURZFORM_SONNTAG","SO");

/**
 * author: http://at2.php.net/manual/de/function.date.php
 * liefert ein array mit dem letzen und ersten der woche
 * */
function get_week_boundaries($int_time) {
	//first: find monday 0:00
	$weekdayid=date("w",$int_time);
	$dayid=date("j",$int_time);
	$monthid=date("n", $int_time);
	$yearid=date("Y", $int_time);
	$beginofday=mktime(0,0,0,$monthid,$dayid,$yearid);
	$beginofweek=$beginofday - (($weekdayid-1) * 86400); //86400 == seconds of one day (24 hours)
	//now add the value of one week and call it the end of the week
	//NOTE: End of week is Sunday, 23:59:59. I think you could also use Monday 00:00:00 but I though that'd suck
	$endofweek=($beginofweek + 7 * 86400)-1;
	$week["begin"]=$beginofweek;
	$week["end"]=$endofweek;
	$week["pov"]=$int_time;
	return $week;
}
/**
 * author:coster
 * date:10.1.06
 * liefert den ersten tag einer woche
 * */
 function getFirstDayOfWeek($tag,$monat,$jahr){
 	$zeit = mktime(0,0,0,$monat,$tag,$jahr);
 	$woche=get_week_boundaries($zeit);
	$monday=$woche["begin"];
	$datum = date("j",$monday);
	return $datum;
 }
 /**
 * author:coster
 * date:10.1.06
 * liefert den ersten tag einer woche
 * */
 function getLastDayOfWeek($tag,$monat,$jahr){
 	$zeit = mktime(0,0,0,$monat,$tag,$jahr);
 	$woche=get_week_boundaries($zeit);
	$sunday=$woche["end"];
	$datum = date("j",$sunday);
	return $datum;
 }
/**
 * author:coster
 * date:9.1.06
 * liefert den Tag eines Date-Picker Datums 
 * */
function getTagFromDatePicker($datepickerDatum){
	$date = explode("/",$datepickerDatum);
	return $date[0];
}
/**
 * author:coster
 * date:9.1.06
 * liefert das Monat eines Date-Picker Datums 
 * */
function getMonatFromDatePicker($datepickerDatum){
	$date = explode("/",$datepickerDatum);
	return $date[1];
}
/**
 * author:coster
 * date:9.1.06
 * liefert das Jahr eines Date-Picker Datums 
 * */
function getJahrFromDatePicker($datepickerDatum){
	$date = explode("/",$datepickerDatum);
	return $date[2];
}
/**
 * liefert den wochentag aus einem mysql timestamp
 * @author coster
 * date: 17.Apr. 2006
 * @param $timestamp der mysqlTimestamp
 * @return den wochentag (KURZFORM-KONSTANTE)
 */
function getDayFromMySqlTimestamp($timestamp){
	return substr($timestamp,6,2);	
}
/**
author:coster
date:21.10.05
konstuiert einen mysql timestamp
*/
function constructMySqlTimestamp($minute,$stunde,$tag,$monat,$jahr){
	
	$sekunde = "00";
	if ($minute < 10 && strlen($minute)<=1){
		$minute = "0".$minute;
	}
	if ($stunde < 10 && strlen($stunde)<=1){
		$stunde = "0".$stunde;
	}
	if ($tag < 10 && strlen($tag)<=1){
		$tag = "0".$tag;
	}
	if ($monat < 10 && strlen($monat)<=1){
		$monat = "0".$monat;
	}

	$ret = $jahr.$monat.$tag.$stunde.$minute;
	return $ret;

}
/**
author:coster
date:21.10.05
konstuiert einen mysql timestamp
*/
function constructMySqlTimestampFromDatePicker($datePickerDate,$minute,$stunde){
	
	$tag = getTagFromDatePicker($datePickerDate);
	$monat=getMonatFromDatePicker($datePickerDate);
	$jahr =getJahrFromDatePicker($datePickerDate);
	
	$sekunde = "00";
	if ($minute < 10 && strlen($minute)<=1){
		$minute = "0".$minute;
	}
	if ($stunde < 10 && strlen($stunde)<=1){
		$stunde = "0".$stunde;
	}
	if ($tag < 10 && strlen($tag)<=1){
		$tag = "0".$tag;
	}
	if ($monat < 10 && strlen($monat)<=1){
		$monat = "0".$monat;
	}

	$ret = $jahr.$monat.$tag.$stunde.$minute;

	return $ret;

}
/**
 * @author coster
 * datum: 17. Apr. 2006
 * liefert die stunde aus einem mysql timestamp
 */
 function getHourFromMySqlTimestamp($timestamp){
 	return substr($timestamp,8,2);
 }
/**
 * @author coster
 * datum: 17. Apr. 2006
 * liefert die minute aus einem mysql timestamp
 */
 function getMinuteFromMySqlTimestamp($timestamp){
 	return substr($timestamp,10,2);
 } 
/**
 * @author coster
 * datum: 17. Apr. 2006
 * liefert das Jahr aus einem mysql timestamp
 */
 function getYearFromMySqlTimestamp($timestamp){
 	return substr($timestamp,0,4);
 }  
/**
 * @author coster
 * datum: 17. Apr. 2006
 * liefert das Jahr aus einem mysql timestamp
 */
 function getMonthFromMySqlTimestamp($timestamp){
 	return substr($timestamp,4,2);
 } 

/**
author:coster
date:1.11.05
gibt ein formatiertes datum für html aus dem timestamp zurück
*/
function parseMySqlTimestamp($timestamp,$minute,$stunde,$tag,$monat,$jahr){
	
	//mysql timestamp:
	// jjjj-mm-tt  h h : m m : s s
	// 0123456789101112131415161718

	$ja = getYearFromMySqlTimestamp($timestamp);
	$mo = getMonthFromMySqlTimestamp($timestamp);
	$ta = getDayFromMySqlTimestamp($timestamp);
	$st = getHourFromMySqlTimestamp($timestamp);
	$mi = getMinuteFromMySqlTimestamp($timestamp);


	$back = "";
	if ($tag){
		$back.=$ta.".";
	}
	if ($monat){
		$back.=$mo.".";
	}
	if ($jahr){
		$back.=$ja." ";
	}
	if ($stunde){
		$back.=$st.":";
	}
	if ($minute){
		$back.=$mi;
	}
	return $back;
	
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
	$heute =mktime(0,0,0,$today['mon'],$today['mday'],$today['year']);
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

/**
 * author:coster
 * date:21.10.05
 * parst einen monatsname in die monatszahl
 * */
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

} 
/**
 * author:coster
 * date:21.10.05
 * parst eine monatszahl in den monatsnamen
 * */
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

} 
/**
 * author:coster
 * date:1.11.05
 * prüft ob das von-datum kleiner als das bis-datum
 */
function isDatumEarlier($vonMinute,$vonStunde,$vonTag, $vonMonat, $vonJahr, $bisMinute,$bisStunde,$bisTag, $bisMonat, $bisJahr){	
	
	$vonDatum = $vonJahr.$vonMonat.$vonTag.$vonStunde.$vonMinute;
	$bisDatum = $bisJahr.$bisMonat.$bisTag.$bisStunde.$bisMinute;
	$vonDatum++;$bisDatum++; //damit integer werden

	if ($vonDatum <= $bisDatum){
		return true;
	}
	
	return false;

}
/**
 * author:coster
 * date:4.11.05
 * gibt den heutigen tag als 2-stelliger string zurück mit führender 0
 * */
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
/**
 * author:coster
 * date:4.11.05
 * gibt die aktuelle minute als 2-stelliger string zurück mit führender 0
 * */
function getTodayMinute(){

	$today = getdate(); 	
	$min = $today['minutes']; 
	
	switch($min){
		case 1:
		case 2:
		case 3:
		case 4:
		case 5:
		case 6:
		case 7:
		case 8:
		case 9:
			$min = "0".$min;						
	}
	return $min;
}
/**
 * author:coster
 * date:4.11.05
 * gibt die aktuelle stunde als 2-stelliger string zurück mit führender 0
 * */
function getTodayStunde(){

	$today = getdate(); 	
	$min = $today['hours']; 
	
	switch($min){
		case 1:
		case 2:
		case 3:
		case 4:
		case 5:
		case 6:
		case 7:
		case 8:
		case 9:
			$min = "0".$min;						
	}
	return $min;
}
/**
 * author:coster
 * date:20.10.05
 * change: 4.11.05
 * liefert das heutige monat zurück (als int von 1-12) 2-stellig mit führender 0;
 * */
function getTodayMonth(){

	$today = getdate(); 
	$min = $today['mon']; 
	switch($min){
		case 1:
		case 2:
		case 3:
		case 4:
		case 5:
		case 6:
		case 7:
		case 8:
		case 9:
			$min = "0".$min;						
	}
	return $min;
	
} //ende getTodayMonth
/**
 * author:coster
 * date:20.10.05
 * liefert das aktuelle jahr 4 stellig
 * */
function getTodayYear(){

	$today = getdate(); 
	$year = $today['year']; 	
	return $year;

} 

/**
 * author:coster
 * date:9.1.06
 * gibt anzahl der tage eines monats zurück
 * */
function getNumberOfDaysOfMonth($monat,$jahr){

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

/**
 * author: http://at2.php.net/manual/de/function.mktime.php
 * change: coster
 * date:9.01.06
 * gibt die anzahl der tage zweier unix-timestamps zurueck
 */
function getNumberOfDaysOfTimestamp($from,$to){
   if($from && $to) {
     $r = ( ($to - $from) / 86400);
       return number_format($r,0);
   } else {
       return null;
   }
}

//---------------------------------------------------
//gibt zurück welcher tag der 1.im monat ist:
function getFirstDayOfMonth($month,$year){	
	
	//int mktime (int Stunde, int Minute, int Sekunde, int Monat, int Tag, int Jahr [, int is_dst])
	$day = date("D", mktime(0, 0, 0, $month, 1, $year));
	return $day;

} //ende getFirstDayOfMonth

/**
 * gibt den wochentag als kurzform zurueck
 * author: coster
 * date: 17. Apr. 2006
 * @param $tag
 * @param $monat
 * @param $jahr
*/
function getDayName($tag,$monat,$jahr){	
	
	$day = date("D", mktime(0, 0, 0, $monat, $tag, $jahr));	
		
		if ($day == "Mon")
			$day = KURZFORM_MONTAG;
		elseif ($day == "Tue")
			$day = KURZFORM_DIENSTAG;
		elseif ($day == "Wed")
			$day = KURZFORM_MITTWOCH;
		elseif ($day == "Thu")
			$day = KURZFORM_DONNERSTAG;
		elseif ($day == "Fri")
			$day = KURZFORM_FREITAG;
		elseif ($day == "Sat")
			$day = KURZFORM_SAMSTAG;
		elseif ($day == "Sun")
			$day = KURZFORM_SONNTAG;
			
	return $day;
	
} //ende getDayName


?>
