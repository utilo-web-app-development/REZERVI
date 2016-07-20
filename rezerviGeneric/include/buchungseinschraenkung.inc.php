<?php
/*
 * Created on 17.04.2006
 * @author coster
 */


define("BE_TYP_ZEIT","buchungsein zeit von");
define("BE_TYP_TAG","buchungsein tag");
define("BE_TYP_DATUM_VON_BIS","buchungsein datum vonBis");

/**
 * @author coster
 * date: 24.4.06
 * löscht eine buchungseinschränkung
 */
 function deleteBuchungseinschraenkung($einschraenkungs_id){
	global $link;	

	$query = ("delete from REZ_GEN_BUCHUNGSEINSCHRAENKUNG where " .
			"EINSCHRAENKUNGS_ID = '$einschraenkungs_id'");      
	
	$res = mysqli_query($link, $query);
	
	if (!$res) { 
		echo("die Anfrage $query scheitert"); 
		echo(mysqli_error($link));
		exit;
	}
	else{
		return true;
	}
 }
 /**
  * löscht alle buchungseinschränkungen eines mietobjektes eines bestimmten typs
  * @author coster
  * datum: 25.4.06
  * @param $mietobjekt_id id des mietobjektes
  * @param $typ typ konstante
  */
  function deleteBuchungseinschraenkungenOfMietobjekt($mietobjekt_id,$typ){
  	global $link;	

	$query = ("delete from REZ_GEN_BUCHUNGSEINSCHRAENKUNG where " .
			"MIETOBJEKT_ID = '$mietobjekt_id' and TYP = '$typ'");      
	
	$res = mysqli_query($link, $query);
	
	if (!$res) { 
		echo("die Anfrage $query scheitert"); 
		echo(mysqli_error($link));
		exit;
	}
	else{
		return true;
	}
  	
  }
 /**
  * fuegt eine buchungseinschraenkung fuer einen bestimmten tag ein
  * das mietobjekt und der tag sind unique
  * @author:coster
  * datum: 25.4.06
  * @param $mietobjekt_id id des mietobjektes
  * @param $tag die konstante für die kurzbezeichnung des tages aus datumFuntions.inc.php
  */
 function insertBuchungseinschraenkungTag($mietobjekt_id,$tag){
 	
 	global $root;
 	global $link;
	include_once($root."/include/datumFunctions.inc.php");
	//monat und jahr sind egal, ich verwende ja nur den tag der woche:
	$jahr = 2006;
	$monat= 4;
	$minute = 1;
	$stunde = 1;
	$typ = BE_TYP_TAG;
	$update = false;
	if ($tag == KURZFORM_MONTAG){
		$tag = 17;
		if (isMondayEingeschraenkt($mietobjekt_id)){
			$update = true;
		}
	}
	else if($tag == KURZFORM_DIENSTAG){
		$tag = 18;
		if (isTuesdayEingeschraenkt($mietobjekt_id)){
			$update = true;
		}
	}
	else if($tag == KURZFORM_MITTWOCH){
		$tag = 19;
		if (isWednesdayEingeschraenkt($mietobjekt_id)){
			$update = true;
		}		
	}
	else if ($tag == KURZFORM_DONNERSTAG){
		$tag = 20;
		if (isThursdayEingeschraenkt($mietobjekt_id)){
			$update = true;
		}		
	}
	else if ($tag == KURZFORM_FREITAG){
		$tag = 21;
		if (isFridayEingeschraenkt($mietobjekt_id)){
			$update = true;
		}		
	}
	else if ($tag == KURZFORM_SAMSTAG){
		$tag = 22;
		if (isSaturdayEingeschraenkt($mietobjekt_id)){
			$update = true;
		}		
	}
	else if ($tag == KURZFORM_SONNTAG){
		$tag = 23;
		if (isSundayEingeschraenkt($mietobjekt_id)){
			$update = true;
		}		
	}
	else{
		echo("fehlerhafte übergabe des tages! insertBuchungunseinschraenkungTag tag=".$tag);
		exit;
	}
	$timestampVon = constructMySqlTimestamp($minute,$stunde,$tag,$monat,$jahr);
	$timestampBis = constructMySqlTimestamp($minute,$stunde,$tag,$monat,$jahr);
	if ($update){
	}
	else{
		$query = ("insert into
				   REZ_GEN_BUCHUNGSEINSCHRAENKUNG
				   (MIETOBJEKT_ID,VON,BIS,TYP)
				   values" .
				 " ('$mietobjekt_id','$timestampVon','$timestampBis','$typ')
	   			  ");  
		$res = mysqli_query($link, $query);
		
		if (!$res) { 
			echo("die Anfrage $query scheitert"); 
			echo(mysqli_error($link));
			exit;
		}
	}
	return true;

 }
/**
 * fuegt eine buchungseinschraenkung fuer ein unique mietobjekt ein
 * @author coster
 * date 24.4.06
 */
function insertBuchungseinschraenkung($mietobjekt_id,$vonStunde,$vonMinute,$bisStunde,$bisMinute,$typ){
	global $root;
	include_once($root."/include/datumFunctions.inc.php");
	//tag monat jahr sind egal in diesem fall:
	$tag = 1;
	$monat = 1;
	$jahr = 2006;
	$timestampVon = constructMySqlTimestamp($vonMinute,$vonStunde,$tag,$monat,$jahr);
	$timestampBis = constructMySqlTimestamp($bisMinute,$bisStunde,$tag,$monat,$jahr);
	setBuchungseinschraenkungUniqueMietobjekt($mietobjekt_id,$timestampVon,$timestampBis,$typ);
	
}
/**
 * fuegt eine buchungseinschraenkung ein
 * @author coster
 * date: 25.4.06
 * @param $mietobjekt_id die id des mietobjektes
 * @param $datumVon mysql timestamp von
 * @param $datumBis mysql timestamp bis
 * @param $typ typ konstante
 */
 function insertBuchungseinschraenkungVonBis($mietobjekt_id,$datumVon,$datumBis,$typ){
	
	global $link;
	
	$query = ("insert into
	   REZ_GEN_BUCHUNGSEINSCHRAENKUNG
	   (MIETOBJEKT_ID,VON,BIS,TYP)
	   values" .
	 " ('$mietobjekt_id','$datumVon','$datumBis','$typ')
	  ");           
	
	$res = mysqli_query($link, $query);
	
	if (!$res) { 
		echo("die Anfrage $query scheitert"); 
		echo(mysqli_error($link));
		exit;
	}
	else{
		return true;
	}
 }
/**
 * fuegt eine buchungseinschraenkung fuer ein unique mietobjekt ein
 * @author coster
 * date 24.4.06
 */
function setBuchungseinschraenkungUniqueMietobjekt($mietobjekt_id,$timestampVon,$timestampBis,$typ){
	
	global $link;	
	if (hasMietobjektBuchungseinschraenkung($mietobjekt_id,$typ) == true){
		$query = ("update REZ_GEN_BUCHUNGSEINSCHRAENKUNG set " .
				"VON = '$timestampVon', " .
				"BIS = '$timestampBis', " .
				"TYP = '$typ' " .
				"where MIETOBJEKT_ID = '$mietobjekt_id'");
	}
	else{
		$query = ("insert into
				   REZ_GEN_BUCHUNGSEINSCHRAENKUNG
				   (MIETOBJEKT_ID,VON,BIS,TYP)
				   values" .
				 " ('$mietobjekt_id','$timestampVon','$timestampBis','$typ')
	   			  ");           
	}
	
	$res = mysqli_query($link, $query);
	
	if (!$res) { 
		echo("die Anfrage $query scheitert"); 
		echo(mysqli_error($link));
		exit;
	}
	else{
		return true;
	}
}
function hasMietobjektBuchungseinschraenkung($mietobjekt_id,$typ){
	global $link;	

	$query = ("select count(MIETOBJEKT_ID) as anzahl
			   from" .
			   		" REZ_GEN_BUCHUNGSEINSCHRAENKUNG" .
			   		" where" .
			   		" TYP = '$typ' and" .
			   		" MIETOBJEKT_ID = '$mietobjekt_id'
   			  ");           

	$res = mysqli_query($link, $query);
	
	if (!$res) { 
		echo("die Anfrage $query scheitert"); 
		echo(mysqli_error($link));
		exit;
	}
	else{
		$d = mysqli_fetch_array($res);
		$anzahl = $d["anzahl"];
		if ($anzahl > 0){
			return true;
		}
	}
	return false;
}
function isDayEingeschraenkt($mietobjekt_id,$day){
	global $root;
	include_once($root."/include/datumFunctions.inc.php");
	$typ = BE_TYP_TAG;
	$res = getBuchungseinschraenkungZeitVon($mietobjekt_id,$typ);
	while($d = mysqli_fetch_array($res)){
		$timestamp = $d["VON"];
		$tag = getDayFromMySqlTimestamp($timestamp);
		$monat = getMonthFromMySqlTimestamp($timestamp);
		$jahr = getYearFromMySqlTimestamp($timestamp);
		$dayName = getDayName($tag,$monat,$jahr);	
		if ($dayName == $day){
			return true;
		}
	}
	return false;	
}
/**
 * @author coster
 * date 24.4.06
 * prueft ob dieser tag eingeschraenkt ist (nicht gebucht werden kann)
 */
function isMondayEingeschraenkt($mietobjekt_id){
	return isDayEingeschraenkt($mietobjekt_id,KURZFORM_MONTAG);
}
/**
 * @see isMondayEingeschraenkt($mietobjekt_id)
 */
function isTuesdayEingeschraenkt($mietobjekt_id){
	return isDayEingeschraenkt($mietobjekt_id,KURZFORM_DIENSTAG);	
}
/**
 * @see isMondayEingeschraenkt($mietobjekt_id)
 */
function isWednesdayEingeschraenkt($mietobjekt_id){
	return isDayEingeschraenkt($mietobjekt_id,KURZFORM_MITTWOCH);
}
/**
 * @see isMondayEingeschraenkt($mietobjekt_id)
 */
function isThursdayEingeschraenkt($mietobjekt_id){
	return isDayEingeschraenkt($mietobjekt_id,KURZFORM_DONNERSTAG);
}
/**
 * @see isMondayEingeschraenkt($mietobjekt_id)
 */
function isFridayEingeschraenkt($mietobjekt_id){
	return isDayEingeschraenkt($mietobjekt_id,KURZFORM_FREITAG);
}
/**
 * @see isMondayEingeschraenkt($mietobjekt_id)
 */
function isSaturdayEingeschraenkt($mietobjekt_id){
	return isDayEingeschraenkt($mietobjekt_id,KURZFORM_SAMSTAG);	
}
/**
 * @see isMondayEingeschraenkt($mietobjekt_id)
 */
function isSundayEingeschraenkt($mietobjekt_id){
	return isDayEingeschraenkt($mietobjekt_id,KURZFORM_SONNTAG);
}
/**
 * datum 24. apr. 06
 * @author coster
 * @param $vermieter_id
 * @param $typ typ der buchungseinschraenkung
 */
function getMietobjekteWithBuchungseinschraenkungen($vermieter_id,$typ){
	global $link;	

	$query = ("SELECT distinct
			   m.*
			   FROM
			   REZ_GEN_BUCHUNGSEINSCHRAENKUNG b, REZ_GEN_MIETOBJEKT m
			   WHERE
			   b.MIETOBJEKT_ID = m.MIETOBJEKT_ID" .
			 " and" .
			 " m.VERMIETER_ID = '$vermieter_id'" .
			 " and" .
			 " b.TYP = '$typ'
   			  ");           

	$res = mysqli_query($link, $query);
	
	if (!$res) { 
		echo("die Anfrage $query scheitert"); 
		echo(mysqli_error($link));
		exit;
	}
	else{
		return $res;
	}
}
/**
 * datum 24. Apr. 06
 * @author coster
 * @param mietobject_id
 * @param $typ typ der buchungseinschraenkung
 * liefert alle buchungseinschränkungen eines gewissen typs
 */
function getBuchungseinschraenkungen($vermieter_id,$typ){
	
	global $link;	

	$query = ("SELECT 
			   b.*
			   FROM
			   REZ_GEN_BUCHUNGSEINSCHRAENKUNG b, REZ_GEN_MIETOBJEKT m
			   WHERE
			   b.MIETOBJEKT_ID = m.MIETOBJEKT_ID" .
			 " and" .
			 " m.VERMIETER_ID = '$vermieter_id'" .
			 " and" .
			 " b.TYP = '$typ'
   			  ");           

	$res = mysqli_query($link, $query);
	
	if (!$res) { 
		echo("die Anfrage $query scheitert"); 
		echo(mysqli_error($link));
		exit;
	}
	else{
		return $res;
	}
	
}
/**
 * datum 25. Apr. 06
 * @author coster
 * @param mietobject_id
 * @param $typ typ der buchungseinschraenkung
 * liefert alle buchungseinschränkungen eines gewissen typs und mietobjektes
 */
function getBuchungseinschraenkungenOfMietobjekt($mietobjekt_id,$typ){
	
	global $link;	

	$query = ("SELECT 
			   *
			   FROM
			   REZ_GEN_BUCHUNGSEINSCHRAENKUNG 
			   WHERE
			   MIETOBJEKT_ID = '$mietobjekt_id'" .
			 " and" .
			 " TYP = '$typ'
   			  ");           

	$res = mysqli_query($link, $query);
	
	if (!$res) { 
		echo("die Anfrage $query scheitert"); 
		echo(mysqli_error($link));
		exit;
	}
	else{
		return $res;
	}
	
}
/**
 * datum 17. Apr. 06
 * @author coster
 * @param mietobject_id
 * liefert die zeit an dem eine zeitliche buchungseinschraenkung beginnt
 */
function getBuchungseinschraenkungZeitVon($mietobjekt_id,$typ){
	
	global $link;	

	$query = ("SELECT 
			   VON
			   FROM
			   REZ_GEN_BUCHUNGSEINSCHRAENKUNG
			   WHERE
			   MIETOBJEKT_ID = '$mietobjekt_id'" .
			   		" and" .
			   		" TYP = '$typ'
   			  ");           

	$res = mysqli_query($link, $query);
	
	if (!$res) { 
		echo("die Anfrage $query scheitert"); 
		echo(mysqli_error($link));
		exit;
	}

	return $res;
	
	
}
/**
 * datum 17. Apr. 06
 * @author coster
 * @param mietobject_id
 * liefert die stunde an dem eine zeitliche buchungseinschraenkung beginnt
 */
function getBuchungseinschraenkungZeitVonStunde($mietobjekt_id){
	
	global $root;
	include_once($root."/include/datumFunctions.inc.php");
	$typ = BE_TYP_ZEIT_VON;
	$res = getBuchungseinschraenkungZeitVon($mietobjekt_id,$typ);
	$d = mysqli_fetch_array($res);
	$timestamp = $d["VON"];
	$std = getHourFromMySqlTimestamp($timestamp);
	return $std;
	
}
/**
 * datum 17. Apr. 06
 * @author coster
 * @param mietobject_id
 * liefert die minute an dem eine zeitliche buchungseinschraenkung beginnt
 */
function getBuchungseinschraenkungZeitVonMinute($mietobjekt_id){
	
	global $root;
	include_once($root."/include/datumFunctions.inc.php");
	$typ = BE_TYP_ZEIT_VON;
	$res = getBuchungseinschraenkungZeitVon($mietobjekt_id,$typ);
	$d = mysqli_fetch_array($res);
	$timestamp = $d["VON"];	
	$min = getMinuteFromMySqlTimestamp($timestamp);
	return $min;
	
}
/**
 * datum 24. Apr. 2006
 * @author coster
 * @param $buchungseinschr_id die id der buchungseinschraenkung
 * liefert alle daten einer buchungseinschraenkung
 */
 function getBuchungseinschraenkung($buchungseinschr_id){
 	global $link;	

	$query = ("SELECT 
			   *
			   FROM
			   REZ_GEN_BUCHUNGSEINSCHRAENKUNG
			   WHERE
			   EINSCHRAENKUNGS_ID = '$buchungseinschr_id'
   			  ");           

	$res = mysqli_query($link, $query);
	
	if (!$res) { 
		echo("die Anfrage $query scheitert"); 
		echo(mysqli_error($link));
		exit;
	}
	else{
		return mysqli_fetch_array($res);
	}
 }
/**
 * datum 24. Apr. 2006
 * @author coster
 * @param $buchungseinschr_id die id der buchungseinschraenkung
 * liefert die stunde von einer buchungseinschraenkung
 */
function getVonStundeOfBuchungseinschraenkung($buchungseinschr_id){
	$d = getBuchungseinschraenkung($buchungseinschr_id);
	global $root;
	include_once($root."/include/datumFunctions.inc.php");
	$timestamp = $d["VON"];	
	$min = getHourFromMySqlTimestamp($timestamp);
	return $min;
}
/**
 * datum 24. Apr. 2006
 * @author coster
 * @param $buchungseinschr_id die id der buchungseinschraenkung
 * liefert die stunde bis einer buchungseinschraenkung
 */
function getBisStundeOfBuchungseinschraenkung($buchungseinschr_id){
	$d = getBuchungseinschraenkung($buchungseinschr_id);
	global $root;
	include_once($root."/include/datumFunctions.inc.php");
	$timestamp = $d["BIS"];	
	$min = getHourFromMySqlTimestamp($timestamp);
	return $min;
}
/**
 * datum 24. Apr. 2006
 * @author coster
 * @param $buchungseinschr_id die id der buchungseinschraenkung
 * liefert die minute von einer buchungseinschraenkung
 */
function getVonMinuteOfBuchungseinschraenkung($buchungseinschr_id){
	$d = getBuchungseinschraenkung($buchungseinschr_id);
	global $root;
	include_once($root."/include/datumFunctions.inc.php");
	$timestamp = $d["VON"];	
	$min = getMinuteFromMySqlTimestamp($timestamp);
	return $min;
}
/**
 * datum 24. Apr. 2006
 * @author coster
 * @param $buchungseinschr_id die id der buchungseinschraenkung
 * liefert die minute von einer buchungseinschraenkung
 */
function getBisMinuteOfBuchungseinschraenkung($buchungseinschr_id){
	$d = getBuchungseinschraenkung($buchungseinschr_id);
	global $root;
	include_once($root."/include/datumFunctions.inc.php");
	$timestamp = $d["BIS"];	
	$min = getMinuteFromMySqlTimestamp($timestamp);
	return $min;
}
/**
 * datum 17. Apr. 06
 * @author coster
 * @param mietobject_id
 * liefert die zeit an dem eine zeitliche buchungseinschraenkung endet
 */
function getBuchungseinschraenkungZeitBis($mietobjekt_id,$typ){
	
	global $link;	

	$query = ("SELECT 
			   BIS
			   FROM
			   REZ_GEN_BUCHUNGSEINSCHRAENKUNG
			   WHERE
			   MIETOBJEKT_ID = '$mietobjekt_id'" .
			   		" and" .
			   		" TYP = '$typ'
   			  ");           

	$res = mysqli_query($link, $query);
	
	if (!$res) { 
		echo("die Anfrage $query scheitert"); 
		echo(mysqli_error($link));
		exit;
	}

	return $res;
	
	
}
/**
 * datum 17. Apr. 06
 * @author coster
 * @param mietobject_id
 * liefert die stunde an dem eine zeitliche buchungseinschraenkung endet
 */
function getBuchungseinschraenkungZeitBisStunde($mietobjekt_id){
	
	global $root;
	include_once($root."/include/datumFunctions.inc.php");
	$typ = BE_TYP_ZEIT_BIS;
	$res = getBuchungseinschraenkungZeitBis($mietobjekt_id,$typ); 
	$d = mysqli_fetch_array($res);
	$timestamp = $d["BIS"];	
	$std = getHourFromMySqlTimestamp($timestamp);
	return $std;
	
}
/**
 * datum 17. Apr. 06
 * @author coster
 * @param mietobject_id
 * liefert die minute an dem eine zeitliche buchungseinschraenkung endet
 */
function getBuchungseinschraenkungZeitBisMinute($mietobjekt_id){
	
	global $root;
	include_once($root."/include/datumFunctions.inc.php");
	$typ = BE_TYP_ZEIT_BIS;
	$res = getBuchungseinschraenkungZeitBis($mietobjekt_id,$typ); 
	$d = mysqli_fetch_array($res);
	$timestamp = $d["BIS"];	
	$min = getMinuteFromMySqlTimestamp($timestamp);
	return $min;
	
}
/**
 * datum 17. Apr. 06
 * @author coster
 * @param mietobject_id
 * @param $tag Kurzform aus datumFunctions.inc.php
 * prueft ob an einem tag eine buchungseinschränkung existiert
 */
function hasBuchungseinschraenkungOnDay($mietobjekt_id,$tag){
	
	global $root;
	include_once($root."/include/datumFunctions.inc.php");
	$typ = BE_TYP_TAG;
	$res = getBuchungseinschraenkungZeitBis($mietobjekt_id,$typ); 
	while($d = mysqli_fetch_array($res)){
		$timestamp = $d["VON"];
		$day = getDayFromMySqlTimestamp($timestamp);
		if ($tag == $day){
			return true;
		}	
	}
	return false;
	
}

?>