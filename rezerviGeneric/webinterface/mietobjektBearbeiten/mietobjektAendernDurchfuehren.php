<? $root = "../..";

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
	$mietobjekt_id = $_POST["mietobjekt_id"];

	//uebersetzungen in array sammeln:
	$uebers_bez = array();
	$uebers_bes = array();
	
    $res = getActivtedSprachenOfVermieter($vermieter_id);
    
	$defaultBezeichnung = false;
	$defaultBeschreibung = false;
    		
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

		if (($standardsprache == $sprache_id) && empty($bezeichnung)){
			$fehler = true;
			$nachricht = getUebersetzung("Bitte geben sie die Bezeichnung ihrer Standardsprache ein!");
			$nachricht .= " (".getUebersetzung(getBezeichnungOfSpracheID($sprache_id)).")";
			include_once("./mietobjektAendern.php");	
			exit;		
		}
		
		if ($standardsprache == $sprache_id){
			$defaultBezeichnung = $bezeichnung;
		}

		if ($standardsprache == $sprache_id){
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

    
    include_once($root."/webinterface/templates/bodyStart.inc.php"); 
    
	//mietobjekt speichern:
	updateMietobjekt($mietobjekt_id,$defaultBezeichnung,$defaultBeschreibung,$preis,$linkName);
	
	?>
	<table border="0" cellpadding="0" cellspacing="0" class="<?= FREI ?>">
	  <tr>
		<td><?php echo(getUebersetzung("Das Mietobjekt wurde erfolgreich verändert.")); ?></td>
	  </tr>
	</table>	
	<br/>
		
<table border="0" cellpadding="0" cellspacing="0" class="<?= TABLE_STANDARD ?>">
  <tr> 
    <td><form action="./index.php" method="post" name="zurueck" target="_self" id="zurueck">
        <input name="retour2" type="submit" class="<?= BUTTON ?>" id="retour2" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
	 onMouseOut="this.className='<?= BUTTON ?>';" value="<?php echo(getUebersetzung("zurück")); ?>">
      </form></td>
  </tr>
</table>
<?php
include_once($root."/webinterface/templates/footer.inc.php");
?>
