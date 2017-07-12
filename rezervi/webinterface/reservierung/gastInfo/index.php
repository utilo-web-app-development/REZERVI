<?php session_start();
$root = "../../..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once($root . "/include/sessionFunctions.inc.php");
//variablen:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
if (isset($_POST["gast_id"])) {
    $gast_id = $_POST["gast_id"];
} elseif (isset($_GET["gast_id"])) {
    $gast_id = $_GET["gast_id"];
}
if (isset($_POST["jahr"])) {
    $jahr = $_POST["jahr"];
} elseif (isset($_GET["jahr"])) {
    $jahr = $_GET["jahr"];
}
if (isset($_POST["monat"])) {
    $monat = $_POST["monat"];
} elseif (isset($_GET["monat"])) {
    $monat = $_GET["monat"];
}
if (isset($_POST["zimmer_id"])) {
    $zimmer_id = $_POST["zimmer_id"];
} elseif (isset($_GET["zimmer_id"])) {
    $zimmer_id = $_GET["zimmer_id"];
}
$sprache = getSessionWert(SPRACHE);

/*
        reservierungsplan
        gast-infos anzeigen und evt. ändern:
        author: christian osterrieder utilo.eu

        dieser seite muss übergeben werden:
        Gast PK_ID $gast_id
        $unterkunft_id
    */

//datenbank öffnen:
include_once("../../../conf/rdbmsConfig.php");

//funktions einbinden:
include_once("../../../include/unterkunftFunctions.php");
//uebersetzer einfuegen:
include_once("../../../include/uebersetzer.php");
include_once("../../../include/reservierungFunctions.php");
include_once("../../../include/gastFunctions.php");
include_once("../../../include/benutzerFunctions.php");

//variablen initialisieren:
if (isset($_POST["ben"]) && isset($_POST["pass"])) {
	$ben = $_POST["ben"];
	$pass = $_POST["pass"];
} else {
	//aufruf kam innerhalb des webinterface:
	$ben = getSessionWert(BENUTZERNAME);
	$pass = getSessionWert(PASSWORT);
}

$benutzer_id = -1;
if (isset($ben) && isset($pass)) {
	$benutzer_id = checkPassword($ben, $pass, $link);
}
if ($benutzer_id == -1) {
	//passwortprüfung fehlgeschlagen, auf index-seite zurück:
	$fehlgeschlagen = true;
	header("Location: ".$URL."webinterface/index.php?fehlgeschlagen=true"); /* Redirect browser */
	exit();
	//include_once("./index.php");
	//exit;
} else {
	$benutzername = $ben;
	$passwort = $pass;
	setSessionWert(BENUTZERNAME, $benutzername);
	setSessionWert(PASSWORT, $passwort);

	//unterkunft-id holen:
	$unterkunft_id = getUnterkunftID($benutzer_id, $link);
	setSessionWert(UNTERKUNFT_ID, $unterkunft_id);
	setSessionWert(BENUTZER_ID, $benutzer_id);
}

?>
<?php include_once("../../templates/headerA.php"); ?>
<style type="text/css">
    <?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../../templates/headerB.php"); ?>
<!-- dynamisches update der anzahl der tage für ein gewisses monat mit java-script: -->
<script language="JavaScript">
    <!--
    function zurueck() {
        history.back();
    }
    //-->
</script>
<?php include_once("../../templates/bodyA.php"); ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h2><?php echo(getUebersetzung("Gäste-Information", $sprache, $link)); ?></h2>
    </div>
    <div class="panel-body">
        <?php
        //passwortprüfung:
        if (checkPass($benutzername, $passwort, $unterkunft_id, $link)) { ?>
            <p class="ueberschrift"></p>
            <form action="../index.php" method="post" name="form1" target="_self" class="form-horizontal">
                <div class="form-group">
                    <label for="anrede"
                           class="col-sm-2 control-label"><?php echo(getUebersetzung("Anrede", $sprache, $link)); ?></label>
                    <div class="col-sm-4">
                        <input name="anrede" type="text" id="anrede" readonly="readonly"
                               value="<?php echo(getGuestAnrede($gast_id, $link)); ?>" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="vorname" class="col-sm-2 control-label">
                        <?php echo(getUebersetzung("Vorname", $sprache, $link)); ?>*
                    </label>
                    <div class="col-sm-4">
                        <input name="vorname" type="text" id="vorname" readonly="readonly"
                               value="<?php echo(getGuestVorname($gast_id, $link)); ?>" class="form-control"
                               >
                    </div>
                </div>
                <div class="form-group">
                    <label for="nachname"
                           class="col-sm-2 control-label"><?php echo(getUebersetzung("Nachname", $sprache, $link)); ?>
                        *</label>
                    <div class="col-sm-4">
                        <input name="nachname" type="text" id="nachname" readonly="readonly"
                               value="<?php echo(getGuestNachname($gast_id, $link)); ?>" class="form-control"
                               >
                    </div>
                </div>
                <div class="form-group">
                    <label for="strasse"
                           class="col-sm-2 control-label"><?php echo(getUebersetzung("Straße/Hausnummer", $sprache, $link)); ?></label>
                    <div class="col-sm-4">
                        <input name="strasse" type="text" id="strasse" readonly="readonly"
                               value="<?php echo(getGuestStrasse($gast_id, $link)); ?>" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="plz"
                           class="col-sm-2 control-label"><?php echo(getUebersetzung("PLZ", $sprache, $link)); ?></label>
                    <div class="col-sm-4">
                        <input name="plz" type="text" id="plz" value="<?php echo(getGuestPLZ($gast_id, $link)); ?>"
                               readonly="readonly"
                               class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="ort"
                           class="col-sm-2 control-label"><?php echo(getUebersetzung("Ort", $sprache, $link)); ?></label>
                    <div class="col-sm-4">
                        <input name="ort" type="text" id="ort" value="<?php echo(getGuestOrt($gast_id, $link)); ?>"
                               readonly="readonly"
                               class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="land"
                           class="col-sm-2 control-label"><?php echo(getUebersetzung("Land", $sprache, $link)); ?></label>
                    <div class="col-sm-4">
                        <input name="land" type="text" id="land" value="<?php echo(getGuestLand($gast_id, $link)); ?>"
                               readonly="readonly"
                               class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="email"
                           class="col-sm-2 control-label"><?php echo(getUebersetzung("E-Mail-Adresse", $sprache, $link)); ?>
                        *</label>
                    <div class="col-sm-4">
                        <input name="email" type="text" id="email"
                               value="<?php echo(getGuestEmail($gast_id, $link)); ?>" class="form-control"
                               readonly="readonly">
                    </div>
                </div>
                <div class="form-group">
                    <label for="tel"
                           class="col-sm-2 control-label"><?php echo(getUebersetzung("Telefonnummer", $sprache, $link)); ?></label>
                    <div class="col-sm-4">
                        <input name="tel" type="text" id="tel" value="<?php echo(getGuestTel($gast_id, $link)); ?>"
                               readonly="readonly"
                               class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="fax"
                           class="col-sm-2 control-label"><?php echo(getUebersetzung("Faxnummer", $sprache, $link)); ?></label>
                    <div class="col-sm-4">
                        <input name="fax" type="text" id="fax" value="<?php echo(getGuestFax($gast_id, $link)); ?>"
                               readonly="readonly"
                               class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="speech"
                           class="col-sm-2 control-label"><?php echo(getUebersetzung("bevorzugte Sprache", $sprache, $link)); ?></label>
                    <div class="col-sm-4">
                        <input name="spr" type="text" id="spr" class="form-control" value="<?php
                        $speech = getGuestSprache($gast_id, $link);
                        if ($speech == "fr")
                            echo(getUebersetzung("Französisch", $sprache, $link));
                        else if ($speech == "en")
                            echo(getUebersetzung("Englisch", $sprache, $link));
                        else if ($speech == "it")
                            echo(getUebersetzung("Italienisch", $sprache, $link));
                        else if ($speech == "nl")
                            echo(getUebersetzung("Holländisch", $sprache, $link));
                        else if ($speech == "sp")
                            echo(getUebersetzung("Spanisch", $sprache, $link));
                        else if ($speech == "es")
                            echo(getUebersetzung("Estnisch", $sprache, $link));
                        else
                            echo(getUebersetzung("Deutsch", $sprache, $link)); ?>
														" readonly="readonly">
                    </div>
                </div>
                <div class="form-group">
                    <label for="anmerkungen"
                           class="col-sm-2 control-label"><?php echo(getUebersetzung("Anmerkungen", $sprache, $link)); ?></label>
                    <div class="col-sm-4">
                        <textarea name="anmerkungen" type="text" id="anmerkungen"
                                  value="<?php echo(getGuestAnmerkung($gast_id, $link)); ?>"
                                  class="form-control" readonly="readonly"></textarea>
                    </div>
                </div>


                <input name="zimmer_id" type="hidden" id="zimmer_id" value="<?php echo($zimmer_id); ?>">
                <input name="jahr" type="hidden" id="jahr" value="<?php echo($jahr); ?>">
                <input name="monat" type="hidden" id="monat" value="<?php echo($monat); ?>">
                <div class="row">
                    <div class="col-sm-offset-10 col-sm-2" style="text-align: right;">
                        <input type="submit" name="Submit" class="btn btn-primary"
                               value="<?php echo(getUebersetzung("zurück", $sprache, $link)); ?>">
                    </div>
                </div>
            </form>
        <?php } //ende passwortprüfung
        else {
            echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!", $sprache, $link));
        }
        ?>
    </div>
</div>
</body>
</html>
