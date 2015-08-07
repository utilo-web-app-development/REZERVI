<?php
/*
	funktionen zum bearbeiten der stylesheets
	project: rezervi generic
*/

//konstanten fuer die css klassen => classname:
define("BACKGROUND_COLOR","backgroundColor"); //hintergrundfarbe der seiten
define("STANDARD_SCHRIFT","standardSchrift"); //standardschrift
define("BELEGT","belegt"); //farbe bzw. anzeige des status belegt
define("FREI","frei"); //farbe bzw. anzeige des status frei
define("RESERVIERT","reserviert"); //farbe bzw. anzeige des status frei
define("STANDARD_SCHRIFT_BOLD","standardSchriftBold"); //standardschrift fett
define("SCHRIFT_KLEIN","kleineSchrift"); //schrift klein z.b. fuer footer
define("UEBERSCHRIFT","ueberschrift"); //ueberschrift
define("TABLE_STANDARD","table");
define("TABLE_COLOR","tableColor");
define("BUTTON","button200pxA");
define("BUTTON_HOVER","button200pxB");
define("SELECT","selects"); //fuer select boxen, textfelder, etc.
define("TISCH_BELEGT","tischbelegt"); //symbol fuer einen belegten tisch der frontpage
define("TISCH_FREI","tischfrei"); //symbol fuer einen freuen tisch der frontpage

/**
 * author: coster
 * date: 7.10.05
 * setzt die standardwerte der css eines vermieters
 * 
 * */
 function setStandardCSS($gastro_id){
 	
 	setStyle(TISCH_BELEGT,"width: 75px;
							height: 75px;
							background-image:url(\"./templates/img/besteckgekreuzt.gif\");
							",
 			 $gastro_id);
 	setStyle(TISCH_FREI,"width: 75px;
							height:75px;
							background-image:url(\"./templates/img/besteckNebeneinander.gif\");
							",
 			 $gastro_id);
 
 	setStyle(BACKGROUND_COLOR,"background-color: #FFFFFF;
							  ",$gastro_id);
 	setStyle(STANDARD_SCHRIFT,"font-family: Arial, Helvetica, sans-serif;
												font-size: 12px;
												font-style: normal;
												line-height: normal;
												font-weight: normal;
												font-variant: normal;
												color: #000000;
							  ",$gastro_id);
 	setStyle(SCHRIFT_KLEIN,"font-family: Arial, Helvetica, sans-serif;
												font-size: 8px;
												font-style: normal;
												line-height: normal;
												font-weight: normal;
												font-variant: normal;
												color: #000000;
							",$gastro_id);												
	setStyle(BELEGT,"font-family: Arial, Helvetica, sans-serif;
										font-size: 12px;
										font-style: normal;
										font-weight: normal;
										font-variant: normal;
										background-color: #FF0000;
										border:1px solid #ccc;
										text-align: center;
							",$gastro_id);
	setStyle(FREI,"font-family: Arial, Helvetica, sans-serif;
									font-size: 12px;
									font-style: normal;
									font-weight: normal;
									font-variant: normal;
									background-color: #009BFA;
									border: 1px ridge #000000;
									text-align: center;
							",$gastro_id);
	setStyle(RESERVIERT,"font-family: Arial, Helvetica, sans-serif;
									font-size: 12px;
									font-style: normal;
									font-weight: normal;
									font-variant: normal;
									background-color: #000000;
									border: 1px ridge #000000;
									text-align: center;
							",$gastro_id);
	setStyle(STANDARD_SCHRIFT_BOLD,"font-family: Arial, Helvetica, sans-serif;
													font-size: 12px;
													font-style: normal;
													line-height: normal;
													font-weight: bold;
													font-variant: normal;
													color: #000000;
							",$gastro_id);
	setStyle(UEBERSCHRIFT,"font-family: Arial, Helvetica, sans-serif;
											font-size: 14px;
											font-style: normal;
											font-weight: bold;
											font-variant: normal;
							",$gastro_id);
	setStyle(TABLE_STANDARD,"font-family: Arial, Helvetica, sans-serif;
												font-size: 12px;
												font-style: normal;
												font-weight: normal;
												font-variant: normal;
												background-color: #F1F1F7;
												border:1px solid #ccc;
							",$gastro_id);
	setStyle(TABLE_COLOR,"font-family: Arial, Helvetica, sans-serif;
											font-size: 12px;
											font-style: normal;
											font-weight: normal;
											font-variant: normal;
											background-color: #FFFFFF;
											border:1px solid #ccc;
							",$gastro_id);
	setStyle(BUTTON,"font-family: Arial, Helvetica, sans-serif;
											font-size: 11px;
											font-style: normal;
											font-weight: normal;
											font-variant: normal;
											background-color: #FFFFFF;
											height: 20px;
											width: 170px;
											border:1px solid #ccc;
							",$gastro_id);
	setStyle(SELECT,"font-family: Arial, Helvetica, sans-serif;
											font-size: 11px;
											font-style: normal;
											font-weight: normal;
											font-variant: normal;
											background-color: #FFFFFF;
											height: 20px;
											border:1px solid #ccc;
							",$gastro_id);											
	setStyle(BUTTON_HOVER,"font-family: Arial, Helvetica, sans-serif;
											font-size: 11px;
											font-style: normal;
											font-weight: normal;
											font-variant: normal;
											background-color: #ccc;
											height: 20px;
											width: 170px;
											color: #000000;
											border:1px solid #ccc;
							",$gastro_id);
}
/**
 * author:coster
 * date: 5.10.05
 * liefert alle stylesheets eines vermieters
 * */
 function getAllStylesFromVermieter($gastro_id){
  	global $db;
 	
	 $query = ("SELECT 
	 			*  
					FROM
					BOOKLINE_CSS
					WHERE
					GASTRO_ID = '$gastro_id'
					");
	
		$res = $db->Execute($query);
		if (!$res) { 
			
			return false;
		}
		return $res;
		
 }
/**
 * author: coster
 * date: 5.10.05
 * liefert ein stylesheet aus der datenbank mit dem klassennamen $classname
 * */
 function getStyle($classname,$gastro_id){
 
 	global $db;
 	
	 $query = ("SELECT 
	 			WERT  
					FROM
					BOOKLINE_CSS
					WHERE
					GASTRO_ID = '$gastro_id'
					and
					Classname = '$classname'
					");
	
		$res = $db->Execute($query);
		if (!$res) { 			
			return false;
		}
			
		$d = $res->FetchNextObject();
		if (!empty($d)){
			$style = $d->WERT;
			if (!empty($style)){
				return $style;
			}
		}
		return false;
 }
 /**
 * author: coster
 * date: 5.10.05
 * setzt ein stylesheet mit dem klassennamen $classname
 * */
 function setStyle($classname,$wert,$gastro_id){
 	
 	global $db;
 	$style = getStyle($classname,$gastro_id);
 	if ( !empty($style)){ 	
		$query = ("UPDATE 
				BOOKLINE_CSS
				set
				WERT = '$wert'
				WHERE
				GASTRO_ID = '$gastro_id'
				and
				Classname = '$classname'
				"); 	
 	}else{ 		
 		 $query = ("insert into 
				BOOKLINE_CSS
				(GASTRO_ID,CLASSNAME,WERT)
				values
				('$gastro_id','$classname','$wert')
				");
 	}
 	
	$res = $db->Execute($query);
	if (!$res) { 
		
		return false;
	}
			
	return $db->Insert_ID();
	
 }
?>