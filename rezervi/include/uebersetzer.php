<?php 

/*
Autor: Christian Osterrieder utilo.eu
Projekt: Rezervi
methoden zum uebersetzen eines deutschen texten in andere sprachen:
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 

/**
liefert die Bezeichnung einer Sprache aufgrund der 
sprachen id. z. b. auf "de" = "deutsch"
*/
function getBezeichnungOfSpracheID($spracheID,$link){
			
			$query = "select 
			  Bezeichnung
			  from
			  Rezervi_Sprachen_Neu
			  where
			  Sprache_ID = '$spracheID'
			 ";

  		$res = mysqli_query($link, $query);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  			echo(mysqli_error($link));
  		}
		else{		
			$d = mysqli_fetch_array($res);
			return $d["Bezeichnung"];
		}
}

/**
liefert alle sprachen die fuer den belegungsplan
zur verfuegung stehen. d.h. aktiv = 2 oder 3 sind
*/
function getSprachenForBelegungsplan($link){
		
		$query = "select 
			  *
			  from
			  Rezervi_Sprachen_Neu
			  where
			  Aktiv = 2 
			  OR 
			  Aktiv = 3
			 ";

  		$res = mysqli_query($link, $query);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
		else		
			return $res;
}

/**
liefert alle sprachen die fuer das webinterface
zur verfuegung stehen. d.h. aktiv = 1 oder 3 sind
*/
function getSprachenForWebinterface($link){
		
		$query = "select 
			  *
			  from
			  Rezervi_Sprachen_Neu
			  where
			  Aktiv = 1 
			  OR 
			  Aktiv = 3
			 ";

  		$res = mysqli_query($link, $query);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
		else		
			return $res;
}

/**
gibt eine uebersetzung aufgrund einer id und einer
sprache_id zurueck
*/
function getUebersetzungWithPKID($id,$sprache,$link){
	
			$query = "select 
				  Text
				  from
				  Rezervi_Uebersetzungen
				  where
				  Sprache_ID = '$sprache'
				  AND 
				  Standardsprache_ID = '$id'
				 ";
		    

  		$res = mysqli_query($link, $query);
  		if (!$res){
  			return "";
  		}
		else{					
			$d = mysqli_fetch_array($res);
			return htmlentities($d["Text"]);
		}
}

function getUebersetzung($text,$sprache,$link){
	
		//wenn text leer gleich leeren string zurueckgeben:
	if ($text == ""){
		return "";
	}
	else if ($sprache == "de"){
		return ($text);
	}
	
		$query = "select 
				  PK_ID
				  from
				  Rezervi_Uebersetzungen
				  where
				  Text = '$text'
				  AND 
				  Sprache_ID = $sprache
				 ";

  		$res = mysqli_query($link, $query);
  		if (!$res){
  			return htmlentities($text);
  		}
		else{	
				
			$d = mysqli_fetch_array($res);
			$id = $d["PK_ID"];
			if ($id == "" || $id == -1){
				return htmlentities($text);
			}
			else{
				return getUebersetzungWithPKID($id,$sprache,$link);
			}
		}	

}

function getPKIDfromUebersetzungUnterkunft($text,$unterkunft_id,$link){
		
		$query = "select 
		  Standardsprache_ID
		  from
		  Rezervi_Uebersetzungen
		  where
		  Text = '$text'
		  AND 
		  FK_Unterkunft_ID = '$unterkunft_id'
		  AND
		  Standardsprache_ID != -1
		 ";
		
//		echo($query."<br/>");
  		$res = mysqli_query($link, $query);
  		if (!$res){
  			return -1;
  		}
		else{					
			$d = mysqli_fetch_array($res);
			$id = $d["Standardsprache_ID"];
			if ($id == ""){
						$query = "select 
							  PK_ID
							  from
							  Rezervi_Uebersetzungen
							  where
							  Text = '$text'
							  AND 
							  FK_Unterkunft_ID = '$unterkunft_id'
							  AND
							  Standardsprache_ID = -1
							 ";
							 
					   $res = mysqli_query($link, $query);
			     		if (!$res){
				  			return -1;
				  		}
						else{
							$d = mysqli_fetch_array($res);
							$id = $d["PK_ID"];
							if ($id == ""){
								return -1;
							}
							else{
								return $id;
							}
						}
			}
			else{
//				echo("id=".$id."<br/>");
				return $id;
			}
		}
}

function insertNewUebersetzungUnterkunft($sprache,$standardsprache,$unterkunft_id,$text,$link){
	$query = "
		INSERT INTO 
		Rezervi_Uebersetzungen
		(Sprache_ID,Standardsprache_ID,FK_Unterkunft_id,Text)
		VALUES
		('$sprache','$standardsprache','$unterkunft_id','$text')
		";
  		$res = mysqli_query($link, $query);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  			echo(mysqli_error($link));
			return -1;
		}
		else{
			return mysqli_insert_id($link);
		}
}

function changeUebersetzungUnterkunft($pk_Id,$text,$sprache,$link){
	
	//ändern des textes in der datenbank:
	$query = "UPDATE 
			Rezervi_Uebersetzungen 
			SET 
			Text = '$text',
			Sprache_id = '$sprache'
			where 
			(
			  PK_ID = '$pk_Id'
			)
		  ";
//	echo($query."<br/>");
  		$res = mysqli_query($link, $query);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  			echo(mysqli_error($link));
			return -1;
		}
		else{
			return $pk_Id;
		}

}

function getPKIDWithStandardsprachenID($standardsprachen_id,$sprache,$link){

		$query = "select 
				  PK_ID
				  from
				  Rezervi_Uebersetzungen
				  where
				  Standardsprache_ID = '$standardsprachen_id'
				  AND 
				  Sprache_ID = '$sprache'
				 ";
		
  		$res = mysqli_query($link, $query);
  		if (!$res){
  			return -1;
  		}
		else{					
			$d = mysqli_fetch_array($res);
			$id = $d["PK_ID"];
			if ($id == ""){
				return -1;
			}
			else{
				return $id;
			}
		}

}

function setUebersetzungUnterkunft($text,$text_standard,$sprache,$sprache_standard,$unterkunft_id,$link){
	
	if ($text == ""){
		return -1;
	}
	
//	echo("text=".$text." textstand=".$text_standard);
	
	//1. wenn text = text_standard ist:
	//es soll eine standardsprache eingetragen werden
	//d. h. mit standardspracheID = -1
	//pk_id von holen:
	if ($text == $text_standard){
		$pk_id = getPKIDfromUebersetzungUnterkunft($text,$unterkunft_id,$link);
		if ($pk_id == -1){
			
			//1.1 noch kein eintrag vorhanden
			//es wird ein neuer standardeintrag angelegt:
//			echo("1.1"."<br/>");
			$pk_id = insertNewUebersetzungUnterkunft($sprache,-1,$unterkunft_id,$text,$link);
		}
		else{
			
			//1.2 es ist bereits ein eintrag vorhanden
			//dieser eintrag soll korregiert werden:
			$standardsprachen_id = $pk_id;
//			echo("1.2"."<br/>");
			$pk_id = getPKIDWithStandardsprachenID($standardsprachen_id,$sprache,$link);
			if ($pk_id == -1){
//				echo("1.2.1"."<br/>");
				//1.2.1 es existiert noch kein eintrag:
				$pk_id = insertNewUebersetzungUnterkunft($sprache,$standardsprachen_id,$unterkunft_id,$text,$link);
			}
			else{
//				echo("1.2.2"."<br/>");
				//1.2.2 existierenden eintrag updaten:
				$pk_id = changeUebersetzungUnterkunft($pk_id,$text,$sprache,$link);
			}
		}
	}
	else{
	//2. es soll eine standard-sprache entweder neu 
	//angelegt werden oder eine id einer standardsprache für einen
	//neuen eintrag verwendet werden oder mit dieser verändert werden#
		$pk_id = getPKIDfromUebersetzungUnterkunft($text_standard,$unterkunft_id,$link);
		if ($pk_id == -1){
//			echo("2.1"."<br/>");
			//2.1 es existiert noch kein eintrag mit dem 
			//standard-text --> es muss ein neuer standard-text
			//angelegt werden und dann mit dieser neuen id
			//ein text angelgt werden:
			$pk_id = insertNewUebersetzungUnterkunft($sprache_standard,-1,$unterkunft_id,$text_standard,$link);
			$pk_id = insertNewUebersetzungUnterkunft($sprache,$pk_id,$unterkunft_id,$text,$link);
		
		}
		else{
//			echo("2.2"."<br/>");
			//2.2 es existiert bereits ein eintrag mit
			//dem standard-text --> dieser gehört jetzt 
			//entweder upgedated oder neu eingetragen wenn noch keiner
			//vorhanden:
			$standardsprachen_id = $pk_id;
			$pk_id = getPKIDWithStandardsprachenID($standardsprachen_id,$sprache,$link);
			if ($pk_id == -1){
//				echo("2.2.1"."<br/>");
				//2.2.1 es existiert noch kein eintrag:
				$pk_id = insertNewUebersetzungUnterkunft($sprache,$standardsprachen_id,$unterkunft_id,$text,$link);
			}
			else{
				//2.2.2 existierenden eintrag updaten:
//				echo("2.2.2"."<br/>"."change_id=".$pk_id);
				$pk_id = changeUebersetzungUnterkunft($pk_id,$text,$sprache,$link);
			}
		}
	}
	return $pk_id;
}

/**
	liefert die uebersetzung fuer
	eine gewisse unterkunft und eine bestimmte sprache
*/
function getUebersetzungUnterkunft($text,$sprache,$unterkunft_id,$link){

		if ($text == ""){
			return $text;
		}		
					
		$id = getPKIDfromUebersetzungUnterkunft($text,$unterkunft_id,$link);
		
		if ($id == -1){
			return $text;
		}
		
		$query = "select 
				  Text
				  from
				  Rezervi_Uebersetzungen
				  where
				  (
					Standardsprache_ID = '$id'
				  )
				  AND
				  (FK_Unterkunft_ID = '$unterkunft_id')
				  AND
				  (Sprache_ID = '$sprache')
				 ";

  		$res = mysqli_query($link, $query);
//  		echo($query."<br/>");
  		if (!$res){
  			return htmlentities($text);
  		}
		else{		
			$d = mysqli_fetch_array($res);
			$te = $d["Text"];
			if ($te == ""){
				$query = "select 
				  Text
				  from
				  Rezervi_Uebersetzungen
				  where
				  (
					PK_ID = '$id'
				  )
				  AND
				  (FK_Unterkunft_ID = '$unterkunft_id')
				  AND
				  (Sprache_ID = '$sprache')
				 ";

  				$res = mysqli_query($link, $query);
  				if (!$res){
  					return htmlentities($text);
  				}
  				else{
  					$d = mysqli_fetch_array($res);
					$te = $d["Text"];
					if ($te == ""){
						return htmlentities($text);
					}
					else{
						return htmlentities($te);
					}
  				}
			}
			else{
				return htmlentities($te);
			}
		}	

}

?>