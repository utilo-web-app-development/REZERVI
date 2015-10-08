<?php session_start();
$root = "../../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");

//datenbank �ffnen:
include_once($root."/conf/rdbmsConfig.php");
include_once($root."/include/buchungseinschraenkung.php");
include_once($root."/include/uebersetzer.php");
include_once($root."/include/benutzerFunctions.php");
include_once($root."/include/unterkunftFunctions.php");
include_once($root."/webinterface/templates/components.php"); 
$sprache = getSessionWert(SPRACHE);
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$loeschen = false;
$hinzufuegen = false;
$bu_id = -1;
if (isset($_POST["add"]) && $_POST["add"] == getUebersetzung("hinzufügen",$sprache,$link)){
	$hinzufuegen = true;
}
else{
	$res = getBuchungseinschraenkungen($unterkunft_id);
	while ($d=mysql_fetch_array($res)){
		$id = $d["PK_ID"];
		//welche id soll gel�scht werden?
		if (isset($_POST["loeschen#".$id]) 
			&& $_POST["loeschen#".$id] == getUebersetzung("löschen",$sprache,$link)){
			$bu_id = $id;
			$loeschen = true;
			break;
		}
			
	}
}

$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$sprache = getSessionWert(SPRACHE);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);

?>
<?php include_once("../../templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../../templates/headerB.php"); ?>
<?php include_once("../../templates/bodyA.php"); ?>
<?php 
	//passwortpr�fung:	
	if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){
		
		//l�schen oder hinzufuegen:
		if ($loeschen && !$hinzufuegen){
			removeBuchungseinschraenkung($bu_id);
			$nachricht = "Der Datensatz wurde erfolgreich entfernt";
			$nachricht = getUebersetzung($nachricht,$sprache,$link);
		}
		else if ($hinzufuegen && !$loeschen){
			$von_wochentag = $_POST["von_wochentag"];
			$zimmer_id = $_POST["zimmer_id"];
			$bis_wochentag = $_POST["bis_wochentag"];
			$vonTag = $_POST["vonTag"];
			$bisTag = $_POST["bisTag"];
			$vonMonat=$_POST["vonMonat"];
			$bisMonat=$_POST["bisMonat"];
			$vonJahr =$_POST["vonJahr"];
			$bisJahr =$_POST["bisJahr"];
			//pruefen ob sich die buchungseinschr�nkung eh
			//nicht mit einer bereits bestehenden �berschneidet:
			if(hasBuchungseinschraenkung($vonTag,$vonMonat,$vonJahr,$bisTag,$bisMonat,$bisJahr,$zimmer_id)){
				$fehler = true;
				$nachricht = "Die Buchungseinschränkung überschneidet sich mit einer bereits existierenden!";
				$nachricht = getUebersetzung($nachricht,$sprache,$link);
			}
			else{
				$fehler = false;
				setBuchungseinschraenkung($zimmer_id,$von_wochentag,$bis_wochentag,$vonTag,$vonMonat,$vonJahr,$bisTag,$bisMonat,$bisJahr);
				$nachricht = "Der Datensatz wurde erfolgreich hinzugefögt";
				$nachricht = getUebersetzung($nachricht,$sprache,$link);
			}
		}
		
?>
<p class="standardSchriftBold"><?php echo(getUebersetzung("Einschränken von Buchungen innerhalb eines bestimmten Zeitraumes",$sprache,$link)); ?>.</p>
<?php 
if (isset($nachricht) && $nachricht != ""){
?>
	<table  border="0" cellpadding="0" cellspacing="3" <? if (isset($fehler) && $fehler == true) { ?> class="belegt" <? } else { ?> class="frei" <? } ?>>
	  <tr>
		<td><?php echo($nachricht) ?></td>
	  </tr>
	</table>
	<br/>
<?php 
}
?>
<br/>
<?php 
	  //-----buttons um zur�ck zum menue zu gelangen: 
	  showSubmitButtonWithForm("./index.php",getUebersetzung("zurück",$sprache,$link));
?>
<br/>
<?php 
	  //-----buttons um zur�ck zum menue zu gelangen: 
	  showSubmitButtonWithForm("../../inhalt.php",getUebersetzung("Hauptmenü",$sprache,$link));
?>
<?php 
	} //ende if passwortpr�fung
	else {
		echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!",$sprache,$link));
	}
 include_once("../../templates/end.php"); 
 ?>