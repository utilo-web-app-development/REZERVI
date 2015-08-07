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

//variablen:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
$sprache = getSessionWert(SPRACHE);

//datenbank �ffnen:
include_once("../../conf/rdbmsConfig.php");

//andere funktionen importieren:
include_once("../../include/benutzerFunctions.php");
include_once("../../include/unterkunftFunctions.php");
include_once("../../include/uebersetzer.php");
include_once("../templates/components.php"); 	
			
?>
<?php include_once("../templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../templates/headerB.php"); ?>
<?php include_once("../templates/bodyA.php"); ?>
<?php 
	//passwortpr�fung:	
	if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){
?>
<p class="standardSchriftBold"><?php echo(getUebersetzung("diverse Einstellungen",$sprache,$link)); ?></p>
<?php 
if (isset($nachricht) && $nachricht != ""){
?>
	<table  border="0" cellpadding="0" cellspacing="3" class="table">
	  <tr>
		<td><?php echo($nachricht) ?></td>
	  </tr>
	</table>
	<br/>
<?php 
}
?>
<table  border="0" cellpadding="0" cellspacing="3" class="table">
  <form action="./sprachen/sprachen.php" method="post" target="_self">
  <tr>
    <td><?php showSubmitButton(getUebersetzung("Sprachen",$sprache,$link)); ?></td>
    <td><?php echo(getUebersetzung("�ndern der zur Auswahl stehenden Sprachen ihres Belegungsplanes",$sprache,$link)); ?>.</td>
  </tr>
  </form>
  <form action="./standardSprache/index.php" method="post" target="_self">
  <tr>
    <td><?php showSubmitButton(getUebersetzung("Standard-Sprache",$sprache,$link)); ?></td>
    <td><?php echo(getUebersetzung("�ndern der Standard-Sprache des Belegungsplanes und Webinterfaces",$sprache,$link)); ?>.</td>
  </tr>
  </form>
  <form action="./frame/index.php" method="post" target="_self">
    <tr>
      <td><?php showSubmitButton(getUebersetzung("Frames",$sprache,$link)); ?></td>
      <td><?php echo(getUebersetzung("�ndern der Standard-Framegr��en des Belegungsplanes",$sprache,$link)); ?>.</td>
    </tr>
  </form>	
  <form action="./suche/index.php" method="post" target="_self">
    <tr>
	  <td><?php showSubmitButton(getUebersetzung("Suche",$sprache,$link)); ?></td>
      <td><?php echo(getUebersetzung("�ndern der Suchoptionen",$sprache,$link)); ?>.</td>
    </tr>
  </form>
  <form action="./buchungseinschraenkungen/index.php" method="post" target="_self">
  <tr>
    <td><?php showSubmitButton(getUebersetzung("Buchung einschr�nken",$sprache,$link)); ?></td>
    <td><?php echo(getUebersetzung("Einschr�nken von Buchungen innerhalb eines bestimmten Zeitraumes",$sprache,$link)); ?>.</td>
   </tr>
   </form>
   <form action="./bilder/index.php" method="post" target="_self">
	  <tr>
	    <td><?php showSubmitButton(getUebersetzung("Bilder",$sprache,$link)); ?></td>
	    <td><?php echo(getUebersetzung("Einstellungen f�r Bilder der Zimmer",$sprache,$link)); ?>.</td>
	  </tr>
    </form>
	<form action="./belegungsplan/index.php" method="post" target="_self">
	  <tr>
	    <td><?php showSubmitButton(getUebersetzung("Belegungsplan",$sprache,$link)); ?></td>
	    <td><?php echo(getUebersetzung("Einstellungen f�r den Belegungsplan",$sprache,$link)); ?>.</td>
	  </tr>
    </form>
	<form action="./reservierungen/index.php" method="post" target="_self">
	  <tr>
	    <td><?php showSubmitButton(getUebersetzung("Reservierungen",$sprache,$link)); ?></td>
	    <td><?php echo(getUebersetzung("Einstellungen f�r Reservierungen",$sprache,$link)); ?>.</td>
	  </tr>
    </form>    
   	<form action="./buchungsformular/index.php" method="post" target="_self">
	  <tr>
	    <td><?php showSubmitButton(getUebersetzung("Buchungsformular",$sprache,$link)); ?></td>
	    <td><?php echo(getUebersetzung("Einstellungen f�r das Buchungsformular",$sprache,$link)); ?>.</td>
	  </tr>
    </form>
    </table>
<br/>
<?php 
	  //-----buttons um zur�ck zum menue zu gelangen: 
	  showSubmitButtonWithForm("../inhalt.php",getUebersetzung("Hauptmen�",$sprache,$link));
?>
<?php 
	} //ende if passwortpr�fung
	else {
		echo(getUebersetzung("Bitte Browser schlie�en und neu anmelden - Passwortpr�fung fehlgeschlagen!",$sprache,$link));
	}
 ?>
 <?php include_once("../templates/end.php"); ?>