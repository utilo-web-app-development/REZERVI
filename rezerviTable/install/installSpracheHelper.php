<?php
/**
Fügt eine Zeile aus dem csv in die Datenbank
ein:
*/
function insertSprache($zeile){
	
	global $db;
	
	//leerzeichen am anfang und ende und zeilenumbruch entfernen:
	$zeile = rtrim($zeile);
	
	//entferne das erste und das letzte anf�hrungszeichen:
	$zeile = "#".$zeile."#";
	$zeile = str_replace ( "#\"", "", $zeile);
	$zeile = str_replace ( "\"#", "", $zeile);
	
	//zeile in die einzelnen eintraege zerlegen:
	//array explode ( string separator, string string [, int limit] )
	$saetze = explode("\",\"",$zeile);
	$standardtext = "";
	
	//nun die saetze in die datenbank eintragen:
	//die reihenfolge ist dabei wichtig!
	//1. deutsch
	//2. englisch
	//3. franz
	//4. estnisch
	//5. italiener
	//6. spanier	
	for($i=0; $i< count($saetze); $i++){
		$satz = $saetze[$i];		
		//anfuehrungszeichen filtern:
		$satz = str_replace ( "'","\'",$satz);		
		//NULL eintraege ignorieren:
		if ($satz == "NULL"){
			continue;
		}
		
		switch ($i) {
		case 0:
		   $spracheId = "de";
		   $standardtext = $satz;
		   break;
		case 1:
		   $spracheId = "en";
		   break;
		case 2:
		   $spracheId = "fr";
		   break;
		case 3:
		   $spracheId = "es";
		   break;
		case 4:
		   $spracheId = "it";
		   break;
		case 5:
		   $spracheId = "sp";
		   break;
		}
		
		$query = "INSERT INTO " .
				"BOOKLINE_UEBERSETZUNGEN " .
				"(SPRACHE_ID, TEXT, TEXT_STANDARD) " .
				"VALUES " .
				"('$spracheId','$satz','$standardtext')";
			
		//query absetzen:
		$res = $db->Execute($query);
		if (!$res){
			echo($query);
			print $db->ErrorMsg();
			exit;
		}
		
	} //ende for schleife - durchlaufen einer zeile

}
?>