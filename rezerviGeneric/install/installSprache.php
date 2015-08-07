<?php session_start();

/*
		author: christian osterrieder utilo.net
*/

$sprache = $_SESSION["sprache"];
include_once("../conf/rdbmsConfig.inc.php");
include_once("../include/uebersetzer.inc.php");
include_once("./installSpracheHelper.php");
	
$vermieter_id = 1;

$fail = false;
$antwort="";

$file = "insertSprache.csv";
$fp = fopen($file,"r");

//zeile für zeile auslesen und in db einfügen:
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