<?php session_start();

include_once("../conf/rdbmsConfig.inc.php");
include_once("../include/uebersetzer.inc.php");

$filename = "createTables.sql";

if(!function_exists("file_get_contents"))
{
   function file_get_contents($filename) {
   $fp = fopen($filename, "rb");
  
   if (!$fp) {
       return false;
   }
  
   $contents = "";
   while (! feof($fp)) {
       $contents .= fread($fp, 4096);
   }

   return $contents;
   }
}

//tabellen anlegen:
$query = file_get_contents($filename);
$queries = explode(";",$query);
for ($i=0; $i<count($queries); $i++){
$query = trim($queries[$i]);
	//query absetzen:
	if (!empty($query)){
		$res = mysql_query($query, $link);
		if (!$res){
			$tabellen = false;
			$fehler = true;
			$antwort=mysql_error($link)."<br/>";
			$antwort.="Anlegen der Tabellen scheiterte!"."<br/>";
		    $antwort.="Eine mögliche Ursache ist, dass die Zugangsdaten in ihrer Konfigurationsdatei nicht korrekt sind oder die Tabellen bereits angelegt wurden."."<br/>";
			$antwort.="Überprüfen Sie die Zugangsdaten in conf/rdbmsConfig.php und die Version Ihrer MySQL Datenbank."."<br/>";  
			$antwort.="Wenn die Tabellen bereits angelegt wurden, können sie diesen Schritt überspringen."."<br/>";  
			$antwort.="Ansonsten wenden sie sich bitte per E-Mail an utilo.net - wir helfen ihnen gerne weiter!"."<br/>";
			echo($antwort);
			exit;
		}
		else{
			$tabellen = true;
			$fehler = false;
			$antwort="Anlegen der Tabellen erfolgreich!";
		}
	}
}

?>