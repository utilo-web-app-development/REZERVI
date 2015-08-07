<?php 

define("LIMIT_UEBERSETZUNGEN",10);

/**
 * author:coster
 * date: 14.10.05
 * aendert eine uebersetzung
 * */
function changeUebersetzung($standardtext,$text,$sprache){
	
		global $db;
		global $gastro_id;
		if (empty($db) || empty($gastro_id)){
			die("Globale Variable fehlt.");
		}
		
				
		$query = "update
		  BOOKLINE_UEBERSETZUNGEN_FRONTPAGE
		  set
		  TEXT = '$text'
		  where
		  GASTRO_ID = '$gastro_id'
		  and
		  TEXT_STANDARD = '$standardtext'" .
		  		" and SPRACHE_ID = '$sprache'
		 ";

  		//$res = $db->Execute($query);
  		$res = $db->Execute($query);
  		if (!$res){
  			print $db->ErrorMsg();
  			return false;
  		}
		else{	
			return true;
		}

}

/**
 * author:coster
 * date: 26.07.2007
 * aendert eine standard uebersetzung
 * */
function changeStandardsprache($ueb_id,$text){
	
		global $db;
		global $gastro_id;
		if (empty($db) || empty($gastro_id)){
			die("Globale Variable fehlt.");
		}		
		
		//echo("neue uebersetzung fuer id: ".$ueb_id." ist: ".$text);
		
		$query = "update
		  BOOKLINE_UEBERSETZUNGEN_FRONTPAGE
		  set
		  TEXT = '$text'
		  where
		  UEBERSETZUNGS_ID = '$ueb_id'
		 ";

  		$res = $db->Execute($query);
  		if (!$res){
  			print $db->ErrorMsg();
  			return false;
  		}
		else{	
			return true;
		}

}
/**
 * author:coster
 * date: 14.10.05
 * liefert die anzahl der bersetzungen in der datenbank
 * */
function getAnzahlUebersetzungen($sprache){
	
		global $db;
		global $gastro_id;
		if (empty($db) || empty($gastro_id)){
			die("Globale Variable fehlt.");
		}
		
		$query = "select count(UEBERSETZUNGS_ID) as anzahl from
		  BOOKLINE_UEBERSETZUNGEN_FRONTPAGE
		  where
		  GASTRO_ID = '$gastro_id'
		  and
		  SPRACHE_ID = '$sprache'
		 ";

  		$res = $db->Execute($query);
  		if (!$res){
  			print $db->ErrorMsg();
  			return false;
  		}
		else{		
			return $res->fields["anzahl"];
		}

}
/**
 * author: coster
 * date: 8.10.05
 * liefert alle bersetzungen, ausser die die einem bestimmen vermieter
 * zugewiesen sind mit einem bestimmten index und einem Limit LIMIT von 10
 * */
function getAllUebersetzungenWithIndex($index,$sprache){
		
		global $db;
		global $gastro_id;
		if (empty($db) || empty($gastro_id)){
			die("Globale Variable fehlt.");
		}
		$limit = LIMIT_UEBERSETZUNGEN;
		if ($index < 0){
			$index = 0;
		}
		
		$query = "select * from
		  BOOKLINE_UEBERSETZUNGEN_FRONTPAGE
		  where
		  GASTRO_ID = '$gastro_id'
		  and
		  SPRACHE_ID = '$sprache'
		  order by
		  TEXT_STANDARD
		  limit 
		  $index,$limit
		 ";

  		$res = $db->Execute($query);
  		if (!$res){
  			print $db->ErrorMsg();
  			die ($query);
  		}
		else{	
			
			return $res;
		}
		
}/**
 * author: coster
 * date: 8.10.05
 * liefert alle bersetzungen, ausser die die einem bestimmen vermieter
 * zugewiesen sind
 * */
function getAllUebersetzungen(){
		
		global $db;
		global $gastro_id;
		if (empty($db) || empty($gastro_id)){
			die("Globale Variable fehlt.");
		}
		
		$query = "select * from
		  BOOKLINE_UEBERSETZUNGEN
		  where
		  GASTRO_ID = '$gastro_id'
		  sort by
		  Text
		 ";

  		$res = $db->Execute($query);
  		if (!$res){
  			print $db->ErrorMsg();
  			return false;
  		}
		else{		
			return $res;
		}
		
}
/**
 * author: coster
 * date: 30.9.05
 * loescht alle aktivierten sprachen eines vermieters
 * */
function deleteAllActivtedSprachenOfVermieter($gastro_id){
		
		global $db;
		global $gastro_id;
		if (empty($db) || empty($gastro_id)){
			die("Globale Variable fehlt.");
		}
		
			$query = "delete from 
			  BOOKLINE_SPR_GASTRO
			  where
			  GASTRO_ID = '$gastro_id'
			 ";

  		$res = $db->Execute($query);
  		if (!$res){
  			print $db->ErrorMsg();
  			return false;
  		}
		else{		
			return true;
		}
}
/**
 * author: coster
 * date: 30.9.05
 * setzt eine aktivierte sprache eines vermieters
 * */
function setActivtedSpracheOfVermieter($gastro_id,$sprache_id){
	
		global $db;
		global $gastro_id;
		if (empty($db) || empty($gastro_id)){
			die("Globale Variable fehlt.");
		}
		
			$query = "replace into
			  BOOKLINE_SPR_GASTRO
			  set
			  GASTRO_ID = '$gastro_id',
			  SPRACHE_ID = '$sprache_id'
			 ";

  		$res = $db->Execute($query);
  		if (!$res){
  			print $db->ErrorMsg();
  			return false;
  		}
		else{		
			return true;
		}
}
/**
 * author: coster
 * date: 30.9.05
 * liefert die aktivierten sprachen eines vermieters
 * */
function getActivtedSprachenOfVermieter($gastro_id){
		
		global $db;
		global $gastro_id;
		if (empty($db) || empty($gastro_id)){
			die("Globale Variable fehlt.");
		}
		
			$query = "select
			  s.*
			  from
			  BOOKLINE_SPR_GASTRO v, BOOKLINE_SPRACHEN s
			  where
			  v.GASTRO_ID = '$gastro_id'
			  and
			  v.SPRACHE_ID = s.SPRACHE_ID
			 ";

  		$res = $db->Execute($query);
  		if (!$res){
  			print $db->ErrorMsg();
  			return false;
  		}
		else{	
			return $res;
		}
}
/**
 * author:coster
 * date:30.9.05
 * prueft ob die uebergebene sprache fuer den belegungsplan aktiv ist
 * */
function isSpracheOfVermieterActiv($sprache_id,$gastro_id){
		
		global $db;
		global $gastro_id;
		if (empty($db) || empty($gastro_id)){
			die("Globale Variable fehlt.");
		}
		
			$query = "select
			  count(SPRACHE_ID) as anzahl
			  from
			  BOOKLINE_SPR_GASTRO
			  where
			  GASTRO_ID = '$gastro_id'
			  and
			  SPRACHE_ID = '$sprache_id'
			 ";

  		$res = $db->Execute($query);
  		if (!$res){
  			print $db->ErrorMsg();
  			return false;
  		}
		else{		
			$anzahl = $res->fields["anzahl"];
			if ($anzahl <= 0){
				return false;
			}
			else{
				return true;
			}
		}
}
/**
 * author:coster
 * date:17.10.05  
   liefert die Bezeichnung einer Sprache aufgrund der 
   sprachen id. z. b. auf "de" = "deutsch"
*/
function getBezeichnungOfSpracheID($spracheID){
		
		global $db;
		if (empty($db)){
			die("Globale Variable fehlt.");
		}
			$query = "select 
			  BEZEICHNUNG
			  from
			  BOOKLINE_SPRACHEN
			  where
			  SPRACHE_ID = '$spracheID'

			 ";

  		$res = $db->Execute($query);
  		if (!$res){
  			print $db->ErrorMsg();
  		}
		else{		
			return $res->fields["BEZEICHNUNG"];
		}
}

/**
author:coster
date:29.9.05
liefert alle sprachen die fuer den belegungsplan
zur verfuegung stehen.
*/
function getSprachen(){
		
		global $db;

		if (empty($db)){
			die("Globale Variable fehlt in getSprachen()");
		}
		
		$query = "select 
			  *
			  from
			  BOOKLINE_SPRACHEN" .
			  		" order by" .
			  		" BEZEICHNUNG
			 ";

  		$res = $db->Execute($query);
  		if (!$res){
  			print $db->ErrorMsg();
  			return false;
  		}
		else	{	
			return $res;
		}
}
/**
author:coster
date:3.4.06
fuegt eine neue sprache in die tabelle BOOKLINE_sprachen ein
*/
function setSprache($sprache_id,$bilder_id,$bezeichnung){
		
		global $db;

		if (empty($db)){
			die("Globale Variable fehlt");
		}
		$query = "REPLACE INTO 
				BOOKLINE_SPRACHEN
				(SPRACHE_ID,BEZEICHNUNG, BILDER_ID) 
				VALUES 
				('$sprache_id','$bezeichnung','$bilder_id')";
		
		$res = $db->Execute($query);
		if (!$res){
		    print $db->ErrorMsg();
			exit;
		}
		else{	
			return true;
		}
}
/**
 * author:lihaitao
 * date:17.10.07
 * löscht eine Sprache
 * */
function deleteSprache($sprache_id){
		
		global $db;

		if (empty($db)){
			die("Globale Variable fehlt");
		}
		$query = "DELETE FROM
				  BOOKLINE_SPRACHEN
				  WHERE	
				  SPRACHE_ID = '$sprache_id'";
		
		$res = $db->Execute($query);
		if (!$res){
		    print $db->ErrorMsg();
			exit;
		}
		else{	
			return true;
		}
}
/**
 * author:lihaitao
 * date:17.10.07
 * liefert ein BILDER_ID
 * */
function getBilderIDOfSpracheID($spracheID){
		
	global $db;
	if (empty($db)){
		die("Globale Variable fehlt.");
	}
	$query = "select 
			  BILDER_ID
			  from
			  BOOKLINE_SPRACHEN
			  where
			  SPRACHE_ID = '$spracheID' ";
	$res = $db->Execute($query);
	if (!$res){
		print $db->ErrorMsg();
	}else{		
		return $res->fields["BILDER_ID"];
	}
}
/**
 * author:coster
 * date: 8.10.05
 * liefert eine uebersetzung
 * */
 function getUebersetzung($text_standard){
 	
 	global $db;
	global $sprache;
	
 	if (empty($sprache)){
 		global $root;
 		if (empty($root)){
 			die("Globale Variable root fehlt.");
 		}
		include_once($root."/include/sessionFunctions.inc.php");
		$sprache = getSessionWert(SPRACHE);
	}	
	
	if (empty($db) || empty($sprache)){
		echo("db: ".$db." sprache: ".$sprache);
		die("Globale Variable fehlt.");
	}
	$query = "select 
		  TEXT
		  from
		  BOOKLINE_UEBERSETZUNGEN
		  where
		  TEXT_STANDARD = '$text_standard'
		  AND 
		  SPRACHE_ID = '$sprache'
		 ";

  		$res = $db->Execute($query);
  		if (!$res){
  			print $db->ErrorMsg();
  		}
  		else{  			
  			if (count($res)>0){
  				$txt = $res->fields["TEXT"];
  				if ($txt != ""){
  					$text_standard = $txt;
  				}
  				else{
  					//die bersetzung existiert noch nicht in der datenbank
  					//sie wird neu angelegt um sie später bersetzen zu können:
  					setUebersetzung($text_standard,$text_standard,$sprache);
  				}
  			}
  		}
  		
	return $text_standard;
	
 }
/**
 * author:coster
 * date: 8.10.05
 * liefert eine uebersetzung
 * */
 function getUebersetzungFromSprache($text_standard,$sprache_id){
 	
 	global $db;
	global $gastro_id;
	if (empty($db) || empty($gastro_id)){
		die("Globale Variable fehlt. -> getUebersetzungFromSprache");
	}

	$query = "select 
		  TEXT
		  from
		  BOOKLINE_UEBERSETZUNGEN_FRONTPAGE
		  where
		  TEXT_STANDARD = '$text_standard'
		  AND 
		  SPRACHE_ID = '$sprache_id'
          and
		  GASTRO_ID = '$gastro_id'
		 ";

  		$res = $db->Execute($query);
  		if (!$res){
  			print $db->ErrorMsg();
  			exit;
  		}
  		
		$d = $res->FetchNextObject();
		if (empty($d)){
			return $text_standard;
		}
		$text = $d->TEXT;  		
		if (empty($text)){
			return $text_standard;
		}
		else{
			return $text;	
		}
 } 
/**
 * author:coster
 * date: 8.10.05
 * setzt eine uebersetzung
 * */
 function setUebersetzung($text,$text_standard,$changeSprache){
 	
	if ($text == "" || $text_standard == ""){
		return false;
	}
	global $db;
	global $gastro_id;
	if (empty($db) ){
		die("Globale Variable fehlt.");
	}

	$query = "insert into 
		  BOOKLINE_UEBERSETZUNGEN
		  (TEXT_STANDARD,TEXT,SPRACHE_ID, GASTRO_ID)
		  values
		  ('$text_standard','$text','$changeSprache','$gastro_id')
		 ";

  		$res = $db->Execute($query);
  		if (!$res){
  			print $db->ErrorMsg();
  			exit;
  		}
  		else{  			
			return true;
  		}
	
 }
/**
 * liefert die uebersetzung auf grund einer uebersetzungs-id
 * @author coster
 * @date 7.Apr.06
 */
function getTextFromUebersetzung($stText){
		global $db;
		global $gastro_id;
		if (empty($db) || empty($gastro_id)){
			die("Globale Variable fehlt.");
		}
		$query = "select 
				  TEXT
				  from
				  BOOKLINE_UEBERSETZUNGEN_FRONTPAGE
				  where
				  UEBERSETZUNGS_ID = '$stText'
	              and
			      GASTRO_ID = '$gastro_id'
				 ";
		
  		$res = $db->Execute($query);
  		if (!$res){
  			return -1;
  		}
		else{					
			$text = $res->fields["TEXT"];
			return $text;
		}
}
/**
 * author:coster
 * date:8.10.05
 * speichert die uebersetzung eines bestimmten gastro
 * */
function setUebersetzungVermieter($text,$text_standard,$sprache){
	
		global $db;
		global $gastro_id;
		if (empty($db) || empty($gastro_id)){
			die("Globale Variable fehlt.");
		}
	
	$vorhanden = isTextVorhanden($text_standard,$sprache,$gastro_id);
	
	if ($vorhanden == false || empty($vorhanden)){
		//text ist noch nicht vorhanden, er wird neu angelegt:
		$query = "insert into 
				  BOOKLINE_UEBERSETZUNGEN_FRONTPAGE
				  (GASTRO_ID,SPRACHE_ID,TEXT,TEXT_STANDARD)
				  values
				  ('$gastro_id','$sprache','$text','$text_standard')
				 ";

  		$res = $db->Execute($query);
  		if (!$res){
  			print $db->ErrorMsg();
  			return false;
  		}
		else{					
			return true;
		}
	
	}
	else{

		//text ist bereits vorhanden, er wird ersetzt:
		$query = "update 
				  BOOKLINE_UEBERSETZUNGEN_FRONTPAGE
				  set
				  TEXT = '$text'
				  where
				  TEXT_STANDARD = '$text_standard'
				  and
				  SPRACHE_ID = '$sprache'
				  and
				  GASTRO_ID = '$gastro_id'
				 ";
		
  		$res = $db->Execute($query);

  		if (!$res){
  			print $db->ErrorMsg();
  			return false;
  		}
		else{					
			return true;
		}
	}
}

/**
 * author: coster
 * date: 8.10.05
	liefert die uebersetzung fuer
	eine gewisse unterkunft und eine bestimmte sprache
	@param $text der zu uebersetzende text
	@param $sprache die sprache in der die uebersetzung gezeigt werden soll
	@param $gastro_id
*/
function getUebersetzungGastro($text,$sprache,$gastro_id){
		
		global $db;
		global $gastro_id;
		if (empty($db) || empty($gastro_id)){
			die("Globale Variable fehlt.");
		}
		
	$query = "select 
			  TEXT
			  from
			  BOOKLINE_UEBERSETZUNGEN_FRONTPAGE
			  where
			  TEXT_STANDARD = '$text'
			  AND
			  GASTRO_ID = '$gastro_id'
			  AND
			  SPRACHE_ID = '$sprache'
			 ";

	$res = $db->Execute($query);
	if (!$res){
		print $db->ErrorMsg();
		return $text;
	}
	else{	
		$d = $res->FetchNextObject();
		if (!empty($d)){
			$textUebersetzt = $d->TEXT;
			if (!isset($textUebersetzt) || $textUebersetzt == ""){
				return $text;
			}
			$text = $textUebersetzt;
		}
	}	
	return $text;
}

function isUebersetzungVorhanden($stText,$changeSprache){
		global $db;
		global $gastro_id;
		if (empty($db) || empty($gastro_id)){
			die("Globale Variable fehlt.");
		}
		
	$query = "select 
			  TEXT
			  from
			  BOOKLINE_UEBERSETZUNGEN
			  where
			  TEXT_STANDARD = '$stText'
			  AND
			  SPRACHE_ID = '$changeSprache'
              and
     	      GASTRO_ID = '$gastro_id'
			 ";

	$res = $db->Execute($query);
	if (!$res){
		print $db->ErrorMsg();
		exit;
	}
	else{	
		$textUebersetzt = $res->fields["TEXT"];
		if (!empty($textUebersetzt)){
			return true;	
		}
	}	
	return false;
}
/**
 * @author coster
 * prueft ob ein text eines vermieters bereits in der datenbank ist
 */
function isTextVorhanden($text,$sprache,$gastro_id){
		global $db;
		global $gastro_id;
		if (empty($db) || empty($gastro_id)){
			die("Globale Variable fehlt.");
		}
		
	$query = "select 
			  TEXT
			  from
			  BOOKLINE_UEBERSETZUNGEN
			  where
			  TEXT_STANDARD = '$text'
			  AND
			  GASTRO_ID = '$gastro_id'
			  AND
			  SPRACHE_ID = '$sprache'
			 ";

	$res = $db->Execute($query);

	if (!$res){
		print $db->ErrorMsg();
		exit;
	}
	else{	
		$textUebersetzt = $res->fields["TEXT"];
		if (!empty($textUebersetzt)){
			return true;	
		}
	}	
	return false;
}
?>