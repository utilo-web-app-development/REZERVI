<?php 
/*
 * Created on 24.10.2007
 * Autor: LI Haitao
 * Company: Alpstein-Austria
 * Hauptseite von Backoffice
 *  
 */
	 
 //session starten wenn dies noch nicht erfolgt ist:
 $sessId = session_id();
 if (empty($sessId)){
 	session_start();
 }
 
 // Send modified header for session-problem of ie:
 // @see http://de.php.net/session
 header('P3P: CP="NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM"');
 //datenbank Öffnen:
 include_once($root."/include/rdbmsConfig.inc.php");
 //conf file Öffnen:
 include_once($root."/conf/conf.inc.php");
 //uebersetzer Öffnen:
 include_once($root."/include/uebersetzer.inc.php");
 include_once($root."/include/sessionFunctions.inc.php");
 include_once($root."/include/cssFunctions.inc.php");  
 include_once($root."/include/benutzerFunctions.inc.php"); 
 include_once($root."/include/autoResponseFunctions.inc.php");
 //passwortpruefung durchfuehren:
 include_once($root."/backoffice/templates/checkPass.inc.php");

 //globale variablen initialisieren:
 $gastro_id = getSessionWert(GASTRO_ID);
 if (isset($_POST["standardSprache"])) {
	$sprache = $_POST["standardSprache"];
	setSessionWert(SPRACHE, $sprache);
 }else{
	$sprache = getSessionWert(SPRACHE);
 }
 
 $benutzer_id = getSessionWert(BENUTZER_ID);
 $benutzerrechte = getUserRights($benutzer_id);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>Wartungsseite Backoffice Bookline</title>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<meta name="author" content="Christian Osterrieder-Schlick UTILO"/>
	<meta name="Generator" content="All coding done by hand"/>
	<meta name="robots" content="INDEX,FOLLOW"/>
	<meta name="publisher" content="UTILO"/>
	<meta name="copyright" content="UTILO"/>
	<meta name="audience" content="Alle"/>
	<meta name="geo.region" content="AUT"/>
	<meta name="geo.placename" content="Salzburg, Austria"/>
	<link href="<?= $root ?>/backoffice/templates/template_css.css" rel="stylesheet" type="text/css">
	<!-- Namespace source file -->
	<script type="text/javascript" src="<?= $root ?>/yui/build/yahoo/yahoo.js"></script>
	<!-- Dependency source files -->
	<script type="text/javascript" src="<?= $root ?>/yui/build/event/event.js"></script>
	<script type="text/javascript" src="<?= $root ?>/yui/build/dom/dom.js"></script>
	<script type="text/javascript" src="<?= $root ?>/yui/build/animation/animation.js"></script>
	<!-- Container source file -->
	<script type="text/javascript" src="<?= $root ?>/yui/build/container/container_core.js"></script>
	<script language=javascript>
		var url = "<?php echo $_SERVER["PHP_SELF"]."?".$_SERVER["QUERY_STRING"]?>";
		function refresh(){ 
			aendernSprache.action=url;  
			aendernSprache.submit();  
		}    
	</script>
</head>