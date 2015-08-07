<?php
$root = "../../.."; 
$ueberschrift = "Tisch bearbeiten";
$unterschrift = "Anlegen";

/*
 * Created on 06.12.2007
 * Author: LI Haitao
 * Company: Alpstein-Austria  
 */

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/backoffice/templates/breadcrumps.inc.php");
$breadcrumps = erzeugenBC($root, "Tisch", "tischBearbeiten/index.php",
								$unterschrift, "tischBearbeiten/tischAnlegen/index.php");
include_once($root."/backoffice/templates/bodyStart.inc.php"); 
?>
<form action="./tischAnlegen.php" method="post" name="tischAnlegen" target="_self">
	<table>
		<h2><?php echo(getUebersetzung("Tisch anlegen")); ?>  	</h2>
	    <tr>
	    	<td><?= getUebersetzung("Raum") ?>:&nbsp;
		      	<select name="raum_id" id="raum_id">
		          <?php	
		          	 //es muss ein raum zum tisch ausgewählt werden:
				 	 $res = getRaeume($gastro_id);
				 	 $first = true;
					  while($d = $res->FetchNextObject()) {
						$ziArt = getUebersetzungGastro($d->BEZEICHNUNG,$sprache,$gastro_id);		?>
						<option value="<?= $d->RAUM_ID ?>" <?
							if($first){	?>
								selected="selected"	<?php
								$first = false;
							}
							?>
							><?= $ziArt ?></option>	<?php
					  } //ende while
					 ?>
		           </select>
	    	</td>
	    </tr>
	    <tr>
	      <td><input name="zimmerAnlegenButton" type="submit" id="zimmerAnlegenButton" 
	      	class="button" value="<?php echo(getUebersetzung("Anlegen")); ?>"></td>
	    </tr>	       
	</table>
</form>
<?php
include_once($root."/backoffice/templates/footer.inc.php");
?>
