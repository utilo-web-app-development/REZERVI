<?php
$root = "../../.."; 
$ueberschrift = "Tisch bearbeiten";
$unterschrift = "Löschen";

/*
 * Created on 06.12.2007
 * Author: LI Haitao
 * Company: Alpstein-Austria  
 */

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/backoffice/templates/breadcrumps.inc.php");
$breadcrumps = erzeugenBC($root, "Tisch", "tischBearbeiten/index.php",
								$unterschrift, "tischBearbeiten/tischLoeschen/index.php");
include_once($root."/backoffice/templates/bodyStart.inc.php"); 

$anzahlVorhandTische = getAnzahlVorhandeneTische($gastro_id);
if ($anzahlVorhandTische > 0){
?>

<form action="./tischLoeschenBestaetigen.php" method="post" name="tischLoeschenBestaetigen" target="_self">
  <table>
    <h2><?php echo(getUebersetzung("Tisch löschen")); ?></h2>
    <tr>
      <td colspan="2"><?php echo(getUebersetzung("Bitte wählen Sie die zu löschenden Tische aus")); ?>. 
          <?php echo(getUebersetzung("Sie können mehrere Tische zugleich auswählen und " .
          		"löschen indem Sie die [STRG]-Taste gedröt halten und auf die " .
          		"Bezeichnung klicken")); ?>.</td>      
    </tr>
    <tr>
      <td>      	
      	  <select name="tisch_id[]" size="10" id="tisch_id" multiple="multiple">
          <?php	
		 	 $res = getAllTische($gastro_id);
		 	 $first = true;
			  while($d = $res->FetchNextObject()) {
								$ziArt = getUebersetzungGastro($d->TISCHNUMMER,
									$sprache,$gastro_id);
				$raumId =getRaumOfTisch($d->TISCHNUMMER);
				$raum   =getRaumBezeichnung($raumId);
				$raum   =getUebersetzungGastro($raum,$sprache,$gastro_id);
				$temp = getUebersetzung("Raum").": ".$raum."/".getUebersetzung("Tisch").": ".$ziArt;
				?>
				<option value="<?php echo $d->TISCHNUMMER ?>" <?php
					if($first){
						?>
						selected="selected"
						<?php
						$first = false;
					}
					?>
					><?php echo $temp ?></option>
				<?php
			  } //ende while
			 ?>
           </select>
      </td>
    </tr>
    <tr>
      <td><input name="Submit2" type="submit" id="Submit2" class="button" value="<?php 
       	echo(getUebersetzung("Tisch löschen")); ?>"></td>
    </tr>    
  </table>
</form>
<?php	
	include_once($root."/backoffice/templates/footer.inc.php");
}else{
	$fehler = true;
	$nachricht = "Kein Tisch ist vorhanden!";
	include_once($root."/backoffice/tischBearbeiten/tischAnlegen/index.php");
}
?>
