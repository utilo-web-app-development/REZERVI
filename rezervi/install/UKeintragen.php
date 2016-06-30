<?php //session_start();
// Set flag that this is a parent file
define( '_JEXEC', 1 );

/*
		author: christian osterrieder utilo.eu
*/

include_once("../include/uebersetzer.php");
include_once("../include/gastFunctions.php");
include_once("../include/einstellungenFunctions.php");
include_once("../include/propertiesFunctions.php");
include_once("../include/reseller/reseller.php");
	
?>
<!DOCTYPE html>
<html>
<head>
<title>Unterkunft in DB eintragen</title>
<meta http-equiv="Content-Type" content="text/html; charset="UTF-8">
</head>

<body class="backgroundColor">
<?php

$anwort = "";
$fail = false;

//bei kaufversion immer unterkunft-id 1 verwenden:
$unterkunft_id = 1;
$anzahl_zimmer = 1000;

$anzahl_benutzer = 1000;
$rechte = 2;
$username = "test";
$passwort = "test";
$passwort = sha1($passwort);
$backgroundColor="background-color: #F1F1F7;";
$standardSchrift="font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: normal;
	line-height: normal;
	font-weight: normal;
	font-variant: normal;
	color: #000000;";
$belegt="font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: normal;
	font-weight: normal;
	font-variant: normal;
	background-color: #FF0000;
	border: 1px ridge #000000;
	text-align: center;";
$frei="	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: normal;
	font-weight: normal;
	font-variant: normal;
	background-color: #009BFA;
	border: 1px ridge #000000;
	text-align: center;";
$reserviert="font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: normal;
	font-weight: normal;
	font-variant: normal;
	background-color: yellow;
	border: 1px ridge #000000;
	text-align: center;";
$standardSchriftBold="	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: normal;
	line-height: normal;
	font-weight: bold;
	font-variant: normal;
	color: #000000;";
$ueberschrift="	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-style: normal;
	font-weight: bold;
	font-variant: normal;";
$table="	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: normal;
	font-weight: normal;
	font-variant: normal;
	background-color: #F1F1F7;
	border: 0 ridge #6666FF;";
$tableColor="	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: normal;
	font-weight: normal;
	font-variant: normal;
	background-color: #FFFFFF;
	border: 1 ridge #6666FF;";
$button200pxA="	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-style: normal;
	font-weight: normal;
	font-variant: normal;
	background-color: #FFFFFF;
	height: 20px;
	width: 170px;
	border: 1px ridge #6666FF;";
$button200pxB="	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-style: normal;
	font-weight: normal;
	font-variant: normal;
	background-color: #0023DC;
	height: 20px;
	width: 170px;
	color: #FFFFFF;
	border: 1px ridge #FFFFCC;";

$samstagBelegt=$belegt;
$samstagFrei=$frei;
$samstagReserviert=$reserviert;		

	//als erstes die unterkunft anlegen und den PK_ID ausspucken:
	$query = "
		REPLACE INTO 
		Rezervi_Unterkunft
		(AnzahlZimmer,PK_ID,Name,AnzahlBenutzer,Zimmerart_EZ,Zimmerart_MZ,Email,Art)
		VALUES
		($anzahl_zimmer,$unterkunft_id,'$name',$anzahl_benutzer,'$ZIMMERART_EZ','$ZIMMERART_MZ','$EMAIL','$art')
		";

  	$res = mysql_query($query, $link);
  	if (!$res) {
		$antwort = mysql_error($link);
		$fail = true;		
	}
	
	//jetzt den test-user anlegen:
	$query = "
		REPLACE INTO 
		Rezervi_Benutzer
		(FK_Unterkunft_ID, Name, Passwort, Rechte)
		VALUES
		($unterkunft_id,'$username','$passwort','$rechte')
		";

  	$res = mysql_query($query, $link);
  	if (!$res) {
		$antwort = $antwort.(mysql_error($link));		
		$fail = true;
	}

	
	//...und die CSS für die unterkunft:
	$query = "
		REPLACE INTO 
		Rezervi_CSS
		(samstagBelegt,samstagFrei,samstagReserviert,backgroundColor,standardSchrift,belegt,frei,reserviert,standardSchriftBold,ueberschrift,tableStandard,tableColor,button200pxA,button200pxB,FK_Unterkunft_ID)
		VALUES
		('$samstagBelegt','$samstagFrei','$samstagReserviert','$backgroundColor','$standardSchrift','$belegt','$frei','$reserviert','$standardSchriftBold','$ueberschrift','$table','$tableColor','$button200pxA','$button200pxB',$unterkunft_id)
		";

  	$res = mysql_query($query, $link);
  	if (!$res) {
  		$antwort = $antwort.("Anfrage $query scheitert.\n");
		$antwort = $antwort.(mysql_error($link));
		$fail = true;
	}
	
		
	//fuer statistik - kann gelöscht werden!
	$von = $EMAIL;
	$an = "office@utilo.eu";
	$subject = "rezervi 2.9";
	if ($isReseller){
		$subject.=" Reseller: ".$resellerName;
	}
	$message = $URL;
	$von = preg_replace( "/(content-type:|bcc:|cc:|to:|from:)/im", "", $von );
		    $message = preg_replace( "/(content-type:|bcc:|cc:|to:|from:)/im", "", $message );
		    $subject = preg_replace( "/(content-type:|bcc:|cc:|to:|from:)/im", "", $subject );
		    $an = preg_replace( "/(content-type:|bcc:|cc:|to:|from:)/im", "", $an );
	mail($an, $subject, $message, "From: $von\nReply-To: $von\nX-Mailer: PHP/".phpversion());	
	if ($isReseller){
		mail($resellerEMail, $subject, $message, "From: $von\nReply-To: $von\nX-Mailer: PHP/".phpversion());	
	}
	//...und die standard-sprache:
	setStandardSprache($unterkunft_id,$sprache,$link);	
	setStandardSpracheBelegungsplan($unterkunft_id,$sprache,$link);
	
	//anonymen gast anlegen:
	//der bekommt die id = 1
	insertGuestWithID(1,$unterkunft_id," ","Anonym","Anonymous","no street address","no post code","no city","no land","no e-mail","no tel","no fax","anonymous guest","en",$link);
 
 	//die standard-framegroessen setzen:
 	//zuerst mal einen eintrag in den einstellungen machen:
 			$query = "REPLACE INTO 
			  Rezervi_Einstellungen_Neu
			  (FK_Unterkunft_ID)
			  VALUES				  
			  ('$unterkunft_id')
			 ";

  	$res = mysql_query($query, $link);
  	
 	setFramesizeRightBP($unterkunft_id,"","*",$link);
 	setFramesizeLeftBP($unterkunft_id,"280","px",$link);
 	setFramesizeLeftWI($unterkunft_id,"280","px",$link);
 	setFramesizeRightWI($unterkunft_id,"","*",$link);
	
	//speichert der default Values in der properties tabelle:
	setDefaultValues($unterkunft_id,$link);
 	
if (!$fail){
	$fehler = false;
	$unterkunft = true;
	$antwort = $antwort."Anlegen der Unterkunft erfolgreich durchgeführt.";
}
else{
	$fehler = true;
	$unterkunft = false;
	$antwort.=getUebersetzung("Installationsfehler.",$sprache,$link)."<br/>";
	$antwort.=getUebersetzung("Überprüfen Sie die Zugangsdaten in conf/rdbmsConfig.php und die Version Ihrer MySQL Datenbank.",$sprache,$link)."<br/>";  
	$antwort.=getUebersetzung("Ansonsten wenden sie sich bitte per E-Mail an utilo.eu - wir helfen ihnen gerne weiter!",$sprache,$link)."<br/>";
}


?> 
</body>
</html>
