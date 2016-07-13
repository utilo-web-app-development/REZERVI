<?php 
$root = "../..";
$ueberschrift = "Stammdaten bearbeiten";

/*   
	date: 19.9.05
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
	
//andere funktionen importieren:
include_once($root."/include/benutzerFunctions.inc.php");
include_once($root."/include/vermieterFunctions.inc.php");

	//initialisieren der variablen:	
	//nur wenn seite neu aufgerufen wurde:
	if (!isset($fehler) || $fehler == false){
	
		$strasse = 	getVermieterStrasse($gastro_id);
		$plz = 		getVermieterPlz($gastro_id);
		$ort = 		getVermieterOrt($gastro_id);	
		$email = 	getVermieterEmail($gastro_id);
		$tel = 		getVermieterTel($gastro_id);
		$tel2 = 	getVermieterTel2($gastro_id);
		$fax = 		getVermieterFax($gastro_id);		
		$vorname =  getVermieterVorname($gastro_id);
		$nachname=  getVermieterNachname($gastro_id);
		$url =		getVermieterUrl($gastro_id);		
		$firmenname = getGastroFirmenName($gastro_id);		
		$land    = getVermieterLand($gastro_id);			
		$standardsprache = getGastroProperty(STANDARDSPRACHE,$gastro_id);		
		
	} //ende if kein fehler
	
	if (empty($standardsprache)){
		setGastroProperty(STANDARDSPRACHE,"en",$gastro_id);
		$standardsprache = "en";
	}
			
?>

<?php 
include_once($root."/backoffice/templates/breadcrumps.inc.php");
$breadcrumps = erzeugenBC($root, "Stammdaten", "vermieter/index.php");
include_once($root."/backoffice/templates/bodyStart.inc.php");  ?>

<form name="form" method="post" action="./aendern.php">
<table>
	    <tr> 
      <td colspan="2"><?php echo(getUebersetzung("Bitte füllen Sie die untenstehenden Felder aus.")); ?> 
		  <?php echo(getUebersetzung("Die mit [*] gekennzeichneten Felder müssen ausgefüllt werden")); ?>!</td>
    </tr>
	<?php
    $res = getActivtedSprachenOfVermieter($gastro_id);
    while ($d = $res->FetchNextObject()){
    	$sprache_id = $d->SPRACHE_ID;
    	$bezeichnung= $d->BEZEICHNUNG;
    	if (isset($fehler) && $_POST["firma_".$sprache_id]){
    		$firmenname = $_POST["firma_".$sprache_id];
    	}
    	if (!isset($firmenname)){
    		$firmenname = "";
    	}
    	$firma= getUebersetzungGastro($firmenname,$sprache_id,$gastro_id); 
    ?>
    <tr>
	    <td><?php echo(getUebersetzung("Name ihres Gastronomiebetriebes - Seitenüberschrift")); ?> 
	        (<?php echo(getUebersetzung($bezeichnung)); ?>)<br/>	       
	        <?php if ($standardsprache != $sprache_id){ ?>
	        (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.")); ?>)
	        <?php
	      	 }
	        ?>
	    </td>
	    <td nowrap="nowrap">
	      <input name="firma_<?php echo $sprache_id ?>" type="text" value="<?php echo($firma) ?>" size="50">
	      <?php if ($standardsprache == $sprache_id){ ?>
	      	*
	      <?php } ?>
	    </td>
  </tr>
  <?php
    } //ende while sprachen
  ?>
  <tr>
    <td><?php echo(getUebersetzung("Vorname")); ?></td>
    <td><input name="vorname" type="text" id="strasse" value="<?php echo($vorname) ?>" size="50"></td>
  </tr>
  <tr>
    <td><?php echo(getUebersetzung("Nachname")); ?></td>
    <td><input name="nachname" type="text" id="strasse" value="<?php echo($nachname) ?>" size="50"></td>
  </tr>
  <tr>
    <td><?php echo(getUebersetzung("Stra&szlig;e/Hausnummer")); ?></td>
    <td><input name="strasse" type="text" id="strasse" value="<?php echo($strasse) ?>" size="50"></td>
  </tr>
  <tr>
    <td><?php echo(getUebersetzung("Ort")); ?></td>
    <td><input name="ort" type="text" id="ort" value="<?php echo($ort) ?>" size="50"></td>
  </tr>
  <tr>
    <td><?php echo(getUebersetzung("PLZ")); ?></td>
    <td><input name="plz" type="text" id="plz" value="<?php echo($plz) ?>" size="50"></td>
  </tr>
  <tr>
    <td><?php echo(getUebersetzung("Land")); ?></td>
    <td><input name="land" type="text" id="land" value="<?php echo($land) ?>" size="50"></td>
  </tr>
  <tr>
    <td><?php echo(getUebersetzung("E-Mail-Adresse")); ?>
    </td>
    <td nowrap="nowrap"><input name="email" type="text" id="email" value="<?php echo($email) ?>" size="50">*</td>
  </tr>
  <tr>
    <td><?php echo(getUebersetzung("Homepage")); ?>
    </td>
    <td><input name="url" type="text" id="url" value="<?php echo($url) ?>" size="50"></td>
  </tr>
  <tr>
    <td><?php echo(getUebersetzung("Telefonnummer")); ?></td>
    <td><input name="tel" type="text" id="tel" value="<?php echo($tel); ?>" size="50"></td>
  </tr>
  <tr>
    <td>2. <?php echo(getUebersetzung("Telefonnummer")); ?> </td>
    <td><input name="tel2" type="text" id="tel2" value="<?php echo($tel2); ?>" size="50"></td>
  </tr>
  <tr>
    <td><?php echo(getUebersetzung("Faxnummer")); ?> </td>
    <td><input name="fax" type="text" id="fax" value="<?php echo($fax); ?>" size="50"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="submit" name="Submit" class="button" id="retour" value="<?php echo(getUebersetzung("Ändern")); ?>"></td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
<?php
include_once($root."/backoffice/templates/footer.inc.php");
?>