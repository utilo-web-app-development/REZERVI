<?php
/**
Markers of special pictures:
* */
define("SYMBOL_TABLE_FREE","tischIstFrei"); //symbol for free table
define("SYMBOL_TABLE_OCCUPIED","tischIstBelegt"); //symbol for occupied table

/**
 * author:coster
 * date: 26.9.05
 * liefert ein bild eines raumes
 * */
function getBildOfRaum($mietobjekt_id){
		global $db;
		
		$query = "SELECT
					BILDER_ID
					FROM 
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
			return $res->fields["BILDER_ID"];
		}	
}

/**
 * author:li haitao
 * date: 17.12.2007
 * liefert ein bild eines tisches
 * */
function getBildOfTisch($tisch_id){
		global $db;
		
		$query = "SELECT
					BILDER_ID
					FROM 
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
			return $res->fields["BILDER_ID"];
		}	
}

/**
 * author:coster
 * date: 26.9.05
 * loescht alle bilder eines mietobjektes von der Datenbank
 * die bilder werden nicht vom filesystem entfernt
 * */
function deleteBilderOfMietobjekt($mietobjekt_id){
		global $db;
		$query = "DELETE
					FROM 
				  	BOOKLINE_BILDER
					where
					MIETOBJEKT_ID = '$mietobjekt_id'
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
 * date: 4.Okt 2005
liefet die anzahl der hochgeladenen bilder eines Vermieters
*/
function getAnzahlBilderOfRaum($gastro_id){
		global $db;
		$query = "SELECT DISTINCT
					count(m.BILDER_ID) as anzahl
					FROM 
				  	BOOKLINE_RAUM m
					where
					m.GASTRO_ID = '$gastro_id'
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

/**�
 * author: coster
   date: 4.10.2005
   liefert alle bilder eines vermieters mit limit und index
*/
function getAllPicturesFromVermieterWithLimit($gastro_id,$limit,$index){
		global $db;
		$query = "SELECT
					b.*, m.*
					FROM 
				  	BOOKLINE_BILDER b, BOOKLINE_MIETOBJEKT m
					where
					m.GASTRO_ID = '$gastro_id'
					AND
					m.MIETOBJEKT_ID = b.MIETOBJEKT_ID
	  				ORDER BY
					m.BEZEICHNUNG
					LIMIT
					$index,$limit
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
 * 	author: coster
	date: 4. Okt. 2005
	speichert ein bild und dessen pfad im upload directory
*/
function setBild($pfad,$beschreibung,$widht,$height,$mimeType,$marker="null"){
	
			global $db;	
			global $gastro_id;
			if (empty($db) || empty($gastro_id)){
				die ("globale Variable fehlt in setBild()");			
			}
			
			$blob = addslashes(fread(fopen($pfad, "r"), filesize($pfad)));

			$query = "INSERT INTO 
					  BOOKLINE_BILDER
					  (BILD,BESCHREIBUNG,WIDTH,HEIGHT,MIME,MARKER,GASTRO_ID)
					  VALUES
					  ('$blob','$beschreibung','$widht','$height','$mimeType','$marker','$gastro_id')				  
					 ";		

  		$res = $db->Execute($query);
  		
  		if (!$res){
  			print $db->ErrorMsg();
  			return false;
  		}
		else{		
			return $db->Insert_ID();
		}	
			
} 
/**
 * 	author: coster
	date: 3.April 2006
	liest alle daten eines bildes
*/
function getBildWithMarker($marker){
		
		global $db;	
		global $gastro_id;
		if (empty($db) || empty($gastro_id)){
			die("Globale Variable fehlt.");
		}
		
		$query = "SELECT
				  BILDER_ID
				  FROM
				  BOOKLINE_BILDER
				  WHERE
				  MARKER = '$marker'
			      and
				  GASTRO_ID = '$gastro_id'
				 ";

  		$res = $db->Execute($query);
  		
  		if (!$res){
  			print $db->ErrorMsg();
  			return false;
  		}
		else{	
			return $res->fields["BILDER_ID"];
		}	

}
/**
 * 	author: coster
	date: 3.April 2006
	liest alle daten eines bildes
*/
function getBild($bilder_id){
		
		global $db;	
		
		$query = "SELECT
				  *
				  FROM
				  BOOKLINE_BILDER
				  WHERE
				  BILDER_ID = '$bilder_id'
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
	author: coster
	date: 4. okt. 2005
	l�scht ein bild aus der Datenbank
	Bild wird aber nicht von Festplatte gel�scht!
*/
function deleteBild($id){	
	
	global $db;

	$query = "DELETE FROM
			  BOOKLINE_BILDER
			  WHERE
			  BILDER_ID = '$id'			  
			 ";		

  		$res = $db->Execute($query);
  		
  		if (!$res){
  			print $db->ErrorMsg();
  			die("<br/>".$query);
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
	
		global $db;
		
		$query = "SELECT
				  BESCHREIBUNG
				  FROM
				  BOOKLINE_BILDER
				  WHERE
				  BILDER_ID = '$bilder_id'
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
	liest die Breite eines Bildes
	author: coster
	date: 4. Okt. 2005
*/
function getBildBreite($bilder_id){
		
		global $db;
				
		$query = "SELECT
				  WIDTH
				  FROM
				  BOOKLINE_BILDER
				  WHERE
				  BILDER_ID = '$bilder_id'
				 ";

  		$res = $db->Execute($query);
  		
  		if (!$res){
  			print $db->ErrorMsg();
  			return false;
  		}
		else{	
			return $res->fields["WIDTH"];
		}	

}
/**
	liest die H�he eines Bildes
	author: coster
	date: 4. Okt. 2005
*/
function getBildHoehe($bilder_id){
	
	    global $db;
		
		$query = "SELECT
				  HEIGHT
				  FROM
				  BOOKLINE_BILDER
				  WHERE
				  BILDER_ID = '$bilder_id'
				 ";

  		$res = $db->Execute($query);
  		
  		if (!$res){
  			print $db->ErrorMsg();
  			return false;
  		}
		else{	
			return $res->fields["HEIGHT"];
		}	

}
/**
 * 	author: coster
	date: 4. Okt. 2005
	liest alle Bilder IDs eines Zimmers

*/
function getBilderOfZimmer($mietobjekt_id){
	
		global $db;
			    
		$query = "SELECT
				  *
				  FROM
				  BOOKLINE_BILDER
				  WHERE
				  MIETOBJEKT_ID = '$mietobjekt_id'
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
 * 	author: coster
	date: 28. Okt. 2005
	prueft ob ein mietobjekt ein bild hat
*/
function hasMietobjektBilder($mietobjekt_id){
		global $db;		
		$query = "SELECT
				  count(MIETOBJEKT_ID) as anzahl
				  FROM
				  BOOKLINE_BILDER
				  WHERE
				  MIETOBJEKT_ID = '$mietobjekt_id'
				 ";

  		$res = $db->Execute($query);
  		
  		if (!$res){
  			print $db->ErrorMsg();
  			return false;
  		}
		else{	
			$anzahl = $res->fields["anzahl"];
			if ($anzahl > 0){
				return true;
			}	
			else{
				return false;
			}			 
		}	
	
}
?>
