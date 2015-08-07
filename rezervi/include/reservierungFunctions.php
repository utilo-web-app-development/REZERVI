<?php

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 

/* state of the reservations */
define("STATUS_FREI",0); //free
define("STATUS_RESERVIERT",1); //reserved
define("STATUS_BELEGT",2); //occupied

/**
 * get the room id of the reservation
 * */
function getZimmerID($id,$link){	
		
	$query = ("SELECT		 
			   FK_Zimmer_ID
			   FROM
			   Rezervi_Reservierung
			   WHERE				
			   PK_ID = '$id'
		   	  ");

  	$res = mysql_query($query, $link);
	if (!$res)  
		echo("die Anfrage scheitert"); 
	$d = mysql_fetch_array($res);
	return $d["FK_Zimmer_ID"];
	
} //ende getZimmerID

/**
 * @author coster
 * generates a mysql timestamp
 * @return the current timestamp in mysql format
 */
 function generateMySqlTimestamp(){
 	
	//seconds, minutes, milliseconds not necassary
 	$date = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
	//generate mysql timestamp format:
	return date("Y-m-d H:i:s",$date);
 }
/**
 * @author coster
 * returns all reservation before the given date
 * @return all reservation before the given date
 * @param $date 
 * @param $state the state of the reservation
 */
function getReservationsBefore($date,$state){
		
		global $link;
		global $unterkunft_id;
		
		$query = ("SELECT	
			   r.PK_ID
			   FROM
			   Rezervi_Reservierung r, Rezervi_Zimmer z, Rezervi_Unterkunft u
			   WHERE
			   r.FK_Zimmer_ID = z.PK_ID AND
			   z.FK_Unterkunft_ID = '$unterkunft_id' AND
			   r.ANFRAGEDATUM <= '$date' AND
			   r.STATUS = '$state'
			   ");
	   
	$res = mysql_query($query, $link);		
	  
	if (!$res) {
		echo("die Anfrage $query scheitert");
		echo(mysql_error($link));
		exit;
	}
			   
	return $res;
		
}
/**
 * @author coster
 * deletes all reservation before the given date
 * @param $date 
 * @param $state the state of the reservation
 */
function deleteReservationsBefore($date,$state){
	global $link; //db link	
	$res = getReservationsBefore($date,$state);
	while ($d = mysql_fetch_array($res)){
		$id = $d["PK_ID"];
		deleteReservation($id,$link);
	}		
}
/**
 * @author coster
 * deletes all reservation before the current date minus $xDays
 * @param $xDays 
 * @param $state the state of the reservation
 */
function deleteReservationsBeforeXDays($xDays,$state){
	global $link; //db link	

	$date = mktime(0, 0, 0, date("m")  , date("d")-$xDays, date("Y"));
	//generate mysql timestamp format:
	$date = date("Y-m-d H:i:s",$date);
	
	$res = getReservationsBefore($date,$state);
	while ($d = mysql_fetch_array($res)){
		$id = $d["PK_ID"];
		deleteReservation($id,$link);
	}		
}
/**
 * @author coster
 * gets all reservation before the current date minus $xDays
 * @param $xDays 
 * @param $state the state of the reservation
 */
function getReservationsBeforeXDays($xDays,$state){
	global $link; //db link	

	$date = mktime(0, 0, 0, date("m")  , date("d")-$xDays, date("Y"));
	//generate mysql timestamp format:
	$date = date("Y-m-d H:i:s",$date);
	
	$res = getReservationsBefore($date,$state);
	return $res;
		
}
/**
get the reservation with the given id
@param res_id the id of the reservation
@return the reservation with the given id
* */
function getReservation($res_id){

	global $link;
	$query = "select * from Rezervi_Reservierung where PK_ID = '$res_id'";
	$res = mysql_query($query, $link);
	if (!$res)  {
		die("die Anfrage $query scheitert"); 
	}
	return mysql_fetch_array($res);
	
}
/**
aendert den status einer reservierung
author: coster
date: 9.9.05
*/
function changeReservationState($res_id,$status,$link){
	
	//daten eintragen:
	$query = ("UPDATE 
				Rezervi_Reservierung
				SET
				Status = '$status'
				WHERE
				PK_ID = '$res_id'
		   	  ");
			  
	$res = mysql_query($query, $link);	
	
	if (!$res)  {
		echo("die Anfrage $query scheitert"); 
	}
	
	$reservierung = getReservation($res_id);
	$gast_id = $reservierung['FK_Gast_ID'];
	$datum_von=$reservierung['Datum_von'];
	$datum_bis=$reservierung['Datum_bis'];

	//auch fuer alle child rooms aendern:
	$query = ("select FK_Zimmer_ID from Rezervi_Reservierung where PK_ID = '$res_id'");
	$res = mysql_query($query, $link);	
	$d = mysql_fetch_array($res);
	$zimmer_id = $d['FK_Zimmer_ID'];	
	$resu = getChildRooms($zimmer_id);
	if (!empty($resu)){
		while ($d = mysql_fetch_array($resu)){
			$child = $d['PK_ID'];
			
			$query = ("update Rezervi_Reservierung ".
					  "set Status = '$status' where FK_Zimmer_ID = '$child' ".
					  "and FK_Gast_ID = '$gast_id' and Datum_von = '$datum_von' and ".
					  "Datum_bis = '$datum_bis'");
			$res = mysql_query($query, $link);
			if (!$res)  {
				die("die Anfrage $query scheitert"); 
			}
			
		}	
	}
	
	return true;

}

//reservierung eines zimmer löschen:
function deleteReservationWithDate($zimmer_id,$vonDatum,$bisDatum,$link){

	$query = ("DELETE FROM	
			   Rezervi_Reservierung
			   WHERE
			   (FK_Zimmer_ID = $zimmer_id AND
			   ('$vonDatum' >= Datum_von and '$bisDatum' <= Datum_bis))
			   OR
			   (FK_Zimmer_ID = $zimmer_id AND
			   ('$vonDatum' < Datum_bis and '$bisDatum' <= Datum_bis and '$bisDatum' > Datum_von))
			   OR
			   (FK_Zimmer_ID = $zimmer_id AND	
			   ('$vonDatum' >= Datum_von and '$bisDatum' > Datum_bis and '$vonDatum' < Datum_bis))
			   	OR
			   (FK_Zimmer_ID = $zimmer_id AND	
			   ('$vonDatum' <= Datum_von and '$bisDatum' >= Datum_bis))");
			   
	$res = mysql_query($query, $link);		
	  
	if (!$res) {
		echo("die Anfrage $query scheitert");
		echo(mysql_error($link));
		return false;
	}
			   
	return true;
			   
}

//reservierungen innerhalb eines zeitraumes anzeigen (bei loeschung):
function getReservationWithDate($zimmer_id,$vonDatum,$bisDatum,$link){

	$query = ("SELECT	
			   PK_ID
			   FROM
			   Rezervi_Reservierung
			   WHERE
			   (FK_Zimmer_ID = $zimmer_id AND
			   ('$vonDatum' >= Datum_von and '$bisDatum' <= Datum_bis))
			   OR
			   (FK_Zimmer_ID = $zimmer_id AND
			   ('$vonDatum' < Datum_bis and '$bisDatum' <= Datum_bis and '$bisDatum' > Datum_von))
			   OR
			   (FK_Zimmer_ID = $zimmer_id AND	
			   ('$vonDatum' >= Datum_von and '$bisDatum' > Datum_bis and '$vonDatum' < Datum_bis))
			   	OR
			   (FK_Zimmer_ID = $zimmer_id AND	
			   ('$vonDatum' <= Datum_von and '$bisDatum' >= Datum_bis)
			   )");
			   
	$res = mysql_query($query, $link);		
	  
	if (!$res) {
		echo("die Anfrage $query scheitert");
		echo(mysql_error($link));
	}
			   
	return $res;
			   
}

//funktion legt eine neue reservierung an:
function insertReservationWithDate($zimmer_id,$gast_id,$vonDatum,$bisDatum,$status,
	$anzahlErwachsene,$anzahlKinder,$pension,$link){
		
	//zuerst alle eintraege in diesem zeitraum löschen:
	deleteReservationWithDate($zimmer_id,$vonDatum,$bisDatum,$link);
	
	//get the current timestamp in mysql format:
	$timestamp = generateMySqlTimestamp();
	
	//daten eintragen:
	$query = ("insert into 
				Rezervi_Reservierung
				(FK_Zimmer_ID,FK_Gast_ID,Datum_von,Datum_bis,Status,Erwachsene,Kinder,Pension,ANFRAGEDATUM)
				VALUES				
				('$zimmer_id','$gast_id','$vonDatum','$bisDatum','$status','$anzahlErwachsene','$anzahlKinder','$pension','$timestamp')
		   	  ");
			  
	$res = mysql_query($query, $link);	
	
	if (!$res) { 
		echo("die Anfrage $query scheitert"); 
	}	
	
	//also insert reservations of child rooms, if exists:
	$res = getChildRooms($zimmer_id);
	global $root;
	include_once($root.'/include/zimmerFunctions.php');	
	if (!empty($res)){
		while ($d = mysql_fetch_array($res)){
			insertReservationWithDate($d['PK_ID'],$gast_id,$vonDatum,$bisDatum,$status,
				$anzahlErwachsene,$anzahlKinder,$pension,$link);
		}	
	}
	
}


//--------------------------------------------
//funktion gibt die RESERVIERUNGS-id retour, die in diesem
//zeitraum als reserviert oder belegt eingetragen ist:
function getReservierungID($zimmer_id,$tag,$monat,$jahr,$link){
	
	if ($monat < 10 && strlen($monat) <= 1) {
		$monat = "0".($monat);
	}
	if ($tag < 10 && strlen($tag) <= 1) {
		$tag = "0".($tag);
	}
	$datum = ($jahr)."-".($monat)."-".($tag);
	
	$id = -1;
	//daten aus datenbank abrufen...
	$query = "select 
				PK_ID
				from 
				Rezervi_Reservierung
				where 		
				FK_Zimmer_ID = '$zimmer_id' and
				('$datum' >= Datum_von and '$datum' <= Datum_bis)				
				";

  	$res = mysql_query($query, $link);
  	if (!$res) {
  		echo("Anfrage $query scheitert.");
	}
	else {		
		$d = mysql_fetch_array($res);
		$id = $d["PK_ID"];
	}
				
	return $id;

} //ende getReservierungID
//--------------------------------------------
//funktion gibt die gast-ids retour, die in diesem
//zeitraum als reserviert oder belegt eingetragen ist:
function getReservierungGastIDs($zimmer_id,$tag,$monat,$jahr,$link){
	
	if ($monat < 10 && strlen($monat) <= 1) {
		$monat = "0".($monat);
	}
	if ($tag < 10 && strlen($tag) <= 1) {
		$tag = "0".($tag);
	}
	$datum = ($jahr)."-".($monat)."-".($tag);
	
	$gast_id = -1;
	//daten aus datenbank abrufen...
	$query = "select 
				FK_Gast_ID
				from 
				Rezervi_Reservierung
				where 		
				FK_Zimmer_ID = '$zimmer_id' and
				('$datum' >= Datum_von and '$datum' <= Datum_bis)
				order by Datum_von				
				";

  	$res = mysql_query($query, $link);
  	if (!$res) {
  		echo("Anfrage $query scheitert.");
	}
	else {		
		return $res;
	}

} //ende getReservierungGastID
//--------------------------------------------
//funktion gibt die gast-id retour, die in diesem
//zeitraum als reserviert oder belegt eingetragen ist:
function getReservierungGastID($zimmer_id,$tag,$monat,$jahr,$link){
	
	if ($monat < 10 && strlen($monat) <= 1) {
		$monat = "0".($monat);
	}
	if ($tag < 10 && strlen($tag) <= 1) {
		$tag = "0".($tag);
	}
	$datum = ($jahr)."-".($monat)."-".($tag);
	
	$gast_id = -1;
	//daten aus datenbank abrufen...
	$query = "select 
				FK_Gast_ID
				from 
				Rezervi_Reservierung
				where 		
				FK_Zimmer_ID = '$zimmer_id' and
				('$datum' >= Datum_von and '$datum' <= Datum_bis)				
				";

  	$res = mysql_query($query, $link);
  	if (!$res) {
  		echo("Anfrage $query scheitert.");
	}
	else {		
		$d = mysql_fetch_array($res);
		$gast_id = $d["FK_Gast_ID"];
	}
			
	return $gast_id;

} //ende getReservierungGastID


//--------------------------------------------
//funktion gibt den status dieses zimmers 
// als string für die css-class zurück:
function parseStatus($id,$isSaturday = false){	

	global $root;
	global $link;
	global $unterkunft_id;
	include_once($root."/include/propertiesFunctions.php");
	//should the reservation state be shown?
	$showReservation = getPropertyValue(SHOW_RESERVATION_STATE,$unterkunft_id,$link);
	if ($showReservation != "true"){
		$showReservation = false;
	}
	
	if ($id == "0" && !$isSaturday){
		$statString = "frei";
	}
	elseif ($id == "0" && $isSaturday){
		$statString = "samstagFrei";
	}
	elseif ($id == "1" && !$isSaturday){
		//reserviert als frei anzeigen falls reservierungen
		//nicht angezeigt werden sollen:
		if ($showReservation){
			$statString = "reserviert";
		}
		else{
			$statString = "frei"; 
		}
	}
	elseif ($id == "1" && $isSaturday){
		//reserviert als frei anzeigen falls reservierungen
		//nicht angezeigt werden sollen:
		if ($showReservation){
			$statString = "samstagReserviert";
		}
		else{
			$statString = "samstagFrei"; 
		}
	}	
	elseif ($id == "2" && !$isSaturday){
		$statString = "belegt";
	}
	elseif ($id == "2" && $isSaturday){
		$statString = "samstagBelegt";
	}	
	else {
		//gewöhnliche farbe der tabelle ausgeben:
		//$statString = "tableColor";
		//oder doch besser, dass diese frei sind?
		$statString = "frei";
	}
			
	return $statString;
}


//--------------------------------------------
//funktion gibt den status dieses zimmers an
//diesem tag als string für die css-class zurück:
function getStatusString($zimmer_id,$tag,$monat,$jahr,$saAktiviert,$link){

	global $root;
	global $link;
	global $unterkunft_id;
	include_once($root."/include/propertiesFunctions.php");
	include_once($root."/include/zimmerFunctions.php");
	
	//should the reservation state be shown?
	$showReservation = getPropertyValue(SHOW_RESERVATION_STATE,$unterkunft_id,$link);
	if ($showReservation != "true"){
		$showReservation = false;
	}
	
	if ($saAktiviert != "true"){
		$saAktiviert = false;
	}
	
	//status = 0: frei
	//status = 1: reserviert
	//status = 2: belegt	
	if ($monat < 10 && strlen($monat) <= 1) {
		$monat = "0".($monat);
	}
	if ($tag < 10 && strlen($tag) <= 1) {
		$tag = "0".($tag);
	}
	$datum = ($jahr)."-".($monat)."-".($tag);
	//daten aus datenbank abrufen...
	$query = "select 
				Status
				from 
				Rezervi_Reservierung
				where 		
				FK_Zimmer_ID = '$zimmer_id' and
				('$datum' >= Datum_von and '$datum' <= Datum_bis)				
				";

	$res = mysql_query($query, $link);
	if (!$res)
		echo("Anfrage $query scheitert.");
	else		
		$d = mysql_fetch_array($res);		
	
	$day = getDayName($tag,$monat,$jahr);
	
	if ($d["Status"] == "0")
	{
	  if($day == "SA" && $saAktiviert)
	  {
	    $statString = "samstagFrei";
	  }
	  else
		$statString = "frei";
	}
	
	elseif ($d["Status"] == "1")
	{
	  
	  if($day == "SA" && $saAktiviert)
	  {
	  	if ($showReservation){
	    	$statString = "samstagReserviert";
	  	}
	  	else{
	  		$statString = "samstagFrei";
	  	}
	  }
	  else{
	    if ($showReservation){
	    	$statString = "reserviert";
	  	}
	  	else{
	  		$statString = "frei";
	  	}
	  }
	}
	
	elseif ($d["Status"] == "2")
	{
	  if($day == "SA" && $saAktiviert)
	  {
	    $statString = "samstagBelegt";
	  }
	  else{
		$statString = "belegt";
	  }
	}
	else
	{
      //gewöhnliche farbe der tabelle ausgeben:
      //$statString = "tableColor";
      //oder doch besser, dass diese frei sind?
      if($day == "SA" && $saAktiviert)
	  {
	    $statString = "samstagFrei";
	  }
	  else
		$statString = "frei";
	}
		
	if (($statString == "samstagFrei" || $statString == "frei") 
		&& getPropertyValue(RES_HOUSE,$unterkunft_id,$link) == "true" 
		&& hasChildRooms($zimmer_id)){
		
		//if room is a parent, check if the child has another status:
		$childs = getChildRooms($zimmer_id);
		while ($c = mysql_fetch_array($childs)){
			
			$child_zi_id = $c['PK_ID'];
			$statStringc = getStatusString($child_zi_id,$tag,$monat,$jahr,$saAktiviert,$link);	
			if (!($statStringc == "samstagBelegt" || $statStringc == "belegt")){
				break;
				$statString = $statStringc;
			}
			
		}
		
	}
	
	//if the room has child rooms and ALL rooms are occupied, set the parent as occupied:
	else if (getPropertyValue(RES_HOUSE,$unterkunft_id,$link) != "true" 
		&& hasChildRooms($zimmer_id)){
		
		//get all childs of the parent:
		$childs = getChildRooms($zimmer_id);
		$occ = "true";
		$rse = "true"; 
		$fre = "true";
		while ($c = mysql_fetch_array($childs)){
			$child_zi_id = $c['PK_ID'];
			
			//check if the child is occupied:
			$statStringc = getStatusString($child_zi_id,$tag,$monat,$jahr,$saAktiviert,$link);	

			if (($statStringc == "samstagFrei" || $statStringc == "frei" )){
				$occ = "false";
				$rse = "false";
				break;
			}
			elseif (($statStringc == "reserviert" || $statStringc == "samstagReserviert")){
				$fre = "false";
				$occ = "false";
			}
			
		}
		
		if ($occ == "true"){
			if($day == "SA" && $saAktiviert)
			  {
			    $statString = "samstagBelegt";
			  }
			  else{
				$statString = "belegt";
			  }
		}
		elseif($rse == "true" && $showReservation){
			if ($day == "SA" && $saAktiviert){
				$statString = "samstagReserviert";
			}
			else{
				$statString = "reserviert";
			}
		}
		else{
		    if($day == "SA" && $saAktiviert) {
			    $statString = "samstagFrei";
			  }
			  else{
				$statString = "frei";
			  }
		}
			
	}	

	return $statString;

} //ende getStatusString

/**
get an array with status numbers of the given day and room 
0 = frei
1 = reserviert
2 = belegt
@param $zimmer_id the room id
@param $tag the day
@param $monat the month
@param $jahr the year
@param $link the database connection link
@return get an array with status numbers of the given day and room 
*/
function getStatus($zimmer_id,$tag,$monat,$jahr,$link){	

	global $root;
	include_once($root."/include/propertiesFunctions.php");
	include_once($root."/include/reservierungFunctions.php");
	global $unterkunft_id;
	
	//true if reservations must be shown:
	$showReservation = false;
	$showReservationProp = getPropertyValue(SHOW_RESERVATION_STATE,$unterkunft_id,$link);
	if (!empty($showReservationProp) && $showReservationProp == "true"){
		$showReservation = true;
	}	
	
	//generate a date for the sql query:
	if ($monat < 10 && strlen($monat) <= 1) {
		$monat = "0".($monat);
	}
	if ($tag < 10 && strlen($tag) <= 1) {
		$tag = "0".($tag);
	}
	$datum = ($jahr)."-".($monat)."-".($tag);
	
	//get the state from the database:
	$query = "select 
				Status, PK_ID
				from 
				Rezervi_Reservierung
				where 		
				FK_Zimmer_ID = '$zimmer_id' and
				('$datum' >= Datum_von and '$datum' <= Datum_bis)
				order by
				Datum_von
				";

  	$res = mysql_query($query, $link);
	if (!$res){
  			die("Anfrage $query scheitert.");
	}
	
	//create the state array:
	$status = array();	
	$ids    = array();									
	while($d = mysql_fetch_array($res)){
		$state = $d["Status"];
		if (!$showReservation && $state == STATUS_RESERVIERT){
			//do not show reservation state
			continue;
		}
		$status[] = $state;
		$ids[] = $d['PK_ID'];								
	} //ende while
	
	//if the room has child rooms and the parent-schild relation must be shown, check if the child has the same state
	$showParentRooms = false;
	$hasChildRooms = hasChildRooms($zimmer_id);
	if (getPropertyValue(RES_HOUSE,$unterkunft_id,$link) != "true"){
		$showParentRooms = true;
	}

	if ($showParentRooms === false || $hasChildRooms === false){
		if (count($status) == 1){
		
			//check if the next day is the same reservation:
			$nTag = $tag+1;$nMonat = $monat;$nJahr = $jahr;
			$anzahlTage = getNumberOfDays($month,$year);
			if ($nTag > $anzahlTage){
				$nTag = 1;
				$nMonat=$month+1;
			} //ende if tag zu gross
			if ($nMonat>12){
				$nMonat=1;
				$nJahr=$year+1;
			} //ende if monat zu gross
			$datum = ($nJahr)."-".($nMonat)."-".($nTag);
			//get the state from the database:
			$query = "select 
						Status, PK_ID
						from 
						Rezervi_Reservierung
						where 		
						FK_Zimmer_ID = '$zimmer_id' and
						('$datum' >= Datum_von and '$datum' <= Datum_bis)
						order by
						Datum_von
						";
		
			$res = mysql_query($query, $link);
			if (!$res){
					die("Anfrage $query scheitert.");
			}
			
			//create the state array:
			$nstatus = array();	
			$nids    = array();									
			while($d = mysql_fetch_array($res)){
				$state = $d["Status"];
				if (!$showReservation && $state == STATUS_RESERVIERT){
					//do not show reservation state
					continue;
				}
				$nstatus[] = $state;
				$nids[] = $d['PK_ID'];								
			} //ende while		
			
			if ($ids[0] != $nids[0]){
				$status[] = 0;
			}	
			
			//check if the previous day is the same reservation:
			$vTag = $tag-1;$vMonat = $monat;$vJahr = $jahr;
			if ($vTag < 1) {
				$vMonat= $month - 1;
				if ($vMonat < 1) {
					$vMonat = 12;
					$vJahr = $year-1;
				} //ende if monat zu klein
				$vTag = getNumberOfDays($vMonat,$vJahr);
			} //ende if tag zu klein		
			$datum = ($vJahr)."-".($vMonat)."-".($vTag);
			//get the state from the database:
			$query = "select 
						Status, PK_ID
						from 
						Rezervi_Reservierung
						where 		
						FK_Zimmer_ID = '$zimmer_id' and
						('$datum' >= Datum_von and '$datum' <= Datum_bis)
						order by
						Datum_von
						";
		
			$res = mysql_query($query, $link);
			if (!$res){
					die("Anfrage $query scheitert.");
			}
			
			//create the state array:
			$vstatus = array();	
			$vids    = array();									
			while($d = mysql_fetch_array($res)){
				$state = $d["Status"];
				if (!$showReservation && $state == STATUS_RESERVIERT){
					//do not show reservation state
					continue;
				}
				$vstatus[] = $state;
				$vids[] = $d['PK_ID'];								
			} //ende while		
			
			if ( (count($vstatus) == 1) && ($ids[0] != $vids[0]) ){
				$status[1] = $status[0];
				$status[0] = 0;
			}				
			
			
		}

		return $status;
	}
	
	//the room has child rooms and the parent-child relation must be shown..
	//check if the child has the same state:
	//get all childs of the parent:
	$parentState = array(2);
	if (count($status) > 1){
		$parentState = array(2,2); //parent is occupied defaul
	}
	$childs = getChildRooms($zimmer_id);
	$childArray = array();
	//create an array with child ids:
	while ($c = mysql_fetch_array($childs)){ //continue 1

			$childArray[] = $c['PK_ID'];
			
	}

	for ($l=0; $l<count($parentState); $l++){ //continue 2

		foreach ($childArray as $child_id){ //continue 1
		
			$childStatus = getStatus($child_id,$tag,$monat,$jahr,$link);		
	
			/*
			if ($parentState[$l] == 0){ //if parent is free, show the parent state as free
				$status[$l] = 0;
				continue 2;
			}
			*/
			if (!isset($childStatus[$l]) || $childStatus[$l] == 0 ){ //if any child is free set the parent state free
				$status[$l] = 0;
				continue 2;
			}
			if (isset($childStatus[$l]) && $childStatus[$l] == 1){ //if any child is reserved set the parent reserved
				$status[$l] = 1;
				//continue 2;
			}
			if ($parentState[$l] == 1){
				$status[$l] = 1;
				//continue 2;
			}
			
			$status[$l] = $parentState[$l];
	
		}//end while level 1
	
	} //end for level 2	
	
	if ($status[0] == 0 && $status[1] == 0){
		return null;
	}
	//var_dump($status);
	return $status;
	
}
//--------------------------------------------
//funktion prüft, ob im angegebenen zeitraum
//das zimmer belegt ist:
function isRoomTaken($zimmer_id,$vonTag,$vonMonat,$vonJahr,$bisTag,$bisMonat,$bisJahr,$link){
	
	//status = 0: frei
	//status = 1: reserviert
	//status = 2: belegt	
	if ($vonMonat < 10 && strlen($vonMonat) <= 1) {
		$vonMonat = "0".($vonMonat);
	}
	if ($bisMonat < 10 && strlen($bisMonat) <= 1) {
		$bisMonat = "0".($bisMonat);
	}
	if ($vonTag < 10 && strlen($vonTag) <= 1) {
		$vonTag = "0".($vonTag);
	}
	if ($bisTag < 10 && strlen($bisTag) <= 1) {
		$bisTag = "0".($bisTag);
	}
	
	$vonDatum = ($vonJahr)."-".($vonMonat)."-".($vonTag);
	$bisDatum = ($bisJahr)."-".($bisMonat)."-".($bisTag);
	
	//daten aus datenbank abrufen...
	$query = "select 
				Status
				from 
				Rezervi_Reservierung
				where 		
				FK_Zimmer_ID = '$zimmer_id' and
			   (('$vonDatum' >= Datum_von and '$bisDatum' <= Datum_bis) 
			   OR
				('$vonDatum' < Datum_bis and '$bisDatum' <= Datum_bis and '$bisDatum' > Datum_von) 
				OR	
			    ('$vonDatum' >= Datum_von and '$bisDatum' > Datum_bis and '$vonDatum' < Datum_bis)
				OR	
			    ('$vonDatum' <= Datum_von and '$bisDatum' >= Datum_bis))
				and
				Status = '2'				
				";

  		$res = mysql_query($query, $link);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
		else		
			$d = mysql_fetch_array($res);
	
	if ($d["Status"] == "2"){
		return true;
	}		

	return false;


} //ende isRoomTaken

//funktion legt eine neue reservierung an:
function insertReservation($zimmer_id,$gast_id,$vonTag,$vonMonat,$vonJahr,$bisTag,$bisMonat,$bisJahr,$status,$anzahlErwachsene,$anzahlKinder,$pension,$link){

	if ($vonMonat < 10 && strlen($vonMonat) <= 1) {
		$vonMonat = "0".($vonMonat);
	}
	if ($bisMonat < 10 && strlen($bisMonat) <= 1) {
		$bisMonat = "0".($bisMonat);
	}
	if ($vonTag < 10 && strlen($vonTag) <= 1) {
		$vonTag = "0".($vonTag);
	}
	if ($bisTag < 10 && strlen($bisTag) <= 1) {
		$bisTag = "0".($bisTag);
	}
	
	$vonDatum = ($vonJahr)."-".($vonMonat)."-".($vonTag);
	$bisDatum = ($bisJahr)."-".($bisMonat)."-".($bisTag);
	
	//zuerst alle eintraege in diesem zeitraum löschen:
	deleteReservationWithDate($zimmer_id,$vonDatum,$bisDatum,$link);
	
	//get the current timestamp in mysql format:
	$timestamp = generateMySqlTimestamp();
	
	//daten eintragen:
	$query = ("insert into 
				Rezervi_Reservierung
				(FK_Zimmer_ID,FK_Gast_ID,Datum_von,Datum_bis,Status,Erwachsene,Kinder,Pension,ANFRAGEDATUM)
				VALUES				
				('$zimmer_id','$gast_id','$vonDatum','$bisDatum','$status','$anzahlErwachsene','$anzahlKinder','$pension','$timestamp')
		   	  ");
			  
	$res = mysql_query($query, $link);	
	if (!$res)  
		echo("die Anfrage $query scheitert"); 
		
	//also insert reservations of child rooms, if exists:
	global $root;
	include_once($root.'/include/zimmerFunctions.php');
	$res = getChildRooms($zimmer_id);
	if (!empty($res)){
		while ($d = mysql_fetch_array($res)){
			insertReservation($d['PK_ID'],$gast_id,$vonTag,$vonMonat,$vonJahr,$bisTag,$bisMonat,$bisJahr,$status,$anzahlErwachsene,$anzahlKinder,$pension,$link);
		}	
	}

}

//funktion legt eine neue anfrage an:
function insertAnfrage($zimmer_id,$gast_id,$vonTag,$vonMonat,$vonJahr,$bisTag,$bisMonat,$bisJahr,$status,$anzahlErwachsene,$anzahlKinder,$haustiere,$pension,$link){

	if ($vonMonat < 10 && strlen($vonMonat) <= 1) {
		$vonMonat = "0".($vonMonat);
	}
	if ($bisMonat < 10 && strlen($bisMonat) <= 1) {
		$bisMonat = "0".($bisMonat);
	}
	if ($vonTag < 10 && strlen($vonTag) <= 1) {
		$vonTag = "0".($vonTag);
	}
	if ($bisTag < 10 && strlen($bisTag) <= 1) {
		$bisTag = "0".($bisTag);
	}
	
	$vonDatum = ($vonJahr)."-".($vonMonat)."-".($vonTag);
	$bisDatum = ($bisJahr)."-".($bisMonat)."-".($bisTag);	
	
	//get the current timestamp in mysql format:
	$timestamp = generateMySqlTimestamp();
	
	//daten eintragen:
	$query = ("insert into 
				Rezervi_Reservierung
				(FK_Zimmer_ID,FK_Gast_ID,Datum_von,Datum_bis,Status,Erwachsene,Kinder,Pension,ANFRAGEDATUM)
				VALUES				
				('$zimmer_id','$gast_id','$vonDatum','$bisDatum','$status','$anzahlErwachsene','$anzahlKinder','$pension','$timestamp')
		   	  ");
			  
	$res = mysql_query($query, $link);	
	if (!$res)  
		echo("die Anfrage $query scheitert"); 
		
	//also insert reservations of child rooms, if exists:
	global $root;
	include_once($root.'/include/zimmerFunctions.php');
	$res = getChildRooms($zimmer_id);
	if (!empty($res)){
		while ($d = mysql_fetch_array($res)){
			insertAnfrage($d['PK_ID'],$gast_id,$vonTag,$vonMonat,$vonJahr,$bisTag,$bisMonat,$bisJahr,$status,$anzahlErwachsene,$anzahlKinder,$haustiere,$pension,$link);
		}	
	}		

}

//-----------------------------------------------------
//reservierung aus der datenbank löschen:
function deleteReservation($id,$link){	
		
	$query = ("DELETE FROM	 
			   Rezervi_Reservierung
			   WHERE				
			   PK_ID = $id
		   	  ");

  	$res = mysql_query($query, $link);
  	
	if (!$res) { 
		echo("die Anfrage $query scheitert");
		echo(mysql_error($link));
		exit;
	}
	
} //ende deleteReservation

//-----------------------------------------
//Datum_von ausgeben
function getDatumVon($id,$link){	
		
	$query = ("SELECT		 
			   Datum_von
			   FROM
			   Rezervi_Reservierung
			   WHERE				
			   PK_ID = '$id'
		   	  ");

  	$res = mysql_query($query, $link);
	if (!$res)  
		echo("die Anfrage scheitert"); 
	$d = mysql_fetch_array($res);
	return $d["Datum_von"];
	
} //ende getDatumVon
//-----------------------------------------
//Datum_von ausgeben
function getPension($id,$link){	
		
	$query = ("SELECT		 
			   Pension
			   FROM
			   Rezervi_Reservierung
			   WHERE				
			   PK_ID = '$id'
		   	  ");

  	$res = mysql_query($query, $link);
	if (!$res)  
		echo("die Anfrage scheitert"); 
	$d = mysql_fetch_array($res);
	return $d["Pension"];
	
} //ende getDatumVon
//-----------------------------------------
//Datum_von ausgeben
function getDatumBis($id,$link){	
		
	$query = ("SELECT		 
			   Datum_bis
			   FROM
			   Rezervi_Reservierung
			   WHERE				
			   PK_ID = '$id'
		   	  ");

  	$res = mysql_query($query, $link);
	if (!$res)  
		echo("die Anfrage scheitert"); 
	$d = mysql_fetch_array($res);
	return $d["Datum_bis"];
	
} //ende getDatumVon

//-----------------------------------------
//Datum_von ausgeben
function getErwachsene($id,$link){	
		
	$query = ("SELECT		 
			   Erwachsene
			   FROM
			   Rezervi_Reservierung
			   WHERE				
			   PK_ID = '$id'
		   	  ");

  	$res = mysql_query($query, $link);
	if (!$res)  
		echo("die Anfrage scheitert"); 
	$d = mysql_fetch_array($res);
	return $d["Erwachsene"];
	
} //ende getDatumVon

//-----------------------------------------
//Datum_von ausgeben
function getKinder($id,$link){	
		
	$query = ("SELECT		 
			   Kinder
			   FROM
			   Rezervi_Reservierung
			   WHERE				
			   PK_ID = '$id'
		   	  ");

  	$res = mysql_query($query, $link);
	if (!$res)  
		echo("die Anfrage scheitert"); 
	$d = mysql_fetch_array($res);
	return $d["Kinder"];
	
} //ende getDatumVon

//-----------------------------------------
//Datum_von ausgeben
function getState($id,$link){	
		
	$query = ("SELECT		 
			   Status
			   FROM
			   Rezervi_Reservierung
			   WHERE				
			   PK_ID = '$id'
		   	  ");

  	$res = mysql_query($query, $link);
	if (!$res)  
		echo("die Anfrage scheitert"); 
	$d = mysql_fetch_array($res);
	return $d["Status"];
	
} //ende getDatumVon

//-----------------------------------------
//Datum_von ausgeben
function getGastID($id,$link){	
		
	$query = ("SELECT		 
			   FK_Gast_ID
			   FROM
			   Rezervi_Reservierung
			   WHERE				
			   PK_ID = '$id'
		   	  ");

  	$res = mysql_query($query, $link);
	if (!$res)  
		echo("die Anfrage scheitert"); 
	$d = mysql_fetch_array($res);
	return $d["FK_Gast_ID"];
	
} //ende getDatumVon


/**
 * returns the guest_id from the reservation
 * @return  the guest_id from the reservation
 * @param $res_id the id of the reservation
 */
function getIDFromGast($res_id,$link){	
		
	return getGastId($res_id,$link);
	
} //ende getGastID

/**
 * @author coster
 * checks if the parent has the same reservation
 * as the child room
 * */
function hasParentSameReservation($reservierungs_id){
	
	global $unterkunft_id;
	global $link;
	global $root;
	
	include_once($root."/include/zimmerFunctions.php");
	
	$zi_id = getZimmerID($reservierungs_id,$link);
	
	if (!hasRoomParentRooms($zi_id)){
		
		return false;
		
	}
	
	$gast      = getIDFromGast($reservierungs_id,$link);
	$datum_von = getDatumVon($reservierungs_id,$link);
	$datum_bis = getDatumBis($reservierungs_id,$link);
	$status    = getState($reservierungs_id,$link);
	
		$query = ("SELECT		 
			   r.PK_ID
			   FROM
			   Rezervi_Reservierung r, Rezervi_Zimmer z
			   WHERE				
			   FK_GAST_ID = '$gast' and" .
			   		" r.Datum_von = '$datum_von' and" .
			   		" r.Datum_bis = '$datum_bis' and".
					" r.Status = '$status' and
					z.Parent_ID is null and 
					r.FK_Zimmer_ID = z.PK_ID ");

  	$res = mysql_query($query, $link);
	
	if (!$res)  {
		echo("die Anfrage scheitert");
		echo("<br/>".mysql_error()); 
	}
	else{
		$d = mysql_fetch_array($res);
		$id = $d["PK_ID"];
		if (!empty($id)){
			return true;
		}
	}
	
	return false;
	
	
}

?>
