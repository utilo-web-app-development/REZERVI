<?  session_start();
$root = ".";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
//datenbank öffnen:
include_once($root."/conf/rdbmsConfig.php");
include_once($root."/include/sessionFunctions.inc.php");
include_once($root."/include/reservierungFunctions.php");
include_once($root."/include/einstellungenFunctions.php");
include_once($root."/include/zimmerFunctions.php");
include_once($root."/include/uebersetzer.php");
include_once($root."/include/unterkunftFunctions.php");
include_once($root."/include/propertiesFunctions.php");
include_once($root."/include/autoResponseFunctions.php");

// left.php

include_once($root."/include/reseller/reseller.php");
include_once($root."/include/datumFunctions.php");
include_once($root."/leftHelper.php");

// right.php

include_once("./rightHelper.php");	

// Jahresübersicht 

include_once($root."/jahresuebersichtHelper.php");
include_once($root."/include/gastFunctions.php");
include_once($root."/include/benutzerFunctions.php");

			
//alte sessions löschen:
destroyInactiveSessions();

	//variablen aus übergebener url auslesen:
	//variablen kommen von suche.php:
	if (isset($_POST["keineSprache"])){
		$keineSprache = $_POST["keineSprache"];
	} 
	if (isset($keineSprache) && $keineSprache == "true" && getSessionWert(UNTERKUNFT_ID) != false){
		$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
		$sprache = getSessionWert(SPRACHE);
		$zimmer_id = $_POST["zimmer_id"];
	}
	
	if (isset($_GET["unterkunft_id"])){ //start.php wurde direkt per get aufgerufen:
		$unterkunft_id = $_GET["unterkunft_id"];
		//zerstöre session daten falls schon welche vorhanden sind:
		//destroySession();
		if (isset($_GET["sprache"])){
			$sprache = $_GET["sprache"];
			$spracheNeu = false;
		}
		else if (isset($_GET["spracheNeu"])){
			$sprache = $_GET["spracheNeu"]; // eine "legacy-eigenschaft - scheisse!"
		}
		else{
			$sprache = false;
		}
		if (isset($_GET["zimmer_id"])){
			$zimmer_id = $_GET["zimmer_id"];
		}
		else{
			$zimmer_id = false;
		}

	}	
	
	//testdaten:
	if (empty($unterkunft_id)){
	   $unterkunft_id = "1";
	}
	if (empty($sprache)){
		//standard-sprache aus datenbank holen:
		$sprache = getStandardSpracheBelegungsplan($unterkunft_id,$link);						
	}
	
if(getAnzahlVorhandeneZimmer($unterkunft_id,$link) > 0){
	
	include_once("leftHelper.php");
	 	
	 if (empty($zimmer_id)){
		$zimmer_id = getFirstRoom($unterkunft_id,$link);
	 } 
	
	setSessionWert(SPRACHE,$sprache);
	setSessionWert(ZIMMER_ID,$zimmer_id);
	setSessionWert(UNTERKUNFT_ID,$unterkunft_id);
		
	// //framegroessen auslesen:;
  	// $framesizeLeftBP = getFramesizeLeftBP($unterkunft_id,$link);
  	// $framesizeRightBP= getFramesizeRightBP($unterkunft_id,$link);
  	// $framesizeLeftBPUnit = getFramesizeLeftBPUnit($unterkunft_id,$link);
  	// $framesizeRightBPUnit= getFramesizeRightBPUnit($unterkunft_id,$link);
  	// if ($framesizeLeftBPUnit == "%"){
  		// $framesizeLeftBP.=$framesizeLeftBPUnit;
  	// }	
  	// if ($framesizeRightBPUnit == "%"){
  		// $framesizeRightBP.=$framesizeRigthBPUnit;
  	// }
  	// //wird der frame oben angezeigt oder links? oben => horizontal=true
	// $horizontal = false;
	// if (getPropertyValue(HORIZONTAL_FRAME,$unterkunft_id,$link) == "true"){
		// $horizontal = true;
	// }	
	
	//prüfe ob alte reservierungen zu löschen sind:
	$xDays = getPropertyValue(RESERVATION_STATE_TIME,$unterkunft_id,$link);
	if (!empty($xDays) && $xDays > 0){
		//sollen die gäste per mail über die löschung
		//ihrer reservierung verständigt werden?
		$ablehnungSenden = isMessageActive($unterkunft_id,AUTO_RESPONSE_ABLEHNUNG,$link);
		
		if (!empty($ablehnungSenden) && $ablehnungSenden == true){
			$reserv = getReservationsBeforeXDays($xDays,STATUS_RESERVIERT);
			while ($l = mysql_fetch_array($reserv)){
				$reservierungsID = $l["PK_ID"];
				$gast_id = getIDFromGast($reservierungsID,$link);
				sendMessage($gast_id,AUTO_RESPONSE_ABLEHNUNG);
			}
		}
		deleteReservationsBeforeXDays($xDays,STATUS_RESERVIERT);
	}	
	
    ?>
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
	<html>
	<head>
		<title>Zimmerreservierungsplan Belegungsplan und Gästedatenbank Rezervi</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	</head>
	<!--
	<frameset 
		<?php if ($horizontal){ ?>
			rows="<?php echo($framesizeLeftBP); ?>,<?php echo($framesizeRightBP); ?>"
		<?php } 
			else {
		?>
			cols="<?php echo($framesizeLeftBP); ?>,<?php echo($framesizeRightBP); ?>"
		<?php } ?>
		framespacing="1" frameborder="yes" border="1" bordercolor="#000000">
	  <frame src="left.php" name="reservierung" frameborder="yes" id="reservierung"/>
	  <frame src="ansichtWaehlen.php?vonStart=true" name="kalender" frameborder="no" id="kalender"/>
	<noframes>	
	-->
	<div class="panel panel-default">
  <div class="panel-body">	
	<div class="row">
		
		<div class="col-md-2">
<!-- Linke Seite mit Menü -->
	
<!-- left.php -->

<table width="100%" border="0">
  <tr>
    <td>
		<?php include_once($root."/templates/selectDatumZimmer.inc.php"); ?>
<?php if (!$horizontal){ ?>
    </td>
  </tr>
  <tr>
    <td>
<?php } ?>
		<?php include_once($root."/templates/selectAnsicht.inc.php"); ?>
		<?php include_once($root."/templates/zimmersucheButton.inc.php"); ?>    
    </td>
<?php if (!$horizontal){ ?>
  </tr>
  <tr>
<?php } ?>
    <td>
		<?php include_once($root."/templates/reservierung.inc.php"); ?>
    </td>
<?php if (!$horizontal){ ?>
  </tr>
  <tr>
<?php } ?>
    <td>
    	<?php include_once($root."/templates/showBelegtFrei.inc.php"); ?>
    	<br/>
		<?php include_once($root."/templates/sprachauswahl.inc.php"); ?>
  	</td>
  </tr>
</table>

<!-- left.php ende -->



		</div>
		<div class="col-md-10">
<!-- Rechte Seite mit Belegungsplan -->


<!-- Ansichtwählen.php -->
			
<?

//script waehlt die korrekte ansicht aus:
//die letzte ansicht wird in der session-veriable ansicht gespeichert
// 0 = right.php
// 1 = jahresuebersicht
// 2 = alle Zimmer
if (isset($ansicht) && $ansicht != ""){
	setSessionWert(ANSICHT,$ansicht);
	switch($ansicht){
		case 0:
			include_once("./right.php");
			break;
		case 1:
			include_once("./jahresuebersicht.php");
			break;
		case 2:
			include_once("./gesamtuebersicht.php");
			break;	
		default:
			include_once("./right.php");
			break;
	} //ende switch
}//ende if
else{
 
 $showMonatsansicht = getPropertyValue(SHOW_MONATSANSICHT,$unterkunft_id,$link);
 $showJahresansicht = getPropertyValue(SHOW_JAHRESANSICHT,$unterkunft_id,$link);
 $showGesamtansicht = getPropertyValue(SHOW_GESAMTANSICHT,$unterkunft_id,$link);
	
	if ($showMonatsansicht == "true"){
		include_once("./right.php");
		exit;
	}
	if ($showJahresansicht == "true"){
		include_once("./jahresuebersicht.php");
		exit;
	}
	if ($showGesamtansicht == "true"){
		include_once("./gesamtuebersicht.php");
		exit;
	}	
}
?>
			
		</div>
		
		
	</div>
	
	<body class="backgroundColor">
	<p>Rezervi Belegungsplan und Kundendatenbank von utilo.eu</p>
	<p><a href="http://www.utilo.eu" target="_parent">http://www.utilo.eu</a></p>
	<p><a href="http://www.rezervi.com" target="_parent">http://www.rezervi.com</a></p>
	</body>
	</noframes>
<?
} 
else{
?>
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
	<html>
	<head>
	<title>Zimmerreservierungsplan Belegungsplan und Gästedatenbank Rezervi</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	</head>
	<body>
	<?php
	//pruefen ob installation schon durchgeführt wurde:
	if (isInstalled($unterkunft_id)){
		echo(getUebersetzung("Es wurden noch keine Mietobjekte (z. B. Zimmer) eingegeben. Bitte rufen sie das Webinterface auf und geben sie ihre Mietobjekte ein.",$sprache,$link));
		?>
			<a href="webinterface/index.php">--> Webinterface</a>
		<?
	}
	else{
	?>
		Please install Rezervi first! <br/>
		Bitte insallieren sie Rezervi zuerst! <br/>
		<a href="install/index.php">--> Install</a>
	<?
	}
	?>
	</body>
<?php
}
?>
</div>
</div>
</html>