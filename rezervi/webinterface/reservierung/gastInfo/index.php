<?php session_start();
$root = "../../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
//variablen:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
if (isset($_POST["gast_id"])){
	$gast_id = $_POST["gast_id"];
}
elseif(isset($_GET["gast_id"])){
	$gast_id = $_GET["gast_id"];
}
if (isset($_POST["jahr"])){
	$jahr = $_POST["jahr"];
}
elseif(isset($_GET["jahr"])){
	$jahr = $_GET["jahr"];
}
if (isset($_POST["monat"])){
	$monat = $_POST["monat"];
}	
elseif(isset($_GET["monat"])){
	$monat = $_GET["monat"];
}
if (isset($_POST["zimmer_id"])){
	$zimmer_id = $_POST["zimmer_id"];
}
elseif(isset($_GET["zimmer_id"])){
	$zimmer_id = $_GET["zimmer_id"];
}
$sprache = getSessionWert(SPRACHE);

	/*   
			reservierungsplan
			gast-infos anzeigen und evt. ändern:
			author: christian osterrieder utilo.eu
					
			dieser seite muss übergeben werden:
			Gast PK_ID $gast_id
			$unterkunft_id
		*/

	//datenbank öffnen:
	include_once("../../../conf/rdbmsConfig.php");
	
	//funktions einbinden:
	include_once("../../../include/unterkunftFunctions.php");
	//uebersetzer einfuegen:
	include_once("../../../include/uebersetzer.php");
	include_once("../../../include/reservierungFunctions.php");
	include_once("../../../include/gastFunctions.php");
	include_once("../../../include/benutzerFunctions.php");	
	
?>
<?php include_once("../../templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../../templates/headerB.php"); ?>
<!-- dynamisches update der anzahl der tage für ein gewisses monat mit java-script: -->
<script language="JavaScript">
	<!--
	    function zurueck(){
			history.back();		
	    }
	    //-->
	</script>
<?php include_once("../../templates/bodyA.php"); ?>
<?php		
	//passwortprüfung:	
	if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){ ?>
<p class="ueberschrift"><?php echo(getUebersetzung("Gäste-Information",$sprache,$link)); ?>:</p>
<form action="../ansichtWaehlen.php" method="post" name="form1" target="_self" >
  <table border="0" cellpadding="0" cellspacing="0" class="table">
    <tr>
      <td><table border="0" cellspacing="3" cellpadding="0">
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("Anrede",$sprache,$link)); ?></td>
            <td> <input name="anrede" type="text" id="anrede2" value="<?php echo(getGuestAnrede($gast_id,$link)); ?>" readonly> 
            </td>
            <td></td>
          </tr>
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("Vorname",$sprache,$link)); ?></td>
            <td><input name="vorname" type="text" id="vorname2" value="<?php echo(getGuestVorname($gast_id,$link)); ?>" readonly></td>
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
            <td class="standardSchrift"><?php echo(getUebersetzung("bevorzugte Sprache",$sprache,$link)); ?> </td>
            <td><input name="spr" type="text" id="spr" value="<?php             
            	$speech = getGuestSprache($gast_id,$link); 
				if ($speech == "fr")
						echo(getUebersetzung("Französisch",$sprache,$link));
					else if ($speech == "en")
						echo(getUebersetzung("Englisch",$sprache,$link));
					else if ($speech == "it")
						echo(getUebersetzung("Italienisch",$sprache,$link));
					else if ($speech == "nl")
						echo(getUebersetzung("Holländisch",$sprache,$link));	
					else if ($speech == "sp")
						echo(getUebersetzung("Spanisch",$sprache,$link));
					else if ($speech == "es")
						echo(getUebersetzung("Estnisch",$sprache,$link));
					else
						echo(getUebersetzung("Deutsch",$sprache,$link));	?>												
														" readonly></td>
            <td></td>
          </tr>
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("Anmerkungen",$sprache,$link)); ?></td>
            <td><textarea name="anmerkungen" readonly="readonly" id="textarea"><?php echo(getGuestAnmerkung($gast_id,$link)); ?></textarea></td>
            <td></td>
          </tr>
        </table></td>
    </tr>
  </table>
 
  <input name="zimmer_id" type="hidden" id="zimmer_id" value="<? echo($zimmer_id); ?>">
  <input name="jahr" type="hidden" id="jahr" value="<? echo($jahr); ?>">
  <input name="monat" type="hidden" id="monat" value="<? echo($monat); ?>">
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
