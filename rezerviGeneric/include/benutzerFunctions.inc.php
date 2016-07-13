<?php
/**
 * author:coster
 * date: 24.9.05
 * loescht einen benutzer mit einer übergebenen id
 * */
function deleteBenutzer($benutzer_id){
	global $link;
		
		$query = "delete from 
				  REZ_GEN_BENUTZER
				  where
				  BENUTZER_ID = '$benutzer_id' 
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res) {
  			echo("Anfrage $query scheitert.");
  			return false;
		}
		else {		
			return true;
		}

}
/**
 * author: coster
 * date: 23.9.05
 * prueft ob ein beutzer mit dem passwort und namen bereits vorhanden ist
 * */
function isBenutzerVorhanden($name,$pass,$vermieter_id){
		global $link;
	
		$query = "select 
				  BENUTZER_ID as anzahl
				  from
				  REZ_GEN_BENUTZER
				  where
				  PASSWORT = '$pass' and
				  NAME = '$name' and
				  VERMIETER_ID = '$vermieter_id'
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res) {
  			//nichts anzeigen - sonst wird passwort sichtbar!
  			//echo("Anfrage $query scheitert.");
  			return false;
		}
		else {		
			$d = mysql_fetch_array($res);
			$temp = $d["anzahl"];
			if (!(empty($temp) || $temp > 1)) {
				return true;
			}
			else{
				return false;
			}
		}
	
}
/**
ändern eines benutzers
author: coster
date: 22.9.05
*/
function changeBenutzer($id,$name,$pass,$rechte){

	global $link;
	
	$query = ("UPDATE 
				REZ_GEN_BENUTZER
				SET
          		NAME = '$name',	
		   		PASSWORT = '$pass',
		   		RECHTE = '$rechte'
           		WHERE
           		BENUTZER_ID = '$id'
		   ");           

	$res = mysql_query($query, $link);
    if (!$res) { 
		echo("die Anfrage $query scheitert"); 
		return false;
	}
	return true;
}
/**
 * author:coster
 * date:22.9.05
 * prueft das passwort eines benutzers und gibt bei erfolg dessen
 * benutzer id zurück, sonst -1;
 * */
function checkPassword($name,$password){
	
	global $link;
	
		$query = "select 
				  *
				  from
				  REZ_GEN_BENUTZER
				  where
				  PASSWORT = '$password' and
				  NAME = '$name'
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res) {
  			//nichts anzeigen - sonst wird passwort sichtbar!
  			//echo("Anfrage $query scheitert.");
  			return -1;
		}
		else {		
			$d = mysql_fetch_array($res);
			$temp = $d["BENUTZER_ID"];
			if (!(empty($temp) || $temp == "")) {
				return $temp;
			}
		}
	
		return -1;
		
} //ende checkPassword
/**
 * author:coster
 * date: 22.9.05
 * liefert den benutzernamen 
 * */
function getUserName($id){
	
	global $link;
	
		$name = "";
		$query = "select 
				  NAME
				  from
				  REZ_GEN_BENUTZER
				  where
				  BENUTZER_ID = '$id'
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res) {
  			echo("Anfrage $query scheitert.");
  			return false;
		}
		else {		
			$d = mysql_fetch_array($res);
			$name = $d["NAME"];
			return $name;
		}		
		
} //ende getUserName
/**
 * author:coster
 * date: 22.9.05
 * gibt das passwort eines benutzers zurück
 * */
function getPassword($id){
	
	global $link;
	
		$name = "";
		$query = "select 
				  PASSWORT
				  from
				  REZ_GEN_BENUTZER
				  where
				  BENUTZER_ID = '$id'
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res) {
  			//nicht aus sicherheitsgründen: echo("Anfrage $query scheitert.");
  			return false;
		}
		else {		
			$d = mysql_fetch_array($res);
			$name = $d["PASSWORT"];
		}
	
		return $name;
		
} //ende getPassword
/**
 * author:coster
 * date: 22.9.05
 * */
function getUserRights($id){
	
	global $link;
	
		$rechte = "";
		$query = "select 
				  RECHTE
				  from
				  REZ_GEN_BENUTZER
				  where
				  BENUTZER_ID = '$id'
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res) {
  			echo("Anfrage $query scheitert.");
  			return false;
		}
		else {		
			$d = mysql_fetch_array($res);
			$rechte = $d["RECHTE"];
		}
	
		return $rechte;
		
} //ende getUserRights

/**
 * author:coster
 * date: 19.9.05
//--------------------------------------------
//funktion gibt VERMIETER_ID retour
//Übergeben wird die id des benutzers
 */
function getVermieterID($id){
	
	global $link;

		$query = "select 
				  VERMIETER_ID
				  from
				  REZ_GEN_BENUTZER
				  where
				  BENUTZER_ID = '$id'
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res) {
  			echo("Anfrage $query scheitert.");
  			return false;
		}
		else {		
			$d = mysql_fetch_array($res);
			return $d["VERMIETER_ID"];
		}
		
} //ende getVermieterID
/**
 * author:coster
 * date: 22.9.05
 * liefert die anzahl von angelegten benutzern eines vermieters
 * */
function getAnzahlVorhandeneBenutzer($vermieter_id){

	global $link;

	$num_rows = 0;
	
		$query = "select 
				  count(BENUTZER_ID) as anzahl
				  from
				  REZ_GEN_BENUTZER
				  where
				  VERMIETER_ID = '$vermieter_id'
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  			return 0;
  		}
		else{
			$d= mysql_fetch_array($res);		
			$num_rows = $d["anzahl"];
		}	
	
	return $num_rows;
			
}
/**
 * author:coster
 * date: 22.9.05
 * liefert alle vorhandenen benutzer
 * */
function getBenutzer($vermieter_id){

	global $link;
	
		$query = "select 
				  *
				  from
				  REZ_GEN_BENUTZER
				  where
				  VERMIETER_ID = '$vermieter_id'
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  			return false;
  		}
		else{
			return $res;
		}	
			
}
/**
 * author:coster
 * date: 22.9.05
 * speichert einen neuen benutzer
 * */
function setBenutzer($name,$pass,$rechte,$vermieter_id){
	global $link;
	
		$query = "insert into 
				  REZ_GEN_BENUTZER
				  set
				  NAME = '$name',
				  PASSWORT = '$pass',
				  VERMIETER_ID = '$vermieter_id',
				  RECHTE = '$rechte'
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
?>
