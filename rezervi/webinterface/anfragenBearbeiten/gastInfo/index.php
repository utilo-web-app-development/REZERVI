<?php session_start();
$root = "../../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
	/*   
			reservierungsplan
			gast-infos anzeigen und evt. ändern:
			author: christian osterrieder utilo.eu
					
			dieser seite muss übergeben werden:
			Gast PK_ID $gast_id
			$unterkunft_id
		*/

//variablen:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
$gast_id = $_POST["gast_id"]; 
$sprache = getSessionWert(SPRACHE);

	//datenbank öffnen:
	include_once("../../../conf/rdbmsConfig.php");
	
	//funktions einbinden:
	include_once("../../../include/unterkunftFunctions.php");
	//include_once("../../../webinterface/include/zimmerFunctions.php");	
	include_once("../../../include/reservierungFunctions.php");
	include_once("../../../include/gastFunctions.php");
	include_once("../../../include/benutzerFunctions.php");	
	//uebersetzer einfuegen:
	include_once("../../../include/uebersetzer.php");
	
?>
<?php include_once("../../templates/headerA.php"); ?>
<!--link href="../templates/stylesheets.css" rel="stylesheet" type="text/css"-->
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../../templates/headerB.php"); ?>
<?php include_once("../../templates/bodyA.php"); ?>
<!-- dynamisches update der anzahl der tage für ein gewisses monat mit java-script: -->
<script language="JavaScript">
	<!--
	    function zurueck(){
			history.back();		
	    }
	    //-->
	</script>
<?php		
	//passwortprüfung:	
	if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){ ?>
<p class="ueberschrift"><?php echo(getUebersetzung("Informationen über den Gast",$sprache,$link)); ?>:</p>
<form action="../index.php" method="post" name="form1" target="_self" >
  <table border="0" cellpadding="0" cellspacing="0" class="table">
    <tr>
      <td><table border="0" cellspacing="3" cellpadding="0">
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("Anrede",$sprache,$link)); ?></td>
            <td> <input name="anrede" type="text" id="anrede" value="<?php echo(getGuestAnrede($gast_id,$link)); ?>" readonly> 
            </td>
            <td></td>
          </tr>
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("Vorname",$sprache,$link)); ?></td>
            <td><input name="vorname" type="text" id="vorname" value="<?php echo(getGuestVorname($gast_id,$link)); ?>" readonly></td>
            <td></td>
          </tr>
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("Nachname",$sprache,$link)); ?></td>
            <td><input name="nachname" type="text" id="nachname" value="<?php echo(getGuestNachname($gast_id,$link)); ?>" readonly></td>
            <td></td>
          </tr>
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("Straße/Hausnummer",$sprache,$link)); ?></td>
            <td><input name="strasse" type="text" id="strasse" value="<?php echo(getGuestStrasse($gast_id,$link)); ?>" readonly></td>
            <td></td>
          </tr>
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("PLZ",$sprache,$link)); ?></td>
            <td><input name="plz" type="text" id="plz" value="<?php echo(getGuestPLZ($gast_id,$link)); ?>" readonly></td>
            <td></td>
          </tr>
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("Ort",$sprache,$link)); ?></td>
            <td><input name="ort" type="text" id="ort" value="<?php echo(getGuestOrt($gast_id,$link)); ?>" readonly></td>
            <td></td>
          </tr>
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("Land",$sprache,$link)); ?></td>
            <td><input name="land" type="text" id="land" value="<?php echo(getGuestLand($gast_id,$link)); ?>" readonly></td>
            <td></td>
          </tr>
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("E-Mail-Adresse",$sprache,$link)); ?></td>
            <td><input name="email" type="text" id="email" value="<?php echo(getGuestEmail($gast_id,$link)); ?>" readonly></td>
            <td></td>
          </tr>
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("Telefonnummer",$sprache,$link)); ?></td>
            <td><input name="tel" type="text" id="tel" value="<?php echo(getGuestTel($gast_id,$link)); ?>" readonly></td>
            <td></td>
          </tr>
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("Faxnummer",$sprache,$link)); ?></td>
            <td><input name="fax" type="text" id="fax" value="<?php echo(getGuestFax($gast_id,$link)); ?>" readonly></td>
            <td></td>
          </tr>
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("Anmerkungen",$sprache,$link)); ?></td>
            <td><textarea name="anmerkungen" readonly="readonly" id="anmerkungen"><?php echo(getGuestAnmerkung($gast_id,$link)); ?></textarea></td>
            <td></td>
          </tr>
        </table></td>
    </tr>
  </table>
   <p>
    <input type="submit" name="Submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("zurück",$sprache,$link)); ?>">
  </p>
</form>
<?php } //ende passwortprüfung 
	else{
		echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!",$sprache,$link));
		}
?>
</body>
</html>
