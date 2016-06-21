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

//datenbank öffnen:
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
	//passwortprüfung:	
	if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){
?>
<!-- <p class="standardSchriftBold"><?php echo(getUebersetzung("diverse Einstellungen",$sprache,$link)); ?></p> -->
<h1><?php echo(getUebersetzung("diverse Einstellungen",$sprache,$link)); ?></h1>
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

	
  <!-- <form action="./sprachen/sprachen.php" method="post" target="_self"> -->
<div class="panel panel-default">
  <div class="panel-body">
	<form action="./sprachen/sprachen.php" method="post" name="sprachen" target="_self" onSubmit="return chkFormular();" class="form-horizontal">
  <tr>
    <td><?php showSubmitButton(getUebersetzung("Sprachen",$sprache,$link)); ?></td>
    <td><?php echo(getUebersetzung("Ändern der zur Auswahl stehenden Sprachen ihres Belegungsplanes",$sprache,$link)); ?>.</td>
  </tr>
  </form>
  <form action="./standardSprache/index.php" method="post" target="_self">
  <tr>
    <td><?php showSubmitButton(getUebersetzung("Standard-Sprache",$sprache,$link)); ?></td>
    <td><?php echo(getUebersetzung("ändern der Standard-Sprache des Belegungsplanes und Webinterfaces",$sprache,$link)); ?>.</td>
  </tr>
  </form>
  <form action="./frame/index.php" method="post" target="_self">
    <tr>
      <td><?php showSubmitButton(getUebersetzung("Frames",$sprache,$link)); ?></td>
      <td><?php echo(getUebersetzung("ändern der Standard-Framegrößen des Belegungsplanes",$sprache,$link)); ?>.</td>
    </tr>
  </form>	
  <form action="./suche/index.php" method="post" target="_self">
    <tr>
	  <td><?php showSubmitButton(getUebersetzung("Suche",$sprache,$link)); ?></td>
      <td><?php echo(getUebersetzung("ändern der Suchoptionen",$sprache,$link)); ?>.</td>
    </tr>
  </form>
  <form action="./buchungseinschraenkungen/index.php" method="post" target="_self">
  <tr>
    <td><?php showSubmitButton(getUebersetzung("Buchung einschränken",$sprache,$link)); ?></td>
    <td><?php echo(getUebersetzung("Einschränken von Buchungen innerhalb eines bestimmten Zeitraumes",$sprache,$link)); ?>.</td>
   </tr>
   </form>
   <form action="./bilder/index.php" method="post" target="_self">
	  <tr>
	    <td><?php showSubmitButton(getUebersetzung("Bilder",$sprache,$link)); ?></td>
	    <td><?php echo(getUebersetzung("Einstellungen für Bilder der Zimmer",$sprache,$link)); ?>.</td>
	  </tr>
    </form>
	<form action="./belegungsplan/index.php" method="post" target="_self">
	  <tr>
	    <td><?php showSubmitButton(getUebersetzung("Belegungsplan",$sprache,$link)); ?></td>
	    <td><?php echo(getUebersetzung("Einstellungen für den Belegungsplan",$sprache,$link)); ?>.</td>
	  </tr>
    </form>
	<form action="./reservierungen/index.php" method="post" target="_self">
	  <tr>
	    <td><?php showSubmitButton(getUebersetzung("Reservierungen",$sprache,$link)); ?></td>
	    <td><?php echo(getUebersetzung("Einstellungen für Reservierungen",$sprache,$link)); ?>.</td>
	  </tr>
    </form>    
   	<form action="./buchungsformular/index.php" method="post" target="_self">
	  <tr>
	    <td><?php showSubmitButton(getUebersetzung("Buchungsformular",$sprache,$link)); ?></td>
	    <td><?php echo(getUebersetzung("Einstellungen für das Buchungsformular",$sprache,$link)); ?>.</td>
	  </tr>
    </form>
    </table>

<?php 
	  //-----buttons um zurück zum menue zu gelangen: 
	  // showSubmitButtonWithForm("../inhalt.php",getUebersetzung("Hauptmenü",$sprache,$link));
?>
<?php 
	} //ende if passwortprüfung
	else {
		echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!",$sprache,$link));
	}
 ?>
 <?php include_once("../templates/end.php"); ?>