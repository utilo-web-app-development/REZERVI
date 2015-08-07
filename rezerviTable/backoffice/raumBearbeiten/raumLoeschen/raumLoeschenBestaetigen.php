<?  
$root = "../../.."; 
$ueberschrift = "Raum bearbeiten";
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
if (isset($_POST["raum_id"])){
	$raum_id = $_POST["raum_id"];
	$anzahl = count($raum_id);
}
if ($anzahl < 1){
	$fehler = true;
	$nachricht = getUebersetzung("Bitte w�hlen sie mindestens einen Raum aus!");
	include_once("./index.php");	
	exit;	
}
include_once($root."/backoffice/templates/breadcrumps.inc.php");
$breadcrumps = erzeugenBC($root, "Raum", "raumBearbeiten/index.php",
								$unterschrift, "raumBearbeiten/raumLoeschen/index.php",
								$unterschrift1, "");
include_once($root."/backoffice/templates/bodyStart.inc.php"); 
?>

<h2><?php echo(getUebersetzung("Löschung bestätigen")); ?></h2>
<form action="./raumLoeschen.php" method="post" name="raumLoeschen" target="_self" 
	id="raumLoeschen">	
<table>
  <tr> 
      <td colspan="2"><?php echo(getUebersetzung("Folgende Räume werden aus der Datenbank entfernt")); ?>.<br/>
        <?php echo(getUebersetzung("Bitte beachten Sie, dass damit auch alle Tische und Reservierungen die diese(s) Räume betreffen ebenfalls entfernt werden")); ?>!</td>
    </tr>
    <tr>
		<td colspan="2"><?php 
			$anzahl = count($raum_id);				
	  		for($i = 0; $i < $anzahl; $i++){ 
	  			$temp = $raum_id[$i];
	  		?> 
  				<input type="checkbox" name="raum_id[]" value="<?php echo($raum_id[$i]); ?>" checked="checked">
           		<?= getUebersetzungGastro(getRaumBezeichnung($temp),$sprache,$gastro_id) ?>
           		<br/>       
               <?php 
			} //ende for
			 ?>  
			 <?php echo(getUebersetzung("Nur die hier selektierten Räume werden gelöscht.")); ?> 	
      		<br/>	         
       		<input name="weiter" type="submit" class="button" id="weiter" value="<?php echo(getUebersetzung("weiter")); ?>">        		
		</td>  
	</form>
	    <td><form action="./index.php" method="post" name="zurueck" target="_self" id="zurueck">
        	<input name="retour2" type="submit" class="button" id="retour2" value="<?php echo(getUebersetzung("abbrechen")); ?>">
      	</form></td>
          
    </tr>
</table>
<?php
include_once($root."/backoffice/templates/footer.inc.php");
?>
