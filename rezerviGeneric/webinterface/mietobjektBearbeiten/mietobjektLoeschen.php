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
	$nachricht = getUebersetzung("Es wurde kein Mietobjekt zum L�schen ausgew�hlt.");
	include_once("./index.php");	
	exit;	
}
if (DEMO == true){
	//im demo modus darf nicht das letzte mo gel�scht werden:
	$anzahl = getAnzahlVorhandeneMietobjekte($vermieter_id);
	if ($anzahl <= 1){
		$fehler = true;
		$nachricht = getUebersetzung("Im Demo-Modus kann das letzte Mietobjekt nicht gel�scht werden.");
		include_once("./index.php");	
		exit;	
	}
}
include_once($root."/webinterface/templates/bodyStart.inc.php"); 
?>	
<p class="<?= STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("L�schung durchf�hren")); ?></p>
<form action="./zimmerLoeschen.php" method="post" name="zimmerLoeschen" target="_self" id="zimmerLoeschen">	
<table border="0" cellpadding="0" cellspacing="3" class="<?= FREI ?>">
  <tr>
    <td>
	<?php 		
	 	for($i = 0; $i < $anzahl; $i++){
			deleteMietobjekt($mietobjekt_id[$i]);
		} //ende for
	?>
	<?php 
		if ($anzahl > 1){
			echo(getUebersetzung("Die Mietobjekte wurden samt seinen Reservierungen aus der Datenbank gel�scht")); 
		}	
		else{
			echo(getUebersetzung("Das Mietobjekt wurde samt seinen Reservierungen aus der Datenbank gel�scht")); 
		}		
	?>!
      </td>
  </tr>
</table>
</form>
<br/>
<table border="0" cellpadding="0" cellspacing="0" class="<?= TABLE_STANDARD ?>">
  <tr> 
    <td>
    	<form action="./index.php" method="post" name="retour" target="_self" id="retour">
	        <input name="retour2" type="submit" class="<?= BUTTON ?>" id="retour2" 
	        	onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
		 		onMouseOut="this.className='<?= BUTTON ?>';" 
		 		value="<?php echo(getUebersetzung("zur�ck")); ?>">
        </form>
    </td>
  </tr>
</table>
<?php
include_once($root."/webinterface/templates/footer.inc.php");
?>