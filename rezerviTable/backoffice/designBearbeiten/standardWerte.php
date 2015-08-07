<? 
$root = "../..";
$ueberschrift = "Design bearbeiten";
$unterschrift = "Zurücksetzen";

/*
 date: 26.9.05
 author: christian osterrieder alpstein-austria
 */

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");

if(isset($_POST["weiter"])){
	//setzte die standardwert:
	setStandardCSS($gastro_id);
	$info = true;
	$nachricht = "Das Design wurde erfolgreich auf die Standardwerte zurückgesetzt!";
}

include_once($root."/backoffice/templates/breadcrumps.inc.php");	
$breadcrumps = erzeugenBC($root, "Design", "designBearbeiten/index.php",
							"Auf Standardwerte zurücksetzen", "designBearbeiten/standardWerte.php");		
include_once($root."/backoffice/templates/bodyStart.inc.php");
include_once($root."/include/cssFunctions.inc.php");

?>
<h2><?php echo(getUebersetzung($unterschrift)); ?></h2>
<p><?php echo(getUebersetzung("Bitte beachten Sie, dass Design auf Standardwerte zurückgesetzt wird und das eigene Design gleichzeitig entfernt wird.")); ?></p>
<table>
	<tr>
		<td>
		<form action="./standardWerte.php" method="post" name="standard" target="_self" id="raumLoeschen">	
			<input name="weiter" type="submit" class="button" id="weiter" value="<?php echo(getUebersetzung("weiter")); ?>">		
		</form>
		</td>
		<td>
		<form action="./index.php" method="post" name="zurueck" target="_self" id="zurueck">
      	 	<input name="retour2" type="submit" class="button" id="retour2" value="<?php echo(getUebersetzung("abbrechen")); ?>">
		</form>
		</td>
	</tr>
</table>
<?php
include_once($root."/backoffice/templates/footer.inc.php");
?>