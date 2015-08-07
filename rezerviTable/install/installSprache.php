<?php 

/*
		author: christian osterrieder alpstein-austria
*/

$sprache = $_POST["sprache"];
include_once("../include/rdbmsConfig.inc.php");
include_once("../include/uebersetzer.inc.php");
include_once("./installSpracheHelper.php");
	
$gastro_id = 1;

$fail = false;
$antwort="";

$file = "insertSprache.csv";
$fp = fopen($file,"r");

//zeile f�r zeile auslesen und in db einf�gen:
while ($query = fgets($fp, 1024)){
	
	//in die sprache_neu einfuegen:
	insertSprache($query);	
	
} //ende while  	

if ($fail){
	$antwort .= getUebersetzung("Anlegen der Übersetzungen scheiterte!")."<br/>";
	$antwort = $antwort.(mysql_error($link));
	$fehler = true;
	$woerterbuch = false;
}
else{
	$fehler = false;
	$woerterbuch = true;
	$antwort=getUebersetzung("Anlegen der Übersetzungen erfolgreich!");
}


?>