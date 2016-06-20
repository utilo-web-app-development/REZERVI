<?php
/*
 * Created on 10.09.2005
 *
 * author: coster
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
 // Send modified header for session-problem of ie:
 // @see http://de.php.net/session
 header('P3P: CP="NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM"');
 
 //open database first:
 //datenbank öffnen:
 include_once($root."/conf/rdbmsConfig.php");

 //session bezeichnungen als konstanten: 
 define("SPRACHE","sprache");
 define("UNTERKUNFT_ID","unterkunft_id");
 define("BENUTZERNAME","benutzername");
 define("PASSWORT","passwort");
 define("BENUTZER_ID","benutzer_id");
 define("ZIMMER_ID","zimmer_id");
 define("RECHTE","rechte");  
 define("ANSICHT_WI","ansicht webinterface");
 define("ANSICHT","ansicht belegungsplan"); 
 define("ZIMMER_IDS","zimmer ids");
 
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
		include_once($root."/include/datumFunctions.php");
		$tag = getNumberOfDays($monat,$jahr);
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
			
			global $link;		
			$session_id = session_id();
	
			$query = ("SELECT 
					   WERT
					   FROM
					   REZERVI_SESSION
					   WHERE
					   BEZEICHNUNG = '$bezeichnung'
					   AND
					   HTTP_SESSION_ID = '$session_id'
					   LIMIT 0,1
		   			  ");           

	$res = mysql_query($query, $link);
	
	if (!$res) { 
		echo("die Anfrage $query scheitert"); 
		echo(mysql_error($link));
		return false;
	}
	else{
		$d = mysql_fetch_array($res);
		$wert = $d["WERT"];
		return $wert;
	}

}
/**
 * author: coster
 * date: 10.9.05
 * setzt einen session wert (aus konstanten entnehmen)
 * */
function setSessionWert($bezeichnung,$wert){
	
	global $link;
	$session_id = session_id();
	$erstellung = getSessionDate(0);
	
	if (getSessionWert($bezeichnung) == ""){
		$query = ("INSERT INTO 
		   REZERVI_SESSION
		   (BEZEICHNUNG,ERSTELLUNG,HTTP_SESSION_ID,WERT)
		   VALUES
		   ('$bezeichnung','$erstellung','$session_id','$wert')
		  ");     
	}
	else{
		$query = ("UPDATE 
		   REZERVI_SESSION
		   SET
		   WERT = '$wert'
		   where
		   HTTP_SESSION_ID = '$session_id'
		   and
		   BEZEICHNUNG = '$bezeichnung'
		  ");  
	}
	
	$res = mysql_query($query, $link);
	
	if (!$res) { 
		echo("die Anfrage $query scheitert"); 
		echo(mysql_error($link));
		return false;
	}
	else{
		return true;
	}
}
/**
 * author:coster
 * date: 19.9.05
 * zerstört eine session
 * */
function destroySession(){
	
	global $link;
	
	$session_id = session_id();
	
	$query = ("DELETE 
			   FROM
			   REZERVI_SESSION
			   WHERE
			   HTTP_SESSION_ID = '$session_id'
   			  ");      

	$res = mysql_query($query, $link);
	
	if (!$res) { 
		echo("die Anfrage $query scheitert"); 
		echo(mysql_error($link));
		return false;
	}
	else{
		return true;
	}

}
/**
 * author:coster
 * date: 19.9.05
 * zerstört alle session die älter als 1 tag sind
 * 
 * */
function destroyInactiveSessions(){
	
	global $link;
	
	$session_id = session_id();
	$erstellung = getSessionDate(2);
	
	$query = ("DELETE 
			   FROM
			   REZERVI_SESSION
			   WHERE
			   ERSTELLUNG <= $erstellung
   			  ");      

	$res = mysql_query($query, $link);
	
	if (!$res) { 
		echo("die Anfrage $query scheitert"); 
		echo(mysql_error($link));
		return false;
	}
	else{
		return true;
	}

}
?>
