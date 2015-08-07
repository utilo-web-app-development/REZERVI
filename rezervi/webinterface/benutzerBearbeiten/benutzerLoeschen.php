<? session_start();
$root = "../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
/*   
			reservierungsplan
			bestätigung zum löschen von zimmern von benutzer einholen!
*/

$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
$id = $_POST["id"];
$sprache = getSessionWert(SPRACHE);

	//datenbank öffnen:
	include_once("../../conf/rdbmsConfig.php");
	
	//andere funktionen importieren:
	include_once("../../include/benutzerFunctions.php");
	include_once("../../include/unterkunftFunctions.php");
	include_once("../../include/gastFunctions.php");
	include_once("../../include/reservierungFunctions.php");
	include_once("../../include/zimmerFunctions.php");
	//uebersetzer einfuegen:
	include_once("../../include/uebersetzer.php");
			
?>
<?php include_once("../templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../templates/headerB.php"); ?>
<?php include_once("../templates/bodyA.php"); ?>
<p class="standardSchriftBold"><?php echo(getUebersetzung("Löschung bestätigen",$sprache,$link)); ?></p>
 <?php //passwortprüfung:	
	if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){
		$benutzer_id = getUserId($benutzername,$passwort,$link);
?>

<table border="0" cellpadding="0" cellspacing="3" class="frei">
  <tr>
    <td><p> 
	<?php 		
	 			
		$anzahl = count($id);
	 	for($i = 0; $i < $anzahl; $i++){
			if ($id[$i] == $benutzer_id) continue;
			if ($id[$i] == 1 && DEMO == true) continue;
			//zuerst mal die reservierungen raushauen:
			$query = ("DELETE FROM 
						Rezervi_Benutzer
           			 	WHERE
           				PK_ID = '$id[$i]'
		    ");          

			$res = mysql_query($query, $link);
			if (!$res) { 
				echo("die Anfrage $query scheitert"); 
			}			
		} //ende for
	?><?php echo(getUebersetzung("Der Benutzer wurde aus der Datenbank gelöscht!",$sprache,$link)); ?></p>
      </td>
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

        <input name="retour2" type="submit" class="button200pxA" id="retour2" onMouseOver="this.className='button200pxB';"
	 onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("Hauptmenü",$sprache,$link)); ?>">
      </form></td>
  </tr>
</table>
<?php 
	} //ende if passwortprüfung
	else {
		echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!",$sprache,$link));
	}
 ?>
</body>
</html>
