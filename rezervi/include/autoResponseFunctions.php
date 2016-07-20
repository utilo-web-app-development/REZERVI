<?php

/**********************************************************************
Funktionen zur Bearbeitung der automatischen Antworten an einen Gast.
Autor: Christian Osterrieder utilo.eu
Projekt: Rezervi Belegungsplan und Kundendatenbank
**********************************************************************/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 

define("AUTO_RESPONSE_ABLEHNUNG","ablehnung");
define("AUTO_RESPONSE_BESTAETIGUNG","bestaetigung");
define("AUTO_RESPONSE_ANFRAGE","anfrage");

function sendMessage($gast_id,$art){
	
	 global $link;
	 global $unterkunft_id;
	 global $root;
	 global $sprache;
	 
	 include_once($root."/include/gastFunctions.php");
	 include_once($root."/include/propertiesFunctions.php");
	 include_once($root."/include/mail.inc.php");
	 include_once($root."/include/uebersetzer.php");
	 include_once($root."/include/unterkunftFunctions.php");
	 
	 $speech = getGuestSprache($gast_id,$link);
	 $gastName = getGuestNachname($gast_id,$link);
	 $an = getGuestEmail($gast_id,$link);
	 $von = getUnterkunftEmail($unterkunft_id,$link);		
	 $subject = getUebersetzungUnterkunft(getMessageSubject($unterkunft_id,$art,$link),$speech,$unterkunft_id,$link);
	 $anr = getUebersetzungUnterkunft(getMessageAnrede($unterkunft_id,$art,$link),$speech,$unterkunft_id,$link);
	 $message = $anr.(" ").($gastName).("!\n\n");
	 $bod = getUebersetzungUnterkunft(getMessageBody($unterkunft_id,$art,$link),$speech,$unterkunft_id,$link);
	 $message .= $bod.("\n\n");
	 $unt = getUebersetzungUnterkunft(getMessageUnterschrift($unterkunft_id,$art,$link),$speech,$unterkunft_id,$link);
	 $message .= $unt;
	
	//mail absenden:  
	 	
	sendMail($von,$an,$subject,$message);

    if (getPropertyValue(MAIL_KOPIE_AN_VERMIETER_ABLEHNUNG,$unterkunft_id,$link) == "true"){
		$message = getUebersetzung("Folgende Nachricht wurde an ihren Gast versendet",$sprache,$link).":\n\n".$message;
		sendMail($von,$von,$subject,$message);
 
	}
	
}

function getMessageSubject($unterkunft_id,$art,$link){

		$query = "select 
				  Subject
				  from
				  Rezervi_Auto_Response
				  where
				  Art = '$art'
				  AND
				  FK_Unterkunft_ID = '$unterkunft_id'
				 ";

  		$res = mysqli_query($link, $query);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
		else		
			$d = mysqli_fetch_array($res);
				
		$uebers = $d["Subject"];
		if (!isset($uebers) || $uebers == "NULL" || $uebers == ""){
			return "";
		}
		else
			return $uebers;

}

function getMessageBody($unterkunft_id,$art,$link){

		$query = "select 
				  Body
				  from
				  Rezervi_Auto_Response
				  where
				  Art = '$art'
				  AND
				  FK_Unterkunft_ID = '$unterkunft_id'
				 ";

  		$res = mysqli_query($link, $query);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
		else		
			$d = mysqli_fetch_array($res);
				
		$uebers = $d["Body"];
		if (!isset($uebers) || $uebers == "NULL" || $uebers == ""){
			return "";
		}
		else
			return $uebers;

}

function getMessageUnterschrift($unterkunft_id,$art,$link){

		$query = "select 
				  Unterschrift
				  from
				  Rezervi_Auto_Response
				  where
				  Art = '$art'
				  AND
				  FK_Unterkunft_ID = '$unterkunft_id'
				 ";

  		$res = mysqli_query($link, $query);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
		else		
			$d = mysqli_fetch_array($res);
				
		$uebers = $d["Unterschrift"];
		if (!isset($uebers) || $uebers == "NULL" || $uebers == ""){
			return "";
		}
		else
			return $uebers;

}

function getMessageAnrede($unterkunft_id,$art,$link){

		$query = "select 
				  Anrede
				  from
				  Rezervi_Auto_Response
				  where
				  Art = '$art'
				  AND
				  FK_Unterkunft_ID = '$unterkunft_id'
				 ";

  		$res = mysqli_query($link, $query);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
		else		
			$d = mysqli_fetch_array($res);
				
		$uebers = $d["Anrede"];
		if (!isset($uebers) || $uebers == "NULL" || $uebers == ""){
			return "";
		}
		else
			return $uebers;

}

function getMessageID($unterkunft_id,$art,$link){

		$query = "select 
				  PK_ID
				  from
				  Rezervi_Auto_Response
				  where
				  Art = '$art'
				  AND
				  FK_Unterkunft_ID = '$unterkunft_id'
				 ";

  		$res = mysqli_query($link, $query);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
		else		
			$d = mysqli_fetch_array($res);
				
		$uebers = $d["PK_ID"];
		if (!isset($uebers) || $uebers == "NULL" || $uebers == ""){
			return -1;
		}
		else
			return $uebers;

}

function isMessageActive($unterkunft_id,$art,$link){

		$query = "select 
				  aktiviert
				  from
				  Rezervi_Auto_Response
				  where
				  Art = '$art'
				  AND
				  FK_Unterkunft_ID = '$unterkunft_id'
				 ";

  		$res = mysqli_query($link, $query);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
		else		
			$d = mysqli_fetch_array($res);
				
		$uebers = $d["aktiviert"];
		if (!isset($uebers) || $uebers == 0 || $uebers == "NULL" || $uebers == ""){
			return false;
		}
		else{
			return true;
		}

}

function setMessage($unterkunft_id,$art,$subject,$body,$unterschrift,$anrede,$link){

		$query = ("insert into 
				Rezervi_Auto_Response
				(FK_Unterkunft_ID,Subject,Body,Unterschrift,Art,Anrede)
				VALUES				
				('$unterkunft_id','$subject','$body','$unterschrift','$art','$anrede')
			  ");
				  
		$res = mysqli_query($link, $query);
		if (!$res){  
			echo("die Anfrage $query scheitert");
			return false;
		}
	return true;
}

function changeMessage($unterkunft_id,$art,$subject,$body,$unterschrift,$anrede,$link){
	//falls noch nicht vorhanden - setzen:
	$id = getMessageID($unterkunft_id,$art,$link);
	if ($id == -1){
		return setMessage($unterkunft_id,$art,$subject,$body,$unterschrift,$anrede,$link);
	}
	else{
			//Ändern des textes in der datenbank:
		$query = "UPDATE 
				Rezervi_Auto_Response 
				SET 
				Subject = '$subject',
				Body = '$body',
				Unterschrift = '$unterschrift',
				Anrede = '$anrede'
				where 
				PK_ID = '$id'
			  ";
	
			$res = mysqli_query($link, $query);
			if (!$res){
				echo("Anfrage $query scheitert.");
				return false;
			}
	}

	return true;
}

function setMessageActive($unterkunft_id,$art,$link){
		
	$query = "UPDATE 
			Rezervi_Auto_Response 
			SET 
			aktiviert = 1
			where 
			FK_Unterkunft_ID = '$unterkunft_id'
			AND
			Art = '$art'
		  ";

		$res = mysqli_query($link, $query);
		if (!$res){
			echo("Anfrage $query scheitert.");
			return false;
		}
	

	return true;
}

function setMessageInactive($unterkunft_id,$art,$link){
		
	$query = "UPDATE 
			Rezervi_Auto_Response 
			SET 
			aktiviert = 0
			where 
			FK_Unterkunft_ID = '$unterkunft_id'
			AND
			Art = '$art'
		  ";

		$res = mysqli_query($link, $query);
		if (!$res){
			echo("Anfrage $query scheitert.");
			return false;
		}
	

	return true;
}



?>