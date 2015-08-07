<?php
/*
 * Created on 17.04.2006
 * @author coster
 */

define("BE_TYP_ZEIT","buchungsein zeit von");
define("BE_TYP_TAG","buchungsein tag");
define("BE_TYP_DATUM_VON_BIS","buchungsein datum vonBis");

/**
@author coster
@date 30.07.2007
gets the 'from-date' of a limitation
* */
function getFromDateOfLimitation($limit_id){
	
	global $db;	
	if (empty($db)){
		die("Global variable db not exists!");
	}
	
	$query = ("SELECT 
			   VON
			   FROM
			   BOOKLINE_RESERVIERUNGSEINSCHRAENKUNG
			   WHERE
			   RESERVIERUNGSEINSCHRAENKUNG_ID = '$limit_id'
   			  ") ;          

	$res = $db->Execute($query);
	
	if (!$res) {		 
		print $db->ErrorMsg();
		die($query);
	}
	else{
		return $res->fields["VON"];
	}

}
/**
@author coster
@date 30.07.2007
gets the 'to-date' of a limitation
* */
function getToDateOfLimitation($limit_id){
	
	global $db;	
	if (empty($db)){
		die("Global variable db not exists!");
	}
	
	$query = ("SELECT 
			   BIS
			   FROM
			   BOOKLINE_RESERVIERUNGSEINSCHRAENKUNG
			   WHERE
			   RESERVIERUNGSEINSCHRAENKUNG_ID = '$limit_id'
   			  ") ;          

	$res = $db->Execute($query);
	
	if (!$res) {		 
		print $db->ErrorMsg();
		die($query);
	}
	else{
		return $res->fields["BIS"];
	}

}
/**
@author coster
@date 30.07.2007
gets the typ of a limitation
* */
function getTypOfLimitation($limit_id){
	
	global $db;	
	if (empty($db)){
		die("Global variable db not exists!");
	}
	
	$query = ("SELECT 
			   TYP
			   FROM
			   BOOKLINE_RESERVIERUNGSEINSCHRAENKUNG
			   WHERE
			   RESERVIERUNGSEINSCHRAENKUNG_ID = '$limit_id'
   			  ") ;          

	$res = $db->Execute($query);
	
	if (!$res) {		 
		print $db->ErrorMsg();
		die($query);
	}
	else{
		return $res->fields["TYP"];
	}

}
/**
@author coster
@date 30.07.2007
removes all limitations with the same dates
@parameter $einschraenkungs_id the id of the limitation
* */
function deleteSameBuchungseinschraenkungen($einschraenkungs_id){
	
	global $db;	
	global $gastro_id;
	global $root;
	
	if (empty($db) || empty($gastro_id) || empty($root)){
		die("Fehler bei globaler Variable.");
	}
	
	$typ = getTypOfLimitation($einschraenkungs_id);
	$von = getFromDateOfLimitation($einschraenkungs_id);
	$bis = getToDateOfLimitation($einschraenkungs_id);
		
	$query = ("delete
			   from
			   BOOKLINE_RESERVIERUNGSEINSCHRAENKUNG
			   where
			   TYP = '$typ' and
			   VON = '$von' and
			   BIS = '$bis' 
   			  ");  
	$res = $db->Execute($query);
	if (!$res) {		 
		print $db->ErrorMsg();
		die($query);
	}
	else{
		$res = $db->Execute($query);
  		if ($res){	
			return true;	
  		}
	}
	return false;

}
/**
@author coster
@date 30.07.2007
check of all tables of an gastronomy has the same limitation of a typ
* */
function hasAllTablesSameLimitation($einschraenkungs_id){
	
	global $db;	
	global $gastro_id;
	global $root;
	
	if (empty($db) || empty($gastro_id) || empty($root)){
		die("Fehler bei globaler Variable.");
	}
	
	$anzahlEinschr = 0;
	
	$typ = getTypOfLimitation($einschraenkungs_id);
	$von = getFromDateOfLimitation($einschraenkungs_id);
	$bis = getToDateOfLimitation($einschraenkungs_id);
		
	$query = ("select count(res.TISCHNUMMER) as anzahl
			   from
			   BOOKLINE_RESERVIERUNGSEINSCHRAENKUNG res, BOOKLINE_TISCH tisch, BOOKLINE_RAUM raum
			   where
			   TYP = '$typ' and
			   VON = '$von' and
			   BIS = '$bis' and
			   res.TISCHNUMMER = tisch.TISCHNUMMER 
			   and
			   tisch.RAUM_ID = raum.RAUM_ID
    	       and
			   raum.GASTRO_ID = '$gastro_id'
   			  ");  
	$res = $db->Execute($query);
	if (!$res) {		 
		print $db->ErrorMsg();
		die($query);
	}
	else{
		$res = $db->Execute($query);
  		if ($res){	
			$anzahlEinschr = $res->fields["anzahl"];	
  		}
	}
	
	include_once($root."/include/mietobjektFunctions.inc.php");
	$anzahlTische = getAnzahlVorhandeneTische($gastro_id);
	if ($anzahlTische <= $anzahlEinschr){
		return true;
	}
	return false;

}
/**
@author coster
@date 30.07.2007
check of all tables of an gastronomy has the same limitations of a typ
* */
function hasAllTablesWithTypSameLimitation($tischnummer,$typ){
	
	global $db;	
	global $gastro_id;
	global $root;
	
	if (empty($db) || empty($gastro_id) || empty($root)){
		die("Fehler bei globaler Variable.");
	}
	
	$anzahlEinschr = 0;
	$res = getBuchungseinschraenkungenOfTisch($tischnummer,$typ);
	$d = $res->FetchNextObject();
	$einschraenkungs_id = $d->RESERVIERUNGSEINSCHRAENKUNG_ID;
	$von = getFromDateOfLimitation($einschraenkungs_id);
	$bis = getToDateOfLimitation($einschraenkungs_id);
		
	$query = ("select count(res.TISCHNUMMER) as anzahl
			   from
			   BOOKLINE_RESERVIERUNGSEINSCHRAENKUNG res, BOOKLINE_TISCH tisch, BOOKLINE_RAUM raum
			   where
			   TYP = '$typ' and
			   VON = '$von' and
			   BIS = '$bis' and
			   res.TISCHNUMMER = tisch.TISCHNUMMER 
			   and
			   tisch.RAUM_ID = raum.RAUM_ID
    	       and
			   raum.GASTRO_ID = '$gastro_id'
   			  ");  
	$res = $db->Execute($query);
	if (!$res) {		 
		print $db->ErrorMsg();
		die($query);
	}
	else{
		$res = $db->Execute($query);
  		if ($res){	
			$anzahlEinschr = $res->fields["anzahl"];	
  		}
	}


	//zaehle alle des typs:
	$query = ("select count(res.TISCHNUMMER) as anzahl
			   from
			   BOOKLINE_RESERVIERUNGSEINSCHRAENKUNG res, BOOKLINE_TISCH tisch, BOOKLINE_RAUM raum
			   where
			   TYP = '$typ' 
			   and
			   res.TISCHNUMMER = tisch.TISCHNUMMER 
			   and
			   tisch.RAUM_ID = raum.RAUM_ID
    	       and
			   raum.GASTRO_ID = '$gastro_id'
   			  ");  
	$res = $db->Execute($query);
	if (!$res) {		 
		print $db->ErrorMsg();
		die($query);
	}
	else{
		$res = $db->Execute($query);
  		if ($res){	
			$anzahlTyp = $res->fields["anzahl"];	
  		}
	}
	
	if ($anzahlEinschr == $anzahlTyp){
		return true;
	}
	return false;

}
/**
@author coster
@date 30.07.2007
check of all tables of an gastronomy has the same limitation of a typ
* */
function hasAllTablesWithTableIdSameLimitation($tischnummer,$typ){
	
	global $db;	
	global $gastro_id;
	global $root;
	
	if (empty($db) || empty($gastro_id) || empty($root)){
		die("Fehler bei globaler Variable.");
	}
	
	$anzahlEinschr = 0;
	$res = getBuchungseinschraenkungenOfTisch($tischnummer,$typ);
	$d = $res->FetchNextObject();
	$einschraenkungs_id = $d->RESERVIERUNGSEINSCHRAENKUNG_ID;
	$von = getFromDateOfLimitation($einschraenkungs_id);
	$bis = getToDateOfLimitation($einschraenkungs_id);
		
	$query = ("select count(TISCHNUMMER) as anzahl
			   from
			   BOOKLINE_RESERVIERUNGSEINSCHRAENKUNG
			   where
			   TYP = '$typ' and
			   VON = '$von' and
			   BIS = '$bis' 
   			  ");  
	$res = $db->Execute($query);
	if (!$res) {		 
		print $db->ErrorMsg();
		die($query);
	}
	else{
		$res = $db->Execute($query);
  		if ($res){	
			$anzahlEinschr = $res->fields["anzahl"];	
  		}
	}

	include_once($root."/include/mietobjektFunctions.inc.php");
	$anzahlTische = getAnzahlVorhandeneTische($gastro_id);
	if ($anzahlTische == $anzahlEinschr){
		return true;
	}
	return false;

}
/**
 * @author coster
 * date: 24.4.06
 * loescht eine buchungseinschraenkung
 */
 function deleteBuchungseinschraenkung($einschraenkungs_id){
 
	global $db;	
	if (empty($db)){
		die("Fehler bei globaler Variable.");
	}
	
	$query = ("delete from BOOKLINE_RESERVIERUNGSEINSCHRAENKUNG where " .
			"RESERVIERUNGSEINSCHRAENKUNG_ID = '$einschraenkungs_id'");      
	
	$res = $db->Execute($query);
	
	if (!$res) { 		 
		print $db->ErrorMsg();
		die($query);
	}
	else{
		return true;
	}
	
 }
 /**
  * loescht alle buchungseinschraenkungen eines tisches eines bestimmten typs
  * @author coster
  * datum: 25.4.06
  * @param $mietobjekt_id id des mietobjektes
  * @param $typ typ konstante
  */
  function deleteBuchungseinschraenkungenOfTisch($mietobjekt_id,$typ){
  	
  	global $db;	
	if (empty($db)){
		die("Fehler bei globaler Variable.");
	}

	$query = ("delete from BOOKLINE_RESERVIERUNGSEINSCHRAENKUNG where " .
			"TISCHNUMMER = '$mietobjekt_id' and TYP = '$typ'");      
	
	$res = $db->Execute($query);
	
	if (!$res) { 		 
		print $db->ErrorMsg();
		die($query);
	}
	else{
		return true;
	}
  	
  }
 /**
  * loescht alle buchungseinschraenkungen eines typs 
  * @author coster
  * datum: 30.7.2007
  * @param $typ typ konstante
  */
  function deleteBuchungseinschraenkungenOfTyp($typ){
  	
  	global $db;	
  	global $gastro_id;
	if (empty($db) || empty($gastro_id)){
		die("Fehler bei globaler Variable.");
	}

	$res = getBuchungseinschraenkungen($gastro_id,$typ);
	while ($d = $res->FetchNextObject()){
		$res_id = $d->RESERVIERUNGSEINSCHRAENKUNG_ID;
		deleteBuchungseinschraenkung($res_id);
	}
	return true;
  	
  }  
 /**
  * fuegt eine buchungseinschraenkung fuer einen bestimmten tag ein
  * das mietobjekt und der tag sind unique
  * @author:coster
  * datum: 25.4.06
  * @param $mietobjekt_id id des mietobjektes
  * @param $tag die konstante f�r die kurzbezeichnung des tages aus datumFuntions.inc.php
  */
 function insertBuchungseinschraenkungTag($mietobjekt_id,$tag){
 	
 	global $root;
 	global $db;
	if (empty($db) || empty($root)){
		die("Fehler bei globaler Variable.");
	}
 	
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
		echo("fehlerhafte Übergabe des Tages! insertBuchungunseinschraenkungTag tag=".$tag);
		exit;
	}

	$timestampVon = constructBooklineDate($jahr,$monat,$tag,$stunde,$minute);
	$timestampBis = constructBooklineDate($jahr,$monat,$tag,$stunde,$minute);
	
	if ($update){
	}
	else{
		$query = ("insert into
				   BOOKLINE_RESERVIERUNGSEINSCHRAENKUNG
				   (TISCHNUMMER,VON,BIS,TYP)
				   values" .
				 " ('$mietobjekt_id','$timestampVon','$timestampBis','$typ')
	   			  ");  
		$res = $db->Execute($query);
		
		if (!$res) {		 
			print $db->ErrorMsg();
			die($query);
		}
	}
	return true;

 }
/**
@author coster
@date 30.07.2007
prueft ob eine buchungseinschraenkung existiert
* */
function hasBuchungseinschraenkung($mietobjekt_id,$vonJahr,$vonMonat,$vonTag,$vonStunde,$vonMinute,$bisJahr,$bisMonat,$bisTag,$bisStunde,$bisMinute,$typ){
	
	global $db;	
	global $root;
	
	if (empty($db) || empty($root)){
		die("Fehler bei globaler Variable.");
	}
	
	include_once($root."/include/datumFunctions.inc.php");
	$von = constructBooklineDate($vonJahr,$vonMonat,$vonTag,$vonStunde,$vonMinute);
	$bis = constructBooklineDate($bisJahr,$bisMonat,$bisTag,$bisStunde,$bisMinute);
		
	$query = ("select count(TISCHNUMMER) as anzahl
			   from
			   BOOKLINE_RESERVIERUNGSEINSCHRAENKUNG
			   where
			   TYP = '$typ' and
			   VON = '$von' and
			   BIS = '$bis' and 
			   TISCHNUMMER = '$mietobjekt_id'
   			  ");  
	$res = $db->Execute($query);
	if (!$res) {		 
		print $db->ErrorMsg();
		die($query);
	}
	else{
		$res = $db->Execute($query);
  		if ($res){	
			if($res->fields["anzahl"] > 0){
				return true;	
			}
  		}
	}

	return false;

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
	
	//pruefe ob nicht dieselbe buchungseinschraenkung bereits
	//vorhanden ist:
	$hasBE = hasBuchungseinschraenkung($mietobjekt_id,$jahr,$monat,$tag,$vonStunde,$vonMinute,$jahr,$monat,$tag,$bisStunde,$bisMinute,$typ);
	if ($hasBE){
		echo "hier:".$mietobjekt_id;
		return;
	}
	
	$timestampVon = constructBooklineDate($jahr,$monat,$tag,$vonStunde,$vonMinute);
	$timestampBis = constructBooklineDate($jahr,$monat,$tag,$bisStunde,$bisMinute);
	
	setBuchungseinschraenkung($mietobjekt_id,$timestampVon,$timestampBis,$typ);
	
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
	
	global $db;
	
	$query = ("insert into
	   BOOKLINE_RESERVIERUNGSEINSCHRAENKUNG
	   (TISCHNUMMER,VON,BIS,TYP)
	   values" .
	 " ('$mietobjekt_id','$datumVon','$datumBis','$typ')
	  ");           
	
	$res = $db->Execute($query);
	
	if (!$res) {		 
		print $db->ErrorMsg();
		die($query);
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
function setBuchungseinschraenkungUniqueTisch($mietobjekt_id,$timestampVon,$timestampBis,$typ){
	
	global $db;	
	if (hasMietobjektBuchungseinschraenkung($mietobjekt_id,$typ) == true){
		$query = ("update BOOKLINE_RESERVIERUNGSEINSCHRAENKUNG set " .
				"VON = '$timestampVon', " .
				"BIS = '$timestampBis', " .
				"TYP = '$typ' " .
				"where TISCHNUMMER = '$mietobjekt_id'");
	}
	else{
		$query = ("insert into
				   BOOKLINE_RESERVIERUNGSEINSCHRAENKUNG
				   (TISCHNUMMER,VON,BIS,TYP)
				   values" .
				 " ('$mietobjekt_id','$timestampVon','$timestampBis','$typ')
	   			  ");           
	}
	
	$res = $db->Execute($query);
	
	if (!$res) {		 
		print $db->ErrorMsg();
		die($query);
	}
	else{
		return true;
	}
}
/**
 * insert a limitation for a table
 * @author coster
 * date 24.4.06
 */
function setBuchungseinschraenkung($mietobjekt_id,$timestampVon,$timestampBis,$typ){
	
	global $db;
	if (empty($db)){
		die ("Fehler bei globaler Variablen!");	
	}

	$query = ("insert into
			   BOOKLINE_RESERVIERUNGSEINSCHRAENKUNG
			   (TISCHNUMMER,VON,BIS,TYP)
			   values" .
			 " ('$mietobjekt_id','$timestampVon','$timestampBis','$typ')
   			  ");           
	
	$res = $db->Execute($query);
	
	if (!$res) {		 
		print $db->ErrorMsg();
		die($query);
	}
	else{
		return true;
	}
}
function hasMietobjektBuchungseinschraenkung($mietobjekt_id,$typ){
	global $db;	

	$query = ("select count(TISCHNUMMER) as anzahl
			   from" .
			   		" BOOKLINE_RESERVIERUNGSEINSCHRAENKUNG" .
			   		" where" .
			   		" TYP = '$typ' and" .
			   		" TISCHNUMMER = '$mietobjekt_id'
   			  ");           

	$res = $db->Execute($query);
	
	if (!$res) {		 
		print $db->ErrorMsg();
		die($query);
	}
	else{
		$res = $db->Execute($query);
  		if ($res){	
			return $res->fields["anzahl"];	
  		}
	}
	return false;
}
function isDayEingeschraenkt($mietobjekt_id,$day){
	global $root;
	include_once($root."/include/datumFunctions.inc.php");
	$typ = BE_TYP_TAG;
	$res = getBuchungseinschraenkungZeitVon($mietobjekt_id,$typ);
	while($d = $res->FetchNextObject()){
		$timestamp = $d->VON;
		$tag = getDayFromBooklineDate($timestamp);		
		$monat = getMonthFromBooklineDate($timestamp);
		$jahr = getYearFromBooklineDate($timestamp);
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
 * @param $gastro_id
 * @param $typ typ der buchungseinschraenkung
 */
function getTischeWithBuchungseinschraenkungen($gastro_id,$typ){
	global $db;	

	$query = ("SELECT distinct
			   tisch.*
			   FROM
			   BOOKLINE_RESERVIERUNGSEINSCHRAENKUNG eins, BOOKLINE_TISCH tisch, BOOKLINE_RAUM raum
			   WHERE
			   tisch.TISCHNUMMER = eins.TISCHNUMMER
			   and
			   tisch.RAUM_ID = raum.RAUM_ID
			   and
			   raum.GASTRO_ID = '$gastro_id'
			   and
			   eins.TYP = '$typ'
   			  ");           

	$res = $db->Execute($query);
	
	if (!$res) { 		 
		print $db->ErrorMsg();
		die($query);
	}
	else{
		return $res;
	}
}
/**
 * count tables with the same typ of limitation
 * @date 30.07.2007
 * @author coster
 * @param $gastro_id
 * @param $typ typ der buchungseinschraenkung
 */
function countTischeWithBuchungseinschraenkungen($gastro_id,$typ){
	global $db;	

	$query = ("SELECT distinct
			   count(tisch.TISCHNUMMER) as anzahl
			   FROM
			   BOOKLINE_RESERVIERUNGSEINSCHRAENKUNG eins, BOOKLINE_TISCH tisch, BOOKLINE_RAUM raum
			   WHERE
			   tisch.TISCHNUMMER = eins.TISCHNUMMER
			   and
			   tisch.RAUM_ID = raum.RAUM_ID
			   and
			   raum.GASTRO_ID = '$gastro_id'
			   and
			   eins.TYP = '$typ'
   			  ");           

	$res = $db->Execute($query);
	
	if (!$res) { 		 
		print $db->ErrorMsg();
		die($query);
	}
	else{
		return $res->fields["anzahl"];	
	}
}
/**
 * datum 24. Apr. 06
 * @author coster
 * @param mietobject_id
 * @param $typ typ der buchungseinschraenkung
 * liefert alle buchungseinschränkungen eines gewissen typs
 */
function getBuchungseinschraenkungen($gastro_id,$typ){
	
	global $db;	

	$query = ("SELECT 
			   ein.*
			   FROM
			   BOOKLINE_RESERVIERUNGSEINSCHRAENKUNG ein, BOOKLINE_TISCH tisch, BOOKLINE_RAUM raum
			   WHERE
			   tisch.TISCHNUMMER = ein.TISCHNUMMER
			   and
			   tisch.RAUM_ID = raum.RAUM_ID 
			   and
			   raum.GASTRO_ID = '$gastro_id'
			   and
			   ein.TYP = '$typ'
			   order by
               raum.BEZEICHNUNG
   			  ") ;          

	$res = $db->Execute($query);
	
	if (!$res) {		 
		print $db->ErrorMsg();
		die($query);
	}
	else{
		return $res;
	}
	
}
/**
 * datum 25. Apr. 06
 * @author coster
 * @param mietobject_id die tischnummer
 * @param $typ typ der buchungseinschraenkung
 * liefert alle buchungseinschraenkungen eines gewissen typs und tisches
 */
function getBuchungseinschraenkungenOfTisch($mietobjekt_id,$typ){
	
	global $db;	

	$query = ("SELECT 
			   *
			   FROM
			   BOOKLINE_RESERVIERUNGSEINSCHRAENKUNG 
			   WHERE
			   TISCHNUMMER = '$mietobjekt_id'" .
			 " and" .
			 " TYP = '$typ'
   			  ");           

	$res = $db->Execute($query);
	
	if (!$res) { 		 
		print $db->ErrorMsg();
		die($query);
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
	
	global $db;	

	$query = ("SELECT 
			   VON
			   FROM
			   BOOKLINE_RESERVIERUNGSEINSCHRAENKUNG
			   WHERE
			   TISCHNUMMER = '$mietobjekt_id'" .
			   		" and" .
			   		" TYP = '$typ'
   			  ");           

	$res = $db->Execute($query);
	
	if (!$res) { 		 
		print $db->ErrorMsg();
		die($query);
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
	$d = $res->FetchNextObject();
	$timestamp = $d->VON;
	$std = getHourFromBooklineDate($timestamp);
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
	$d = $res->FetchNextObject();
	$timestamp = $d->VON;	
	$min = getMinuteFromBooklineDate($timestamp);
	return $min;
	
}
/**
 * datum 24. Apr. 2006
 * @author coster
 * @param $buchungseinschr_id die id der buchungseinschraenkung
 * liefert alle daten einer buchungseinschraenkung
 */
 function getBuchungseinschraenkung($buchungseinschr_id){
 	global $db;	

	$query = ("SELECT 
			   *
			   FROM
			   BOOKLINE_RESERVIERUNGSEINSCHRAENKUNG
			   WHERE
			   RESERVIERUNGSEINSCHRAENKUNG_ID = '$buchungseinschr_id'
   			  ");           

	$res = $db->Execute($query);
	
	if (!$res) {		 
		print $db->ErrorMsg();
		die($query);
	}
	else{
		return $res->FetchNextObject();
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
	if (empty($d)){
		return false;
	}
	global $root;
	include_once($root."/include/datumFunctions.inc.php");
	$timestamp = $d->VON;	
	$min = getHourFromBooklineDate($timestamp);
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
	if (empty($d)){
		return false;
	}
	global $root;
	include_once($root."/include/datumFunctions.inc.php");
	$timestamp = $d->BIS;	
	$min = getHourFromBooklineDate($timestamp);
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
	if (empty($d)){
		return false;
	}
	global $root;
	include_once($root."/include/datumFunctions.inc.php");
	$timestamp = $d->VON;	
	$min = getMinuteFromBooklineDate($timestamp);
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
	if (empty($d)){
		return false;
	}
	global $root;
	include_once($root."/include/datumFunctions.inc.php");
	$timestamp = $d->BIS;	
	$min = getMinuteFromBooklineDate($timestamp);
	return $min;
}
/**
 * datum 24. Apr. 2006
 * @author coster
 * @param $buchungseinschr_id die id der buchungseinschraenkung
 * liefert die minute von einer buchungseinschraenkung
 */
function getTischnummerOfBuchungseinschraenkung($buchungseinschr_id){
	$d = getBuchungseinschraenkung($buchungseinschr_id);
	if (empty($d)){
		return false;
	}
	return $d->TISCHNUMMER;	

}
/**
 * datum 17. Apr. 06
 * @author coster
 * @param mietobject_id
 * liefert die zeit an dem eine zeitliche buchungseinschraenkung endet
 */
function getBuchungseinschraenkungZeitBis($mietobjekt_id,$typ){
	
	global $db;	

	$query = ("SELECT 
			   BIS
			   FROM
			   BOOKLINE_RESERVIERUNGSEINSCHRAENKUNG
			   WHERE
			   TISCHNUMMER = '$mietobjekt_id'" .
			   		" and" .
			   		" TYP = '$typ'
   			  ");           

	$res = $db->Execute($query);
	
	if (!$res) {		 
		print $db->ErrorMsg();
		die($query);
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
	$d = $res->FetchNextObject();
	$timestamp = $d->BIS;	
	$std = getHourFromBooklineDate($timestamp);
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
	$d = $res->FetchNextObject();
	$timestamp = $d->BIS;	
	$min = getMinuteFromBooklineDate($timestamp);
	return $min;
	
}
/**
 * datum 17. Apr. 06
 * @author coster
 * @param mietobject_id
 * @param $tag Kurzform aus datumFunctions.inc.php
 * prueft ob an einem tag eine buchungseinschr�nkung existiert
 */
function hasBuchungseinschraenkungOnDay($mietobjekt_id,$tag){
	
	global $root;
	include_once($root."/include/datumFunctions.inc.php");
	$typ = BE_TYP_TAG;
	$res = getBuchungseinschraenkungZeitBis($mietobjekt_id,$typ); 
	while($d = $res->FetchNextObject()){		
		$timestamp = $d->VON;
		$day = getDayFromBooklineDate($timestamp);
		if ($tag == $day){
			return true;
		}	
	}
	return false;
	
}

?>