<? session_start();
$root = "../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
/*   
			reservierungsplan
			benutzer eintragen
			author utilo.eu
*/

$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
$pass = $_POST["pass"];
$name = $_POST["name"];
$pass2 = $_POST["pass2"];
$rechte = $_POST["rechte"];
$sprache = getSessionWert(SPRACHE);

	//datenbank öffnen:
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
<?php include_once("../templates/bodyA.php"); ?>
<p class="standardSchriftBold"><?php echo(getUebersetzung("Einen neuen Benutzer anlegen",$sprache,$link)); ?></p>	
<?php //passwortprüfung:	
	if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){		
		setUser($name,$pass,$rechte);
?>
		<table border="0" cellpadding="0" cellspacing="0" class="frei">
			  <tr>
				<td><?php echo(getUebersetzung("Der Benutzer wurde hinzugefügt.",$sprache,$link)); ?></td>
			  </tr>
		</table>
	
<p>&nbsp;</p><table border="0" cellpadding="0" cellspacing="0" class="table">
  <tr> 
    <td><form action="./benutzerAnlegen.php" method="post" name="zimmer aendern" target="_self" id="zimmer aendern">

        <input name="retour" type="submit" class="button200pxA" id="retour" onMouseOver="this.className='button200pxB';"
	 onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("einen weiteren anlegen",$sprache,$link)); ?>">
      </form></td>
  </tr>
</table>
<br/>
<table border="0" cellpadding="0" cellspacing="0" class="table">
  <tr> 
    <td><form action="./index.php" method="post" name="zimmer aendern" target="_self" id="zimmer aendern">

        <input name="retour2" type="submit" class="button200pxA" id="retour2" onMouseOver="this.className='button200pxB';"
	 onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("zurück",$sprache,$link)); ?>">
      </form></td>
  </tr>
</table>
<br/>
<table border="0" cellpadding="0" cellspacing="0" class="table">
  <tr> 
    <td><form action="../inhalt.php" method="post" name="hauptmenue" target="_self" id="hauptmenue">

        <input name="retour" type="submit" class="button200pxA" id="retour" onMouseOver="this.className='button200pxB';"
	 onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("Hauptmenü",$sprache,$link)); ?>">
      </form></td>
  </tr>
</table>
<p> </p>     
    <?php 
	} //ende if passwortprüfung
	else {
		echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!",$sprache,$link));
	}
 ?>
</body>
</html>
