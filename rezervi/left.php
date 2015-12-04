<?php session_start();
$root = ".";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
	/*   
			reservierungsplan
			steuerung des kalenders und reservierung f�r den gast
			author: christian osterrieder utilo.eu
			
			dieser seite kann optional �bergeben werden:
			Zimmer PK_ID ($zimmer_id)
			Jahr ($jahr)
			Monat ($monat)
			
			dieser seite muss �bergeben werden:
			Unterkunft PK_ID ($unterkunft_id)
		*/

	include_once("./include/reseller/reseller.php");
	//datums-funktionen einbinden:
	include_once("./include/datumFunctions.php");
	include_once("./include/zimmerFunctions.php");
	include_once("./include/unterkunftFunctions.php");
	//uebersetzer einfuegen:
	include_once("./include/uebersetzer.php");
	//helper-datei eing�en:
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
	
	//falls keine zimmer_id ausgew�hlt wurde, das erste gefundene zimmer nehmen:
	if (empty($zimmer_id)) {
		$zimmer_id = getFirstRoom($unterkunft_id,$link);
	}
	
	//falls kein jahr ausgew�hlt wurde, das aktuelle jahr verwenden:
	if (empty($jahr)){
		$jahr = getTodayYear();
	}
	else if (isset($_POST["jahr"])){
		$jahr = $_POST["jahr"];
	}
	
	//falls kein monat ausgew�hlt wurde, das aktuelle monat verwenden:
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
<!-- dynamisches update der anzahl der tage f�r ein gewisses monat mit java-script: -->
<script language="JavaScript" type="text/javascript" src="./templates/changeForms.js">
</script>
<script language="JavaScript" type="text/javascript" src="./leftJS.js">
</script>
<script type="text/javascript" src="<?php echo($root); ?>/templates/calendarDateInput.php">
	/***********************************************
	* Jason's Date Input Calendar- By Jason Moon http://www.jasonmoon.net/
	* Script featured on and available at http://www.dynamicdrive.com
	* Keep this notice intact for use.
	***********************************************/	
</script>
</head>
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