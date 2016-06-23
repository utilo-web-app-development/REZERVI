<? $root = "../..";

/*   
	date: 23.9.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");


//andere funktionen importieren:
include_once($root."/include/mietobjektFunctions.inc.php");

$anzahl = 0;
if (isset($_POST["mietobjekt_id"])){
	$mietobjekt_id = $_POST["mietobjekt_id"];
	$anzahl = count($mietobjekt_id);
}
if ($anzahl < 1){
	$fehler = true;
	$nachricht = getUebersetzung("Bitte wählen sie mindestens ein Mietobjekt aus!");
	include_once("./index.php");	
	exit;	
}
include_once($root."/webinterface/templates/bodyStart.inc.php"); 
?>
<p class="<?= STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("Löschung bestätigen")); ?></p>
<form action="./mietobjektLoeschen.php" method="post" name="mietobjektLoeschen" target="_self" id="mietobjektLoeschen">	
<table border="0" cellpadding="0" cellspacing="3" class="<?= TABLE_STANDARD ?>">
  <tr>
    <td><p><?php echo(getUebersetzung("Folgende Mietobjekte werden aus der Datenbank entfernt")); ?>.<br/>
        <?php echo(getUebersetzung("Bitte beachten Sie, dass damit auch alle Reservierungen die diese(s) Mietobjekte betreffen ebenfalls entfernt werden")); ?>!</p>
        <p>
            <?php 
				$anzahl = count($mietobjekt_id);				
	  			for($i = 0; $i < $anzahl; $i++){ 
	  				$temp = $mietobjekt_id[$i];
	  			?> 
  					<input type="checkbox" name="mietobjekt_id[]" value="<?php echo($mietobjekt_id[$i]); ?>" checked="checked">
           			<?= getUebersetzungVermieter(getMietobjektBezeichnung($temp),$sprache,$vermieter_id) ?><br/>       
                <?php 
				} //ende for
			    ?>  
	  </p>
       <?php echo(getUebersetzung("Nur die hier selektierten Mietobjekte werden gelöscht.")); ?> 	
       <br/>	         
       <input name="weiter" type="submit" class="<?= BUTTON ?>" id="weiter" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
       onMouseOut="this.className='<?= BUTTON ?>';" value="<?php echo(getUebersetzung("weiter")); ?>">        		
    </td>
  </tr>
</table>
</form>
<br/>
<table border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td><form action="./index.php" method="post" name="zurueck" target="_self" id="zurueck">
        <input name="retour2" type="submit" class="<?= BUTTON ?>" id="retour2" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
	 onMouseOut="this.className='<?= BUTTON ?>';" value="<?php echo(getUebersetzung("abbrechen")); ?>">
      </form></td>
  </tr>
</table>
<?php
include_once($root."/webinterface/templates/footer.inc.php");
?>
