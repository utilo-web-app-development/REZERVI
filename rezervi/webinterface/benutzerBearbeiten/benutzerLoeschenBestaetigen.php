<? session_start();
$root = "../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
/*   
			reservierungsplan
			best�tigung zum l�schen 
			author utilo.eu
*/

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
<?php include_once("../templates/bodyA.php"); ?>
<p class="standardSchriftBold"><?php echo(getUebersetzung("Löschung bestätigen",$sprache,$link)); ?></p>
<form action="./benutzerLoeschen.php" method="post" name="zimmerLoeschen" target="_self" id="zimmerLoeschen">
  <table border="0" cellpadding="0" cellspacing="3" class="table">
    <tr>
      <td><p><?php echo(getUebersetzung("Folgende Benutzer werden aus der Datenbank entfernt",$sprache,$link)); ?>:
        <p>
          <select name="id[]" size="5" multiple>
            <?php 
				$anzahl = count($id);				
	  			for($i = 0; $i < $anzahl; $i++){ ?>
            <option value="<?php echo($id[$i]); ?>" selected> <?php echo(getUserName($id[$i],$link)); 
            ?> </option>
            <?php 
				} //ende for
			?>
          </select>
        </p>
        <p><?php echo(getUebersetzung("Nur die hier selektierten Benutzer werden gel�scht.",$sprache,$link)); ?> 
		<?php echo(getUebersetzung("Entfernen Sie die Markierungen (mit [STRG] und Mausklick) wenn Benutzer nicht gelöscht werden sollen!",$sprache,$link)); ?></p>
        
        <input name="retour" type="submit" class="btn btn-danger"  id="retour"  value="<?php echo(getUebersetzung("löschen",$sprache,$link)); ?>">
      </td>
    </tr>
  </table>
</form>
<br/>
<table border="0" cellpadding="0" cellspacing="0" class="table">
  <tr>
    <td>
    	<!-- <form action="./index.php" method="post" name="zimmer aendern" target="_self" id="zimmer aendern">
        <input name="zurueck" type="submit" class="button200pxA" id="zurueck" onMouseOver="this.className='button200pxB';"
	 onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("zurück",$sprache,$link)); ?>">
      </form> -->
        <a class="btn btn-primary" href="./index.php"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>&nbsp;<?php echo(getUebersetzung("zurück",$sprache,$link)); ?></a>
    </td>
  </tr>
</table>
<br/>
<table border="0" cellpadding="0" cellspacing="0" class="table">
  <tr>
    <td><form action="../inhalt.php" method="post" name="hauptmenue" target="_self" id="hauptmenue">
        <input name="hauptmenue" type="submit" class="button200pxA" id="hauptmenue" onMouseOver="this.className='button200pxB';"
	 onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("Hauptmenü",$sprache,$link)); ?>">
      </form></td>
  </tr>
</table>
</body>
</html>
