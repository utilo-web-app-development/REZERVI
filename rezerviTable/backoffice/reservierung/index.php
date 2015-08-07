<?php
$root = "../.."; 
$ueberschrift = "Reservierungen bearbeiten";

/*   
	date: 20.10.05
	author: christian osterrieder alpstein-austria						
*/
//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/include/mietobjektFunctions.inc.php");
include_once($root."/include/vermieterFunctions.inc.php");
include_once($root."/include/datumFunctions.inc.php");
include_once($root."/include/reservierungFunctions.inc.php");
include_once($root."/templates/constants.inc.php");	
include_once($root."/backoffice/reservierung/tagesuebersicht.php");
include_once($root."/include/oeffnungszeitenFunktions.inc.php");
include_once($root."/include/buchungseinschraenkung.inc.php");

//soll eine reservierung entfernt werden?
if (isset($_POST["doDeleteReservierung"]) && isset($_POST["reservierung_id"])){
	$reservierung_id = $_POST["reservierung_id"];
	deleteReservation($reservierung_id);
}

//muss die reservierung veraendert werden?
if (isset($_POST["doChangeReservation"])){
	
	$reservierung_id = $_POST["reservierung_id"];
	$bisMinute = $_POST["bisMinute"];
	$vonMinute = $_POST["vonMinute"];
	$vonStunde = $_POST["vonStunde"];
	$bisStunde = $_POST["bisStunde"];
	$tisch_id = $_POST["table_id"];
	$raum_id = $_POST["raum_id"];
	$datumVon = $_POST["datumVon"];
	$tag = getTagFromDatePicker($datumVon);
	$monat = getMonatFromDatePicker($datumVon); 
	$jahr = getJahrFromDatePicker($datumVon); 
	changeReservationTime($reservierung_id,$tisch_id,$vonMinute,$vonStunde,$bisMinute,$bisStunde, 
						  $tag, $monat, $jahr);
	
}

//muss eine reservierung eingetragen werden?
if (isset($_POST["doAddRes"])){

	include_once($root."/backoffice/reservierung/resEintragen.php");

}

	//falls keine raum_id ausgewählt wurde, der erste gefundene raum nehmen:
	if (isset($_POST["raum_id"])) {
		$raum_id = $_POST["raum_id"];
	}else{
		$raum_id = getFirstRaumId($gastro_id);
	}
	if (isset($_POST["table_id"])) {
		$tisch_id = $_POST["table_id"];
	}else{
		$tisch_id = getFirstTischId($raum_id);
	}
	//falls kein jahr ausgewählt wurde, das aktuelle jahr verwenden:
	if (isset($_POST["datumAnsicht"])){
		$jahr = getJahrFromDatePicker($_POST["datumAnsicht"]);
	}else if(isset($_POST["datumVon"])){
		$jahr = getJahrFromDatePicker($_POST["datumVon"]);
	}else if (isset($_POST["jahr"])){
		$jahr = $_POST["jahr"];
	}else{
		$jahr = getTodayYear();
	}
	
	if (isset($_POST["minute"])){
		$minute = $_POST["minute"];
	}else{
		$minute = getTodayMinute();
	}
	
	if (isset($_POST["stunde"])){
		$stunde = $_POST["stunde"];
	}else{
		$stunde = getTodayStunde();
	}
	
	if (isset($_POST["datumAnsicht"])){
		$monate = getMonatFromDatePicker($_POST["datumAnsicht"]);
	}else if(isset($_POST["datumVon"])){
		$monate = getMonatFromDatePicker($_POST["datumVon"]);
	}else if (isset($_POST["monat"])){
		$monate = $_POST["monat"];
	}else{
		$monate = getTodayMonth();
	}	
	
	if (isset($_POST["datumAnsicht"])){
		$tag = getTagFromDatePicker($_POST["datumAnsicht"]);
	}else if(isset($_POST["datumVon"])){
		$tag = getTagFromDatePicker($_POST["datumVon"]);
	}else if (isset($_POST["tag"])){
		$tag = $_POST["tag"];
	}else{
		$tag = getTodayDay();
	}
	
	if (isset($_POST["ansicht"])){
		$ansicht = $_POST["ansicht"];
	}else if(isset($_GET["ansicht"])){		
		$ansicht = $_GET["ansicht"];
	}else{
		$ansicht = "Tagesansicht";
	}
	
	if (isset($_POST["vonMinute"])){
		$vonMinute = $_POST["vonMinute"];
		$minute = $vonMinute;
	}else{
		$vonMinute = getTodayMinute();
	}
	if (isset($_POST["bisMinute"])){
		$bisMinute = $_POST["bisMinute"];
	}else{
		$bisMinute = getTodayMinute();
	}
	if (isset($_POST["bisStunde"])){
		$bisStunde = $_POST["bisStunde"];
	}else{
		$bisStunde = getTodayStunde();
	}
	if (isset($_POST["vonStunde"])){
		$vonStunde = $_POST["vonStunde"];
		$stunde = $vonStunde;
	}else{
		$vonStunde = getTodayStunde();
	}
	
	if (isset($_POST["vonTag"])){
		$vonTag = $_POST["vonTag"];
		$tag = $vonTag;
	}else{
		$vonTag = getTodayDay();
	}
	if (isset($_POST["bisTag"])){
		$bisTag = $_POST["bisTag"];
	}else{
		$bisTag = getTodayDay();
	}
	if (isset($_POST["vonMonat"])){
		$vonMonat = $_POST["vonMonat"];
		$monate = $vonMonat;
	}else{
		$vonMonat = getTodayMonth();
	}
	if (isset($_POST["bisMonat"])){
		$bisMonat = $_POST["bisMonat"];
	}else{
		$bisMonat = getTodayMonth();
	}
	if (isset($_POST["vonJahr"])){
		$vonJahr = $_POST["vonJahr"];
		$jahr = $vonJahr;
	}else{
		$vonJahr = getTodayYear();
	}
	if (isset($_POST["bisJahr"])){
		$bisJahr = $_POST["bisJahr"];
	}else{
		$bisJahr = getTodayYear();
	}
	if (isset($_POST["block"])){
		$nachricht = blockieren($tag,$monate,$jahr,$gastro_id);
		if($nachricht != "false"){
			$info = true;
		}else{
			$fehler = true;
		}
	}
	$startdatumDP = $tag."/".$monate."/".$jahr;
	$enddatumDP =   $startdatumDP;

include_once($root."/backoffice/templates/breadcrumps.inc.php");
$breadcrumps = erzeugenBC($root, "Reservierungen", "reservierung/index.php",
							$ansicht, "reservierung/index.php?ansicht=".$ansicht);
include_once($root."/backoffice/templates/bodyStart.inc.php");

?>

<script src="<?=$root?>/backoffice/templates/prototype.js"></script>
<script language="javascript">
	function newload(id, gastro_id, raum_id, tag, monate, jahr){
		if(id == "0"){
			$('panel1_hd').innerHTML = "<?= getUebersetzung("Reservierung bearbeiten") ?>";				
			$('panel1_bd').innerHTML = "<iframe src=\"./dispInfo.php\" width=\"100%\" height=\"100%\" frameborder=0 scrolling=auto></iframe>";
			$('panel1_bd').style.height = "80px"
		}else if(id == "2"){
			$('panel1_hd').innerHTML = "<?= getUebersetzung("Reservierung bearbeiten") ?>";				
			$('panel1_bd').innerHTML = "<iframe src=\"./dispBlock.php\" width=\"100%\" height=\"100%\" frameborder=0 scrolling=auto></iframe>";
			$('panel1_bd').style.height = "80px"
		}else{
			var status = id.substring(0,1);
			var tisch_id = id.substring(1,2+id.length-6);
			var vonStunde = id.substring(2+id.length-6,4+id.length-6);
			var vonMinute = id.substring(4+id.length-6,6+id.length-6);
			var inhalt = "";
			if(status == "1"){
				$('panel1_hd').innerHTML = "<?= getUebersetzung("Reservierung ändern für Tisch") ?>"+" "+tisch_id;				
				$('panel1_bd').innerHTML = "<iframe src=\"./dispAendern.php?root=<?= $root ?>&gastro_id="+gastro_id+"&sprache=<?= $sprache ?>&raum_id="+raum_id+"&tisch_id="+tisch_id+"&vonStunde="+vonStunde+"&vonMinute="+vonMinute+"&tag="+tag+"&monate="+monate+"&jahr="+jahr+"\" width=\"100%\" height=\"100%\" frameborder=0 scrolling=auto></iframe>";
				$('panel1_bd').style.height = "220px";
			}else if (status == "0"){	
				$('panel1_hd').innerHTML = "<?= getUebersetzung("Reservierung hinzufügen für Tisch") ?>"+" "+tisch_id;
				$('panel1_bd').innerHTML = "<iframe src=\"./dispHinfuegen.php?root=<?= $root ?>&gastro_id="+gastro_id+"&sprache=<?= $sprache ?>&raum_id="+raum_id+"&tisch_id="+tisch_id+"&vonStunde="+vonStunde+"&vonMinute="+vonMinute+"&tag="+tag+"&monate="+monate+"&jahr="+jahr+"\" width=\"100%\" height=\"100%\" frameborder=0 scrolling=auto></iframe>";
				$('panel1_bd').style.height = "400px";
			}
		}	
	}
</script>

<script language="JavaScript" type="text/javascript" src="<?= $root ?>/backoffice/reservierung/leftJS.js"></script>
<script type="text/javascript" src="<?= $root ?>/templates/calendarDateInput.inc.php?root=<?= $root ?>">
	/***********************************************
	* Jason's Date Input Calendar- By Jason Moon http://www.jasonmoon.net/
	* Script featured on and available at http://www.dynamicdrive.com
	* Keep this notice intact for use.
	***********************************************/	
</script>
<script type="text/javascript" src="<?= $root ?>/yui/build/dragdrop/dragdrop.js" ></script>
<script type="text/javascript" src="<?= $root ?>/yui/build/container/container.js"></script>
<link href="<?= $root ?>/yui/build/container/assets/container_bookline.css" rel="stylesheet" type="text/css">	

<script>
	YAHOO.namespace("example.container");
	// BEGIN RESIZEPANEL SUBCLASS //
	YAHOO.widget.ResizePanel = function(el, userConfig) {
		if (arguments.length > 0) {
			YAHOO.widget.ResizePanel.superclass.constructor.call(this, el, userConfig);
		}
	}
	YAHOO.extend(YAHOO.widget.ResizePanel, YAHOO.widget.Panel);
	YAHOO.widget.ResizePanel.CSS_PANEL_RESIZE = "resizepanel";
	YAHOO.widget.ResizePanel.CSS_RESIZE_HANDLE = "resizehandle";
	YAHOO.widget.ResizePanel.prototype.init = function(el, userConfig) {
		YAHOO.widget.ResizePanel.superclass.init.call(this, el);
		this.beforeInitEvent.fire(YAHOO.widget.ResizePanel);
		YAHOO.util.Dom.addClass(this.innerElement, YAHOO.widget.ResizePanel.CSS_PANEL_RESIZE);
		this.resizeHandle = document.createElement("DIV");
		this.resizeHandle.id = this.id + "_r";
		this.resizeHandle.className = YAHOO.widget.ResizePanel.CSS_RESIZE_HANDLE;
		this.beforeShowEvent.subscribe(
			function() {
				this.body.style.overflow = "auto";
			}, this, true);
		this.beforeHideEvent.subscribe(
			function() {
			/* Set the CSS "overflow" property to "hidden" before
			hiding the panel to prevent the scrollbars from 
			bleeding through on Firefox for OS X.
			*/
				this.body.style.overflow = "hidden";
			}, this, true);
		this.beforeRenderEvent.subscribe(
			function() {
			/* Set the CSS "overflow" property to "hidden" by
            default to prevent the scrollbars from bleeding
            through on Firefox for OS X.
            */
				this.body.style.overflow = "hidden";
				if (! this.footer) {
					this.setFooter("");
				}
			}, this, true);
		this.renderEvent.subscribe(
			function() {
				var me = this;
				me.innerElement.appendChild(me.resizeHandle);
				this.ddResize = new YAHOO.util.DragDrop(this.resizeHandle.id, this.id);
				his.ddResize.setHandleElId(this.resizeHandle.id);
				var headerHeight = me.header.offsetHeight;
				this.ddResize.onMouseDown = function(e) {
					this.startWidth = me.innerElement.offsetWidth;
					this.startHeight = me.innerElement.offsetHeight;
					me.cfg.setProperty("width", this.startWidth + "px");
					me.cfg.setProperty("height", this.startHeight + "px");
					this.startPos = [YAHOO.util.Event.getPageX(e), YAHOO.util.Event.getPageY(e)];
					me.innerElement.style.overflow = "hidden";
					me.body.style.overflow = "auto";
				}
				this.ddResize.onDrag = function(e) {
					var newPos = [YAHOO.util.Event.getPageX(e),	 YAHOO.util.Event.getPageY(e)];
					var offsetX = newPos[0] - this.startPos[0];
					var offsetY = newPos[1] - this.startPos[1];
					var newWidth = Math.max(this.startWidth + offsetX, 10);
					var newHeight = Math.max(this.startHeight + offsetY, 10);
					me.cfg.setProperty("width", newWidth + "px");
					me.cfg.setProperty("height", newHeight + "px");
					var bodyHeight = (newHeight - 5 - me.footer.offsetHeight - me.header.offsetHeight - 3);
					if (bodyHeight < 0) {
						bodyHeight = 0;
					}
					me.body.style.height =  bodyHeight + "px";
					var innerHeight = me.innerElement.offsetHeight;
					var innerWidth = me.innerElement.offsetWidth;
					if (innerHeight < headerHeight) {
						me.innerElement.style.height = headerHeight + "px";
					}
					if (innerWidth < 20) {
						me.innerElement.style.width = "20px";
					}
				}
			}, this, true);
		if (userConfig) {
			this.cfg.applyConfig(userConfig, true);
		}
		this.initEvent.fire(YAHOO.widget.ResizePanel);
	};
	YAHOO.widget.ResizePanel.prototype.toString = function() {
		return "ResizePanel " + this.id;
	};
	// END RESIZEPANEL SUBCLASS //
	function init() {	
				YAHOO.example.container.panel1 = new YAHOO.widget.ResizePanel("panel1", { width:"350px", visible:false, constraintoviewport:true, fixedcenter:true} );
				YAHOO.example.container.panel1.render();
				
				YAHOO.util.Event.addListener("show", "click", YAHOO.example.container.panel1.show, YAHOO.example.container.panel1, true);
 	}
 	YAHOO.util.Event.addListener(window, "load", init);
 	
</script>
<?php
if ($ansicht == TAGESANSICHT){
	?>
	<p><?= getUebersetzung("Klicken Sie auf ein Feld in der Reservierungsübersicht um eine Reservierung zu ändern, zu löschen oder neu anzulegen.") ?></p>
<?php
}
?>
<table>
	<form action="./index.php" method="post" name="reservierung">
	<tr>
		<td valign="center"><?= getUebersetzung("Raum") ?>: 
		</td>
		<td>
			<select name="raum_id"  id="raum_id" onchange="submit()"> <?
				$rooms = getRaeume($gastro_id);
				while($room = $rooms->FetchNextObject()){?>
					<option value="<? echo $room->RAUM_ID ?>"<? if ($raum_id == $room->RAUM_ID) {echo(" selected=\"selected\"");} ?>>
					<?php echo($room->BEZEICHNUNG); ?>
					</option> <?  
				} ?>
			</select>
		</td>
		<td><?= getUebersetzung("Datum") ?>:
		</td>
		<td>
			<script>DateInput('datumAnsicht', true, 'DD/MM/YYYY','<?= $startdatumDP  ?>')</script>
		</td>
		<td>
			<input type="hidden" name="ansicht" value="<?= $ansicht ?>"/>
		  	<input name="ansichtWechseln" type="submit" id="ansichtWechseln" class="button"
		      value="<?php echo(getUebersetzung("anzeigen")); ?>">
		</td>
		<td>
			<input type="hidden" name="ansicht" value="<?= $ansicht ?>"/>
		  	<input name="block" type="submit" id="block" class="button"
		      value="<?php echo(getUebersetzung("blockieren")); ?>">
		</td>			
	</tr>	
	</form>	  
</table>
<table>
	<tr>
		<td>
<?php
			if ($ansicht == LISTENANSICHT){
				include_once("./tagesList.php");
			}
			else if ($ansicht == TAGESANSICHT){
				showDayDetail($ansicht,$tag,$monate,$jahr,$raum_id,$gastro_id,MODUS_WEBINTERFACE);
			}
?>
		</td>		
	</tr>	
</table>
<?php
include_once($root."/backoffice/templates/footer.inc.php");

function blockieren($tag,$monate,$jahr,$gastro_id){

	$typ = BE_TYP_DATUM_VON_BIS;	
 	$datum = $tag."/".$monate."/".$jahr;
 	$datumVon = constructMySqlTimestampFromDatePicker($datum,0,0);
 	$datumBis = constructMySqlTimestampFromDatePicker($datum,59,23);
 
 	$res = getAllTische($gastro_id);
 	while ($d = $res->FetchNextObject()){
 		$tisch_id = $d->TISCHNUMMER;
 		insertBuchungseinschraenkungVonBis($tisch_id,$datumVon,$datumBis,$typ);
 	}
	return getUebersetzung("Die Reservierungen für den aktuellen Tag wurden erfolgreich blockiert.");
}
?>	
