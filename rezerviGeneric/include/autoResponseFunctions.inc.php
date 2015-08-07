<?php

/**
 * konstanten fuer arten von automatischen nachrichten:
 */
define("BUCHUNGS_BESTAETIGUNG","bestaetigung"); 
define("BUCHUNGS_ABLEHNUNG","ablehnung");
define("ANFRAGE_BESTAETIGUNG","anfrage");
define("NEWSLETTER","emails");

/**
 * author:coster
 * date: 7.10.05
 * liefert den betreff einer automatischen antwort
 * */
function getMessageSubject($vermieter_id,$bezeichnung){
	
		global $link;

		$query = "select 
				  SUBJECT
				  from
				  REZ_GEN_ANTWORTEN
				  where
				  BEZEICHNUNG = '$bezeichnung'
				  AND
				  VERMIETER_ID = '$vermieter_id'
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  			echo(mysql_error($link));
  			return false;
  		}
		else{		
			$d = mysql_fetch_array($res);				
			$uebers = $d["SUBJECT"];
			if (!isset($uebers) || $uebers == "NULL" || $uebers == ""){
				return false;
			}
			else
				return $uebers;
			}

}
/**
 * author:coster
 * date: 7.10.05
 * liefert den text einer nachricht
 * */
function getMessageBody($vermieter_id,$bezeichnung){

		global $link;
		
		$query = "select 
				  BODY	
				  from
				  REZ_GEN_ANTWORTEN
				  where
				  BEZEICHNUNG = '$bezeichnung'
				  AND
				  VERMIETER_ID = '$vermieter_id'
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  			echo(mysql_error($link));
  			return false;
  		}
		else{
			$d = mysql_fetch_array($res);				
			$uebers = $d["BODY"];
			if (!isset($uebers) || $uebers == "NULL" || $uebers == ""){
				return false;
			}
			else{
				return $uebers;
			}
		}
}
/**
 * author:coster
 * date:7.10.05
 * liefert die unterschrift einer nachricht
 * */
function getMessageUnterschrift($vermieter_id,$bezeichnung){

		global $link;
		
		$query = "select 
				  UNTERSCHRIFT
				  from
				  REZ_GEN_ANTWORTEN
				  where
				  BEZEICHNUNG = '$bezeichnung'
				  AND
				  VERMIETER_ID = '$vermieter_id'
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  			echo(mysql_error($link));
  			return false;
  		}
		else {
			$d = mysql_fetch_array($res);				
			$uebers = $d["UNTERSCHRIFT"];
			if (!isset($uebers) || $uebers == "NULL" || $uebers == ""){
				return false;
			}
			else{
				return $uebers;
			}
		}

}
/**
 * author:coster
 * date:7.10.05
 * liefert die anrede einer nachricht z. b. "sehr geehrte damen und herren"
 * */
function getMessageAnrede($vermieter_id,$bezeichnung){

		global $link;
		
		$query = "select 
				  ANREDE
				  from
				  REZ_GEN_ANTWORTEN
				  where
				  BEZEICHNUNG = '$bezeichnung'
				  AND
				  VERMIETER_ID = '$vermieter_id'
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  			echo(mysql_error($link));
  			return false;
  		}
		else{	
			$d = mysql_fetch_array($res);					
			$uebers = $d["ANREDE"];
			if (!isset($uebers) || $uebers == "NULL" || $uebers == ""){
				return false;
			}
			else{
				return $uebers;
			}
		}

}
/**
 * author:coster
 * date:7.10.05
 * liefert die Id einer nachricht
 * */
function getMessageID($vermieter_id,$bezeichnung){

		global $link;
		
		$query = "select 
				  ANTWORTEN_ID
				  from
				  REZ_GEN_ANTWORTEN
				  where
				  BEZEICHNUNG = '$bezeichnung'
				  AND
				  VERMIETER_ID = '$vermieter_id'
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  			echo(mysql_error($link));
  			return false;
  		}
		else{
			$d = mysql_fetch_array($res);				
			$uebers = $d["ANTWORTEN_ID"];
			if (!isset($uebers) || $uebers == "NULL" || $uebers == ""){
				return false;
			}
			else{
				return $uebers;
			}
		}

}
/**
 * author:coster
 * date:7.10.05
 * prueft ob eine nachricht aktiviert ist
 * */
function isMessageActive($vermieter_id,$bezeichnung){

		global $link;
		
		$query = "select 
				  AKTIV
				  from
				  REZ_GEN_ANTWORTEN
				  where
				  BEZEICHNUNG = '$bezeichnung'
				  AND
				  VERMIETER_ID = '$vermieter_id'
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  			echo(mysql_error($link));
  			return false;
  		}
		else{
			$d = mysql_fetch_array($res);				
			$uebers = $d["AKTIV"];
			if (!isset($uebers) || $uebers == 0 || $uebers == "NULL" || $uebers == ""){
				return false;
			}
			else{
				return true;
			}
		}

}
/**
 * author:coster
 * date:7.10.05
 * speichert eine nachricht
 * */
function setMessage($vermieter_id,$bezeichnung,$subject,$body,$unterschrift,$anrede){

		global $link;
		
		$query = ("insert into 
				REZ_GEN_ANTWORTEN
				(VERMIETER_ID,SUBJECT,BODY,UNTERSCHRIFT,BEZEICHNUNG,ANREDE)
				VALUES				
				('$vermieter_id','$subject','$body','$unterschrift','$bezeichnung','$anrede')
			  ");
				  
		$res = mysql_query($query, $link);	
		if (!$res){  
			echo("die Anfrage $query scheitert");
			echo(mysql_error($link));
			return false;
		}
		
	return true;
	
}
/**
 * author:coster
 * date:7.10.05
 * aendert eine nachricht, falls diese noch nicht vorhanden ist, wird sie neu angelegt
 * */
function changeMessage($vermieter_id,$bezeichnung,$subject,$body,$unterschrift,$anrede){
	
	global $link;
	
	//falls noch nicht vorhanden - setzen:
	$id = getMessageID($vermieter_id,$bezeichnung);
	if ($id == false){
		return setMessage($vermieter_id,$bezeichnung,$subject,$body,$unterschrift,$anrede);
	}
	else{

		$query = "UPDATE 
				REZ_GEN_ANTWORTEN 
				SET 
				SUBJECT = '$subject',
				BODY = '$body',
				UNTERSCHRIFT = '$unterschrift',
				ANREDE = '$anrede'
				where 
				ANTWORTEN_ID = '$id'
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

}
/**
 * author:coster
 * date:7.10.05
 * setzt eine nachricht als Aktiv
 * */
function setMessageActive($vermieter_id,$bezeichnung){
	
	global $link;
	
	$query = "UPDATE 
			REZ_GEN_ANTWORTEN 
			SET 
			AKTIV = 1
			where 
			VERMIETER_ID = '$vermieter_id'
			AND
			BEZEICHNUNG = '$bezeichnung'
		  ";

		$res = mysql_query($query, $link);
		if (!$res){
			echo("Anfrage $query scheitert.");
			echo(mysql_error($link));
			return false;
		}	

	return true;
}
/**
 * author:coster
 * date:7.10.05
 * setzt eine nachricht als Inaktiv
 * */
function setMessageInactive($vermieter_id,$bezeichnung){
		
	global $link;
		
	$query = "UPDATE 
			REZ_GEN_ANTWORTEN 
			SET 
			AKTIV = 0
			where 
			VERMIETER_ID = '$vermieter_id'
			AND
			BEZEICHNUNG = '$bezeichnung'
		  ";

		$res = mysql_query($query, $link);
		if (!$res){
			echo("Anfrage $query scheitert.");
			echo(mysql_error($link));
			return false;
		}	

	return true;
}

?>