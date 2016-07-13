<?php $root = "../../..";

/*   
	date: 26.9.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");
include_once($root."/webinterface/templates/bodyStart.inc.php"); 
include_once($root."/webinterface/templates/components.inc.php"); 

$sucheAktiv = getVermieterEigenschaftenWert(SUCHFUNKTION_AKTIV,$vermieter_id);
if ($sucheAktiv == "true"){
	$sucheAktiv = true;
}
else{
	$sucheAktiv = false;
}

?>
<p class="<?php echo STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("Einstellungen zur Suche nach Mietobjekten")); ?>.</p>
<table  border="0" cellpadding="0" cellspacing="3" class="<?php echo TABLE_STANDARD ?>">
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
	  showSubmitButton(getUebersetzung("ändern"));
	 ?>
	</td>
  </tr>
  </form>
</table>
<br/>
<?php 
//-----buttons um zurück zum menue zu gelangen: 
showSubmitButtonWithForm("../index.php",getUebersetzung("zurück"));
include_once($root."/webinterface/templates/footer.inc.php");
?>