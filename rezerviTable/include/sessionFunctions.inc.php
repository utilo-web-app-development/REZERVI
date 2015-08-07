<?php
/*
 * Created on 10.09.2005
 *
 * author: coster
 */

 //session bezeichnungen als konstanten: 
 define("SPRACHE","sprache");
 define("GASTRO_ID","GASTRO_ID");
 define("ANGEMELDET","angemeldet");
 define("BENUTZER_ID","benutzer_id");
 define("MIETOBJEKT_ID","raum_id"); //id des raumes bzw. mietobjektes

/**
author:coster
date:7.2.06
liefert ein datum fuer session-eintraege
@param $daysback anzahl der tage in die vergangenheit, default = 0
*/
function getSessionDate($daysback = 0){
	
	$arr_date = getdate();
	$jahr = $arr_date['year'];
	$monat= $arr_date['mon'];
	$tag  = $arr_date['mday'];
	
	$tag = $tag-$daysback;
	if ($tag < 1){
		global $root;
		include_once($root."/include/datumFunctions.inc.php");
		$tag = getNumberOfDaysOfMonth($monat,$jahr);
		$monat--;
	}
	if ($monat < 1){
		$monat = 12;
		$jahr--;
	}
	if (strlen($tag)<=1) {
		$tag = "0".($tag);
	}
	if (strlen($monat)<=1) {
		$monat = "0".($monat);
	}
	
	return $jahr.$monat.$tag;

}
/**
 * author:coster
 * date: 10.9.05
 * liefert einen wert aus der session
 * als bezeichnung konstante verwenden
 * */
function getSessionWert($bezeichnung){

			global $db;		
			$session_id = session_id();		
	
			$query = ("SELECT 
					   WERT
					   FROM
					   BOOKLINE_SESSION
					   WHERE
					   BEZEICHNUNG = '$bezeichnung'
					   AND
					   HTTP_SESSION_ID = '$session_id'
		   			  ");           

	//$res = $db->Execute($query);
	$res = $db->Execute($query);
	
	if (!$res) { 
		print $db->ErrorMsg();	
		return false;
	}
	else{		
	
		$wert = $res->fields["WERT"];
		if (empty($wert)){
			return false;
		}
		else{
			return $wert;
		}
	}

}
/**
 * author: coster
 * date: 10.9.05
 * setzt einen session wert (aus konstanten entnehmen)
 * */
function setSessionWert($bezeichnung,$wert){	
	
	global $db;
	$session_id = session_id();
	$erstellung = getSessionDate(0);
	
	if (getSessionWert($bezeichnung) == false){
		$query = ("INSERT INTO 
		   BOOKLINE_SESSION
		   (BEZEICHNUNG,ERSTELLUNG,HTTP_SESSION_ID,WERT)
		   VALUES
		   ('$bezeichnung','$erstellung','$session_id','$wert')
		  ");     
	}
	else{
		$query = ("UPDATE 
		   BOOKLINE_SESSION
		   SET
		   WERT = '$wert'
		   where
		   HTTP_SESSION_ID = '$session_id'
		   and
		   BEZEICHNUNG = '$bezeichnung'
		  ");  
	}
	
	//$res = $db->Execute($query);
	$res = $db->Execute($query);
	
	if (!$res) { 
		print $db->ErrorMsg();
		return false;
	}
	else{
		return true;
	}
}
/**
 * author:coster
 * date: 19.9.05
 * zerst�rt eine session
 * */
function destroySession(){
	
	global $db;
	
	$session_id = session_id();
	
	$query = ("DELETE 
			   FROM
			   BOOKLINE_SESSION
			   WHERE
			   HTTP_SESSION_ID = '$session_id'
   			  ");      

	//$res = $db->Execute($query);
	$res = $db->Execute($query);
	
	if (!$res) { 
		print $db->ErrorMsg();
		return false;
	}
	else{
		return true;
	}

}
	
/**
 * author:coster
 * date: 19.9.05
 * zerst�rt alle session die �lter als 1 tag sind
 * 
 * */
function destroyInactiveSessions(){
	
	global $db;
	
	$session_id = session_id();
	$erstellung = getSessionDate(2);
	
	$query = ("DELETE 
			   FROM
			   BOOKLINE_SESSION
			   WHERE
			   ERSTELLUNG <= $erstellung
   			  ");      

	//$res = $db->Execute($query);
	$res = $db->Execute($query);
	
	if (!$res) { 
		print $db->ErrorMsg();
		return false;
	}
	else{
		return true;
	}

}
?>
