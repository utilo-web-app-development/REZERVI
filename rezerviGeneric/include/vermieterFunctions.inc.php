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
/**
 * author:coster
 * date: 10.9.05
 * liefert einen wert aus den eigenschaften
 * als bezeichnung konstante verwenden
 * @param $bezeichnung die Bezeichnung des Wertes
 * @param $vermieter_id
 * @return den wert der Eigenschaft
 * */
function getVermieterEigenschaftenWert($bezeichnung,$vermieter_id){
			
			global $link;			
	
			$query = ("SELECT 
					   WERT
					   FROM
					   REZ_GEN_VER_EIGENSCHAFTEN
					   WHERE
					   BEZEICHNUNG = '$bezeichnung'
					   AND
					   VERMIETER_ID = '$vermieter_id'
		   			  ");           

	$res = mysql_query($query, $link);
	
	if (!$res) { 
		echo("die Anfrage $query scheitert"); 
		echo(mysql_error($link));
		return false;
	}
	else{
		$d = mysql_fetch_array($res);
		$wert = $d["WERT"];
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
function setVermieterEigenschaftenWert($bezeichnung,$wert,$vermieter_id){
	
	global $link;
	
	$temp = getVermieterEigenschaftenWert($bezeichnung,$vermieter_id);
	if (empty($temp)){
		$query = ("INSERT INTO 
		   REZ_GEN_VER_EIGENSCHAFTEN
		   (BEZEICHNUNG,VERMIETER_ID,WERT)
		   VALUES
		   ('$bezeichnung','$vermieter_id','$wert')
		  ");     
	}
	else{
		$query = ("UPDATE 
		   REZ_GEN_VER_EIGENSCHAFTEN
		   SET
		   WERT = '$wert'
		   where
		   VERMIETER_ID = '$vermieter_id'
		   and
		   BEZEICHNUNG = '$bezeichnung'
		  ");  
	}
	
	$res = mysql_query($query, $link);
	
	if (!$res) { 
		echo("die Anfrage $query scheitert"); 
		echo(mysql_error($link));
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
function getVermieterFirmenName($vermieter_id){
		global $link;
		$query = "select 
					a.FIRMA 
					from 
					REZ_GEN_ADRESSE a, REZ_GEN_VERMIETER v 
					where 
					v.VERMIETER_ID = '$vermieter_id'
					and
					v.ADRESSE_ID = a.ADRESSE_ID
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  			return false;
  		}
		else{
			$d = mysql_fetch_array($res);
			return $d["FIRMA"];
		}
		
		
} 
/**
 * author: coster
 * date: 19.9.05
 * liefert die bezeichnung des mietobjektes in einzahl
 * 
 * */
function getVermieterMietobjektEz($vermieter_id){
		global $link;
		$query = "select 
					MIETOBJEKT_EZ
					from 
					REZ_GEN_VERMIETER 
					where 
					VERMIETER_ID = '$vermieter_id'
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  			return false;
  		}
		else{
			$d = mysql_fetch_array($res);
			return $d["MIETOBJEKT_EZ"];
		}		
		
} 
/**
 * author: coster
 * date: 19.9.05
 * liefert die bezeichnung des mietobjektes in einzahl
 * 
 * */
function getVermieterMietobjektMz($vermieter_id){
		global $link;
		$query = "select 
					MIETOBJEKT_MZ
					from 
					REZ_GEN_VERMIETER 
					where 
					VERMIETER_ID = '$vermieter_id'
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  			return false;
  		}
		else{
			$d = mysql_fetch_array($res);
			return $d["MIETOBJEKT_MZ"];
		}		
		
} 
/**
 * author: coster
 * date: 20.9.05
 * liefert die anzahl der mietobjekte die ein vermieter 
 * vermieten darf - bei miete
 * */
function getAnzahlMietobjekteOfVermieter($vermieter_id){
		global $link;
		$query = "select 
					ANZAHL_MIETOBJEKTE 
					from 
					REZ_GEN_VERMIETER 
					where 
					VERMIETER_ID = '$vermieter_id'
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  			return false;
  		}
		else{		
			$d = mysql_fetch_array($res);	
			return $d["ANZAHL_MIETOBJEKTE"];
		}
		
} 
/**
 * author: coster
 * date: 20.9.05
 * gibt die die bezeichnung des mietobjektes - einzahl zurück.
 * z. B. Tennisplatz
 * @param $vermieter_id
 * @return string bezeichnung der mietobjekte einzahl
 * */
function getMietobjekt_EZ($vermieter_id){	
	global $link;
		$query = "select 
					MIETOBJEKT_EZ 
					from 
					REZ_GEN_VERMIETER 
					where 
					VERMIETER_ID = '$vermieter_id' 
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  			return false;
  		}
		else{
			$d = mysql_fetch_array($res);			
			return $d["MIETOBJEKT_EZ"];
		}
			
} 
/**
 * author:coster
 * date: 20.9.05
 * gibt die bezeichnung des mietobjektes - mehrzahl - zurück
 * z. b. Tennisplätze
 * */
function getMietobjekt_MZ($vermieter_id){
	global $link;
		$query = "select 
					MIETOBJEKT_MZ 
					from 
					REZ_GEN_VERMIETER 
					where 
					VERMIETER_ID = '$vermieter_id'
				  ";	

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  			return false;
  		}
		else{
			$d = mysql_fetch_array($res);			
			return $d["MIETOBJEKT_MZ"];
		}
		
} 
/**
 * author:coster
 * date: 20.9.05
 * liefert die anzahl der benutzer die ein vermieter haben darf - bei miete
 * */
function getAnzahlBenutzer($vermieter_id){
	global $link;
		$query = "select 
					ANZAHL_BENUTZER 
					from 
					REZ_GEN_VERMIETER 
					where 
					VERMIETER_ID = '$vermieter_id'
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  			return false;
  		}
		else{		
			$d = mysql_fetch_array($res);
			return $d["AnzahlBenutzer"];
		}
		
} 
/**
 * author:coster
 * date: 19.9.05
 * liefert den nachnamen des vermieters
 * */
function getVermieterVorname($vermieter_id){
	
	global $link;

		$query = "select 
					a.VORNAME 
					from 
					REZ_GEN_ADRESSE a, REZ_GEN_VERMIETER v 
					where 
					VERMIETER_ID = '$vermieter_id'
					and
					a.ADRESSE_ID = v.ADRESSE_ID
				   ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  			return false;
  		}
		else{
			$d = mysql_fetch_array($res);	
			return $d["VORNAME"];
		}
		
} 
/**
 * author:coster
 * date: 19.9.05
 * liefert den nachnamen des vermieters
 * */
function getVermieterNachname($vermieter_id){
	
	global $link;

		$query = "select 
					a.NACHNAME 
					from 
					REZ_GEN_ADRESSE a, REZ_GEN_VERMIETER v 
					where 
					VERMIETER_ID = '$vermieter_id'
					and
					a.ADRESSE_ID = v.ADRESSE_ID
				   ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  			return false;
  		}
		else{
			$d = mysql_fetch_array($res);	
			return $d["NACHNAME"];
		}
		
} 
/**
 * author:coster
 * date: 19.9.05
 * liefert die e-mail-adresse eines vermieters
 * */
function getVermieterEmail($vermieter_id){
	
	global $link;
	
	//unterkunft-email aus datenbank auslesen:
		$d = "";	
		$query = "select 
					a.EMAIL 
					from 
					REZ_GEN_ADRESSE a, REZ_GEN_VERMIETER v
					where 
					v.VERMIETER_ID = '$vermieter_id'
					and
					v.ADRESSE_ID = a.ADRESSE_ID
				   ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  			return false;
  		}
		else{		
			$d = mysql_fetch_array($res);	
			return $d["EMAIL"];
		}
		
} 
/**
 * author: coster
 * date: 19.9.05
 * liefert die strasse eines vermieters
 */
function getVermieterStrasse($vermieter_id){
	global $link;
		$query = "select 
					a.STRASSE 
					from 
					REZ_GEN_ADRESSE a, REZ_GEN_VERMIETER v
					where 
					v.VERMIETER_ID = '$vermieter_id'
					and
					v.ADRESSE_ID = a.ADRESSE_ID
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  			return false;
  		}
		else{
			$d = mysql_fetch_array($res);	
			return $d["STRASSE"];
		}
} 
/**
 * author: coster
 * date: 19.9.05
 * liefert die plz eines vermieters
 */
function getVermieterPlz($vermieter_id){
	global $link;
		$query = "select 
					a.PLZ 
					from 
					REZ_GEN_ADRESSE a, REZ_GEN_VERMIETER v 
					where 
					VERMIETER_ID = '$vermieter_id'
					and
					a.ADRESSE_ID = v.ADRESSE_ID
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  			return false;
  		}
		else{
			$d = mysql_fetch_array($res);	
			return $d["PLZ"];
		}
				
} 
/**
 * author: coster
 * date: 19.9.05
 * liefert den wohnort eines vermieters
 * */
function getVermieterOrt($vermieter_id){
	global $link;
	
		$query = "select 
					a.ORT 
					from 
					REZ_GEN_ADRESSE a, REZ_GEN_VERMIETER v 
					where 
					VERMIETER_ID = '$vermieter_id'
					and
					a.ADRESSE_ID = v.ADRESSE_ID
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  			return false;
  		}
		else{
			$d = mysql_fetch_array($res);	
			return $d["ORT"];
		}
				
} 
/**
 * author: coster
 * date: 19.9.05
 * liefert das land des vermieters
 * */
function getVermieterLand($vermieter_id){
	global $link;
		$query = "select 
					a.LAND 
					from 
					REZ_GEN_ADRESSE a, REZ_GEN_VERMIETER v 
					where 
					VERMIETER_ID = '$vermieter_id'
					and
					a.ADRESSE_ID = v.ADRESSE_ID
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  			return false;
  		}
		else{
			$d = mysql_fetch_array($res);	
			return $d["LAND"];
		}
				
} 
/**
 * author: coster
 * date: 19.9.05
 * liefert die telefonnummer des vermieters
 * */
function getVermieterTel($vermieter_id){
	
	global $link;
	
		$query = "select 
					a.TELEFON 
					from 
					REZ_GEN_ADRESSE a, REZ_GEN_VERMIETER v 
					where 
					VERMIETER_ID = '$vermieter_id'
					and
					a.ADRESSE_ID = v.ADRESSE_ID
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  			return false;
  		}
  		else{		
			$d = mysql_fetch_array($res);	
			return $d["TELEFON"];
  		}
				
} 
/**
 * author: coster
 * date: 19.9.05
 * liefert die 2. telefonnummer des vermieters
 * */
function getVermieterTel2($vermieter_id){
	global $link;
		$query = "select 
					a.TELEFON2
					from
					REZ_GEN_ADRESSE a, REZ_GEN_VERMIETER v 
					where 
					VERMIETER_ID = '$vermieter_id'
					and
					a.ADRESSE_ID = v.ADRESSE_ID
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  			return false;
  		}
		else{		
			$d = mysql_fetch_array($res);
			return $d["TELEFON2"];
		}
} 
/**
 * author: coster
 * date: 19.9.05
 * liefert die faxnummer des vermieters
 * */
function getVermieterFax($vermieter_id){
	global $link;
		$query = "select 
					a.FAX 
					from 
					REZ_GEN_ADRESSE a, REZ_GEN_VERMIETER v 
					where 
					VERMIETER_ID = '$vermieter_id'
					and
					a.ADRESSE_ID = v.ADRESSE_ID
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  			return false;
  		}
		else{
			$d = mysql_fetch_array($res);	
			return $d["FAX"];
		}
				
} 
/**
 * author: coster
 * date: 20.9.05
 * liefert die homepage des vermieters
 * */
function getVermieterUrl($vermieter_id){
	global $link;
		$query = "select 
					a.URL
					from 
					REZ_GEN_ADRESSE a, REZ_GEN_VERMIETER v 
					where 
					VERMIETER_ID = '$vermieter_id'
					and
					a.ADRESSE_ID = v.ADRESSE_ID
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  			return false;
  		}
		else{
			$d = mysql_fetch_array($res);	
			return $d["URL"];
		}
				
} 
/**
 * author:coster
 * date: 22.9.05
 * liefert die adress-id eines vermieters,
 * wenn noch keine vorhanden wird false zurückgegeben.
 * */
 function getAdressIDfromVermieter($vermieter_id){
 		global $link;
		$query = "select
					a.ADRESSE_ID
					from 
					REZ_GEN_VERMIETER v, REZ_GEN_ADRESSE a
					where 
					v.VERMIETER_ID = '$vermieter_id'
					and
					v.ADRESSE_ID = a.ADRESSE_ID
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  			return false;
  		}
  		else{
  			$d = mysql_fetch_array($res);
  			$id = $d["ADRESSE_ID"];
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
function setAnzahlMietobjekte($vermieter_id,$anzahlMO){
		global $link;
		$query = "UPDATE 
					REZ_GEN_VERMIETER 
					SET 
					ANZAHL_MIETOBJEKTE = '$anzahlMO' 
					where 
					VERMIETER_ID = '$vermieter_id'
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
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
function setAnzahlBenutzer($vermieter_id,$anzahlBenutzer){
		global $link;
		$query = "UPDATE 
					REZ_GEN_VERMIETER 
					SET 
					ANZAHL_BENUTZER = '$anzahlBenutzer' 
					where 
					VERMIETER_ID = '$vermieter_id'
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
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
function setVermieterVorname($vermieter_id,$vname){
	global $link;
	
	$adress_id = getAdressIDfromVermieter($vermieter_id);
	
	if ($adress_id == false){
		$query = "insert into 
					REZ_GEN_ADRESSE
					SET 
					VORNAME = '$vname'
				  ";
	}
	else{
		$query = "update 
					REZ_GEN_ADRESSE
					SET 
					VORNAME = '$vname'
					where 
					ADRESSE_ID = '$adress_id'
				  ";
	}
	
	$res = mysql_query($query, $link);
	if (!$res){
		echo("Anfrage $query scheitert.");
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
function setVermieterNachname($vermieter_id,$nname){
	global $link;
	
		$adress_id = getAdressIDfromVermieter($vermieter_id);
	
	if ($adress_id == false){
		$query = "insert into 
					REZ_GEN_ADRESSE
					SET 
					NACHNAME = '$nname'
				  ";
	}
	else{
		$query = "update 
					REZ_GEN_ADRESSE
					SET 
					NACHNAME = '$nname'
					where 
					ADRESSE_ID = '$adress_id'
				  ";
	}
	
  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
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
function setVermieterFirmenname($vermieter_id,$fname){
	global $link;
	
			$adress_id = getAdressIDfromVermieter($vermieter_id);
	
	if ($adress_id == false){
		$query = "insert into 
					REZ_GEN_ADRESSE
					SET 
					FIRMA = '$fname'
				  ";
	}
	else{
		$query = "update 
					REZ_GEN_ADRESSE
					SET 
					FIRMA = '$fname'
					where 
					ADRESSE_ID = '$adress_id'
				  ";
	}

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
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
function setVermieterEmail($vermieter_id,$email){
	global $link;
	
	$adress_id = getAdressIDfromVermieter($vermieter_id);
	
	if ($adress_id == false){
		$query = "insert into 
					REZ_GEN_ADRESSE
					SET 
					EMAIL = '$email'
				  ";
	}
	else{
		$query = "update 
					REZ_GEN_ADRESSE
					SET 
					EMAIL = '$email'
					where 
					ADRESSE_ID = '$adress_id'
				  ";
	}
	
  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
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
function setVermieterStrasse($vermieter_id,$strasse){
	global $link;
	$adress_id = getAdressIDfromVermieter($vermieter_id);

	if ($adress_id == false){
		$query = "insert into 
					REZ_GEN_ADRESSE
					SET 
					STRASSE = '$strasse'
				  ";
	}
	else{
		$query = "update 
					REZ_GEN_ADRESSE
					SET 
					STRASSE = '$strasse'
					where 
					ADRESSE_ID = '$adress_id'
				  ";
	}
	
  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
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
function setVermieterPlz($vermieter_id,$plz){
	global $link;

	$adress_id = getAdressIDfromVermieter($vermieter_id);
	if ($adress_id == false){
		$query = "insert into 
					REZ_GEN_ADRESSE
					SET 
					PLZ = '$plz'
				  ";
	}
	else{
		$query = "update 
					REZ_GEN_ADRESSE
					SET 
					PLZ = '$plz'
					where 
					ADRESSE_ID = '$adress_id'
				  ";
	}

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  			return false;
  		}
  		else{
  			return true;
  		}
				
} 

function setVermieterOrt($vermieter_id,$ort){
	global $link;
	
	$adress_id = getAdressIDfromVermieter($vermieter_id);
	if ($adress_id == false){
		$query = "insert into 
					REZ_GEN_ADRESSE
					SET 
					ORT = '$ort'
				  ";
	}
	else{
		$query = "update 
					REZ_GEN_ADRESSE
					SET 
					ORT = '$ort'
					where 
					ADRESSE_ID = '$adress_id'
				  ";
	}

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
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
function setVermieterLand($vermieter_id,$land){
	global $link;
	
	$adress_id = getAdressIDfromVermieter($vermieter_id);
	if ($adress_id == false){
		$query = "insert into 
					REZ_GEN_ADRESSE
					SET 
					LAND = '$land'
				  ";
	}
	else{
		$query = "update 
					REZ_GEN_ADRESSE
					SET 
					LAND = '$land'
					where 
					ADRESSE_ID = '$adress_id'
				  ";
	}
	
  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
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
function setVermieterTel($vermieter_id,$tel){
	global $link;
	
	$adress_id = getAdressIDfromVermieter($vermieter_id);
	if ($adress_id == false){
		$query = "insert into 
					REZ_GEN_ADRESSE
					SET 
					TELEFON = '$tel'
				  ";
	}
	else{
		$query = "update 
					REZ_GEN_ADRESSE
					SET 
					TELEFON = '$tel'
					where 
					ADRESSE_ID = '$adress_id'
				  ";
	}
	
  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
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
function setVermieterTel2($vermieter_id,$tel2){
	global $link;
	
	$adress_id = getAdressIDfromVermieter($vermieter_id);
	if ($adress_id == false){
		$query = "insert into 
					REZ_GEN_ADRESSE
					SET 
					TELEFON2 = '$tel2'
				  ";
	}
	else{
		$query = "update 
					REZ_GEN_ADRESSE
					SET 
					TELEFON2 = '$tel2'
					where 
					ADRESSE_ID = '$adress_id'
				  ";
	}
	
  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
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
function setVermieterFax($vermieter_id,$fax){
	global $link;
	
	$adress_id = getAdressIDfromVermieter($vermieter_id);
	if ($adress_id == false){
		$query = "insert into 
					REZ_GEN_ADRESSE
					SET 
					FAX = '$fax'
				  ";
	}
	else{
		$query = "update 
					REZ_GEN_ADRESSE
					SET 
					FAX = '$fax'
					where 
					ADRESSE_ID = '$adress_id'
				  ";
	}

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
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
function setVermieterUrl($vermieter_id,$url){
	global $link;
	
	$adress_id = getAdressIDfromVermieter($vermieter_id);
	if ($adress_id == false){
		$query = "insert into 
					REZ_GEN_ADRESSE
					SET 
					URL = '$url'
				  ";
	}
	else{
		$query = "update 
					REZ_GEN_ADRESSE
					SET 
					URL = '$url'
					where 
					ADRESSE_ID = '$adress_id'
				  ";
	}
	
  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
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
function setMietobjekt_EZ($vermieter_id,$mietobjekt){
		global $link;
		$query = "UPDATE 
					REZ_GEN_VERMIETER 
					SET 
					MIETOBJEKT_EZ = '$mietobjekt' 
					where 
					VERMIETER_ID = '$vermieter_id'
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  			echo(mysql_error($link));
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
 * z. b. Tennisplätze
 * */
function setMietobjekt_MZ($vermieter_id,$mietobjekt){
		global $link;
		$query = "UPDATE 
					REZ_GEN_VERMIETER 
					SET 
					MIETOBJEKT_MZ = '$mietobjekt' 
					where 
					VERMIETER_ID = '$vermieter_id'
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  			echo(mysql_error($link));
  			return false;
  		}
  		else{
  			return true;
  		}
  		
}

?>