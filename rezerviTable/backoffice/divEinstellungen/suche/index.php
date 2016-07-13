<?php 
$root = "../../..";
$ueberschrift = "Diverse Einstellungen";

/*   
	date: 26.9.05
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/backoffice/templates/bodyStart.inc.php"); 
include_once($root."/backoffice/templates/components.inc.php"); 

$sucheAktiv = getGastroProperty(SUCHFUNKTION_AKTIV,$gastro_id);
if ($sucheAktiv == "true"){
	$sucheAktiv = true;
}
else{
	$sucheAktiv = false;
}

?>
<p class="standardschrift"><?php echo(getUebersetzung("Einstellungen zur Suche nach Mietobjekten")); ?>.</p>
<table>
  <form action="./aendern.php" method="post" target="_self">
  <tr>
  	<td>
  		<?php echo getUebersetzung("Suchfunktion aktivieren") ?>
  	<td>
  	<td>
  		<input type="checkbox" value="true" <?php if ($sucheAktiv) { 
  				echo("checked=\"checked\""); 
  				} ?> name="sucheAktiv" />
  	<td>
  </tr>
   <tr>
    <td colspan="2">
 	 <?php 
	  showSubmitButton(getUebersetzung("Ändern"));
	 ?>
	</td>
  </tr>
  </form>
</table>
<br/>
<?php 
//-----buttons um zurück zum menue zu gelangen: 
showSubmitButtonWithForm("../index.php",getUebersetzung("zurück"));
include_once($root."/backoffice/templates/footer.inc.php");
?>