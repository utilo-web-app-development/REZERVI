<?php

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 

/**
liefet die anzahl der hochgeladenen bilder einer unterkunft
*/
function getAnzahlBilder($unterkunft_id,$link){

		$query = "SELECT
					count(b.PK_ID) as anzahl
					FROM 
				  	Rezervi_Bilder b, Rezervi_Zimmer z
					where
					z.FK_Unterkunft_ID = '$unterkunft_id'
					AND
					z.PK_ID = b.FK_Zimmer_ID
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

/**
liefert alle bilder einer unterkunft mit limit und index
author: coster
date: 28.8.2005
*/
function getAllPicturesFromUnterkunftWithLimit($unterkunft_id,$limit,$index,$link){
		
		$query = "SELECT
					b.PK_ID,b.Pfad,b.Beschreibung,b.Width,b.Height, z.Zimmernr
					FROM 
				  	Rezervi_Bilder b, Rezervi_Zimmer z
					where
					z.FK_Unterkunft_ID = '$unterkunft_id'
					AND
					z.PK_ID = b.FK_Zimmer_ID
	  				ORDER BY
					z.Zimmernr
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
	setzt ein bild
	author: coster
	date: 4. aug. 2005
*/
function setBild($pfad,$beschreibung,$zimmer_id,$widht,$height,$link){	

			$query = "INSERT INTO 
					  Rezervi_Bilder
					  (FK_Zimmer_ID,Pfad,Beschreibung,Width,Height)
					  VALUES
					  ('$zimmer_id','$pfad','$beschreibung','$widht','$height')				  
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
	liest den Pfad eines Bildes
	author: coster
	date: 4. aug. 2005
*/
function getBildPfad($bilder_id,$link){
		
		$query = "SELECT
				  Pfad
				  FROM
				  Rezervi_Bilder
				  WHERE
				  PK_ID = '$bilder_id'
				 ";

  		$res = mysql_query($query, $link);
  		
  		if (!$res){
  			echo(mysql_error($link));
  			echo("Anfrage $query scheitert.");
  			return false;
  		}
		else{	
			$d = mysql_fetch_array($res);	
			return $d["Pfad"];
		}	

}
/**
	löscht ein bild
	Bild wird aber nicht von Festplatte gelöscht!
	author: coster
	date: 4. aug. 2005
*/
function deleteBild($id,$link){	
		
	$query = "DELETE FROM
			  Rezervi_Bilder
			  WHERE
			  PK_ID = '$id'			  
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
	liest die Beschreibung eines Bildes
	author: coster
	date: 4. aug. 2005
*/
function getBildBeschreibung($bilder_id,$link){
		
		$query = "SELECT
				  Beschreibung
				  FROM
				  Rezervi_Bilder
				  WHERE
				  PK_ID = '$bilder_id'
				 ";

  		$res = mysql_query($query, $link);
  		
  		if (!$res){
  			echo(mysql_error($link));
  			echo("Anfrage $query scheitert.");
  			return false;
  		}
		else{	
			$d = mysql_fetch_array($res);	
			return $d["Beschreibung"];
		}	

}
/**
	liest die Breite eines Bildes
	author: coster
	date: 4. aug. 2005
*/
function getBildBreite($bilder_id,$link){
		
		$query = "SELECT
				  Width
				  FROM
				  Rezervi_Bilder
				  WHERE
				  PK_ID = '$bilder_id'
				 ";

  		$res = mysql_query($query, $link);
  		
  		if (!$res){
  			echo(mysql_error($link));
  			echo("Anfrage $query scheitert.");
  			return false;
  		}
		else{	
			$d = mysql_fetch_array($res);	
			return $d["Width"];
		}	

}
/**
	liest die Höhe eines Bildes
	author: coster
	date: 4. aug. 2005
*/
function getBildHoehe($bilder_id,$link){
		
		$query = "SELECT
				  Height
				  FROM
				  Rezervi_Bilder
				  WHERE
				  PK_ID = '$bilder_id'
				 ";

  		$res = mysql_query($query, $link);
  		
  		if (!$res){
  			echo(mysql_error($link));
  			echo("Anfrage $query scheitert.");
  			return false;
  		}
		else{	
			$d = mysql_fetch_array($res);	
			return $d["Height"];
		}	

}
/**
	liest alle Bilder IDs eines Zimmers
	author: coster
	date: 4. aug. 2005
*/
function getBilderOfZimmer($zimmer_id,$link){
		
		$query = "SELECT
				  *
				  FROM
				  Rezervi_Bilder
				  WHERE
				  FK_Zimmer_ID = '$zimmer_id'
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
	prueft ob ein zimmer ein bild hat
	author: coster
	date: 28. aug. 2005
*/
function hasZimmerBilder($zimmer_id,$link){
		
		$query = "SELECT
				  count(PK_ID) as anzahl
				  FROM
				  Rezervi_Bilder
				  WHERE
				  FK_Zimmer_ID = '$zimmer_id'
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
		}	
	return false;
}
?>
