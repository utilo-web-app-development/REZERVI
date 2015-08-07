<?  
$root = "../../.."; 
$ueberschrift = "Raum bearbeiten";
$unterschrift = "Löschen";

/*
 * Created on 05.12.2007
 * Author: LI Haitao
 * Company: Alpstein-Austria  
 */

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/backoffice/templates/breadcrumps.inc.php");
$breadcrumps = erzeugenBC($root, "Raum", "raumBearbeiten/index.php",
							$unterschrift, "raumBearbeiten/raumLoeschen/index.php");
include_once($root."/backoffice/templates/bodyStart.inc.php"); 

//andere funktionen importieren:
include_once($root."/include/mietobjektFunctions.inc.php");
include_once($root."/include/bildFunctions.inc.php");

$anzahlVorhandMietobjekte = getAnzahlVorhandeneRaeume($gastro_id);
if ($anzahlVorhandMietobjekte > 0){
?>
<h2><?php echo(getUebersetzung("Raum löschen")); ?></h2>
<form action="./raumLoeschenBestaetigen.php" method="post" name="raumLoeschenBestaetigen" target="_self">
  <table>    
    <tr>
      <td><?php echo(getUebersetzung("Bitte wählen Sie die zu löschenden Räume aus")); ?>. 
          <?php echo(getUebersetzung("Sie können mehrere Räume zugleich auswählen und löschen indem Sie die [STRG]-Taste gedrückt halten und auf die Bezeichnung klicken")); ?>.</td>      
    </tr>
    <tr>
      <td>      	
      	  <select name="raum_id[]" size="5" id="raum_id" multiple="multiple">
          <?php	
		 	 $res = getRaeume($gastro_id);
		 	 $first = true;
			  while($d = $res->FetchNextObject()) {
				$ziArt = getUebersetzungGastro($d->BEZEICHNUNG,$sprache,$gastro_id);
				?>
				<option value="<?= $d->RAUM_ID ?>" <?
					if($first){
						?>
						selected="selected"
						<?php
						$first = false;
					}
					?>
					><?= $ziArt ?></option>
				<?php
			  } //ende while
			 ?>
           </select>
      </td>
    </tr>
    <tr>
      <td><input name="Submit2" type="submit" id="Submit2" class="button" value="<?php echo(getUebersetzung("löschen")); ?>"></td>
    </tr>
  </table>
</form>
<?php
}else{
	$fehler = true;
	$nachricht = "Kein Raum ist vorhanden!";
	include_once($root."/backoffice/raumBearbeiten/raumAnlegen/index.php");
}
include_once($root."/backoffice/templates/footer.inc.php");
?>
