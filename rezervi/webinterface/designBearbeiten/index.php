<? session_start();
$root = "../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
/*   
			reservierungsplan
			startseite zur wartung des designs
			author: christian osterrieder utilo.eu						
*/

$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
$sprache = getSessionWert(SPRACHE);

//datenbank öffnen:
include_once("../../conf/rdbmsConfig.php");

//andere funktionen importieren:
include_once("../../include/benutzerFunctions.php");
include_once("../../include/unterkunftFunctions.php");
include_once($root."/include/propertiesFunctions.php");
include_once("../../include/zimmerFunctions.php");
//uebersetzer einfuegen:
include_once("../../include/uebersetzer.php");	

//should the reservation state be shown?
$showReservation = getPropertyValue(SHOW_RESERVATION_STATE,$unterkunft_id,$link);
if ($showReservation != "true"){
	$showReservation = false;
}
			
?>
<?php include_once("../templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../templates/headerB.php"); ?>
<script language="JavaScript">
	<!--
	    function sicher(){
	    	return confirm("<?php echo(getUebersetzung("Alle Änderungen verwerfen und auf Standardwerte zurücksetzen?",$sprache,$link)); ?>"); 	    
	    }
	    //-->
</script>
<?php include_once("../templates/bodyA.php"); ?>
<?php 
	//passwortprüfung:	
	if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){
?>
</p>

<table  border="0" cellpadding="0" cellspacing="3" class="table">
  <tr valign="top">
    <td width="1"><form action="./styles.php" method="post" target="_self">
		<input name="hintergrund" type="submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       		onMouseOut="this.className='button200pxA';" id="resEingebenAendern" value="<?php echo(getUebersetzung("Hintergrund",$sprache,$link)); ?>">
	   <input name="font_family" type="hidden" value="0">
	   <input name="font_size" type="hidden" value="0">
	   <input name="font_style" type="hidden" value="0">
	   <input name="font_weight" type="hidden" value="0">
	   <input name="text_align" type="hidden" value="0">
	   <input name="color" type="hidden" value="0">
	   <input name="border" type="hidden" value="0">
	   <input name="border_color" type="hidden" value="0">
	   <input name="background_color" type="hidden" value="1">
	   <input name="height" type="hidden" value="0">
	   <input name="width" type="hidden" value="0">
	   <input name="stylesheet" type="hidden" value="hintergrund">
    </form></td>
    <td><?php echo(getUebersetzung("Ändern der Hintergrundfarbe",$sprache,$link)); ?></td>
  </tr>
  <tr valign="top">
    <td><form action="./styles.php" method="post" target="_self">
	<input name="resEingebenAendern" type="submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" id="resEingebenAendern" value="<?php echo(getUebersetzung("Schrift",$sprache,$link)); ?>">
	   <input name="font_family" type="hidden" value="1">
	   <input name="font_size" type="hidden" value="1">
	   <input name="font_style" type="hidden" value="1">
	   <input name="font_weight" type="hidden" value="1">
	   <input name="text_align" type="hidden" value="1">
	   <input name="color" type="hidden" value="1">
	   <input name="border" type="hidden" value="0">
	   <input name="border_color" type="hidden" value="0">
	   <input name="background_color" type="hidden" value="0">
	   <input name="height" type="hidden" value="0">
	   <input name="width" type="hidden" value="0">
	   <input name="stylesheet" type="hidden" value="standardSchrift">
    </form></td>
    <td><?php echo(getUebersetzung("Ändern der Standard-Schrift (Farbe, Art, Größe, ...)",$sprache,$link)); ?></td>
  </tr>
  <tr valign="top">
    <td><form action="./styles.php" method="post" target="_self">
	<input name="ueberschrift" type="submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" id="resEingebenAendern" value="<?php echo(getUebersetzung("Überschrift",$sprache,$link)); ?>">
	   <input name="font_family" type="hidden" value="1">
	   <input name="font_size" type="hidden" value="1">
	   <input name="font_style" type="hidden" value="1">
	   <input name="font_weight" type="hidden" value="1">
	   <input name="text_align" type="hidden" value="1">
	   <input name="color" type="hidden" value="1">
	   <input name="border" type="hidden" value="0">
	   <input name="border_color" type="hidden" value="0">
	   <input name="background_color" type="hidden" value="0">
	   <input name="height" type="hidden" value="0">
	   <input name="width" type="hidden" value="0">
	   <input name="stylesheet" type="hidden" value="ueberschrift">
    </form></td>
    <td><?php echo(getUebersetzung("Ändern der Überschriften (Farbe, Art, Größe, ...)",$sprache,$link)); ?></td>
  </tr>
  <tr valign="top">
    <td><form action="./styles.php" method="post" target="_self">
	<input name="markierteSchrift" type="submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" id="resEingebenAendern" value="<?php echo(getUebersetzung("markierte Schrift",$sprache,$link)); ?>">
	   <input name="font_family" type="hidden" value="1">
	   <input name="font_size" type="hidden" value="1">
	   <input name="font_style" type="hidden" value="1">
	   <input name="font_weight" type="hidden" value="1">
	   <input name="text_align" type="hidden" value="1">
	   <input name="color" type="hidden" value="1">
	   <input name="border" type="hidden" value="0">
	   <input name="border_color" type="hidden" value="0">
	   <input name="background_color" type="hidden" value="0">
	   <input name="height" type="hidden" value="0">
	   <input name="width" type="hidden" value="0">
	   <input name="stylesheet" type="hidden" value="markierteSchrift">
    </form></td>
    <td><?php echo(getUebersetzung("Ändern der markierten Schrift",$sprache,$link)); ?></td>
  </tr>
  <tr valign="top">
    <td><form action="./styles.php" method="post" target="_self">
	<input name="buttonA" type="submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" id="resEingebenAendern" value="<?php echo(getUebersetzung("Button",$sprache,$link)); ?>">
	   <input name="font_size" type="hidden" value="1">
	   <input name="font_style" type="hidden" value="1">
	   <input name="font_weight" type="hidden" value="1">
	   <input name="text_align" type="hidden" value="1">
	   <input name="color" type="hidden" value="1">
	   <input name="border" type="hidden" value="1">
	   <input name="border_color" type="hidden" value="1">
	   <input name="background_color" type="hidden" value="1">
	   <input name="height" type="hidden" value="1">
	   <input name="width" type="hidden" value="1">
	   <input name="stylesheet" type="hidden" value="buttonA">
    </form></td>
    <td><?php echo(getUebersetzung("Ändern des Buttons",$sprache,$link)); ?></td>
  </tr>
  <tr valign="top">
    <td><form action="./styles.php" method="post" target="_self">
		<input name="buttonB" type="submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" id="resEingebenAendern" value="<?php echo(getUebersetzung("Button rollover",$sprache,$link)); ?>">
	   <input name="font_size" type="hidden" value="1">
	   <input name="font_style" type="hidden" value="1">
	   <input name="font_weight" type="hidden" value="1">
	   <input name="text_align" type="hidden" value="1">
	   <input name="color" type="hidden" value="1">
	   <input name="border" type="hidden" value="1">
	   <input name="border_color" type="hidden" value="1">
	   <input name="background_color" type="hidden" value="1">
	   <input name="height" type="hidden" value="1">
	   <input name="width" type="hidden" value="1">
	   <input name="stylesheet" type="hidden" value="buttonB">
	   </form>
    </td>
    <td><?php echo(getUebersetzung("Ändern des Buttons der angezeigt wird, wenn die Maus darüber bewegt wird",$sprache,$link)); ?></td>
  </tr>
  <tr valign="top">
    <td><form action="./styles.php" method="post" target="_self">
		<input name="tabelle" type="submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" id="resEingebenAendern" value="<?php echo(getUebersetzung("Tabelle",$sprache,$link)); ?>">
	   <input name="font_size" type="hidden" value="1">
	   <input name="font_style" type="hidden" value="1">
	   <input name="font_weight" type="hidden" value="1">
	   <input name="text_align" type="hidden" value="1">
	   <input name="color" type="hidden" value="1">
	   <input name="border" type="hidden" value="1">
	   <input name="border_color" type="hidden" value="1">
	   <input name="background_color" type="hidden" value="1">
	   <input name="height" type="hidden" value="0">
	   <input name="width" type="hidden" value="0">
	   <input name="stylesheet" type="hidden" value="tabelle">
	   </form>
    </td>
    <td><?php echo(getUebersetzung("Ändern der Tabelle (Hintergrundfarbe, Schriftfarbe, Rahmen, etc.)",$sprache,$link)); ?></td>
  </tr>
  <tr valign="top">
    <td><form action="./styles.php" method="post" target="_self">
	<input name="tabelleColor" type="submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" id="resEingebenAendern" value="<?php echo(getUebersetzung("färbige Tabelle",$sprache,$link)); ?>">
	   <input name="font_size" type="hidden" value="1">
	   <input name="font_style" type="hidden" value="1">
	   <input name="font_weight" type="hidden" value="1">
	   <input name="text_align" type="hidden" value="1">
	   <input name="color" type="hidden" value="1">
	   <input name="border" type="hidden" value="1">
	   <input name="border_color" type="hidden" value="1">
	   <input name="background_color" type="hidden" value="1">
	   <input name="height" type="hidden" value="0">
	   <input name="width" type="hidden" value="0">
	   <input name="stylesheet" type="hidden" value="tabelleColor">
	   </form>
    </td>
    <td><?php echo(getUebersetzung("Ändern der färbigen Tabellen",$sprache,$link)); ?></td>
  </tr>
  <tr valign="top">
    <td><form action="./styles.php" method="post" target="_self">
	<input name="belegt" type="submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" id="resEingebenAendern" value="<?php echo(getUebersetzung("belegt",$sprache,$link)); ?>">
	   <input name="font_size" type="hidden" value="1">
	   <input name="font_style" type="hidden" value="1">
	   <input name="font_weight" type="hidden" value="1">
	   <input name="text_align" type="hidden" value="1">
	   <input name="color" type="hidden" value="1">
	   <input name="border" type="hidden" value="1">
	   <input name="border_color" type="hidden" value="1">
	   <input name="background_color" type="hidden" value="1">
	   <input name="height" type="hidden" value="0">
	   <input name="width" type="hidden" value="0">
	   <input name="stylesheet" type="hidden" value="belegt">
	   </form>
    </td>
    <td><?php echo(getUebersetzung("Ändern der Farbe der belegt-Anzeige",$sprache,$link)); ?></td>
  </tr>
  <tr valign="top">
    <td><form action="./styles.php" method="post" target="_self">
	<input name="samstagBelegt" type="submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" id="resEingebenAendern" value="<?php echo(getUebersetzung("Samstag belegt",$sprache,$link)); ?>">
	   <input name="font_size" type="hidden" value="1">
	   <input name="font_style" type="hidden" value="1">
	   <input name="font_weight" type="hidden" value="1">
	   <input name="text_align" type="hidden" value="1">
	   <input name="color" type="hidden" value="1">
	   <input name="border" type="hidden" value="1">
	   <input name="border_color" type="hidden" value="1">
	   <input name="background_color" type="hidden" value="1">
	   <input name="height" type="hidden" value="0">
	   <input name="width" type="hidden" value="0">
	   <input name="stylesheet" type="hidden" value="samstagBelegt">
	   </form>
    </td>
    <td><?php echo(getUebersetzung("Ändern der Farbe der Samstag belegt-Anzeige",$sprache,$link)); ?></td>
  </tr>
  <tr valign="top">
    <td><form action="./styles.php" method="post" target="_self">
	<input name="frei" type="submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" id="resEingebenAendern" value="<?php echo(getUebersetzung("frei",$sprache,$link)); ?>">
	   <input name="font_size" type="hidden" value="1">
	   <input name="font_style" type="hidden" value="1">
	   <input name="font_weight" type="hidden" value="1">
	   <input name="text_align" type="hidden" value="1">
	   <input name="color" type="hidden" value="1">
	   <input name="border" type="hidden" value="1">
	   <input name="border_color" type="hidden" value="1">
	   <input name="background_color" type="hidden" value="1">
	   <input name="height" type="hidden" value="0">
	   <input name="width" type="hidden" value="0">
	   <input name="stylesheet" type="hidden" value="frei">
	   </form>
    </td>
    <td><?php echo(getUebersetzung("Ändern der Farbe der frei-Anzeige",$sprache,$link)); ?></td>
  </tr>
   <tr valign="top">
    <td><form action="./styles.php" method="post" target="_self">
	<input name="samstagFrei" type="submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" id="resEingebenAendern" value="<?php echo(getUebersetzung("Samstag frei",$sprache,$link)); ?>">
	   <input name="font_size" type="hidden" value="1">
	   <input name="font_style" type="hidden" value="1">
	   <input name="font_weight" type="hidden" value="1">
	   <input name="text_align" type="hidden" value="1">
	   <input name="color" type="hidden" value="1">
	   <input name="border" type="hidden" value="1">
	   <input name="border_color" type="hidden" value="1">
	   <input name="background_color" type="hidden" value="1">
	   <input name="height" type="hidden" value="0">
	   <input name="width" type="hidden" value="0">
	   <input name="stylesheet" type="hidden" value="samstagFrei">
	   </form>
    </td>
    <td><?php echo(getUebersetzung("Ändern der Farbe der Samstag frei-Anzeige",$sprache,$link)); ?></td>
  </tr>
  <?php
  if ($showReservation){
  ?>
  <tr valign="top">
    <td><form action="./styles.php" method="post" target="_self">
	<input name="reserviert" type="submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" id="resEingebenAendern" value="<?php echo(getUebersetzung("reserviert",$sprache,$link)); ?>">
	   <input name="font_size" type="hidden" value="1">
	   <input name="font_style" type="hidden" value="1">
	   <input name="font_weight" type="hidden" value="1">
	   <input name="text_align" type="hidden" value="1">
	   <input name="color" type="hidden" value="1">
	   <input name="border" type="hidden" value="1">
	   <input name="border_color" type="hidden" value="1">
	   <input name="background_color" type="hidden" value="1">
	   <input name="height" type="hidden" value="0">
	   <input name="width" type="hidden" value="0">
	   <input name="stylesheet" type="hidden" value="reserviert">
	   </form>
    </td>
    <td><?php echo(getUebersetzung("Ändern der Farbe der reserviert-Anzeige",$sprache,$link)); ?></td>
  </tr>
   <tr valign="top">
    <td><form action="./styles.php" method="post" target="_self">
	<input name="samstagReserviert" type="submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" id="resEingebenAendern" value="<?php echo(getUebersetzung("Samstag reserviert",$sprache,$link)); ?>">
	   <input name="font_size" type="hidden" value="1">
	   <input name="font_style" type="hidden" value="1">
	   <input name="font_weight" type="hidden" value="1">
	   <input name="text_align" type="hidden" value="1">
	   <input name="color" type="hidden" value="1">
	   <input name="border" type="hidden" value="1">
	   <input name="border_color" type="hidden" value="1">
	   <input name="background_color" type="hidden" value="1">
	   <input name="height" type="hidden" value="0">
	   <input name="width" type="hidden" value="0">
	   <input name="stylesheet" type="hidden" value="samstagReserviert">
	   </form>
    </td>
    <td><?php echo(getUebersetzung("Ändern der Farbe der Samstag reserviert-Anzeige",$sprache,$link)); ?></td>
  </tr>
  <?php
	} //end reservation state
  ?>
  <tr valign="top">
    <td><form action="./standardWerte.php" method="post" target="_self" onSubmit="return sicher()">
        <input name="standardwerte" type="submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" id="resEingebenAendern" value="<?php echo(getUebersetzung("Standardwerte setzen",$sprache,$link)); ?>">
        </form></td>
    <td><?php echo(getUebersetzung("Alle Änderungen werden auf die Rezervi-Standard-Werte zurückgesetzt.",$sprache,$link)); ?></td>
  </tr>
  <tr valign="top">
    <td>
	<input name="farbtabelle" type="submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" 
	   onClick="window.open('./farbtabelle.php','Farbtabelle','toolbar=no,menubar=no,scrollbars=yes,width=650,height=800')"
	   id="farbtabelle" value="<?php echo(getUebersetzung("Farbtabelle anzeigen",$sprache,$link)); ?>"></td>
    <td><?php echo(getUebersetzung("Zeigt eine Tabelle mit Farbcodes an, die im Design verwendet werden können.",$sprache,$link)); ?></td>
  </tr>
  <tr valign="top">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?php
//-----buttons um zurück zum menue zu gelangen: 
?>
<br/>
<table border="0" cellpadding="0" cellspacing="0" class="table">
  <tr>
    <td><form action="../inhalt.php" method="post" name="hauptmenue" target="_self" id="hauptmenue">
        <input name="retour" type="submit" class="button200pxA" id="retour" onMouseOver="this.className='button200pxB';"
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
