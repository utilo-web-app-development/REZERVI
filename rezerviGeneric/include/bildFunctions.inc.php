<?php
/**
 * author:coster
 * date: 26.9.05
 * liefert alle bilder eines mietobjektes
 * */
function getBilderOfMietobjekt($mietobjekt_id){
		global $link;
		$query = "SELECT
					*
					FROM 
				  	REZ_GEN_BILDER
					where
					MIETOBJEKT_ID = '$mietobjekt_id'
					 ";		

  		$res = mysql_query($query, $link);
  		
  		if (!$res){
  			echo(mysql_error($link));
  			echo("Anfrage $query scheitert.");
  			return false;
  		}
		else{		
			return $res;
		}	
}
/**
 * author:coster
 * date: 26.9.05
 * löscht alle bilder eines mietobjektes von der Datenbank
 * die bilder werden nicht vom filesystem entfernt
 * */
function deleteBilderOfMietobjekt($mietobjekt_id){
		global $link;
		$query = "DELETE
					FROM 
				  	REZ_GEN_BILDER
					where
					MIETOBJEKT_ID = '$mietobjekt_id'
					 ";		

  		$res = mysql_query($query, $link);
  		
  		if (!$res){
  			echo(mysql_error($link));
  			echo("Anfrage $query scheitert.");
  			return false;
  		}
		else{		
			return true;
		}	
}
/**
 * author: coster
 * date: 4.Okt 2005
liefet die anzahl der hochgeladenen bilder eines Vermieters
*/
function getAnzahlBilderOfVermieter($vermieter_id){
		global $link;
		$query = "SELECT
					count(b.BILDER_ID) as anzahl
					FROM 
				  	REZ_GEN_BILDER b, REZ_GEN_MIETOBJEKT m
					where
					m.VERMIETER_ID = '$vermieter_id'
					AND
					m.MIETOBJEKT_ID = b.MIETOBJEKT_ID
					group by
					b.BILDER_ID
					 ";		

  		$res = mysql_query($query, $link);
  		
  		if (!$res){
  			echo(mysql_error($link));
  			echo("Anfrage $query scheitert.");
  			return false;
  		}
		else{		
			$d = mysql_fetch_array($res);
			return $d["anzahl"];
		}	

}

/**´
 * author: coster
   date: 4.10.2005
   liefert alle bilder eines vermieters mit limit und index
*/
function getAllPicturesFromVermieterWithLimit($vermieter_id,$limit,$index){
		global $link;
		$query = "SELECT
					b.*, m.*
					FROM 
				  	REZ_GEN_BILDER b, REZ_GEN_MIETOBJEKT m
					where
					m.VERMIETER_ID = '$vermieter_id'
					AND
					m.MIETOBJEKT_ID = b.MIETOBJEKT_ID
	  				ORDER BY
					m.BEZEICHNUNG
					LIMIT
					$index,$limit
					 ";		

  		$res = mysql_query($query, $link);
  		
  		if (!$res){
  			echo(mysql_error($link));
  			echo("Anfrage $query scheitert.");
  			return false;
  		}
		else{		
			return $res;
		}	
	
}
/**
 * 	author: coster
	date: 4. Okt. 2005
	speichert ein bild und dessen pfad im upload directory
*/
function setBild($pfad,$beschreibung,$mietobjekt_id,$widht,$height,$mimeType){
	
			global $link;	
			$blob = addslashes(fread(fopen($pfad, "r"), filesize($pfad)));

			$query = "INSERT INTO 
					  REZ_GEN_BILDER
					  (MIETOBJEKT_ID,BILD,BESCHREIBUNG,WIDTH,HEIGHT,MIME)
					  VALUES
					  ('$mietobjekt_id','$blob','$beschreibung','$widht','$height','$mimeType')				  
					 ";		

  		$res = mysql_query($query, $link);
  		
  		if (!$res){
  			echo(mysql_error($link));
  			echo("Anfrage $query scheitert.");
  			return false;
  		}
		else{		
			return mysql_insert_id($link);
		}	
			
}  
/**
 * 	author: coster
	date: 3.April 2006
	liest alle daten eines bildes
*/
function getBild($bilder_id){
		
		global $link;	
		
		$query = "SELECT
				  *
				  FROM
				  REZ_GEN_BILDER
				  WHERE
				  BILDER_ID = '$bilder_id'
				 ";

  		$res = mysql_query($query, $link);
  		
  		if (!$res){
  			echo(mysql_error($link));
  			echo("Anfrage $query scheitert.");
  			return false;
  		}
		else{	
			$d = mysql_fetch_array($res);	
			return $d;
		}	

}
/**
	author: coster
	date: 4. okt. 2005
	löscht ein bild aus der Datenbank
	Bild wird aber nicht von Festplatte gelöscht!
*/
function deleteBild($id){	
	
	global $link;
		
	$query = "DELETE FROM
			  REZ_GEN_BILDER
			  WHERE
			  BILDER_ID = '$id'			  
			 ";		

  		$res = mysql_query($query, $link);
  		
  		if (!$res){
  			echo(mysql_error($link));
  			echo("Anfrage $query scheitert.");
  			return false;
  		}
		else{		
			return true;
		}	
			
}
/**
 * 	author: coster
	date: 4. Okt. 2005
	liest die Beschreibung eines Bildes
*/
function getBildBeschreibung($bilder_id){
	
		global $link;
		
		$query = "SELECT
				  BESCHREIBUNG
				  FROM
				  REZ_GEN_BILDER
				  WHERE
				  BILDER_ID = '$bilder_id'
				 ";

  		$res = mysql_query($query, $link);
  		
  		if (!$res){
  			echo(mysql_error($link));
  			echo("Anfrage $query scheitert.");
  			return false;
  		}
		else{	
			$d = mysql_fetch_array($res);	
			return $d["BESCHREIBUNG"];
		}	

}
/**
	liest die Breite eines Bildes
	author: coster
	date: 4. Okt. 2005
*/
function getBildBreite($bilder_id){
		
		global $link;
				
		$query = "SELECT
				  WIDTH
				  FROM
				  REZ_GEN_BILDER
				  WHERE
				  BILDER_ID = '$bilder_id'
				 ";

  		$res = mysql_query($query, $link);
  		
  		if (!$res){
  			echo(mysql_error($link));
  			echo("Anfrage $query scheitert.");
  			return false;
  		}
		else{	
			$d = mysql_fetch_array($res);	
			return $d["WIDTH"];
		}	

}
/**
	liest die Höhe eines Bildes
	author: coster
	date: 4. Okt. 2005
*/
function getBildHoehe($bilder_id){
	
	    global $link;
		
		$query = "SELECT
				  HEIGHT
				  FROM
				  REZ_GEN_BILDER
				  WHERE
				  BILDER_ID = '$bilder_id'
				 ";

  		$res = mysql_query($query, $link);
  		
  		if (!$res){
  			echo(mysql_error($link));
  			echo("Anfrage $query scheitert.");
  			return false;
  		}
		else{	
			$d = mysql_fetch_array($res);	
			return $d["HEIGHT"];
		}	

}
/**
 * 	author: coster
	date: 4. Okt. 2005
	liest alle Bilder IDs eines Zimmers

*/
function getBilderOfZimmer($mietobjekt_id){
	
		global $link;
			    
		$query = "SELECT
				  *
				  FROM
				  REZ_GEN_BILDER
				  WHERE
				  MIETOBJEKT_ID = '$mietobjekt_id'
				 ";

  		$res = mysql_query($query, $link);
  		
  		if (!$res){
  			echo(mysql_error($link));
  			echo("Anfrage $query scheitert.");
  			return false;
  		}
		else{	
			return $res;				 
		}	

}
/**
 * 	author: coster
	date: 28. Okt. 2005
	prueft ob ein mietobjekt ein bild hat
*/
function hasMietobjektBilder($mietobjekt_id){
		global $link;		
		$query = "SELECT
				  count(MIETOBJEKT_ID) as anzahl
				  FROM
				  REZ_GEN_BILDER
				  WHERE
				  MIETOBJEKT_ID = '$mietobjekt_id'
				 ";

  		$res = mysql_query($query, $link);
  		
  		if (!$res){
  			echo(mysql_error($link));
  			echo("Anfrage $query scheitert.");
  			return false;
  		}
		else{	
			$d=mysql_fetch_array($res);
			$anzahl = $d["anzahl"];
			if ($anzahl > 0){
				return true;
			}	
			else{
				return false;
			}			 
		}	
	
}
?>
