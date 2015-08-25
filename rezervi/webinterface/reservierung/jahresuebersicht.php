<? session_start();
$root = "../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
/*   
	reservierungsplan
	anzeige des kalenders
	author: christian osterrieder utilo.eu		
	
	dieser seite muss �bergeben werden:
	Unterkunft PK_ID ($unterkunft_id)
*/

//variablen initialisieren:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
$sprache = getSessionWert(SPRACHE);
$zimmer_id = $_POST["zimmer_id"];
$monat = 1;
$jahr = $_POST["jahr"];
setSessionWert(ZIMMER_ID,$zimmer_id);
$sprache = getSessionWert(SPRACHE);

//datenbank �ffnen:
include_once("../../conf/rdbmsConfig.php");

//funktions einbinden:
include_once("../../include/unterkunftFunctions.php");
include_once("../../include/uebersetzer.php");
include_once("../../include/zimmerFunctions.php");
include_once("../../include/datumFunctions.php");
include_once("../../include/reservierungFunctions.php");
include_once("../../include/gastFunctions.php");
include_once("../../include/benutzerFunctions.php");
include_once("../../include/uebersetzer.php");
//helper-funktionen einf�gen:
include_once("./jahresuebersichtHelper.php");

	include_once("../../include/propertiesFunctions.php");
	$saAktiviert = getPropertyValue(SHOW_OTHER_COLOR_FOR_SA,$unterkunft_id,$link);

	
?>
<?php include_once("../templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../templates/headerB.php"); ?>
<?php include_once("../templates/bodyA.php"); ?>
<script language="JavaScript" type="text/javascript" src="./rightJS.js">
</script>
<?php		
	//passwortpr�fung:	
	if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){ ?>

<table width="100%" border="0" class="tableColor">
  <tr>  
    <td class="standardSchriftBold"><?php echo(getUebersetzung("Belegungsplan",$sprache,$link)); ?> <? echo($jahr); ?>, 
      <?php echo(getUebersetzung("für",$sprache,$link)); ?> <?php echo(getUebersetzungUnterkunft(getZimmerArt($unterkunft_id,$zimmer_id,$link),"de",$unterkunft_id,$link)); ?> 
      <?php echo(getUebersetzungUnterkunft(getZimmerNr($unterkunft_id,$zimmer_id,$link),"de",$unterkunft_id,$link)); ?></td>
  </tr>
</table>
<br/>
<table width="100%" border="0" class="table">
  <tr>
    <td colspan="2"><?php			
			//monat ausgeben:
			showYear(1,$jahr,$unterkunft_id,$zimmer_id,$sprache,$saAktiviert,$link);			
		?>
    </td>
  </tr>
  <tr valign="middle">
    <td width="50%"><?php		
		$jah = $jahr-1;
		if (!($jah < getTodayYear()-4)){																					 																			
		?>
      <form action="./jahresuebersicht.php" method="post" name="monatZurueck" target="_self" id="monatZurueck">
        <div align="right">
          <input name="monat" type="hidden" id="monat" value="<? echo($monat); ?>">
          <input name="zimmer_id" type="hidden" id="zimmer_id" value="<? echo $zimmer_id ?>">
          <input name="jahr" type="hidden" id="jahr" value="<? echo($jah); ?>">
          <input name="zurueck" type="submit" class="btn btn-primary"  onClick="updateLeft(<?php echo(($monat).",".($jah).",".($zimmer_id)); ?>,0);" id="zurueck" value="<?php echo(getUebersetzung("ein Jahr zurück",$sprache,$link)); ?>">
        </div>
      </form>
      <?php } //ende if jahr 
	  ?></td>
    <td width="50%"><?php		
		$jah = $jahr+1;
		if (!($jah >= getTodayYear()+4)){																															
		?>
      <form action="./jahresuebersicht.php" method="post" name="monatWeiter" target="_self" id="monatWeiter">
        <input name="zimmer_id" type="hidden" id="zimmer_id" value="<? echo $zimmer_id ?>">
        <input name="jahr" type="hidden" id="jahr" value="<? echo ($jah); ?>">
        <input name="monat" type="hidden" id="monat" value="<? echo($monat); ?>">
        <input name="weiter" type="submit" class="btn btn-primary"  onClick="updateLeft(<?php echo(($monat).",".($jah).",".($zimmer_id)); ?>,1);" id="weiter" value="<?php echo(getUebersetzung("ein Jahr weiter",$sprache,$link)); ?>">
      </form>
      <?php } //ende if jahr 
	  ?></td>
  </tr>
  <tr valign="middle">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?php } //ende passwortpr�fung 
	else{
		echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortpr�fung fehlgeschlagen!",$sprache,$link));
		}
?>
</body>
</html>
