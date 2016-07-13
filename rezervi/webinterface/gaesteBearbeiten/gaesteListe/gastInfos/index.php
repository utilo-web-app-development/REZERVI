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
include_once("../../../../webinterface/gaesteBearbeiten/gaesteListe/gastInfos/./helper.php");	
include_once("../../../../include/gastFunctions.php");
include_once("../../../../include/benutzerFunctions.php");	
include_once("../../../../include/zimmerFunctions.php");	
//uebersetzer einfuegen:
include_once("../../../../include/uebersetzer.php");
include_once($root."/include/propertiesFunctions.php");
include_once($root."/include/reservierungFunctions.php");

	
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
<span class="standardSchriftBold"><?php echo(getUebersetzung("Es liegen	folgende Reservierungen für den Gast vor (aufsteigend sortiert)",$sprache,$link)); ?>:<br/>
<br/>
</span>
<?php
$res = getReservationsOfGuest($gast_id,$link);
if (!empty($res) && mysql_affected_rows($link)>0){
?>
<table  border="0" cellpadding="0" cellspacing="3" class="tableColor">
		  <tr class="tableColor">
			<td><?php echo(getUebersetzung("Reservierung von",$sprache,$link)); ?></td>
			<td><?php echo(getUebersetzung("bis",$sprache,$link)); ?></td>
			<td><?php echo(getUebersetzung("für",$sprache,$link)); ?></td>
			<?php 
  			if (getPropertyValue(PENSION_UEBERNACHTUNG,$unterkunft_id,$link) == "true"){
  			?>
				<td><?php echo getUebersetzung("Pension",$sprache,$link) ?></td>
			<?php
  			}
  			?>
  </tr>
	<!-- ausgeben der reservierungen: -->
	<?php
		while($d = mysql_fetch_array($res)){
			//variablen auslesen:
			$zimmer_id = $d["FK_Zimmer_ID"];
			$zimmernr = getZimmerNr($unterkunft_id,$zimmer_id,$link);
			$datumVon = $d["Datum_von"];
			$datumBis = $d["Datum_bis"];
			$pension = $d["Pension"];
			
			if (hasParentSameReservation($d["PK_ID"])){
				continue;
			}
			
			?>
              <tr class="table">
                <td><?php echo($datumVon); ?></td>
                <td><?php echo($datumBis); ?></td>
                <td><?php echo($zimmernr); ?></td>
                <?php 
	  			if (getPropertyValue(PENSION_UEBERNACHTUNG,$unterkunft_id,$link) == "true"){
	  			?>
					<td><?php echo $pension ?></td>
				<?php
	  			}
	  			?>
  </tr>
<?php 
		} //ende while
?>
</table>
<?php 
} //ende if reservations
else {
?>
<span class="standardSchriftBold"><?php echo(getUebersetzung("Keine Reservierungen für diesen Gast vorhanden.",$sprache,$link)); ?></span>
<br/>
<?php
}
?>
<br/>
<table border="0" cellspacing="3" cellpadding="0" class="table">
  <tr>
    <td>
      <form action="../index.php" method="post" name="ok" target="_self" id="ok">
        <input type="submit" name="Submit" class="button200pxA" id="zurueck" onMouseOver="this.className='button200pxB';"
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
		<input name="index" type="hidden" value="<?php echo($index); ?>"/>
      </form>      
    </td>
  </tr>
</table>
<table border="0" cellspacing="3" cellpadding="0" class="table">
  <tr>
    <form action="../../../inhalt.php" method="post" name="hauptmenue" target="_self" id="hauptmenue">
      <td width="1"><input type="submit" name="Submit3" value="<?php echo(getUebersetzung("Hauptmenü",$sprache,$link)); ?>" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';"></td>
    </form>
  </tr>
</table>
<?php
} //ende passwortprüfung 
else{ 
	echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!",$sprache,$link)); 
} ?>
</body>
</html>