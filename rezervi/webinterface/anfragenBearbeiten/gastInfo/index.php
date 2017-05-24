<?php session_start();
$root = "../../..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once($root . "/include/sessionFunctions.inc.php");
/*
		reservierungsplan
		gast-infos anzeigen und evt. ändern:
		author: christian osterrieder utilo.eu

		dieser seite muss übergeben werden:
		Gast PK_ID $gast_id
		$unterkunft_id
	*/

//variablen:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort      = getSessionWert(PASSWORT);
$benutzername  = getSessionWert(BENUTZERNAME);
$gast_id       = $_POST["gast_id"];
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
include_once("../../../conf/rdbmsConfig.php");

//funktions einbinden:
include_once("../../../include/unterkunftFunctions.php");
//include_once("../../../webinterface/include/zimmerFunctions.php");
include_once("../../../include/reservierungFunctions.php");
include_once("../../../include/gastFunctions.php");
include_once("../../../include/benutzerFunctions.php");
//uebersetzer einfuegen:
include_once("../../../include/uebersetzer.php");

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
<?php include_once("../../templates/headerA.php"); ?>
<!--link href="../templates/stylesheets.css" rel="stylesheet" type="text/css"-->
<style type="text/css">
    <?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../../templates/headerB.php"); ?>
<?php include_once("../../templates/bodyA.php"); ?>
<!-- dynamisches update der anzahl der tage für ein gewisses monat mit java-script: -->
<script language="JavaScript">
    <!--
    function zurueck() {
        history.back();
    }
    //-->
</script>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3>
			<?php echo(getUebersetzung("Informationen über den Gast", $sprache, $link)); ?>
        </h3>
    </div>
    <div class="panel-body">


		<?php
		//passwortprüfung:
		if (checkPass($benutzername, $passwort, $unterkunft_id, $link))
		{ ?>
            <form action="../index.php" method="post" name="form1" target="_self" class="form-horizontal">
                <div class="form-group">
                    <div class="col-sm-2">
                        <label>
							<?php echo(getUebersetzung("Anrede", $sprache, $link)); ?>
                        </label>
                    </div>
                    <div class="col-sm-10">
                        <input name="anrede" type="text" id="anrede" class="form-control"
                               value="<?php echo(getGuestAnrede($gast_id, $link)); ?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2">
                        <label>
							<?php echo(getUebersetzung("Vorname", $sprache, $link)); ?>
                        </label>
                    </div>
                    <div class="col-sm-10">
                        <input name="vorname" type="text" id="vorname" class="form-control"
                               value="<?php echo(getGuestVorname($gast_id, $link)); ?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2">
                        <label>
							<?php echo(getUebersetzung("Nachname", $sprache, $link)); ?>
                        </label>
                    </div>
                    <div class="col-sm-10">
                        <input name="nachname" type="text" id="nachname" class="form-control"
                               value="<?php echo(getGuestNachname($gast_id, $link)); ?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2">
                        <label>
							<?php echo(getUebersetzung("Straße/Hausnummer", $sprache, $link)); ?>
                        </label>
                    </div>
                    <div class="col-sm-10">
                        <input name="strasse" type="text" id="strasse" class="form-control"
                               value="<?php echo(getGuestStrasse($gast_id, $link)); ?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2">
                        <label>
							<?php echo(getUebersetzung("PLZ", $sprache, $link)); ?>
                        </label>
                    </div>
                    <div class="col-sm-10">
                        <input name="plz" type="text" id="plz" class="form-control"
                               value="<?php echo(getGuestPLZ($gast_id, $link)); ?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2">
                        <label>
							<?php echo(getUebersetzung("Ort", $sprache, $link)); ?>
                        </label>
                    </div>
                    <div class="col-sm-10">
                        <input name="ort" type="text" id="ort" class="form-control"
                               value="<?php echo(getGuestOrt($gast_id, $link)); ?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2">
                        <label>
							<?php echo(getUebersetzung("Land", $sprache, $link)); ?>
                        </label>
                    </div>
                    <div class="col-sm-10">
                        <input name="land" type="text" id="land" class="form-control"
                               value="<?php echo(getGuestLand($gast_id, $link)); ?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2">
                        <label>
							<?php echo(getUebersetzung("E-Mail-Adresse", $sprache, $link)); ?>
                        </label>
                    </div>
                    <div class="col-sm-10">
                        <input name="email" type="text" id="email" class="form-control"
                               value="<?php echo(getGuestEmail($gast_id, $link)); ?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2">
                        <label>
							<?php echo(getUebersetzung("Telefonnummer", $sprache, $link)); ?>
                        </label>
                    </div>
                    <div class="col-sm-10">
                        <input name="tel" type="text" id="tel" class="form-control"
                               value="<?php echo(getGuestTel($gast_id, $link)); ?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2">
                        <label>
							<?php echo(getUebersetzung("Faxnummer", $sprache, $link)); ?>
                        </label>
                    </div>
                    <div class="col-sm-10">
                        <input name="fax" type="text" id="fax" class="form-control"
                               value="<?php echo(getGuestFax($gast_id, $link)); ?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2">
                        <label>
							<?php echo(getUebersetzung("Anmerkungen", $sprache, $link)); ?>
                        </label>
                    </div>
                    <div class="col-sm-10">
                        <textarea name="anmerkungen" readonly="readonly" id="anmerkungen" class="form-control">
                            <?php echo(getGuestAnmerkung($gast_id, $link)); ?>
                        </textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="submit" name="Submit" class="btn btn-primary"
                               value="<?php echo(getUebersetzung("Zurück", $sprache, $link)); ?>">
                    </div>
                </div>
            </form>
		<?php } //ende passwortprüfung
		else
		{
			echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!", $sprache, $link));
		}
		?>
    </div>
</div>
</body>
</html>
