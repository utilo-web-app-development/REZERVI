<?php 

define("LIMIT_UEBERSETZUNGEN",10);

/**
 * author:coster
 * date: 14.10.05
 * aendert eine uebersetzung
 * */
function changeUebersetzung($standardtext,$text,$sprache){
	
		global $link;
				
		$query = "update
		  REZ_GEN_UEBERSETZUNGEN
		  set
		  TEXT = '$text'
		  where
		  TEXT_STANDARD = '$standardtext'" .
		  		" and SPRACHE_ID = '$sprache'
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
/**
 * author:coster
 * date: 14.10.05
 * liefert die anzahl der bersetzungen in der datenbank
 * */
function getAnzahlUebersetzungen($sprache){
	
		global $link;
		
		$query = "select count(UEBERSETZUNGS_ID) as anzahl from
		  REZ_GEN_UEBERSETZUNGEN
		  where
		  VERMIETER_ID = 0
		  and
		  SPRACHE_ID = '$sprache'
		 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  			echo(mysql_error($link));
  			return false;
  		}
		else{	
			$d = mysql_fetch_array($res);	
			return $d["anzahl"];
		}

}
/**
 * author: coster
 * date: 8.10.05
 * liefert alle bersetzungen, ausser die die einem bestimmen vermieter
 * zugewiesen sind mit einem bestimmten index und einem Limit LIMIT von 10
 * */
function getAllUebersetzungenWithIndex($index,$sprache){
		
		global $link;
		$limit = LIMIT_UEBERSETZUNGEN;
		if ($index < 0){
			$index = 0;
		}
		
		$query = "select * from
		  REZ_GEN_UEBERSETZUNGEN
		  where
		  VERMIETER_ID = 0
		  and
		  SPRACHE_ID = '$sprache'
		  order by
		  TEXT_STANDARD
		  limit 
		  $index,$limit
		 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  			echo(mysql_error($link));
  			return false;
  		}
		else{		
			return $res;
		}
		
}
/**
 * author: coster
 * date: 8.10.05
 * liefert alle bersetzungen, ausser die die einem bestimmen vermieter
 * zugewiesen sind
 * */
function getAllUebersetzungen(){
		
		global $link;
		
		$query = "select * from
		  REZ_GEN_UEBERSETZUNGEN
		  where
		  VERMIETER_ID = NULL
		  sort by
		  Text
		 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  			echo(mysql_error($link));
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
function deleteAllActivtedSprachenOfVermieter($vermieter_id){
		global $link;
			$query = "delete from 
			  REZ_GEN_SPR_VER
			  where
			  VERMIETER_ID = '$vermieter_id'
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
/**
 * author: coster
 * date: 30.9.05
 * setzt eine aktivierte sprache eines vermieters
 * */
function setActivtedSpracheOfVermieter($vermieter_id,$sprache_id){
	
		global $link;
			$query = "replace into
			  REZ_GEN_SPR_VER
			  set
			  VERMIETER_ID = '$vermieter_id',
			  SPRACHE_ID = '$sprache_id'
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
/**
 * author: coster
 * date: 30.9.05
 * liefert die aktivierten sprachen eines vermieters
 * */
function getActivtedSprachenOfVermieter($vermieter_id){
		global $link;
			$query = "select
			  s.*
			  from
			  REZ_GEN_SPR_VER v, REZ_GEN_SPRACHEN s
			  where
			  v.VERMIETER_ID = '$vermieter_id'
			  and
			  v.SPRACHE_ID = s.SPRACHE_ID
			 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  			echo(mysql_error($link));
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
function isSpracheOfVermieterActiv($sprache_id,$vermieter_id){
		global $link;
			$query = "select
			  count(SPRACHE_ID) as anzahl
			  from
			  REZ_GEN_SPR_VER
			  where
			  VERMIETER_ID = '$vermieter_id'
			  and
			  SPRACHE_ID = '$sprache_id'
			 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  			echo(mysql_error($link));
  			return false;
  		}
		else{		
			$d = mysql_fetch_array($res);
			$anzahl = $d["anzahl"];
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
			global $link;
			$query = "select 
			  BEZEICHNUNG
			  from
			  REZ_GEN_SPRACHEN
			  where
			  SPRACHE_ID = '$spracheID'
			 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  			echo(mysql_error($link));
  		}
		else{		
			$d = mysql_fetch_array($res);
			return $d["BEZEICHNUNG"];
		}
}

/**
author:coster
date:29.9.05
liefert alle sprachen die fuer den belegungsplan
zur verfuegung stehen.
*/
function getSprachen(){
		global $link;
		$query = "select 
			  *
			  from
			  REZ_GEN_SPRACHEN" .
			  		" order by" .
			  		" BEZEICHNUNG
			 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  			return false;
  		}
		else	{	
			return $res;
		}
}
/**
author:coster
date:3.4.06
fuegt eine neue sprache in die tabelle rez_gen_sprachen ein
*/
function setSprache($sprache_id,$bilder_id,$bezeichnung){
		global $link;
		$query = "REPLACE INTO 
				REZ_GEN_SPRACHEN
				(SPRACHE_ID,BEZEICHNUNG, BILDER_ID) 
				VALUES 
				('$sprache_id','$bezeichnung','$bilder_id')";
		$res = mysql_query($query, $link);
		if (!$res){
		    echo (mysql_error($link));
			exit;
		}
		else{	
			return true;
		}
}
/**
 * author:coster
 * date: 8.10.05
 * liefert eine uebersetzung
 * */
 function getUebersetzung($text_standard){
 	
 	global $link;
	global $sprache;
	global $root;
		
	if (empty($sprache)){
		include_once($root."/include/sessionFunctions.inc.php");
		$sprache = getSessionWert(SPRACHE);
	}

	$query = "select 
		  TEXT
		  from
		  REZ_GEN_UEBERSETZUNGEN
		  where
		  TEXT_STANDARD = '$text_standard'
		  AND 
		  SPRACHE_ID = '$sprache'
		 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo(mysql_error($link));
  		}
  		else{  			
  			if (mysql_num_fields($res)>0){
  				$d = mysql_fetch_array($res);
  				if ($d["TEXT"] != ""){
  					$text_standard = $d["TEXT"];
  				}
  				else{
  					//die bersetzung existiert noch nicht in der datenbank
  					//sie wird neu angelegt um sie später übersetzen zu könen:
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
 	
 	global $link;
	global $sprache;

	$query = "select 
		  TEXT
		  from
		  REZ_GEN_UEBERSETZUNGEN
		  where
		  TEXT_STANDARD = '$text_standard'
		  AND 
		  SPRACHE_ID = '$sprache_id'
		 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo(mysql_error($link));
  			exit;
  		}
  		
  		$d = mysql_fetch_array($res);
  		$text = $d["TEXT"];
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
	
 	global $link;

	$query = "insert into 
		  REZ_GEN_UEBERSETZUNGEN
		  (TEXT_STANDARD,TEXT,SPRACHE_ID)
		  values
		  ('$text_standard','$text','$changeSprache')
		 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo(mysql_error($link));
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
		global $link;
		$query = "select 
				  TEXT
				  from
				  REZ_GEN_UEBERSETZUNGEN
				  where
				  UEBERSETZUNGS_ID = '$stText'
				 ";
		
  		$res = mysql_query($query, $link);
  		if (!$res){
  			return -1;
  		}
		else{					
			$d = mysql_fetch_array($res);
			$text = $d["TEXT"];
			return $text;
		}
}
/**
 * author:coster
 * date:8.10.05
 * speichert die uebersetzung eines bestimmten vermieters
 * */
function setUebersetzungVermieter($text,$text_standard,$sprache,$sprache_standard,$vermieter_id){
	
	global $link;
	
	$vorhanden = isTextVorhanden($text_standard,$sprache,$vermieter_id);
	
	if ($vorhanden == false || empty($vorhanden)){
		//text ist noch nicht vorhanden, er wird neu angelegt:
		$query = "insert into 
				  REZ_GEN_UEBERSETZUNGEN
				  (VERMIETER_ID,SPRACHE_ID,TEXT,TEXT_STANDARD)
				  values
				  ('$vermieter_id','$sprache','$text','$text_standard')
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo(mysql_error($link));
  			return false;
  		}
		else{					
			return true;
		}
	
	}
	else{

		//text ist bereits vorhanden, er wird ersetzt:
		$query = "update 
				  REZ_GEN_UEBERSETZUNGEN
				  set
				  TEXT = '$text'
				  where
				  TEXT_STANDARD = '$text_standard'
				  and
				  SPRACHE_ID = '$sprache'
				  and
				  VERMIETER_ID = '$vermieter_id'
				 ";
		
  		$res = mysql_query($query, $link);

  		if (!$res){
  			echo(mysql_error($link));
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
	@param $vermieter_id
*/
function getUebersetzungVermieter($text,$sprache,$vermieter_id){
		
	global $link;
		
	$query = "select 
			  TEXT
			  from
			  REZ_GEN_UEBERSETZUNGEN
			  where
			  TEXT_STANDARD = '$text'
			  AND
			  VERMIETER_ID = '$vermieter_id'
			  AND
			  SPRACHE_ID = '$sprache'
			 ";

	$res = mysql_query($query, $link);

	if (!$res){
		echo(mysql_error($link));
		return $text;
	}
	else{	
		$d = mysql_fetch_array($res);
		$textUebersetzt = $d["TEXT"];
		if (!isset($textUebersetzt) || $textUebersetzt == ""){
			return $text;
		}
		$text = $textUebersetzt;
	}	
	return $text;
}
function isUebersetzungVorhanden($stText,$changeSprache){
	global $link;
		
	$query = "select 
			  TEXT
			  from
			  REZ_GEN_UEBERSETZUNGEN
			  where
			  TEXT_STANDARD = '$stText'
			  AND
			  SPRACHE_ID = '$changeSprache'
			 ";

	$res = mysql_query($query, $link);

	if (!$res){
		echo(mysql_error($link));
		exit;
	}
	else{	
		$d = mysql_fetch_array($res);
		$textUebersetzt = $d["TEXT"];
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
function isTextVorhanden($text,$sprache,$vermieter_id){
		
	global $link;
		
	$query = "select 
			  TEXT
			  from
			  REZ_GEN_UEBERSETZUNGEN
			  where
			  TEXT_STANDARD = '$text'
			  AND
			  VERMIETER_ID = '$vermieter_id'
			  AND
			  SPRACHE_ID = '$sprache'
			 ";

	$res = mysql_query($query, $link);

	if (!$res){
		echo(mysql_error($link));
		exit;
	}
	else{	
		$d = mysql_fetch_array($res);
		$textUebersetzt = $d["TEXT"];
		if (!empty($textUebersetzt)){
			return true;	
		}
	}	
	return false;
}
?>