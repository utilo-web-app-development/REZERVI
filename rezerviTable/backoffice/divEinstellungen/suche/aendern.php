<?php 
$root = "../../..";
$ueberschrift = "Diverse Einstellungen";

/*   
	date: 15.4.06
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");

//variablen initialisieren:
$sucheAktiv = "false";
if (isset($_POST["sucheAktiv"])){
	$sucheAktiv = $_POST["sucheAktiv"];
}
if ($sucheAktiv != "true"){
	$sucheAktiv = "false";
}


include_once($root."/include/vermieterFunctions.inc.php");
	
setGastroProperty(SUCHFUNKTION_AKTIV,$sucheAktiv,$gastro_id);

include_once($root."/backoffice/templates/bodyStart.inc.php"); 
include_once($root."/backoffice/templates/components.inc.php"); 

?>
	<table  border="0" cellpadding="0" cellspacing="3" class="<?php echo FREI ?>">
	  <tr>
		<td><?php 	$temp = "Die Einstellungen zur Suchfunktion wurden erfolgreich geändert.";
					$temp = getUebersetzung($temp);
					echo($temp); ?>
		</td>
	  </tr>
	</table>
	<br/>
<?php 
	  //-----buttons um zurück zum menue zu gelangen: 
	  showSubmitButtonWithForm("../index.php",getUebersetzung("zurück"));
	  
include_once($root."/backoffice/templates/footer.inc.php");
?>