<? $root = "../..";

/*   
	date: 24.9.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");
include_once($root."/include/benutzerFunctions.inc.php");

if (!isset($fehler) || $fehler != true){
	$id = $_POST["id"];
	$name = getUserName($id);
	$pass = getPassword($id);
	if ($name == "test" && $pass == "test"){
		$testuser = true;	
	}
	else{
		$testuser = false;	
	}
	$rechte = getUserRights($id);
}

include_once($root."/webinterface/templates/bodyStart.inc.php"); ?>
	
<form action="./benutzerAendernDurchfuehren.php" method="post" 
	name="benutzer" id="benutzer" target="_self">
  <input name="id" type="hidden" value="<?= $id ?>">
  <input name="testuser" type="hidden" value="<?= $testuser ?>">  
  <table border="0" cellpadding="0" cellspacing="3"  class="<?= STANDARD_SCHRIFT ?>">
    <tr>
      <td colspan="2"><p class="<?= STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("Benutzer bearbeiten")); ?><br/>
          <span class="<?= STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("Bitte füllen Sie die untenstehenden Felder aus.")); ?> <?php echo(getUebersetzung("Die mit [*] gekennzeichneten Felder müssen ausgefüllt werden!")); ?></span></p></td>
    </tr>
    <tr>
      <td height="30" colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td><?php echo(getUebersetzung("Benutzername")); ?>*</td>
      <td><input name="name" type="text" id="name" value="<?php if (isset($name)) {echo($name);} ?>" maxlength="20"></td>
    </tr>
    <tr>
      <td><?php echo(getUebersetzung("Passwort")); ?>*</td>
      <td><input name="pass" type="password" id="pass" value="<?php if (isset($pass)) {echo($pass);} ?>" maxlength="20"></td>
    </tr>
    <tr>
      <td><?php echo(getUebersetzung("Passwort wiederholen")); ?>*</td>
      <td><input name="pass2" type="password" id="pass2"  value="<?php if (isset($pass)) {echo($pass);} ?>" maxlength="20"></td>
    </tr>
    <tr>
      <td height="30" colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td><?php echo(getUebersetzung("Benutzerrechte")); ?>*</td>
      <td><select name="rechte">
          <option value="1" <?php if ($rechte == 1) echo(" selected"); ?>><?php echo(getUebersetzung("Benutzer")); ?></option>
          <option value="2" <?php if ($rechte == 2) echo(" selected"); ?>><?php echo(getUebersetzung("Administrator")); ?></option>
        </select></td>
    </tr>
    <tr>
      <td colspan="2">
        <input name="Submit" type="submit" id="Submit" class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
       onMouseOut="this.className='<?= BUTTON ?>';" value="<?php echo(getUebersetzung("Benutzer ändern")); ?>"></td>
    </tr>
  </table>
</form>
<br/>
<table border="0" cellpadding="0" cellspacing="0" class="<?= TABLE_STANDARD ?>">
  <tr>
    <td><form action="./index.php" method="post" name="benutzeraendern" target="_self" id="benutzeraendern">
        <input name="retour" type="submit" class="<?= BUTTON ?>" id="retour" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
	 onMouseOut="this.className='<?= BUTTON ?>';" value="<?php echo(getUebersetzung("zurück")); ?>">
      </form></td>
  </tr>
</table>
<?php
include_once($root."/webinterface/templates/footer.inc.php");
?>
