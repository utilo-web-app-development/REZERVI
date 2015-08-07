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
define("UEBERSCHRIFT","ueberschrift"); //ueberschrift
define("TABLE_STANDARD","table");
define("TABLE_COLOR","tableColor");
define("BUTTON","button200pxA");
define("BUTTON_HOVER","button200pxB");

/**
 * author: coster
 * date: 7.10.05
 * setzt die standardwerte der css eines vermieters
 * 
 * */
 function setStandardCSS($vermieter_id){
 	setStyle(BACKGROUND_COLOR,"background-color: #F1F1F7;",$vermieter_id);
 	setStyle(STANDARD_SCHRIFT,"font-family: Arial, Helvetica, sans-serif;
												font-size: 12px;
												font-style: normal;
												line-height: normal;
												font-weight: normal;
												font-variant: normal;
												color: #000000;",$vermieter_id);
	setStyle(BELEGT,"font-family: Arial, Helvetica, sans-serif;
										font-size: 12px;
										font-style: normal;
										font-weight: normal;
										font-variant: normal;
										background-color: #FF0000;
										border: 1px ridge #000000;
										text-align: center;",$vermieter_id);
	setStyle(FREI,"font-family: Arial, Helvetica, sans-serif;
									font-size: 12px;
									font-style: normal;
									font-weight: normal;
									font-variant: normal;
									background-color: #009BFA;
									border: 1px ridge #000000;
									text-align: center;",$vermieter_id);
	setStyle(RESERVIERT,"font-family: Arial, Helvetica, sans-serif;
									font-size: 12px;
									font-style: normal;
									font-weight: normal;
									font-variant: normal;
									background-color: #000000;
									border: 1px ridge #000000;
									text-align: center;",$vermieter_id);
	setStyle(STANDARD_SCHRIFT_BOLD,"font-family: Arial, Helvetica, sans-serif;
													font-size: 12px;
													font-style: normal;
													line-height: normal;
													font-weight: bold;
													font-variant: normal;
													color: #000000;",$vermieter_id);
	setStyle(UEBERSCHRIFT,"font-family: Arial, Helvetica, sans-serif;
											font-size: 14px;
											font-style: normal;
											font-weight: bold;
											font-variant: normal;",$vermieter_id);
	setStyle(TABLE_STANDARD,"font-family: Arial, Helvetica, sans-serif;
												font-size: 12px;
												font-style: normal;
												font-weight: normal;
												font-variant: normal;
												background-color: #F1F1F7;
												border: 1px ridge #6666FF;",$vermieter_id);
	setStyle(TABLE_COLOR,"font-family: Arial, Helvetica, sans-serif;
											font-size: 12px;
											font-style: normal;
											font-weight: normal;
											font-variant: normal;
											background-color: #FFFFFF;
											border: 1px ridge #6666FF;",$vermieter_id);
	setStyle(BUTTON,"font-family: Arial, Helvetica, sans-serif;
											font-size: 11px;
											font-style: normal;
											font-weight: normal;
											font-variant: normal;
											background-color: #FFFFFF;
											height: 20px;
											width: 170px;
											border: 1px ridge #6666FF;",$vermieter_id);
	setStyle(BUTTON_HOVER,"font-family: Arial, Helvetica, sans-serif;
											font-size: 11px;
											font-style: normal;
											font-weight: normal;
											font-variant: normal;
											background-color: #0023DC;
											height: 20px;
											width: 170px;
											color: #FFFFFF;
											border: 1px ridge #FFFFCC;",$vermieter_id);
	
 }
/**
 * author:coster
 * date: 5.10.05
 * liefert alle stylesheets eines vermieters
 * */
 function getAllStylesFromVermieter($vermieter_id){
  	global $link;
 	
	 $query = ("SELECT 
	 			*  
					FROM
					REZ_GEN_CSS
					WHERE
					VERMIETER_ID = '$vermieter_id'
					");
	
		$res = mysql_query($query, $link);
		if (!$res) { 
			echo("die Anfrage $query scheitert");
			return false;
		}
		return $res;
		
 }
/**
 * author: coster
 * date: 5.10.05
 * liefert ein stylesheet aus der datenbank mit dem klassennamen $classname
 * */
 function getStyle($classname,$vermieter_id){
 
 	global $link;
 	
	 $query = ("SELECT 
	 			WERT  
					FROM
					REZ_GEN_CSS
					WHERE
					VERMIETER_ID = '$vermieter_id'
					and
					Classname = '$classname'
					");
	
		$res = mysql_query($query, $link);
		if (!$res) { 
			echo("die Anfrage $query scheitert");
			return false;
		}
			
		$d = mysql_fetch_array($res);
		$style = $d["WERT"];
		if ($style == ""){
			return false;
		}
		return $style;
 }
 /**
 * author: coster
 * date: 5.10.05
 * setzt ein stylesheet mit dem klassennamen $classname
 * */
 function setStyle($classname,$wert,$vermieter_id){
 
 	global $link;
 	$style = getStyle($classname,$vermieter_id);
 	if ( empty( $style ) ){
 		
 		 $query = ("insert into 
				REZ_GEN_CSS
				(VERMIETER_ID,CLASSNAME,WERT)
				values
				('$vermieter_id','$classname','$wert')
				");
 	
 	}
 	else{
 	
	 $query = ("UPDATE 
				REZ_GEN_CSS
				set
				WERT = '$wert'
				WHERE
				VERMIETER_ID = '$vermieter_id'
				and
				Classname = '$classname'
				");
 	}
 	
	$res = mysql_query($query, $link);
	if (!$res) { 
		echo("die Anfrage $query scheitert");
		return false;
	}
			
	return mysql_insert_id($link);
	
 }
?>