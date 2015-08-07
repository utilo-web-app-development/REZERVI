<?php session_start();
$root = "../../../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
	/*   
			reservierungsplan
			gast-infos anzeigen und evt. ‰ndern:
			author: christian osterrieder utilo.eu
					
			dieser seite muss ¸bergeben werden:
			Gast PK_ID $gast_id
			$unterkunft_id
		*/

	//datenbank ˆffnen:
	include_once("../../../../conf/rdbmsConfig.php");
	
	//funktions einbinden:
	include_once("../../../../include/unterkunftFunctions.php");
	//include_once("../../../../webinterface/gaesteBearbeiten/include/zimmerFunctions.php");	
	include_once("../../../../include/reservierungFunctions.php");
	include_once("../../../../include/gastFunctions.php");
	include_once("../../../../include/benutzerFunctions.php");	
	
?>
<?php include_once("../../../templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../../../templates/headerB.php"); ?>
<?php include_once("../../../templates/bodyA.php"); ?>
<?php		
	//passwortpr¸fung:	
	if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){ ?>

<p class="ueberschrift"><? echo (getUnterkunftName($unterkunft_id,$link)) ?></p>
<table width="100%" border="0" cellspacing="3" cellpadding="0" class="table">
  <tr>
    <td>Gast bearbeiten:<br/>
      Bitte &uuml;berschreiben bzw. erg&auml;nzen Sie die Felder des Gastes die 
      Sie &auml;ndern m&ouml;chten. Klicken sie anschlie&szlig;end auf den Button 
      &quot;Gast &auml;ndern&quot;.</td>
  </tr>
</table>
<br/>
<form action="../../../../webinterface/gaesteBearbeiten/suche/gastBearbeiten/gastAendern.php" method="post" name="gastAendern" target="_self" id="gastAendern" >
  <table border="0" cellpadding="0" cellspacing="3" class="table">
    <tr>
      <td><table border="0" cellspacing="3" cellpadding="0">
          <tr> 
            <td class="standardSchrift">Anrede</td>
            <td> <input name="anrede" type="text" id="anrede" value="<?php echo(getGuestAnrede($gast_id,$link)); ?>" > 
            </td>
            <td></td>
          </tr>
          <tr> 
            <td class="standardSchrift">Vorname</td>
            <td><input name="vorname" type="text" id="vorname" value="<?php echo(getGuestVorname($gast_id,$link)); ?>" ></td>
            <td></td>
          </tr>
          <tr> 
            <td class="standardSchrift">Nachname</td>
            <td><input name="nachname" type="text" id="nachname" value="<?php echo(getGuestNachname($gast_id,$link)); ?>" ></td>
            <td></td>
          </tr>
          <tr> 
            <td class="standardSchrift">Straﬂe/Hausnummer</td>
            <td><input name="strasse" type="text" id="strasse" value="<?php echo(getGuestStrasse($gast_id,$link)); ?>" ></td>
            <td></td>
          </tr>
          <tr> 
            <td class="standardSchrift">Postleitzahl</td>
            <td><input name="plz" type="text" id="plz" value="<?php echo(getGuestPLZ($gast_id,$link)); ?>" ></td>
            <td></td>
          </tr>
          <tr> 
            <td class="standardSchrift">Wohnort</td>
            <td><input name="ort" type="text" id="ort" value="<?php echo(getGuestOrt($gast_id,$link)); ?>" ></td>
            <td></td>
          </tr>
          <tr> 
            <td class="standardSchrift">Land</td>
            <td><input name="land" type="text" id="land" value="<?php echo(getGuestLand($gast_id,$link)); ?>" ></td>
            <td></td>
          </tr>
          <tr> 
            <td class="standardSchrift">E-Mail-Adresse</td>
            <td><input name="email" type="text" id="email" value="<?php echo(getGuestEmail($gast_id,$link)); ?>" ></td>
            <td></td>
          </tr>
          <tr> 
            <td class="standardSchrift">Telefonnummer</td>
            <td><input name="tel" type="text" id="tel" value="<?php echo(getGuestTel($gast_id,$link)); ?>" ></td>
            <td></td>
          </tr>
          <tr> 
            <td class="standardSchrift">Faxnummer</td>
            <td><input name="fax" type="text" id="fax" value="<?php echo(getGuestFax($gast_id,$link)); ?>" ></td>
            <td></td>
          </tr>
          <tr> 
            <td class="standardSchrift">Anmerkungen</td>
            <td><textarea name="anmerkung"  id="textarea"><?php echo(getGuestAnmerkung($gast_id,$link)); ?></textarea></td>
            <td></td>
          </tr>
        </table>
        <br/>
        <input name="gastAendern" type="submit" id="gastAendern" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" value="Gast &auml;ndern">
        <input name="benutzer_id" type="hidden" id="benutzer_id" value="<? echo($benutzer_id); ?>">
        <input name="unterkunft_id" type="hidden" id="unterkunft_id" value="<? echo($unterkunft_id); ?>">
        <input name="gast_id" type="hidden" id="gast_id" value="<? echo($gast_id); ?>">
        <input name="anrede_val" type="hidden" id="anrede_var" value="<? echo($anrede_val); ?>"> 
        <input name="vorname_val" type="hidden" id="vorname_var3" value="<? echo($vorname_val); ?>"> 
        <input name="nachname_val" type="hidden" id="anrede_var4" value="<? echo($nachname_val); ?>"> 
        <input name="strasse_val" type="hidden" id="anrede_var5" value="<? echo($strasse_val); ?>"> 
        <input name="ort_val" type="hidden" id="anrede_var6" value="<? echo($ort_val); ?>"> 
        <input name="land_val" type="hidden" id="anrede_var7" value="<? echo($land_val); ?>"> 
        <input name="email_val" type="hidden" id="anrede_var8" value="<? echo($email_val); ?>"> 
        <input name="tel_val" type="hidden" id="anrede_var9" value="<? echo($tel_val); ?>"> 
        <input name="fax_val" type="hidden" id="anrede_var" value="<? echo($fax_val); ?>"> 
        <input name="anmerkung_val" type="hidden" id="anrede_var" value="<? echo($anmerkung_val); ?>"> 
      </td>
    </tr>
  </table>
  </form>  
<table width="100%" border="0" cellspacing="3" cellpadding="0" class="table">
  <tr><form action="../../../../webinterface/inhalt.php" method="post" name="hauptmenue" target="_self" id="hauptmenue"> 
    <td width="1"> <input name="benutzername" type="hidden" value="<?php echo($benutzername); ?>"> 
      <input name="passwort" type="hidden" value="<?php echo($passwort); ?>"> 
      <input type="submit" name="Submit3" value="Hauptmen¸" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';"></td></form><form action="../../../../webinterface/gaesteBearbeiten/suche/index.php" method="post" name="zurueck" target="_self" id="zurueck">
    <td> <input name="unterkunft_id" type="hidden" id="unterkunft_id" value="<? echo $unterkunft_id ?>">
	<input name="benutzer_id" type="hidden" id="benutzer_id" value="<? echo($benutzer_id); ?>"> 
      <input type="submit" name="Submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" value="zur&uuml;ck">
        <input name="anrede_val" type="hidden" id="anrede_val" value="<? echo($anrede_val); ?>"> 
        <input name="vorname_val" type="hidden" id="vorname_val" value="<? echo($vorname_val); ?>"> 
        <input name="nachname_val" type="hidden" id="nachname_val" value="<? echo($nachname_val); ?>"> 
        <input name="strasse_val" type="hidden" id="strasse_val" value="<? echo($strasse_val); ?>"> 
        <input name="ort_val" type="hidden" id="ort_val" value="<? echo($ort_val); ?>"> 
        <input name="land_val" type="hidden" id="land_val" value="<? echo($land_val); ?>"> 
        <input name="email_val" type="hidden" id="email_val" value="<? echo($email_val); ?>"> 
        <input name="tel_val" type="hidden" id="tel_val" value="<? echo($tel_val); ?>"> 
        <input name="fax_val" type="hidden" id="anrede_val" value="<? echo($fax_val); ?>"> 
        <input name="anmerkung_val" type="hidden" id="anrede_val" value="<? echo($anmerkung_val); ?>"></td></form>
  </tr>
</table>
<?php } //ende passwortpr¸fung 
	else{
		echo(getUebersetzung("Bitte Browser schlieﬂen und neu anmelden - Passwortpr¸fung fehlgeschlagen!",$sprache,$link));
		}
?>
</body>
</html>
