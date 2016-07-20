<?php $root = "../..";

/*   
	date: 19.9.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");
	
//andere funktionen importieren:
include_once($root."/include/benutzerFunctions.inc.php");
include_once($root."/include/vermieterFunctions.inc.php");
	
	//initialisieren der variablen:	
	//nur wenn seite neu aufgerufen wurde:
	if (!isset($fehler) || $fehler == false){
		$strasse = 	getVermieterStrasse($vermieter_id);
		$plz = 		getVermieterPlz($vermieter_id);
		$ort = 		getVermieterOrt($vermieter_id);	
		$email = 	getVermieterEmail($vermieter_id);
		$tel = 		getVermieterTel($vermieter_id);
		$tel2 = 	getVermieterTel2($vermieter_id);
		$fax = 		getVermieterFax($vermieter_id);		
		$vorname =  getVermieterVorname($vermieter_id);
		$nachname=  getVermieterNachname($vermieter_id);
		$url =		getVermieterUrl($vermieter_id);		
		$firmenname    = getVermieterFirmenname($vermieter_id);		
		$land    = getVermieterLand($vermieter_id);		
		$mietobjekt_ez 	  = getMietobjekt_EZ($vermieter_id);		
		$mietobjekt_mz    = getMietobjekt_MZ($vermieter_id);		
		$standardsprache = getVermieterEigenschaftenWert(STANDARDSPRACHE,$vermieter_id);
		
	} //ende if kein fehler
	else{
		$mietobjekt_ez 	  = $defaultMoEz;		
		$mietobjekt_mz    = $defaultMoMz;
		$firmenname	      = $defaultFirma;
	}
	
	if (empty($standardsprache)){
		setVermieterEigenschaftenWert(STANDARDSPRACHE,"en",$vermieter_id);
		$standardsprache = "en";
	}
			
?>

<?php include_once($root."/webinterface/templates/bodyStart.inc.php"); ?>

<form name="form" method="post" action="./aendern.php">
<table border="0" cellpadding="3" cellspacing="0" class="<?php echo TABLE_STANDARD ?>">
	<tr>
		<td colspan="2"><p class="<?php echo STANDARD_SCHRIFT_BOLD ?>">
	      <?php echo(getUebersetzung("Bitte füllen Sie die untenstehenden Felder aus.")); ?> 
		  <?php echo(getUebersetzung("Die mit [*] gekennzeichneten Felder müssen ausgefüllt werden")); ?>!
		</p>
		</td>
	</tr>
	<?php
    $res = getActivtedSprachenOfVermieter($vermieter_id);
    while ($d = mysqli_fetch_array($res)){
    	$sprache_id = $d["SPRACHE_ID"];
    	$bezeichnung= $d["BEZEICHNUNG"];
    	$firma= getUebersetzungVermieter($firmenname,$sprache_id,$vermieter_id); 
    ?>
    <tr>
	    <td><?php echo(getUebersetzung("Firmenname - Seitenüberschrift")); ?> 
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
    <td><?php echo(getUebersetzung("Straße/Hausnummer")); ?></td>
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
  	<?php
    $res = getActivtedSprachenOfVermieter($vermieter_id);
    while ($d = mysqli_fetch_array($res)){
    	$sprache_id = $d["SPRACHE_ID"];
    	$bezeichnung= $d["BEZEICHNUNG"];
    	$mo= getUebersetzungVermieter($mietobjekt_ez,$sprache_id,$vermieter_id); 
    ?>
    <tr>
	    <td><?php echo(getUebersetzung("Bezeichnung der Mietobjekte Einzahl (z. B. Tennisplatz) ")); ?> 
	        (<?php echo(getUebersetzung($bezeichnung)); ?>)<br/>	       
	        <?php if ($standardsprache != $sprache_id){ ?>
	        (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.")); ?>)
	        <?php
	      	 }
	        ?>
	    </td>
	    <td nowrap="nowrap">
	      <input name="mietobjekt_ez_<?php echo $sprache_id ?>" type="text" value="<?php echo($mo) ?>" size="50">
	      <?php if ($standardsprache == $sprache_id){ ?>
	      	*
	      <?php } ?>
	    </td>
  </tr>
  <?php
    } //ende while sprachen
  ?>
  	<?php
    $res = getActivtedSprachenOfVermieter($vermieter_id);
    while ($d = mysqli_fetch_array($res)){
    	$sprache_id = $d["SPRACHE_ID"];
    	$bezeichnung= $d["BEZEICHNUNG"];
    	$mo= getUebersetzungVermieter($mietobjekt_mz,$sprache_id,$vermieter_id); 
    ?>
    <tr>
	    <td><?php echo(getUebersetzung("Bezeichnung der Mietobjekte Mehrzahl (z. B. Tennisplätze) ")); ?> 
	        (<?php echo(getUebersetzung($bezeichnung)); ?>)<br/>	       
	        <?php if ($standardsprache != $sprache_id){ ?>
	        (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.")); ?>)
	        <?php
	      	 }
	        ?>
	    </td>
	    <td nowrap="nowrap">
	      <input name="mietobjekt_mz_<?php echo $sprache_id ?>" type="text" value="<?php echo($mo) ?>" size="50">
	      <?php if ($standardsprache == $sprache_id){ ?>
	      	*
	      <?php } ?>
	    </td>
  </tr>
  <?php
    } //ende while sprachen
  ?>
   <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="submit" name="Submit" class="<?php echo BUTTON ?>" id="retour" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
	 onMouseOut="this.className='<?php echo BUTTON ?>';" value="<?php echo(getUebersetzung("ändern")); ?>"></td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
<?php
include_once($root."/webinterface/templates/footer.inc.php");
?>