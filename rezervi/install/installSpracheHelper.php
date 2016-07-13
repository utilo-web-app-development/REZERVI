<?php
/**
Fügt eine Zeile aus dem csv in die Datenbank
ein:
*/
function insertSpracheNeu($zeile,$link){
	
	//leerzeichen am anfang und ende und zeilenumbruch entfernen:
	$zeile = rtrim($zeile);
	
	//entferne das erste und das letzte anf�hrungszeichen:
	$zeile = "#".$zeile."#";
	$zeile = str_replace ( "#\"", "", $zeile);
	$zeile = str_replace ( "\"#", "", $zeile);
	
	//zeile in die einzelnen eintraege zerlegen:
	//array explode ( string separator, string string [, int limit] )
	$saetze = explode("\",\"",$zeile);
	$standardspracheId = -1;
	
	//nun die saetze in die datenbank eintragen:
	//die reihenfolge ist dabei wichtig!
	//1. deutsch
	//2. englisch
	//3. franz
	//4. estnisch
	//5. hollaendisch
	//6. spanier	
	//7. italien
	for($i=0; $i< count($saetze); $i++){
		//echo($saetze[$i]."<br/>");
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
		   $spracheId = "nl";
		   break;
		case 5:
		   $spracheId = "sp";
		   break;
		case 6:
	       $spracheId = "it";
	       break;
		}
		
		$query = "INSERT INTO " .
				"Rezervi_Uebersetzungen " .
				"(Sprache_ID, Standardsprache_ID, Text) " .
				"VALUES " .
				"('$spracheId','$standardspracheId','$satz')";
			
		//query absetzen:
		$res = mysql_query($query, $link);
		if (!$res){
			echo($query);
			echo(mysql_error($link));
			exit;
		}
		if ($spracheId == "de"){
			$standardspracheId = mysql_insert_id($link);
		}
		
	}

}
?>