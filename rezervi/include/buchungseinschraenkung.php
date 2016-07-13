<?php

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 

/**
author:coster
date:5.11.05
prueft ob eine buchungseinschraenkung zu dem übergebenen
datum existiert
*/
function hasBuchungseinschraenkung($vonTag,$vonMonat,$vonJahr,$bisTag,$bisMonat,$bisJahr,$zimmer_id){
	global $link;
 	global $root;
	include_once($root."/include/datumFunctions.php");
	
	$wochentag_von = getDayName($vonTag,$vonMonat,$vonJahr);
	$wochentag_bis = getDayName($bisTag,$bisMonat,$bisJahr);
	$vonDatum =parseDateFormular($vonTag,$vonMonat,$vonJahr);
 	$bisDatum =parseDateFormular($bisTag,$bisMonat,$bisJahr);
	
	$query = "select 
		  count(PK_ID) as anzahl
		  from
		  Rezervi_Buch_Einschraenkung
		  where FK_Zimmer_ID = '$zimmer_id'
 			AND
		  (		  
		   ('$vonDatum' >= Datum_von and '$bisDatum' <= Datum_bis)
		   OR
		   ('$vonDatum' < Datum_bis and '$bisDatum' <= Datum_bis and '$bisDatum' > Datum_von)
		   OR
		   ('$vonDatum' >= Datum_von and '$bisDatum' > Datum_bis and '$vonDatum' < Datum_bis)
		   	OR
		   ('$vonDatum' <= Datum_von and '$bisDatum' >= Datum_bis)
		   )
		   ";

	$res = mysql_query($query, $link);
	if (!$res){
		echo(mysql_error($link));
		echo($query);
		exit;
	}
	
	$d=mysql_fetch_array($res);
	$anzahl = $d["anzahl"];
	if ($anzahl>0){
		return true;
	}		
	
	return false;
}
/**
author:coster
date:5.11.05
prueft ob eine buchungseinschraenkung zu dem übergebenen
datum existiert
*/
function checkBuchungseinschraenkung($vonTag,$vonMonat,$vonJahr,$bisTag,$bisMonat,$bisJahr,$zimmer_ids){
	
	global $link;
 	global $root;
	include_once($root."/include/datumFunctions.php");
	
	$wochentag_von = getDayName($vonTag,$vonMonat,$vonJahr);

	$wochentag_bis = getDayName($bisTag,$bisMonat,$bisJahr);

	$vonDatum =parseDateFormular($vonTag,$vonMonat,$vonJahr);
 	$bisDatum =parseDateFormular($bisTag,$bisMonat,$bisJahr);
	
	$query = "select 
		  *
		  from
		  Rezervi_Buch_Einschraenkung
		  where ";
		  for ($i=0; $i<count($zimmer_ids);$i++){
		  	if ($i == count($zimmer_ids)-1){
		  		$query.=" FK_Zimmer_ID = ".$zimmer_ids[$i];
		  	}
		  	else{
		  		$query.=" FK_Zimmer_ID = ".$zimmer_ids[$i]." OR ";
		  	}
		  }		   
		  $query.=" AND
		  (		  
		   ('$vonDatum' >= Datum_von and '$bisDatum' <= Datum_bis)
		   OR
		   ('$vonDatum' < Datum_bis and '$bisDatum' <= Datum_bis and '$bisDatum' > Datum_von)
		   OR
		   ('$vonDatum' >= Datum_von and '$bisDatum' > Datum_bis and '$vonDatum' < Datum_bis)
		   	OR
		   ('$vonDatum' <= Datum_von and '$bisDatum' >= Datum_bis)
		   )
		   ";

	$res = mysql_query($query, $link);
	if (!$res){
		echo(mysql_error($link));
		echo($query);
		exit;
	}

	//wenn leer dann auch true!
	if (mysql_num_rows($res)<1){
		return true;
	}
	
	while ($d=mysql_fetch_array($res)){
		$wo_von = $d["Tag_von"];
		$wo_bis = $d["Tag_bis"];
		if ($wochentag_von == $wo_von && $wochentag_bis == $wo_bis){
			return true;
		}		
	}
	return false;
}
/**
author:coster
date:5.11.05
liefert den grund einer buchungseinschränkung
*/
function getBuchungseinschraenkungText($vonTag,$vonMonat,$vonJahr,$bisTag,$bisMonat,$bisJahr,$zimmer_ids){
	
	global $link;
 	global $root;
 	global $sprache;
	include_once($root."/include/uebersetzer.php");
	include_once($root."/include/datumFunctions.php");
	
	$wochentag_von = getDayName($vonTag,$vonMonat,$vonJahr);
	$wochentag_von = getUebersetzung($wochentag_von,$sprache,$link);
	$wochentag_bis = getDayName($bisTag,$bisMonat,$bisJahr);
	$wochentag_bis = getUebersetzung($wochentag_bis,$sprache,$link);
	$vonDatum =parseDateFormular($vonTag,$vonMonat,$vonJahr);
 	$bisDatum =parseDateFormular($bisTag,$bisMonat,$bisJahr);
	
	$query = "select distinct
		  *
		  from
		  Rezervi_Buch_Einschraenkung
		  where ";
		  for ($i=0; $i<count($zimmer_ids);$i++){
		  	if ($i == count($zimmer_ids)-1){
		  		$query.=" FK_Zimmer_ID = ".$zimmer_ids[$i];
		  	}
		  	else{
		  		$query.=" FK_Zimmer_ID = ".$zimmer_ids[$i]." OR ";
		  	}
		  }		   
		  $query.=" AND
		  (		  
		   ('$vonDatum' >= Datum_von and '$bisDatum' <= Datum_bis)
		   OR
		   ('$vonDatum' < Datum_bis and '$bisDatum' <= Datum_bis and '$bisDatum' > Datum_von)
		   OR
		   ('$vonDatum' >= Datum_von and '$bisDatum' > Datum_bis and '$vonDatum' < Datum_bis)
		   	OR
		   ('$vonDatum' <= Datum_von and '$bisDatum' >= Datum_bis)
		   )
		   ";

	$res = mysql_query($query, $link);
	if (!$res){
		echo(mysql_error($link));
		echo($query);
		exit;
	}

	while ($d=mysql_fetch_array($res)){
		$wo_von = $d["Tag_von"];
		$wo_von = getUebersetzung($wo_von,$sprache,$link);
		$wo_bis = $d["Tag_bis"];
		$wo_bis = getUebersetzung($wo_bis,$sprache,$link);
		break;		
	}
	
	$text = "Buchungen sind nur von";
	$text = getUebersetzung($text,$sprache,$link);
	$text.= " ".$wo_von." ".getUebersetzung("bis",$sprache,$link)." ".$wo_bis." ".getUebersetzung("erlaubt",$sprache,$link).".";
	$text.= " ".getUebersetzung("Das gewählte Datum ist von",$sprache,$link)." ";
	$text.= $wochentag_von." ".getUebersetzung("bis",$sprache,$link)." ".$wochentag_bis;
	
	return $text;
}
/**
author:coster
date:5.11.05
liefert alle buchungseinschränkungen einer unterkunft
*/
function getBuchungseinschraenkungen($unterkunft_id){
		
		global $link;
	
		$query = "select 
				  e.*
				  from
				  Rezervi_Buch_Einschraenkung e, Rezervi_Unterkunft u, Rezervi_Zimmer z
				  where
				  u.PK_ID = '$unterkunft_id'
				  and
				  z.FK_Unterkunft_ID = u.PK_ID 
				  and
				  z.PK_ID = e.FK_Zimmer_ID
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
			echo(mysql_error($link));
  			return false;
		}
	
	return $res;
			
} 
/**
author:coster
date:5.11.05
liefert alle buchungseinschränkungen einer unterkunft ab heutigem Datum
*/
function getActualBuchungseinschraenkungen($unterkunft_id){
		
		global $link;
	 	global $root;
 		include_once($root."/include/datumFunctions.php");
 		$datum =parseDateFormular(getTodayDay(),parseMonthNumber(getTodayMonth()),getTodayYear()); 		
	
		$query = "select 
				  e.*
				  from
				  Rezervi_Buch_Einschraenkung e, Rezervi_Unterkunft u, Rezervi_Zimmer z
				  where
				  u.PK_ID = '$unterkunft_id'
				  and
				  z.FK_Unterkunft_ID = u.PK_ID 
				  and
				  z.PK_ID = e.FK_Zimmer_ID
				  and
				  e.Datum_bis >= $datum
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
			echo(mysql_error($link));
  			return false;
		}
	
	return $res;
			
} 
/**
 * author:coster
 * date:5.11.05
 * prüft ob buchungseinschränkungen ab dem heutigen Datum vorhanden sind
 * */
 function hasActualBuchungsbeschraenkungen($unterkunft_id){
 		
 		global $link;
 		global $root;
 		include_once($root."/include/datumFunctions.php");
 		$datum =parseDateFormular(getTodayDay(),parseMonthNumber(getTodayMonth()),getTodayYear()); 		
	
		$query = "select 
				  count(e.PK_ID) as anzahl
				  from
				  Rezervi_Buch_Einschraenkung e, Rezervi_Unterkunft u, Rezervi_Zimmer z
				  where
				  u.PK_ID = '$unterkunft_id'
				  and
				  z.FK_Unterkunft_ID = u.PK_ID 
				  and
				  z.PK_ID = e.FK_Zimmer_ID
				  and
				  e.Datum_bis >= $datum
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
			echo(mysql_error($link));
			echo($query);
			exit;
		}
	
		$d = mysql_fetch_array($res);
		if ($d["anzahl"]>0){
			return true;
		}
		else{
			return false;
		}
 }
/**
 * author:coster
 * date:7.11.05
 * löscht eine buchungseinschränkung
 * */
function removeBuchungseinschraenkung($bu_id){
	
	global $link;
	
			$query = "delete 
				  from
				  Rezervi_Buch_Einschraenkung 
				  where
				  PK_ID = '$bu_id'
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
			echo(mysql_error($link));
  			return false;
		}
		
	return true;
	
}
/**
 * author:coster
 * date:7.11.05
 * fügt eine neue buchungseinschränkung hinzu
 * */
 function setBuchungseinschraenkung($zimmer_id,$von_wochentag,$bis_wochentag,$vonTag,$vonMonat,$vonJahr,$bisTag,$bisMonat,$bisJahr){
 
 	global $link;
 	global $root;
 	include_once($root."/include/datumFunctions.php");
 	
 	$datumVon =parseDateFormular($vonTag,$vonMonat,$vonJahr);
 	$datumBis =parseDateFormular($bisTag,$bisMonat,$bisJahr);
	
			$query = "insert into 
				  Rezervi_Buch_Einschraenkung 
				  (FK_Zimmer_ID,Tag_von,Tag_bis,Datum_von,Datum_bis)
				  values
				  ('$zimmer_id','$von_wochentag','$bis_wochentag','$datumVon','$datumBis')
				 ";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo($query);
			echo(mysql_error($link));
  			return false;
		}
		
	return mysql_insert_id($link);
 }
 
 function getZimmerBuchungseinschraenkung($zimmer_id){
   
   global $link; 
   
   $query = "SELECT Tag_von, Tag_bis, Datum_von, Datum_bis
             FROM Rezervi_Buch_Einschraenkung
             WHERE FK_Zimmer_ID = '" . $zimmer_id . "'";
   
   //echo("Query: " . $query);
   $res = mysql_query($query, $link);
  		if (!$res){
			echo(mysql_error($link));
			echo($query);
			exit;
		}
	
		else{
			return $res;
		}
  }					 
?>