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
//funktionen zum versenden von e-mails:
include_once($root . "/include/mail.inc.php");
//variablen:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort      = getSessionWert(PASSWORT);
$benutzername  = getSessionWert(BENUTZERNAME);
$an            = $_POST["an"];
$von           = $_POST["von"];
$subject       = $_POST["subject"];
$message       = $_POST["message"];
$sprache       = getSessionWert(SPRACHE);

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

//datenbank öffnen:
include_once("../../conf/rdbmsConfig.php");

//andere funktionen importieren:
include_once("../../include/benutzerFunctions.php");
include_once("../../include/unterkunftFunctions.php");
include_once("../../include/propertiesFunctions.php");
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
            <h3>
				<?php echo(getUebersetzung("Anfrage Bestätigung", $sprache, $link)); ?>
            </h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="alert frei">
                        <label>
	                        <?php echo(getUebersetzung("Der Gast wurde per E-Mail verständigt", $sprache, $link)); ?>.
                        </label>
                    </div>
                </div>
            </div>
			<?php
			//mail($an, unhtmlentities($subject), unhtmlentities($message), "From: $von\nReply-To: $von\nX-Mailer: PHP/" . phpversion());
			if (!sendMail($von, $an, $subject, $message))
			{
				?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="alert alert-danger">
							<?php echo(getUebersetzung("Email wurde nicht gesendet", $sprache, $link)); ?>
                        </div>
                    </div>
                </div>
				<?php
			}
			if (getPropertyValue(MAIL_KOPIE_AN_VERMIETER_BESTAETIGUNG, $unterkunft_id, $link) == "true")
			{
				$message = getUebersetzung("Folgende Nachricht wurde an ihren Gast versendet", $sprache, $link) . ":\n\n" . $message;
				//mail($von, unhtmlentities($subject), unhtmlentities($message), "From: $von\nReply-To: $von\nX-Mailer: PHP/" . phpversion());

				if (!sendMail($von, $von, $subject, $message))
				{
					?>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="alert alert-danger">
								<?php echo(getUebersetzung("Email wurde nicht gesendet", $sprache, $link)); ?>
                            </div>
                        </div>
                    </div>
					<?php
				}
			}
			?>
            <div class="row">
                <div class="col-sm-12">
                    <a class="btn btn-success" href="../inhalt.php">
	                    <?php echo(getUebersetzung("Hauptmenü", $sprache, $link)); ?>
                    </a>
                    <a class="btn btn-primary" href="index.php">
		                <?php echo(getUebersetzung("Zurück", $sprache, $link)); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
	<?php
} //ende if passwortprüfung
else
{
    ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3>
			<?php echo(getUebersetzung("Anfrage Bestätigung", $sprache, $link)); ?>
        </h3>
    </div>
    <div class="panel-body">
        <?php
	echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!", $sprache, $link));
	?>
    </div>
</div>
<?php
}
?>
</body>
</html>
