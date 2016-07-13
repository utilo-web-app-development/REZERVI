<?php 
/**
 * Created on 22.01.2007
 *
 * @author coster alpstein austria
 */ 
 if (!isset($nachricht)){
	 session_start();
	 $root = ".";
	 
	 // Send modified header for session-problem of ie:
	 // @see http://de.php.net/session
	 header('P3P: CP="NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM"');
 }

 include_once($root."/conf/conf.inc.php"); //conf hinzufuegen
 include_once($root."/include/rdbmsConfig.inc.php"); //datenbank oeffnen
 
 include_once($root."/include/uebersetzer.inc.php"); //uebersetzungen hinzufuegen
 include_once($root."/include/sessionFunctions.inc.php"); //session funktionen
 include_once($root."/include/cssFunctions.inc.php"); //stylesheet definitionen als konstanten
 include_once($root."/include/vermieterFunctions.inc.php"); //infos ueber gastro betrieb
 include_once($root."/include/mietobjektFunctions.inc.php"); //raum und tisch infos
 include_once($root."/include/datumFunctions.inc.php"); //manipulation des datums
 include_once($root."/include/reservierungFunctions.inc.php"); //reservierungen abfragen
 include_once($root."/templates/constants.inc.php"); //allgemeine konstanten
 include_once($root."/include/bildFunctions.inc.php"); 
 
 define("BREITE_KALENDER",200);
 //constante fuer default transparenz wert:
 define("TRANSPARENZ",15);

//---------------------------------------------------------------------------
//als erstes pruefen ob per get oder post diverse variablen uebergeben wurden
//vermieter bzw. gastronomiebetrieb?
if (isset($_GET["gastro_id"])){
	$gastro_id = $_GET["gastro_id"];
}
else if (isset($_POST["gastro_id"])){
	$gastro_id = $_POST["gastro_id"];	
}
else if (getSessionWert(GASTRO_ID) != false){
	$gastro_id = getSessionWert(GASTRO_ID);
}
else{
	$gastro_id = 1;
}
setSessionWert(GASTRO_ID,$gastro_id);
 // pruefe ob bookline bereits installiert wurde:
 include_once($root."/components/checkInstall.php"); 
//sprache?
if (isset($_GET["sprache"])){
	$sprache = $_GET["sprache"];	
}
else if (isset($_POST["sprache"])){
	$sprache = $_POST["sprache"];	
}
else if (getSessionWert(SPRACHE) != false){
	$sprache = getSessionWert(SPRACHE);
}
else{
	$sprache = getGastroProperty(STANDARDSPRACHE,$gastro_id);
}
setSessionWert(SPRACHE,$sprache);

//setSessionWert(SPRACHE,$sprache);
//mietobjekt?
if (isset($_GET["mietobjekt_id"])){
	$mietobjekt_id = $_GET["mietobjekt_id"];
}
else if (isset($_POST["mietobjekt_id"])){
	$mietobjekt_id = $_POST["mietobjekt_id"];	
}
else if (getSessionWert(MIETOBJEKT_ID) != false){
	$mietobjekt_id = getSessionWert(MIETOBJEKT_ID);
}
else{
	$mietobjekt_id = getFirstRaumId($gastro_id);	
}
//setSessionWert(MIETOBJEKT_ID,$mietobjekt_id);
//----------------------------------------------------------------
//das datum ermitteln:
if (isset($_POST["datum"])){
	$jahr = getJahrFromDatePicker($_POST["datum"]);
}
else if (isset($_POST["jahr"])){
	$jahr = $_POST["jahr"];
}
else{
	$jahr = getTodayYear();
}
if (isset($_POST["datum"])){
	$monat = getMonatFromDatePicker($_POST["datum"]);
}
else if (isset($_POST["monat"])){
	$monat = $_POST["monat"];
}	
else{
	$monat = getTodayMonth();
}
if (isset($_POST["datum"])){
	$tag = getTagFromDatePicker($_POST["datum"]);
}
else if (isset($_POST["tag"])){
	$tag = $_POST["tag"];
}	
else{
	$tag = getTodayDay();
}
if (isset($_POST["minute"])){
	$minute = $_POST["minute"];
}
else{
	$minute = getTodayMinute();
}
if (isset($_POST["stunde"])){
	$stunde = $_POST["stunde"];
}
else{
	$stunde = getTodayStunde();
}
//pruefe ob ein tisch gebucht wurde:
$raum_id = $mietobjekt_id;
$tische = getTische($raum_id);
$reservierungen[] = array();
while($d = $tische->FetchNextObject()) {
	$id = $d->TISCHNUMMER;	
	if (isset($_POST["tischgebucht_".$id]) && $_POST["tischgebucht_".$id] == "true"){
		$reservierungen[]=$id;
	}	
} //ende pruefe ob tisch gebucht wurde

//datum fuer datepicker setzen:
$startdatumDP = $tag."/".$monat."/".$jahr;

$bilder_id  = getBildOfRaum($raum_id); 
$bildbreite = getBildBreite($bilder_id);
$bildhoehe  = getBildHoehe($bilder_id);

$maxAnzahlPersonen = getMaximaleBelegungOfRaum($raum_id); 
$minAnzahlPersonen = getMinimaleBelegungOfRaum($raum_id);

//header einfuegen:
?>
<!DOCTYPE html>
<html>
<head>
<title>Bookline Booking System - Bookline Buchungssystem - UTILO</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<style type="text/css">
	<?php  include_once($root."/templates/stylesheets.php");  ?>
</style>
<link rel="stylesheet" type="text/css" href="<?php echo $root ?>/templates/round_tabs.css">
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.7.0/build/tabview/assets/tabview.css">
<link rel="stylesheet" type="text/css" href="<?php echo $root ?>/templates/rezerviTable.css">
<script type="text/javascript" src="<?php echo $root ?>/templates/calendarDateInput.inc.php?root=<?php echo $root ?>">
	/***********************************************
	* Jason's Date Input Calendar- By Jason Moon http://www.jasonmoon.net/
	* Script featured on and available at http://www.dynamicdrive.com
	* Keep this notice intact for use.
	***********************************************/	
</script>
<!-- Namespace source file  
<script type="text/javascript" src = '<?php echo $root ?>/yui/build/yahoo/yahoo.js' ></script>
<script type="text/javascript" src = '<?php echo $root ?>/yui/build/dom/dom.js' ></script> 
<script type="text/javascript" src="<?php echo $root ?>/yui/build/event/event.js"></script>
-->
<script src="http://yui.yahooapis.com/2.7.0/build/yahoo/yahoo-min.js"></script>
<script src="http://yui.yahooapis.com/2.7.0/build/dom/dom-min.js"></script>
<script type="text/javascript" src="http://yui.yahooapis.com/2.7.0/build/event/event-min.js" ></script>

<!-- transparenz fuer objekte -->
<script type="text/javascript" src='<?php echo $root ?>/templates/transobj.js' ></script>
<script type="text/javascript">

	function tischPos(x,y,element){
		var DOM = YAHOO.util.Dom;
		DOM.setX(element,x+DOM.getX("raum"));
		DOM.setY(element,y+DOM.getY("raum"));
	}
	
	function bildPosKorr(){
		var DOM = YAHOO.util.Dom;
		var raumPos = DOM.getXY("raum");
		DOM.setXY('raumbild',raumPos);
	}
	
	function tischInfo(tisch_id){
		//var DOM = YAHOO.util.Dom;
		//var tischSymbPos = DOM.getXY("tisch"+tisch_id);
		var tisch = document.getElementById("tischInfo_"+tisch_id);
		tisch.style.visibility="visible";
		//DOM.setXY(tisch,tischSymbPos);
	}
	
	function exitTischInfo(tisch_id){
		//var DOM = YAHOO.util.Dom;
		var tisch = document.getElementById("tischInfo_"+tisch_id);
		tisch.style.visibility="hidden";
		//DOM.setX(tisch,-500);
	}
	
	/*
	fuegt einen tisch zur tischliste hinzu
	*/
	function addTisch(tischnummer){
		var selectBox = document.getElementById('tische');
		//wenn tisch noch nicht vorhanden, hinzufügen, sonst fehlermeldung ausgeben:
		var i;
		var vorhanden = false;
		for(i=selectBox.options.length-1;i>=0;i--){
			if(selectBox.options[i].value == tischnummer){
				vorhanden = true;
				break;
			}
			
		}
		if (vorhanden){
			alert("<?php echo getUebersetzung("Der Tisch wurde bereits ausgewählt.") ?>");
		}
		else{			
			var optn = document.createElement("OPTION");
			optn.text = "<?php echo getUebersetzung("Tisch Nr."); ?> "+tischnummer;
			optn.value = tischnummer;
			selectBox.options.add(optn);
			alert("<?php echo getUebersetzung("Der Tisch wurde zur Auswahl links hinzugefügt.  Sie können nun noch weitere Tische reservieren, starten Sie danach die Reservierung links.") ?>");
			exitTischInfo(tischnummer);
		}
	}
	/*
	fuegt einen tisch zur tischliste hinzu
	*/
	function removeAllTische(){
		var selectBox = document.getElementById('tische');
		var i;
		for(i=selectBox.options.length-1;i>=0;i--){			
				 selectBox.remove(i);						
		}
		alert("<?php echo getUebersetzung("Alle ausgewählten Tische wurden entfernt.") ?>");
	}
	/*
	prueft ob ein tisch selectiert wurde und loest reservierungsvorgang aus
	*/	
	function submitReservierung(){
		var selectBox = document.getElementById('tische');
		var i =selectBox.options.length;
		if (i<1){
			alert("<?php echo getUebersetzung("Bitte wählen Sie zuerst einen Tisch aus.") ?>");
			return false;
		}
		else{
			//alle tische selectieren und formular abschicken:
			for(i=selectBox.options.length-1;i>=0;i--){			
				 selectBox.options[i].selected = true;					
			}
			//send form:
			document.reservationForm.action = "<?php echo $root ?>/frontpage/anfrage/index.php";
			document.reservationForm.submit();
			return true;
		}
	}
	/*
	zeigt die reservierungen wenn datum oder anzahl personen verändert wurde;
	*/
	function showReservations(){
		document.reservationForm.submit();
		return true;
	}
	
</script>

<script type="text/javascript">

	 function init() {

			//raum bild richtig positionieren:
			bildPosKorr();
			
			//tische positionieren:
			<?php
			$res  = getTische($raum_id);
			while($d = $res->FetchNextObject()) {
				$id = $d->TISCHNUMMER;	
				$lefts = getLeftPosOfTisch($id);
				$tops  = getTopPosOfTisch($id);
				?>
				tischPos(<?php echo $lefts ?>, <?php echo $tops ?>, 'tisch<?php echo $id ?>');
				transparency('tischInfo_<?php echo $id ?>',<?php echo TRANSPARENZ ?>);
				tischPos(<?php echo $lefts ?>, <?php echo $tops ?>, 'tischInfo_<?php echo $id ?>');
				<?php
			}
			?>	

	 }
	 
	 YAHOO.util.Event.onDOMReady(init);

 </script>


</head>
<?php
include_once($root."/templates/bodyStart.inc.php");
include_once($root."/templates/roomTabs.inc.php");
include_once($root."/templates/raumPlan.inc.php");
include_once($root."/templates/footer.inc.php");

?>
