<? $root = "../../..";

/*   
	date: 26.9.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");
include_once($root."/webinterface/templates/bodyStart.inc.php"); 			
include_once($root."/webinterface/templates/components.inc.php"); 		
include_once($root."/templates/constants.inc.php");

$standardansicht = getVermieterEigenschaftenWert(STANDARDANSICHT,$vermieter_id);
if ($standardansicht == false || $standardansicht == ""){
	$standardansicht = JAHRESUEBERSICHT;
}

?>

<p class="<?= STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("Ändern der angezeigten Ansichten")); ?>.</p>

<br/>
<table  border="0" cellpadding="0" cellspacing="3" class="<?= TABLE_STANDARD ?>">
  <form action="./standardAendern.php" method="post" target="_self">
  <tr>
    <td colspan="3"><?php echo(getUebersetzung("Wählen sie die Ansichten, die in ihrem Belegungsplan verfügbar sein sollen")); ?>:</td>
  </tr>
  <tr>
  	<th><div align="left">Ansicht</div></th>
  	<th><div align="left">anzeigen</div></th>
  	<th><div align="left">Standard</div></th>
  </tr>
  <?php
  	foreach ($ansicht_array as $ans){
  ?>
  <tr>
    <td><?php echo(getUebersetzung($ans)); ?></td>
    <td>
      <input name="<?php echo($ans."_anzeigen"); ?>" type="checkbox" value="true" 
      <?php
      	if ($ans == JAHRESUEBERSICHT && getVermieterEigenschaftenWert(JAHRESUEBERSICHT_ANZEIGEN,$vermieter_id) == "true"){
      		echo("checked=\"checked\"");
      	}
      	else if($ans == MONATSUEBERSICHT && getVermieterEigenschaftenWert(MONATSUEBERSICHT_ANZEIGEN,$vermieter_id) == "true"){
      		echo("checked=\"checked\"");
      	}
      	else if($ans == WOCHENANSICHT && getVermieterEigenschaftenWert(WOCHENANSICHT_ANZEIGEN,$vermieter_id) == "true"){
      		echo("checked=\"checked\"");
      	}
      	else if($ans == TAGESANSICHT && getVermieterEigenschaftenWert(TAGESANSICHT_ANZEIGEN,$vermieter_id) == "true"){
      		echo("checked=\"checked\"");
      	}
      ?>
      >
	</td>
	<td>
      <input type="radio" name="standard" value="<?php echo($ans); ?>"
      <?php
      	if ($standardansicht == $ans){
      		echo("checked=\"checked\"");
      	}
      ?>
      >
	</td>
  </tr>
  <?php
  	}
  ?>
  <tr>
    <td colspan="3"><br/>
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