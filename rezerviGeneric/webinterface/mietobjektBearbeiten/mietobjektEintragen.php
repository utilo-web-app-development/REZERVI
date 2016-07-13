<?php $root = "../..";

/*   
	date: 23.9.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");
include_once($root."/include/vermieterFunctions.inc.php");

//andere funktionen importieren:
include_once($root."/include/mietobjektFunctions.inc.php");
	$standardsprache = getVermieterEigenschaftenWert(STANDARDSPRACHE,$vermieter_id);
	if ($standardsprache == false || $standardsprache == ""){
		$standardsprache = "en";
	}

	$preis =  $_POST["preis"];
	$linkName =  $_POST["linkName"];

	//uebersetzungen in array sammeln:
	$uebers_bez = array();
	$uebers_bes = array();
	$defaultBezeichnung = false;
	$defaultBeschreibung = false;
    $res = getActivtedSprachenOfVermieter($vermieter_id);
    while ($d = mysql_fetch_array($res)){
    	$sprache_id = $d["SPRACHE_ID"];
		
		$bezeichnung = false;
		if (isset($_POST["bezeichnung_".$sprache_id])){
			$bezeichnung = $_POST["bezeichnung_".$sprache_id];
		}
		$beschreibung = false;
		if (isset($_POST["beschreibung_".$sprache_id])){
			$beschreibung =  $_POST["beschreibung_".$sprache_id];
		}

		if (($standardsprache == $sprache_id) && ($bezeichnung == "" || $bezeichnung == false)){
			$fehler = true;
			$nachricht = getUebersetzung("Bitte geben sie die Bezeichnung ihrer Standardsprache ein!");
			$nachricht .= " (".getUebersetzung(getBezeichnungOfSpracheID($sprache_id)).")";
			include_once("./mietobjektAnlegen.php");	
			exit;		
		}		
		
		if ($standardsprache == $sprache_id){
			$defaultBezeichnung = $bezeichnung;
		}
		
		if ($standardsprache ==  $sprache_id){
			$defaultBeschreibung = $beschreibung;
		}
		
		//assoziatives array aufbauen mit sprache als schluessel
		if ($beschreibung != false){
			$uebers_bes[$sprache_id]=$beschreibung;
		}
		if ($bezeichnung != false){
			$uebers_bez[$sprache_id]=$bezeichnung;
		}		
		
    }
    
	//uebersetzungen durchfuehren:
	foreach ($uebers_bez as $sprache_id => $bezeichnung){
		setUebersetzungVermieter($bezeichnung,$defaultBezeichnung,$sprache_id,$standardsprache,$vermieter_id);
	}
	foreach ($uebers_bes as $sprache_id => $beschreibung){
		setUebersetzungVermieter($beschreibung,$defaultBeschreibung,$sprache_id,$standardsprache,$vermieter_id);
	}

	//mietobjekt speichern:
	setMietobjekt($vermieter_id,$defaultBezeichnung,$defaultBeschreibung,$preis,$linkName);
	
	$anzahlMietobjekte = getAnzahlMietobjekteOfVermieter($vermieter_id);
	$anzahlVorhandenerMietobjekte = getAnzahlVorhandeneMietobjekte($vermieter_id);
	
	include_once($root."/webinterface/templates/bodyStart.inc.php"); 
	
	?>
	<table border="0" cellpadding="0" cellspacing="0" class="<?php echo FREI ?>">
	  <tr>
		<td><?php echo(getUebersetzung("Das Mietobjekt wurde erfolgreich hinzugefügt.")); ?></td>
	  </tr>
	</table>	
	<br/>
	<br/>
	
	<?php
	if ( $anzahlVorhandenerMietobjekte < $anzahlMietobjekte ){
	?>
		<table border="0" cellpadding="0" cellspacing="0" class="<?php echo TABLE_STANDARD ?>">
		  <tr> 
			<td><form action="./mietobjektAnlegen.php" method="post" name="anlegen" target="_self" id="anlegen">		
				<input name="retour" type="submit" class="<?php echo BUTTON ?>" id="retour" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
			 		onMouseOut="this.className='<?php echo BUTTON ?>';" value="<?php echo(getUebersetzung("ein weiteres Mietobjekt anlegen")); ?>">
			  </form></td>
		  </tr>
		</table>
		<br/>
	<?php
	}
	?>
		
<table border="0" cellpadding="0" cellspacing="0" class="<?php echo TABLE_STANDARD ?>">
  <tr> 
    <td><form action="./index.php" method="post" name="zurueck" target="_self" id="zurueck">
        <input name="retour2" type="submit" class="<?php echo BUTTON ?>" id="retour2" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
	 onMouseOut="this.className='<?php echo BUTTON ?>';" value="<?php echo(getUebersetzung("zurück")); ?>">
      </form></td>
  </tr>
</table>
<?php
include_once($root."/webinterface/templates/footer.inc.php");
?>
