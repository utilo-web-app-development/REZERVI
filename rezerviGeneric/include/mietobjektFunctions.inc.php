<?php
/**
 * author:coster
 * date: 10.9.05
 * liefert einen wert aus den eigenschaften
 * als bezeichnung konstante verwenden
 * */
function getMietobjektEigenschaftenWert($bezeichnung,$mietobjekt_id){
			
			global $link;			
	
			$query = ("SELECT 
					   WERT
					   FROM
					   REZ_GEN_MIE_EIGENSCHAFTEN
					   WHERE
					   BEZEICHNUNG = '$bezeichnung'
					   AND
					   MIETOBJEKT_ID = '$mietobjekt_id'
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
function setMietobjektEigenschaftenWert($bezeichnung,$wert,$mietobjekt_id){
	
	global $link;
	
	if (getMietobjektEigenschaftenWert($bezeichnung,$mietobjekt_id) == false){
		$query = ("INSERT INTO 
		   REZ_GEN_MIE_EIGENSCHAFTEN
		   (BEZEICHNUNG,MIETOBJEKT_ID,WERT)
		   VALUES
		   ('$bezeichnung','$mietobjekt_id','$wert')
		  ");     
	}
	else{
		$query = ("UPDATE 
		   REZ_GEN_MIE_EIGENSCHAFTEN
		   SET
		   WERT = '$wert'
		   where
		   MIETOBJEKT_ID = '$mietobjekt_id'
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
 * author:coster
 * date: 24.9.05
 * löscht ein mietobjekt
 * */
function deleteMietobjekt($mietobjekt_id){
	
	global $link;
	
	//einstellungen zum mo löschen:
	$query = ("DELETE FROM 
				REZ_GEN_MIE_EIGENSCHAFTEN
				where
				MIETOBJEKT_ID = '$mietobjekt_id'
		   ");           

	$res = mysql_query($query, $link);
	
	if (!$res) { 
		echo("die Anfrage $query scheitert"); 
		return false;
	}
	
	//reservierungen löschen:
	$query = ("DELETE FROM 
				REZ_GEN_RESERVIERUNG
				where
				MIETOBJEKT_ID = '$mietobjekt_id'
		   ");           

	$res = mysql_query($query, $link);
	
	if (!$res) { 
		echo("die Anfrage $query scheitert"); 
		return false;
	}
	
	//bilder löschen:
	global $root;
	include_once($root."/include/bildFunctions.inc.php");
	include_once($root."/include/filesAndFolders.inc.php");
	$res = getBilderOfMietobjekt($mietobjekt_id);
	while ($d=mysql_fetch_array($res)){
		rmFile($root."/".$d["PFAD"]);
	}
	deleteBilderOfMietobjekt($mietobjekt_id);
	
	//mietobjekt selbst löschen
	$query = ("DELETE FROM 
				REZ_GEN_MIETOBJEKT
				where
				MIETOBJEKT_ID = '$mietobjekt_id'
		   ");           

	$res = mysql_query($query, $link);
	
	if (!$res) { 
		echo("die Anfrage $query scheitert"); 
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
function updateMietobjekt($mietobjekt_id,$bezeichnung,$beschreibung,$preis,$url){
	global $link;
	$query = ("UPDATE 
				REZ_GEN_MIETOBJEKT
				SET
          		BEZEICHNUNG = '$bezeichnung',	
		   		BESCHREIBUNG = '$beschreibung',
				PREIS = '$preis',
				LINK = '$url'
				where
				MIETOBJEKT_ID = '$mietobjekt_id'
		   ");           

	$res = mysql_query($query, $link);
	
	if (!$res) { 
		echo("die Anfrage $query scheitert"); 
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
function setMietobjekt($vermieter_id,$bezeichnung,$beschreibung,$preis,$url){
	global $link;
	//eintragen in db
	$query = "
		INSERT INTO 
		REZ_GEN_MIETOBJEKT
		(VERMIETER_ID,BEZEICHNUNG,BESCHREIBUNG,PREIS,LINK)
		VALUES
		('$vermieter_id','$bezeichnung','$beschreibung','$preis','$url')
		";

  	$res = mysql_query($query, $link);
	
  	if (!$res) {
  		echo("Anfrage $query scheitert.");
  		echo(mysql_error($link));
		return false;
	}
	else{
		return mysql_insert_id($link);
	}

} 
/**
 * author:coster
 * date: 24.9.05
 * liefert die anzahl der angelegten mietobjekte eines vermieters
 * */
function getAnzahlVorhandeneMietobjekte($vermieter_id){
	
	global $link;
	
		$query = "select 
				  count(MIETOBJEKT_ID) as anzahl
				  from
				  REZ_GEN_MIETOBJEKT
				  where
				  VERMIETER_ID = '$vermieter_id'
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo(mysql_error($link));
  			return false;
  		}
		else{	
			$d = mysql_fetch_array($res);
			return $d["anzahl"];			
		}			
} 
/**
 * author:coster
 * date:24.9.05
 * liefert alle mietobjekte eines vermieters
 * @param $vermieter_id
 * @return mysql result set
 * */
function getMietobjekte($vermieter_id){
		global $link;
		$query = "select 
				  *
				  from
				  REZ_GEN_MIETOBJEKT
				  where
				  VERMIETER_ID = '$vermieter_id'
				  ORDER BY
				  BEZEICHNUNG
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo(mysql_error($link));
  			return false;
  		}
		else{		
			return $res;
		}	
			
} 
/**
 * author:coster
 * date:24.9.05
 * liefert das erste mietobjekte sortiert nach der bezeichnung
 * */
function getFirstMietobjektId($vermieter_id){
		global $link;
		$query = "select 
				  MIETOBJEKT_ID
				  from
				  REZ_GEN_MIETOBJEKT
				  where
				  VERMIETER_ID = '$vermieter_id'
				  ORDER BY
				  BEZEICHNUNG
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo(mysql_error($link));
  			return false;
  		}
		else{		
			$row = mysql_fetch_row($res);
			return $row[0];			
		}	
			
} 
/**
 * author: coster
 * date: 20.10.05
 * liefert alle mietobjekte eines vermieters
 * 
 * */
function getMietobjekteOfVermieter($vermieter_id){
		global $link;
		$query = "select 
					*
					from 
					REZ_GEN_MIETOBJEKT
					where 
					VERMIETER_ID = '$vermieter_id'
					order by
					BEZEICHNUNG
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
 * author:coster
 * date: 26.9.05
 * liefert die bezeichnung eines mietobjektes
 * */
function getMietobjektBezeichnung($mietobjekt_id){
	global $link;

		$query = "select 
				  BEZEICHNUNG
				  from
				  REZ_GEN_MIETOBJEKT
				  where
				  MIETOBJEKT_ID = '$mietobjekt_id' 
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
			return false;
		}
		else{		
			$d = mysql_fetch_array($res);			
			return $d["BEZEICHNUNG"];
		}
			
}
/**
 * author:coster
 * date: 26.9.05
 * liefert die beschreibung eines mietobjektes
 * */
function getMietobjektBeschreibung($mietobjekt_id){
	global $link;

		$query = "select 
				  BESCHREIBUNG
				  from
				  REZ_GEN_MIETOBJEKT
				  where
				  MIETOBJEKT_ID = '$mietobjekt_id' 
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
			return false;
		}
		else{		
			$d = mysql_fetch_array($res);			
			return $d["BESCHREIBUNG"];
		}
			
}
/**
 * author:coster
 * date:26.9.05
 * liefert den link zu weiteren informationen des mietobjektes
 * */
function getMietobjektLink($mietobjekt_id){	
		global $link;
		$query = "SELECT
				  LINK
				  FROM
				  REZ_GEN_MIETOBJEKT
				  where
				  MIETOBJEKT_ID = '$mietobjekt_id' 
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
			return false;
		}
		else{		
			$d = mysql_fetch_array($res);			
			return $d["LINK"];
		}	
			
}
/**
 * author:coster
 * date:26.9.05
 * liefert den preis des mietobjektes
 * */
function getMietobjektPreis($mietobjekt_id){	
		global $link;
		$query = "SELECT
				  PREIS
				  FROM
				  REZ_GEN_MIETOBJEKT
				  where
				  MIETOBJEKT_ID = '$mietobjekt_id' 
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
			return false;
		}
		else{		
			$d = mysql_fetch_array($res);			
			return $d["PREIS"];
		}	
			
}

?>
