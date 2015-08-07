<?  
$root = "../../.."; 
$ueberschrift = "Benutzerdaten bearbeiten";
$unterschrift = "Löschen";
$unterschrift1 = "Bestätigen";

/*   
	date: 22.9.05
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/include/benutzerFunctions.inc.php");
include_once($root."/backoffice/templates/breadcrumps.inc.php");
$breadcrumps = erzeugenBC($root, "Benutzerdaten", "benutzerBearbeiten/index.php",
								$unterschrift, "benutzerBearbeiten/benutzerLoeschen/index.php",
								$unterschrift1, "");
include_once($root."/backoffice/templates/bodyStart.inc.php"); 

$id = $_POST["id"];
?>
<h2><?php echo(getUebersetzung("Löschung Bestätigung")); ?></h2>
<form action="./benutzerLoeschen.php" method="post" name="benutzerLoeschen" target="_self" id="benutzerLoeschen">
  <table>
    <tr>
      <td><?php echo(getUebersetzung("Sind sie sicher, dass sie folgende Benutzer löschen wollen")); ?>?<br/>
          (<?php echo(getUebersetzung("Nur die hier selektierten Benutzer werden gelöscht")); ?>.)<br/>  
            <?php 
				$anzahl = count($id);				
	  			for($i = 0; $i < $anzahl; $i++){ ?> 
  					<input type="checkbox" name="id[]" value="<?php echo($id[$i]); ?>" checked="checked">
           			<?php echo(getUserName($id[$i])); ?><br/>       
            <?php 
				} //ende for
			?>         
		<input name="loeschen" type="submit" class="button" id="loeschen"
			 value="<?php echo(getUebersetzung("weiter")); ?>">
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
