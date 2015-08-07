<?php

define("LIMIT_MIETERLISTE","6"); //limit der angezeigten g�ste pro seite
define("ANONYMER_GAST_ID","1"); //anonymer mieter - sollte nirgends aufscheinen
define("NEUER_MIETER","neuerMieter"); //konstante fuer form felder mit neuem mieter

/**
 * author:coster
 * date: 17.10.05
 * l�scht einen mieter
 * */
function deleteMieter($mieter_id){
	global $db;
	
	$query = ("delete from 
				BOOKLINE_RESERVIERUNG 
				WHERE
				GAST_ID = '$mieter_id'
				 ");

  	$res = $db->Execute($query);
	if (!$res)  {
		
		print $db->ErrorMsg();
		exit;
	}
	
	$query = ("delete from 
				BOOKLINE_GAST_TEXTE 
				WHERE
				GAST_ID = '$mieter_id'
				 ");

  	$res = $db->Execute($query);
	if (!$res)  {
		
		print $db->ErrorMsg();
		exit;
	}
	
	$query = ("delete from 
				BOOKLINE_GAST 
				WHERE
				GAST_ID = '$mieter_id'
				 ");

  	$res = $db->Execute($query);
	if (!$res)  {
		
		print $db->ErrorMsg();
		exit;
	}
		
	return true;

}
/**
 * author:coster
 * date:14.10.05
 * speichert einen neuen mieter
 * */
function insertMieter($gastro_id,$anrede,$vorname,$nachname,$strasse,$plz,$ort,$land,$email,$tel,$tel2,$fax,$url,$firma,$speech, $beschreibung, $bezeichnung){
	
	global $db;	 
	
	$query = ("insert into 
				BOOKLINE_ADRESSE
				(ANREDE,VORNAME,NACHNAME,STRASSE,PLZ,ORT,LAND,EMAIL,TELEFON,TELEFON2,FAX,WWW,FIRMA)
				VALUES				
				('$anrede','$vorname','$nachname','$strasse','$plz','$ort','$land','$email','$tel','$tel2','$fax','$url','$firma')
		   	  ");
		   	  
	$res = $db->Execute($query);
	if (!$res)  {		
		print $db->ErrorMsg();
		exit;
	}
	$bezeichnung_array = explode(",", $bezeichnung);
	$echtBuchung = 0;
	foreach($bezeichnung_array as $jede){
		if(getStatusOfGaesteGruppe($jede, $gastro_id)== "unbuchung"){
			$echtBuchung = 0;
			break;
		}else if (getStatusOfGaesteGruppe($jede, $gastro_id) == "buchung"){
			$echtBuchung = 0;
			break;
		}else if(getStatusOfGaesteGruppe($jede, $gastro_id) == "echtBuchung"){
			$echtBuchung = 1;
		}
	}
	$adresse_id = $db->Insert_ID();	
	$query = ("insert into 
				BOOKLINE_GAST
				(ADRESSE_ID,GASTRO_ID,SPRACHE_ID,BEZEICHNUNG,BESCHREIBUNG,ECHTBUCHUNG)
				VALUES				
				('$adresse_id','$gastro_id','$speech','$bezeichnung','$beschreibung','$echtBuchung')
		   	  ");

  	$res = $db->Execute($query);
  	
	if (!$res)  {
		echo("fehler: ".$db->ErrorMsg());
		exit;
	}

	$mieter_id = $db->Insert_ID();
	return $mieter_id;

}
/**
 * author:coster
 * date:17.10.05
 * liefert die adress-id eines mieters
 * */
 function getAdressIDfromMieter($mieter_id){
 	
 	global $db;
	
	$query = ("SELECT 
				ADRESSE_ID
				FROM
				BOOKLINE_GAST 
				WHERE
				GAST_ID = '$mieter_id'
				 ");

  	$res = $db->Execute($query);
	if (!$res)  {
		
		print $db->ErrorMsg();
		return false;
	}
		
	$d = $res->FetchNextObject();
	return $d->ADRESSE_ID;
 
 }
/**
 * author:coster
 * date:17.10.05
 * �ndert einen bereits vorhandenen mieter
 * */
function updateMieter($mieter_id,$anrede,$vorname,$nachname,$strasse,$plz,$ort,$land,$email,$tel,$tel2,$fax,$url,$firma,$sprache, $bezeichnung, $beschreibung){
	
	$adresse_id = getAdressIDfromMieter($mieter_id);
	
	global $db;
	global $gastro_id;
	
	$bezeichnung_array = explode(",", $bezeichnung);
	$echtBuchung = 0;
	foreach($bezeichnung_array as $jede){
		if(getStatusOfGaesteGruppe($jede, $gastro_id) == "unbuchung"){
			$echtBuchung = 0;
			break;
		}else if (getStatusOfGaesteGruppe($jede, $gastro_id) == "buchung"){
			$echtBuchung = 0;
			break;
		}else if(getStatusOfGaesteGruppe($jede, $gastro_id) == "echtBuchung"){
			$echtBuchung = 1;
		}
	}
	$query = ("UPDATE
				BOOKLINE_GAST
				SET	
				SPRACHE_ID = '$sprache',
				BEZEICHNUNG = '$bezeichnung',
				BESCHREIBUNG = '$beschreibung',
				ECHTBUCHUNG = '$echtBuchung'
				where
				GAST_ID = '$mieter_id' 
			");
			
	$res = $db->Execute($query);
	if (!$res)  {
		
		print $db->ErrorMsg();
		return false;
	}		
	
		$query = ("UPDATE
				BOOKLINE_ADRESSE
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
				WWW = '$url',
			  	FIRMA = '$firma'
				WHERE
				ADRESSE_ID = '$adresse_id'
		   	  ");

  	$res = $db->Execute($query);
	if (!$res)  {
		print $db->ErrorMsg();
		return false;
	}
	
	return true;
	
} 
/**
 * @author: coster
 * Datum: 8.Apr.2006
 * f�gt einen text eines mieters ein
 * @param $text der zu speichernde text
 * @param $mieter_id die id des mieters
 */
 function insertMieterText($text,$mieter_id){
 	
 	global $db;
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
	
	$query = ("insert into BOOKLINE_GAST_TEXTE 
				(GAST_ID,TEXT,DATUM)
				values
				('$mieter_id','$text','$datum')
				");

  	$res = $db->Execute($query);
	if (!$res)  {		
		print $db->ErrorMsg();
		die ($query);
	}		
 	
 }
/**
 * author:coster
 * date:17.10.05 
 * funktion pr�ft, ob ein mieter bereits vorhanden ist.
  ich checke mal nach vornamen, nachnamen und e-mail,
  das d�rfte wohl eindeutig sein
  dann id des mieters zur�ckgeben:
 * */
function getMieterId($gastro_id,$vorname,$nachname,$email){
	
	global $db;
	
	$query = ("SELECT 
				m.GAST_ID
				FROM
				BOOKLINE_GAST m, BOOKLINE_ADRESSE a
				WHERE
				a.VORNAME = '$vorname' and
				a.NACHNAME = '$nachname' and
				a.EMAIL = '$email' and
				m.GASTRO_ID = '$gastro_id' and
				m.ADRESSE_ID = a.ADRESSE_ID
				");

  	$res = $db->Execute($query);
	if (!$res)  {
		
		print $db->ErrorMsg();
		return false;
	}
		
	$d = $res->FetchNextObject();
	if (!empty($d)){
		$mieter_id = $d->GAST_ID;
		return $mieter_id;
	}
	return false;

}
/**
 * author:coster
 * date:8.10.05
 * liefert den nachnamen eines mieters
 * */
function getNachnameOfMieter($mieter_id){
	
	global $db;
	
	$query = ("SELECT 
				a.NACHNAME
				FROM
				BOOKLINE_GAST m, BOOKLINE_ADRESSE a
				WHERE
				m.GAST_ID = '$mieter_id'
				and
				m.ADRESSE_ID = a.ADRESSE_ID
				 ");

  	$res = $db->Execute($query);
	if (!$res)  {
		
		print $db->ErrorMsg();
		return false;
	}
		
	$d = $res->FetchNextObject();
	if (!empty($d)){
		return $d->NACHNAME;
	}
	return false;

}
/**
 * author:coster
 * date:8.10.05
 * liefert die sprache eines mieters
 * */
function getSpracheOfMieter($mieter_id){
	
	global $db;
	
	$query = ("SELECT 
				SPRACHE_ID
				FROM
				BOOKLINE_GAST
				WHERE
				GAST_ID = '$mieter_id'
				 ");

  	$res = $db->Execute($query);
	if (!$res)  {
		
		print $db->ErrorMsg();
		return false;
	}
	
	$d = $res->FetchNextObject();
	return $d->SPRACHE_ID;

}
/**
 * author:coster
 * date:17.10.05
 * liefert den ort eines mieters
 * */
function getMieterOrt($mieter_id){
	global $db;
	$query = ("SELECT 
				a.ORT
				FROM
				BOOKLINE_GAST m, BOOKLINE_ADRESSE a
				WHERE
				m.GAST_ID = '$mieter_id'
				and
				a.ADRESSE_ID = m.ADRESSE_ID
				 ");

  	$res = $db->Execute($query);
	if (!$res)  {
		
		print $db->ErrorMsg();
		return false;
	}
		
	$d = $res->FetchNextObject();
	return $d->ORT;

}
/**
 * author:coster
 * date:17.10.05
 * liefert den vornamen eines mieters
 * */
function getMieterVorname($mieter_id){
	global $db;
	$query = ("SELECT 
				a.VORNAME
				FROM
				BOOKLINE_GAST m, BOOKLINE_ADRESSE a
				WHERE
				m.GAST_ID = '$mieter_id'
				and
				a.ADRESSE_ID = m.ADRESSE_ID
				 ");

  	$res = $db->Execute($query);
	if (!$res)  {
		
		print $db->ErrorMsg();
		return false;
	}
		
	$d = $res->FetchNextObject();
	if (!empty($d)){
		return $d->VORNAME;
	}
	return false;

}
/**
 * author:coster
 * date: 17.10.05
 * liefert die strasse eines mieters
 * */
function getMieterStrasse($mieter_id){
	global $db;
	$query = ("SELECT 
				a.STRASSE
				FROM
				BOOKLINE_GAST m, BOOKLINE_ADRESSE a
				WHERE
				m.GAST_ID = '$mieter_id'
				and
				a.ADRESSE_ID = m.ADRESSE_ID
				 ");

  	$res = $db->Execute($query);
	if (!$res)  {
		
		print $db->ErrorMsg();
		return false;
	}
		
	$d = $res->FetchNextObject();
	return $d->STRASSE;

}
/**
 * author:coster
 * date: 17.10.05
 * liefert die plz eines mieters
 * */
function getMieterPlz($mieter_id){
	global $db;
	$query = ("SELECT 
				a.PLZ
				FROM
				BOOKLINE_GAST m, BOOKLINE_ADRESSE a
				WHERE
				m.GAST_ID = '$mieter_id'
				and
				a.ADRESSE_ID = m.ADRESSE_ID
				 ");

  	$res = $db->Execute($query);
	if (!$res)  {
		
		print $db->ErrorMsg();
		return false;
	}
		
	$d = $res->FetchNextObject();
	return $d->PLZ;

}
/**
 * author:coster
 * date: 17.10.05
 * liefert das land eines mieters
 * */
function getMieterLand($mieter_id){
	global $db;
	$query = ("SELECT 
				a.LAND
				FROM
				BOOKLINE_GAST m, BOOKLINE_ADRESSE a
				WHERE
				m.GAST_ID = '$mieter_id'
				and
				a.ADRESSE_ID = m.ADRESSE_ID
				 ");

  	$res = $db->Execute($query);
	if (!$res)  {
		
		print $db->ErrorMsg();
		return false;
	}
		
	$d = $res->FetchNextObject();
	return $d->LAND;

}
/**
 * author:coster
 * date: 8.4.06
 * liefert die firma eines mieters
 * */
function getMieterFirma($mieter_id){
	global $db;
	$query = ("SELECT 
				a.FIRMA
				FROM
				BOOKLINE_GAST m, BOOKLINE_ADRESSE a
				WHERE
				m.GAST_ID = '$mieter_id'
				and
				a.ADRESSE_ID = m.ADRESSE_ID
				 ");

  	$res = $db->Execute($query);
	if (!$res)  {
		
		print $db->ErrorMsg();
		return false;
	}
		
	$d = $res->FetchNextObject();
	return $d->FIRMA;

}
/**
 * author:coster
 * date:8.10.05
 * liefert die e-mail-adresse eines mieters
 * */
function getEmailOfMieter($mieter_id){
	
	global $db;
	
	$query = ("SELECT 
				a.EMAIL
				FROM
				BOOKLINE_GAST m, BOOKLINE_ADRESSE a
				WHERE
				m.GAST_ID = '$mieter_id'
				and
				m.ADRESSE_ID = a.ADRESSE_ID
				 ");

  	$res = $db->Execute($query);
	if (!$res)  {
		
		print $db->ErrorMsg();
		return false;
	}
		
	$d = $res->FetchNextObject();
	return $d->EMAIL;

}
/**
 * author:coster
 * date: 17.10.05
 * liefert die 1. telefonnummer eines mieters
 * */
function getMieterTel($mieter_id){
	global $db;
	$query = ("SELECT 
				a.TELEFON
				FROM
				BOOKLINE_GAST m, BOOKLINE_ADRESSE a
				WHERE
				m.GAST_ID = '$mieter_id'
				and
				a.ADRESSE_ID = m.ADRESSE_ID
				 ");

  	$res = $db->Execute($query);
	if (!$res)  {
		
		print $db->ErrorMsg();
		return false;
	}
		
	$d = $res->FetchNextObject();
	return $d->TELEFON;

}
/**
 * author:coster
 * date: 17.10.05
 * liefert die 2. telefonnummer eines mieters
 * */
function getMieterTel2($mieter_id){
	global $db;
	$query = ("SELECT 
				a.TELEFON2
				FROM
				BOOKLINE_GAST m, BOOKLINE_ADRESSE a
				WHERE
				m.GAST_ID = '$mieter_id'
				and
				a.ADRESSE_ID = m.ADRESSE_ID
				 ");

  	$res = $db->Execute($query);
	if (!$res)  {
		
		print $db->ErrorMsg();
		return false;
	}
		
	$d = $res->FetchNextObject();
	return $d->TELEFON2;

}
/**
 * author:coster
 * date: 17.10.05
 * liefert die url eines mieters
 * */
function getMieterUrl($mieter_id){
	global $db;
	$query = ("SELECT 
				a.WWW
				FROM
				BOOKLINE_GAST m, BOOKLINE_ADRESSE a
				WHERE
				m.GAST_ID = '$mieter_id'
				and
				a.ADRESSE_ID = m.ADRESSE_ID
				 ");

  	$res = $db->Execute($query);
	if (!$res)  {
		
		print $db->ErrorMsg();
		return false;
	}
		
	$d = $res->FetchNextObject();
	return $d->WWW;

}
/**
 * author:coster
 * 17.10.05
 * liefert die faxnummer des mieters 
 * */
function getMieterFax($mieter_id){
	global $db;
	$query = ("SELECT 
				a.FAX
				FROM
				BOOKLINE_GAST m, BOOKLINE_ADRESSE a
				WHERE
				m.GAST_ID = '$mieter_id'
				and
				a.ADRESSE_ID = m.ADRESSE_ID
				 ");

  	$res = $db->Execute($query);
	if (!$res)  {
		
		print $db->ErrorMsg();
		return false;
	}
		
	$d = $res->FetchNextObject();
	return $d->FAX;

}
/**
 * author:coster
 * 17.10.05
 * liefert die anrede des mieters
 * */
function getMieterAnrede($mieter_id){
	global $db;
	$query = ("SELECT 
				a.ANREDE
				FROM
				BOOKLINE_GAST m, BOOKLINE_ADRESSE a
				WHERE
				m.GAST_ID = '$mieter_id'
				and
				a.ADRESSE_ID = m.ADRESSE_ID
				 ");

  	$res = $db->Execute($query);
	if (!$res)  {
		
		print $db->ErrorMsg();
		return false;
	}
		
	$d = $res->FetchNextObject();
	return $d->ANREDE;

}
/**
 * author:coster
 * date:7.10.05
 * liefert eine liste aller mieter, sortiert nach dem nachnamen
 * */
function getAllMieterFromVermieter($gastro_id){	

	global $db;
	$ano = ANONYMER_GAST_ID;
	
	$query = ("SELECT 
				m.*,a.*
				FROM
				BOOKLINE_GAST m, BOOKLINE_ADRESSE a
				WHERE
				m.GASTRO_ID = '$gastro_id'
				AND
				m.ADRESSE_ID = a.ADRESSE_ID
				AND
				m.GAST_ID != '$ano'
				ORDER BY
				a.NACHNAME
				");

  	$res = $db->Execute($query);
	if (!$res)  {
		
		print $db->ErrorMsg();
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
function getMieterListWithLimitAndIndex($gastro_id,$index){	
	
	global $db;
	$limit = LIMIT_MIETERLISTE;
	$ano = ANONYMER_GAST_ID;
	
	$query = ("SELECT 
				m.*, a.*
				FROM
				BOOKLINE_GAST m, BOOKLINE_ADRESSE a
				WHERE
				m.GASTRO_ID = '$gastro_id'
				AND
				m.ADRESSE_ID = a.ADRESSE_ID" .
						" AND
				m.GAST_ID != '$ano'
				ORDER BY
				a.NACHNAME
				LIMIT
				$index,$limit
				");

  	$res = $db->Execute($query);
	if (!$res)  {
		
		print $db->ErrorMsg();
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
function getAnzahlMieter($gastro_id){
	global $db;
		$ano = ANONYMER_GAST_ID;
		$query = ("SELECT 
				count(GAST_ID) as anzahl
				FROM
				BOOKLINE_GAST
				WHERE
				GASTRO_ID = '$gastro_id'" .
				" AND
				GAST_ID != '$ano'
				");

  	$res = $db->Execute($query);
	if (!$res)  {		
		print $db->ErrorMsg();
		return false;
	}
	else{
		return $res->fields["anzahl"];
	}
}
/**
author: lihaitao
date: 20.12.07
*/
function getMieterBezeichnung($gast_id){
 	
 	global $db;
	
	$query = ("SELECT 
				BEZEICHNUNG
				FROM
				BOOKLINE_GAST 
				WHERE
				GAST_ID = '$gast_id'
				 ");

  	$res = $db->Execute($query);
	if (!$res)  {
		
		print $db->ErrorMsg();
		return false;
	}
		
	$d = $res->FetchNextObject();
	return explode(",",$d->BEZEICHNUNG);
 
 }
/**
author: lihaitao
date: 20.12.07
*/
function getMieterBeschreibung($gast_id){
 	
 	global $db;
	
	$query = ("SELECT 
				BESCHREIBUNG
				FROM
				BOOKLINE_GAST 
				WHERE
				GAST_ID = '$gast_id'
				 ");

  	$res = $db->Execute($query);
	if (!$res)  {
		
		print $db->ErrorMsg();
		return false;
	}
		
	$d = $res->FetchNextObject();
	return $d->BESCHREIBUNG;
 
}

/**
author: lihaitao
date: 20.12.07
*/ 
function getMieterEchtbuchung($gast_id){
 	
 	global $db;
	
	$query = ("SELECT 
				ECHTBUCHUNG
				FROM
				BOOKLINE_GAST 
				WHERE
				GAST_ID = '$gast_id'
			  ");

  	$res = $db->Execute($query);
	if (!$res)  {
		
		print $db->ErrorMsg();
		return false;
	}
		
	$d = $res->FetchNextObject();
	return $d->ECHTBUCHUNG;
 
 }
 
/**
 * author:lihaitao
 * date:20.12.07
 * */
function getGaesteGruppen($gastro_id){
	global $db;
	$query = "select 
			  *
			  from
			  BOOKLINE_GASTGRUPPE
			  where
			  GASTRO_ID = '$gastro_id'
			 ";
	$res = $db->Execute($query);
	if (!$res){
		print $db->ErrorMsg();
		return false;
	}else{		
		return $res;
	}	
} 
/**
 * author:lihaitao
 * date:20.12.07
 * */
function insertGaesteGruppe($name, $beschreibung, $status, $gastro_id){
	global $db;
	$query = "INSERT INTO 
			  BOOKLINE_GASTGRUPPE
			  (GRUPPENBEZEICHNUNG,BESCHREIBUNG,STATUS,GASTRO_ID)
			  VALUES
			  ('$name','$beschreibung','$status','$gastro_id')
		";

	$res = $db->Execute($query);
	if (!$res){
		print $db->ErrorMsg();
		return false;
	}	
	return true;
} 
/**
 * author:lihaitao
 * date:20.12.07
 * */
function updateGaesteGruppe($gruppenname_neu, $gruppenname_alt, $beschreibung, $status, $gastro_id){
	
	global $db;
	$query = "UPDATE 
				BOOKLINE_GASTGRUPPE
				SET
          		GRUPPENBEZEICHNUNG = '$gruppenname_neu',
          		BESCHREIBUNG = '$beschreibung',	
				STATUS = '$status'
				where
				GRUPPENBEZEICHNUNG = '$gruppenname_alt'
			  	and
			  	GASTRO_ID = '$gastro_id'
			 ";
	$res = $db->Execute($query);
	if (!$res){
		print $db->ErrorMsg();
		return false;
	}
	if($gruppenname_alt != $gruppenname_neu){
		$query = ("UPDATE 
					BOOKLINE_GAST
					SET
          			BEZEICHNUNG = '$gruppenname_neu'
					where
					BEZEICHNUNG = '$gruppenname_alt'
		   ");     

		$res = $db->Execute($query);
		if (!$res) { 
			print $db->ErrorMsg(); 
			return false;
		}else{
			return true;
		}
	}
	return true;
} 
/**
 * author:lihaitao
 * date:20.12.07
 * */
function deleteGaesteGruppe($gruppenname, $gastro_id){
	global $db;
	
	$query = ("UPDATE 
				BOOKLINE_GAST
				SET
          		BEZEICHNUNG = ''
				where
				BEZEICHNUNG = '$gruppenname'
			  ");           
	$res = $db->Execute($query);
	if (!$res) { 
		print $db->ErrorMsg(); 
		return false;
	}
	
	$query = ("DELETE FROM 
				BOOKLINE_GASTGRUPPE
				where
				GRUPPENBEZEICHNUNG = '$gruppenname'
	    	");           
	$res = $db->Execute($query);
	if (!$res){
		print $db->ErrorMsg();
		return false;
	}
	return true;
} 
/**
 * author:lihaitao
 * date:20.12.07
 * */
function getGruppeOfGast($gast_id){
		global $db;

		$query = "select 
				  BEZEICHNUNG
				  from
				  BOOKLINE_GAST	
				  where
				  GAST_ID = '$gast_id' 
				 ";

  		$res = $db->Execute($query);
  		if (!$res){
  			print $db->ErrorMsg();
			return false;
		}
		else{		
			return $res->fields["BEZEICHNUNG"];
		}
}

function getStatusOfGaesteGruppe($gruppenname, $gastro_id){
	global $db;
	$query = "select 
			  STATUS 
			  from
			  BOOKLINE_GASTGRUPPE	
			  where
			  GRUPPENBEZEICHNUNG = '$gruppenname'
			  and
			  GASTRO_ID = '$gastro_id'
			 ";
	$res = $db->Execute($query);
 	if (!$res){
  		print $db->ErrorMsg();
		return false;
	}else{
		return $res->fields["STATUS"];
	}
}

function getBeschreibungOfGaesteGruppe($gruppenname, $gastro_id){
	global $db;
	$query = "select 
			  BESCHREIBUNG 
			  from
			  BOOKLINE_GASTGRUPPE	
			  where
			  GRUPPENBEZEICHNUNG = '$gruppenname'
			  and
			  GASTRO_ID = '$gastro_id'
			 ";
	$res = $db->Execute($query);
 	if (!$res){
  		print $db->ErrorMsg();
		return false;
	}else{
		return $res->fields["BESCHREIBUNG"];
	}
}
?>
