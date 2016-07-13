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

	//datenbank öffnen:
	include_once("../../../../conf/rdbmsConfig.php");
	
	//funktions einbinden:
	include_once("../../../../include/unterkunftFunctions.php");
	//include_once("../../../../webinterface/gaesteBearbeiten/include/zimmerFunctions.php");	
	//include_once("../../../../../include/reservierungFunctions.php");
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
	//passwortprüfung:	
	if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){ 
	
		if ($vorname == "") 
			$vorname = "-";
		if ($nachname == "")
			$nachname = "-";
		if ($strasse == "")
			$strasse = "-";
		if ($plz == "")
			$plz = "-";
		if ($ort == "")
			$ort = "-";
		if ($email == "")
			$email = "-";
		
		$query = "UPDATE
					Rezervi_Gast
					SET
				    Anrede = '$anrede',
				    Vorname = '$vorname',
					Nachname = '$nachname',
					Strasse = '$strasse',
					PLZ = '$plz',
					Ort = '$ort',
					Land = '$land',
					EMail = '$email',
					Tel = '$tel',
					Fax = '$fax',
					Anmerkung = '$anmerkung'
					WHERE
					PK_ID = '$gast_id'";
					
		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
		}
		else {	
	?>

<p class="ueberschrift"><? echo (getUnterkunftName($unterkunft_id,$link)) ?></p>
<table width="100%" border="0" cellspacing="3" cellpadding="0" class="table">
  <tr>
    <td>Die Daten des Gastes wurden erfolgreich ge&auml;ndert!</td>
  </tr>
</table>
<br/>
<table width="100%" border="0" cellspacing="3" cellpadding="0" class="table">
  <tr><form action="../../../../webinterface/inhalt.php" method="post" name="hauptmenue" target="_self" id="hauptmenue"> 
    <td width="1"> <input name="benutzername" type="hidden" value="<?php echo($benutzername); ?>"> 
      <input name="passwort" type="hidden" value="<?php echo($passwort); ?>"> 
      <input type="submit" name="Submit3" value="Hauptmenü" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';"></td></form><form action="../../../../webinterface/gaesteBearbeiten/suche/index.php" method="post" name="zurueck" target="_self" id="zurueck">
    <td> 
        <input name="benutzer_id" type="hidden" id="benutzer_id" value="<? echo($benutzer_id); ?>">
        <input name="unterkunft_id" type="hidden" id="unterkunft_id" value="<? echo($unterkunft_id); ?>"> 
        <input type="submit" name="Submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" value="zur&uuml;ck">
        <input name="anrede_val" type="hidden" id="anrede_var" value="<? echo($anrede_val); ?>"> 
        <input name="vorname_val" type="hidden" id="vorname_var3" value="<? echo($vorname_val); ?>"> 
        <input name="nachname_val" type="hidden" id="anrede_var4" value="<? echo($nachname_val); ?>"> 
        <input name="strasse_val" type="hidden" id="anrede_var5" value="<? echo($strasse_val); ?>"> 
        <input name="ort_val" type="hidden" id="anrede_var6" value="<? echo($ort_val); ?>"> 
        <input name="land_val" type="hidden" id="anrede_var7" value="<? echo($land_val); ?>"> 
        <input name="email_val" type="hidden" id="anrede_var8" value="<? echo($email_val); ?>"> 
        <input name="tel_val" type="hidden" id="anrede_var9" value="<? echo($tel_val); ?>"> 
        <input name="fax_val" type="hidden" id="anrede_var" value="<? echo($fax_val); ?>"> 
        <input name="anmerkung_val" type="hidden" id="anrede_var" value="<? echo($anmerkung_val); ?>"></td></form>
  </tr>
</table>
<?php 		} //ende else
		} //ende passwortprüfung 
	else{
		echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!",$sprache,$link));
		}
?>
</body>
</html>
