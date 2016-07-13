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
$anrede = $_POST["anrede"];
$vorname = $_POST["vorname"];
$nachname = $_POST["nachname"];
$strasse = $_POST["strasse"];
$plz = $_POST["plz"];
$ort = $_POST["ort"];
$land = $_POST["land"];
$email = $_POST["email"];
$tel = $_POST["tel"];
$fax = $_POST["fax"];
$speech = $_POST["speech"];
$anmerkung = $_POST["anmerkung"];
$gast_id = $_POST["gast_id"];
$sprache = getSessionWert(SPRACHE);
$index = $_POST["index"];

//datenbank öffnen:
include_once("../../../../conf/rdbmsConfig.php");

//funktions einbinden:
include_once("../../../../include/unterkunftFunctions.php");
include_once("../../../../include/gastFunctions.php");
include_once("../../../../include/benutzerFunctions.php");	
//uebersetzer einfuegen:
include_once("../../../../include/uebersetzer.php");
	
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
					Anmerkung = '$anmerkung',
					Sprache = '$speech'
					WHERE
					PK_ID = '$gast_id'";
					
		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
		}
		else {	
	?>


<table  border="0" cellspacing="3" cellpadding="0" class="frei">
  <tr>
    <td><?php echo(getUebersetzung("Die Daten des Gastes wurden erfolgreich geändert",$sprache,$link)); ?>!</td>
  </tr>
</table>
<br/>
<table  border="0" cellspacing="3" cellpadding="0" class="table">
  <tr><form action="../../../inhalt.php" method="post" name="hauptmenue" target="_self" id="hauptmenue"> 
    <td width="1"> 
      <input type="submit" name="Submit3" value="<?php echo(getUebersetzung("Hauptmenü",$sprache,$link)); ?>" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';"></td></form>
	   <form action="../index.php" method="post" name="zurueck" target="_self" id="zurueck">
    <td> 
       
        <input type="submit" name="Submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("zurück",$sprache,$link)); ?>">
        <input name="anrede_val" type="hidden" id="anrede_var" value="<?php echo($anrede_val); ?>"> 
        <input name="vorname_val" type="hidden" id="vorname_var3" value="<?php echo($vorname_val); ?>"> 
        <input name="nachname_val" type="hidden" id="anrede_var4" value="<?php echo($nachname_val); ?>"> 
        <input name="strasse_val" type="hidden" id="anrede_var5" value="<?php echo($strasse_val); ?>"> 
        <input name="ort_val" type="hidden" id="anrede_var6" value="<?php echo($ort_val); ?>"> 
        <input name="land_val" type="hidden" id="anrede_var7" value="<?php echo($land_val); ?>"> 
        <input name="email_val" type="hidden" id="anrede_var8" value="<?php echo($email_val); ?>"> 
        <input name="tel_val" type="hidden" id="anrede_var9" value="<?php echo($tel_val); ?>"> 
        <input name="fax_val" type="hidden" id="anrede_var" value="<?php echo($fax_val); ?>"> 
        <input name="anmerkung_val" type="hidden" id="anrede_var" value="<?php echo($anmerkung_val); ?>">
		<input name="gast_id" type="hidden" id="gast_id" value="<?php echo($gast_id); ?>">
		<input name="sprache_val" type="hidden" id="anrede_var" value="<?php echo($sprache_val); ?>">
        <input name="plz_val" type="hidden" id="plz_val" value="<?php echo($plz_val); ?>">
		<input name="index" type="hidden" value="<?php echo($index); ?>"/>
		
	</td></form>
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
