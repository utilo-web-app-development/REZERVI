<? session_start();
$root = "../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
/*   
			reservierungsplan
			benutzer�nderung durchf�hren
*/

$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
$id = $_POST["id"];
$pass = $_POST["pass"];
$name = $_POST["name"];
$pass2 = $_POST["pass2"];
$rechte = $_POST["rechte"];
$sprache = getSessionWert(SPRACHE);
$testuser = $_POST["testuser"];
if ($testuser == "true"){
	$testuser = true;
}
else{
	$testuser = false;
}

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
<?php include_once("../templates/bodyA.php"); ?>
<?php //passwortpr�fung:	

	if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){	
	
	if ($testuser == true && DEMO == true){
		?>
		<table border="0" cellspacing="0" cellpadding="0" class="frei">
		  <tr>
		    <td><?php echo(getUebersetzung("Der Testbenutzer kann im Demo-Modus nicht ver�ndert werden.",$sprache,$link)); ?>.</td>
		  </tr>
		</table>
		<br/>
	<?php
	}	
	else if(changeBenutzer($id,$name,$pass,$rechte,$unterkunft_id,$link)){	
		
		//�nderungen in der session durchf�hren:
		if (getSessionWert(BENUTZER_ID) == $id){
			setSessionWert(PASSWORT,$pass);
			setSessionWert(BENUTZERNAME,$name);
			setSessionWert(RECHTE,'2');
		}
	
	?>
		<table border="0" cellspacing="0" cellpadding="0" class="frei">
		  <tr>
		    <td><?php echo(getUebersetzung("Die �nderung wurde erfolgreich durchgef�hrt",$sprache,$link)); ?>.</td>
		  </tr>
		</table>
		<br/>
	<?php 
	}
	?>

<table border="0" cellpadding="0" cellspacing="0" class="table">
  <tr>
    <td><form action="./index.php" method="post" name="zimmer aendern" target="_self" id="zimmer aendern">
        <input name="retour" type="submit" class="button200pxA" id="retour" onMouseOver="this.className='button200pxB';"
	 onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("zur�ck",$sprache,$link)); ?>">
      </form></td>
  </tr>
</table>
<br/>
<table border="0" cellpadding="0" cellspacing="0" class="table">
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
