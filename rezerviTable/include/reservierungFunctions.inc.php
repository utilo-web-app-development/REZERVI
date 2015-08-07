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
 * prueft ob eine reservierung f�r den mieter vorhanden ist
 * */
function hasMieterReservations($mieter_id){
	global $db;

	$query = ("select
				count(RESERVIERUNG_ID) as anzahl
				FROM 
				BOOKLINE_RESERVIERUNG
				WHERE
				GAST_ID = '$mieter_id'
		   	  ");
			  
	$res = $db->Execute($query);	
	
	if (!$res)  {
		
		print $db->ErrorMsg();
		die($query) ;
	}
	else{
		$anzahl = $res->fields["anzahl"];
		if ($anzahl > 0){
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
function hasVermieterReservations($gastro_id,$status){
	global $db;

	$query = ("select
				count(r.RESERVIERUNG_ID) as anzahl
				FROM 
				BOOKLINE_RESERVIERUNG r, BOOKLINE_TISCH m, BOOKLINE_RAUM a
				WHERE
				a.GASTRO_ID = '$gastro_id' and
				m.RAUM_ID = a.RAUM_ID and
				r.TISCH_ID = m.TISCHNUMMER and
				r.STATUS = '$status'
		   	  ");
			  
	$res = $db->Execute($query);	
	
	if (!$res)  {
		
		print $db->ErrorMsg();
		die($query);
		
	}
	else{
		$d = $res->fields["anzahl"];
		if (!empty($d) && $d > 0){
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
function getReservationsOfVermieter($gastro_id,$status){
	global $db;

	$query = ("select
				re.*
				FROM 
				BOOKLINE_RESERVIERUNG re, BOOKLINE_TISCH ti, BOOKLINE_RAUM ra
				WHERE
				ra.GASTRO_ID = '$gastro_id' and
				ti.RAUM_ID = ra.RAUM_ID and
				ti.TISCHNUMMER = re.TISCH_ID and
				re.STATUS = '$status'
				order by
				re.VON
		   	  ");
			  
	$res = $db->Execute($query);	
	
	if (!$res)  {
		
		print $db->ErrorMsg();
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
	global $db;
	//daten eintragen:
	$query = ("select
				*
				FROM 
				BOOKLINE_RESERVIERUNG
				WHERE
				GAST_ID = '$mieter_id'
		   	  ");
			  
	$res = $db->Execute($query);	
	
	if (!$res)  {
		
		print $db->ErrorMsg();
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
	global $db;
	//daten eintragen:
	$query = ("UPDATE 
				BOOKLINE_RESERVIERUNG
				SET
				STATUS = '$status'
				WHERE
				RESERVIERUNG_ID = '$res_id'
		   	  ");
			  
	$res = $db->Execute($query);	
	
	if (!$res)  {
		 
		print $db->ErrorMsg();
		return false;
	}

	return true;

}
/**
 * author:coster
 * date:4.11.05
 * l�scht eine reservierung eines mieters
 * */
function deleteReservationWithDate($tisch_id,$vonMinute,$vonStunde,$vonTag,$vonMonat,$vonJahr,$bisMinute,$bisStunde,$bisTag,$bisMonat,$bisJahr){
	
	global $db;
	global $root;
	include_once($root."/include/datumFunctions.inc.php");
	$von = constructMySqlTimestamp($vonMinute,$vonStunde,$vonTag,$vonMonat,$vonJahr);
	$bis = constructMySqlTimestamp($bisMinute,$bisStunde,$bisTag,$bisMonat,$bisJahr);	
	
	$query = ("DELETE FROM	
			   BOOKLINE_RESERVIERUNG
			   WHERE
			   (TISCH_ID = '$tisch_id' AND
			   ('$von' >= VON and '$bis' <= BIS))
			   OR
			   (TISCH_ID = '$tisch_id' AND
			   ('$von' < BIS and '$bis' <= BIS and '$bis' > VON))
			   OR
			   (TISCH_ID = '$tisch_id' AND	
			   ('$von' >= VON and '$bis' > BIS and '$von' < BIS))
			   	OR
			   (TISCH_ID = '$tisch_id' AND	
			   ('$von' <= VON and '$bis' >= BIS))");
			   
	$res = $db->Execute($query);		
	  
	if (!$res) {		
		print $db->ErrorMsg();
		return false;
	}
			   
	return true;
			   
}
/**
 * author:lihaitao
 * date:10.10.07
 * reservierungen innerhalb eines zeitraumes ausgeben
 * */
function getReservationWithDate($tisch_id,$vonMinute,$vonStunde,$vonTag,$vonMonat,$vonJahr,$bisMinute,$bisStunde,$bisTag,$bisMonat,$bisJahr){
	global $db;
	global $root;
	
	include_once($root."/include/datumFunctions.inc.php");
	
	$vonDatum = constructMySqlTimestamp($vonMinute,$vonStunde,$vonTag,$vonMonat,$vonJahr);
	$bisDatum = constructMySqlTimestamp($bisMinute,$bisStunde,$bisTag,$bisMonat,$bisJahr);
	
	$query = ("SELECT	
			   RESERVIERUNG_ID
			   FROM
			   BOOKLINE_RESERVIERUNG
			   WHERE
			   (TISCH_ID = '$tisch_id' AND
			   ('$vonDatum' >= VON and '$bisDatum' <= BIS))
			   OR
			   (TISCH_ID = '$tisch_id' AND
			   ('$vonDatum' < BIS and '$bisDatum' <= BIS and '$bisDatum' > VON))
			   OR
			   (TISCH_ID = '$tisch_id' AND	
			   ('$vonDatum' >= VON and '$bisDatum' > BIS and '$vonDatum' < BIS))
			   	OR
			   (TISCH_ID = '$tisch_id' AND	
			   ('$vonDatum' <= VON and '$bisDatum' >= BIS)
			   )");
			   
	$res = $db->Execute($query);		
	  
	if (!$res) {
		
		print $db->ErrorMsg();
		return false;
	}
			   
	return $res;
			   
}

//funktion legt eine neue reservierung an:
function insertReservationWithDate($mietobjekt_id,$gast_id,$vonDatum,$bisDatum,$status,$anzahlErwachsene,$anzahlKinder){
	global $db;
	//zuerst alle eintraege in diesem zeitraum l�schen:
	deleteReservationWithDate($mietobjekt_id,$vonDatum,$bisDatum);
	
	//daten eintragen:
	$query = ("insert into 
				BOOKLINE_RESERVIERUNG
				(MIETOBJEKT_ID,FK_Gast_ID,VON,BIS,Status,Erwachsene,Kinder)
				VALUES				
				('$mietobjekt_id','$gast_id','$vonDatum','$bisDatum','$status','$anzahlErwachsene','$anzahlKinder')
		   	  ");
			  
	$res = $db->Execute($query);	
	
	if (!$res)  {
		print $db->ErrorMsg();
	}
		 

}
/**
 * author:coster
 * date: 21.10.05
 * funktion gibt die RESERVIERUNGS-id retour, die in diesem
 * zeitraum als reserviert oder belegt eingetragen ist:
 * 
 */
function getReservierungID($mietobjekt_id,$minute=0,$stunde=0,$tag,$monat,$jahr){
	
	global $db;
	global $root;
	include_once($root."/include/datumFunctions.inc.php");	

	$datum = constructMySqlTimestamp($minute,$stunde,$tag,$monat,$jahr);
	
	//daten aus datenbank abrufen...
	$query = "select 
				RESERVIERUNG_ID
				from 
				BOOKLINE_RESERVIERUNG
				where 		
				TISCH_ID = '$mietobjekt_id' and
				('$datum' >= VON and '$datum' <= BIS)				
				";
  	$res = $db->Execute($query);
  	
  	if (!$res) {
  		
  		print $db->ErrorMsg();
  		return false;
  		
	}
	else {	
		$d=$res->FetchNextObject();	
		if ($d){
			return $d->RESERVIERUNG_ID;
		}
	}
	return false;

} //ende getReservierungID
/**
 * author:coster
 * date: 27.12.05
 * funktion gibt die RESERVIERUNGS-ids retour, die in diesem
 * zeitraum als belegt eingetragen ist:
 * @return mysql result set
 */
function getReservierungIDs($mietobjekt_id,$minuteVon,$stundeVon,$tagVon,$monatVon,$jahrVon,$minuteBis,$stundeBis,$tagBis,$monatBis,$jahrBis){
	
	global $db;
	global $root;
	include_once($root."/include/datumFunctions.inc.php");	

	$vonDatum = constructMySqlTimestamp($minuteVon,$stundeVon,$tagVon,$monatVon,$jahrVon);
	$bisDatum = constructMySqlTimestamp($minuteBis,$stundeBis,$tagBis,$monatBis,$jahrBis);
	$status = STATUS_BELEGT;
	
	//daten aus datenbank abrufen...
	$query = "select 
			   RESERVIERUNG_ID
			   FROM
			   BOOKLINE_RESERVIERUNG
			   WHERE" .
			   "(
			   (TISCH_ID = '$mietobjekt_id' AND
			   ('$vonDatum' >= VON and '$bisDatum' <= BIS))
			   OR
			   (TISCH_ID = '$mietobjekt_id' AND
			   ('$vonDatum' < BIS and '$bisDatum' <= BIS and '$bisDatum' > VON))
			   OR
			   (TISCH_ID = '$mietobjekt_id' AND	
			   ('$vonDatum' >= VON and '$bisDatum' > BIS and '$vonDatum' < BIS))
			   	OR
			   (TISCH_ID = '$mietobjekt_id' AND	
			   ('$vonDatum' <= VON and '$bisDatum' >= BIS))" .
			   " )" .
			   " and " .
			   " (STATUS = '$status')
			   order by
 			   VON";

  	$res = $db->Execute($query);
  	if (!$res) {
  		
  		print $db->ErrorMsg();
  		return false;
	}
	else {	
		return $res;
	}

} //ende getReservierungIDs
/**
 * author:coster
 * date: 27.12.05
 * funktion z�hlt die RESERVIERUNGS-ids, die in diesem
 * zeitraum als reserviert oder belegt eingetragen ist:
 * @return anzahl der reservierungen
 */
function countReservierungIDs($mietobjekt_id,$minuteVon,$stundeVon,$tagVon,$monatVon,$jahrVon,$minuteBis,$stundeBis,$tagBis,$monatBis,$jahrBis){
	
	global $db;
	global $root;
	include_once($root."/include/datumFunctions.inc.php");	

	$vonDatum = constructMySqlTimestamp($minuteVon,$stundeVon,$tagVon,$monatVon,$jahrVon);
	$bisDatum = constructMySqlTimestamp($minuteBis,$stundeBis,$tagBis,$monatBis,$jahrBis);
	
	//daten aus datenbank abrufen...
	$query = "select 
			   count(RESERVIERUNG_ID) as anzahl
			   FROM
			   BOOKLINE_RESERVIERUNG
			   WHERE
			   (TISCH_ID = '$mietobjekt_id' AND
			   ('$vonDatum' >= VON and '$bisDatum' <= BIS))
			   OR
			   (TISCH_ID = '$mietobjekt_id' AND
			   ('$vonDatum' < BIS and '$bisDatum' <= BIS and '$bisDatum' > VON))
			   OR
			   (TISCH_ID = '$mietobjekt_id' AND	
			   ('$vonDatum' >= VON and '$bisDatum' > BIS and '$vonDatum' < BIS))
			   	OR
			   (TISCH_ID = '$mietobjekt_id' AND	
			   ('$vonDatum' <= VON and '$bisDatum' >= BIS)
			   )";
	

  	$res = $db->Execute($query);
  	if (!$res) {  		
  		print $db->ErrorMsg();
  		return false;
	}
	else {	
		return $res->fields["anzahl"];
	}

} //ende getReservierungID
/**
 * author:coster
 * date:26.10.05
 * gibt die mieter id einer reservierung retour
 */
function getReservierungMieterId($mietobjekt_id,$minute,$stunde,$tag,$monat,$jahr){

	global $db;
	global $root;
	
	include_once($root."/include/datumFunctions.inc.php");
	
	$datum = constructMySqlTimestamp($minute,$stunde,$tag,$monat,$jahr);
	
	//daten aus datenbank abrufen...
	$query = "select 
				GAST_ID
				from 
				BOOKLINE_RESERVIERUNG
				where 		
				TISCH_ID = '$mietobjekt_id' and
				('$datum' >= VON and '$datum' <= BIS)				
				";

  	$res = $db->Execute($query);
  	if (!$res) {
  		
  		print $db->ErrorMsg();
  		return false;
	}
	else {		
		//echo($query);
		$d = $res->FetchNextObject();
		return $d->GAST_ID;		
	}			

} 
/**
 * author:coster
 * date:28.12.05
 * gibt die mieter id einer reservierung retour
 */
function getMieterIdOfReservierung($reservierungs_id){

	global $db;
	global $root;
	
	//daten aus datenbank abrufen...
	$query = "select 
				GAST_ID
				from 
				BOOKLINE_RESERVIERUNG
				where 			
				RESERVIERUNG_ID	= '$reservierungs_id'			
				";

  	$res = $db->Execute($query);
  	if (!$res) {
  		
  		print $db->ErrorMsg();
  		return false;
	}
	else {		
		//echo($query);
		$d = $res->FetchNextObject();
		return $d->GAST_ID;		
	}			

} 
/**
 * author:coster
 * date:26.10.05
 * gibt den status als css klasse zur�ck
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
 * diesem tag als string f�r die css-class zur�ck
 *  
 */
function getStatusString($mietobjekt_id,$minute=0,$stunde=0,$tag,$monat,$jahr){
	global $db;
	global $root;
	
	include_once($root."/include/datumFunctions.inc.php");
	
	$datum = constructMySqlTimestamp($minute,$stunde,$tag,$monat,$jahr);
	
	//daten aus datenbank abrufen...
	$query = "select 
				STATUS
				from 
				BOOKLINE_RESERVIERUNG
				where 		
				TISCH_ID = '$mietobjekt_id' and
				('$datum' >= VON and '$datum' <= BIS)				
				";

	$res = $db->Execute($query);
	if (!$res){
		
		print $db->ErrorMsg();
		return false;
	}	
	
	$d = $res->FetchNextObject();
	$stat = $d->STATUS;
	
	//wenn kein eintrag vorhanden ist,
	//frei zur�ckgeben:
	if (mysql_num_fields($res) < 1 || $stat == ""){
		return parseStatus(STATUS_FREI);
	}

	return parseStatus($stat);

} 
/**
 * author:coster
 * date:26.10.05
 * funktion gibt ein array mit den status-nummern
 * zur�ck
 *  
 */
function getStatus($mietobjekt_id,$vonMinute,$vonStunde,$vonTag,$vonMonat,$vonJahr,$bisMinute,$bisStunde,$bisTag,$bisMonat,$bisJahr){	
	
	global $db;
	global $root;
	
	include_once($root."/include/datumFunctions.inc.php");
	
	$vonDatum = constructMySqlTimestamp($vonMinute,$vonStunde,$vonTag,$vonMonat,$vonJahr);
	$bisDatum = constructMySqlTimestamp($bisMinute,$bisStunde,$bisTag,$bisMonat,$bisJahr);
	
	//daten aus datenbank abrufen...
	$query = "select 
				STATUS
				from 
				BOOKLINE_RESERVIERUNG
				where 		
				TISCH_ID = '$mietobjekt_id' and
			    (('$vonDatum' >= VON and '$bisDatum' <= BIS) 
			    OR
				('$vonDatum' < BIS and '$bisDatum' <= BIS and '$bisDatum' > VON) 
				OR	
			    ('$vonDatum' >= VON and '$bisDatum' > BIS and '$vonDatum' < BIS)
				OR	
			    ('$vonDatum' <= VON and '$bisDatum' >= BIS))			
				";

	$res = $db->Execute($query);
//	echo($query);
	if (!$res){
		
		print $db->ErrorMsg();
		return false;
	}
		
	$i = 0;	$status=array();									
	while($d = $res->FetchNextObject()){
		$temp = $d->STATUS;
		
		if ($temp != STATUS_RESERVIERT){ //reserviert nicht anzeigen
			$status[$i++] = $temp;
		}
	} //ende while
	
	return $status;
	
} //ende getStatus
/**
 * author:coster
 * date:1.11.05
 * funktion pr�ft, ob im angegebenen zeitraum das mietobjekt belegt ist:
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
	
	global $db;
	global $root;
	
	include_once($root."/include/datumFunctions.inc.php");
	
	$vonDatum = constructMySqlTimestamp($vonMinute,$vonStunde,$vonTag,$vonMonat,$vonJahr);	
	$bisDatum = constructMySqlTimestamp($bisMinute,$bisStunde,$bisTag,$bisMonat,$bisJahr);
	
	$status = STATUS_BELEGT;
	
	//daten aus datenbank abrufen...
	$query = "select 
				STATUS
				from 
				BOOKLINE_RESERVIERUNG
				where 		
				TISCH_ID = '$mietobjekt_id' and
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

  		$res = $db->Execute($query);
  		if (!$res){
  			
  			print $db->ErrorMsg();
  			return false;
  		}
	
	$d = $res->FetchNextObject();	
	if (!empty($d) && $d->STATUS == STATUS_BELEGT){

		return true;
	}
	else{

		return false;
	}

} 
/**
 * author:coster
 * date:30.1.06
 * funktion pr�ft, ob der gesamte tag frei ist
 * */
function isFullDayFree($mietobjekt_id,$tag,$monat,$jahr){
	
	global $db;
	global $root;
	
	include_once($root."/include/datumFunctions.inc.php");	

	$vonDatum = constructMySqlTimestamp(0,0,$tag,$monat,$jahr);
	$bisDatum = constructMySqlTimestamp(59,23,$tag,$monat,$jahr);
	
	//daten aus datenbank abrufen...
	$query = "select 
				count(STATUS) as anzahl
				from 
				BOOKLINE_RESERVIERUNG
				where 		
				TISCH_ID = '$mietobjekt_id' and
			    (('$vonDatum' >= VON and '$bisDatum' <= BIS) 
			    OR
				('$vonDatum' < BIS and '$bisDatum' <= BIS and '$bisDatum' > VON) 
				OR	
			    ('$vonDatum' >= VON and '$bisDatum' > BIS and '$vonDatum' < BIS)
				OR	
			    ('$vonDatum' <= VON and '$bisDatum' >= BIS))			
				";

  	$res = $db->Execute($query);
  	if (!$res) {
  		
  		print $db->ErrorMsg();
  		return false;
	}
	else {			
		$anzahl = $res->fields["anzahl"];
		if ($anzahl < 1){
			return true;
		}
	}
	return false;

} 
/**
 * author:coster
 * date:30.1.06
 * funktion pr�ft, ob der gesamte tag ausgebucht ist
 * */
function isFullDayBooked($mietobjekt_id,$tag,$monat,$jahr){
	
	global $db;
	global $root;
	
	include_once($root."/include/datumFunctions.inc.php");	

	$vonDatum = constructMySqlTimestamp(0,0,$tag,$monat,$jahr);
	$bisDatum = constructMySqlTimestamp(59,23,$tag,$monat,$jahr);
	
	//daten aus datenbank abrufen...
	$query = "select 
			   count(RESERVIERUNG_ID) as anzahl
			   FROM
			   BOOKLINE_RESERVIERUNG
			   WHERE
			   (
			   TISCH_ID = '$mietobjekt_id' AND	
			   (VON <= '$vonDatum' and BIS >= '$bisDatum')
			   )";

  	$res = $db->Execute($query);
  	if (!$res) {
  		
  		print $db->ErrorMsg();
  		return false;
	}
	else {	
		$anzahl = $res->fields["anzahl"];
		if ($anzahl == 1){
			return true;
		}
	}
	return false;
	
} 
/**
 * @author:coster
 * date:25.6.2007
 * fuegt eine neue reservierung fuer einen tisch ein
 * 
 * */
function insertReservation($tisch_id,$gast_id,$anzahlPersonen,$vonMinute,$vonStunde,$vonTag,$vonMonat,$vonJahr,$status){
	
	global $db;
	global $root;
	include_once($root."/include/datumFunctions.inc.php");
	include_once($root."/include/vermieterFunctions.inc.php");
	include_once($root."/include/mietobjektFunctions.inc.php");
	
	//echo("min: ".$vonMinute." std: ".$vonStunde." tag: ".$vonTag." mnt: ".$vonMonat." jhr:".$vonJahr);	
	
	//erzeuge bis datum:    
	$gastro_id = getGastroOfRaum(getRaumOfTisch($tisch_id));
	$reservierungsdauer = getGastroProperty(RESERVIERUNGSDAUER,$gastro_id);
	//int mktime ( [int $Stunde [, int $Minute [, int $Sekunde [, int $Monat [, int $Tag [, int $Jahr [, int $is_dst]]]]]]] )
	$timeBis = mktime($vonStunde,($vonMinute+$reservierungsdauer),0,$vonMonat,$vonTag,$vonJahr);
	$bisMinute = date("i",$timeBis);
	$bisStunde = date("H",$timeBis);
 	$bisTag    = date("d",$timeBis);
	$bisMonat  = date("m",$timeBis);
	$bisJahr   = date("Y",$timeBis);
	
	//echo("min: ".$bisMinute." std: ".$bisStunde." tag: ".$bisTag." mnt: ".$bisMonat." jhr:".$bisJahr); exit;
	
	$von = constructMySqlTimestamp($vonMinute,$vonStunde,$vonTag,$vonMonat,$vonJahr);
	$bis = constructMySqlTimestamp($bisMinute,$bisStunde,$bisTag,$bisMonat,$bisJahr);	
	
	//daten eintragen:
	$query = ("insert into 
				BOOKLINE_RESERVIERUNG
				(TISCH_ID,GAST_ID,VON,BIS,Status,ANZAHL_PERSONEN)
				VALUES				
				('$tisch_id','$gast_id','$von','$bis','$status','$anzahlPersonen')
		   	  ");
			  
	$res = $db->Execute($query);	
	if (!$res)  {
		 
		print $db->ErrorMsg();
		return false;
	}
	
	return $db->Insert_ID();

}

/**
 * @author:lihaitao
 * date:10.10.2007
 * fuegt eine neue reservierung fuer einen tisch ein
 * 
 * */
function insertReservation1($tisch_id,$gast_id,$anzahlPersonen,$vonMinute,$vonStunde,$vonTag,$vonMonat,$vonJahr,$bisMinute,$bisStunde,$bisTag,$bisMonat,$bisJahr,$status){
	global $db;
	global $root;
	include_once($root."/include/datumFunctions.inc.php");
	include_once($root."/include/vermieterFunctions.inc.php");
	include_once($root."/include/mietobjektFunctions.inc.php");

	//erzeuge bis datum:    
	$gastro_id = getGastroOfRaum(getRaumOfTisch($tisch_id));
	$von = constructMySqlTimestamp($vonMinute,$vonStunde,$vonTag,$vonMonat,$vonJahr);
	$bis = constructMySqlTimestamp($bisMinute,$bisStunde,$bisTag,$bisMonat,$bisJahr);	
	$query = ("insert into 
				BOOKLINE_RESERVIERUNG
				(TISCH_ID,GAST_ID,VON,BIS,Status,ANZAHL_PERSONEN)
				VALUES				
				('$tisch_id','$gast_id','$von','$bis','$status','$anzahlPersonen')
		   	  ");
			  
	$res = $db->Execute($query);	
	if (!$res)  {		 
		print $db->ErrorMsg();
		return "false";
	}
	
	return "true";

}

/**
 * author:coster
 * date:20.10.05
 * l�scht eine reservierung
 * */
function deleteReservation($id){	
	global $db;
	$query = ("DELETE from
			   BOOKLINE_RESERVIERUNG
			   WHERE				
			   RESERVIERUNG_ID = '$id'
		   	  ");

  	$res = $db->Execute($query);
	if (!$res) { 
		 
		print $db->ErrorMsg();
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
	
	global $db;
	
	$query = ("SELECT		 
			   VON
			   FROM
			   BOOKLINE_RESERVIERUNG
			   WHERE				
			   RESERVIERUNG_ID = '$res_id'
		   	  ");

  	$res = $db->Execute($query);
	if (!$res) { 
		 
		print $db->ErrorMsg();
		return false;
	}
	
	$d = $res->FetchNextObject();
	if (!empty($d)){
		return $d->VON;
	}
	return false;
	
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
	
	global $db;
	
	$query = ("SELECT		 
			   BIS
			   FROM
			   BOOKLINE_RESERVIERUNG
			   WHERE				
			   RESERVIERUNG_ID = '$res_id'
		   	  ");

  	$res = $db->Execute($query);
	if (!$res) { 
		 
		print $db->ErrorMsg();
		return false;
	}
	
	$d = $res->FetchNextObject();
	if (!empty($d)){
		return $d->BIS;
	}
	return false;
	
} 
/**
 * author:coster
 * date:20.10.05
 * liefert den status einer reservierung
 * */
function getStateOfReservierung($id){	
	global $db;
	$query = ("SELECT		 
			   STATUS
			   FROM
			   BOOKLINE_RESERVIERUNG
			   WHERE				
			   RESERVIERUNG_ID = '$id'
		   	  ");

  	$res = $db->Execute($query);
	if (!$res) { 
		 
		print $db->ErrorMsg();
		return false;
	}
	
	$d = $res->FetchNextObject();
	return $d->STATUS;
	
}
/**
 * author:coster
 * date:20.10.05
 * liefert die mieter id auf grund einer reservierungs id
 * */
function getMieterIdFromReservierung($res_id){	
		global $db;
	$query = ("SELECT		 
			   GAST_ID
			   FROM
			   BOOKLINE_RESERVIERUNG
			   WHERE				
			   RESERVIERUNG_ID = '$res_id'
		   	  ");

  	$res = $db->Execute($query);
  	
	if (!$res)  {
		 
		print $db->ErrorMsg();
		return false;
	}
	
	$d = $res->FetchNextObject();
	if (!empty($d)){
		return $d->GAST_ID;
	}
	return false;
} 
/**
 * author:coster
 * date:20.10.05
 * liefert die mietobjekt id einer reservierung
 * */
function getMietobjektIdFromReservierung($res_id){	
	
	global $db;
	
	$query = ("SELECT		 
			   TISCH_ID
			   FROM
			   BOOKLINE_RESERVIERUNG
			   WHERE				
			   RESERVIERUNG_ID = '$res_id'
		   	  ");

  	$res = $db->Execute($query);
	if (!$res)  {
		echo("die Anfrage scheitert"); 
		print $db->ErrorMsg();
		return false;
	}
	$d = $res->FetchNextObject();
	return $d->TISCH_ID;
	
} 

/**
 * author:lihaitao
 * date:11.10.07
 * return the duration in hours
 * 
 * */
function getDurationOfReservierung($res_id){
	$von = getDatumVonOfReservierung($res_id);
	$bis = getDatumBisOfReservierung($res_id);
	$vonStunde = getHourFromBooklineDate($von);
	$bisStunde = getHourFromBooklineDate($bis);
	$vonMinute = getMinuteFromBooklineDate($von);
	if($vonMinute<30){
		$vonMinute = 0;
	}else{
		$vonMinute = 0.5;
	}
	$bisMinute = getMinuteFromBooklineDate($bis);
	if($bisMinute<30){
		$bisMinute = 0;
	}else{
		$bisMinute = 0.5;
	}
//	echo "ID:".$res_id." "."vonStunde:".$vonStunde." "."bis:".$bisStunde." "."vonMin:".$vonMinute."bis:".$bisMinute;exit;
	return $bisStunde+$bisMinute-$vonStunde-$vonMinute;
}

function changeReservationTime($res_id,$tisch_id,$vonMinute,$vonStunde, $bisMinute,$bisStunde, $tag, $monat, $jahr){

	global $db;
	global $root;
	include_once($root."/include/datumFunctions.inc.php");
	$von = constructMySqlTimestamp($vonMinute,$vonStunde,$tag,$monat,$jahr);
	$bis = constructMySqlTimestamp($bisMinute,$bisStunde,$tag,$monat,$jahr);	
	
	//daten eintragen:
	$query = ("UPDATE 
				BOOKLINE_RESERVIERUNG
				SET
				VON = '$von',
				BIS = '$bis',
				TISCH_ID = '$tisch_id'
				WHERE
				RESERVIERUNG_ID = '$res_id'
		   	  ");
			  
	$res = $db->Execute($query);	
	
	if (!$res)  {
		 
		print $db->ErrorMsg();
		return false;
	}

	return true;
}

function hasReservierung($reservierung_id, $mietobjekt_id,$minuteVon,$stundeVon,$tagVon,$monatVon,$jahrVon,$minuteBis,$stundeBis,$tagBis,$monatBis,$jahrBis){
	$resIds = getReservierungIDs($mietobjekt_id,$minuteVon,$stundeVon,$tagVon,$monatVon,$jahrVon,$minuteBis,$stundeBis,$tagBis,$monatBis,$jahrBis);
	$result = false;
	if($resIds == false){
		return false;
	}else{
		while ($d = $resIds->FetchNextObject()){
			if($reservierung_id != $d->RESERVIERUNG_ID){
				return true;
			}			
		}
		return $result;
	}
}
?>
