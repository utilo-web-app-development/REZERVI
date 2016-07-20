<?php

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 

/**
insert a new user in the database
@param $benutzername the username to set
@param $pass the password for the user
*/
function setUser($benutzername,$pass,$rechte){

	$pass = sha1($pass);
	global $unterkunft_id;
	global $link;

	//eintragen in db
	$query = "
		INSERT INTO 
		Rezervi_Benutzer
		(FK_Unterkunft_ID,Name,Passwort,Rechte)
		VALUES
		('$unterkunft_id','$benutzername','$pass','$rechte')
		";

  	$res = mysqli_query($link, $query);
  	if (!$res) {
  		echo("Anfrage $query scheitert.");
	}
	
}

/**
Ändern eines benutzers
author: coster
*/
function changeBenutzer($id,$name,$pass,$rechte,$unterkunft_id,$link){

	$pass = sha1($pass);

	$query = ("UPDATE 
				Rezervi_Benutzer
				SET
          		Name = '$name',	
		   		Passwort = '$pass',
		   		Rechte = '$rechte'
           		WHERE
           		PK_ID = '$id'
				and
				FK_Unterkunft_ID = '$unterkunft_id'
		   ");           

	$res = mysqli_query($link, $query);
    if (!$res) { 
		echo("die Anfrage $query scheitert"); 
		return false;
	}
	return true;
}

//--------------------------------------------
//funktion prüft ein eingegebenes passwort
//und gibt id des benutzers zurück
//bei erfolgloser passwortprüfung wird
//-1 zurückgegeben
function checkPassword($name,$password,$link){

		//sha verschluesselung:
		$password = sha1($password);
	
		$query = "select 
				  PK_ID, Name, Passwort
				  from
				  Rezervi_Benutzer
				  where
				  Passwort = '$password' and
				  Name = '$name'
				 ";

  		$res = mysqli_query($link, $query);
  		if (!$res) {
  			echo("Anfrage $query scheitert.");
		}
		else {		
			$d = mysqli_fetch_array($res);
			$temp = $d["PK_ID"];
			if (!(empty($temp) || $temp == "")) {
				return $temp;
			}
		}
	
		return -1;
		
} //ende checkPassword

//--------------------------------------------
//funktion prüft ein eingegebenes passwort
function checkPass($name,$password,$unterkunft_id,$link){

		$password = sha1($password);
	
		$query = "select 
				  Name, Passwort, FK_Unterkunft_ID
				  from
				  Rezervi_Benutzer
				  where
				  Passwort = '$password' and
				  Name = '$name'
				 ";

  		$res = mysqli_query($link, $query);
  		if (!$res) {
  			echo("Anfrage $query scheitert.");
		}
		else {		
			$d = mysqli_fetch_array($res);
			$uk_id = $d["FK_Unterkunft_ID"];
			if ($uk_id == $unterkunft_id) {
				return true;
			}
		}
	
		return false;
		
} //ende checkPass

/**
author: coster
date: 30.12.05
liefert die benutzer-id aufgrund des passwortes und benutzernamens
*/
function getUserId($username,$password,$link){

	$password = sha1($password);
	
		$name = "";
		$query = "select 
				  PK_ID
				  from
				  Rezervi_Benutzer
				  where
				  Name = '$username'
				  and
				  Passwort = '$password'
				 ";

  		$res = mysqli_query($link, $query);
  		if (!$res) {
  			echo("Anfrage $query scheitert.");
		}
		else {		
			$d = mysqli_fetch_array($res);
			$name = $d["PK_ID"];
		}
	
		return $name;
		
} //ende getUserName

//--------------------------------------------
//funktion gibt benutzernamen retour
//Übergeben wird die id des benutzers
function getUserName($id,$link){
	
		$name = "";
		$query = "select 
				  Name
				  from
				  Rezervi_Benutzer
				  where
				  PK_ID = '$id'
				 ";

  		$res = mysqli_query($link, $query);
  		if (!$res) {
  			echo("Anfrage $query scheitert.");
		}
		else {		
			$d = mysqli_fetch_array($res);
			$name = $d["Name"];
		}
	
		return $name;
		
} //ende getUserName

//--------------------------------------------
//funktion gibt passwort zurück
function getPassword($id,$link){
	
		$name = "";
		$query = "select 
				  Passwort
				  from
				  Rezervi_Benutzer
				  where
				  PK_ID = '$id'
				 ";

  		$res = mysqli_query($link, $query);
  		if (!$res) {
  			echo("Anfrage $query scheitert.");
		}
		else {		
			$d = mysqli_fetch_array($res);
			$name = $d["Passwort"];
		}
	
		return $name;
		
} //ende getPassword

//--------------------------------------------
//funktion gibt benutzerrechte retour
//Übergeben wird die id des benutzers
function getUserRights($id,$link){
	
		$rechte = "";
		$query = "select 
				  Rechte
				  from
				  Rezervi_Benutzer
				  where
				  PK_ID = '$id'
				 ";

  		$res = mysqli_query($link, $query);
  		if (!$res) {
  			echo("Anfrage $query scheitert.");
		}
		else {		
			$d = mysqli_fetch_array($res);
			$rechte = $d["Rechte"];
		}
	
		return $rechte;
		
} //ende getUserRights

//--------------------------------------------
//funktion gibt unterkunft-id retour
//übergeben wird die id des benutzers
function getUnterkunftID($id,$link){
	
		$uk = "";
		$query = "select 
				  FK_Unterkunft_ID
				  from
				  Rezervi_Benutzer
				  where
				  PK_ID = '$id'
				 ";

  		$res = mysqli_query($link, $query);
  		if (!$res) {
  			echo("Anfrage $query scheitert.");
		}
		else {		
			$d = mysqli_fetch_array($res);
			$uk = $d["FK_Unterkunft_ID"];
		}
	
		return $uk;
		
} //ende getUnterkunftID

//zählt die anzahl der bereits angelegten zimmer:
function getAnzahlVorhandeneBenutzer($unterkunft_id,$link){

	$num_rows = 0;
	
		$query = "select 
				  PK_ID
				  from
				  Rezervi_Benutzer
				  where
				  FK_Unterkunft_ID = '$unterkunft_id'
				 ";

  		$res = mysqli_query($link, $query);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
		else		
			$num_rows = mysqli_num_rows($res);	
	
	return $num_rows;
			
} //ende getAnzahlVorhandeneZimmer

?>
