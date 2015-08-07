<?php
$root = "../../.."; 
$ueberschrift = "Benutzerdaten bearbeiten";
$unterschrift = "Löschen";

/*
 * Created on 05.12.2007
 * Author: LI Haitao
 * Company: Alpstein-Austria  
 */

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/backoffice/templates/components.inc.php");
include_once($root."/backoffice/templates/breadcrumps.inc.php");
$breadcrumps = erzeugenBC($root, "Benutzerdaten", "benutzerBearbeiten/index.php",
								$unterschrift, "benutzerBearbeiten/benutzerLoeschen/index.php");
include_once($root."/backoffice/templates/bodyStart.inc.php"); 

?>
    <h2><?php echo(getUebersetzung("Benutzer löschen")); ?></h2>
<form action="./benutzerLoeschenBestaetigen.php" method="post" name="benutzerLoeschen" target="_self">
  <table>
    <tr>
      <td><?php echo(getUebersetzung("Bitte wahlen Sie den zu löschenden Benutzer aus")); ?>. 
		  <?php echo(getUebersetzung("Sie können mehrere Benutzer zugleich auswählen und löschen indem Sie die [STRG]-Taste gedrückt halten und auf die Benutzernamen klicken")); ?>.</td>      
    </tr>
    <tr>
      <td>      	
      	<select name="id[]" size="5" multiple id="id">
          <?php
		  $res = getBenutzer($gastro_id);
		  $i = true;
		  while($d = $res->FetchNextObject()) {
		  	if ($d->BENUTZER_ID == $benutzer_id){
		  		continue; //man kann sich nicht selbst löschen!
		  	}
		  	?>		  	
          	<option value="<?php echo($d->BENUTZER_ID); ?>" <?php if ($i) echo(" selected"); ?>> <?php echo($d->NAME); ?></option>
          <?php
          	$i=false;
		  } //ende while   
		  ?>
        </select>
      </td>
    </tr> <?php
	/* prüfen ob benutzer überhaupt vorhanden sind - sich selbst kann man nicht löschen!*/
	if (getAnzahlVorhandeneBenutzer($gastro_id) > 1){ ?>
	<tr>
      <td><?php showSubmitButton(getUebersetzung("löschen")); ?></td>
    </tr> <?php
	} else{	?>  
	<tr>
      <td><?php showSubmitButtonNo(getUebersetzung("löschen")); ?></td>
    </tr>
    <tr>
      <td><?php echo "* ".getUebersetzung("Man kann sich selbst nicht löschen!"); ?></td>
    </tr> <?php
	} ?>
  </table>
</form>
