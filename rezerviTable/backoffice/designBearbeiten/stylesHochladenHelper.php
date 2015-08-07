<?php
$root = "../../";
$ueberschrift = "Design bearbeiten";
/*
 * Created on 07.12.2007
 * Author: LI Haitao
 * Company: Alpstein-Austria  
 */
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/include/cssFunctions.inc.php"); 

$stylesFile =  $_FILES['stylesheet']['tmp_name'];
$content = file_get_contents($stylesFile);
$styles = explode("\n", $content);
$aendern = false;
for($i=0; $i<count($styles); $i++){
	$styles_sub = explode("{", $styles[$i]);
	if($styles[$i] == "" || $styles[$i] == null){
		continue;
	}
	if(count($styles_sub)<2){
		$fehler = true;
		$nachricht = "Diese Definition \"".$styles[$i]."\" ist ungültig!";
		include_once("./stylesHochladen.php");
		exit;
	}
	$klassname = $styles_sub[0];
	$werts_neu = explode(";", $styles_sub[1]);
	if(	$style = getStyle($klassname,$gastro_id)){		
		$werts_alt = explode(";", $style);
		for($j=0; $j<count($werts_alt)-1; $j++){
			$werts_alt[$j] = update($werts_alt[$j], $werts_neu);
		}
		setStyle($klassname,getString($werts_alt),$gastro_id);
		$aendern = true;
	}
}
if($aendern){
	$info = true;
	$nachricht = "Die Designs wurden erfolgreich geändert!";
	include_once("./stylesHochladen.php");
	exit;
}else{
	$fehler = true;
	$nachricht = "Kein entsprechendes Design in der Datei vorhanden!";
	include_once("./stylesHochladen.php");
	exit;
}

function update($alt, $neu_alle){
	$alt_array = explode(":", $alt);
	$alt = "";
	$alt_name = trim($alt_array[0]);
	$alt_wert = trim($alt_array[1]);
	for($i=0; $i<count($neu_alle)-1; $i++){	
		$neu_array = explode(":", $neu_alle[$i]);
		if(count($neu_array) != 2){
			$fehler = true;
			$nachricht = "Diese Definition \"".$neu_alle[$i]."\" ist ungültig!";
			include_once("./stylesHochladen.php");
			exit;
		}
		if($alt_name == trim($neu_array[0])){
			$alt_wert = trim($neu_array[1]);
			
		}
	}
	return $alt_name.": ".$alt_wert;
}

function getString($wert_array){
	$wert_string = "";
	for($i=0; $i<count($wert_array); $i++){
		$wert_string = $wert_string.$wert_array[$i].";";
	}
	return $wert_string;
}
?>
