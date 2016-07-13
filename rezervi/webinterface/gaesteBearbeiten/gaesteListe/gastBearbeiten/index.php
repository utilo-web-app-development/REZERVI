<?php session_start();
$root = "../../../..";
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

$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
$anrede_val = $_POST["anrede_val"];
$vorname_val = $_POST["vorname_val"];
$nachname_val = $_POST["nachname_val"];
$strasse_val = $_POST["strasse_val"];
$plz_val = $_POST["plz_val"];
$ort_val = $_POST["ort_val"];
$land_val = $_POST["land_val"];
$email_val = $_POST["email_val"];
$tel_val = $_POST["tel_val"];
$fax_val = $_POST["fax_val"];
$sprache_val = $_POST["anmerkung_val"];
$anmerkung_val = $_POST["anmerkung_val"];
$gast_id = $_POST["gast_id"];
$sprache = getSessionWert(SPRACHE);
$index = $_POST["index"];

//datenbank öffnen:
include_once("../../../../conf/rdbmsConfig.php");

//funktions einbinden:
include_once("../../../../include/unterkunftFunctions.php");
//uebersetzer einfuegen:
include_once("../../../../include/uebersetzer.php");
include_once("../../../../include/reservierungFunctions.php");
include_once("../../../../include/gastFunctions.php");
include_once("../../../../include/benutzerFunctions.php");	
include_once("../../../../include/einstellungenFunctions.php");	
	
		
?>
<?php include_once("../../../templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../../../templates/headerB.php"); ?>
<?php include_once("../../../templates/bodyA.php"); ?>
<?php		
//passwortprüfung:	
if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){ 
?>

<table width="100%" border="0" cellspacing="3" cellpadding="0" class="table">
  <tr>
    <td><?php echo(getUebersetzung("Gast bearbeiten",$sprache,$link)); ?>:<br/>
      <?php echo(getUebersetzung("Bitte überschreiben bzw. ergänzen Sie die Felder des Gastes den Sie ändern möchten",$sprache,$link)); ?>:</td>
  </tr>
</table>
<br/>
<form action="./gastAendern.php" method="post" name="gastAendern" target="_self" id="gastAendern" >
  <table border="0" cellpadding="0" cellspacing="3" class="table">
    <tr>
      <td><table border="0" cellspacing="3" cellpadding="0">
          <tr>
            <td class="standardSchrift"><?php echo(getUebersetzung("Anrede",$sprache,$link)); ?></td>
            <td><input name="anrede" type="text" id="anrede" value="<?php echo(getGuestAnrede($gast_id,$link)); ?>" >
            </td>
            <td></td>
          </tr>
          <tr>
            <td class="standardSchrift"><?php echo(getUebersetzung("Vorname",$sprache,$link)); ?></td>
            <td><input name="vorname" type="text" id="vorname" value="<?php echo(getGuestVorname($gast_id,$link)); ?>" ></td>
            <td></td>
          </tr>
          <tr>
            <td class="standardSchrift"><?php echo(getUebersetzung("Nachname",$sprache,$link)); ?></td>
            <td><input name="nachname" type="text" id="nachname" value="<?php echo(getGuestNachname($gast_id,$link)); ?>" ></td>
            <td></td>
          </tr>
          <tr>
            <td class="standardSchrift"><?php echo(getUebersetzung("Straße/Hausnummer",$sprache,$link)); ?></td>
            <td><input name="strasse" type="text" id="strasse" value="<?php echo(getGuestStrasse($gast_id,$link)); ?>" ></td>
            <td></td>
          </tr>
          <tr>
            <td class="standardSchrift"><?php echo(getUebersetzung("PLZ",$sprache,$link)); ?></td>
            <td><input name="plz" type="text" id="plz" value="<?php echo(getGuestPLZ($gast_id,$link)); ?>" ></td>
            <td></td>
          </tr>
          <tr>
            <td class="standardSchrift"><?php echo(getUebersetzung("Ort",$sprache,$link)); ?></td>
            <td><input name="ort" type="text" id="ort" value="<?php echo(getGuestOrt($gast_id,$link)); ?>" ></td>
            <td></td>
          </tr>
          <tr>
            <td class="standardSchrift"><?php echo(getUebersetzung("Land",$sprache,$link)); ?></td>
            <td><input name="land" type="text" id="land" value="<?php echo(getGuestLand($gast_id,$link)); ?>" ></td>
            <td></td>
          </tr>
          <tr>
            <td class="standardSchrift"><?php echo(getUebersetzung("E-Mail-Adresse",$sprache,$link)); ?></td>
            <td><input name="email" type="text" id="email" value="<?php echo(getGuestEmail($gast_id,$link)); ?>" ></td>
            <td></td>
          </tr>
          <tr>
            <td class="standardSchrift"><?php echo(getUebersetzung("Telefonnummer",$sprache,$link)); ?></td>
            <td><input name="tel" type="text" id="tel" value="<?php echo(getGuestTel($gast_id,$link)); ?>" ></td>
            <td></td>
          </tr>
          <tr>
            <td class="standardSchrift"><?php echo(getUebersetzung("Faxnummer",$sprache,$link)); ?></td>
            <td><input name="fax" type="text" id="fax" value="<?php echo(getGuestFax($gast_id,$link)); ?>" ></td>
            <td></td>
          </tr>
          <tr>
            <td class="standardSchrift"><?php echo(getUebersetzung("bevorzugte Sprache",$sprache,$link)); ?></td>
            <td><select name="speech" id="speech">
            	<?php
            	//sprachen des belegungsplanes anzeigen:
            	$res = getSprachen($unterkunft_id,$link);
            	while ($d = mysql_fetch_array($res)){
				 	$spr = $d["Sprache_ID"];
					$bezeichnung = getBezeichnungOfSpracheID($spr,$link);
            	?>
                	<option value="<?php echo($spr); ?>" <?php if (getGuestSprache($gast_id,$link) == $spr) echo("selected"); ?>><?php echo(getUebersetzung($bezeichnung,$sprache,$link)); ?></option>
                <?php
				}
				?>
                </select></td>
            <td></td>
          </tr>
          <tr>
            <td class="standardSchrift"><?php echo(getUebersetzung("Anmerkungen",$sprache,$link)); ?></td>
            <td><textarea name="anmerkung"  id="textarea"><?php echo(getGuestAnmerkung($gast_id,$link)); ?></textarea></td>
            <td></td>
          </tr>
        </table>
        <br/>
        <input name="gastAendern" type="submit" id="gastAendern" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("Gast ändern",$sprache,$link)); ?>">
        <input name="gast_id" type="hidden" id="gast_id" value="<?php echo($gast_id); ?>">
        <input name="anrede_val" type="hidden" id="anrede_var" value="<?php echo($anrede_val); ?>">
        <input name="plz_val" type="hidden" id="plz_val" value="<?php echo($plz_val); ?>">
        <input name="vorname_val" type="hidden" id="vorname_var3" value="<?php echo($vorname_val); ?>">
        <input name="nachname_val" type="hidden" id="anrede_var4" value="<?php echo($nachname_val); ?>">
        <input name="strasse_val" type="hidden" id="anrede_var5" value="<?php echo($strasse_val); ?>">
        <input name="ort_val" type="hidden" id="anrede_var6" value="<?php echo($ort_val); ?>">
        <input name="land_val" type="hidden" id="anrede_var7" value="<?php echo($land_val); ?>">
        <input name="email_val" type="hidden" id="anrede_var8" value="<?php echo($email_val); ?>">
        <input name="tel_val" type="hidden" id="anrede_var9" value="<?php echo($tel_val); ?>">
        <input name="fax_val" type="hidden" id="anrede_var" value="<?php echo($fax_val); ?>">
        <input name="anmerkung_val" type="hidden" id="anrede_var" value="<?php echo($anmerkung_val); ?>">
        <input name="sprache_val" type="hidden" id="anrede_var" value="<?php echo($sprache_val); ?>">
		<input name="index" type="hidden" value="<?php echo($index); ?>"/>
      </td>
    </tr>
  </table>
</form>
<table border="0" cellspacing="3" cellpadding="0" class="table">
  <tr>
    
      <td width="1"><form action="../../../inhalt.php" method="post" name="hauptmenue" target="_self" id="hauptmenue">
	  	<input type="submit" name="Submit3" value="<?php echo(getUebersetzung("Hauptmenü",$sprache,$link)); ?>" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';"> </form></td>
   
    <td><form action="../index.php" method="post" name="zurueck" target="_self" id="zurueck">
        <input type="submit" name="Submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("zurück",$sprache,$link)); ?>">
        <input name="anrede_val" type="hidden" id="anrede_val" value="<?php echo($anrede_val); ?>">
        <input name="vorname_val" type="hidden" id="vorname_val" value="<?php echo($vorname_val); ?>">
        <input name="nachname_val" type="hidden" id="nachname_val" value="<?php echo($nachname_val); ?>">
        <input name="strasse_val" type="hidden" id="strasse_val" value="<?php echo($strasse_val); ?>">
        <input name="ort_val" type="hidden" id="ort_val" value="<?php echo($ort_val); ?>">
        <input name="land_val" type="hidden" id="land_val" value="<?php echo($land_val); ?>">
        <input name="email_val" type="hidden" id="email_val" value="<?php echo($email_val); ?>">
        <input name="tel_val" type="hidden" id="tel_val" value="<?php echo($tel_val); ?>">
        <input name="fax_val" type="hidden" id="anrede_val" value="<?php echo($fax_val); ?>">
        <input name="anmerkung_val" type="hidden" id="anrede_val" value="<?php echo($anmerkung_val); ?>">
        <input name="sprache_val" type="hidden" id="anrede_var" value="<?php echo($sprache_val); ?>">
        <input name="plz_val" type="hidden" id="plz_val" value="<?php echo($plz_val); ?>">
      </form></td>
  </tr>
</table>
<?php } //ende passwortprüfung 
else{
	echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!",$sprache,$link));
	}
?>
</body>
</html>
