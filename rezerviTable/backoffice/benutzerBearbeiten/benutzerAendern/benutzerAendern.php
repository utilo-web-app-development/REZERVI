<?  
$root = "../../.."; 
$ueberschrift = "Benutzerdaten bearbeiten";
$unterschrift = "Ändern";

/*   
	date: 24.9.05
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
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

include_once($root."/backoffice/templates/breadcrumps.inc.php");
$breadcrumps = erzeugenBC($root, "Benutzerdaten", "benutzerBearbeiten/index.php",
								$unterschrift, "benutzerBearbeiten/benutzerAendern/index.php",
								$name, "");
include_once($root."/backoffice/templates/bodyStart.inc.php"); ?>
<h2><?php echo(getUebersetzung("Benutzer ändern")); ?></h2>      	
<form action="./benutzerAendernDurchfuehren.php" method="post" 
	name="benutzer" id="benutzer" target="_self">
  <input name="id" type="hidden" value="<?= $id ?>">
  <input name="testuser" type="hidden" value="<?= $testuser ?>">  
  <table border="0" cellpadding="0" cellspacing="3">
    <tr>
      <td colspan="2"><?php echo(getUebersetzung("Bitte füllen Sie die untenstehenden Felder aus.")); ?> <?php echo(getUebersetzung("Die mit [*] gekennzeichneten Felder müssen ausgefüllt werden!")); ?></td>
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
        <input name="Submit" type="submit" id="Submit" class="button" value="<?php echo(getUebersetzung("Benutzer ändern")); ?>"></td>
    </tr>
  </table>
</form>
<?php
include_once($root."/backoffice/templates/footer.inc.php");
?>
