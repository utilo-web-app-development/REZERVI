<?php $root = "../..";

/*   
	date: 22.9.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");

if (!isset($fehler) || $fehler != true){
	$name = "";
	$pass = "";
	$pass2= "";
}

include_once($root."/webinterface/templates/bodyStart.inc.php"); ?>

<form action="./benutzerEintragen.php" method="post" name="benutzer" id="benutzer" target="_self">
  <table cellpadding="0" cellspacing="3" border="0" class="<?php echo STANDARD_SCHRIFT ?>">
    <tr>
      <td colspan="2"><p class="<?php echo STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("Benutzer anlegen")); ?><br/>
          <span class="<?php echo STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("Bitte füllen Sie die untenstehenden Felder aus.")); ?> 
          	<?php echo(getUebersetzung("Die mit [*] gekennzeichneten Felder müssen ausgefüllt werden!")); ?>
          </span></p>
      </td>
    </tr>
    <tr>
      <td height="30" colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td><?php echo(getUebersetzung("Benutzername")); ?>*</td>
      <td><input name="name" type="text" id="name" value="<?php echo $name ?>" maxlength="20"></td>
    </tr>
    <tr>
      <td><?php echo(getUebersetzung("Passwort")); ?>*</td>
      <td><input name="pass" type="password" id="pass" value="<?php echo $pass ?>" maxlength="20"></td>
    </tr>
    <tr>
      <td><?php echo(getUebersetzung("Passwort wiederholen")); ?>*</td>
      <td><input name="pass2" type="password" id="pass2" value="<?php echo $pass2 ?>" maxlength="20"></td>
    </tr>
    <tr>
      <td height="30" colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td><?php echo(getUebersetzung("Benutzerrechte")); ?>*</td>
      <td><select name="rechte">
          <option value="1" selected><?php echo(getUebersetzung("Benutzer")); ?></option>
          <option value="2"><?php echo(getUebersetzung("Administrator")); ?></option>
        </select></td>
    </tr>
    <tr>
      <td colspan="2"><input name="Submit" type="submit" id="Submit" class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
       onMouseOut="this.className='<?php echo BUTTON ?>';" value="<?php echo(getUebersetzung("Benutzer anlegen")); ?>"></td>
    </tr>
  </table>
</form>
<table border="0" cellpadding="3" cellspacing="0">
  <tr>
    <td><form action="./index.php" method="post" name="zurueck" target="_self" id="zurueck">
        <input name="retour" type="submit" class="<?php echo BUTTON ?>" id="retour" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
	 onMouseOut="this.className='<?php echo BUTTON ?>';" value="<?php echo(getUebersetzung("zurück")); ?>">
      </form></td>
  </tr>
</table>
<?php
include_once($root."/webinterface/templates/footer.inc.php");
?>
