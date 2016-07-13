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
	<!DOCTYPE html>
	<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html;">
	<meta charset="UTF-8">
	<title>Bookline - Fehlerhafte Installation</title>
	</head>
	<body>
		Bookline wurde noch nicht korrekt installiert. <br/>
		Bitte modifizieren sie die Konfigurationseinstellungen zur Datenbank (/include/rdbmsConfig.inc.php) und
		führen sie die Installation durch:
		<a href="<?php echo $root ?>/install/index.php">Installation starten.</a>
	</body>
	</html>
<?php
  exit; //sicherstellen dass nachstehender Code nicht ausgefuehrt wird
}
//2. ist ein raum vorhanden?
if (getAnzahlVorhandeneRaeume($gastro_id) < 1){
?>
<!DOCTYPE html>
	<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html;">
	<meta charset="UTF-8">
	<title>Bookline - Fehlerhafte Installation</title>
	</head>
	<body>
		Bookline wurde noch nicht richtig konfiguriert. <br/>
		Rufen sie bitte Ihr Backoffice auf und legen sie ihre Räume und Tische an:
		<a href="<?php echo $root ?>/backoffice/index.php">Backoffice starten.</a>
	</body>
	</html>
<?php
  exit; //sicherstellen dass nachstehender Code nicht ausgefuehrt wird
}