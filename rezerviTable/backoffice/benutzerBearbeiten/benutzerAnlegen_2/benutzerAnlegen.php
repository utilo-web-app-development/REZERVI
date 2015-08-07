<?  
$root = "../../.."; 
$ueberschrift = "Benutzerdaten bearbeiten";

/*   
	date: 22.9.05
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");

if (!isset($fehler) || $fehler != true){
	$name = "";
	$pass = "";
	$pass2= "";
}

?>
<h2><?php echo(getUebersetzung("Einen neuen Benutzer anlegen")); ?></h2>      
<form action="./benutzerEintragen.php" method="post" name="benutzer" id="benutzer" target="_self">
  <table cellpadding="0" cellspacing="3" border="0">
    <tr>
      <td colspan="2"><?php echo(getUebersetzung("Bitte füllen Sie die untenstehenden Felder aus.")); ?> 
          	<?php echo(getUebersetzung("Die mit [*] gekennzeichneten Felder müssen ausgefüllt werden!")); ?>
      </td>
    </tr>
    <tr>
      <td><?php echo(getUebersetzung("Benutzername")); ?>*</td>
      <td><input name="name" type="text" id="name" value="<?= $name ?>" maxlength="20"/></td>
    </tr>
    <tr>
      <td><?php echo(getUebersetzung("Passwort"));?>*</td>
      <td><input name="pass" type="password" id="pass" value="<?= $pass ?>" maxlength="20"/></td>
    </tr>
    <tr>
      <td><?php echo(getUebersetzung("Passwort wiederholen")); ?>*</td>
      <td><input name="pass2" type="password" id="pass2" value="<?= $pass2 ?>" maxlength="20"/></td>
    </tr>
    <tr>
      <td><?php echo(getUebersetzung("Benutzerrechte")); ?>*</td>
      <td><select name="rechte">
          <option value="1" selected><?php echo(getUebersetzung("Benutzer")); ?></option>
          <option value="2"><?php echo(getUebersetzung("Administrator")); ?></option>
        </select></td>
    </tr>
    <tr>
      <td colspan="2"><input name="Submit" type="submit" id="Submit" class="button"
      	 value="<?php echo(getUebersetzung("Hinfügen")); ?>"></td>
    </tr>
  </table>
</form>
