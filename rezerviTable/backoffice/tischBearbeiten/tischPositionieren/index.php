<?php
$root = "../../.."; 
$ueberschrift = "Tisch bearbeiten";
$unterschrift = "Positionieren";

/*
 * Created on 06.12.2007
 * Author: LI Haitao
 * Company: Alpstein-Austria  
 */

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/backoffice/templates/breadcrumps.inc.php");
$breadcrumps = erzeugenBC($root, "Tisch", "tischBearbeiten/index.php",
								$unterschrift, "tischBearbeiten/tischPositionieren/index.php");
include_once($root."/backoffice/templates/bodyStart.inc.php");
include_once($root."/include/mietobjektFunctions.inc.php");
include_once($root."/include/vermieterFunctions.inc.php");
include_once($root."/include/bildFunctions.inc.php"); 
?>
<script type="text/javascript">
<?php 
$res = getRaeume($gastro_id); 
$size = count($res);
?>

function fensterOeffnen (Adresse) {
	
  <?php //speichere die groesse der bilder eines raumes in einem array:
   $i = 0;
   while($d = $res->FetchNextObject()) {
   	$raum_id = $d->RAUM_ID;
   	$bilder_id  = getBildOfRaum($raum_id); 
   	$breite = getBildBreite($bilder_id);
   	$hoehe  = getBildHoehe($bilder_id);
   	?>raeume[<?= $i ?>][0]=<?= $raum_id ?>;
   	  raeume[<?= $i ?>][1]=<?= $breite ?>;
   	  raeume[<?= $i ?>][2]=<?= $hoehe ?>;
   	<?php $i++;
   }
  ?>
  var raum = document.position.raum_id.value;
  var breite = <?= getGastroProperty(MAX_BILDBREITE_RAUM,$gastro_id) ?>;
  var hoehe  = <?= getGastroProperty(MAX_BILDHOEHE_RAUM,$gastro_id) ?>;
  for (var i =0; i<raeume.length; i++){
  	if (raeume[i][0] == raum){
  		breite = raeume[i][1];
  		hoehe  = raeume[i][2];
  		break;
  	}
  }
  Adresse = Adresse+"?raum_id="+raum;
  TischPos = window.open(Adresse, "Tisch positionieren", "width=breite,height='hoehe',scrollbars=yes");
  TischPos.focus();
}
</script> 
<?php
$anzahlVorhandMietobjekte = getAnzahlVorhandeneTische($gastro_id);
if ($anzahlVorhandMietobjekte > 0){
	//tisch positionieren:
	?>
	<form action="./position.php" method="post" name="position" target="_self">
	  <table>
	    <h2><?php echo(getUebersetzung("Tisch positionieren")); ?></h2>
	    <tr>
	      <td>
	      	<span>
	      		<?php echo(getUebersetzung("Bitte wählen sie einen Raum aus in dem sie den Tisch " .
	      				"positionieren wollen. Sie können anschließend die Tische per Drag and Drop an " .
	      				"die richtige Position im Raum bewegen.")); ?>
	      	</span>
	      	<br/>
	      </td>
	    </tr>	    
	    <tr>
	    	<td><?= getUebersetzung("Raum") ?>:&nbsp;
		      	<select name="raum_id" id="raum_id">
		          <?php	
		          	 //es muss ein raum zum tisch ausgewählt werden:
				 	 $res = getRaeume($gastro_id);
				 	 $first = true;
					  while($d = $res->FetchNextObject()) {
					  	$curr_raum_id = $d->RAUM_ID;
					  	//check if the room already has tables:
						if (countTables($curr_raum_id) < 1){
							continue;
						}
						$ziArt = getUebersetzungGastro($d->BEZEICHNUNG,$sprache,$gastro_id);
						?>
						<option value="<?= $curr_raum_id ?>" <?
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
	      <td>
	      	<input name="zimmerAnlegenButton" type="submit" 
	      		id="zimmerAnlegenButton" class="button" 
	       		<? /*
	       		onClick="fensterOeffnen('<?= $root ?>/backoffice/tischBearbeiten/position.php'); return false"
	        	*/
	        	?>
	        	value="<?php echo(getUebersetzung("Positionieren")); ?>">
	      </td>
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