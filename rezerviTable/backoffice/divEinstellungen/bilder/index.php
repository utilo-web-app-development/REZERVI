<? 
$root = "../../..";
$ueberschrift = "Diverse Einstellungen";
$unterschrift = "Bilder";

/*   
	date: 26.9.05
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/backoffice/templates/breadcrumps.inc.php");
$breadcrumps = erzeugenBC($root, $ueberschrift, "divEinstellungen/index.php",
							$unterschrift, "divEinstellungen/bilder/index.php");
include_once($root."/backoffice/templates/bodyStart.inc.php"); 
include_once($root."/backoffice/templates/components.inc.php"); 

?>
<h2><?php echo(getUebersetzung("Einstellungen für Bilder der Räume")); ?>.</h2>

<table>
  <form action="./bilderAendern.php" method="post" target="_self">
  <?php
  
  	if (!(isset($fehler) && $fehler == true)){
  		$belegungsplanActive = getGastroProperty(BELEGUNGSPLAN_BILDER_ACTIV,$gastro_id);
  		if ($belegungsplanActive != "true"){
  			$belegungsplanActive = false;
  		}
  		else{
  			$belegungsplanActive = true;
  		}
  		$suchergebnisseActive = getGastroProperty(SUCHERGEBNISSE_BILDER_ACTIV,$gastro_id);
  		if ($suchergebnisseActive != "true"){
  			$suchergebnisseActive = false;
  		}
  		else{
  			$suchergebnisseActive = true;
  		}
        $width  = getGastroProperty(MAX_BILDBREITE_RAUM,$gastro_id);
        $height = getGastroProperty(MAX_BILDHOEHE_RAUM,$gastro_id);
  	}
  	
    ?> 

  <tr>
    <td><?php echo(getUebersetzung("Maximale Höhe Ihrer Raumbilder")); ?>
    </td>
    <td>  
      <input name="width" type="text" id="width" value="<?php echo($width); ?>" size="5" maxlength="5"/>&nbsp;<?php echo(getUebersetzung("Pixel")); ?>
    </td>
  </tr>
  <tr>
    <td><?php echo(getUebersetzung("Maximale Breite Ihrer Raumbilder")); ?>
    </td>
    <td>
      <input name="height" type="text" id="height" value="<?php echo($height); ?>" size="5" maxlength="5"/>&nbsp;<?php echo(getUebersetzung("Pixel")); ?>
     </td>
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
<?php 
include_once($root."/backoffice/templates/footer.inc.php");
?>