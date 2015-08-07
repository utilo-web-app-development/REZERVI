<?php

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 

/**
 * Anlegen eines neuen Gastes mit einer ID
 */
function insertGuestWithID($guest_id,$unterkunft_id,$anrede,$vorname,$nachname,$strasse,$plz,$ort,$land,$email,$tel,$fax,$anmerkung,$sprache,$link){
	
	$query = ("replace into 
				Rezervi_Gast
				(PK_ID,FK_Unterkunft_ID,Anrede,Vorname,Nachname,Strasse,PLZ,Ort,Land,EMail,Tel,Fax,Anmerkung,Sprache)
				VALUES				
				('$guest_id','$unterkunft_id','$anrede','$vorname','$nachname','$strasse','$plz','$ort','$land','$email','$tel','$fax','$anmerkung','$sprache')
		   	  ");

  	$res = mysql_query($query, $link);
	if (!$res) { 
		echo("die Anfrage $query scheitert");
		echo(mysql_error($link));
		return false;
	}
	
	return true; 

}

//funktion legt einen neuen gast an,
//zur�ckgegeben wird die id des neu
//angelegten gastes:
function insertGuest($unterkunft_id,$anrede,$vorname,$nachname,$strasse,$plz,$ort,$land,$email,$tel,$fax,$anmerkung,$sprache,$link){
	
	$query = ("insert into 
				Rezervi_Gast
				(FK_Unterkunft_ID,Anrede,Vorname,Nachname,Strasse,PLZ,Ort,Land,EMail,Tel,Fax,Anmerkung,Sprache)
				VALUES				
				('$unterkunft_id','$anrede','$vorname','$nachname','$strasse','$plz','$ort','$land','$email','$tel','$fax','$anmerkung','$sprache')
		   	  ");

  	$res = mysql_query($query, $link);
	if (!$res)  
		echo("die Anfrage scheitert");
		
	//letzte eingetragene id zur�ckgeben:
	return mysql_insert_id($link); 

}

//funktion �ndert einen bereits vorhandenen gast:
function updateGuest($gast_id,$anrede,$vorname,$nachname,$strasse,$plz,$ort,$land,$email,$tel,$fax,$anmerkung,$sprache,$link){
	
	$query = ("UPDATE
				Rezervi_Gast
				SET								
				Anrede = '$anrede',
				Vorname = '$vorname',
				Nachname = '$nachname',
				Strasse = '$strasse',
				PLZ = '$plz',
				Ort = '$ort',
				Land = '$land',
				EMail = '$email',
				Tel = '$tel',
				Fax = '$fax',
				Anmerkung = '$anmerkung',
				Sprache = '$sprache'
				WHERE
				PK_ID = '$gast_id'
		   	  ");

  	$res = mysql_query($query, $link);
	if (!$res)  
		echo("die Anfrage scheitert");
} //ende updateGuest

//funktion pr�ft, ob ein gast bereits vorhanden ist.
//ich checke mal nach vornamen, nachnamen und e-mail,
//das d�rfte wohl eindeutig sein
//dann id des gastes zur�ckgeben:
function getGuestID($unterkunft_id,$vorname,$nachname,$email,$link){
	
	$query = ("SELECT 
				PK_ID
				FROM
				Rezervi_Gast
				WHERE
				Vorname = '$vorname' and
				Nachname = '$nachname' and
				EMail = '$email' and
				FK_Unterkunft_ID = '$unterkunft_id'
				");

  	$res = mysql_query($query, $link);
	if (!$res)  
		echo("die Anfrage scheitert");
		
	$d = mysql_fetch_array($res);
	$gast_id = $d["PK_ID"];
	return $gast_id;

}

//funktion pr�ft, ob ein gast bereits vorhanden ist.
//check mit vorname, nachname, strasse, ort
function getGuestIDDetail($unterkunft_id,$vorname,$nachname,$strasse,$ort,$link){
	
	$query = ("SELECT 
				PK_ID
				FROM
				Rezervi_Gast
				WHERE
				Vorname = '$vorname' and
				Nachname = '$nachname' and
				Strasse = '$strasse' and
				FK_Unterkunft_ID = '$unterkunft_id' and
				Ort = '$ort'
				");

  	$res = mysql_query($query, $link);
	if (!$res)  
		echo("die Anfrage scheitert");
		
	$d = mysql_fetch_array($res);
	$gast_id = $d["PK_ID"];
	if (!isset($gast_id) || $gast_id == "")
		return -1;
	else
		return $gast_id;

}


//funktion gibt nachnamen des gastes aus,
//uebergeben wird die id des gastes
function getGuestNachname($gast_id,$link){
	
	$query = ("SELECT 
				Nachname
				FROM
				Rezervi_Gast
				WHERE
				PK_ID = '$gast_id'
				 ");

  	$res = mysql_query($query, $link);
	if (!$res)  
		echo("die Anfrage scheitert");
		
	$d = mysql_fetch_array($res);
	return $d["Nachname"];

}

function getGuestSprache($gast_id,$link){
	
	$query = ("SELECT 
				Sprache
				FROM
				Rezervi_Gast
				WHERE
				PK_ID = '$gast_id'
				 ");

  	$res = mysql_query($query, $link);
	if (!$res)  
		echo("die Anfrage scheitert");
		
	$d = mysql_fetch_array($res);
	return $d["Sprache"];

}

//funktion gibt wohnort des gastes aus,
//uebergeben wird die id des gastes
function getGuestOrt($gast_id,$link){
	
	$query = ("SELECT 
				Ort
				FROM
				Rezervi_Gast
				WHERE
				PK_ID = '$gast_id'
				 ");

  	$res = mysql_query($query, $link);
	if (!$res)  
		echo("die Anfrage scheitert");
		
	$d = mysql_fetch_array($res);
	return $d["Ort"];

}

//funktion gibt wohnort des gastes aus,
//uebergeben wird die id des gastes
function getGuestVorname($gast_id,$link){
	
	$query = ("SELECT 
				Vorname
				FROM
				Rezervi_Gast
				WHERE
				PK_ID = '$gast_id'
				 ");

  	$res = mysql_query($query, $link);
	if (!$res)  
		echo("die Anfrage scheitert");
		
	$d = mysql_fetch_array($res);
	return $d["Vorname"];

}

//funktion gibt wohnort des gastes aus,
//uebergeben wird die id des gastes
function getGuestStrasse($gast_id,$link){
	
	$query = ("SELECT 
				Strasse
				FROM
				Rezervi_Gast
				WHERE
				PK_ID = '$gast_id'
				 ");

  	$res = mysql_query($query, $link);
	if (!$res)  
		echo("die Anfrage scheitert");
		
	$d = mysql_fetch_array($res);
	return $d["Strasse"];

}

//funktion gibt wohnort des gastes aus,
//uebergeben wird die id des gastes
function getGuestPLZ($gast_id,$link){
	
	$query = ("SELECT 
				PLZ
				FROM
				Rezervi_Gast
				WHERE
				PK_ID = '$gast_id'
				 ");

  	$res = mysql_query($query, $link);
	if (!$res)  
		echo("die Anfrage scheitert");
		
	$d = mysql_fetch_array($res);
	return $d["PLZ"];

}

//funktion gibt wohnort des gastes aus,
//uebergeben wird die id des gastes
function getGuestLand($gast_id,$link){
	
	$query = ("SELECT 
				Land
				FROM
				Rezervi_Gast
				WHERE
				PK_ID = '$gast_id'
				 ");

  	$res = mysql_query($query, $link);
	if (!$res)  
		echo("die Anfrage scheitert");
		
	$d = mysql_fetch_array($res);
	return $d["Land"];

}

//funktion gibt wohnort des gastes aus,
//uebergeben wird die id des gastes
function getGuestEmail($gast_id,$link){
	
	$query = ("SELECT 
				EMail
				FROM
				Rezervi_Gast
				WHERE
				PK_ID = '$gast_id'
				 ");

  	$res = mysql_query($query, $link);
	if (!$res)  
		echo("die Anfrage scheitert");
		
	$d = mysql_fetch_array($res);
	return $d["EMail"];

}

//funktion gibt wohnort des gastes aus,
//uebergeben wird die id des gastes
function getGuestTel($gast_id,$link){
	
	$query = ("SELECT 
				Tel
				FROM
				Rezervi_Gast
				WHERE
				PK_ID = '$gast_id'
				 ");

  	$res = mysql_query($query, $link);
	if (!$res)  
		echo("die Anfrage scheitert");
		
	$d = mysql_fetch_array($res);
	return $d["Tel"];

}

//funktion gibt wohnort des gastes aus,
//uebergeben wird die id des gastes
function getGuestFax($gast_id,$link){
	
	$query = ("SELECT 
				Fax
				FROM
				Rezervi_Gast
				WHERE
				PK_ID = '$gast_id'
				 ");

  	$res = mysql_query($query, $link);
	if (!$res)  
		echo("die Anfrage scheitert");
		
	$d = mysql_fetch_array($res);
	return $d["Fax"];

}

//funktion gibt wohnort des gastes aus,
//uebergeben wird die id des gastes
function getGuestAnmerkung($gast_id,$link){
	
	$query = ("SELECT 
				Anmerkung
				FROM
				Rezervi_Gast
				WHERE
				PK_ID = '$gast_id'
				 ");

  	$res = mysql_query($query, $link);
	if (!$res)  
		echo("die Anfrage scheitert");
		
	$d = mysql_fetch_array($res);
	return $d["Anmerkung"];

}

//funktion gibt wohnort des gastes aus,
//uebergeben wird die id des gastes
function getGuestAnrede($gast_id,$link){
	
	$query = ("SELECT 
				Anrede
				FROM
				Rezervi_Gast
				WHERE
				PK_ID = '$gast_id'
				 ");

  	$res = mysql_query($query, $link);
	if (!$res)  
		echo("die Anfrage scheitert");
		
	$d = mysql_fetch_array($res);
	return $d["Anrede"];

}

function getGuestList($unterkunft_id,$link){	
//g�steliste ausgeben:	
	$query = ("SELECT 
				*
				FROM
				Rezervi_Gast
				WHERE
				FK_Unterkunft_ID = '$unterkunft_id'
				AND
				PK_ID != 1
				ORDER BY
				Nachname
				");

  	$res = mysql_query($query, $link);
	if (!$res)  
		echo("die Anfrage $query scheitert");
	else
		return $res;
}
/**
liefert eine g�steliste mit einem limit und einem index
author: coster
date: 28.8.05
*/
function getGuestListWithLimitAndIndex($unterkunft_id,$limit,$index,$link){	
//g�steliste ausgeben:	
	$query = ("SELECT 
				*
				FROM
				Rezervi_Gast
				WHERE
				FK_Unterkunft_ID = '$unterkunft_id'
				AND
				PK_ID != 1
				ORDER BY
				Nachname
				LIMIT
				$index,$limit
				");

  	$res = mysql_query($query, $link);
	if (!$res)  
		echo("die Anfrage $query scheitert");
	else
		return $res;
}
/**
liefert die anzahl der g�ste f�r eine unterkunft
author: coster
date: 28.8.05
*/
function getAnzahlGaeste($unterkunft_id,$link){
		$query = ("SELECT 
				count(PK_ID) as anzahl
				FROM
				Rezervi_Gast
				WHERE
				FK_Unterkunft_ID = '$unterkunft_id'
				AND
				PK_ID != 1
				");

  	$res = mysql_query($query, $link);
	if (!$res)  {
		echo("die Anfrage $query scheitert");
	}
	else{
		$d = mysql_fetch_array($res);
		return $d["anzahl"];
	}
}
?>
