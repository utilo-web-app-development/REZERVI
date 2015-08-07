<?php

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 

/*
 * funktionen für preise von zimmern 
 * 
 * */
 
define("STANDARDWAEHRUNG","Euro");

/**
 * speichert einen neuen preis
 */
function setPrice($zimmer_id,$valid_from,$valid_to,$price,$waehrung,$standard,$link){
	
	if ($standard == true || $standard == "true"){
		$standard = 0;
	}
	else{
		$standard = 1;
	}
	
	//eintragen in db
	$query = "
		INSERT INTO 
		Rezervi_Preise
		(GUELTIG_VON,GUELTIG_BIS,PREIS,WAEHRUNG,STANDARD)
		VALUES
		('$valid_from','$valid_to','$price','$waehrung','$standard')
		";

  	$res = mysql_query($query, $link);
	
  	if (!$res) {
  		echo("Anfrage $query scheitert.");
  		echo(mysql_error($link));
		return false;
	}
	else{
		$preis_id = mysql_insert_id($link);
		foreach ($zimmer_id as $zi_id){
			$query = "
			INSERT INTO 
			Rezervi_Zimmer_Preise
			(FK_ZIMMER_ID,FK_PREISE_ID)
			VALUES
			('$zi_id','$preis_id')
			";
			
			$res = mysql_query($query, $link);
		  	if (!$res) {
		  		echo("Anfrage $query scheitert.");
		  		echo(mysql_error($link));
				return false;
			}
		}	
	}
	return $preis_id;

} //ende preis eintragen
/**
 * aendert einen preis
 */
 function changePrice($preis_id,$zimmer_id,$valid_from,$valid_to,$price,$waehrung,$standard,$link){
	
	if ($standard == true || $standard == "true"){
		$standard = 0;
	}
	else{
		$standard = 1;
	}
	
	//eintragen in db
	$query = "
		REPLACE INTO 
		Rezervi_Preise
		(PK_ID,GUELTIG_VON,GUELTIG_BIS,PREIS,WAEHRUNG,STANDARD)
		VALUES
		('$preis_id','$valid_from','$valid_to','$price','$waehrung','$standard')
		";

  	$res = mysql_query($query, $link);
	
  	if (!$res) {
  		echo("Anfrage $query scheitert.");
  		echo(mysql_error($link));
		return false;
	}
	else{
	
		//entferne alle alten einträge:
		$query = "
			DELETE FROM
			Rezervi_Zimmer_Preise
			where
			FK_PREISE_ID = '$preis_id'
			";
			
			$res = mysql_query($query, $link);
		  	if (!$res) {
		  		echo("Anfrage $query scheitert.");
		  		echo(mysql_error($link));
				return false;
			}

			foreach ($zimmer_id as $zi_id){
				$query = "
				INSERT INTO 
				Rezervi_Zimmer_Preise
				(FK_ZIMMER_ID,FK_PREISE_ID)
				VALUES
				('$zi_id','$preis_id')
				";
				
				$res = mysql_query($query, $link);
			  	if (!$res) {
			  		echo("Anfrage $query scheitert.");
			  		echo(mysql_error($link));
					return false;
				}
			}	
	}
	return $preis_id;

} //ende preis ändern
/**
 * liefert alle preise als result set zurück
 */
function getPrices($unterkunft_id,$link){

		$query = "select distinct
				  p.*
				  from
				  Rezervi_Zimmer z, Rezervi_Zimmer_Preise zp, Rezervi_Preise p
				  where
				  z.FK_Unterkunft_ID = '$unterkunft_id' 
				  and " .
				  		" z.PK_ID = zp.FK_ZIMMER_ID " .
				  		" and" .
				  		" zp.FK_PREISE_ID = p.PK_ID" .
				  		" and" .
				  		" p.Standard = 1" .
				  		" GROUP BY" .
				  		" p.PK_ID" .
				  		" ORDER BY " .
				  		" p.gueltig_von
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
	  		echo("Anfrage $query scheitert.");
	  		echo(mysql_error($link));
			return false;
  		}
	
	return $res;
			
} //ende getPrices
/**
 * liefert alle standardpreise
 */
 function getStandardPrices($unterkunft_id,$link){

		$query = "select distinct
				  p.*
				  from
				  Rezervi_Zimmer z, Rezervi_Zimmer_Preise zp, Rezervi_Preise p
				  where
				  z.FK_Unterkunft_ID = '$unterkunft_id' 
				  and " .
				  		" z.PK_ID = zp.FK_ZIMMER_ID " .
				  		" and" .
				  		" zp.FK_PREISE_ID = p.PK_ID" .
				  		" and" .
				  		" p.Standard = 0" .
				  		" GROUP BY" .
				  		" p.PK_ID" .
				  		" ORDER BY " .
				  		" p.gueltig_von
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
	  		echo("Anfrage $query scheitert.");
	  		echo(mysql_error($link));
			return false;
  		}
	
	return $res;
			
} //ende getStandardPrices
/**
 * liefert den Standardpreis für ein Zimmer falls dieser
 * eingegeben wurde <br/>
 * Achtung es wird der 1. Preis zurückgegeben der gefunden wird
 */
 function getStandardPrice($zimmer_id,$link){

		$query = "select distinct
				  p.PREIS
				  from
				  Rezervi_Zimmer_Preise zp, Rezervi_Preise p
				  where
				  zp.FK_Zimmer_ID = '$zimmer_id' 
				  and " .
				  		" zp.FK_PREISE_ID = p.PK_ID" .
				  		" and" .
				  		" p.Standard = 0
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
	  		echo("Anfrage $query scheitert.");
	  		echo(mysql_error($link));
			return false;
  		}
  		
  		$d = mysql_fetch_array($res);
  		if (!empty($d["PREIS"])){
  			return $d["PREIS"];
  		}  		
	
	return 0;
			
} //ende getStandardPrices
/**
 * liefert die zimmer zu einem preis
 */
 function getZimmerForPrice($preis_id){
 	
 	global $link;
 	
 			$query = "select distinct
				  z.*
				  from
				  Rezervi_Zimmer z, Rezervi_Zimmer_Preise zp, Rezervi_Preise p
				  where
				  p.PK_ID = '$preis_id' 
				  and " .
				  		" z.PK_ID = zp.FK_ZIMMER_ID " .
				  		" and" .
				  		" zp.FK_PREISE_ID = p.PK_ID" .
				  		" ORDER BY " .
				  		" z.Zimmernr
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
	  		echo("Anfrage $query scheitert.");
	  		echo(mysql_error($link));
			return false;
  		}
	
	return $res;
 	
 }

/**
 * löscht einen preis aus der datenbank
 */
function deletePreis($preis_id){
		
		global $link;
		
		$query = "delete
				  from
				  Rezervi_Zimmer_Preise
				  where
				  FK_Preise_ID = '$preis_id' 
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
	  		echo("Anfrage $query scheitert.");
	  		echo(mysql_error($link));
			return false;
  		}
  		
		$query = "delete
		  from
		  Rezervi_Preise
		  where
		  PK_ID = '$preis_id' 
		 ";
  		$res = mysql_query($query, $link);
  		if (!$res){
	  		echo("Anfrage $query scheitert.");
	  		echo(mysql_error($link));
			return false;
  		}
  		return true;
}
/**
 * liefert den preis der zu einem bestimmten datum gültig ist <br/>
 * es wird der erste gefundene preis zurückgeliefert.
 */
function getPriceOfDate($zimmer_id,$vonTag,$vonMonat,$vonJahr,$bisTag,$bisMonat,$bisJahr,$link){
	
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
				p.Preis
				from 
				Rezervi_Preise p, Rezervi_Zimmer_Preise zp
				where 		
				zp.FK_Zimmer_ID = '$zimmer_id' and" .
						" zp.FK_Preise_ID = p.PK_ID and" .
						" p.Standard = 1 and
			   (('$vonDatum' >= gueltig_von and '$bisDatum' <= gueltig_bis) 
			   OR
				('$vonDatum' < gueltig_bis and '$bisDatum' <= gueltig_bis and '$bisDatum' > gueltig_von) 
				OR	
			    ('$vonDatum' >= gueltig_von and '$bisDatum' > gueltig_bis and '$vonDatum' < gueltig_bis)
				OR	
			    ('$vonDatum' <= gueltig_von and '$bisDatum' >= gueltig_bis))				
				";

  		$res = mysql_query($query, $link);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
		else		
			$d = mysql_fetch_array($res);
	
	if (!empty($d["Preis"])){
		return $d["Preis"];
	}
	
   return 0;

} 

/**
 * berechnet einen preis eines zimmers über einen bestimmten zeitraum
 */
function calculatePrice($zimmer_id,$from,$to){
	
	global $link;
	global $root;
	
	include_once($root."/include/datumFunctions.php");
	$gesamtpreis = 0;
	$tagVon = getTagFromSQLDate($from);
	$monatVon = getMonatFromSQLDate($from);
	$jahrVon = getJahrFromSQLDate($from);
	$tagBis = getTagFromSQLDate($to);
	$monatBis = getMonatFromSQLDate($to);
	$jahrBis = getJahrFromSQLDate($to);
	
	$anzahlTage = numberOfDays($monatVon,$tagVon,$jahrVon,$monatBis,$tagBis,$jahrBis);

	//durchlaufe jeden einzelnen tag und lese den preis dazu aus:
	for ($i = 1; $i <= $anzahlTage; $i++){
		
		//$date erzeugen:
		//wieviel tage hat der derzeitige monat?
		$anzahlTageDesMonats = getNumberOfDays($monatVon,$jahrVon);
		if (($tagVon+1) < $anzahlTageDesMonats){
			$tagVon++;
		}
		else{
			$tagVon=1;
			$monatVon++;
		}
		if($monatVon >= 12){
			$monatVon = 1;
			$jahrVon++;
		} 
		$preis = 0;
		$preis = getPriceOfDate($zimmer_id,$tagVon,$monatVon,$jahrVon,$tagBis,$monatBis,$jahrBis,$link);
		
		if (empty($preis) || $preis == 0){
			$preis = getStandardPrice($zimmer_id,$link);
		}
		
		$gesamtpreis += $preis;
		
	}
	return $gesamtpreis;
}
/**
 * calculates the price of a reservertion
 */
 function calculatePriceOfReservation($reservation_id){
 	global $root;
 	global $link;
 	include_once($root."/include/reservierungFunctions.inc.php");
 	$datumVon = getDatumVon($reservation_id,$link);
 	$datumBis = getDatumBis($reservation_id,$link);
 	$zimmer_id= getZimmerID($reservation_id,$link);
 	$preis = calculatePrice($zimmer_id,$datumVon,$datumBis);
 	return $preis;
 }
 
?>
