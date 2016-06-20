<?php

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 

/**
count the rooms, that are parent from other rooms
@param $unterkunft_id
@return the number of rooms, that are parent from other rooms
* */
function countParentRooms($unterkunft_id){

	global $link;
	$query = ("select count(PK_ID) as anzahl from Rezervi_Zimmer where Parent_ID is not null");        

	$res = mysql_query($query, $link);
	
	if (!$res) { 
		echo("die Anfrage $query scheitert"); 
		return false;
	}
	else{
		$d = mysql_fetch_array($res);
		if (!empty($d['anzahl']) && $d['anzahl'] > 0){
			$hasParent = $d['anzahl'];
			$allRooms = getAnzahlVorhandeneZimmer($unterkunft_id,$link);			
			return $allRooms - $hasParent;
		}
	}
	return 0;

}
/**
checks if any parant - child relationship exists
@param $unterkunft_id
* */
function hasParentRooms($unterkunft_id){

	global $link;
	$query = ("select count(PK_ID) as anzahl from Rezervi_Zimmer where Parent_ID is not null");        

	$res = mysql_query($query, $link);
	
	if (!$res) { 
		echo("die Anfrage $query scheitert"); 
		return false;
	}
	else{
		$d = mysql_fetch_array($res);
		if (!empty($d['anzahl']) && $d['anzahl'] > 0){
			return true;
		}
	}
	return false;

}
/**
checks if any parant - child relationship for the room exists
@param $room_id
* */
function hasRoomParentRooms($room_id){

	global $link;
	$query = ("select count(PK_ID) as anzahl from Rezervi_Zimmer where Parent_ID is not null and PK_ID = '$room_id'");        

	$res = mysql_query($query, $link);
	
	if (!$res) { 
		echo("die Anfrage $query scheitert"); 
		return false;
	}
	else{
		$d = mysql_fetch_array($res);
		if (!empty($d['anzahl']) && $d['anzahl'] > 0){
			return true;
		}
	}
	return false;

}
/**
returns the parent room id
@param $room_id
* */
function getParentRoom($room_id){

	global $link;
	$query = ("select PK_ID from Rezervi_Zimmer where Parent_ID is not null and PK_ID = '$room_id'");        

	$res = mysql_query($query, $link);
	
	if (!$res) { 
		echo("die Anfrage $query scheitert"); 
		return false;
	}
	else{
		$d = mysql_fetch_array($res);
		if (!empty($d['PK_ID'])){
			return $d['PK_ID'];
		}
	}
	return false;

}
/**
returns all parent rooms
* */
function getParentRooms(){

	global $link;
	global $unterkunft_id;
	
	if (hasParentRooms($unterkunft_id)){
		$query = ("select * from Rezervi_Zimmer where Parent_ID is null");        
	
		$res = mysql_query($query, $link);
		
		if (!$res) { 
			echo("die Anfrage $query scheitert"); 
			return false;
		}
		else{
			return $res;
		}
	}
	return false;

}
/**
delete all child rooms of the given room
@param $room the parent room
* */
function deleteChildRooms($zimmer_id){

	global $link;
	$query = ("UPDATE 
				Rezervi_Zimmer
				SET
          		Parent_ID = NULL
           		WHERE
           		Parent_ID = '$zimmer_id'
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
returns all rooms with child rooms
@param $unterkunft_id
@return mysql result set with all room ids with child rooms
* */
function getAllRoomsWithChilds($unterkunft_id){

	global $link;
	$query = ("select distinct Parent_ID from Rezervi_Zimmer where Parent_ID is not null");        

	$res = mysql_query($query, $link);
	
	if (!$res) { 
		echo("die Anfrage $query scheitert"); 
		return false;
	}

	return $res;

}
/**
set the parent room (eg. the house) of the room
@param $zimmer the room (the child)
@param $house the parent room (the parent, eg. the house)
* */
function setParentRoom($zimmer,$house){

	global $link;
	$query = ("UPDATE 
				Rezervi_Zimmer
				SET
          		Parent_ID = '$house'
           		WHERE
           		PK_ID = '$zimmer'
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
checks child rooms of the room (eg. the rooms of a house)
@param $room the room 
@return the mysql result set of rooms
* */
function hasChildRooms($room){
		
		global $link;
		$query = "select 
				  count(PK_ID) as anzahl
				  from
				  Rezervi_Zimmer
				  where
				  Parent_ID = '$room'
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo(mysql_error($link));
  		}
		else{		
			$d = mysql_fetch_array($res);
			$anzahl = $d['anzahl'];
			if ($anzahl > 0){
				return true;
			}
		}
		return false;
}
/**
get child rooms of the room (eg. the rooms of a house)
@param $room the room 
@return the mysql result set of rooms
* */
function getChildRooms($room){
		
		global $link;
		$query = "select 
				  *
				  from
				  Rezervi_Zimmer
				  where
				  Parent_ID = '$room'
				  ORDER BY
				  Zimmernr
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo(mysql_error($link));
  		}
		else{		
			return $res;
		}
}

function updateZimmer($zimmer_id,$unterkunft_id,$zimmernr,$betten,$bettenKinder,$zimmerart,$linkName,$haustiere,$link){
	
	$query = ("UPDATE 
				Rezervi_Zimmer
				SET
          		Zimmernr = '$zimmernr',	
		   		Zimmerart = '$zimmerart',
				Betten = '$betten',
				Betten_Kinder = '$bettenKinder',
				Link = '$linkName',
				Haustiere= '$haustiere'
           		WHERE
           		PK_ID = '$zimmer_id'
				and
				FK_Unterkunft_ID = '$unterkunft_id'
		   ");           

	$res = mysql_query($query, $link);
	
	if (!$res) { 
		echo("die Anfrage $query scheitert"); 
		return false;
	}
	else{
		return true;
	}
				
} //ende updateZimmer

function setZimmer($unterkunft_id,$zimmernr,$betten,$bettenKinder,$zimmerart,$linkName,$haustiere,$link){

	//eintragen in db
	$query = "
		INSERT INTO 
		Rezervi_Zimmer
		(FK_Unterkunft_ID,Zimmernr,Betten,Betten_Kinder,Zimmerart,Haustiere,Link)
		VALUES
		('$unterkunft_id','$zimmernr','$betten','$bettenKinder','$zimmerart','$haustiere','$linkName')
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

} //ende zimmer eintragen

//zählt die anzahl der bereits angelegten zimmer:
function getAnzahlVorhandeneZimmer($unterkunft_id,$link){

	$num_rows = 0;
	
		$query = "select 
				  PK_ID
				  from
				  Rezervi_Zimmer
				  where
				  FK_Unterkunft_ID = '$unterkunft_id'
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res)
  			return 0;
		else		
			$num_rows = mysql_num_rows($res);	
	
	return $num_rows;
			
} //ende getAnzahlVorhandeneZimmer

/**
gibt my_sql result aller zimmer einer unterkunft zurück
*/
function getZimmer($unterkunft_id,$link){
	
		$query = "select 
				  *
				  from
				  Rezervi_Zimmer
				  where
				  FK_Unterkunft_ID = '$unterkunft_id'
				  ORDER BY
				  Zimmernr
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo(mysql_error($link));
  		}
		else{		
			return $res;
		}	
			
} //ende getZimmer

//--------------------------------------------
//funktion gibt die zimmernummer zurück, 
//übergeben wird die id der unterkunft,
//des zimmers und 
//der link zur datenbank
//die datenbank muss dazu geöffnet sein.
function getZimmerNr($unterkunft_id,$zimmer_id,$link){

	//zimmer-nummer aus datenbank auslesen:
		$query = "select 
				  Zimmernr
				  from
				  Rezervi_Zimmer
				  where
				  PK_ID = '$zimmer_id' 
				  and
				  FK_Unterkunft_ID = '$unterkunft_id'
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
			return false;
		}
		else{		
			$d = mysql_fetch_array($res);			
			return $d["Zimmernr"];
		}
			
} //ende getZimmerNummer

//--------------------------------------------
//funktion gibt eine einzelne zimmerart zurück, 
//übergeben wird die id der unterkunft,
//des zimmers und 
//der link zur datenbank
//die datenbank muss dazu geöffnet sein.
function getZimmerArt($unterkunft_id,$zimmer_id,$link){

	//zimmer-art aus datenbank auslesen:
		$d = "";	
		$query = "select 
				  Zimmerart
				  from
				  Rezervi_Zimmer
				  where
				  PK_ID = '$zimmer_id' and
				  FK_Unterkunft_ID = '$unterkunft_id'
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
		else		
			$d = mysql_fetch_array($res);
		
		return $d["Zimmerart"];
			
} //ende getZimmerArt

function getzimmerArtString($unterkunft_id,$link){

	$zimmera = "";

	//feststellen wie viele zimmer es gibt, um einzahl oder mehrzahl zu wählen:
	$anzahlZimmer = getAnzahlVorhandeneZimmer($unterkunft_id,$link);
	if ($anzahlZimmer > 1){
		//mehrzahl auslesen:
		 $zimmera = getzimmerart_MZ($unterkunft_id,$link);
		 if (!isset($zimmera) || $zimmera == ""){
			$zimmera = getZimmerArten($unterkunft_id,$link); 
		 } 
	}
	else{
		//einzahl auslesen:
		 $zimmera = getzimmerart_EZ($unterkunft_id,$link);
		 if (!isset($zimmera) || $zimmera == ""){
			$zimmera = getZimmerArten($unterkunft_id,$link);
		 } 	
	}
	
	return $zimmera;	
}

//--------------------------------------------
//funktion gibt alle zimmerarten als string zurück, 
//übergeben wird die id der unterkunft,
//die sprache und 
//der link zur datenbank
//die datenbank muss dazu geöffnet sein.
function getZimmerArten($unterkunft_id,$link){

	$zimmerart = "";
	global $root;
	global $sprache;
	include_once($root.'/include/uebersetzer.php');
	
	//zimmer-art aus datenbank auslesen:
		$query = "select DISTINCT 
				  Zimmerart
				  from
				  Rezervi_Zimmer
				  where				
				  FK_Unterkunft_ID = '$unterkunft_id'
				 ";
  		$res = mysql_query($query, $link);
		
		while($d = mysql_fetch_array($res)){
			if ($zimmerart == ""){
				$zimmerart = getUebersetzungUnterkunft($d["Zimmerart"],$sprache,$unterkunft_id,$link);
			}
			else if($d["Zimmerart"] != ""){
				$zimmerart = $zimmerart."<br/>".getUebersetzungUnterkunft($d["Zimmerart"],$sprache,$unterkunft_id,$link);
			}		
		}	
			
	return $zimmerart;
			
} //ende getZimmerArten

//--------------------------------------------
//funktion die die bettenanzahl zurückgibt
//der link zur datenbank
//die datenbank muss dazu geöffnet sein.
function getBetten($unterkunft_id,$zimmer_id,$link){	
			
		$query = "select 
				  Betten
				  from
				  Rezervi_Zimmer
				  where				
				  FK_Unterkunft_ID = '$unterkunft_id'
				  and
				  PK_ID = '$zimmer_id'
				 ";

  		$res = mysql_query($query, $link);		
		$d = mysql_fetch_array($res);
				
		return $d["Betten"];		
			
} //ende getBetten

//--------------------------------------------
//funktion die die bettenanzahl fuer Kinder zurückgibt
//der link zur datenbank
//die datenbank muss dazu geöffnet sein.
function getBettenKinder($unterkunft_id,$zimmer_id,$link){	
			
		$query = "select 
				  Betten_Kinder
				  from
				  Rezervi_Zimmer
				  where				
				  FK_Unterkunft_ID = '$unterkunft_id'
				  and
				  PK_ID = '$zimmer_id'
				 ";

  		$res = mysql_query($query, $link);		
		$d = mysql_fetch_array($res);
				
		return $d["Betten_Kinder"];		
			
} //ende getBetten

//--------------------------------------------
//Funktion, die den Link des Zimmers zurückgibt
//der link zur datenbank
//die datenbank muss dazu geöffnet sein.
function getLink($unterkunft_id,$zimmer_id,$link){	
			
		$query = "SELECT
				  Link
				  FROM
				  Rezervi_Zimmer
				  WHERE			
				  FK_Unterkunft_ID = '$unterkunft_id'
				  AND
				  PK_ID = '$zimmer_id'
				 ";

  		$res = mysql_query($query, $link);		
		$d = mysql_fetch_array($res);
				
		return $d["Link"];		
			
} //ende getLink

//--------------------------------------------
//Funktion, die das Feld "Haustiere" des Zimmers zurückgibt
//der link zur datenbank
//die datenbank muss dazu geöffnet sein.
function getHaustiere($unterkunft_id,$zimmer_id,$link){	
			
		$query = "SELECT
				  Haustiere
				  FROM
				  Rezervi_Zimmer
				  WHERE			
				  FK_Unterkunft_ID = '$unterkunft_id'
				  AND
				  PK_ID = '$zimmer_id'
				 ";

  		$res = mysql_query($query, $link);		
		$d = mysql_fetch_array($res);
				
		return $d["Haustiere"];		
			
} //ende getHaustiere

?>
