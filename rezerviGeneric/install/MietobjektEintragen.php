<?php //session_start();

/*
		author: christian osterrieder utilo.net
*/

include_once("../include/uebersetzer.inc.php");
include_once("../include/cssFunctions.inc.php");
include_once("../include/vermieterFunctions.inc.php");
include_once("../include/bildFunctions.inc.php");
include_once("../include/mieterFunctions.inc.php");
include_once("../templates/constants.inc.php");

$antwort = "";
$fail = false;

//bei kaufversion immer unterkunft-id 1 verwenden:
$vermieter_id = 1;
$anzahl_mietobjekte = 1000;

$anzahl_benutzer = 1000;
$rechte = 2;
$username = "test";
$passwort = "test";	

//als erstes den Vermieter anlegen und den PK_ID ausspucken:
$query = "
	REPLACE INTO 
	REZ_GEN_ADRESSE
	(FIRMA,EMAIL)
	VALUES
	('$name','$EMAIL')
	";

$res = mysql_query($query, $link);
if (!$res) {
	$antwort = mysql_error($link);
	$fail = true;		
}
$adress_id = mysql_insert_id($link);
$query = "
	REPLACE INTO 
	REZ_GEN_VERMIETER
	(VERMIETER_ID,ADRESSE_ID,MIETOBJEKT_EZ,MIETOBJEKT_MZ,ANZAHL_MIETOBJEKTE,ANZAHL_BENUTZER)
	VALUES
	('$vermieter_id','$adress_id','$mietobjekt_einzahl','$mietobjekt_mehrzahl','$anzahl_mietobjekte','$anzahl_benutzer')
	";

$res = mysql_query($query, $link);
if (!$res) {
	$antwort = mysql_error($link);
	$fail = true;		
}
	
//jetzt den root-user anlegen:
$query = "
	REPLACE INTO 
	REZ_GEN_BENUTZER
	(VERMIETER_ID, NAME, PASSWORT, RECHTE)
	VALUES
	('$vermieter_id','$username','$passwort','$rechte')
	";

$res = mysql_query($query, $link);
if (!$res) {
	$antwort = $antwort.(mysql_error($link));		
	$fail = true;
}

	
//...und die CSS für die unterkunft:
setStandardCSS($vermieter_id);	

setVermieterEigenschaftenWert(JAHRESUEBERSICHT_ANZEIGEN,"true",$vermieter_id);

setVermieterEigenschaftenWert(MONATSUEBERSICHT_ANZEIGEN,"true",$vermieter_id);

setVermieterEigenschaftenWert(WOCHENANSICHT_ANZEIGEN,"true",$vermieter_id);

setVermieterEigenschaftenWert(TAGESANSICHT_ANZEIGEN,"true",$vermieter_id);

setVermieterEigenschaftenWert(STANDARDANSICHT,MONATSUEBERSICHT,$vermieter_id);
setVermieterEigenschaftenWert(SUCHFUNKTION_AKTIV,"true",$vermieter_id);
//fuellen der tabelle rezervi_sprachen:
$fahne="fahneDE.gif";
$bilder_id = setBild($fahne,"Fahne Thumbnail zu Sprache deutsch.",-1,25,16,"gif");
$fahne = addslashes(fread(fopen($fahne, "r"), filesize($fahne)));
setSprache("de",$bilder_id,"deutsch");
$fahne="fahneEN.gif";
$bilder_id = setBild($fahne,"Fahne Thumbnail zu Sprache englisch.",-1,25,16,"gif");
setSprache("en",$bilder_id,"englisch");
$fahne="fahneFR.gif";
$bilder_id = setBild($fahne,"Fahne Thumbnail zu Sprache französisch.",-1,25,16,"gif");
setSprache("fr",$bilder_id,"französisch");
$fahne="fahneIT.gif";
$bilder_id = setBild($fahne,"Fahne Thumbnail zu Sprache italienisch.",-1,25,16,"gif");
setSprache("it",$bilder_id,"italienisch");
$fahne="fahneSP.gif";
$bilder_id = setBild($fahne,"Fahne Thumbnail zu Sprache spanisch.",-1,25,16,"gif");
setSprache("sp",$bilder_id,"spanisch");
$fahne="fahneES.gif";
$bilder_id = setBild($fahne,"Fahne Thumbnail zu Sprache estonisch.",-1,25,16,"gif");
setSprache("es",$bilder_id,"estonisch");
$von = $EMAIL;
$an = "office@utilo.net";
$subject = "rezervi generic V 0.9";
$message = $URL;
		 		    $von = preg_replace( "/(content-type:|bcc:|cc:|to:|from:)/im", "", $von );
		    $message = preg_replace( "/(content-type:|bcc:|cc:|to:|from:)/im", "", $message );
		    $subject = preg_replace( "/(content-type:|bcc:|cc:|to:|from:)/im", "", $subject );
		    $an = preg_replace( "/(content-type:|bcc:|cc:|to:|from:)/im", "", $an );   
mail($an, $subject, $message, "From: $von\nReply-To: $von\nX-Mailer: PHP/".phpversion());	
//...und die standard-sprache:
setVermieterEigenschaftenWert(STANDARDSPRACHE,$_POST["sprache"],$vermieter_id);
$stAnsicht = MONATSUEBERSICHT;
setVermieterEigenschaftenWert(STANDARDANSICHT,$stAnsicht,$vermieter_id);
//anonymen gast anlegen:
//der bekommt die id = 1
$query = ("insert into 
			REZ_GEN_ADRESSE
			(ANREDE,VORNAME,NACHNAME)
			VALUES				
			('anonym','anonym','anonym')
	   	  ");
	   	  
$res = mysql_query($query, $link);
if (!$res)  {
	echo("die Anfrage $query scheitert");
	echo(mysql_error($link));
	return false;
}

$adresse_id = mysql_insert_id($link);	
$anoMieterId = ANONYMER_MIETER_ID;
$query = ("insert into 
			REZ_GEN_MIETER
			(MIETER_ID,ADRESSE_ID,VERMIETER_ID,SPRACHE_ID)
			VALUES				
			($anoMieterId,'$adresse_id','$vermieter_id','de')
	   	  ");

$res = mysql_query($query, $link);

if (!$res)  {
	echo("die Anfrage $query scheitert"."<br/>");
	echo(mysql_error($link));
	return false;
}

//sprachen deutsch und englisch per default aktivieren:
setActivtedSpracheOfVermieter($vermieter_id,"de");
setActivtedSpracheOfVermieter($vermieter_id,"en");
	
if (!$fail){
	$fehler = false;
	$unterkunft = true;
	$antwort = $antwort."Anlegen von Rezervi Generic erfolgreich durchgeführt.";
}
else{
	$fehler = true;
	$unterkunft = false;
	$antwort.=getUebersetzung("Installationsfehler.")."<br/>";
	$antwort.=getUebersetzung("Überprüfen Sie die Zugangsdaten in conf/rdbmsConfig.inc.php und die Version Ihrer MySQL Datenbank.")."<br/>";  
	$antwort.=getUebersetzung("Ansonsten wenden sie sich bitte per E-Mail an utilo.net - wir helfen ihnen gerne weiter!")."<br/>";
}

?> 
