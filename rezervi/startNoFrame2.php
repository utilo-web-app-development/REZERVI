<?php  session_start();
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
include_once($root."/include/datumFunctions.php");
include_once($root."/rightHelper.php");	
include_once($root."/leftHelper.php");
include_once($root."/include/propertiesFunctions.php");
include_once($root."/jahresuebersichtHelper.php");
include_once($root."/templates/headerA.php");

		
/*   
			reservierungsplan
			steuerung des kalenders und reservierung für den gast
			author: christian osterrieder utilo.eu
			
			dieser seite kann optional übergeben werden:
			Zimmer PK_ID ($zimmer_id)
			Jahr ($jahr)
			Monat ($monat)
			
			dieser seite muss übergeben werden:
			Unterkunft PK_ID ($unterkunft_id)
		*/

	include_once($root."/include/reseller/reseller.php");
	//datums-funktionen einbinden:
	include_once("./include/datumFunctions.php");
	//uebersetzer einfuegen:
	include_once("./include/uebersetzer.php");
	//helper-datei einfügen:
	include_once("./include/einstellungenFunctions.php");


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
	
	//variablen initialisieren:
	//unset($zimmer_id);
	$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
	$sprache = getSessionWert(SPRACHE);
	if (isset($_GET["vonStart"]) && $_GET["vonStart"] == "true"){
		$zimmer_id = getSessionWert(ZIMMER_ID);
	}
	else{
		$zimmer_id = $_POST["zimmer_id"];
	}
	//falls keine zimmer_id ausgewählt wurde, das erste gefundene zimmer nehmen:
	if (!isset($zimmer_id) || $zimmer_id == "" || empty($zimmer_id)) {
		$zimmer_id = getFirstRoom($unterkunft_id,$link);		
	}
	if (isset($_POST["monat"])){
		$monat = $_POST["monat"];
	}
	if (isset( $_POST["jahr"])){
		$jahr = $_POST["jahr"];
	}	
	setSessionWert(ZIMMER_ID,$zimmer_id);
 	
	$saAktiviert = getPropertyValue(SHOW_OTHER_COLOR_FOR_SA,$unterkunft_id,$link);
	
	$showPic = getPropertyValue(ZIMMER_THUMBS_AV_OV,$unterkunft_id,$link);
	if ($showPic != "true"){
		$showPic = false;
	}
	else{
		$showPic = true;
	}	
	
	//falls kein jahr ausgewählt wurde, das aktuelle jahr verwenden:
	if (!isset($jahr) || $jahr == "" || empty($jahr)){
		$jahr = getTodayYear();
	}
	//ich brauche für jahr einen integer:
	$jahr+=1;$jahr-=1;
	
	//falls kein monat ausgewählt wurde, das aktuelle monat verwenden:
	if (!isset($monat) || $monat == "" || empty($monat)){
		$monat = parseMonthNumber(getTodayMonth());
	}
	//und fürs monat einen integer
	$monat-=1;$monat+=1;
	
    ?>
    
    
  
	
	
	
	<!-- --------------------------------------------------------------------
	
	start.php
	
	--------------------------------------------------------------------- -->

  
    
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
	<html>
	<head>
	<title>Zimmerreservierungsplan Belegungsplan und Gästedatenbank Rezervi</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	</head>
	
<div class="panel panel-default">
  <div class="panel-body">	

	<?php
	 /*
	 *  
	 * TODO: hier linke Navigation und Kalender einbauen
	 * 
	 */
	?>
	

	<?php } ?>
	
	<div class="form-group">
		
		
		<div class="col-md-2">
			
			<!-- TODO: linke Navigation aus left.php einbauen--
			
			
	<!-- -----------------------------------------------------------------------------------
	
	left.php
	
	----------------------------------------------------------------------------------- -->
	
	
	<?php session_start();
$root = ".";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
	/*   
			reservierungsplan
			steuerung des kalenders und reservierung für den gast
			author: christian osterrieder utilo.eu
			
			dieser seite kann optional übergeben werden:
			Zimmer PK_ID ($zimmer_id)
			Jahr ($jahr)
			Monat ($monat)
			
			dieser seite muss übergeben werden:
			Unterkunft PK_ID ($unterkunft_id)
		*/

	include_once("./include/reseller/reseller.php");
	//datums-funktionen einbinden:
	include_once("./include/datumFunctions.php");
	include_once("./include/zimmerFunctions.php");
	include_once("./include/unterkunftFunctions.php");
	//uebersetzer einfuegen:
	include_once("./include/uebersetzer.php");
	//helper-datei einfügen:
	include_once("./leftHelper.php");
	include_once("./include/einstellungenFunctions.php");
	include_once("./include/propertiesFunctions.php");
	
	//variablen initialisieren:
	$zimmer_id = getSessionWert(ZIMMER_ID);
	$sprache = getSessionWert(SPRACHE);
	$unterkunft_id = getSessionWert(UNTERKUNFT_ID);	

	//wird der frame oben angezeigt oder links? oben => horizontal=true
	$horizontal = false;
	if (getPropertyValue(HORIZONTAL_FRAME,$unterkunft_id,$link) == "true"){
		$horizontal = true;
	}
	
	//falls keine zimmer_id ausgewählt wurde, das erste gefundene zimmer nehmen:
	if (empty($zimmer_id)) {
		$zimmer_id = getFirstRoom($unterkunft_id,$link);
	}
	
	//falls kein jahr ausgewählt wurde, das aktuelle jahr verwenden:
	if (empty($jahr)){
		$jahr = getTodayYear();
	}
	else if (isset($_POST["jahr"])){
		$jahr = $_POST["jahr"];
	}
	
	//falls kein monat ausgewählt wurde, das aktuelle monat verwenden:
	if (empty($monat)){
		$monat = getTodayMonth();
	}	
	else if (isset($_POST["monat"])){
		$monat = $_POST["monat"];
	}
	
	$startdatumDP = getTodayDay()."/".parseMonthNumber(getTodayMonth())."/".getTodayYear();	
	$enddatumDP   = $startdatumDP;
	
?>
<?php include_once("./templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<!-- dynamisches update der anzahl der tage für ein gewisses monat mit java-script: -->

<script language="JavaScript" type="text/javascript" src="./templates/changeForms.js">
</script>

<!-- <script language="JavaScript" type="text/javascript" src="./leftJS.js">
</script>
<script type="text/javascript" src="<?php echo($root); ?>/templates/calendarDateInput.php">	
</script> -->



<div class="panel panel-default">
  <div class="panel-body">
  	
<body class="backgroundColor">

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
</body>
</html>
	
	<!-- -----------------------------------------------------------------------------------
	
	left.php
	Ende
	----------------------------------------------------------------------------------- -->

<?php
		
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
	
	//variablen initialisieren:
	$zimmer_id = getSessionWert(ZIMMER_ID);
	$sprache = getSessionWert(SPRACHE);
	$unterkunft_id = getSessionWert(UNTERKUNFT_ID);	

	//wird der frame oben angezeigt oder links? oben => horizontal=true
	$horizontal = false;
	if (getPropertyValue(HORIZONTAL_FRAME,$unterkunft_id,$link) == "true"){
		$horizontal = true;
	}
	
	//falls keine zimmer_id ausgewählt wurde, das erste gefundene zimmer nehmen:
	if (empty($zimmer_id)) {
		$zimmer_id = getFirstRoom($unterkunft_id,$link);
	}
	
	//falls kein jahr ausgewählt wurde, das aktuelle jahr verwenden:
	if (empty($jahr)){
		$jahr = getTodayYear();
	}
	else if (isset($_POST["jahr"])){
		$jahr = $_POST["jahr"];
	}
	
	//falls kein monat ausgewählt wurde, das aktuelle monat verwenden:
	if (empty($monat)){
		$monat = getTodayMonth();
	}	
	else if (isset($_POST["monat"])){
		$monat = $_POST["monat"];
	}
	
	$startdatumDP = getTodayDay()."/".parseMonthNumber(getTodayMonth())."/".getTodayYear();	
	$enddatumDP   = $startdatumDP;
	
?>
<?php include_once("./templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<!-- dynamisches update der anzahl der tage für ein gewisses monat mit java-script: -->

	<?php	
		/*
<script language="JavaScript" type="text/javascript" src="./templates/changeForms.js">
</script>
<script language="JavaScript" type="text/javascript" src="./leftJS.js">
</script>
<script type="text/javascript" src="<?php echo($root); ?>/templates/calendarDateInput.php">
</script>
		 /***********************************************
	* Jason's Date Input Calendar- By Jason Moon http://www.jasonmoon.net/
	* Script featured on and available at http://www.dynamicdrive.com
	* Keep this notice intact for use.
	***********************************************/	
		 
		 
?>		


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


		</div>
		
<!-- -------------------------------------------------------------

linke splate /ende

------------------------------------------------------------ -->

</div>
</div>
</div>
		<div class="col-md-10">
			
	<!-- TODO: Kalender einbauen. 1. Schritt nur right.php -->
	<?php	
		/*
<script language="JavaScript" type="text/javascript" src="./rightJS.js">
</script>	
		 */
		 
?>	


		<?php include_once("./templates/headerB.php"); ?>
<?php //kontrolle ob das monat noch gültig ist:
	
	if ($monat < parseMonthNumber(getTodayMonth()) && $jahr <= getTodayYear()){ ?>
		
			<h5><?php echo(getUebersetzung("<p>Das gewählte Monat ist bereits abgelaufen!</p><p>Bitte korrigieren Sie Ihre Anfrage!</p>",$sprache,$link)); ?></h5>
		
<?php } //ende if monat zu klein
	else { ?>

    <h4><?php echo(getUebersetzung("Belegungsplan",$sprache,$link)); ?> <?php echo($jahr) ?>,
      <?php	$art = getUebersetzungUnterkunft(getZimmerArt($unterkunft_id,$zimmer_id,$link),$sprache,$unterkunft_id,$link);
			$nummer = getUebersetzungUnterkunft(getZimmerNr($unterkunft_id,$zimmer_id,$link),$sprache,$unterkunft_id,$link);
			//wenn zimmernummer und zimmerart gleich sind nur eines ausgeben!
			if ($art != $nummer){
				echo($art);	
			}								   									
            echo(" ").($nummer); ?>
   </h4>
  
    <h3>
    	<?php
			//show pic of the room if activated and pic available:
			if ($showPic){	
				include_once($root."/include/bildFunctions.php");
				  if (hasZimmerBilder($zimmer_id,$link)){	  
					$result = getBilderOfZimmer($zimmer_id,$link);
					while ($z = mysql_fetch_array($result)){
					?><?php
						$pfad = $z["Pfad"];
						$pfad = substr($pfad,6,strlen($pfad));
						$width = $z["Width"];
						$height= $z["Height"];
						$description = $z["Beschreibung"];
						$description = getUebersetzungUnterkunft($description,$sprache,$unterkunft_id,$link);
					  ?>
					  <img src="<?php echo($pfad); ?>"/>&nbsp;
					  
					  	<?php echo $description ?>
					  
					  <?php
					}
				  }			
			}
			?>
	</h3>
	
   <?php
			//kontrolle ob monat nicht 0 oder 13:
			if ($monat > 12){
				$monat = 1;
				$jahr+=1;
			} 
			elseif ($monat < 1){
				$monat = 12;
				$jahr-=1;
			}
			//monat ausgeben:
			showMonth($monat,$jahr,$unterkunft_id,$zimmer_id,$link,$saAktiviert,$sprache);
			//monat erhöhen für nächste ausgabe:
			$monat+=1;
		?>
   <?php
			//kontrolle ob monat nicht 0 oder 13:
			if ($monat > 12){
				$monat = 1;
				$jahr+=1;
			} 
			elseif ($monat < 1){
				$monat = 12;
				$jahr-=1;
			}
			//monat ausgeben:
			showMonth($monat,$jahr,$unterkunft_id,$zimmer_id,$link,$saAktiviert,$sprache);
			//monat erhöhen für nächste ausgabe:
			$monat+=1;
		?>
  
  <?php
			//kontrolle ob monat nicht 0 oder 13:
			if ($monat > 12){
				$monat = 1;
				$jahr+=1;
			} 
			elseif ($monat < 1){
				$monat = 12;
				$jahr-=1;
			}
			//monat ausgeben:
			showMonth($monat,$jahr,$unterkunft_id,$zimmer_id,$link,$saAktiviert,$sprache);
			//monat erhöhen für nächste ausgabe:
			$monat+=1;
		?>
    <?php
			//kontrolle ob monat nicht 0 oder 13:
			if ($monat > 12){
				$monat = 1;
				$jahr+=1;
			} 
			elseif ($monat < 1){
				$monat = 12;
				$jahr-=1;
			}
			//monat ausgeben:
			showMonth($monat,$jahr,$unterkunft_id,$zimmer_id,$link,$saAktiviert,$sprache);			
		?>
 
  
    <?php 
		//wenn jahr zu klein, button nicht anzeigen:		
		$mon = $monat-7;
//		echo($mon);																
		 $jah = $jahr;
		 switch ($mon){
			case 0:
				$mon = 12;
				$jah = $jah-1;
				break;
			case -1:
				$mon = 11;
				$jah = $jah-1;
				break;
			case -2:
				$mon = 10;
				$jah = $jah-1;
				break;
			case -3:
				$mon = 9;
				$jah = $jah-1;
				break;
			case -4:
				$mon = 8;
				$jah = $jah-1;
				break;
			case -5:
				$mon = 7;
				$jah = $jah-1;
				break;
			case -6:
				$mon = 6;
				$jah = $jah-1;
				break;	
		 }
		 if ($jah < 	getTodayYear() || ($jah <= getTodayYear()  && $mon+1 <= parseMonthNumber(getTodayMonth()))){
				$jah = getTodayYear();
		 }																	 																
		 else {														 																			
		?>
		
      <form action="./startNoFrame2.php" method="post" name="monatZurueck" target="_self" id="monatZurueck">
        <div align="right">          
          <input name="zimmer_id" type="hidden" id="zimmer_id" value="<?php echo $zimmer_id ?>">
          <input name="monat" type="hidden" id="monat" value="<?php echo($mon); ?>">
          <input name="jahr" type="hidden" id="jahr" value="<?php echo($jah); ?>">
          <input name="zurueck" type="submit" class="btn btn-primary" ;" onClick="updateLeft(<?php echo(($mon).",".($jah).",".($zimmer_id)); ?>,0);" id="zurueck" 
	   value="<?php echo(getUebersetzung("einen Monat zurück",$sprache,$link)); ?>">
        </div>
      </form>
      <?php }
	   ?>
    <?php
		//wenn jahr zu gross wird, button nicht mehr anzeigen:
		$mo = $monat+1;
		$ja = $jahr;
		//bis 4 jahre in die future anzeigen:
		if ($ja > (getTodayYear()+4)){
		 	$ja = (getTodayYear()+4);
			$mo = 8;
		}		
		else { 																													
		?>
      <form action="./startNoFrame2.php" method="post" name="monatWeiter" target="_self" id="monatWeiter"> 
        <input name="zimmer_id" type="hidden" id="zimmer_id" value="<?php echo $zimmer_id ?>">
        <input name="monat" type="hidden" id="monat" value="<?php 
		  														if ($mo > 12){
																	$mo = 1;
																	$ja +=1;
																} 
																echo($mo); 
																?>">
        <input name="jahr" type="hidden" id="jahr" value="<?php echo ($ja); ?>">
        <input name="weiter" type="submit" class="btn btn-primary" onClick="updateLeft(<?php echo(($mo).",".($ja)).",".($zimmer_id); ?>,1);" id="weiter" 
	   value="<?php echo(getUebersetzung("einen Monat weiter",$sprache,$link)); ?>">
	  
      </form>
      <?php } ?>
  

<?php } //ende else monat zu klein ?>






	

</div>
</html>
