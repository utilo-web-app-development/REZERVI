<?php

/**
 * @author: coster
 * Ändert die position eines tisches im raum
 */
 function updateTischPos($top,$left,$tisch_id){
 	global $db;
	
	$query = ("UPDATE
				BOOKLINE_TISCH
				SET	
				LEFT_POS = '$left',
				TOP_POS  = '$top'
				where
				TISCHNUMMER = '$tisch_id' 
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
 * date:1.2.07
 * liefert den ersten tisch sortiert nach der TISCHNUMMER
 * */
function getFirstTischId($raum_id){
		global $db;
		$query = "select 
				  TISCHNUMMER
				  from
				  BOOKLINE_TISCH
				  where
				  RAUM_ID = '$raum_id'
				  ORDER BY
				  TISCHNUMMER
				 ";

  		$res = $db->Execute($query);
  		if (!$res){
  			print $db->ErrorMsg();
  			return false;
  		}
		else{			
			return $res->fields["TISCHNUMMER"];	
		}	
			
} 

/**
 * author:coster
 * date: 10.9.05
 * liefert einen wert aus den eigenschaften
 * als bezeichnung konstante verwenden
 * */
function getMietobjektEigenschaftenWert($bezeichnung,$mietobjekt_id){
			
			global $db;			
	
			$query = ("SELECT 
					   WERT
					   FROM
					   BOOKLINE_MIE_EIGENSCHAFTEN
					   WHERE
					   BEZEICHNUNG = '$bezeichnung'
					   AND
					   MIETOBJEKT_ID = '$mietobjekt_id'
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
function setMietobjektEigenschaftenWert($bezeichnung,$wert,$mietobjekt_id){
	
	global $db;
	
	if (getMietobjektEigenschaftenWert($bezeichnung,$mietobjekt_id) == false){
		$query = ("INSERT INTO 
		   BOOKLINE_MIE_EIGENSCHAFTEN
		   (BEZEICHNUNG,MIETOBJEKT_ID,WERT)
		   VALUES
		   ('$bezeichnung','$mietobjekt_id','$wert')
		  ");     
	}
	else{
		$query = ("UPDATE 
		   BOOKLINE_MIE_EIGENSCHAFTEN
		   SET
		   WERT = '$wert'
		   where
		   MIETOBJEKT_ID = '$mietobjekt_id'
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
 * @author: coster
 * date: 29.9.06
 * löscht einen tisch
 */
function deleteTisch($tisch_id){
	
		global $db;

		$query = ("DELETE FROM 
					BOOKLINE_RESERVIERUNG
					where
					TISCH_ID = '$tisch_id'
			   ");           
	
		$res = $db->Execute($query);
		
		$bilder_id = getBilderIdOfTisch($tisch_id);
		$query = ("DELETE FROM 
					BOOKLINE_BILDER
					where
					BILDER_ID = '$bilder_id'
			   ");           
	
		$res = $db->Execute($query);
		
		if (!$res) { 
			print $db->ErrorMsg(); 
			return false;
		}
		
		$query = ("DELETE FROM 
			BOOKLINE_TISCH
			where
			TISCHNUMMER = '$tisch_id'
	    ");           
	
		$res = $db->Execute($query);
		
		if (!$res) { 
			print $db->ErrorMsg(); 
			return false;
		}
		
}
/**
 * author:coster
 * date: 29.9.06
 * löscht einen raum
 * */
function deleteRaum($mietobjekt_id){
	
	global $db;
	
	$res = getTische($mietobjekt_id);
	while ($d=$res->FetchNextObject()){
		$id = $d->TISCH_ID;
	}
	
	//mietobjekt selbst löschen
	$query = ("DELETE FROM 
				BOOKLINE_RAUM
				where
				RAUM_ID = '$mietobjekt_id'
		   ");           

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
 * author:coster
 * date: 24.9.05
 * aendert ein mietobjekt
 * */
function updateRaum($mietobjekt_id,$bezeichnung,$beschreibung,$bild_id){
	global $db;
	$query = ("UPDATE 
				BOOKLINE_RAUM
				SET
          		BEZEICHNUNG = '$bezeichnung',	
		   		BESCHREIBUNG = '$beschreibung',
		   		BILDER_ID = '$bild_id'
				where
				RAUM_ID = '$mietobjekt_id'
		   ");           

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
 * löscht einen tisch mit einer bestimmten tischnummer und speichert ihn neu
 * 
 */
function updateTisch($tischnummer_alt,$tischnummer_neu,$beschreibung,
		$minimaleBelegung,$maximaleBelegung,$status, $bilder_id){
	global $db;
	$query = ("UPDATE 
				BOOKLINE_TISCH
				SET
          		TISCHNUMMER = '$tischnummer_neu',
          		BESCHREIBUNG = '$beschreibung',	
		   		MINIMALE_BELEGUNG = '$minimaleBelegung',
		   		MAXIMALE_BELEGUNG = '$maximaleBelegung',
		   		BILDER_ID = '$bilder_id',
				STATUS = '$status'
				where
				TISCHNUMMER = '$tischnummer_alt'
		   ");           

	$res = $db->Execute($query);
	
	if (!$res) { 
		print $db->ErrorMsg(); 
		return false;
	}
	
	if($tischnummer_alt != $tischnummer_neu){
		$query = ("UPDATE 
					BOOKLINE_RESERVIERUNG
					SET
          			TISCH_ID = '$tischnummer_neu'
					where
					TISCH_ID = '$tischnummer_alt'
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
 * aendert die groesse eines tisches
 * @author: coster
 */
function updateTischSize($width,$height,$tisch_id){
	global $db;
	$query = ("UPDATE 
				BOOKLINE_TISCH
				SET
          		WIDTH = '$width',	
		   		HEIGHT = '$height'
				where
				TISCHNUMMER = '$tisch_id'
		   ");           

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
 * author:coster
 * date: 24.9.05
 * speichert ein Mietobjekt
 * */
function setRaum($gastro_id,$bezeichnung,$beschreibung,$bild_id){
	global $db;
	//eintragen in db
	$query = "
		INSERT INTO 
		BOOKLINE_RAUM
		(GASTRO_ID,BEZEICHNUNG,BESCHREIBUNG,BILDER_ID)
		VALUES
		('$gastro_id','$bezeichnung','$beschreibung','$bild_id')
		";

  	$res = $db->Execute($query);
	
  	if (!$res) {
  		print $db->ErrorMsg();
  		die("<br/>".$query);
	}
	else{
		return $db->Insert_ID();
	}

} 
/**
 * author:coster
 * date: 24.9.05
 * speichert ein Mietobjekt
 * */
function setTisch($raum_id,$bezeichnung,$beschreibung,$minimaleBelegung,$maximaleBelegung,$status, $bilder_id, $gruppenname){
	global $db;
	//eintragen in db
	$query = "
		INSERT INTO 
		BOOKLINE_TISCH
		(RAUM_ID,TISCHNUMMER,BESCHREIBUNG,MINIMALE_BELEGUNG,MAXIMALE_BELEGUNG,STATUS, BILDER_ID, GRUPPENBEZEICHNUNG)
		VALUES
		('$raum_id','$bezeichnung','$beschreibung','$minimaleBelegung','$maximaleBelegung','$status', '$bilder_id', '$gruppenname')
		";

  	$res = $db->Execute($query);
	
  	if (!$res) {
  		print $db->ErrorMsg();
		return false;
	}
	else{
		return $db->Insert_ID();
	}

} 
/**
 * author:coster
 * date: 24.9.05
 * liefert die anzahl der angelegten mietobjekte eines vermieters
 * */
function getAnzahlVorhandeneRaeume($gastro_id){
	
	global $db;
	
		$query = "select 
				  count(RAUM_ID) as anzahl
				  from
				  BOOKLINE_RAUM
				  where
				  GASTRO_ID = '$gastro_id'
				 ";

  		$res = $db->Execute($query);
  		if ($res){	
			return $res->fields["anzahl"];		
		}	
		return 0;		
} 
/**
 * @author:coster
 * date: 25.6.07
 * liefert die ID des Gastronomiebetriebes eines Raums
 * */
function getGastroOfRaum($raum_id){
	
	global $db;
		$query = "select 
				  GASTRO_ID
				  from
				  BOOKLINE_RAUM
				  where
				  RAUM_ID = '$raum_id'
				 ";

  		$res = $db->Execute($query);
  		if (!$res){
  			print $db->ErrorMsg();
  			return false;
  		}
		else{		
			return $res->fields["GASTRO_ID"];		
		}			
}
/**
 * author:coster
 * date: 24.9.05
 * liefert die anzahl der angelegten tische eines vermieters
 * @return die anzahl der tische 
 * */
function getAnzahlVorhandeneTische($gastro_id){
	
	global $db;
	
		$query = "select 
				  count(t.TISCHNUMMER) as anzahl
				  from
				  BOOKLINE_TISCH t, BOOKLINE_RAUM r
				  where
				  r.GASTRO_ID = '$gastro_id'" .
				  		" and r.RAUM_ID = t.RAUM_ID
				 ";

  		$res = $db->Execute($query);
  		if (!$res){
  			print $db->ErrorMsg();
  			return false;
  		}
		else{		
			return $res->fields["anzahl"];			
		}			
} 
/**
 * author: coster
 * liefert die position links des tisches im raum
 */
function getLeftPosOfTisch($tisch_id){
		
	global $db;
	
		$query = "select 
				  left_pos
				  from
				  BOOKLINE_TISCH
				  where
				  TISCHNUMMER = '$tisch_id'";

  		$res = $db->Execute($query);
  		if (!$res){
  			print $db->ErrorMsg();
  			echo($query);
  			exit;
  			return false;
  		}
		else{		
			return $res->fields["left_pos"];			
		}	
}
/**
 * author: coster
 * liefert die Breite eines tisches
 */
function getWidthOfTisch($tisch_id){
		
	global $db;
	
		$query = "select 
				  WIDTH
				  from
				  BOOKLINE_TISCH
				  where
				  TISCHNUMMER = '$tisch_id'";

  		$res = $db->Execute($query);
  		if (!$res){
  			print $db->ErrorMsg();
  			echo($query);
  			exit;
  			return false;
  		}
		else{		
			return $res->fields["WIDTH"];			
		}	
}
/**
 * author: coster
 * liefert die höhe eines tisches
 */
function getHeightOfTisch($tisch_id){
		
	global $db;
	
		$query = "select 
				  HEIGHT
				  from
				  BOOKLINE_TISCH
				  where
				  TISCHNUMMER = '$tisch_id'";

  		$res = $db->Execute($query);
  		if (!$res){
  			print $db->ErrorMsg();
  			echo($query);
  			exit;
  			return false;
  		}
		else{		
			return $res->fields["HEIGHT"];			
		}	
}
/**
 * author: coster
 * liefert die position top des tisches im raum
 */
function getTopPosOfTisch($tisch_id){
		
	global $db;
	
	$query = "select 
			  top_pos
			  from
			  BOOKLINE_TISCH
			  where
			  TISCHNUMMER = '$tisch_id'";

  		$res = $db->Execute($query);
  		if (!$res){
  			print $db->ErrorMsg();
  			echo($query);
  			exit;

  		}
		else{		
			return $res->fields["top_pos"];			
		}	
}

function getBilderIdOfTisch($tisch_id){
		
	global $db;
	
	$query = "select 
			  bilder_id
			  from
			  BOOKLINE_TISCH
			  where
			  TISCHNUMMER = '$tisch_id'";

  		$res = $db->Execute($query);
  		if (!$res){
  			print $db->ErrorMsg();
  			echo($query);
  			exit;

  		}
		else{		
			return $res->fields["bilder_id"];			
		}	
}
/**
 * author:coster
 * date:24.9.05
 * liefert alle mietobjekte eines vermieters
 * @param $gastro_id
 * @return mysql result set
 * */
function getRaeume($gastro_id){
		global $db;
		$query = "select 
				  *
				  from
				  BOOKLINE_RAUM
				  where
				  GASTRO_ID = '$gastro_id'
				  ORDER BY
				  BEZEICHNUNG
				 ";

  		$res = $db->Execute($query);
  		if (!$res){
  			print $db->ErrorMsg();
  			return false;
  		}
		else{		
			return $res;
		}	
			
} 
/**
 * liefert die raum_id eines tisches
 * @return raum_id des tisches
 * @param tisch_id
 */
 function getRaumOfTisch($tisch_id){
 		
 		global $db;
		$query = "select 
				  RAUM_ID
				  from
				  BOOKLINE_TISCH
				  where
				  TISCHNUMMER = '$tisch_id'
				 ";

  		$res = $db->Execute($query);
  		if (!$res){
  			print $db->ErrorMsg();
  			return false;
  		}
		else{	
			$raum_id = $res->fields["RAUM_ID"];		
			return $raum_id;
		}	
 }
/**
 * author:coster
 * date:29.9.06
 * liefert alle tische eines raumes
 * @param $raum_id
 * @return mysql result set
 * */
function getTische($raum_id){
		global $db;
		$query = "select 
				  *
				  from
				  BOOKLINE_TISCH
				  where
				  RAUM_ID = '$raum_id'
				  ORDER BY
				  TISCHNUMMER
				 ";

  		$res = $db->Execute($query);
  		if (!$res){
  			print $db->ErrorMsg();
  			return false;
  		}
		else{		
			return $res;
		}	
			
} 
/**
 * author:coster
 * date:29.9.06
 * count the number of tables of a room
 * @param $raum_id the id of the room
 * @return the number of tables of a room
 * */
function countTables($raum_id){
		global $db;
		$anzahl = 0;
		$query = "select 
				  count(TISCHNUMMER) as anzahl
				  from
				  BOOKLINE_TISCH
				  where
				  RAUM_ID = '$raum_id'
				 ";

  		$res = $db->Execute($query);
  		if (!$res){
  			print $db->ErrorMsg();
  			return false;
  		}
		else{	
			$anzahl = $res->fields["anzahl"];
		}	
		return $anzahl;	
} 
/**
 * author:coster
 * date:2.10.06
 * liefert alle tische eines gastronomiebetriebes sortiert nach
 * raumbezeichnung und tischnummern
 * @param $gastro_id
 * @return mysql result set
 * */
function getAllTische($gastro_id){
		global $db;
		$query = "select 
				  t.*
				  from
				  BOOKLINE_TISCH t, BOOKLINE_RAUM r
				  where
				  r.GASTRO_ID = '$gastro_id'" .
				  		" and r.RAUM_ID = t.RAUM_ID
				  ORDER BY
				  r.BEZEICHNUNG, t.TISCHNUMMER
				 ";

  		$res = $db->Execute($query);
  		if (!$res){
  			print $db->ErrorMsg();
  			return false;
  		}
		else{		
			return $res;
		}	
			
} 
/**
 * author:coster
 * date:24.9.05
 * liefert den ersten raum sortiert nach der bezeichnung
 * */
function getFirstRaumId($gastro_id){
		global $db;
		$query = "select 
				  RAUM_ID
				  from
				  BOOKLINE_RAUM
				  where
				  GASTRO_ID = '$gastro_id'
				  ORDER BY
				  BEZEICHNUNG
				 ";

  		$res = $db->Execute($query);
  		if (!$res){
  			print $db->ErrorMsg();
  			return false;
  		}
		else{		
			return $res->fields["RAUM_ID"];		
		}	
			
} 

/**
 * author:coster
 * date: 26.9.05
 * liefert die bezeichnung eines mietobjektes
 * */
function getRaumBezeichnung($mietobjekt_id){
	
	global $db;

		$query = "select 
				  BEZEICHNUNG
				  from
				  BOOKLINE_RAUM
				  where
				  RAUM_ID = '$mietobjekt_id' 
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
/**
 * author:coster
 * date: 26.9.05
 * liefert die beschreibung eines tisches
 * */
function getTischBeschreibung($mietobjekt_id){
	
	global $db;

		$query = "select 
				  BESCHREIBUNG
				  from
				  BOOKLINE_TISCH	
				  where
				  TISCHNUMMER = '$mietobjekt_id' 
				 ";

  		$res = $db->Execute($query);
  		if (!$res){
  			print $db->ErrorMsg();
			return false;
		}
		else{		
			return $res->fields["BESCHREIBUNG"];		
		}
			
}
/**
 * liefert die minimale belegung eines tisches
 * @param $tisch_id 
 */
function getMinimaleBelegungOfTisch($tisch_id){
		global $db;
		$min = 0;
		$query = "select 
				  MINIMALE_BELEGUNG
				  from
				  BOOKLINE_TISCH	
				  where
				  TISCHNUMMER = '$tisch_id' 
				 ";

  		$res = $db->Execute($query);
  		if (!$res){
  			print $db->ErrorMsg();
			return false;
		}
		else{		
			$min = $res->fields["MINIMALE_BELEGUNG"];
			if (empty($min)){
				return 0;	
			}
		}
		return $min;
}
/**
 * liefert die maximale belegung eines tisches
 * @param $tisch_id 
 */
function getMaximaleBelegungOfTisch($tisch_id){
		global $db;
		$max = 0;
		$query = "select 
				  MAXIMALE_BELEGUNG
				  from
				  BOOKLINE_TISCH	
				  where
				  TISCHNUMMER = '$tisch_id' 
				 ";

  		$res = $db->Execute($query);
  		if (!$res){
  			print $db->ErrorMsg();
			return false;
		}
		else{		
			$max = $res->fields["MAXIMALE_BELEGUNG"];
			if (empty($max)){
				return 0;
			}
		}
		return $max;
}
/**
 * liefert die minimale belegung eines raumes
 * @param $raum_id 
 */
function getMinimaleBelegungOfRaum($raum_id){
		
		global $db;

		$query = "select 
				  MIN(MINIMALE_BELEGUNG) as anzahl
				  from
				  BOOKLINE_TISCH	
				  where
				  RAUM_ID = '$raum_id' 
				 ";

  		$res = $db->Execute($query);
  		if (!$res){
  			print $db->ErrorMsg();
			return false;
		}
		else{		
			return $res->fields["anzahl"];
		}
}
/**
 * liefert die maximale belegung eines raumes
 * @param $raum_id
 */
function getMaximaleBelegungOfRaum($raum_id){
		global $db;

		$query = "select 
				  MAX(MAXIMALE_BELEGUNG) as anzahl
				  from
				  BOOKLINE_TISCH	
				  where
				  RAUM_ID = '$raum_id' 
				 ";

  		$res = $db->Execute($query);
  		if (!$res){
  			print $db->ErrorMsg();
			return false;
		}
		else{		
			return $res->fields["anzahl"];
		}
}
/**
 * liefert den status eines tisches -> siehe Konstanten!
 * @param $tisch_id 
 */
function getStatusOfTisch($tisch_id){
		global $db;

		$query = "select 
				  STATUS
				  from
				  BOOKLINE_TISCH	
				  where
				  TISCHNUMMER = '$tisch_id' 
				 ";

  		$res = $db->Execute($query);
  		if (!$res){
  			print $db->ErrorMsg();
			return false;
		}
		else{		
			return $res->fields["STATUS"];
		}
}

/**
 * author:coster
 * date: 26.9.05
 * liefert die beschreibung eines mietobjektes
 * */
function getRaumBeschreibung($mietobjekt_id){
	global $db;

		$query = "select 
				  BESCHREIBUNG
				  from
				  BOOKLINE_RAUM
				  where
				  RAUM_ID = '$mietobjekt_id' 
				 ";

  		$res = $db->Execute($query);
  		if (!$res){
  			print $db->ErrorMsg();
			return false;
		}
		else{		
			return $res->fields["BESCHREIBUNG"];
		}
			
}
/**
 * author:coster
 * date:26.9.05
 * liefert den link zu weiteren informationen des mietobjektes
 * */
function getMietobjektLink($mietobjekt_id){	
		global $db;
		$query = "SELECT
				  LINK
				  FROM
				  BOOKLINE_MIETOBJEKT
				  where
				  MIETOBJEKT_ID = '$mietobjekt_id' 
				 ";

  		$res = $db->Execute($query);
  		if (!$res){
  			print $db->ErrorMsg();
			return false;
		}
		else{		
			return $res->fields["LINK"];
		}	
			
}
/**
 * author:coster
 * date:26.9.05
 * liefert den preis des mietobjektes
 * */
function getMietobjektPreis($mietobjekt_id){	
		global $db;
		$query = "SELECT
				  PREIS
				  FROM
				  BOOKLINE_MIETOBJEKT
				  where
				  MIETOBJEKT_ID = '$mietobjekt_id' 
				 ";

  		$res = $db->Execute($query);
  		if (!$res){
  			print $db->ErrorMsg();
			return false;
		}
		else{		
			return $res->fields["PREIS"];
		}	
			
}
/**
 * author:lihaitao
 * date:06.12.07
 * */
function isRaumVorhanden($raum_bezeichnung, $gastro_id){
	global $db;
	$query = "select 
				  RAUM_ID as anzahl
				  from
				  BOOKLINE_RAUM
				  where
				  BEZEICHNUNG = '$raum_bezeichnung' and
				  GASTRO_ID = '$gastro_id'
				 ";
	$res = $db->Execute($query);
  	if (!$res) {
  		return false;
	}else {		
		$temp = $res->fields["anzahl"];
		if ($temp > 1) {
			return true;
		}else{
			return false;
		}
	}
}
/**
 * author:lihaitao
 * date:20.12.07
 * */
function getTischGruppen($gastro_id){
	global $db;
	$query = "select 
			  *
			  from
			  BOOKLINE_TISCHGRUPPE
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
function insertTischGruppe($name, $beschreibung, $status, $gastro_id){
	global $db;
	$query = "INSERT INTO 
			  BOOKLINE_TISCHGRUPPE
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
function updateTischGruppe($gruppenname_neu, $gruppenname_alt, $beschreibung, $status, $gastro_id){
	
	global $db;
	$query = "UPDATE 
				BOOKLINE_TISCHGRUPPE
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
					BOOKLINE_TISCH
					SET
          			GRUPPENBEZEICHNUNG = '$gruppenname_neu'
					where
					GRUPPENBEZEICHNUNG = '$gruppenname_alt'
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
function deleteTischGruppe($gruppenname, $gastro_id){
	global $db;
	
	$query = ("UPDATE 
				BOOKLINE_TISCH
				SET
          		GRUPPENBEZEICHNUNG = ''
				where
				GRUPPENBEZEICHNUNG = '$gruppenname'
			  ");           
	$res = $db->Execute($query);
	if (!$res) { 
		print $db->ErrorMsg(); 
		return false;
	}
	
	$query = ("DELETE FROM 
				BOOKLINE_TISCHGRUPPE
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
function getGruppeOfTisch($tisch_id){
		global $db;

		$query = "select 
				  GRUPPENBEZEICHNUNG
				  from
				  BOOKLINE_TISCH	
				  where
				  TISCHNUMMER = '$tisch_id' 
				 ";

  		$res = $db->Execute($query);
  		if (!$res){
  			print $db->ErrorMsg();
			return false;
		}
		else{		
			return $res->fields["GRUPPENBEZEICHNUNG"];
		}
}

function getStatusOfTischGruppe($gruppenname, $gastro_id){
	global $db;
	$query = "select 
			  STATUS 
			  from
			  BOOKLINE_TISCHGRUPPE	
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

function getBeschreibungOfTischGruppe($gruppenname, $gastro_id){
	global $db;
	$query = "select 
			  BESCHREIBUNG 
			  from
			  BOOKLINE_TISCHGRUPPE	
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
