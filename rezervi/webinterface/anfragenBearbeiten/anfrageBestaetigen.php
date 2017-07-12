<?php session_start();
$root = "../..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once($root . "/include/sessionFunctions.inc.php");
/*   
			reservierungsplan
			eine angefragte reservierung bestätigen - als belegt im plan eintragen
			author: christian osterrieder utilo.eu						
			
			dieser seite muss übergeben werden:
			Benutzer PK_ID $benutzer_id
			Reservierung PK_ID $reservierungs_id
			Unterkunft PK_ID $unterkunft_id
*/

//variablen:
$unterkunft_id    = getSessionWert(UNTERKUNFT_ID);
$passwort         = getSessionWert(PASSWORT);
$benutzername     = getSessionWert(BENUTZERNAME);
$reservierungs_id = $_POST["reservierungs_id"];
$reservierungen   = explode(",", $reservierungs_id);

//variablen initialisieren:
if (isset($_POST["ben"]) && isset($_POST["pass"]))
{
	$ben  = $_POST["ben"];
	$pass = $_POST["pass"];
}
else
{
	//aufruf kam innerhalb des webinterface:
	$ben  = getSessionWert(BENUTZERNAME);
	$pass = getSessionWert(PASSWORT);
}

if (isset($_POST["antwort"]))
{
	$antwort = $_POST["antwort"];
	$art     = $_POST["art"];
}
else
{
	$antwort = false;
}

$sprache = getSessionWert(SPRACHE);

//datenbank öffnen:
include_once("../../conf/rdbmsConfig.php");

//andere funktionen importieren:
include_once("../../include/benutzerFunctions.php");
include_once($root . '/include/zimmerFunctions.php');
include_once("../../include/datumFunctions.php");
include_once("../../include/unterkunftFunctions.php");
include_once("../../include/gastFunctions.php");
include_once("../../include/reservierungFunctions.php");
include_once("../../include/autoResponseFunctions.php");
include_once("../../include/priceFunctions.inc.php");
include_once("../../include/uebersetzer.php");
include_once("../templates/components.php");
//uebersetzer einfuegen:
include_once("../../include/uebersetzer.php");
$benutzer_id = -1;
if (isset($ben) && isset($pass))
{
	$benutzer_id = checkPassword($ben, $pass, $link);
}
if ($benutzer_id == -1)
{
	//passwortprüfung fehlgeschlagen, auf index-seite zurück:
	$fehlgeschlagen = true;
	header("Location: " . $URL . "webinterface/index.php?fehlgeschlagen=true"); /* Redirect browser */
	exit();
	//include_once("./index.php");
	//exit;
}
else
{
	$benutzername = $ben;
	$passwort     = $pass;
	setSessionWert(BENUTZERNAME, $benutzername);
	setSessionWert(PASSWORT, $passwort);

	//unterkunft-id holen:
	$unterkunft_id = getUnterkunftID($benutzer_id, $link);
	setSessionWert(UNTERKUNFT_ID, $unterkunft_id);
	setSessionWert(BENUTZER_ID, $benutzer_id);
}

?>
<?php include_once("../templates/headerA.php"); ?>
<style type="text/css">
    <?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../templates/headerB.php"); ?>
<?php include_once("../templates/bodyA.php"); ?>
<?php //passwortprüfung:	
if (checkPass($benutzername, $passwort, $unterkunft_id, $link))
{
	?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h1><?php echo(getUebersetzung("Reservierungsanfrage bestätigen", $sprache, $link)); ?></h1>
        </div>
        <div class="panel-body">

			<?php

			foreach ($reservierungen as $res_id)
			{

				//zuerst prüfen ob nicht mitlerweile eine andere buchung eingetragen wurde:
				$vonDatum = getDatumVon($res_id, $link);
				$bisDatum = getDatumBis($res_id, $link);

				$vonTag   = getTagFromSQLDate($vonDatum);
				$vonMonat = getMonatFromSQLDate($vonDatum);
				$vonJahr  = getJahrFromSQLDate($vonDatum);
				$bisTag   = getTagFromSQLDate($bisDatum);
				$bisMonat = getMonatFromSQLDate($bisDatum);
				$bisJahr  = getJahrFromSQLDate($bisDatum);

				$gast_id   = getGastID($res_id, $link);
				$zimmer_id = getZimmerID($res_id, $link);

				if (isRoomTaken($zimmer_id, $vonTag, $vonMonat, $vonJahr, $bisTag, $bisMonat, $bisJahr, $link))
				{
					?>
                    <div class="alert alert-info" role="alert">

                        <h4><?php echo(getUebersetzung("Zu dieser Zeit ist bereits eine Buchung eingetragen!", $sprache, $link)); ?></h4>
                        <h4><?php echo(getUebersetzung("Bitte löschen sie zuerst bereits vorhandene Buchungen zu diesem Datum!", $sprache, $link)); ?></h4>
                    </div>

					<?php
					//showSubmitButtonWithForm("./index.php", getUebersetzung("zurück", $sprache, $link));
				}
				else
				{
					//belegung eintragen
					changeReservationState($res_id, 2, $link);
				}
			}

			//soll der gast automatisch informiert werden?
			$speech  = "";
			$an      = "";
			$von     = "";
			$message = "";
			$subject = "";
			$preis   = 0;

			if ($antwort == "true")
			{

				foreach ($reservierungen as $res_id)
				{
					$preis += calculatePriceOfReservation($res_id);
				}

			}

			?>


            <div class="row" style="padding-bottom: 10px; ">
                <div class="col-sm-12">
					<?php echo(getUebersetzung("Die Reservierungsanfrage", $sprache, $link)); ?>
					<?php echo(getGuestVorname($gast_id, $link) . " " . getGuestNachname($gast_id, $link)); ?>

					<?php echo(getUebersetzung("von", $sprache, $link)); ?> <?php echo($vonDatum); ?>
					<?php echo(getUebersetzung("bis", $sprache, $link)); ?> <?php echo($bisDatum); ?>
					<?php echo(getUebersetzung("wurde erfolgreich als", $sprache, $link)); ?>
                    <span class="alert belegt" style="padding: 2px;">
                        <?php echo(getUebersetzung("belegt", $sprache, $link)); ?>
                    </span>
					<?php echo(getUebersetzung("in den Reservierungsplan aufgenommen", $sprache, $link)); ?>.

					<?php if ($antwort == "true")
					{

						$speech   = getGuestSprache($gast_id, $link);
						$gastName = getGuestNachname($gast_id, $link);
						$an       = getGuestEmail($gast_id, $link);
						$von      = getUnterkunftEmail($unterkunft_id, $link);
						$subject  = getUebersetzungUnterkunft(getMessageSubject($unterkunft_id, $art, $link), $speech, $unterkunft_id, $link);
						$anr      = getUebersetzungUnterkunft(getMessageAnrede($unterkunft_id, $art, $link), $speech, $unterkunft_id, $link);
						$message  = $anr . (" ") . ($gastName) . ("!\n\n");
						$bod      = getUebersetzungUnterkunft(getMessageBody($unterkunft_id, $art, $link), $speech, $unterkunft_id, $link);
						$message  .= $bod . ("\n\n");
						if (!empty($preis) && $preis > 0)
						{
							$pr      = getUebersetzung("Preis") . ": " . $preis . " " . getWaehrung($unterkunft_id);
							$message .= $pr;
							$message .= ("\n\n");
						}
						$unt     = getUebersetzungUnterkunft(getMessageUnterschrift($unterkunft_id, $art, $link), $speech, $unterkunft_id, $link);
						$message .= $unt;
					}
					?>
					<?php echo(getUebersetzung("Die folgende Mitteilung wird per E-Mail an Ihren Gast gesendet. Sie haben hier die Möglichkeiten noch Korrekturen vorzunehmen", $sprache, $link)); ?>
                    :
                </div>
            </div>


            <!-- <form action="./bestaetigungSenden.php" method="post" name="bestaetigungSenden" target="_self"> -->

            <form action="./bestaetigungSenden.php" method="post" name="bestaetigungSenden" target="_self"
                  onSubmit="return chkFormular();" class="form-horizontal">
                <input name="an" type="hidden" value="<?php echo($an); ?>">
                <input name="von" type="hidden" value="<?php echo($von); ?>">


                <div class="form-group">
                    <label for="anrede"
                           class="col-sm-2"><?php echo(getUebersetzung("Betreff", $sprache, $link)); ?> </label>
                    <div class="col-sm-10">
                        <input name="subject" type="text" id="subject_de" value="<?php echo($subject); ?>"
                               class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label for="anmerkungen"
                           class="col-sm-2"><?php echo(getUebersetzung("Text", $sprache, $link)); ?></label>
                    <div class="col-sm-10">
                        <textarea name="message" type="text" id="text_de" value="" class="form-control"
                                  style="height: 200px;">
                        </textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12" style="text-align: right;">
                        <input type="submit" name="absenden"
                               value="<?php echo(getUebersetzung("Absenden", $sprache, $link)); ?>"
                               class="btn btn-success" id="absenden"/>
                        <a class="btn btn-primary" href="./index.php">
							<?php echo(getUebersetzung("zurück", $sprache, $link)); ?>
                        </a>
                    </div>
                </div>

            </form>
        </div>
    </div>


	<?php
	//} //ende wenn noch keine buchung vorhanden
} //ende if passwortprüfung
else
{
	echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!", $sprache, $link));
}
?>

