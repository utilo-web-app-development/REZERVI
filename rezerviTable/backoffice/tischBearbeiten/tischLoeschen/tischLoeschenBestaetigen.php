<? 
$root = "../../..";
$ueberschrift = "Tisch bearbeiten";
$unterschrift = "Löschen";
$unterschrift1 = "Bestätigen";

/*   
	date: 23.9.05
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");

//andere funktionen importieren:
include_once($root."/include/mietobjektFunctions.inc.php");

$anzahl = 0;
if (isset($_POST["tisch_id"])){
	$tisch_id = $_POST["tisch_id"];
	$anzahl = count($tisch_id);
}
if ($anzahl < 1){
	$fehler = true;
	$nachricht = getUebersetzung("Bitte wählen sie mindestens einen Tisch aus!");
	include_once("./index.php");	
	exit;	
}
include_once($root."/backoffice/templates/breadcrumps.inc.php");
$breadcrumps = erzeugenBC($root, "Tisch", "tischBearbeiten/index.php",
								$unterschrift, "tischBearbeiten/tischLoeschen/index.php",
								$unterschrift1, "");
include_once($root."/backoffice/templates/bodyStart.inc.php"); 
?>
<h2><?php echo(getUebersetzung("Löschung bestätigen")); ?></h2>
<form action="./tischLoeschen.php" method="post" name="tischLoeschen" target="_self" id="tischLoeschen">	
<table>
  <tr> 
      <td colspan="2"><?php echo(getUebersetzung("Folgende Tische werden aus der Datenbank entfernt")); ?>.<br/>
        <?php echo(getUebersetzung("Bitte beachten Sie, dass damit auch alle Reservierungen die diese(n) Tisch(e) betreffen ebenfalls entfernt werden")); ?>!</td>
    </tr>
    <tr>
      <td colspan="2">
		<?php 
			$anzahl = count($tisch_id);				
	  		for($i = 0; $i < $anzahl; $i++){ 
	  			$temp = $tisch_id[$i];
	  		?> 
  				<input type="checkbox" name="tisch_id[]" value="<?php echo($tisch_id[$i]); ?>" checked="checked">
          			<?= getUebersetzungGastro($temp,$sprache,$gastro_id) ?><br/>       
               <?php 
			} //ende for
		    ?>
		<?php echo(getUebersetzung("Nur die hier selektierten Tische werden gelöscht.")); ?> 	
       	</td>
	</tr>
</table>
<table>
	<tr>
		<td>         
			<input name="weiter" type="submit" class="button" id="weiter" value="<?php echo(getUebersetzung("weiter")); ?>"> 
			</form> 
		</td>       
    	<td><form action="./index.php" method="post" name="zurueck" target="_self" id="zurueck">
        	<input name="retour2" type="submit" class="button" id="retour2" value="<?php echo(getUebersetzung("abbrechen")); ?>">
      	</form></td>
  	</tr>
</table>
<?php
include_once($root."/backoffice/templates/footer.inc.php");
?>
