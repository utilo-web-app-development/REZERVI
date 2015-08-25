<? session_start();
$root = "../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
/*   
			reservierungsplan rezervi
			author utilo.eu
			benutzer aendern
*/

//variablen:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
$id = $_POST["id"];
$sprache = getSessionWert(SPRACHE);

	//datenbank �ffnen:
	include_once("../../conf/rdbmsConfig.php");
	
	//andere funktionen importieren:
	include_once("../../include/benutzerFunctions.php");
	include_once("../../include/unterkunftFunctions.php");	
	//uebersetzer einfuegen:
	include_once("../../include/uebersetzer.php");
			
?>
<?php include_once("../templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../templates/headerB.php"); ?>
<script language="JavaScript" type="text/javascript" src="./benutzerDaten.php">
</script>
<?php include_once("../templates/bodyA.php"); ?>
<?php //passwortpr�fung:	
	if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){
	
	//daten des ausgew�hlten benutzers auslesen:
	$name = getUserName($id,$link);
	$pass = getPassword($id,$link);
	$rechte = getUserRights($id,$link);
	$testuser = "false";
	if ($name == "test"){
		$testuser = "true";
	}
?>
<form action="./benutzerAendernDurchfuehren.php" method="post" name="benutzer" id="benutzer" target="_self" onSubmit="return chkFormular()">
  <input name="id" type="hidden" value="<?php echo($id); ?>">
  <input name="testuser" type="hidden" value="<?= $testuser ?>">
  <table border="0" cellpadding="0" cellspacing="3" class="tableColor">
    <tr class="table">
      <td colspan="2"><p class="standardSchriftBold"><?php echo(getUebersetzung("Benutzer bearbeiten",$sprache,$link)); ?><br/>
          <span class="standardSchrift"><?php echo(getUebersetzung("Bitte f�llen Sie die untenstehenden Felder aus.",$sprache,$link)); ?> <?php echo(getUebersetzung("Die mit [*] gekennzeichneten Felder m�ssen ausgef�llt werden!",$sprache,$link)); ?></span></p></td>
    </tr>
    <tr>
      <td height="30" colspan="2">&nbsp;</td>
    </tr>
    <tr class="table">
      <td width="50%"><?php echo(getUebersetzung("Benutzername",$sprache,$link)); ?>*</td>
      <td width="50%"><input name="name" type="text" id="name" value="<?php if (isset($name)) {echo($name);} ?>" maxlength="20"></td>
    </tr>
    <tr class="table">
      <td><?php echo(getUebersetzung("Passwort",$sprache,$link)); ?>*</td>
      <td><input name="pass" type="password" id="pass" value="<?php if (isset($pass)) {echo($pass);} ?>" maxlength="20"></td>
    </tr>
    <tr class="table">
      <td><?php echo(getUebersetzung("Passwort wiederholen",$sprache,$link)); ?>*</td>
      <td><input name="pass2" type="password" id="pass2"  value="<?php if (isset($pass)) {echo($pass);} ?>" maxlength="20"></td>
    </tr>
    <tr class="table">
      <td height="30" colspan="2">&nbsp;</td>
    </tr>
    <tr class="table">
      <td><?php echo(getUebersetzung("Benutzerrechte",$sprache,$link)); ?>*</td>
      <td><select name="rechte">
          <option value="1" <?php if ($rechte == 1) echo(" selected"); ?>><?php echo(getUebersetzung("Benutzer",$sprache,$link)); ?></option>
          <option value="2" <?php if ($rechte == 2) echo(" selected"); ?>><?php echo(getUebersetzung("Administrator",$sprache,$link)); ?></option>
        </select></td>
    </tr>
    <tr class="table">
      <td colspan="2">
        <input name="Submit" type="submit" id="Submit" class="btn btn-success" value="<?php echo(getUebersetzung("Benutzer Ändern",$sprache,$link)); ?>">
      </td>
    </tr>
  </table>
 
     
</form>
<br/>

 
<table border="0" cellpadding="0" cellspacing="0" class="table">
  <tr>
    <td>	
    	<!-- button ohne href <form action="./index.php" method="post" name="benutzeraendern" target="_self" id="benutzeraendern">
        <input name="retour" type="submit" class="btn btn-primary" id="retour" value="<?php echo(getUebersetzung("zurück",$sprache,$link)); ?>">
      </form> -->
    	 <a class="btn btn-primary" href="index.php"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>&nbsp;<?php echo(getUebersetzung("zurück",$sprache,$link)); ?></a>
    </td>
  </tr>
</table>
<br/>
<table  border="0" cellpadding="0" cellspacing="0" class="table">
  <tr>
    <td><form action="../inhalt.php" method="post" name="hauptmenue" target="_self" id="hauptmenue">
        <input name="retour" type="submit" class="button200pxA" id="retour" onMouseOver="this.className='button200pxB';"
	 onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("Hauptmen�",$sprache,$link)); ?>">
      </form></td>
  </tr>
</table>
<p>
  </td>
  </tr>
  </table>
</p>
<?php 
	} //ende if passwortpr�fung
	else {
		echo(getUebersetzung("Bitte Browser schlie�en und neu anmelden - Passwortpr�fung fehlgeschlagen!",$sprache,$link));
	}
 ?>
</body>
</html>
