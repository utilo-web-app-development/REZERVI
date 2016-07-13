<?php

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 

/**
prueft ob mit der unterkunft_id bereits
ein Eintrag in der DB ist
*/
function hasEintrag($unterkunft_id,$link){
		
		$query = "select 
				  FK_Unterkunft_ID
				  from
				  Rezervi_Einstellungen_Neu
				  where
				  FK_Unterkunft_ID = '$unterkunft_id'
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  			return false;
  		}
		else{		
			$d = mysql_fetch_array($res);
			if ($d["FK_Unterkunft_ID"] == $unterkunft_id){
				return true;
			} 
		}
		return false;

}

/**
 * Liefert nur den Zahlenwert einer Framesize oder * falls relativ
 */
function removeUnitFromFramesize($framesize){

	if (!isset($framesize) || $framesize == "" || $framesize == -1){
		return false;
	}
	
	if ($framesize == "*"){
		return "*";
	}
	
	//% zeichen entfernen, ein px wird sowieso nicht eingetragen:	
	//mixed str_replace ( mixed search, mixed replace, mixed subject [, int &count] )
	return str_replace("%","",$framesize);	

}

/**
 * Liefert nur die Einheit einer Framesize
 */
function getUnitFromFramesize($framesize){

	if ($framesize == "*"){
		return "*";
	}
	
	//strpos --  Find position of first occurrence of a string
	//Description
	//int strpos ( string haystack, mixed needle [, int offset] )	
	// If needle is not found, strpos() will return boolean FALSE.	
	if (strpos($framesize,"%") === false){
		return "px";
	}
	else{
//		$pos = strpos($framesize,"%");
////		string substr ( string string, int start [, int length] )
//		return substr($framesize,0,$pos+1);
		return "%";
	}
}

/**
gibt die framegroesse des linken frames des
webinterfaces zurueck
*/
function getFramesizeLeftWIUnit($unterkunft_id,$link){
	
	$frame = -1;
		
		$query = "select 
				  Frame_left_WI
				  from
				  Rezervi_Einstellungen_Neu
				  where
				  FK_Unterkunft_ID = '$unterkunft_id'
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  		}
		else	{
		    $d = mysql_fetch_array($res);	
			$frame = $d["Frame_left_WI"];			
		}
	return getUnitFromFramesize($frame);	
			
} //ende 

/**
gibt die framegroesse des linken frames des
belegungsplanes zurueck
*/
function getFramesizeLeftBPUnit($unterkunft_id,$link){
	
	$frame = -1;
		
		$query = "select 
				  Frame_left_BP
				  from
				  Rezervi_Einstellungen_Neu
				  where
				  FK_Unterkunft_ID = '$unterkunft_id'
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  		}
		else{	
			$d = mysql_fetch_array($res);
			$frame = $d["Frame_left_BP"];			
		}
	return  getUnitFromFramesize($frame);	
			
} //ende

/**
gibt die framegroesse des rechten frames des
belegungsplanes zurueck
*/
function getFramesizeRightBPUnit($unterkunft_id,$link){
	
	$frame = -1;
		
		$query = "select 
				  Frame_right_BP
				  from
				  Rezervi_Einstellungen_Neu
				  where
				  FK_Unterkunft_ID = '$unterkunft_id'
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  		}
		else	{	
			$d = mysql_fetch_array($res);
			$frame = $d["Frame_right_BP"];			
		}
	return  getUnitFromFramesize($frame);	
			
} //ende

/**
gibt die framegroesse des rechten frames des
belegungsplanes zurueck
*/
function getFramesizeRightWIUnit($unterkunft_id,$link){
	
	$frame = -1;
		
		$query = "select 
				  Frame_right_WI
				  from
				  Rezervi_Einstellungen_Neu
				  where
				  FK_Unterkunft_ID = '$unterkunft_id'
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  		}
		else	{	
		    $d = mysql_fetch_array($res);
			$frame = $d["Frame_right_WI"];			
		}
	return  getUnitFromFramesize($frame);	
			
} //ende

/**
gibt die framegroesse des linken frames des
webinterfaces zurueck
*/
function getFramesizeLeftWI($unterkunft_id,$link){
	
	$frame = -1;
		
		$query = "select 
				  Frame_left_WI
				  from
				  Rezervi_Einstellungen_Neu
				  where
				  FK_Unterkunft_ID = '$unterkunft_id'
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  		}
		else	{	
			$d = mysql_fetch_array($res);
			$frame = $d["Frame_left_WI"];			
		}
	return removeUnitFromFramesize($frame);	
			
} //ende 

/**
gibt die framegroesse des linken frames des
belegungsplanes zurueck
*/
function getFramesizeLeftBP($unterkunft_id,$link){
	
	$frame = -1;
		
		$query = "select 
				  Frame_left_BP
				  from
				  Rezervi_Einstellungen_Neu
				  where
				  FK_Unterkunft_ID = '$unterkunft_id'
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  		}
		else	{	
			$d = mysql_fetch_array($res);
			$frame = $d["Frame_left_BP"];			
		}
	return  removeUnitFromFramesize($frame);	
			
} //ende

/**
gibt die framegroesse des rechten frames des
belegungsplanes zurueck
*/
function getFramesizeRightBP($unterkunft_id,$link){
	
	$frame = -1;
		
		$query = "select 
				  Frame_right_BP
				  from
				  Rezervi_Einstellungen_Neu
				  where
				  FK_Unterkunft_ID = '$unterkunft_id'
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  		}
		else	{	
			$d = mysql_fetch_array($res);
			$frame = $d["Frame_right_BP"];			
		}
	return  removeUnitFromFramesize($frame);	
			
} //ende

/**
gibt die framegroesse des rechten frames des
belegungsplanes zurueck
*/
function getFramesizeRightWI($unterkunft_id,$link){
	
	$frame = -1;
		
		$query = "select 
				  Frame_right_WI
				  from
				  Rezervi_Einstellungen_Neu
				  where
				  FK_Unterkunft_ID = '$unterkunft_id'
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  		}
		else	{	
			$d = mysql_fetch_array($res);
			$frame = $d["Frame_right_WI"];			
		}
	return  removeUnitFromFramesize($frame);	
			
} //ende

/**
gibt das sql-result mit den gespeicherten sprachen
zurück
*/
function getSprachen($unterkunft_id,$link){
	
	$sprachen_string = "";
		
		$query = "select 
				  Sprache_ID
				  from
				  Rezervi_Standard_Sprachen
				  where
				  Einstellungen_ID = '$unterkunft_id'
				  AND
				  Modul = 2
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
		else		
			return $res;
			
} //ende 

/**
gibt das sql-result mit den gespeicherten sprachen
zurück
*/
function getStandardSprachePKID($unterkunft_id,$sprache,$modul,$link){
		
		$query = "select 
				  PK_ID
				  from
				  Rezervi_Standard_Sprachen
				  where
				  Einstellungen_ID = '$unterkunft_id'
				  AND
				  Modul = '$modul'
				  AND
				  Sprache_ID = '$sprache'
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("anfrage $query scheitert!");
  			return -1;
  		}
		else{	
			$d = mysql_fetch_array($res);
			$id = $d["PK_ID"];
			if ($id == ""){
				return -1;
			}
			else{
				return $id;
			}
		}
			
} //ende 

function getStandardSprachePKID2($unterkunft_id,$modul,$link){
		
		$query = "select 
				  PK_ID
				  from
				  Rezervi_Standard_Sprachen
				  where
				  Einstellungen_ID = '$unterkunft_id'
				  AND
				  Modul = '$modul'
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("anfrage $query scheitert!");
  			return -1;
  		}
		else{	
			$d = mysql_fetch_array($res);
			$id = $d["PK_ID"];
			if ($id == ""){
				return -1;
			}
			else{
				return $id;
			}
		}
			
} //ende 


/**
speichert die sprachen 
*/
function setSprache($unterkunft_id,$sprache,$modul,$link){
	
	$schonVorhandenId =  getStandardSprachePKID($unterkunft_id,$sprache,$modul,$link);	
	
	if ($schonVorhandenId == -1){

		$query = "
			INSERT INTO
			Rezervi_Standard_Sprachen
			(Sprache_ID,Modul,Einstellungen_ID)
			VALUES
			('$sprache','$modul','$unterkunft_id')
			";	
	
  	$res = mysql_query($query, $link);
		
	  	if (!$res) {
	  		echo("Anfrage $query scheitert.");
			return false;
		}
		else{
			return true;
		}
	}

} 

/**
prueft ob eine uebergebene sprache mit sprache_id angezeigt werden soll
*/
function isSpracheShown($unterkunft_id,$spracheID,$link){
	
	$id = getStandardSprachePKID($unterkunft_id,$spracheID,2,$link);
	if ($id == -1){
		return false;
	}
	else{
		return true;
	}

}

/**
gibt die standard-sprache
zurück
*/
function getStandardSprache($unterkunft_id,$link){
		
		$query = "select 
				  Sprache_ID
				  from
				  Rezervi_Standard_Sprachen
				  where
				  Einstellungen_ID = '$unterkunft_id'
				  AND
				  Modul = 0
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
		else		
			$d = mysql_fetch_array($res);
		
		$sprachen_string = $d["Sprache_ID"];
		
		return $sprachen_string;		
			
} //ende getStandardSprache

/**
gibt die standard-sprache des belegungsplanes 
zurück
*/
function getStandardSpracheBelegungsplan($unterkunft_id,$link){
		
		$query = "select 
				  Sprache_ID
				  from
				  Rezervi_Standard_Sprachen
				  where
				  Einstellungen_ID = '$unterkunft_id'
				  AND
				  Modul = 1
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
		else		
			$d = mysql_fetch_array($res);
		
		$sprachen_string = $d["Sprache_ID"];
		
		return $sprachen_string;		
			
} //ende getStandardSprache

/**
setzen der standard-sprache
*/
function setStandardSprache($unterkunft_id,$spracheID,$link) {

	$id = getStandardSprachePKID2($unterkunft_id,0,$link);
	if ($id > -1){
		$query = "UPDATE
			  Rezervi_Standard_Sprachen
			  SET
			  Sprache_ID = '$spracheID'
			  WHERE				  
			  Einstellungen_ID = '$unterkunft_id'
			  AND
			  PK_ID = '$id'
			 ";	
	
	}
	else{
		$query = "INSERT INTO 
			  Rezervi_Standard_Sprachen
			  (Sprache_ID,Modul,Einstellungen_ID)
			  VALUES				  
			  ('$spracheID',0,'$unterkunft_id')
			 ";
	}
	

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
setzen der standard-sprache fuer den Belegungsplan
*/
function setStandardSpracheBelegungsplan($unterkunft_id,$spracheID,$link) {

	$id = getStandardSprachePKID2($unterkunft_id,1,$link);
	if ($id > -1){
		$query = "UPDATE
			  Rezervi_Standard_Sprachen
			  SET
			  Sprache_ID = '$spracheID'
			  WHERE				  
			  Einstellungen_ID = '$unterkunft_id'
			  AND
			  PK_ID = '$id'
			 ";	
	
	}
	else{
		$query = "INSERT INTO 
			  Rezervi_Standard_Sprachen
			  (Sprache_ID,Modul,Einstellungen_ID)
			  VALUES				  
			  ('$spracheID',1,'$unterkunft_id')
			 ";
	}
	

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
prueft ob deutsch angezeigt werden soll
*/
function isGermanShown($unterkunft_id,$link){
	
	return isSpracheShown($unterkunft_id,"de",$link);

}

/**
prueft ob englisch angezeigt werden soll
*/
function isEnglishShown($unterkunft_id,$link){
	
	return isSpracheShown($unterkunft_id,"en",$link);

}

/**
prueft ob französisch angezeigt werden soll
*/
function isFrenchShown($unterkunft_id,$link){
	
	return isSpracheShown($unterkunft_id,"fr",$link);

}

/**
prueft ob italienisch angezeigt werden soll
*/
function isItalianShown($unterkunft_id,$link){
	
	return isSpracheShown($unterkunft_id,"it",$link);

}

/**
prueft ob englisch angezeigt werden soll
*/
function isEspaniaShown($unterkunft_id,$link){
	
	return isSpracheShown($unterkunft_id,"sp",$link);

}

/**
prueft ob hollaendisch angezeigt werden soll
*/
function isNetherlandsShown($unterkunft_id,$link){
	
	return isSpracheShown($unterkunft_id,"nl",$link);

}

/**
prueft ob estnisch angezeigt werden soll
*/
function isEstoniaShown($unterkunft_id,$link){
	
	return isSpracheShown($unterkunft_id,"es",$link);

}

function removeAllStandardSpracheFromModul($unterkunft_id,$modul,$link){
		$query = ("DELETE FROM	
			   Rezervi_Standard_Sprachen
			   WHERE
			   Einstellungen_ID = '$unterkunft_id'
			   AND
			   Modul = '$modul'
			   ");
			   
	$res = mysql_query($query, $link);		
	  
	if (!$res) {
		echo("die Anfrage $query scheitert");
		echo(mysql_error($link));
		return false;
	}
			   
	return true;
}

/**
setzen der framesize links des webinteraces
*/
function setFramesizeLeftWI($unterkunft_id,$framesize,$unit,$link) {
	
	if($unit == "*"){
		$framesize=$unit;
	}
	else if ($unit == "%"){
		$framesize=$framesize.$unit;
	}

		$query = "UPDATE
			  Rezervi_Einstellungen_Neu
			  SET
			  Frame_left_WI = '$framesize'
			  WHERE				  
			  FK_Unterkunft_ID = '$unterkunft_id'
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
setzen der framesize rechts des webinteraces
*/
function setFramesizeRightWI($unterkunft_id,$framesize,$unit,$link) {
	
	if($unit == "*"){
		$framesize=$unit;
	}
	else if ($unit == "%"){
		$framesize=$framesize.$unit;
	}

		$query = "UPDATE
			  Rezervi_Einstellungen_Neu
			  SET
			  Frame_right_WI = '$framesize'
			  WHERE				  
			  FK_Unterkunft_ID = '$unterkunft_id'
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
setzen der framesize links des belegungsplanes
*/
function setFramesizeLeftBP($unterkunft_id,$framesize,$unit,$link) {
	
	if($unit == "*"){
		$framesize=$unit;
	}
	else if ($unit == "%"){
		$framesize=$framesize.$unit;
	}

		$query = "UPDATE
			  Rezervi_Einstellungen_Neu
			  SET
			  Frame_left_BP = '$framesize'
			  WHERE				  
			  FK_Unterkunft_ID = '$unterkunft_id'
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
setzen der framesize rechts des belegungsplanes
*/
function setFramesizeRightBP($unterkunft_id,$framesize,$unit,$link) {
	
	if($unit == "*"){
		$framesize=$unit;
	}
	else if ($unit == "%"){
		$framesize=$framesize.$unit;
	}

		$query = "UPDATE
			  Rezervi_Einstellungen_Neu
			  SET
			  Frame_right_BP = '$framesize'
			  WHERE				  
			  FK_Unterkunft_ID = '$unterkunft_id'
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
