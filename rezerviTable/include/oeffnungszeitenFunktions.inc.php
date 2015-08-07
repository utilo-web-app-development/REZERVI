<?php
/*
 * Created on 24.09.2007
 * Author: LI Haitao
 * Company: Alpstein-Austria
 * Ausgabe aller Tischkarten
 *  
 */
 
 //
 
function getOeffnungszeitID(){
	
	global $db;
	global $gastro_id;
	if (empty($db) || empty($gastro_id)){
		die("Globale Variable fehlt.");
	}	
			
	$query = "select OEFFNUNGSZEITEN_ID from  BOOKLINE_OEFFNUNGSZEITEN
	  			where
		  			GASTRO_ID = '$gastro_id'	
	 		 ";
  	$res = $db->Execute($query);
 	if (!$res){
 		print $db->ErrorMsg();
 		return false;
 	}else{	
		return $res;
	}
}

function getOeffnungszeit($oeffnungszeiten_id){
	
	global $db;
	global $gastro_id;
	if (empty($db) || empty($gastro_id)){
		die("Globale Variable fehlt.");
	}	
			
	$query = "select * from  BOOKLINE_OEFFNUNGSZEITEN
	  			where
		  			GASTRO_ID = '$gastro_id'
		  			and
		  			OEFFNUNGSZEITEN_ID = '$oeffnungszeiten_id'		
	 		 ";
  	$res = $db->Execute($query);
 	if (!$res){
 		print $db->ErrorMsg();
 		return false;
 	}else{	
		return $res;
	}
}

function setOeffnungszeit($oeffnungszeiten_id, $von, $bis, $type){
	
	global $db;
	global $gastro_id;
	if (empty($db) || empty($gastro_id)){
		die("Globale Variable fehlt.");
	}	
	if (empty($oeffnungszeiten_id)){
		die ("open time id failes!");
	}
	
	$temp = getOeffnungszeit($oeffnungszeiten_id);
	
	if ($temp === FALSE){
		$query = ("INSERT INTO BOOKLINE_OEFFNUNGSZEITEN
		   			(OEFFNUNGSZEITEN_ID, VON, BIS, TYPE, GASTRO_ID)
		   			VALUES
		   			($oeffnungszeiten_id, $von, $bis, $type, $gastro_id)
		  		 ");     
	}
	else{
		$query = ("UPDATE BOOKLINE_OEFFNUNGSZEITEN
		   			SET
			  			VON = '$von'
			  			and
			  			BIS = '$bis'
			   			and
			  			TYPE = '$type'
		  			where
		   				GASTRO_ID = '$gastro_id'
			  			and
			  			OEFFNUNGSZEITEN_ID = '$oeffnungszeiten_id'	
		  		 ");  
	}
	
	$res = $db->Execute($query);
	
	if (!$res) { 		 
		print $db->ErrorMsg();
		die ("<br/>Die Anfrage <br/>$query<br/> scheiterte.");
	}
	else{
		return true;
	}
}
?>
