<? $root = "../../..";

/*   
	date: 26.9.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");
include_once($root."/webinterface/templates/bodyStart.inc.php"); 
include_once($root."/webinterface/templates/components.inc.php"); 

?>
<p class="<?= STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("Einstellungen für Bilder der Mietobjekte")); ?>.</p>

<table  border="0" cellpadding="0" cellspacing="3" class="<?= TABLE_STANDARD ?>">
  <form action="./bilderAendern.php" method="post" target="_self">
  <?php
  
  	if (!(isset($fehler) && $fehler == true)){
  		$belegungsplanActive = getVermieterEigenschaftenWert(BELEGUNGSPLAN_BILDER_ACTIV,$vermieter_id);
  		if ($belegungsplanActive != "true"){
  			$belegungsplanActive = false;
  		}
  		else{
  			$belegungsplanActive = true;
  		}
  		$suchergebnisseActive = getVermieterEigenschaftenWert(SUCHERGEBNISSE_BILDER_ACTIV,$vermieter_id);
  		if ($suchergebnisseActive != "true"){
  			$suchergebnisseActive = false;
  		}
  		else{
  			$suchergebnisseActive = true;
  		}
        $width  = getVermieterEigenschaftenWert(BILDER_WIDTH,$vermieter_id);
        $height = getVermieterEigenschaftenWert(BILDER_HEIGHT,$vermieter_id);
  	}
  	
    ?> 
  <!-- 
  <tr>
    <td colspan="2"><input name="suchergebnisseActive" type="checkbox" id="active" value="true" 
    <?php if ($suchergebnisseActive) echo("checked=\"checked\""); ?>>
    <?php echo(getUebersetzung("Bilder bei Suchergebnissen anzeigen")); ?></td>
  </tr>
  <tr>
    <td colspan="2"><input name="belegungsplanActive" type="checkbox" id="active" value="true" 
    <?php if ($belegungsplanActive) echo("checked=\"checked\""); ?>>
    <?php echo(getUebersetzung("Bilder im Belegungsplan anzeigen")); ?></td>
  </tr>
  -->
  <tr>
    <td><?php echo(getUebersetzung("Maximale Höhe bei upload")); ?>
    </td>
    <td>  
      <input name="width" type="text" id="width" value="<?php echo($width); ?>" size="5" maxlength="5"/>&nbsp;<?php echo(getUebersetzung("Pixel")); ?>
    </td>
  </tr>
  <tr>
    <td><?php echo(getUebersetzung("Maximale Breite bei upload")); ?>
    </td>
    <td>
      <input name="height" type="text" id="height" value="<?php echo($height); ?>" size="5" maxlength="5"/>&nbsp;<?php echo(getUebersetzung("Pixel")); ?>
     </td>
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