<?php
/**
 * @author coster
 * @date 28.6.2007
 * Prüft ob Bookline korrekt installiert und konfiguriert wurde
*/
include_once($root."/include/rdbmsConfig.inc.php"); //datenbank oeffnen
//1. ist ein Gastronomiebetrieb vorhanden?
include_once($root."/include/vermieterFunctions.inc.php"); //infos ueber gastro betrieb
if (getNumberOfGastros() < 1){
?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
	<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
	<title>Bookline - Fehlerhafte Installation</title>
	</head>
	<body>
		Bookline wurde noch nicht korrekt installiert. <br/>
		Bitte modifizieren sie die Konfigurationseinstellungen zur Datenbank (/include/rdbmsConfig.inc.php) und
		führen sie die Installation durch:
		<a href="<?= $root ?>/install/index.php">Installation starten.</a>
	</body>
	</html>
<?php
  exit; //sicherstellen dass nachstehender Code nicht ausgefuehrt wird
}
//2. ist ein raum vorhanden?
if (getAnzahlVorhandeneRaeume($gastro_id) < 1){
?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
	<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
	<title>Bookline - Fehlerhafte Installation</title>
	</head>
	<body>
		Bookline wurde noch nicht richtig konfiguriert. <br/>
		Rufen sie bitte Ihr Backoffice auf und legen sie ihre Räume und Tische an:
		<a href="<?= $root ?>/backoffice/index.php">Backoffice starten.</a>
	</body>
	</html>
<?php
  exit; //sicherstellen dass nachstehender Code nicht ausgefuehrt wird
}