<?php

/*
 * Passwortverschluesselung
 * @date 16.7.2007
 * @see http://www.weberdev.com/get_example-4118.html
Description : A function with a very simple but powerful xor method to encrypt
              and/or decrypt a string with an unknown key. Implicitly the key is
              defined by the string itself in a character by character way.
              There are 4 items to compose the unknown key for the character
              in the algorithm
              1.- The ascii code of every character of the string itself
              2.- The position in the string of the character to encrypt
              3.- The length of the string that include the character
              4.- Any special formula added by the programmer to the algorithm
                  to calculate the key to use
*/
FUNCTION ENCRYPT_DECRYPT($Str_Message) {
//Function : encrypt/decrypt a string message v.1.0  without a known key
//Author   : Aitor Solozabal Merino (spain)
//Email    : aitor-3@euskalnet.net
//Date     : 01-04-2005
    $Len_Str_Message=STRLEN($Str_Message);
    $Str_Encrypted_Message="";
    FOR ($Position = 0;$Position<$Len_Str_Message;$Position++){
        // long code of the function to explain the algoritm
        //this function can be tailored by the programmer modifyng the formula
        //to calculate the key to use for every character in the string.
        $Key_To_Use = (($Len_Str_Message+$Position)+1); // (+5 or *3 or ^2)
        //after that we need a module division because can´t be greater than 255
        $Key_To_Use = (255+$Key_To_Use) % 255;
        $Byte_To_Be_Encrypted = SUBSTR($Str_Message, $Position, 1);
        $Ascii_Num_Byte_To_Encrypt = ORD($Byte_To_Be_Encrypted);
        $Xored_Byte = $Ascii_Num_Byte_To_Encrypt ^ $Key_To_Use;  //xor operation
        $Encrypted_Byte = CHR($Xored_Byte);
        $Str_Encrypted_Message .= $Encrypted_Byte;
       
        //short code of  the function once explained
        //$str_encrypted_message .= chr((ord(substr($str_message, $position, 1))) ^ ((255+(($len_str_message+$position)+1)) % 255));
    }
    RETURN $Str_Encrypted_Message;
} //end function 
/**
 * author:coster
 * date: 24.9.05
 * loescht einen benutzer mit einer übergebenen id
 * */
function deleteBenutzer($benutzer_id){
	global $db;
		
		$query = "delete from 
				  BOOKLINE_BENUTZER
				  where
				  BENUTZER_ID = '$benutzer_id' 
				 ";

  		$res = $db->Execute($query);
  		if (!$res) {  			
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
function isBenutzerVorhanden($name,$pass,$gastro_id){
		global $db;
		
		//passwort ist verschluesselt:
		$pass = ENCRYPT_DECRYPT($pass);
		
		$query = "select 
				  BENUTZER_ID as anzahl
				  from
				  BOOKLINE_BENUTZER
				  where
				  PASSWORT = '$pass' and
				  NAME = '$name' and
				  GASTRO_ID = '$gastro_id'
				 ";

  		$res = $db->Execute($query);
  		if (!$res) {
  			//nichts anzeigen - sonst wird passwort sichtbar!
  			//
  			return false;
		}
		else {		
			$temp = $res->fields["anzahl"];
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

	global $db;
	$pass = ENCRYPT_DECRYPT($pass);
	
	$query = ("UPDATE 
				BOOKLINE_BENUTZER
				SET
          		NAME = '$name',	
		   		PASSWORT = '$pass',
		   		RECHTE = '$rechte'
           		WHERE
           		BENUTZER_ID = '$id'
		   ");           

	$res = $db->Execute($query);
    if (!$res) { 		 
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
	
	global $db;
	$password = ENCRYPT_DECRYPT($password);

		$query = "select 
				  BENUTZER_ID
				  from
				  BOOKLINE_BENUTZER
				  where
				  PASSWORT = '$password' and
				  NAME = '$name'
				 ";

  		$res = $db->Execute($query);
  		if (!$res) {
  			if (DEBUG){
  				print $db->ErrorMsg();
  			}  			
  			//nichts anzeigen - sonst wird passwort sichtbar!
  			return -1;
		}
		else {		
			$temp = $res->fields["BENUTZER_ID"];
			if (!empty($temp)) {
				
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
	
	global $db;
	
		$name = "";
		$query = "select 
				  NAME
				  from
				  BOOKLINE_BENUTZER
				  where
				  BENUTZER_ID = '$id'
				 ";

  		$res = $db->Execute($query);
  		if (!$res) {  			
  			return false;
		}
		else {		
			$name = $res->fields["NAME"];
			return $name;
		}		
		
} //ende getUserName
/**
 * author:coster
 * date: 22.9.05
 * gibt das passwort eines benutzers zurück
 * */
function getPassword($id){
	
		global $db;
	
		$name = "";
		$query = "select 
				  PASSWORT
				  from
				  BOOKLINE_BENUTZER
				  where
				  BENUTZER_ID = '$id'
				 ";

  		$res = $db->Execute($query);
  		if (!$res) {
  			//nicht aus sicherheitsgründen: 
  			return false;
		}
		else {		
			$name = $res->fields["PASSWORT"];
		}
	
		return ENCRYPT_DECRYPT($name);

		
} //ende getPassword
/**
 * author:coster
 * date: 22.9.05
 * */
function getUserRights($id){
	
	global $db;
	
		$rechte = "";
		$query = "select 
				  RECHTE
				  from
				  BOOKLINE_BENUTZER
				  where
				  BENUTZER_ID = '$id'
				 ";

  		$res = $db->Execute($query);
  		if (!$res) {  			
  			return false;
		}
		else {		
			$rechte = $res->fields["RECHTE"];
		}
	
		return $rechte;
		
} //ende getUserRights

/**
 * author:coster
 * date: 19.9.05
//--------------------------------------------
//funktion gibt GASTRO_ID retour
//übergeben wird die id des benutzers
 */
function getVermieterID($id){
	
	global $db;

		$query = "select 
				  GASTRO_ID
				  from
				  BOOKLINE_BENUTZER
				  where
				  BENUTZER_ID = '$id'
				 ";

  		$res = $db->Execute($query);
  		if (!$res) {  			
  			return false;
		}
		else {		
			return $res->fields["GASTRO_ID"];
		}
		
} //ende getVermieterID
/**
 * author:coster
 * date: 22.9.05
 * liefert die anzahl von angelegten benutzern eines vermieters
 * */
function getAnzahlVorhandeneBenutzer($gastro_id){

	global $db;

	$num_rows = 0;
	
		$query = "select 
				  count(BENUTZER_ID) as anzahl
				  from
				  BOOKLINE_BENUTZER
				  where
				  GASTRO_ID = '$gastro_id'
				 ";

  		$res = $db->Execute($query);
  		if (!$res){  			
  			return 0;
  		}
		else{
			$num_rows = $res->fields["anzahl"];
		}	
	
	return $num_rows;
			
}
/**
 * author:coster
 * date: 22.9.05
 * liefert alle vorhandenen benutzer
 * */
function getBenutzer($gastro_id){

	global $db;
	
		$query = "select 
				  *
				  from
				  BOOKLINE_BENUTZER
				  where
				  GASTRO_ID = '$gastro_id'
				 ";

  		$res = $db->Execute($query);
  		if (!$res){  			
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
function setBenutzer($name,$pass,$rechte,$gastro_id){
		
		global $db;
		
		//passwort verschluesselt speichern:
		$pass = ENCRYPT_DECRYPT($pass);
	
		$query = "insert into 
				  BOOKLINE_BENUTZER
				  set
				  NAME = '$name',
				  PASSWORT = '$pass',
				  GASTRO_ID = '$gastro_id',
				  RECHTE = '$rechte'
				 ";

  		$res = $db->Execute($query);
  		if (!$res){  			
  			return false;
  		}
		else{
			return true;
		}
}
?>
