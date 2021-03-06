<?php 
/**
 * @author coster
 * Installiert die Datenbanktabellen von Bookline
 */
$root = "..";
include_once($root."/conf/conf.inc.php");
include_once($root."/include/rdbmsConfig.inc.php");
include_once($root."/include/uebersetzer.inc.php");

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
		$res = $db->Execute($query);
		if (!$res){
			$tabellen = false;
			$fehler = true;
			$antwort=$db->ErrorMsg()."<br/>";
			$antwort.="Anlegen der Tabellen scheiterte!"."<br/>";
			if (DEBUG){
				$antwort.="Fehler in Query: ".$query."<br/>";
				
			}
		    $antwort.="Eine mögliche Ursache ist, dass die Zugangsdaten in ihrer Konfigurationsdatei nicht korrekt ".
					  "sind oder die Tabellen bereits angelegt wurden."."<br/>"; 
			$antwort.="Falls Sie Hilfe benötigen wenden sie sich bitte per E-Mail an Alpstein  - wir helfen ihnen gerne weiter!"."<br/>";
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