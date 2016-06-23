<?php

define("LIMIT_MIETERLISTE","6"); //limit der angezeigten gäste pro seite
define("ANONYMER_MIETER_ID","1"); //anonymer mieter - sollte nirgends aufscheinen
define("NEUER_MIETER","neuerMieter"); //konstante fuer form felder mit neuem mieter

/**
 * author:coster
 * date: 17.10.05
 * löscht einen mieter
 * */
function deleteMieter($mieter_id){
	global $link;
	
	$query = ("delete from 
				REZ_GEN_RESERVIERUNG 
				WHERE
				MIETER_ID = '$mieter_id'
				 ");

  	$res = mysql_query($query, $link);
	if (!$res)  {
		echo("die Anfrage $query scheitert");
		echo(mysql_error($link));
		exit;
	}
	
	$query = ("delete from 
				REZ_GEN_MIETER_TEXTE 
				WHERE
				MIETER_ID = '$mieter_id'
				 ");

  	$res = mysql_query($query, $link);
	if (!$res)  {
		echo("die Anfrage $query scheitert");
		echo(mysql_error($link));
		exit;
	}
	
	$query = ("delete from 
				REZ_GEN_MIETER 
				WHERE
				MIETER_ID = '$mieter_id'
				 ");

  	$res = mysql_query($query, $link);
	if (!$res)  {
		echo("die Anfrage $query scheitert");
		echo(mysql_error($link));
		exit;
	}
		
	return true;

}
/**
 * author:coster
 * date:14.10.05
 * speichert einen neuen mieter
 * */
function insertMieter($vermieter_id,$anrede,$vorname,$nachname,$strasse,$plz,$ort,$land,$email,$tel,$tel2,$fax,$url,$firma,$speech){
	global $link;	 
	
	$query = ("insert into 
				REZ_GEN_ADRESSE
				(ANREDE,VORNAME,NACHNAME,STRASSE,PLZ,ORT,LAND,EMAIL,TELEFON,TELEFON2,FAX,URL,FIRMA)
				VALUES				
				('$anrede','$vorname','$nachname','$strasse','$plz','$ort','$land','$email','$tel','$tel2','$fax','$url','$firma')
		   	  ");
		   	  
	$res = mysql_query($query, $link);
	if (!$res)  {
		echo("die Anfrage $query scheitert");
		echo(mysql_error($link));
		exit;
	}
	
	$adresse_id = mysql_insert_id($link);	
	   	  
	$query = ("insert into 
				REZ_GEN_MIETER
				(ADRESSE_ID,VERMIETER_ID,SPRACHE_ID)
				VALUES				
				('$adresse_id','$vermieter_id','$speech')
		   	  ");

  	$res = mysql_query($query, $link);
  	
	if (!$res)  {
		echo("die Anfrage $query scheitert");
		exit;
	}

	$mieter_id = mysql_insert_id($link);
	return $mieter_id;

}
/**
 * author:coster
 * date:17.10.05
 * liefert die adress-id eines mieters
 * */
 function getAdressIDfromMieter($mieter_id){
 	
 	global $link;
	
	$query = ("SELECT 
				ADRESSE_ID
				FROM
				REZ_GEN_MIETER 
				WHERE
				MIETER_ID = '$mieter_id'
				 ");

  	$res = mysql_query($query, $link);
	if (!$res)  {
		echo("die Anfrage $query scheitert");
		echo(mysql_error($link));
		return false;
	}
		
	$d = mysql_fetch_array($res);
	return $d["ADRESSE_ID"];
 
 }
/**
 * author:coster
 * date:17.10.05
 * ändert einen bereits vorhandenen mieter
 * */
function updateMieter($mieter_id,$anrede,$vorname,$nachname,$strasse,$plz,$ort,$land,$email,$tel,$tel2,$fax,$url,$firma,$sprache){
	
	$adresse_id = getAdressIDfromMieter($mieter_id);
	
	global $link;
	
	$query = ("UPDATE
				REZ_GEN_MIETER
				SET	
				SPRACHE_ID = '$sprache'
				where
				MIETER_ID = '$mieter_id' 
			");
			
	$res = mysql_query($query, $link);
	if (!$res)  {
		echo("die Anfrage $query scheitert");
		echo(mysql_error($link));
		return false;
	}		
	
		$query = ("UPDATE
				REZ_GEN_ADRESSE
				SET							
				ANREDE = '$anrede',
				VORNAME = '$vorname',
				NACHNAME = '$nachname',
				STRASSE = '$strasse',
				PLZ = '$plz',
				ORT = '$ort',
				LAND = '$land',
				EMAIL = '$email',
				TELEFON = '$tel',
				FAX = '$fax',
				TELEFON2 = '$tel2',
				URL = '$url'," .
			  " FIRMA = '$firma'
				WHERE
				ADRESSE_ID = '$adresse_id'
		   	  ");

  	$res = mysql_query($query, $link);
	if (!$res)  {
		echo("die Anfrage $query scheitert");
		echo(mysql_error($link));
		return false;
	}
	
	return true;
	
} 
/**
 * @author: coster
 * Datum: 8.Apr.2006
 * fügt einen text eines mieters ein
 * @param $text der zu speichernde text
 * @param $mieter_id die id des mieters
 */
 function insertMieterText($text,$mieter_id){
 	
 	global $link;
	global $root;
	include_once($root."/include/datumFunctions.inc.php");
	$tag = getTodayDay();
	$monat=getTodayMonth();
	$jahr =getTodayYear();
	if ($tag < 10 && strlen($tag)<=1){
		$tag = "0".$tag;
	}
	if ($monat < 10 && strlen($monat)<=1){
		$monat = "0".$monat;
	}
	$datum = $jahr."-".$monat."-".$tag;
	
	$query = ("insert into REZ_GEN_MIETER_TEXTE 
				(MIETER_ID,TEXT,DATUM)
				values
				('$mieter_id','$text','$datum')
				");

  	$res = mysql_query($query, $link);
	if (!$res)  {
		echo("die Anfrage $query scheitert");
		echo(mysql_error($link));
		exit;
	}		
 	
 }
/**
 * author:coster
 * date:17.10.05 
 * funktion prüft, ob ein mieter bereits vorhanden ist.
  ich checke mal nach vornamen, nachnamen und e-mail,
  das dürfte wohl eindeutig sein
  dann id des mieters zurückgeben:
 * */
function getMieterId($vermieter_id,$vorname,$nachname,$email){
	
	global $link;
	
	$query = ("SELECT 
				m.MIETER_ID
				FROM
				REZ_GEN_MIETER m, REZ_GEN_ADRESSE a
				WHERE
				a.VORNAME = '$vorname' and
				a.NACHNAME = '$nachname' and
				a.EMAIL = '$email' and
				m.VERMIETER_ID = '$vermieter_id' and
				m.ADRESSE_ID = a.ADRESSE_ID
				");

  	$res = mysql_query($query, $link);
	if (!$res)  {
		echo("die Anfrage $query scheitert");
		echo(mysql_error($link));
		return false;
	}
		
	$d = mysql_fetch_array($res);
	$mieter_id = $d["MIETER_ID"];
	return $mieter_id;

}
/**
 * author:coster
 * date:8.10.05
 * liefert den nachnamen eines mieters
 * */
function getNachnameOfMieter($mieter_id){
	
	global $link;
	
	$query = ("SELECT 
				a.NACHNAME
				FROM
				REZ_GEN_MIETER m, REZ_GEN_ADRESSE a
				WHERE
				m.MIETER_ID = '$mieter_id'
				and
				m.ADRESSE_ID = a.ADRESSE_ID
				 ");

  	$res = mysql_query($query, $link);
	if (!$res)  {
		echo("die Anfrage $query scheitert");
		echo(mysql_error($link));
		return false;
	}
		
	$d = mysql_fetch_array($res);
	return $d["NACHNAME"];

}
/**
 * author:coster
 * date:8.10.05
 * liefert die sprache eines mieters
 * */
function getSpracheOfMieter($mieter_id){
	
	global $link;
	
	$query = ("SELECT 
				SPRACHE_ID
				FROM
				REZ_GEN_MIETER
				WHERE
				MIETER_ID = '$mieter_id'
				 ");

  	$res = mysql_query($query, $link);
	if (!$res)  {
		echo("die Anfrage $query scheitert");
		echo(mysql_error($link));
		return false;
	}
	
	$d = mysql_fetch_array($res);
	return $d["SPRACHE_ID"];

}
/**
 * author:coster
 * date:17.10.05
 * liefert den ort eines mieters
 * */
function getMieterOrt($mieter_id){
	global $link;
	$query = ("SELECT 
				a.ORT
				FROM
				REZ_GEN_MIETER m, REZ_GEN_ADRESSE a
				WHERE
				m.MIETER_ID = '$mieter_id'
				and
				a.ADRESSE_ID = m.ADRESSE_ID
				 ");

  	$res = mysql_query($query, $link);
	if (!$res)  {
		echo("die Anfrage $query scheitert");
		echo(mysql_error($link));
		return false;
	}
		
	$d = mysql_fetch_array($res);
	return $d["ORT"];

}
/**
 * author:coster
 * date:17.10.05
 * liefert den vornamen eines mieters
 * */
function getMieterVorname($mieter_id){
	global $link;
	$query = ("SELECT 
				a.VORNAME
				FROM
				REZ_GEN_MIETER m, REZ_GEN_ADRESSE a
				WHERE
				m.MIETER_ID = '$mieter_id'
				and
				a.ADRESSE_ID = m.ADRESSE_ID
				 ");

  	$res = mysql_query($query, $link);
	if (!$res)  {
		echo("die Anfrage $query scheitert");
		echo(mysql_error($link));
		return false;
	}
		
	$d = mysql_fetch_array($res);
	return $d["VORNAME"];

}
/**
 * author:coster
 * date: 17.10.05
 * liefert die strasse eines mieters
 * */
function getMieterStrasse($mieter_id){
	global $link;
	$query = ("SELECT 
				a.STRASSE
				FROM
				REZ_GEN_MIETER m, REZ_GEN_ADRESSE a
				WHERE
				m.MIETER_ID = '$mieter_id'
				and
				a.ADRESSE_ID = m.ADRESSE_ID
				 ");

  	$res = mysql_query($query, $link);
	if (!$res)  {
		echo("die Anfrage $query scheitert");
		echo(mysql_error($link));
		return false;
	}
		
	$d = mysql_fetch_array($res);
	return $d["STRASSE"];

}
/**
 * author:coster
 * date: 17.10.05
 * liefert die plz eines mieters
 * */
function getMieterPlz($mieter_id){
	global $link;
	$query = ("SELECT 
				a.PLZ
				FROM
				REZ_GEN_MIETER m, REZ_GEN_ADRESSE a
				WHERE
				m.MIETER_ID = '$mieter_id'
				and
				a.ADRESSE_ID = m.ADRESSE_ID
				 ");

  	$res = mysql_query($query, $link);
	if (!$res)  {
		echo("die Anfrage $query scheitert");
		echo(mysql_error($link));
		return false;
	}
		
	$d = mysql_fetch_array($res);
	return $d["PLZ"];

}
/**
 * author:coster
 * date: 17.10.05
 * liefert das land eines mieters
 * */
function getMieterLand($mieter_id){
	global $link;
	$query = ("SELECT 
				a.LAND
				FROM
				REZ_GEN_MIETER m, REZ_GEN_ADRESSE a
				WHERE
				m.MIETER_ID = '$mieter_id'
				and
				a.ADRESSE_ID = m.ADRESSE_ID
				 ");

  	$res = mysql_query($query, $link);
	if (!$res)  {
		echo("die Anfrage $query scheitert");
		echo(mysql_error($link));
		return false;
	}
		
	$d = mysql_fetch_array($res);
	return $d["LAND"];

}
/**
 * author:coster
 * date: 8.4.06
 * liefert die firma eines mieters
 * */
function getMieterFirma($mieter_id){
	global $link;
	$query = ("SELECT 
				a.FIRMA
				FROM
				REZ_GEN_MIETER m, REZ_GEN_ADRESSE a
				WHERE
				m.MIETER_ID = '$mieter_id'
				and
				a.ADRESSE_ID = m.ADRESSE_ID
				 ");

  	$res = mysql_query($query, $link);
	if (!$res)  {
		echo("die Anfrage $query scheitert");
		echo(mysql_error($link));
		return false;
	}
		
	$d = mysql_fetch_array($res);
	return $d["FIRMA"];

}
/**
 * author:coster
 * date:8.10.05
 * liefert die e-mail-adresse eines mieters
 * */
function getEmailOfMieter($mieter_id){
	
	global $link;
	
	$query = ("SELECT 
				a.EMAIL
				FROM
				REZ_GEN_MIETER m, REZ_GEN_ADRESSE a
				WHERE
				m.MIETER_ID = '$mieter_id'
				and
				m.ADRESSE_ID = a.ADRESSE_ID
				 ");

  	$res = mysql_query($query, $link);
	if (!$res)  {
		echo("die Anfrage $query scheitert");
		echo(mysql_error($link));
		return false;
	}
		
	$d = mysql_fetch_array($res);
	return $d["EMAIL"];

}
/**
 * author:coster
 * date: 17.10.05
 * liefert die 1. telefonnummer eines mieters
 * */
function getMieterTel($mieter_id){
	global $link;
	$query = ("SELECT 
				a.TELEFON
				FROM
				REZ_GEN_MIETER m, REZ_GEN_ADRESSE a
				WHERE
				m.MIETER_ID = '$mieter_id'
				and
				a.ADRESSE_ID = m.ADRESSE_ID
				 ");

  	$res = mysql_query($query, $link);
	if (!$res)  {
		echo("die Anfrage $query scheitert");
		echo(mysql_error($link));
		return false;
	}
		
	$d = mysql_fetch_array($res);
	return $d["TELEFON"];

}
/**
 * author:coster
 * date: 17.10.05
 * liefert die 2. telefonnummer eines mieters
 * */
function getMieterTel2($mieter_id){
	global $link;
	$query = ("SELECT 
				a.TELEFON2
				FROM
				REZ_GEN_MIETER m, REZ_GEN_ADRESSE a
				WHERE
				m.MIETER_ID = '$mieter_id'
				and
				a.ADRESSE_ID = m.ADRESSE_ID
				 ");

  	$res = mysql_query($query, $link);
	if (!$res)  {
		echo("die Anfrage $query scheitert");
		echo(mysql_error($link));
		return false;
	}
		
	$d = mysql_fetch_array($res);
	return $d["TELEFON2"];

}
/**
 * author:coster
 * date: 17.10.05
 * liefert die url eines mieters
 * */
function getMieterUrl($mieter_id){
	global $link;
	$query = ("SELECT 
				a.URL
				FROM
				REZ_GEN_MIETER m, REZ_GEN_ADRESSE a
				WHERE
				m.MIETER_ID = '$mieter_id'
				and
				a.ADRESSE_ID = m.ADRESSE_ID
				 ");

  	$res = mysql_query($query, $link);
	if (!$res)  {
		echo("die Anfrage $query scheitert");
		echo(mysql_error($link));
		return false;
	}
		
	$d = mysql_fetch_array($res);
	return $d["URL"];

}
/**
 * author:coster
 * 17.10.05
 * liefert die faxnummer des mieters 
 * */
function getMieterFax($mieter_id){
	global $link;
	$query = ("SELECT 
				a.FAX
				FROM
				REZ_GEN_MIETER m, REZ_GEN_ADRESSE a
				WHERE
				m.MIETER_ID = '$mieter_id'
				and
				a.ADRESSE_ID = m.ADRESSE_ID
				 ");

  	$res = mysql_query($query, $link);
	if (!$res)  {
		echo("die Anfrage $query scheitert");
		echo(mysql_error($link));
		return false;
	}
		
	$d = mysql_fetch_array($res);
	return $d["FAX"];

}
/**
 * author:coster
 * 17.10.05
 * liefert die anrede des mieters
 * */
function getMieterAnrede($mieter_id){
	global $link;
	$query = ("SELECT 
				a.ANREDE
				FROM
				REZ_GEN_MIETER m, REZ_GEN_ADRESSE a
				WHERE
				m.MIETER_ID = '$mieter_id'
				and
				a.ADRESSE_ID = m.ADRESSE_ID
				 ");

  	$res = mysql_query($query, $link);
	if (!$res)  {
		echo("die Anfrage $query scheitert");
		echo(mysql_error($link));
		return false;
	}
		
	$d = mysql_fetch_array($res);
	return $d["ANREDE"];

}
/**
 * author:coster
 * date:7.10.05
 * liefert eine liste aller mieter, sortiert nach dem nachnamen
 * */
function getAllMieterFromVermieter($vermieter_id){	

	global $link;
	$ano = ANONYMER_MIETER_ID;
	
	$query = ("SELECT 
				m.*,a.*
				FROM
				REZ_GEN_MIETER m, REZ_GEN_ADRESSE a
				WHERE
				m.VERMIETER_ID = '$vermieter_id'
				AND
				m.ADRESSE_ID = a.ADRESSE_ID
				AND
				m.MIETER_ID != '$ano'
				ORDER BY
				a.NACHNAME
				");

  	$res = mysql_query($query, $link);
	if (!$res)  {
		echo("die Anfrage $query scheitert");
		echo(mysql_error($link));
		return false;
	}
	else{
		return $res;
	}
}
/**
author: coster
date: 14.10.05
liefert eine mieterliste mit einem limit und einem index
*/
function getMieterListWithLimitAndIndex($vermieter_id,$index){	
	
	global $link;
	$limit = LIMIT_MIETERLISTE;
	$ano = ANONYMER_MIETER_ID;
	
	$query = ("SELECT 
				m.*, a.*
				FROM
				REZ_GEN_MIETER m, REZ_GEN_ADRESSE a
				WHERE
				m.VERMIETER_ID = '$vermieter_id'
				AND
				m.ADRESSE_ID = a.ADRESSE_ID" .
						" AND
				m.MIETER_ID != '$ano'
				ORDER BY
				a.NACHNAME
				LIMIT
				$index,$limit
				");

  	$res = mysql_query($query, $link);
	if (!$res)  {
		echo("die Anfrage $query scheitert");
		echo(mysql_error($link));
		return false;
	}
	else{
		return $res;
	}
}
/**
author: coster
date: 14.10.05
liefert die anzahl der mieter eines vermieters
*/
function getAnzahlMieter($vermieter_id){
	global $link;
		$ano = ANONYMER_MIETER_ID;
		$query = ("SELECT 
				count(MIETER_ID) as anzahl
				FROM
				REZ_GEN_MIETER
				WHERE
				VERMIETER_ID = '$vermieter_id'" .
				" AND
				MIETER_ID != '$ano'
				");

  	$res = mysql_query($query, $link);
	if (!$res)  {
		echo("die Anfrage $query scheitert");
		echo(mysql_error($link));
		return false;
	}
	else{
		$d = mysql_fetch_array($res);
		return $d["anzahl"];
	}
}
?>
