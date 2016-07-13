<?php

/*
		author: christian osterrieder utilo.eu
*/

// Set flag that this is a parent file
define( '_JEXEC', 1 );

include_once("../include/uebersetzer.php");
include_once("./installSpracheHelper.php");
include_once("../include/einstellungenFunctions.php");
	
$unterkunft_id = 1;

$fail = false;
$antwort=" ";

$file = "insertSprache.csv";
$fp = fopen($file,"r");

//zeile für zeile auslesen und in db einfügen:
while ($query = fgets($fp, 1024)){
	
	//in die sprache_neu einfuegen:
	insertSpracheNeu($query,$link);	
	
} //ende while
	
	$res = getSprachenForBelegungsplan($link);
	$i = 0;
	while($d = mysql_fetch_array($res)){
		$spr = $d["Sprache_ID"];
 		setSprache($unterkunft_id,$spr,2,$link);
	}
	
  	

if ($fail){
	$antwort .= getUebersetzung("Anlegen der Übersetzungen scheiterte!",$sprache,$link)."<br/>";
	$antwort = $antwort.(mysql_error($link));
	$fehler = true;
	$woerterbuch = false;
}
else{
	$fehler = false;
	$woerterbuch = true;
	$antwort=getUebersetzung("Anlegen der Übersetzungen erfolgreich!",$sprache,$link);
}


?>