<? $root = "../..";

/*   
	date: 22.9.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");
include_once($root."/webinterface/templates/bodyStart.inc.php"); 

?>
<form action="./benutzerAendern.php" method="post" name="benutzerAendern" target="_self">
  <table border="0" cellpadding="0" cellspacing="3" class="<?= TABLE_STANDARD ?>">
    <tr>
      <td><p class="<?= STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("Benutzer bearbeiten")); ?>
			<br />        
        <span class="<?= STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("Bitte wählen Sie den zu verändernden Benutzer aus")); ?>:</span></p></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>
      	<select name="id" size="5" id="id">
          <?php
		  $res = getBenutzer($vermieter_id);
		  while($d = mysql_fetch_array($res)) {?>
          	<option value="<?php echo($d["BENUTZER_ID"]); ?>" <?php if ($benutzer_id == $d["BENUTZER_ID"]) echo(" selected"); ?>> <?php echo($d["NAME"]); ?></option>
          <?php
		  } //ende while   
		  ?>
        </select>
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><input name="benutzerAendern" type="submit" id="benutzerAendern" class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
		   onMouseOut="this.className='<?= BUTTON ?>';" value="<?php echo(getUebersetzung("Benutzer ändern")); ?>"></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<?php
//-------------ende benutzer ändern
/*
//-------------benutzer löschen
prüfen ob benutzer überhaupt vorhanden sind - sich selbst kann man nicht löschen!
*/
if (getAnzahlVorhandeneBenutzer($vermieter_id) > 1){
?>
<form action="./benutzerLoeschenBestaetigen.php" method="post" name="benutzerLoeschen" target="_self">
  <table border="0" cellpadding="0" cellspacing="3" class="<?= TABLE_STANDARD ?>">
    <tr>
      <td><p class="<?= STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("Benutzer löschen")); ?><br/>
          <span class="<?= STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("Bitte wählen Sie den zu löschenden Benutzer aus")); ?>. 
		  <?php echo(getUebersetzung("Sie können mehrere Benutzer zugleich auswählen und löschen indem Sie die [STRG]-Taste gedrückt halten und auf die Benutzernamen klicken")); ?>.</span></p></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>      	
      	<select name="id[]" size="5" multiple id="id">
          <?php
		  $res = getBenutzer($vermieter_id);
		  $i = true;
		  while($d = mysql_fetch_array($res)) {
		  	if ($d["BENUTZER_ID"] == $benutzer_id){
		  		continue; //man kann sich nicht selbst löschen!
		  	}
		  	?>		  	
          	<option value="<?php echo($d["BENUTZER_ID"]); ?>" <?php if ($i) echo(" selected"); ?>> <?php echo($d["NAME"]); ?></option>
          <?php
          	$i=false;
		  } //ende while   
		  ?>
        </select>
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><input name="benutzerLoeschen" type="submit" id="benutzerLoeschen" class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
       onMouseOut="this.className='<?= BUTTON ?>';" value="<?php echo(getUebersetzung("Benutzer löschen")); ?>"></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<?php
} //ende anzahlBenutzer ist ok
?>
<form action="./benutzerAnlegen.php" method="post" name="benutzerAnlegen" target="_self">
  <table border="0" cellpadding="0" cellspacing="3" class="<?= TABLE_STANDARD ?>">
    <tr>
      <td><span class="<?= STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("Benutzer anlegen")); ?></span><br/>
        <?php echo(getUebersetzung("Klicken Sie auf den Button [Benutzer anlegen] um einen neuen Benutzer hinzuzufügen")); ?>.</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><input name="benutzerAnlegenButton" type="submit" id="benutzerAnlegenButton" class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
       onMouseOut="this.className='<?= BUTTON ?>';" value="<?php echo(getUebersetzung("Benutzer anlegen")); ?>"></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<?php
include_once($root."/webinterface/templates/footer.inc.php");
?>
