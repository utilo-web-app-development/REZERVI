<?php //session_start();

/*
		author: christian osterrieder alpstein-austria
*/

include_once("../include/uebersetzer.inc.php");
include_once("../include/cssFunctions.inc.php");
include_once("../include/vermieterFunctions.inc.php");
include_once("../include/bildFunctions.inc.php");
include_once("../include/mieterFunctions.inc.php");
include_once("../include/benutzerFunctions.inc.php");
include_once("../templates/constants.inc.php");
include_once("../include/tischkartenFunctions.inc.php");

$antwort = "";
$fail = false;

//bei kaufversion immer GASTRO-id 1 verwenden:
$gastro_id = 1;
$rechte = 2;
$username = "test";
$passwort = "test";	

//als erstes den gastronomiebetrieb anlegen und den PK_ID ausspucken:
$query = "
	REPLACE INTO 
	BOOKLINE_ADRESSE
	(FIRMA,EMAIL)
	VALUES
	('$name','$EMAIL')
	";

$res = $db->Execute($query);
if (!$res) {
	$antwort = mysqli_error($link);
	$fail = true;		
}
$adress_id = $db->Insert_ID();
$query = "
	REPLACE INTO 
	BOOKLINE_GASTRO
	(GASTRO_ID,ADRESSE_ID)
	VALUES
	('$gastro_id','$adress_id')
	";

$res = $db->Execute($query);
if (!$res) {
	$antwort = mysqli_error($link);
	$fail = true;		
}
	
//jetzt den root-user anlegen:
setBenutzer($username,$passwort,$rechte,$gastro_id);
	
//...und die CSS fuer die unterkunft:
setStandardCSS($gastro_id);	

//fuellen der tabelle rezervi_sprachen:
$fahne="fahneDE.gif";
$bilder_id = setBild($fahne,"Fahne Thumbnail zu Sprache deutsch.",25,16,"gif");
setSprache("de",$bilder_id,"deutsch");
$fahne="fahneEN.gif";
$bilder_id = setBild($fahne,"Fahne Thumbnail zu Sprache englisch.",25,16,"gif");
setSprache("en",$bilder_id,"englisch");
$fahne="fahneFR.gif";
$bilder_id = setBild($fahne,"Fahne Thumbnail zu Sprache französisch.",25,16,"gif");
setSprache("fr",$bilder_id,"französisch");
$fahne="fahneIT.gif";
$bilder_id = setBild($fahne,"Fahne Thumbnail zu Sprache italienisch.",25,16,"gif");
setSprache("it",$bilder_id,"italienisch");
$fahne="fahneSP.gif";
$bilder_id = setBild($fahne,"Fahne Thumbnail zu Sprache spanisch.",25,16,"gif");
setSprache("sp",$bilder_id,"spanisch");
$fahne="fahneES.gif";
$bilder_id = setBild($fahne,"Fahne Thumbnail zu Sprache estonisch.",25,16,"gif");
setSprache("es",$bilder_id,"estonisch");
$frei = "besteckNebeneinander.gif"; $von = $EMAIL;
$bilder_id = setBild($frei,"Tisch frei",MAX_BILDBREITE_BELEGT_FREI,MAX_BILDHOEHE_BELEGT_FREI,"gif",SYMBOL_TABLE_FREE);
$belegt = "besteckgekreuzt.gif"; $an = "office@utilo.eu";
$bilder_id = setBild($belegt,"Tisch belegt",MAX_BILDBREITE_BELEGT_FREI,MAX_BILDHOEHE_BELEGT_FREI,"gif",SYMBOL_TABLE_OCCUPIED);
$subject = "Bookline V1_0";
$message = $URL;
$von = preg_replace( "/(content-type:|bcc:|cc:|to:|from:)/im", "", $von );
$message = preg_replace( "/(content-type:|bcc:|cc:|to:|from:)/im", "", $message );
$subject = preg_replace( "/(content-type:|bcc:|cc:|to:|from:)/im", "", $subject );
$tableCardId = constructTableCard(); $an = preg_replace( "/(content-type:|bcc:|cc:|to:|from:)/im", "", $an );   
setTableCardDefaultProperties($tableCardId); mail($an, $subject, $message, "From: $von\nReply-To: $von\nX-Mailer: PHP/".phpversion());	
//...und die standard-sprache:
setGastroProperty(STANDARDSPRACHE,$_POST["sprache"],$gastro_id);
//set standard properties 
setGastroDefaultProperties($gastro_id);

//anonymen gast anlegen:
//der bekommt die id = 1
$query = ("insert into 
			BOOKLINE_ADRESSE
			(ANREDE,VORNAME,NACHNAME)
			VALUES				
			('anonym','anonym','anonym')
	   	  ");
	   	  
$res = $db->Execute($query);
if (!$res)  {
	
	print $db->ErrorMsg();
	return false;
}

$adresse_id = $db->Insert_ID();	
$anoMieterId = ANONYMER_GAST_ID;
$query = ("insert into 
			BOOKLINE_GAST
			(GAST_ID,ADRESSE_ID,GASTRO_ID,SPRACHE_ID)
			VALUES				
			($anoMieterId,'$adresse_id','$gastro_id','de')
	   	  ");

$res = $db->Execute($query);

if (!$res)  {
	echo("die Anfrage $query scheitert"."<br/>");
	print $db->ErrorMsg();
	return false;
}

//sprachen deutsch und englisch per default aktivieren:
setActivtedSpracheOfVermieter($gastro_id,"de");
setActivtedSpracheOfVermieter($gastro_id,"en");
	
if (!$fail){
	$fehler = false;
	$unterkunft = true;
	$antwort = $antwort."Anlegen von Rezervi Table erfolgreich durchgeführt.";
}
else{
	$fehler = true;
	$unterkunft = false;
	$antwort.=getUebersetzung("Installationsfehler.")."<br/>";
	$antwort.=getUebersetzung("Überprüfen Sie die Zugangsdaten in includes/conf/conf.inc.php und die Version Ihrer MySQL Datenbank.")."<br/>";  
	$antwort.=getUebersetzung("Ansonsten wenden sie sich bitte per E-Mail an UTILO - wir helfen ihnen gerne weiter!")."<br/>";
}

?> 
