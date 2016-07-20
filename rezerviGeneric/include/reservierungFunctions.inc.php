<?php

define("STATUS_FREI",0);
define("STATUS_RESERVIERT",1);
define("STATUS_BELEGT",2);

/**
 * author:coster
 * date:9.1.06
 * prueft ob das datum der erste tag einer reservierung ist
 */
function isFirstDayOfReservation($reservierungs_id,$tag,$monat,$jahr){
		
 	global $root;
 	include_once($root."/include/datumFunctions.inc.php");
	
	$vonMysql = getDatumVonOfReservierung($reservierungs_id);
	$vonHier  = constructMySqlTimestamp(0,0,$tag,$monat,$jahr);
	
	$vonMysql = parseMySqlTimestamp($vonMysql,false,false,true,true,true);
	$vonHier =  parseMySqlTimestamp($vonHier ,false,false,true,true,true);

	if ($vonMysql == $vonHier){
		return true;
	}
	
	return false;
}
/**
 * author:coster
 * date:9.1.06
 * prueft ob das datum der letzte tag einer reservierung ist
 */
function isLastDayOfReservation($reservierungs_id,$tag,$monat,$jahr){
 	global $root;
 	include_once($root."/include/datumFunctions.inc.php");
	
	$vonMysql = getDatumBisOfReservierung($reservierungs_id);
	$vonHier  = constructMySqlTimestamp(0,0,$tag,$monat,$jahr);
	
	$vonMysql = parseMySqlTimestamp($vonMysql,false,false,true,true,true);
	$vonHier =  parseMySqlTimestamp($vonHier ,false,false,true,true,true);

	if ($vonMysql == $vonHier){
		return true;
	}
	
	return false;
}

/**
 * author:coster
 * date: 9.1.06
 * liefert die anzahl der tage die die reservierung betrifft
 * */
 function getNumberOfDaysOfReservation($reservierungs_id){
 	
 	global $root;
 	include_once($root."/include/datumFunctions.inc.php");
	
	$von = getDatumVonOfReservierung($reservierungs_id);
	$bis = getDatumBisOfReservierung($reservierungs_id);
	
	//mysql timestamp:
	// jjjjmmtthhm m
	// 01234567891011

	$jaVon = substr($von,0,4);
	$moVon = substr($von,4,2);
	$taVon = substr($von,6,2);
	$jaBis = substr($bis,0,4);
	$moBis = substr($bis,4,2);
	$taBis = substr($bis,6,2);
	
	$from = mktime(0,0,0,$moVon,$taVon,$jaVon);
	$to   = mktime(0,0,0,$moBis,$taBis,$jaBis);
	$anzahl = getNumberOfDaysOfTimestamp($from,$to);
	return $anzahl+1;
	
 }

/**
 * author:coster
 * date:17.10.05
 * prueft ob eine reservierung für den mieter vorhanden ist
 * */
function hasMieterReservations($mieter_id){
	global $link;

	$query = ("select
				RESERVIERUNG_ID as anzahl
				FROM 
				REZ_GEN_RESERVIERUNG
				WHERE
				MIETER_ID = '$mieter_id'
		   	  ");
			  
	$res = mysqli_query($link, $query);
	
	if (!$res)  {
		echo("die Anfrage $query scheitert");
		echo(mysqli_error($link));
		return false ;
	}
	else{
		$d = mysqli_fetch_array($res);
		if ($d["anzahl"] > 0){
			return true;
		}
	}
	return false;
}
/**
 * author:coster
 * date:20.10.05
 * prueft ob ein vermieter reservierungen mit einem bestimmten status hat
 * */
function hasVermieterReservations($vermieter_id,$status){
	global $link;

	$query = ("select
				r.RESERVIERUNG_ID as anzahl
				FROM 
				REZ_GEN_RESERVIERUNG r, REZ_GEN_MIETOBJEKT m
				WHERE
				m.VERMIETER_ID = '$vermieter_id' and
				r.MIETOBJEKT_ID = m.MIETOBJEKT_ID and
				r.STATUS = '$status'
		   	  ");
			  
	$res = mysqli_query($link, $query);
	
	if (!$res)  {
		echo("die Anfrage $query scheitert");
		echo(mysqli_error($link));
		return false ;
	}
	else{
		$d = mysqli_fetch_array($res);
		if ($d["anzahl"] > 0){
			return true;
		}
	}
	return false;
}
/**
 * author:coster
 * date: 20.10.05
 * liefert alle reservierungen eines vermieters mit einem bestimmten status
 * */
function getReservationsOfVermieter($vermieter_id,$status){
	global $link;

	$query = ("select
				r.*
				FROM 
				REZ_GEN_RESERVIERUNG r, REZ_GEN_MIETOBJEKT m
				WHERE
				m.VERMIETER_ID = '$vermieter_id' and
				r.MIETOBJEKT_ID = m.MIETOBJEKT_ID and
				r.STATUS = '$status'
				order by
				r.VON
		   	  ");
			  
	$res = mysqli_query($link, $query);
	
	if (!$res)  {
		echo("die Anfrage $query scheitert");
		echo(mysqli_error($link));
		return false ;
	}
	return $res;
}
/**
 * author:coster
 * date: 19.10.05
 * liefert alle reservierungen eines gastes
 * */
function getReservationsOfMieter($mieter_id){
	global $link;
	//daten eintragen:
	$query = ("select
				*
				FROM 
				REZ_GEN_RESERVIERUNG
				WHERE
				MIETER_ID = '$mieter_id'
		   	  ");
			  
	$res = mysqli_query($link, $query);
	
	if (!$res)  {
		echo("die Anfrage $query scheitert");
		echo(mysqli_error($link));
		return false ;
	}
	return $res;
}
/**
 * author: coster
   date: 20.10.05
   aendert den status einer reservierung
*/
function changeReservationState($res_id,$status){
	global $link;
	//daten eintragen:
	$query = ("UPDATE 
				REZ_GEN_RESERVIERUNG
				SET
				STATUS = '$status'
				WHERE
				RESERVIERUNG_ID = '$res_id'
		   	  ");
			  
	$res = mysqli_query($link, $query);
	
	if (!$res)  {
		echo("die Anfrage $query scheitert"); 
		echo(mysqli_error($link));
		return false;
	}

	return true;

}
/**
 * author:coster
 * date:4.11.05
 * löscht eine reservierung eines mieters
 * */
function deleteReservationWithDate($mietobjekt_id,$vonMinute,$vonStunde,$vonTag,$vonMonat,$vonJahr,$bisMinute,$bisStunde,$bisTag,$bisMonat,$bisJahr){
	
	global $link;
	global $root;
	include_once($root."/include/datumFunctions.inc.php");
	$von = constructMySqlTimestamp($vonMinute,$vonStunde,$vonTag,$vonMonat,$vonJahr);
	$bis = constructMySqlTimestamp($bisMinute,$bisStunde,$bisTag,$bisMonat,$bisJahr);	
	
	$query = ("DELETE FROM	
			   REZ_GEN_RESERVIERUNG
			   WHERE
			   (MIETOBJEKT_ID = $mietobjekt_id AND
			   ('$von' >= VON and '$bis' <= BIS))
			   OR
			   (MIETOBJEKT_ID = $mietobjekt_id AND
			   ('$von' < BIS and '$bis' <= BIS and '$bis' > VON))
			   OR
			   (MIETOBJEKT_ID = $mietobjekt_id AND	
			   ('$von' >= VON and '$bis' > BIS and '$von' < BIS))
			   	OR
			   (MIETOBJEKT_ID = $mietobjekt_id AND	
			   ('$von' <= VON and '$bis' >= BIS))");
			   
	$res = mysqli_query($link, $query);
	  
	if (!$res) {
		echo("die Anfrage $query scheitert");
		echo(mysqli_error($link));
		return false;
	}
			   
	return true;
			   
}
/**
 * author:coster
 * date:1.11.05
 * reservierungen innerhalb eines zeitraumes ausgeben
 * */
function getReservationWithDate($mietobjekt_id,$vonMinute,$vonStunde,$vonTag,$vonMonat,$vonJahr,$bisMinute,$bisStunde,$bisTag,$bisMonat,$bisJahr){
	global $link;
	global $root;
	
	include_once($root."/include/datumFunctions.inc.php");
	
	$vonDatum = constructMySqlTimestamp($vonMinute,$vonStunde,$vonTag,$vonMonat,$vonJahr);
	$bisDatum = constructMySqlTimestamp($bisMinute,$bisStunde,$bisTag,$bisMonat,$bisJahr);
	
	$query = ("SELECT	
			   RESERVIERUNG_ID
			   FROM
			   REZ_GEN_RESERVIERUNG
			   WHERE
			   (MIETOBJEKT_ID = $mietobjekt_id AND
			   ('$vonDatum' >= VON and '$bisDatum' <= BIS))
			   OR
			   (MIETOBJEKT_ID = $mietobjekt_id AND
			   ('$vonDatum' < BIS and '$bisDatum' <= BIS and '$bisDatum' > VON))
			   OR
			   (MIETOBJEKT_ID = $mietobjekt_id AND	
			   ('$vonDatum' >= VON and '$bisDatum' > BIS and '$vonDatum' < BIS))
			   	OR
			   (MIETOBJEKT_ID = $mietobjekt_id AND	
			   ('$vonDatum' <= VON and '$bisDatum' >= BIS)
			   )");
			   
	$res = mysqli_query($link, $query);
	  
	if (!$res) {
		echo("die Anfrage $query scheitert");
		echo(mysqli_error($link));
		return false;
	}
			   
	return $res;
			   
}

//funktion legt eine neue reservierung an:
function insertReservationWithDate($mietobjekt_id,$gast_id,$vonDatum,$bisDatum,$status,$anzahlErwachsene,$anzahlKinder){
	global $link;
	//zuerst alle eintraege in diesem zeitraum löschen:
	deleteReservationWithDate($mietobjekt_id,$vonDatum,$bisDatum);
	
	//daten eintragen:
	$query = ("insert into 
				REZ_GEN_RESERVIERUNG
				(MIETOBJEKT_ID,FK_Gast_ID,VON,BIS,Status,Erwachsene,Kinder)
				VALUES				
				('$mietobjekt_id','$gast_id','$vonDatum','$bisDatum','$status','$anzahlErwachsene','$anzahlKinder')
		   	  ");
			  
	$res = mysqli_query($link, $query);
	
	if (!$res)  
		echo("die Anfrage $query scheitert"); 

}
/**
 * author:coster
 * date: 21.10.05
 * funktion gibt die RESERVIERUNGS-id retour, die in diesem
 * zeitraum als reserviert oder belegt eingetragen ist:
 * 
 */
function getReservierungID($mietobjekt_id,$minute=0,$stunde=0,$tag,$monat,$jahr){
	
	global $link;
	global $root;
	include_once($root."/include/datumFunctions.inc.php");	

	$datum = constructMySqlTimestamp($minute,$stunde,$tag,$monat,$jahr);
	
	//daten aus datenbank abrufen...
	$query = "select 
				RESERVIERUNG_ID
				from 
				REZ_GEN_RESERVIERUNG
				where 		
				MIETOBJEKT_ID = '$mietobjekt_id' and
				('$datum' >= VON and '$datum' <= BIS)				
				";

  	$res = mysqli_query($link, $query);
  	if (!$res) {
  		echo("Anfrage $query scheitert.");
  		echo(mysqli_error($link));
  		return false;
	}
	else {	
		$d=mysqli_fetch_array($res);
		return $d["RESERVIERUNG_ID"];
	}

} //ende getReservierungID
/**
 * author:coster
 * date: 27.12.05
 * funktion gibt die RESERVIERUNGS-ids retour, die in diesem
 * zeitraum als belegt eingetragen ist:
 * @return mysql result set
 */
function getReservierungIDs($mietobjekt_id,$minuteVon,$stundeVon,$tagVon,$monatVon,$jahrVon,$minuteBis,$stundeBis,$tagBis,$monatBis,$jahrBis){
	
	global $link;
	global $root;
	include_once($root."/include/datumFunctions.inc.php");	

	$vonDatum = constructMySqlTimestamp($minuteVon,$stundeVon,$tagVon,$monatVon,$jahrVon);
	$bisDatum = constructMySqlTimestamp($minuteBis,$stundeBis,$tagBis,$monatBis,$jahrBis);
	$status = STATUS_BELEGT;
	
	//daten aus datenbank abrufen...
	$query = "select 
			   RESERVIERUNG_ID
			   FROM
			   REZ_GEN_RESERVIERUNG
			   WHERE" .
			   "(
			   (MIETOBJEKT_ID = $mietobjekt_id AND
			   ('$vonDatum' >= VON and '$bisDatum' <= BIS))
			   OR
			   (MIETOBJEKT_ID = $mietobjekt_id AND
			   ('$vonDatum' < BIS and '$bisDatum' <= BIS and '$bisDatum' > VON))
			   OR
			   (MIETOBJEKT_ID = $mietobjekt_id AND	
			   ('$vonDatum' >= VON and '$bisDatum' > BIS and '$vonDatum' < BIS))
			   	OR
			   (MIETOBJEKT_ID = $mietobjekt_id AND	
			   ('$vonDatum' <= VON and '$bisDatum' >= BIS))" .
			   " )" .
			   " and " .
			   " (STATUS = '$status')
			   order by
 			   VON";

  	$res = mysqli_query($link, $query);
  	if (!$res) {
  		echo("Anfrage $query scheitert.");
  		echo(mysqli_error($link));
  		return false;
	}
	else {	
		return $res;
	}

} //ende getReservierungIDs
/**
 * author:coster
 * date: 27.12.05
 * funktion zählt die RESERVIERUNGS-ids, die in diesem
 * zeitraum als reserviert oder belegt eingetragen ist:
 * @return anzahl der reservierungen
 */
function countReservierungIDs($mietobjekt_id,$minuteVon,$stundeVon,$tagVon,$monatVon,$jahrVon,$minuteBis,$stundeBis,$tagBis,$monatBis,$jahrBis){
	
	global $link;
	global $root;
	include_once($root."/include/datumFunctions.inc.php");	

	$vonDatum = constructMySqlTimestamp($minuteVon,$stundeVon,$tagVon,$monatVon,$jahrVon);
	$bisDatum = constructMySqlTimestamp($minuteBis,$stundeBis,$tagBis,$monatBis,$jahrBis);
	
	//daten aus datenbank abrufen...
	$query = "select 
			   count(RESERVIERUNG_ID) as anzahl
			   FROM
			   REZ_GEN_RESERVIERUNG
			   WHERE
			   (MIETOBJEKT_ID = $mietobjekt_id AND
			   ('$vonDatum' >= VON and '$bisDatum' <= BIS))
			   OR
			   (MIETOBJEKT_ID = $mietobjekt_id AND
			   ('$vonDatum' < BIS and '$bisDatum' <= BIS and '$bisDatum' > VON))
			   OR
			   (MIETOBJEKT_ID = $mietobjekt_id AND	
			   ('$vonDatum' >= VON and '$bisDatum' > BIS and '$vonDatum' < BIS))
			   	OR
			   (MIETOBJEKT_ID = $mietobjekt_id AND	
			   ('$vonDatum' <= VON and '$bisDatum' >= BIS)
			   )";
	

  	$res = mysqli_query($link, $query);
  	if (!$res) {
  		echo("Anfrage $query scheitert.");
  		echo(mysqli_error($link));
  		return false;
	}
	else {	
		$d=mysqli_fetch_array($res);
		return $d["anzahl"];
	}

} //ende getReservierungID
/**
 * author:coster
 * date:26.10.05
 * gibt die mieter id einer reservierung retour
 */
function getReservierungMieterId($mietobjekt_id,$minute,$stunde,$tag,$monat,$jahr){

	global $link;
	global $root;
	
	include_once($root."/include/datumFunctions.inc.php");
	
	$datum = constructMySqlTimestamp($minute,$stunde,$tag,$monat,$jahr);
	
	//daten aus datenbank abrufen...
	$query = "select 
				MIETER_ID
				from 
				REZ_GEN_RESERVIERUNG
				where 		
				MIETOBJEKT_ID = '$mietobjekt_id' and
				('$datum' >= VON and '$datum' <= BIS)				
				";

  	$res = mysqli_query($link, $query);
  	if (!$res) {
  		echo("Anfrage $query scheitert.");
  		echo(mysqli_error($link));
  		return false;
	}
	else {		
		//echo($query);
		$d = mysqli_fetch_array($res);
		return $d["MIETER_ID"];		
	}			

} 
/**
 * author:coster
 * date:28.12.05
 * gibt die mieter id einer reservierung retour
 */
function getMieterIdOfReservierung($reservierungs_id){

	global $link;
	global $root;
	
	//daten aus datenbank abrufen...
	$query = "select 
				MIETER_ID
				from 
				REZ_GEN_RESERVIERUNG
				where 			
				RESERVIERUNG_ID	= '$reservierungs_id'			
				";

  	$res = mysqli_query($link, $query);
  	if (!$res) {
  		echo("Anfrage $query scheitert.");
  		echo(mysqli_error($link));
  		return false;
	}
	else {		
		//echo($query);
		$d = mysqli_fetch_array($res);
		return $d["MIETER_ID"];		
	}			

} 
/**
 * author:coster
 * date:26.10.05
 * gibt den status als css klasse zurück
 * */
function parseStatus($stat){
	
	global $root;
	include_once($root."/include/cssFunctions.inc.php");

	if ($stat == STATUS_BELEGT){
		return BELEGT;
	}
	else if ($stat == STATUS_FREI){
		return FREI;
	}
	else if ($stat == STATUS_RESERVIERT){
		return RESERVIERT;
	}
	else{
		return false;
	}
}
/**
 * author:coster
 * date:26.10.05
 * funktion gibt den status dieses zimmers an
 * diesem tag als string für die css-class zurück
 *  
 */
function getStatusString($mietobjekt_id,$minute=0,$stunde=0,$tag,$monat,$jahr){
	global $link;
	global $root;
	
	include_once($root."/include/datumFunctions.inc.php");
	
	$datum = constructMySqlTimestamp($minute,$stunde,$tag,$monat,$jahr);
	
	//daten aus datenbank abrufen...
	$query = "select 
				STATUS
				from 
				REZ_GEN_RESERVIERUNG
				where 		
				MIETOBJEKT_ID = '$mietobjekt_id' and
				('$datum' >= VON and '$datum' <= BIS)				
				";

	$res = mysqli_query($link, $query);
	if (!$res){
		echo("Anfrage $query scheitert.");
		echo(mysqli_error($link));
		return false;
	}	
	
	$d = mysqli_fetch_array($res);
	$stat = $d["STATUS"];
	
	//wenn kein eintrag vorhanden ist,
	//frei zurückgeben:
	if (mysqli_num_fields($res) < 1 || $stat == ""){
		return parseStatus(STATUS_FREI);
	}

	return parseStatus($stat);

} 
/**
 * author:coster
 * date:26.10.05
 * funktion gibt ein array mit den status-nummern
 * zurück
 *  
 */
function getStatus($mietobjekt_id,$vonMinute,$vonStunde,$vonTag,$vonMonat,$vonJahr,$bisMinute,$bisStunde,$bisTag,$bisMonat,$bisJahr){	
	
	global $link;
	global $root;
	
	include_once($root."/include/datumFunctions.inc.php");
	
	$vonDatum = constructMySqlTimestamp($vonMinute,$vonStunde,$vonTag,$vonMonat,$vonJahr);
	$bisDatum = constructMySqlTimestamp($bisMinute,$bisStunde,$bisTag,$bisMonat,$bisJahr);
	
	//daten aus datenbank abrufen...
	$query = "select 
				STATUS
				from 
				REZ_GEN_RESERVIERUNG
				where 		
				MIETOBJEKT_ID = '$mietobjekt_id' and
			    (('$vonDatum' >= VON and '$bisDatum' <= BIS) 
			    OR
				('$vonDatum' < BIS and '$bisDatum' <= BIS and '$bisDatum' > VON) 
				OR	
			    ('$vonDatum' >= VON and '$bisDatum' > BIS and '$vonDatum' < BIS)
				OR	
			    ('$vonDatum' <= VON and '$bisDatum' >= BIS))			
				";

	$res = mysqli_query($link, $query);
//	echo($query);
	if (!$res){
		echo("Anfrage $query scheitert.");
		echo(mysqli_error($link));
		return false;
	}
		
	$i = 0;	$status=array();									
	while($d = mysqli_fetch_array($res)){
		$temp = $d["STATUS"];
		
		if ($temp != STATUS_RESERVIERT){ //reserviert nicht anzeigen
			$status[$i++] = $temp;
		}
	} //ende while
	
	return $status;
	
} //ende getStatus
/**
 * author:coster
 * date:1.11.05
 * funktion prüft, ob im angegebenen zeitraum das mietobjekt belegt ist:
 * @param $mietobjekt_id id of the object to rent
 * @param $vonMinute
 * @param $vonStunde
 * @param $vonTag
 * @param $vonMonat
 * @param $vonJahr
 * @param $bisMinute
 * @param $bisStunde
 * @param $bisTag
 * @param $bisMonat
 * @param $bisJahr
 * @return true if the object to rent is already rented, false if the object to rent is free
 * */
function isMietobjektTaken($mietobjekt_id,$vonMinute,$vonStunde,$vonTag,$vonMonat,$vonJahr,
	$bisMinute,$bisStunde,$bisTag,$bisMonat,$bisJahr){
	
	global $link;
	global $root;
	
	include_once($root."/include/datumFunctions.inc.php");
	
	$vonDatum = constructMySqlTimestamp($vonMinute,$vonStunde,$vonTag,$vonMonat,$vonJahr);	
	$bisDatum = constructMySqlTimestamp($bisMinute,$bisStunde,$bisTag,$bisMonat,$bisJahr);
	
	$status = STATUS_BELEGT;
	
	//daten aus datenbank abrufen...
	$query = "select 
				STATUS
				from 
				REZ_GEN_RESERVIERUNG
				where 		
				MIETOBJEKT_ID = '$mietobjekt_id' and
			    (('$vonDatum' >= VON and '$bisDatum' <= BIS) 
			    OR
				('$vonDatum' < BIS and '$bisDatum' <= BIS and '$bisDatum' > VON) 
				OR	
			    ('$vonDatum' >= VON and '$bisDatum' > BIS and '$vonDatum' < BIS)
				OR	
			    ('$vonDatum' <= VON and '$bisDatum' >= BIS))
				and
				Status = '$status'				
				";

  		$res = mysqli_query($link, $query);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  			echo(mysqli_error($link));
  			return false;
  		}
	
	$d = mysqli_fetch_array($res);
	if ($d["STATUS"] == STATUS_BELEGT){
		return true;
	}
	else{
		return false;
	}

} 
/**
 * author:coster
 * date:30.1.06
 * funktion prüft, ob der gesamte tag frei ist
 * */
function isFullDayFree($mietobjekt_id,$tag,$monat,$jahr){
	
	global $link;
	global $root;
	
	include_once($root."/include/datumFunctions.inc.php");	

	$vonDatum = constructMySqlTimestamp(0,0,$tag,$monat,$jahr);
	$bisDatum = constructMySqlTimestamp(59,23,$tag,$monat,$jahr);
	
	//daten aus datenbank abrufen...
	$query = "select 
				count(STATUS) as anzahl
				from 
				REZ_GEN_RESERVIERUNG
				where 		
				MIETOBJEKT_ID = '$mietobjekt_id' and
			    (('$vonDatum' >= VON and '$bisDatum' <= BIS) 
			    OR
				('$vonDatum' < BIS and '$bisDatum' <= BIS and '$bisDatum' > VON) 
				OR	
			    ('$vonDatum' >= VON and '$bisDatum' > BIS and '$vonDatum' < BIS)
				OR	
			    ('$vonDatum' <= VON and '$bisDatum' >= BIS))			
				";

  	$res = mysqli_query($link, $query);
  	if (!$res) {
  		echo("Anfrage $query scheitert.");
  		echo(mysqli_error($link));
  		return false;
	}
	else {	
		$d=mysqli_fetch_array($res);
		$anzahl = $d["anzahl"];
		if ($anzahl < 1){
			return true;
		}
	}
	return false;

} 
/**
 * author:coster
 * date:30.1.06
 * funktion prüft, ob der gesamte tag ausgebucht ist
 * */
function isFullDayBooked($mietobjekt_id,$tag,$monat,$jahr){
	
	global $link;
	global $root;
	
	include_once($root."/include/datumFunctions.inc.php");	

	$vonDatum = constructMySqlTimestamp(0,0,$tag,$monat,$jahr);
	$bisDatum = constructMySqlTimestamp(59,23,$tag,$monat,$jahr);
	
	//daten aus datenbank abrufen...
	$query = "select 
			   count(RESERVIERUNG_ID) as anzahl
			   FROM
			   REZ_GEN_RESERVIERUNG
			   WHERE
			   (
			   MIETOBJEKT_ID = $mietobjekt_id AND	
			   (VON <= '$vonDatum' and BIS >= '$bisDatum')
			   )";

  	$res = mysqli_query($link, $query);
  	if (!$res) {
  		echo("Anfrage $query scheitert.");
  		echo(mysqli_error($link));
  		return false;
	}
	else {	
		$d=mysqli_fetch_array($res);
		$anzahl = $d["anzahl"];
		if ($anzahl == 1){
			return true;
		}
	}
	return false;
	
} 
/**
 * author:coster
 * date:4.11.05
 * fügt eine neue reservierung ein
 * */
function insertReservation($mietobjekt_id,$mieter_id,$vonMinute,$vonStunde,$vonTag,$vonMonat,$vonJahr,$bisMinute,$bisStunde,$bisTag,$bisMonat,$bisJahr,$status){
	
	global $link;
	global $root;
	include_once($root."/include/datumFunctions.inc.php");
	$von = constructMySqlTimestamp($vonMinute,$vonStunde,$vonTag,$vonMonat,$vonJahr);
	$bis = constructMySqlTimestamp($bisMinute,$bisStunde,$bisTag,$bisMonat,$bisJahr);	
	
	//daten eintragen:
	$query = ("insert into 
				REZ_GEN_RESERVIERUNG
				(MIETOBJEKT_ID,MIETER_ID,VON,BIS,Status)
				VALUES				
				('$mietobjekt_id','$mieter_id','$von','$bis','$status')
		   	  ");
			  
	$res = mysqli_query($link, $query);
	if (!$res)  {
		echo("die Anfrage $query scheitert"); 
		echo(mysqli_error($link));
		return false;
	}
	
	return mysqli_insert_id($link);

}
/**
 * author:coster
 * date:20.10.05
 * löscht eine reservierung
 * */
function deleteReservation($id){	
	global $link;
	$query = ("DELETE from
			   REZ_GEN_RESERVIERUNG
			   WHERE				
			   RESERVIERUNG_ID = '$id'
		   	  ");

  	$res = mysqli_query($link, $query);
	if (!$res) { 
		echo("die Anfrage $query scheitert"); 
		echo(mysqli_error($link));
		return false;
	}
	return true;
} 
/**
 * author:coster
 * date:20.10.05
 * liefert das "von" datum einer reservierung
 * */
function getDatumVonOfReservierung($res_id){	
	
	global $link;
	
	$query = ("SELECT		 
			   VON
			   FROM
			   REZ_GEN_RESERVIERUNG
			   WHERE				
			   RESERVIERUNG_ID = '$res_id'
		   	  ");

  	$res = mysqli_query($link, $query);
	if (!$res) { 
		echo("die Anfrage $query scheitert"); 
		echo(mysqli_error($link));
		return false;
	}
	
	$d = mysqli_fetch_array($res);
	return $d["VON"];
	
} 
/**
 * author:coster
 * date:9.1.06
 * liefert die von zeit einer reservierung im format hh:mm
 * */
function getTimeVonOfReservierung($res_id){	
	
	$von = getDatumVonOfReservierung($res_id);
	$st = substr($von,8,2);
	$mi = substr($von,10,2);
	if ($st<10 && strlen($st)<=1){
		$st = "0".$st;
	}
	if ($mi<10 && strlen($mi)<=1){
		$mi = "0".$mi;
	}
	return $st.":".$mi;
	
} 
/**
 * author:coster
 * date:9.1.06
 * liefert die von zeit einer reservierung im format hh:mm
 * */
function getTimeBisOfReservierung($res_id){	
	
	$von = getDatumBisOfReservierung($res_id);
	$st = substr($von,8,2);
	$mi = substr($von,10,2);
	if ($st<10 && strlen($st)<=1){
		$st = "0".$st;
	}
	if ($mi<10 && strlen($mi)<=1){
		$mi = "0".$mi;
	}
	return $st.":".$mi;
	
} 
/**
 * author:coster
 * date:1.11.05
 * liefert das "bis" datum einer reservierung
 * */
function getDatumBisOfReservierung($res_id){	
	
	global $link;
	
	$query = ("SELECT		 
			   BIS
			   FROM
			   REZ_GEN_RESERVIERUNG
			   WHERE				
			   RESERVIERUNG_ID = '$res_id'
		   	  ");

  	$res = mysqli_query($link, $query);
	if (!$res) { 
		echo("die Anfrage $query scheitert"); 
		echo(mysqli_error($link));
		return false;
	}
	
	$d = mysqli_fetch_array($res);
	return $d["BIS"];
	
} 
/**
 * author:coster
 * date:20.10.05
 * liefert den status einer reservierung
 * */
function getStateOfReservierung($id){	
	global $link;
	$query = ("SELECT		 
			   STATUS
			   FROM
			   REZ_GEN_RESERVIERUNG
			   WHERE				
			   RESERVIERUNG_ID = '$id'
		   	  ");

  	$res = mysqli_query($link, $query);
	if (!$res) { 
		echo("die Anfrage $query scheitert"); 
		echo(mysqli_error($link));
		return false;
	}
	
	$d = mysqli_fetch_array($res);
	return $d["STATUS"];
	
}
/**
 * author:coster
 * date:20.10.05
 * liefert die mieter id auf grund einer reservierungs id
 * */
function getMieterIdFromReservierung($res_id){	
		global $link;
	$query = ("SELECT		 
			   MIETER_ID
			   FROM
			   REZ_GEN_RESERVIERUNG
			   WHERE				
			   RESERVIERUNG_ID = '$res_id'
		   	  ");

  	$res = mysqli_query($link, $query);
  	
	if (!$res)  {
		echo("die Anfrage $query scheitert"); 
		echo(mysqli_error($link));
		return false;
	}
	
	$d = mysqli_fetch_array($res);
	return $d["MIETER_ID"];
	
} 
/**
 * author:coster
 * date:20.10.05
 * liefert die mietobjekt id einer reservierung
 * */
function getMietobjektIdFromReservierung($res_id){	
	
	global $link;
	
	$query = ("SELECT		 
			   MIETOBJEKT_ID
			   FROM
			   REZ_GEN_RESERVIERUNG
			   WHERE				
			   RESERVIERUNG_ID = '$res_id'
		   	  ");

  	$res = mysqli_query($link, $query);
	if (!$res)  {
		echo("die Anfrage scheitert"); 
		echo(mysqli_error($link));
		return false;
	}
	$d = mysqli_fetch_array($res);
	return $d["MIETOBJEKT_ID"];
	
} 


?>
