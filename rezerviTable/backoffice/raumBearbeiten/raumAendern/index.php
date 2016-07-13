<?php  
$root = "../../.."; 
$ueberschrift = "Raum bearbeiten";
$unterschrift = "Ändern";


/*
 * Created on 05.12.2007
 * Author: LI Haitao
 * Company: Alpstein-Austria  
 */

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/backoffice/templates/breadcrumps.inc.php");
$breadcrumps = erzeugenBC($root, "Raum", "raumBearbeiten/index.php",
								$unterschrift, "raumBearbeiten/raumAendern/index.php");
include_once($root."/backoffice/templates/bodyStart.inc.php"); 

//andere funktionen importieren:
include_once($root."/include/mietobjektFunctions.inc.php");
include_once($root."/include/bildFunctions.inc.php");

$anzahlVorhandMietobjekte = getAnzahlVorhandeneRaeume($gastro_id);
if ($anzahlVorhandMietobjekte > 0){
?>
<h2><?php echo(getUebersetzung("Raum ändern")); ?></h2>
<form action="./raumAendern.php" method="post" name="raumAendern" arget="_self">
  <table>
    <tr>
      <td><?php echo(getUebersetzung("Bitte wählen Sie den zu verändernden Raum aus")); ?>:</td>      
    </tr>
        <tr>
      <td>
      	<select name="raum_id" size="5" id="raum_id">
          <?php	
		 	 $res = getRaeume($gastro_id);
		 	 $first = true;
			  while($d = $res->FetchNextObject()) {
				$ziArt = getUebersetzungGastro($d->BEZEICHNUNG,$sprache,$gastro_id);
				?>
				<option value="<?php echo $d->RAUM_ID ?>" <?php
					if($first){
						?>
						selected="selected"
						<?php
						$first = false;
					}
					?>
					><?php echo $ziArt ?></option>
				<?php
			  } //ende while
			 ?>
           </select>
      </td>
    </tr>
    <tr>
      <td><input name="Submit" type="submit" id="Submit" class="button" value="<?php echo(getUebersetzung("ändern")); ?>"></td>
    </tr>
  </table>
</form>
<?php
	include_once($root."/backoffice/templates/footer.inc.php");
}else{
	$fehler = true;
	$nachricht = "Kein Raum ist vorhanden!";
	include_once($root."/backoffice/raumBearbeiten/raumAnlegen/index.php");
}
?>