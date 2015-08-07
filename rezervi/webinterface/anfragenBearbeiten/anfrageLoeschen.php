<?
session_start();
$root = "../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once ($root . "/include/sessionFunctions.inc.php");
/*   
			reservierungsplan
			startseite zur wartung der reservierung für den benutzer
			author: christian osterrieder utilo.eu						
			
			dieser seite muss übergeben werden:
			Benutzer PK_ID $benutzer_id
*/
//funktionen zum versenden von e-mails:
include_once ($root . "/include/mail.inc.php");

//variablen:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
$reservierungs_id = $_POST["reservierungs_id"];
$reservierungen = split(",", $reservierungs_id);

if (isset ($_POST["gastEntfernen"])) {
	$gastEntfernen = $_POST["gastEntfernen"];
} else {
	$gastEntfernen = false;
}
if (isset ($_POST["antwort"])) {
	$antwort = $_POST["antwort"];
} else {
	$antwort = false;
}
$art = $_POST["art"];
$sprache = getSessionWert(SPRACHE);

//datenbank öffnen:
include_once ("../../conf/rdbmsConfig.php");

//andere funktionen importieren:
include_once ("../../include/benutzerFunctions.php");
include_once ("../../include/unterkunftFunctions.php");
include_once ("../../include/gastFunctions.php");
include_once ("../../include/reservierungFunctions.php");
include_once ("../../include/zimmerFunctions.php");
include_once ("../../include/propertiesFunctions.php");
include_once ("../../include/autoResponseFunctions.php");
include_once ("../../include/uebersetzer.php");
include_once ("../templates/components.php");
//uebersetzer einfuegen:
include_once ("../../include/uebersetzer.php");
?>
<?php include_once("../templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../templates/headerB.php"); ?>
<?php include_once("../templates/bodyA.php"); ?>
<?php
 //passwortprüfung:	
if (checkPass($benutzername, $passwort, $unterkunft_id, $link)) {
?>
<p class="standardSchriftBold"><?php echo(getUebersetzung("Reservierungsanfragen von Gästen löschen",$sprache,$link)); ?></p>
<?php


	$gast_id = "";
	$vonDatum = "";
	$bisDatum = "";

	foreach ($reservierungen as $res_id) {

		$vonDatum = getDatumVon($res_id, $link);
		$bisDatum = getDatumBis($res_id, $link);
		$gast_id = getGastID($res_id, $link);
		$zimmer_id = getZimmerID($res_id, $link);
		deleteReservation($res_id, $link);
		//wenn room child rooms hat auch diese löschen:
		$resu = getChildRooms($zimmer_id);
		if (!empty ($resu)) {
			while ($d = mysql_fetch_array($resu)) {
				$child = $d['PK_ID'];
				deleteReservationWithDate($child, $vonDatum, $bisDatum, $link);
			}
		}

	}

	if ($gastEntfernen == "true") {
		//gast soll auch gelöscht werden:
		$query = ("SELECT
							FK_Gast_ID
						    FROM	
					   		Rezervi_Reservierung
					  		WHERE
					   		FK_Gast_ID = '$gast_id'
					   	  ");

		$res = mysql_query($query, $link);
		if (!$res) {
			echo ("die Anfrage $query scheitert");
			echo (mysql_error($link));
		} //ende if
		else {
			$d = mysql_fetch_array($res);
			$temp = $d["FK_Gast_ID"];
			if ($temp == "") {
				//gast kann gelöscht werden, es sind keine weiteren reservierungen vorhanden:
				$query = ("DELETE FROM	
							   				Rezervi_Gast
							   				WHERE
							   				PK_ID = '$gast_id'
							   			  ");

				$res = mysql_query($query, $link);
				if (!$res) {
					echo ("die Anfrage $query scheitert");
					echo (mysql_error($link));
				} else {
			?>
			<table  border="0" cellpadding="0" cellspacing="3" class="frei">
			  <tr>
			    <td><?php echo(getUebersetzung("Der Gast wurde aus der Datenbank entfernt",$sprache,$link)); ?>.</td>
			  </tr>
			</table>
			<?php

				} // ende if			
			} //ende if
			else {
				//der gast kann nicht entfernt werden
		?>
		<table  border="0" cellpadding="0" cellspacing="3" class="belegt">
		  <tr>
		    <td><?php echo(getUebersetzung("Der Gast kann nicht entfernt werden, es sind weitere Belegungen/Reservierungen für diesen Gast eingetragen",$sprache,$link)); ?>!</td>
		  </tr>
		</table>
		<p>
  		<?php
			}
		} //ende else
	} //ende if gastEntfernen
?>
</p>
<table  border="0" cellpadding="0" cellspacing="3" class="tableColor">
  <tr>
    <td><p class="frei"><?php echo(getUebersetzung("Die Reservierungsanfrage",$sprache,$link)); ?>
        <?php echo(getGuestVorname($gast_id,$link)." ".getGuestNachname($gast_id,$link)); ?>
        <br/>
        <?php echo(getUebersetzung("von",$sprache,$link)); ?> <?php echo($vonDatum); ?><br/>
        <?php echo(getUebersetzung("bis",$sprache,$link)); ?> <?php echo($bisDatum); ?><br/>
        <?php echo(getUebersetzung("wurde erfolgreich entfernt",$sprache,$link)); ?>.</p>

      <?php if ($antwort == "true"){ 
      	
		 $speech = getGuestSprache($gast_id,$link);
		 $gastName = getGuestNachname($gast_id,$link);
		 $an = getGuestEmail($gast_id,$link);
		 $von = getUnterkunftEmail($unterkunft_id,$link);		
		 $subject = getUebersetzungUnterkunft(getMessageSubject($unterkunft_id,$art,$link),$speech,$unterkunft_id,$link);
		 $anr = getUebersetzungUnterkunft(getMessageAnrede($unterkunft_id,$art,$link),$speech,$unterkunft_id,$link);
		 $message = $anr.(" ").($gastName).("!\n\n");
		 $bod = getUebersetzungUnterkunft(getMessageBody($unterkunft_id,$art,$link),$speech,$unterkunft_id,$link);
		 $message .= $bod.("\n\n");
		 
      ?>
      <p><?php echo(getUebersetzung("Die folgende Mitteilung wird per E-Mail an Ihren Gast gesendet. Sie haben hier die Möglichkeiten noch Korrekturen vorzunehmen",$sprache,$link)); ?>:</p>
      <form action="./bestaetigungSenden.php" method="post" name="bestaetigungSenden" target="_self">
        <input name="an" type="hidden" value="<?php echo($an); ?>">
        <input name="von" type="hidden" value="<?php echo($von); ?>">
        <table  border="0" cellpadding="0" cellspacing="3" class="tableColor">
          <tr valign="top">
            <td><?php echo(getUebersetzung("Betreff",$sprache,$link)); ?></td>
            <td><input name="subject" type="text" class="table" id="subject_de" value="<?php echo($subject); ?>" size="100"></td>
          </tr>
          <tr valign="top">
            <td><?php echo(getUebersetzung("Text",$sprache,$link)); ?></td>
            <td><textarea name="message" cols="100" rows="10" class="table" id="text_de"><?php echo($message); ?></textarea></td>
          </tr>
        </table>
        <br/>
        <?php

	//-----buttons um zurück zum menue zu gelangen: 
	showSubmitButton(getUebersetzung("absenden", $sprache, $link));
	} //ende if
	?>
      </form>
      </p>
      <br/>
      <?php
		showSubmitButtonWithForm("./index.php", getUebersetzung("zurück", $sprache, $link));
		?>
      <br/>
	<?php	
	showSubmitButtonWithForm("../inhalt.php", getUebersetzung("Hauptmenü", $sprache, $link));
	?>
    </td>
  </tr>
</table>
<?php

} //ende if passwortprüfung
else {
	echo (getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!", $sprache, $link));
}
?>
</body>
</html>
