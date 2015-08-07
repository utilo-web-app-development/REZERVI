<?  
$root = "../../.."; 
$ueberschrift = "Benutzerdaten bearbeiten";
$unterschrift = "Ändern";

/*
 * Created on 05.12.2007
 * Author: LI Haitao
 * Company: Alpstein-Austria  
 */

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/backoffice/templates/breadcrumps.inc.php");
$breadcrumps = erzeugenBC($root, "Benutzerdaten", "benutzerBearbeiten/index.php",
								$unterschrift, "benutzerBearbeiten/benutzerAendern/index.php");
include_once($root."/backoffice/templates/bodyStart.inc.php"); 

?>
<h2><?php echo(getUebersetzung("Benutzer ändern")); ?></h2>      
<form action="./benutzerAendern.php" method="post" name="benutzerAendern" target="_self">
  <table>
    <tr>
      <td><?php echo(getUebersetzung("Bitte wählen Sie den zu verändernden Benutzer aus")); ?>:</td>      
    </tr>
    <tr>
      <td>
      	<select name="id" size="5" id="id">
          <?php
		  $res = getBenutzer($gastro_id);
		  while($d = $res->FetchNextObject()) {?>
          	<option value="<?php echo($d->BENUTZER_ID); ?>" <?php if ($benutzer_id == $d->BENUTZER_ID) echo(" selected"); ?>> <?php echo($d->NAME); ?></option>
          <?php
		  } //ende while   
		  ?>
        </select>
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><input name="benutzerAendern" type="submit" id="benutzerAendern" class="button" value="<?php echo(getUebersetzung("ändern")); ?>"></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
    <td>&nbsp;</td>
    </tr>
  </table>
</form>
<?php
include_once($root."/backoffice/templates/footer.inc.php");
?>