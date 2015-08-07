<?php

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 

/**
	Konstanten für Properties
*/
define("ZIMMER_THUMBS_ACTIV", "zimmerThumbsActiv"); //zeigt, dass der benutzer in der suchfunktion thumbnails der zimmer anzeigen will
define("ZIMMER_THUMBS_AV_OV", "zimmerThumbsinBelegungsplan"); //zeigt, dass der benutzer im belegungsplan bilder anzeigen will
define("BILDER_SUCHE_WIDTH", "sucheWidth"); //die breite der bilder in den suchergebnissen, standard breite
define("BILDER_SUCHE_HEIGHT", "sucheHeight"); //die höhe der bilder in den suchergebnisssen, standard
define("KINDER_SUCHE", "Kinder");
define("HAUSTIERE_ALLOWED","Haustiere");
define("LINK_SUCHE","Link");
define("SHOW_OTHER_COLOR_FOR_SA","andere Farbe fuer Samstag");
define("SUCHFILTER_ZIMMER","erwachsene und kinder nach einzelnen zimmer filtern");
define("SUCHFILTER_UNTERKUNFT","erwachsene und kinder nach unterkunft filtern");
//pension: werte werden mit true oder false belegt
define("PENSION_UEBERNACHTUNG","pension nur mit uebernachtung");
define("PENSION_FRUEHSTUECK","fruehstueckspension");
define("PENSION_HALB","halbpension");
define("PENSION_VOLL","vollpension");
define("MAIL_KOPIE_AN_VERMIETER_ANFRAGE","mailKopieAnVermieterSendenAnfrage"); //sollen alle ausgehenden Mails auch an den Vermieter gesendet werden? true oder false
define("MAIL_KOPIE_AN_VERMIETER_ABLEHNUNG","mailKopieAnVermieterSendenAblehnung"); //sollen alle ausgehenden Mails auch an den Vermieter gesendet werden? true oder false
define("MAIL_KOPIE_AN_VERMIETER_BESTAETIGUNG","mailKopieAnVermieterSendenBestaetigung"); //sollen alle ausgehenden Mails auch an den Vermieter gesendet werden? true oder false
define("SHOW_ZIMMER_ATTRIBUTE_GESAMTUEBERSICHT","showZimmerAttributeInGesamtuebersicht"); //set to "true" or "false" as String
define("HORIZONTAL_FRAME","frameHorinzontalTeilen");//set to "true" or "false" as String
define("SHOW_MONATSANSICHT","monatsansichtAnzeigen");
define("SHOW_JAHRESANSICHT","jahresansichtAnzeigen");
define("SHOW_GESAMTANSICHT","gesamtansichtAnzeigen");
define("SHOW_RESERVATION_STATE","statusReserviertAnzeigen"); //set to true if incoming reservation requests should be shown 
define("RESERVATION_STATE_TIME","zeitspanneAnzeigenReservierung"); //time to delete the reservation if not confirmed
define("SEARCH_SHOW_PARENT_ROOM","showParentRoomInSearchForm"); //show the parent room in search form
define("RES_HOUSE","reservationForCompleteHouse"); //set to true if a house should be reserved if a room of the house is reserved

/**
	prüft ob ein property bereits vorhanden ist
	author: coster
	date: 4. aug. 2005
*/
function isPropertyInDatabase($name,$unterkunft_id,$link){
		
		$query = "SELECT
				  Name
				  FROM
				  Rezervi_Properties
				  WHERE
				  FK_Unterkunft_ID = '$unterkunft_id'
				  AND			  
				  Name = '$name'
				 ";

  		$res = mysql_query($query, $link);
  		
  		if (!$res){
  			echo(mysql_error($link));
  			echo("Anfrage $query scheitert.");
  			return false;
  		}
		else{	
			$d = mysql_fetch_array($res);	
			if ($d["Name"] == $name){
				return true;
			}
			else{
				return false;
			}
		}
}
/**
	setzt ein property
	author: coster
	date: 4. aug. 2005
*/
function setProperty($name,$value,$unterkunft_id,$link){
	
		$val = isPropertyInDatabase($name,$unterkunft_id,$link);
				
		if ($val != true){			
			$query = "INSERT INTO 
					  Rezervi_Properties
					  (FK_Unterkunft_ID,Name,Value)
					  VALUES
					  ('$unterkunft_id','$name','$value')				  
					 ";

		}
		else{
			$query = "UPDATE 
					  Rezervi_Properties
					  SET
					  Value = '$value'
					  WHERE
					  FK_Unterkunft_ID = '$unterkunft_id'
					  AND
					  Name = '$name'		  
					 ";
		}

  		$res = mysql_query($query, $link);
  		
  		if (!$res){
  			echo(mysql_error($link));
  			echo("Anfrage $query scheitert.");
  			return false;
  		}
		else{		
			return true;
		}	
			
} 
/**
setzt die default values:
author: coster
date: 28.8.05
change: 4.11.05, coster
*/
function setDefaultValues($unterkunft_id,$link){

	setProperty(ZIMMER_THUMBS_ACTIV,"false",$unterkunft_id,$link);
	setProperty(KINDER_SUCHE,"false",$unterkunft_id,$link);
	setProperty(HAUSTIERE_ALLOWED,"false",$unterkunft_id,$link);
	setProperty(LINK_SUCHE,"false",$unterkunft_id,$link);
	setProperty(SHOW_OTHER_COLOR_FOR_SA,"false",$unterkunft_id,$link);
	setProperty(SUCHFILTER_UNTERKUNFT,"true",$unterkunft_id,$link);
	setProperty(SUCHFILTER_ZIMMER,"false",$unterkunft_id,$link);
	//pensionswerte mit false vorbelegen:
	setProperty(PENSION_FRUEHSTUECK,"false",$unterkunft_id,$link);
	setProperty(PENSION_HALB,"false",$unterkunft_id,$link);
	setProperty(PENSION_VOLL,"false",$unterkunft_id,$link);
	setProperty(PENSION_UEBERNACHTUNG,"false",$unterkunft_id,$link);
	setProperty(SHOW_GESAMTANSICHT,"true",$unterkunft_id,$link);
	setProperty(SHOW_MONATSANSICHT,"true",$unterkunft_id,$link);
	setProperty(SHOW_JAHRESANSICHT,"true",$unterkunft_id,$link);
	setProperty(SHOW_RESERVATION_STATE,"false",$unterkunft_id,$link);
	setProperty(RESERVATION_STATE_TIME,"0",$unterkunft_id,$link);
	setProperty(ZIMMER_THUMBS_AV_OV,"false",$unterkunft_id,$link);
	setProperty(SEARCH_SHOW_PARENT_ROOM,"false",$unterkunft_id,$link);
	setProperty(RES_HOUSE,"true",$unterkunft_id,$link);
	
}
/**
	liest den wert eines property
	author: coster
	date: 4. aug. 2005
*/
function getPropertyValue($name,$unterkunft_id,$link){
		
		$query = "SELECT
				  Value
				  FROM
				  Rezervi_Properties
				  WHERE
				  FK_Unterkunft_ID = '$unterkunft_id'
				  AND			  
				  Name = '$name'
				 ";

  		$res = mysql_query($query, $link);
  		
  		if (!$res){
  			echo(mysql_error($link));
  			echo("Anfrage $query scheitert.");
  			return false;
  		}
		else{	
			$d = mysql_fetch_array($res);	
			return $d["Value"];
		}	

}

/**
liefert alle Auswahlmöglichkeiten bei der Suche
*/
function getPropertiesSuche($unterkunft_id, $link){
		$prop1 = KINDER_SUCHE;
		$prop2 = HAUSTIERE_ALLOWED;
		$prop3 = LINK_SUCHE;
		
		$query = "SELECT  
			      Name
			      FROM
			      Rezervi_Properties
			      WHERE 
				  FK_Unterkunft_ID = '$unterkunft_id'
				  AND
				  (
				  Name = '$prop1'
				  OR
				  Name = '$prop2'
				  OR
				  Name = '$prop3'
				  )
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
		else		
			return $res;
}
   
/**
zeigt bereits aktivierte Suchmöglichkeiten an
*/
function isPropertyShown($unterkunft_id,$name,$link)
{
  $query = "SELECT
            Value
			FROM
			Rezervi_Properties
			WHERE
			Name = '$name' && Value = 'true'
			";
  //echo("<h4>: Echo query: " . $query . "</h4>");

  $res = mysql_query($query, $link);
  if (!$res)
    echo("Anfrage $query scheitert.");
  else
  {
    while($array = mysql_fetch_array($res))
	{
  	  $wert = $array["Value"];
	  return $wert;
	}
  }
}

?>
