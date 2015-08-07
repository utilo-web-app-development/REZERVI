<? 
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
include_once($root."/templates/constants.inc.php");

$standardansicht = getGastroProperty(STANDARDANSICHT,$gastro_id);
if ($standardansicht == false || $standardansicht == ""){
	$standardansicht = JAHRESUEBERSICHT;
}

?>

<p class="standardschrift"><?php echo(getUebersetzung("Ändern der angezeigten Ansichten")); ?>.</p>

<br/>
<table>
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
      	if ($ans == JAHRESUEBERSICHT && getGastroProperty(JAHRESUEBERSICHT_ANZEIGEN,$gastro_id) == "true"){
      		echo("checked=\"checked\"");
      	}
      	else if($ans == MONATSUEBERSICHT && getGastroProperty(MONATSUEBERSICHT_ANZEIGEN,$gastro_id) == "true"){
      		echo("checked=\"checked\"");
      	}
      	else if($ans == WOCHENANSICHT && getGastroProperty(WOCHENANSICHT_ANZEIGEN,$gastro_id) == "true"){
      		echo("checked=\"checked\"");
      	}
      	else if($ans == TAGESANSICHT && getGastroProperty(TAGESANSICHT_ANZEIGEN,$gastro_id) == "true"){
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