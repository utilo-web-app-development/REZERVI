<?php 

// Set flag that this is a parent file
define( '_JEXEC', 1 );

include_once("../include/uebersetzer.php");

$files[] = "createTableBenutzer.sql";
$files[] = "createTableUnterkunft.sql";
$files[] = "createTableCSS.sql";
$files[] = "createTableGast.sql";
$files[] = "createTableReservierung.sql";
$files[] = "createTableZimmer.sql";
$files[] = "createTableAuto_Response.sql";
$files[] = "createTableUebersetzungen.sql";
$files[] = "createTableSprachenNeu.sql";
$files[] = "createTableEinstellungen_Neu.sql";
$files[] = "createTableStandardSprachen.sql";
$files[] = "createTableProperties.sql";
$files[] = "createTableBilder.sql";
$files[] = "createTableBuchungseinschraenkung.sql";
$files[] = "createTableBuchungsformular.sql";
$files[] = "createTableGastAttribute.sql";
$files[] = "createTableResAttribute.sql";
$files[] = "createTableSessions.sql";
$files[] = "createTableZimmerAttribute.sql";
$files[] = "createTableZimmerAttributeWert.sql";
$files[] = "createTablePreise.sql";
$files[] = "createTableZimmerPreise.sql";

foreach ($files as $filename){
	//tabellen anlegen:
	$query = @implode("",(@file($filename)));	
	$query3 = trim($query);
	//query absetzen:
	$res = mysql_query($query3, $link);
	
	if (!$res){
		$tabellen = false;
		$fehler = true;
		$antwort=mysql_error($link)."<br/>";
		$antwort.=getUebersetzung("Anlegen der Tabellen scheiterte!",$sprache,$link)."<br/>";
	    $antwort.=getUebersetzung("Eine mögliche Ursache ist, dass die Zugangsdaten in ihrer Konfigurationsdatei nicht korrekt sind oder die Tabellen bereits angelegt wurden.",$sprache,$link)."<br/>";
		$antwort.=getUebersetzung("Überprüfen Sie die Zugangsdaten in conf/rdbmsConfig.php und die Version Ihrer MySQL Datenbank.",$sprache,$link)."<br/>";  
		$antwort.=getUebersetzung("Wenn die Tabellen bereits angelegt wurden, können sie diesen Schritt überspringen.",$sprache,$link)."<br/>";  
		$antwort.=getUebersetzung("Ansonsten wenden sie sich bitte per E-Mail an utilo.eu - wir helfen ihnen gerne weiter!",$sprache,$link)."<br/>";
	}
	else{
		$tabellen = true;
		$fehler = false;
		$antwort=getUebersetzung("Anlegen der Tabellen erfolgreich!",$sprache,$link);
	}
}

//fuellen der tabelle rezervi_sprachen_neu:
$binFile="../fahneDE.gif";
$fahne = addslashes(fread(fopen($binFile, "r"), filesize($binFile)));
$query = "REPLACE INTO 
		Rezervi_Sprachen_Neu 
		(Sprache_ID,Bezeichnung, Fahne,aktiv) 
		VALUES 
		('de','deutsch','$fahne','3')";
$res = mysql_query($query, $link);
if (!$res){
    $antwort=$antwort.(mysql_error($link));
	$fail = true;
}
$binFile="../fahneEN.gif";
$fahne = addslashes(fread(fopen($binFile, "r"), filesize($binFile)));
$query = "REPLACE INTO 
		Rezervi_Sprachen_Neu 
		(Sprache_ID,Bezeichnung, Fahne,aktiv) 
		VALUES 
		('en','englisch','$fahne','3')";
$res = mysql_query($query, $link);
if (!$res){
    $antwort=$antwort.(mysql_error($link));
	$fail = true;
}
$binFile="../fahneFR.gif";
$fahne = addslashes(fread(fopen($binFile, "r"), filesize($binFile)));
$query = "REPLACE INTO 
		Rezervi_Sprachen_Neu 
		(Sprache_ID,Bezeichnung, Fahne,aktiv) 
		VALUES 
		('fr','französisch','$fahne','2')";
$res = mysql_query($query, $link);
if (!$res){
    $antwort=$antwort.(mysql_error($link));
	$fail = true;
}
$binFile="../fahneIT.gif";
$fahne = addslashes(fread(fopen($binFile, "r"), filesize($binFile)));
$query = "REPLACE INTO 
		Rezervi_Sprachen_Neu
		(Sprache_ID,Bezeichnung, Fahne,aktiv) 
		VALUES 
		('it','italienisch','$fahne','0')";
$res = mysql_query($query, $link);
if (!$res){
    $antwort=$antwort.(mysql_error($link));
	$fail = true;
}
$binFile="../fahneSP.gif";
$fahne = addslashes(fread(fopen($binFile, "r"), filesize($binFile)));
$query = "REPLACE INTO 
		Rezervi_Sprachen_Neu 
		(Sprache_ID,Bezeichnung, Fahne,aktiv) 
		VALUES 
		('sp','spanisch','$fahne','0')";
$res = mysql_query($query, $link);
if (!$res){
    $antwort=$antwort.(mysql_error($link));
	$fail = true;
}
$binFile="../fahneES.gif";
$fahne = addslashes(fread(fopen($binFile, "r"), filesize($binFile)));
$query = "REPLACE INTO 
		Rezervi_Sprachen_Neu 
		(Sprache_ID,Bezeichnung, Fahne,aktiv) 
		VALUES 
		('es','estonisch','$fahne','0')";
$res = mysql_query($query, $link);
$binFile="../fahneNL.gif";
$fahne = addslashes(fread(fopen($binFile, "r"), filesize($binFile)));
$query = "REPLACE INTO 
		Rezervi_Sprachen_Neu 
		(Sprache_ID,Bezeichnung, Fahne,aktiv) 
		VALUES 
		('nl','Niederländisch','$fahne','3')";
$res = mysql_query($query, $link);
if (!$res){
    $antwort=$antwort.(mysql_error($link));
	$fail = true;
}

?>