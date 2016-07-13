<?php

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 

/**
 * author:coster
 * date:10.1.06
 * prueft ob rezervi überhaupt schon isntalliert wurde
 * fuer eine bestimmte unterkunft indem festgestellt wird ob eine emailadresse vorhanden ist
 * */
 function isInstalled($unterkunft_id){
 		
 		global $link;
 		
 		$query = "select 
					Email 
					from 
					Rezervi_Unterkunft 
					where 
					PK_ID = '$unterkunft_id'
				  ";

  		$res = mysql_query($query, $link);
  		
  		if (!$res){
  			return false;
  		}
		else{		
			$d = mysql_fetch_array($res);
		}
	
		$email = $d["Email"];
		if (isset($email) && $email != ""){
			return true;
		}
 
 	return false;
 }
 
 /**
 * liefert die währung einer unterkunft
 */
 function getWaehrung($unterkunft_id){
 	global $link;
 		
		$query = "select 
					Waehrung 
					from 
					Rezervi_Unterkunft 
					where 
					PK_ID = '$unterkunft_id'
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
		else		
			$d = mysql_fetch_array($res);
	
		return $d["Waehrung"];
 }
 /**
 * speichert die währung einer unterkunft
 */
 function setWaehrung($unterkunft_id,$waehrung){
 		global $link;
 		$query = "UPDATE 
					Rezervi_Unterkunft 
					SET 
					Waehrung = '$waehrung' 
					where 
					PK_ID = '$unterkunft_id'
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
 	
 }
//--------------------------------------------
//funktion gibt die anzahl der zimmer der unterkunft zurück
function getAnzahlZimmer($unterkunft_id,$link){
	
		$query = "select 
					AnzahlZimmer 
					from 
					Rezervi_Unterkunft 
					where 
					PK_ID = '$unterkunft_id'
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
		else		
			$d = mysql_fetch_array($res);
	
		return $d["AnzahlZimmer"];
		
} //ende getAnzahlZimmer

//--------------------------------------------
//funktion gibt die zimmerart zurück
function getZimmerart_EZ($unterkunft_id,$link){	

		$query = "select 
					Zimmerart_EZ 
					from 
					Rezervi_Unterkunft 
					where 
					PK_ID = '$unterkunft_id' 
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
		else		
			$d = mysql_fetch_array($res);
			
			return $d["Zimmerart_EZ"];
			
} //ende getZimmerart_EZ

//--------------------------------------------
//funktion gibt die zimmerart zurück
function getZimmerart_MZ($unterkunft_id,$link){
	
		$query = "select 
					Zimmerart_MZ 
					from 
					Rezervi_Unterkunft 
					where 
					PK_ID = '$unterkunft_id'
				  ";	

  		$res = mysql_query($query, $link);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
		else		
			$d = mysql_fetch_array($res);
	
		return $d["Zimmerart_MZ"];
		
} //ende getZimmerart_MZ

function getAnzahlBenutzer($unterkunft_id,$link){
	
		$query = "select 
					AnzahlBenutzer 
					from 
					Rezervi_Unterkunft 
					where 
					PK_ID = '$unterkunft_id'
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
		else		
			$d = mysql_fetch_array($res);
	
		return $d["AnzahlBenutzer"];
		
} //ende getAnzahlBenutzer

//--------------------------------------------
//funktion gibt das kindesalter der unterkunft zurück
function getKindesalter($unterkunft_id,$link){
	
		$query = "select 
					Kindesalter
					from
					Rezervi_Unterkunft 
					where 
					PK_ID = '$unterkunft_id'
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
		else		
			$d = mysql_fetch_array($res);
	
		return $d["Kindesalter"];
		
} //ende getUnterkunftName

//--------------------------------------------
//funktion gibt namen der unterkunft zurück, 
//übergeben wird die id der unterkuft und der
//link zur datenbank
//die datenbank muss dazu geöffnet sein.
function getUnterkunftName($unterkunft_id,$link){

	//unterkunft-name aus datenbank auslesen:
		$d = "";	
		$query = "select 
					Name 
					from 
					Rezervi_Unterkunft 
					where 
					PK_ID = '$unterkunft_id'
				   ";

  		$res = mysql_query($query, $link);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
		else		
			$d = mysql_fetch_array($res);
	
		return $d["Name"];
} //ende getUnterkunftName

//--------------------------------------------
//funktion gibt namen der unterkunft zurück, 
//übergeben wird die id der unterkuft und der
//link zur datenbank
//die datenbank muss dazu geöffnet sein.
function getUnterkunftEmail($unterkunft_id,$link){

	//unterkunft-email aus datenbank auslesen:
		$d = "";	
		$query = "select 
					Email 
					from 
					Rezervi_Unterkunft 
					where 
					PK_ID = '$unterkunft_id'
				   ";

  		$res = mysql_query($query, $link);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
		else		
			$d = mysql_fetch_array($res);
	
		return $d["Email"];
} //ende getUnterkunftEmail

function getUnterkunftStrasse($unterkunft_id,$link){

		$query = "select 
					Strasse 
					from 
					Rezervi_Unterkunft 
					where 
					PK_ID = '$unterkunft_id'
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
		else		
			$d = mysql_fetch_array($res);
	
		return $d["Strasse"];
				
} 

function getUnterkunftPlz($unterkunft_id,$link){

		$query = "select 
					PLZ 
					from 
					Rezervi_Unterkunft 
					where 
					PK_ID = '$unterkunft_id'
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
		else		
			$d = mysql_fetch_array($res);
	
		return $d["PLZ"];
				
} 

function getUnterkunftOrt($unterkunft_id,$link){

		$query = "select 
					Ort 
					from 
					Rezervi_Unterkunft 
					where 
					PK_ID = '$unterkunft_id'
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
		else		
			$d = mysql_fetch_array($res);
	
		return $d["Ort"];
				
} 

function getUnterkunftLand($unterkunft_id,$link){

		$query = "select 
					Land 
					from 
					Rezervi_Unterkunft 
					where 
					PK_ID = '$unterkunft_id'
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
		else		
			$d = mysql_fetch_array($res);
	
		return $d["Land"];
				
} 

function getUnterkunftTel($unterkunft_id,$link){

		$query = "select 
					Tel 
					from 
					Rezervi_Unterkunft 
					where 
					PK_ID = '$unterkunft_id'
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
		else		
			$d = mysql_fetch_array($res);
	
		return $d["Tel"];
				
} 

function getUnterkunftTel2($unterkunft_id,$link){

		$query = "select 
					Tel2 
					from 
					Rezervi_Unterkunft 
					where 
					PK_ID = '$unterkunft_id'
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
		else		
			$d = mysql_fetch_array($res);
	
		return $d["Tel2"];
				
} 

function getUnterkunftFax($unterkunft_id,$link){

		$query = "select 
					Fax 
					from 
					Rezervi_Unterkunft 
					where 
					PK_ID = '$unterkunft_id'
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
		else		
			$d = mysql_fetch_array($res);
	
		return $d["Fax"];
				
} 

function getUnterkunftArt($unterkunft_id,$link){

		$query = "select 
					Art 
					from 
					Rezervi_Unterkunft 
					where 
					PK_ID = '$unterkunft_id'
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
		else		
			$d = mysql_fetch_array($res);
	
		return $d["Art"];
				
} 

///////////////////////////////////////////////////////////////
// update Methoden:
//////////////////////////////////////////////////////////////

function setAnzahlZimmer($unterkunft_id,$anzahlZimmer,$link){
	
		$query = "UPDATE 
					Rezervi_Unterkunft 
					SET 
					AnzahlZimmer = '$anzahlZimmer' 
					where 
					PK_ID = '$unterkunft_id'
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
		
} //ende setAnzahlZimmer

function setAnzahlBenutzer($unterkunft_id,$anzahlBenutzer,$link){
	
		$query = "UPDATE 
					Rezervi_Unterkunft 
					SET 
					AnzahlBenutzer = '$anzahlBenutzer' 
					where 
					PK_ID = '$unterkunft_id'
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
		
} //ende setAnzahlBenutzer

function setKindesalter($unterkunft_id,$kindesalter,$link){
	
		$query = "UPDATE 
					Rezervi_Unterkunft 
					SET 
					Kindesalter = '$kindesalter' 
					where 
					PK_ID = '$unterkunft_id'
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
		
} //ende setKindesalter

function setUnterkunftName($unterkunft_id,$name,$link){

		$query = "UPDATE 
					Rezervi_Unterkunft 
					SET 
					Name = '$name' 
					where 
					PK_ID = '$unterkunft_id'
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
			
} //ende setUnterkunftName

function setUnterkunftEmail($unterkunft_id,$email,$link){

		$query = "UPDATE 
					Rezervi_Unterkunft 
					SET 
					Email = '$email' 
					where 
					PK_ID = '$unterkunft_id'
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
			
} //ende setUnterkunftEmail

function setUnterkunftStrasse($unterkunft_id,$strasse,$link){

		$query = "UPDATE 
					Rezervi_Unterkunft 
					SET 
					Strasse = '$strasse' 
					where 
					PK_ID = '$unterkunft_id'
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
				
} 

function setUnterkunftPlz($unterkunft_id,$plz,$link){

		$query = "UPDATE 
					Rezervi_Unterkunft 
					SET 
					PLZ = '$plz' 
					where 
					PK_ID = '$unterkunft_id'
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
				
} 

function setUnterkunftOrt($unterkunft_id,$ort,$link){

		$query = "UPDATE 
					Rezervi_Unterkunft 
					SET 
					Ort = '$ort' 
					where 
					PK_ID = '$unterkunft_id'
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
				
} 

function setUnterkunftLand($unterkunft_id,$land,$link){

		$query = "UPDATE 
					Rezervi_Unterkunft 
					SET 
					Land = '$land' 
					where 
					PK_ID = '$unterkunft_id'
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
				
} 


function setUnterkunftTel($unterkunft_id,$tel,$link){

		$query = "UPDATE 
					Rezervi_Unterkunft 
					SET 
					Tel = '$tel' 
					where 
					PK_ID = '$unterkunft_id'
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
			
} 

function setUnterkunftTel2($unterkunft_id,$tel2,$link){

		$query = "UPDATE 
					Rezervi_Unterkunft 
					SET 
					Tel2 = '$tel2' 
					where 
					PK_ID = '$unterkunft_id'
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
				
} 

function setUnterkunftFax($unterkunft_id,$fax,$link){

		$query = "UPDATE 
					Rezervi_Unterkunft 
					SET 
					Fax = '$fax' 
					where 
					PK_ID = '$unterkunft_id'
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
				
} 

function setUnterkunftArt($unterkunft_id,$art,$link){

		$query = "UPDATE 
					Rezervi_Unterkunft 
					SET 
					Art = '$art' 
					where 
					PK_ID = '$unterkunft_id'
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
				
}

/**
speichert die zimmerart (einzahl)
*/
function setZimmerArt_EZ($unterkunft_id,$zimmerart,$link){
		
		$query = "UPDATE 
					Rezervi_Unterkunft 
					SET 
					Zimmerart_EZ = '$zimmerart' 
					where 
					PK_ID = '$unterkunft_id'
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  			echo(mysql_error($link));
  		}
  		else{
  			return true;
  		}
  		
}

/**
speichert die zimmerart (mehrzahl)
*/
function setZimmerArt_MZ($unterkunft_id,$zimmerart,$link){
		
		$query = "UPDATE 
					Rezervi_Unterkunft 
					SET 
					Zimmerart_MZ = '$zimmerart' 
					where 
					PK_ID = '$unterkunft_id'
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  			echo(mysql_error($link));
  		}
  		else{
  			return true;
  		}
  		
}

?>