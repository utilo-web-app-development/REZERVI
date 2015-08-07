<?php

//konstanten fuer eigenschaften:
define("STANDARDSPRACHE","standardsprache"); //standardsprache des belegungsplanes 
define("MIETOBJEKT_THUMBS_ACTIV","mietobjekt thumbs anzeigen"); //anzeigen von thumbnails bei der suche
define("BELEGUNGSPLAN_BILDER_ACTIV","bilder im belegungsplan anzeigen");
define("SUCHERGEBNISSE_BILDER_ACTIV","bilder in den suchergebnissen anzeigen");
define("BILDER_WIDTH","breite der bilder bei upload");
define("BILDER_HEIGHT","hoehe der bilder bei upload");
define("STANDARDANSICHT","standardansicht des belegungsplanes"); //konstanten fuer ansichten in constants definiert
// welche ansichten sollen im belegungsplan angezeigt werden?
define("JAHRESUEBERSICHT_ANZEIGEN","Jahresansicht_ANZEIGEN");
define("MONATSUEBERSICHT_ANZEIGEN","Monatsansicht_ANZEIGEN");
define("WOCHENANSICHT_ANZEIGEN","Wochenansicht_ANZEIGEN");
define("TAGESANSICHT_ANZEIGEN","Tagesansicht_ANZEIGEN");
define("SUCHFUNKTION_AKTIV","Suche aktiv"); //wenn true dann wird suche im belegungsplan angezeigt, sonst false
//dauer einer Reservierung eines tisches in minuten:
define("RESERVIERUNGSDAUER","reservierungsdauer");
//hoehe und breite eines bildes fuer einen raum:
define("MAX_BILDBREITE_RAUM","maximalWidthRoom");
define("MAX_BILDHOEHE_RAUM", "maximalHeightRoom");
//hoehe und breite eines bildes fuer belegt und frei symbol:
define("MAX_BILDBREITE_BELEGT_FREI","maximalWidthfreeoccu");
define("MAX_BILDHOEHE_BELEGT_FREI", "maximalHeightoccupiedfree");
//reservierungsschluessel:
define("RESERVIERUNGSSCHLUESSEL","RES_key");


/**
 * @author coster
 * @date 28.6.2007
 * gibt die anzahl vorhandener Gastronomiebetriebe aus
 */
function getNumberOfGastros(){
	global $db;
	$query = ("select 
			   count(GASTRO_ID) as anzahl
			   FROM
			   BOOKLINE_GASTRO
   			  ");           

	$res = $db->Execute($query);
	if (!empty($res)) { 		 
		$wert = $res->fields["anzahl"];
		if (!empty($wert)){
			return $wert;
		}
	}
	return 0;
}

/**
 * @author coster
 * setzt default werte fuer properties eines gastronomiebetriebes
 */
function setGastroDefaultProperties($gastro_id){	
    setGastroProperty(RESERVIERUNGSDAUER,120,$gastro_id); //120 minuten
    setGastroProperty(MAX_BILDBREITE_RAUM,800,$gastro_id);
	setGastroProperty(MAX_BILDHOEHE_RAUM, 500,$gastro_id);
	setGastroProperty(MAX_BILDBREITE_BELEGT_FREI,75,$gastro_id);
	setGastroProperty(MAX_BILDHOEHE_BELEGT_FREI,75,$gastro_id);
}
 /**
 * author:coster
 * date: 10.9.05
 * liefert einen wert aus den eigenschaften
 * als bezeichnung konstante verwenden
 * @param $bezeichnung die Bezeichnung des Wertes
 * @param $gastro_id
 * @return den wert der Eigenschaft
 * */
function getGastroProperty($bezeichnung,$gastro_id){
			
	global $db;			
	
	$query = ("SELECT 
			   WERT
			   FROM
			   BOOKLINE_GASTRO_PROPERTIES
			   WHERE
			   BEZEICHNUNG = '$bezeichnung'
			   AND
			   GASTRO_ID = '$gastro_id'
			  ");           

	$res = $db->Execute($query);
	
	if (!$res) { 
		print $db->ErrorMsg();
		return false;
	}
	else{
		$wert = $res->fields["WERT"];
		if ($wert == ""){
			return false;
		}
		else{
			return $wert;
		}
	}

}
/**
 * author: coster
 * date: 20.9.05
 * setzt einen wert in den eigenschaften des vermieters (aus konstanten entnehmen)
 * */
function setGastroProperty($bezeichnung,$wert,$gastro_id){
	
	global $db;
	
	$temp = getGastroProperty($bezeichnung,$gastro_id);
	if (empty($temp)){
		$query = ("INSERT INTO 
		   BOOKLINE_GASTRO_PROPERTIES
		   (BEZEICHNUNG,GASTRO_ID,WERT)
		   VALUES
		   ('$bezeichnung','$gastro_id','$wert')
		  ");     
	}
	else{
		$query = ("UPDATE 
		   BOOKLINE_GASTRO_PROPERTIES
		   SET
		   WERT = '$wert'
		   where
		   GASTRO_ID = '$gastro_id'
		   and
		   BEZEICHNUNG = '$bezeichnung'
		  ");  
	}
	
	$res = $db->Execute($query);
	
	if (!$res) { 		 
		print $db->ErrorMsg();
		return false;
	}
	else{
		return true;
	}
}
/**
 * author: coster
 * date: 19.9.05
 * liefert den firmennamen des vermieters
 * 
 * */
function getGastroFirmenName($gastro_id){
		global $db;
		$query = "select 
					a.FIRMA 
					from 
					BOOKLINE_ADRESSE a, BOOKLINE_GASTRO v 
					where 
					v.GASTRO_ID = '$gastro_id'
					and
					v.ADRESSE_ID = a.ADRESSE_ID
				  ";

  		$res = $db->Execute($query);
  		if (!$res){  			
  			return false;
  		}
		else{
			return $res->fields["FIRMA"];
		}	
		
} 
/**
 * author: coster
 * date: 19.9.05
 * liefert die bezeichnung des mietobjektes in einzahl
 * 
 * */
function getVermieterMietobjektEz($gastro_id){
		global $db;
		$query = "select 
					MIETOBJEKT_EZ
					from 
					BOOKLINE_GASTRO 
					where 
					GASTRO_ID = '$gastro_id'
				  ";

  		$res = $db->Execute($query);
  		if (!$res){
  			
  			return false;
  		}
		else{
			return $res->fields["MIETOBJEKT_EZ"];
		}		
		
} 
/**
 * author: coster
 * date: 19.9.05
 * liefert die bezeichnung des mietobjektes in einzahl
 * 
 * */
function getVermieterMietobjektMz($gastro_id){
		global $db;
		$query = "select 
					MIETOBJEKT_MZ
					from 
					BOOKLINE_GASTRO 
					where 
					GASTRO_ID = '$gastro_id'
				  ";

  		$res = $db->Execute($query);
  		if (!$res){  			
  			return false;
  		}
		else{
			return $res->fields["MIETOBJEKT_MZ"];
		}	
		
} 

/**
 * author:coster
 * date: 20.9.05
 * liefert die anzahl der benutzer die ein vermieter haben darf - bei miete
 * */
function getAnzahlBenutzer($gastro_id){
	global $db;
		$query = "select 
					ANZAHL_BENUTZER 
					from 
					BOOKLINE_GASTRO 
					where 
					GASTRO_ID = '$gastro_id'
				  ";

  		$res = $db->Execute($query);
  		if (!$res){  			
  			return false;
  		}
		else{		
			return $res->fields["AnzahlBenutzer"];
		}
		
} 
/**
 * author:coster
 * date: 19.9.05
 * liefert den nachnamen des vermieters
 * */
function getVermieterVorname($gastro_id){
	
	global $db;

		$query = "select 
					a.VORNAME 
					from 
					BOOKLINE_ADRESSE a, BOOKLINE_GASTRO v 
					where 
					GASTRO_ID = '$gastro_id'
					and
					a.ADRESSE_ID = v.ADRESSE_ID
				   ";

  		$res = $db->Execute($query);
  		if (!$res){  			
  			return false;
  		}
		else{
			return $res->fields["VORNAME"];
		}
		
} 
/**
 * author:coster
 * date: 19.9.05
 * liefert den nachnamen des vermieters
 * */
function getVermieterNachname($gastro_id){
	
	global $db;

		$query = "select 
					a.NACHNAME 
					from 
					BOOKLINE_ADRESSE a, BOOKLINE_GASTRO v 
					where 
					GASTRO_ID = '$gastro_id'
					and
					a.ADRESSE_ID = v.ADRESSE_ID
				   ";

  		$res = $db->Execute($query);
  		if (!$res){  			
  			return false;
  		}
		else{
			return $res->fields["NACHNAME"];
		}
		
} 
/**
 * author:coster
 * date: 19.9.05
 * liefert die e-mail-adresse eines vermieters
 * */
function getVermieterEmail($gastro_id){
	
	global $db;
	
	//unterkunft-email aus datenbank auslesen:
		$d = "";	
		$query = "select 
					a.EMAIL 
					from 
					BOOKLINE_ADRESSE a, BOOKLINE_GASTRO v
					where 
					v.GASTRO_ID = '$gastro_id'
					and
					v.ADRESSE_ID = a.ADRESSE_ID
				   ";

  		$res = $db->Execute($query);
  		if (!$res){  			
  			return false;
  		}
		else{		
			return $res->fields["EMAIL"];
		}
		
} 
/**
 * author: coster
 * date: 19.9.05
 * liefert die strasse eines vermieters
 */
function getVermieterStrasse($gastro_id){
	global $db;
		$query = "select 
					a.STRASSE 
					from 
					BOOKLINE_ADRESSE a, BOOKLINE_GASTRO v
					where 
					v.GASTRO_ID = '$gastro_id'
					and
					v.ADRESSE_ID = a.ADRESSE_ID
				  ";

  		$res = $db->Execute($query);
  		if (!$res){  			
  			return false;
  		}
		else{
			return $res->fields["STRASSE"];
		}
} 
/**
 * author: coster
 * date: 19.9.05
 * liefert die plz eines vermieters
 */
function getVermieterPlz($gastro_id){
	global $db;
		$query = "select 
					a.PLZ 
					from 
					BOOKLINE_ADRESSE a, BOOKLINE_GASTRO v 
					where 
					GASTRO_ID = '$gastro_id'
					and
					a.ADRESSE_ID = v.ADRESSE_ID
				  ";

  		$res = $db->Execute($query);
  		if (!$res){  			
  			return false;
  		}
		else{
			return $res->fields["PLZ"];
		}				
} 
/**
 * author: coster
 * date: 19.9.05
 * liefert den wohnort eines vermieters
 * */
function getVermieterOrt($gastro_id){
	global $db;
	
		$query = "select 
					a.ORT 
					from 
					BOOKLINE_ADRESSE a, BOOKLINE_GASTRO v 
					where 
					GASTRO_ID = '$gastro_id'
					and
					a.ADRESSE_ID = v.ADRESSE_ID
				  ";

  		$res = $db->Execute($query);
  		if (!$res){  			
  			return false;
  		}
		else{
			return $res->fields["ORT"];
		}				
} 
/**
 * author: coster
 * date: 19.9.05
 * liefert das land des vermieters
 * */
function getVermieterLand($gastro_id){
	global $db;
		$query = "select 
					a.LAND 
					from 
					BOOKLINE_ADRESSE a, BOOKLINE_GASTRO v 
					where 
					GASTRO_ID = '$gastro_id'
					and
					a.ADRESSE_ID = v.ADRESSE_ID
				  ";

  		$res = $db->Execute($query);
  		if (!$res){  			
  			return false;
  		}
		else{
			return $res->fields["LAND"];
		}
				
} 
/**
 * author: coster
 * date: 19.9.05
 * liefert die telefonnummer des vermieters
 * */
function getVermieterTel($gastro_id){
	
	global $db;
	
		$query = "select 
					a.TELEFON 
					from 
					BOOKLINE_ADRESSE a, BOOKLINE_GASTRO v 
					where 
					GASTRO_ID = '$gastro_id'
					and
					a.ADRESSE_ID = v.ADRESSE_ID
				  ";

  		$res = $db->Execute($query);
  		if (!$res){  			
  			return false;
  		}
  		else{		
			return $res->fields["TELEFON"];
  		}
				
} 
/**
 * author: coster
 * date: 19.9.05
 * liefert die 2. telefonnummer des vermieters
 * */
function getVermieterTel2($gastro_id){
	global $db;
		$query = "select 
					a.TELEFON2
					from
					BOOKLINE_ADRESSE a, BOOKLINE_GASTRO v 
					where 
					GASTRO_ID = '$gastro_id'
					and
					a.ADRESSE_ID = v.ADRESSE_ID
				  ";

  		$res = $db->Execute($query);
  		if (!$res){  			
  			return false;
  		}
		else{		
			return $res->fields["TELEFON2"];
		}
} 
/**
 * author: coster
 * date: 19.9.05
 * liefert die faxnummer des vermieters
 * */
function getVermieterFax($gastro_id){
	global $db;
		$query = "select 
					a.FAX 
					from 
					BOOKLINE_ADRESSE a, BOOKLINE_GASTRO v 
					where 
					GASTRO_ID = '$gastro_id'
					and
					a.ADRESSE_ID = v.ADRESSE_ID
				  ";

  		$res = $db->Execute($query);
  		if (!$res){  			
  			return false;
  		}
		else{
			return $res->fields["FAX"];
		}
				
} 
/**
 * author: coster
 * date: 20.9.05
 * liefert die homepage des vermieters
 * */
function getVermieterUrl($gastro_id){
	global $db;
		$query = "select 
					a.WWW
					from 
					BOOKLINE_ADRESSE a, BOOKLINE_GASTRO v 
					where 
					GASTRO_ID = '$gastro_id'
					and
					a.ADRESSE_ID = v.ADRESSE_ID
				  ";

  		$res = $db->Execute($query);
  		if (!$res){  			
  			return false;
  		}
		else{
			return $res->fields["WWW"];
		}
				
} 
/**
 * author:coster
 * date: 22.9.05
 * liefert die adress-id eines vermieters,
 * wenn noch keine vorhanden wird false zur�ckgegeben.
 * */
 function getAdressIDfromVermieter($gastro_id){
 		global $db;
		$query = "select
					a.ADRESSE_ID
					from 
					BOOKLINE_GASTRO v, BOOKLINE_ADRESSE a
					where 
					v.GASTRO_ID = '$gastro_id'
					and
					v.ADRESSE_ID = a.ADRESSE_ID
				  ";

  		$res = $db->Execute($query);
  		if (!$res){  			
  			return false;
  		}
  		else{
  			$id =  $res->fields["ADRESSE_ID"];
  			if ($id == ""){
  				return false;
  			}
  			return $id;
  		}
 }
/**
 * author:coster
 * date: 20.9.05
 * setzt die anzahl der mietobjekte die ein vermieter haben darf - bei miete
 * */
function setAnzahlMietobjekte($gastro_id,$anzahlMO){
		global $db;
		$query = "UPDATE 
					BOOKLINE_GASTRO 
					SET 
					ANZAHL_MIETOBJEKTE = '$anzahlMO' 
					where 
					GASTRO_ID = '$gastro_id'
				  ";

  		$res = $db->Execute($query);
  		if (!$res){  			
  			return false;
  		}
  		else{
  			return true;
  		}
		
} 
/**
 * author:coster
 * date: 20.9.05
 * setzt die anzahl der benutzer die ein vermieter haben darf - bei miete
 * */
function setAnzahlBenutzer($gastro_id,$anzahlBenutzer){
		global $db;
		$query = "UPDATE 
					BOOKLINE_GASTRO 
					SET 
					ANZAHL_BENUTZER = '$anzahlBenutzer' 
					where 
					GASTRO_ID = '$gastro_id'
				  ";

  		$res = $db->Execute($query);
  		if (!$res){  			
  			return false;
  		}
  		else{
  			return true;
  		}
		
} 
/**
 * author:coster
 * date: 20.9.05
 * setzt den vornamen des vermieters
 * */
function setVermieterVorname($gastro_id,$vname){
	global $db;
	
	$adress_id = getAdressIDfromVermieter($gastro_id);
	
	if ($adress_id == false){
		$query = "insert into 
					BOOKLINE_ADRESSE
					SET 
					VORNAME = '$vname'
				  ";
	}
	else{
		$query = "update 
					BOOKLINE_ADRESSE
					SET 
					VORNAME = '$vname'
					where 
					ADRESSE_ID = '$adress_id'
				  ";
	}
	
	$res = $db->Execute($query);
	if (!$res){		
		return false;
	}
	else{
		return true;
	}
			
} 
/**
 * author:coster
 * date: 20.9.05
 * setzt den nachnamen des vermieters
 * */
function setVermieterNachname($gastro_id,$nname){
	global $db;
	
		$adress_id = getAdressIDfromVermieter($gastro_id);
	
	if ($adress_id == false){
		$query = "insert into 
					BOOKLINE_ADRESSE
					SET 
					NACHNAME = '$nname'
				  ";
	}
	else{
		$query = "update 
					BOOKLINE_ADRESSE
					SET 
					NACHNAME = '$nname'
					where 
					ADRESSE_ID = '$adress_id'
				  ";
	}
	
  		$res = $db->Execute($query);
  		if (!$res){  			
  			return false;
  		}
  		else{
  			return true;
  		}
			
} 
/**
 * author:coster
 * date: 20.9.05
 * setzt den nachnamen des vermieters
 * */
function setVermieterFirmenname($gastro_id,$fname){
	global $db;
	
	$adress_id = getAdressIDfromVermieter($gastro_id);
	
	if ($adress_id == false){
		$query = "insert into 
					BOOKLINE_ADRESSE
					SET 
					FIRMA = '$fname'
				  ";
	}
	else{
		$query = "update 
					BOOKLINE_ADRESSE
					SET 
					FIRMA = '$fname'
					where 
					ADRESSE_ID = '$adress_id'
				  ";
	}

  		$res = $db->Execute($query);
  		if (!$res){  			
  			return false;
  		}
  		else{
  			return true;
  		}
			
} 
/**
 * author:coster
 * date: 20.9.05
 * */
function setVermieterEmail($gastro_id,$email){
	global $db;
	
	$adress_id = getAdressIDfromVermieter($gastro_id);
	
	if ($adress_id == false){
		$query = "insert into 
					BOOKLINE_ADRESSE
					SET 
					EMAIL = '$email'
				  ";
	}
	else{
		$query = "update 
					BOOKLINE_ADRESSE
					SET 
					EMAIL = '$email'
					where 
					ADRESSE_ID = '$adress_id'
				  ";
	}
	
  		$res = $db->Execute($query);
  		if (!$res){  			
  			return false;
  		}
  		else{
  			return true;
  		}
			
} 
/**
 * author:coster
 * date: 20.9.05
 * */
function setVermieterStrasse($gastro_id,$strasse){
	global $db;
	$adress_id = getAdressIDfromVermieter($gastro_id);

	if ($adress_id == false){
		$query = "insert into 
					BOOKLINE_ADRESSE
					SET 
					STRASSE = '$strasse'
				  ";
	}
	else{
		$query = "update 
					BOOKLINE_ADRESSE
					SET 
					STRASSE = '$strasse'
					where 
					ADRESSE_ID = '$adress_id'
				  ";
	}
	
  		$res = $db->Execute($query);
  		if (!$res){  			
  			return false;
  		}
  		else{
  			return true;
  		}
				
} 
/**
 * author:coster
 * date: 20.9.05
 * */
function setVermieterPlz($gastro_id,$plz){
	global $db;

	$adress_id = getAdressIDfromVermieter($gastro_id);
	if ($adress_id == false){
		$query = "insert into 
					BOOKLINE_ADRESSE
					SET 
					PLZ = '$plz'
				  ";
	}
	else{
		$query = "update 
					BOOKLINE_ADRESSE
					SET 
					PLZ = '$plz'
					where 
					ADRESSE_ID = '$adress_id'
				  ";
	}

  		$res = $db->Execute($query);
  		if (!$res){  			
  			return false;
  		}
  		else{
  			return true;
  		}
				
} 

function setVermieterOrt($gastro_id,$ort){
	global $db;
	
	$adress_id = getAdressIDfromVermieter($gastro_id);
	if ($adress_id == false){
		$query = "insert into 
					BOOKLINE_ADRESSE
					SET 
					ORT = '$ort'
				  ";
	}
	else{
		$query = "update 
					BOOKLINE_ADRESSE
					SET 
					ORT = '$ort'
					where 
					ADRESSE_ID = '$adress_id'
				  ";
	}

  		$res = $db->Execute($query);
  		if (!$res){  			
  			return false;
  		}
  		else{
  			return true;
  		}
				
} 
/**
 * author:coster
 * date: 20.9.05
 * */
function setVermieterLand($gastro_id,$land){
	global $db;
	
	$adress_id = getAdressIDfromVermieter($gastro_id);
	if ($adress_id == false){
		$query = "insert into 
					BOOKLINE_ADRESSE
					SET 
					LAND = '$land'
				  ";
	}
	else{
		$query = "update 
					BOOKLINE_ADRESSE
					SET 
					LAND = '$land'
					where 
					ADRESSE_ID = '$adress_id'
				  ";
	}
	
  		$res = $db->Execute($query);
  		if (!$res){  			
  			return false;
  		}
  		else{
  			return true;
  		}
				
} 
/**
 * author:coster
 * date: 20.9.05
 * */
function setVermieterTel($gastro_id,$tel){
	global $db;
	
	$adress_id = getAdressIDfromVermieter($gastro_id);
	if ($adress_id == false){
		$query = "insert into 
					BOOKLINE_ADRESSE
					SET 
					TELEFON = '$tel'
				  ";
	}
	else{
		$query = "update 
					BOOKLINE_ADRESSE
					SET 
					TELEFON = '$tel'
					where 
					ADRESSE_ID = '$adress_id'
				  ";
	}
	
  		$res = $db->Execute($query);
  		if (!$res){  			
  			return false;
  		}
  		else{
  			return true;
  		}
			
} 
/**
 * author:coster
 * date: 20.9.05
 * */
function setVermieterTel2($gastro_id,$tel2){
	global $db;
	
	$adress_id = getAdressIDfromVermieter($gastro_id);
	if ($adress_id == false){
		$query = "insert into 
					BOOKLINE_ADRESSE
					SET 
					TELEFON2 = '$tel2'
				  ";
	}
	else{
		$query = "update 
					BOOKLINE_ADRESSE
					SET 
					TELEFON2 = '$tel2'
					where 
					ADRESSE_ID = '$adress_id'
				  ";
	}
	
  		$res = $db->Execute($query);
  		if (!$res){  			
  			return false;
  		}
  		else{
  			return true;
  		}
				
} 
/**
 * author:coster
 * date: 20.9.05
 * */
function setVermieterFax($gastro_id,$fax){
	global $db;
	
	$adress_id = getAdressIDfromVermieter($gastro_id);
	if ($adress_id == false){
		$query = "insert into 
					BOOKLINE_ADRESSE
					SET 
					FAX = '$fax'
				  ";
	}
	else{
		$query = "update 
					BOOKLINE_ADRESSE
					SET 
					FAX = '$fax'
					where 
					ADRESSE_ID = '$adress_id'
				  ";
	}

  		$res = $db->Execute($query);
  		if (!$res){
  			return false;
  		}
  		else{
  			return true;
  		}
				
} 
/**
 * author:coster
 * date: 20.9.05
 * */
function setVermieterUrl($gastro_id,$url){
	global $db;
	
	$adress_id = getAdressIDfromVermieter($gastro_id);
	if ($adress_id == false){
		$query = "insert into 
					BOOKLINE_ADRESSE
					SET 
					WWW = '$url'
				  ";
	}
	else{
		$query = "update 
					BOOKLINE_ADRESSE
					SET 
					WWW = '$url'
					where 
					ADRESSE_ID = '$adress_id'
				  ";
	}
	
  		$res = $db->Execute($query);
  		if (!$res){
  			return false;
  		}
  		else{
  			return true;
  		}
				
} 
/**
 * author: coster
 * date: 20.9.05
 * speichert die art des mietobjektes - einzahl
 * z. b. Tennisplatz
 * */
function setMietobjekt_EZ($gastro_id,$mietobjekt){
		global $db;
		$query = "UPDATE 
					BOOKLINE_GASTRO 
					SET 
					MIETOBJEKT_EZ = '$mietobjekt' 
					where 
					GASTRO_ID = '$gastro_id'
				  ";

  		$res = $db->Execute($query);
  		if (!$res){  			
  			print $db->ErrorMsg();
  			return false;
  		}
  		else{
  			return true;
  		}
  		
}
/**
 * author: coster
 * date: 20.9.05
 * speichert die art des mietobjektes - mehrzahl
 * z. b. Tennispl�tze
 * */
function setMietobjekt_MZ($gastro_id,$mietobjekt){
		global $db;
		$query = "UPDATE 
					BOOKLINE_GASTRO 
					SET 
					MIETOBJEKT_MZ = '$mietobjekt' 
					where 
					GASTRO_ID = '$gastro_id'
				  ";

  		$res = $db->Execute($query);
  		if (!$res){  			
  			print $db->ErrorMsg();
  			return false;
  		}
  		else{
  			return true;
  		}
  		
}

?>