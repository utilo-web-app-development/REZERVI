<?php

/**
 * konstanten fuer arten von automatischen nachrichten:
 */
define("BUCHUNGS_BESTAETIGUNG","bestaetigung"); 
define("BUCHUNGS_ABLEHNUNG","ablehnung");
define("ANFRAGE_BESTAETIGUNG","anfrage");
define("NEWSLETTER","emails");
// Texte werden mit einem Schlüssel = TYPE gespeichert.
// der Schlüssel setzt sich aus der Art der Nachricht + Subject, Body, etc. zusammen
define("SUBJECT","subject");
define("BODY","body");
define("SIGN","unterschrift");
define("TITLE","anrede");
//eine nachricht setzt sich aus allen typen zusammen:
$MESSAGE = array(SUBJECT,BODY,SIGN,TITLE);

/**
 * author:coster
 * date: 7.10.05
 * liefert den betreff einer automatischen antwort
 * */
function getMessageSubject($gastro_id,$bezeichnung){
	
		global $db;

		$query = "select 
				  TEXT
				  from
				  BOOKLINE_ANTWORTEN
				  where
				  TYPE = '".$bezeichnung.SUBJECT."'
				  AND
				  GASTRO_ID = '$gastro_id'
				 ";

  		$res = $db->Execute($query);
  		if (!$res){
  			
  			print $db->ErrorMsg();
  			return false;
  		}
		else{		
			$d = $res->FetchNextObject();
			if (!empty($d)){				
				$uebers = $d->TEXT;
				if (!isset($uebers) || $uebers == "NULL" || $uebers == ""){
				}
				else{
					return $uebers;
				}
			}
		}
		return false;
}
/**
 * author:coster
 * date: 7.10.05
 * liefert den text einer nachricht
 * */
function getMessageBody($gastro_id,$bezeichnung){

		global $db;
		
		$query = "select 
				  TEXT	
				  from
				  BOOKLINE_ANTWORTEN
				  where
				  TYPE = '".$bezeichnung.BODY."'
				  AND
				  GASTRO_ID = '$gastro_id'
				 ";

  		$res = $db->Execute($query);
  		if (!$res){  			
  			print $db->ErrorMsg();
  			return false;
  		}
		else{
			$d = $res->FetchNextObject();		
			if (!empty($d)){		
				$uebers = $d->TEXT;
				if (!isset($uebers) || $uebers == "NULL" || $uebers == ""){					
				}
				else{
					return $uebers;
				}
			}
		}
		return false;
}
/**
 * author:coster
 * date:7.10.05
 * liefert die unterschrift einer nachricht
 * */
function getMessageUnterschrift($gastro_id,$bezeichnung){

		global $db;
		
		$query = "select 
				  TEXT
				  from
				  BOOKLINE_ANTWORTEN
				  where
				  TYPE = '".$bezeichnung.SIGN."'
				  AND
				  GASTRO_ID = '$gastro_id'
				 ";

  		$res = $db->Execute($query);
  		if (!$res){
  			
  			print $db->ErrorMsg();
  			return false;
  		}
		else {
			$d = $res->FetchNextObject();
			if (!empty($d)){				
				$uebers = $d->TEXT;
				if (!isset($uebers) || $uebers == "NULL" || $uebers == ""){
					
				}
				else{
					return $uebers;
				}
			}
		}
	return false;
}
/**
 * author:coster
 * date:7.10.05
 * liefert die anrede einer nachricht z. b. "sehr geehrte damen und herren"
 * */
function getMessageAnrede($gastro_id,$bezeichnung){

		global $db;
		
		$query = "select 
				  TEXT
				  from
				  BOOKLINE_ANTWORTEN
				  where
				  TYPE = '".$bezeichnung.TITLE."'
				  AND
				  GASTRO_ID = '$gastro_id'
				 ";

  		$res = $db->Execute($query);
  		if (!$res){
  			
  			print $db->ErrorMsg();
  			return false;
  		}
		else{	
			$d = $res->FetchNextObject();	
			if (!empty($d)){				
				$uebers = $d->TEXT;
				if (!isset($uebers) || $uebers == "NULL" || $uebers == ""){					
				}
				else{
					return $uebers;
				}
			}
		}
	return false;
}
/**
 * author:coster
 * date:7.10.05
 * liefert die Id einer nachricht
 * */
function getMessageID($gastro_id,$art,$typ){

		global $db;
		
		$query = "select 
				  ANTWORTEN_ID
				  from
				  BOOKLINE_ANTWORTEN
				  where
				  TYPE = '".$art.$typ."'
				  AND
				  GASTRO_ID = '$gastro_id'
				 ";

  		$res = $db->Execute($query);
  		if (!$res){
  			
  			print $db->ErrorMsg();
  			return false;
  		}
		else{
			$d = $res->FetchNextObject();	
			if (!empty($d)){			
				$uebers = $d->ANTWORTEN_ID;
				if (!isset($uebers) || $uebers == "NULL" || $uebers == ""){					
				}
				else{
					return $uebers;
				}
			}
		}
	return false;
}
/**
 * author:coster
 * date:7.10.05
 * prueft ob eine nachricht aktiviert ist
 * */
function isMessageActive($gastro_id,$bezeichnung){

		global $db;
		
		$query = "select 
				  AKTIV
				  from
				  BOOKLINE_ANTWORTEN
				  where
				  TYPE = '".$bezeichnung.BODY."'
				  AND
				  GASTRO_ID = '$gastro_id'
				 ";

  		$res = $db->Execute($query);
  		if (!$res){
  			
  			print $db->ErrorMsg();
  			return false;
  		}
		else{
			$d = $res->FetchNextObject();	
			if (empty($d)){
				return false;
			}			
			$uebers = $d->AKTIV;
			if (!isset($uebers) || $uebers == 0 || $uebers == "NULL" || $uebers == ""){
				return false;
			}
			else{
				return true;
			}
		}

}
function storeNachricht($text,$art,$type,$aktiv,$gastro_id){
		global $db;
		
		$query = ("insert into 
				BOOKLINE_ANTWORTEN
				(TEXT,TYPE,AKTIV,GASTRO_ID)
				VALUES				
				('$text','".$art.$type."','$aktiv','$gastro_id')
			  ");
				  
		$res = $db->Execute($query);	
		if (!$res){		
			print $db->ErrorMsg();
			return false;
		}
		return true;
}
/**
 * author:coster
 * date:7.10.05
 * speichert eine nachricht
 * */
function setMessage($gastro_id,$subject,$body,$unterschrift,$anrede,$aktiv,$art){

	if (!storeNachricht($body,$art,BODY,$aktiv,$gastro_id)){
		return false;
	}
	if (!storeNachricht($subject,$art,SUBJECT,$aktiv,$gastro_id)){
		return false;
	}
	if (!storeNachricht($unterschrift,$art,SIGN,$aktiv,$gastro_id)){
		return false;
	}
	if (!storeNachricht($anrede,$art,TITLE,$aktiv,$gastro_id)){
		return false;
	}	
		
	return true;
	
}
function changeNachricht($text,$art,$type,$aktiv,$gastro_id){
	
	global $db;
	
	//falls noch nicht vorhanden - setzen:
	$id = getMessageID($gastro_id,$art,$type);
	if ($id == false){
		return storeNachricht($text,$art,$type,$aktiv,$gastro_id);
	}
	else{

		$query = "UPDATE 
				BOOKLINE_ANTWORTEN 
				SET 
				TEXT = '$text',
				TYPE = '".$art.$type."'
				where 
				ANTWORTEN_ID = '$id'
			  ";
	
			$res = $db->Execute($query);
			if (!$res){				
				print $db->ErrorMsg();
				return false;
			}
			
		return true;
			
	}
}
/**
 * author:coster
 * date:7.10.05
 * aendert eine nachricht, falls diese noch nicht vorhanden ist, wird sie neu angelegt
 * */
function changeMessage($gastro_id,$subject,$body,$unterschrift,$anrede,$aktiv,$art){
	
	if (!changeNachricht($body,$art,BODY,$aktiv,$gastro_id)){
		return false;
	}
	if (!changeNachricht($subject,$art,SUBJECT,$aktiv,$gastro_id)){
		return false;
	}
	if (!changeNachricht($unterschrift,$art,SIGN,$aktiv,$gastro_id)){
		return false;
	}
	if (!changeNachricht($anrede,$art,TITLE,$aktiv,$gastro_id)){
		return false;
	}	
		
	return true;

}
/**
 * author:coster
 * date:7.10.05
 * setzt eine nachricht als Aktiv
 * */
function setMessageActive($gastro_id,$art,$type){
	
	global $db;
	
	$query = "UPDATE 
			BOOKLINE_ANTWORTEN 
			SET 
			AKTIV = 1
			where 
			GASTRO_ID = '$gastro_id'
			AND
			TYPE = '".$art.$type."'
		  ";

		$res = $db->Execute($query);
		if (!$res){			
			print $db->ErrorMsg();
			return false;
		}	

	return true;
}
/**
 * @author:coster
 * @date:17.7.2007
 * setzt eine nachricht als Aktiv
 * */
function setMessagesActive($gastro_id,$art){
	global $MESSAGE;
	for($i=0; $i<count($MESSAGE); $i++){
		if (!setMessageActive($gastro_id,$art,$MESSAGE[$i])){
			return false;
		}
	}
	return true;
}
/**
 * author:coster
 * date:7.10.05
 * setzt eine nachricht als Inaktiv
 * */
function setMessageInactive($gastro_id,$art,$type){
		
	global $db;
		
	$query = "UPDATE 
			BOOKLINE_ANTWORTEN 
			SET 
			AKTIV = 0
			where 
			GASTRO_ID = '$gastro_id'
			AND
			TYPE = '".$art.$type."'
		  ";

		$res = $db->Execute($query);
		if (!$res){			
			print $db->ErrorMsg();
			return false;
		}	

	return true;
}
/**
 * @author:coster
 * @date:17.7.2007
 * setzt eine nachricht als inaktiv
 * */
function setMessagesInactive($gastro_id,$art){
	global $MESSAGE;
	foreach($MESSAGE as $type){
		if (!setMessageInactive($gastro_id,$art,$type)){
			return false;
		}
	}
	return true;
}
?>