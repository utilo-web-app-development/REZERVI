<?php
	 
	 //session starten:
	 session_start();
	 
	 $root = "../../../..";
	 
	 //datenbank öffnen:
	 include_once($root."/conf/rdbmsConfig.inc.php");
	 //conf file öffnen:
	 include_once($root."/conf/conf.inc.php");
	 include_once($root."/include/sessionFunctions.inc.php");
	 
	 //passwortpruefung durchfuehren:
	 include_once($root."/webinterface/templates/checkPass.inc.php");
	 
	 //globale variablen initialisieren:
	 $vermieter_id = getSessionWert(VERMIETER_ID);
	 $sprache = getSessionWert(SPRACHE);

	header("Content-Disposition: attachment; filename=rezerviGenericMieterList.csv");

	include_once($root."/include/mieterFunctions.inc.php");	
	include_once($root."/include/uebersetzer.inc.php");

	//gästeliste ausgeben:	
	$res = getAllMieterFromVermieter($vermieter_id);
		
	while ($d = mysqli_fetch_array($res)){
	
		$vorname = $d["VORNAME"];
		$nachname = $d["NACHNAME"];
		$firma = $d["FIRMA"];
		$strasse = $d["STRASSE"];
		$plz = $d["PLZ"];
		$ort = $d["ORT"];
		$land = $d["LAND"];
		$email = $d["EMAIL"];
		$tel = $d["TELEFON"];
		$tel2 = $d["TELEFON2"];
		$fax = $d["FAX"];
		$anrede = $d["ANREDE"];
		$speech_id = $d["SPRACHE_ID"];
		$speech = getBezeichnungOfSpracheID($speech_id);
	
		echo("\"".$anrede."\",");
	    echo("\"".$vorname."\",");
		echo("\"".$nachname."\",");
		echo("\"".$firma."\",");
		echo("\"".$strasse."\",");
		echo("\"".$plz."\",");
		echo("\"".$ort."\",");
		echo("\"".$land."\",");
		echo("\"".$email."\",");
		echo("\"".$tel."\",");
		echo("\"".$tel2."\",");
		echo("\"".$fax."\",");
		echo("\"".$speech."\"");
	 	echo("\n");
	 	
	} //ende while

?>