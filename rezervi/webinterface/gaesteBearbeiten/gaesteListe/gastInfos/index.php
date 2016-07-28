<?php session_start();
$root = "../../../..";
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

$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
$anrede_val = $_POST["anrede_val"];
$vorname_val = $_POST["vorname_val"];
$nachname_val = $_POST["nachname_val"];
$strasse_val = $_POST["strasse_val"];
$plz_val = $_POST["plz_val"];
$ort_val = $_POST["ort_val"];
$land_val = $_POST["land_val"];
$email_val = $_POST["email_val"];
$tel_val = $_POST["tel_val"];
$fax_val = $_POST["fax_val"];
$sprache_val = $_POST["anmerkung_val"];
$anmerkung_val = $_POST["anmerkung_val"];
$gast_id = $_POST["gast_id"];
$sprache = getSessionWert(SPRACHE);
$index = $_POST["index"];

//datenbank öffnen:
include_once("../../../../conf/rdbmsConfig.php");
//funktions einbinden:
include_once("../../../../include/unterkunftFunctions.php");
include_once("../../../../webinterface/gaesteBearbeiten/gaesteListe/gastInfos/./helper.php");
include_once("../../../../include/gastFunctions.php");
include_once("../../../../include/benutzerFunctions.php");
include_once("../../../../include/zimmerFunctions.php");
//uebersetzer einfuegen:
include_once("../../../../include/uebersetzer.php");
include_once($root . "/include/propertiesFunctions.php");
include_once($root . "/include/reservierungFunctions.php");


?>
<?php include_once("../../../templates/headerA.php"); ?>
<style type="text/css">
    <?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../../../templates/headerB.php"); ?>
<?php include_once("../../../templates/bodyA.php"); ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h2><?php echo(getUebersetzung("Es liegen	folgende Reservierungen für den Gast vor (aufsteigend sortiert)", $sprache, $link)); ?>
        </h2>
    </div>
    <div class="panel-body">


        <?php
        //passwortprüfung:
        if (checkPass($benutzername, $passwort, $unterkunft_id, $link)) {
            ?>

            <?php
            $res = getReservationsOfGuest($gast_id, $link);
            if (!empty($res) && mysqli_affected_rows($link) > 0) {
                ?>
                <table border="0" cellpadding="0" cellspacing="3" class="table table-striped">
                    <thead>
                    <tr>
                        <th><?php echo(getUebersetzung("Reservierung von", $sprache, $link)); ?></th>
                        <th><?php echo(getUebersetzung("bis", $sprache, $link)); ?></th>
                        <th><?php echo(getUebersetzung("für", $sprache, $link)); ?></th>
                        <?php
                        if (getPropertyValue(PENSION_UEBERNACHTUNG, $unterkunft_id, $link) == "true") {
                            ?>
                            <th><?php echo getUebersetzung("Pension", $sprache, $link) ?></th>
                            <?php
                        }
                        ?>
                    </tr>
                    </thead>

                    <!-- ausgeben der reservierungen: -->
                    <?php
                    while ($d = mysqli_fetch_array($res)) {
                        //variablen auslesen:
                        $zimmer_id = $d["FK_Zimmer_ID"];
                        $zimmernr = getZimmerNr($unterkunft_id, $zimmer_id, $link);
                        $datumVon = $d["Datum_von"];
                        $datumBis = $d["Datum_bis"];
                        $pension = $d["Pension"];

                        if (hasParentSameReservation($d["PK_ID"])) {
                            continue;
                        }

                        ?>
                        <tr class="table">
                            <td><?php echo($datumVon); ?></td>
                            <td><?php echo($datumBis); ?></td>
                            <td><?php echo($zimmernr); ?></td>
                            <?php
                            if (getPropertyValue(PENSION_UEBERNACHTUNG, $unterkunft_id, $link) == "true") {
                                ?>
                                <td><?php echo $pension ?></td>
                                <?php
                            }
                            ?>
                        </tr>
                        <?php
                    } //ende while
                    ?>
                </table>
                <?php
            } //ende if reservations
            else {
                ?>
                <div
                    class="alert alert-danger"><?php echo(getUebersetzung("Keine Reservierungen für diesen Gast vorhanden.", $sprache, $link)); ?></div>

                <?php
            }
            ?>
            <div class="row">
                <div class="col-sm-offset-9 col-sm-2" style="text-align: right;">
                    <form action="../../../inhalt.php" method="post" name="hauptmenue" target="_self" id="hauptmenue">
                        <button type="submit" name="Submit3" class="btn btn-primary">
                            <span class="glyphicon glyphicon-home"></span>
                            <?php echo(getUebersetzung("Hauptmenü", $sprache, $link)); ?>
                        </button>
                    </form>
                </div>
                <div class="col-sm-1">
                    <form action="../index.php" method="post" name="ok" target="_self" id="ok">
                        <input type="submit" name="Submit" class="btn btn-primary" id="zurueck"
                               value="<?php echo(getUebersetzung("zurück", $sprache, $link)); ?>">
                        <input name="anrede_val" type="hidden" id="anrede_val" value="<?php echo($anrede_val); ?>">
                        <input name="vorname_val" type="hidden" id="vorname_val" value="<?php echo($vorname_val); ?>">
                        <input name="nachname_val" type="hidden" id="nachname_val"
                               value="<?php echo($nachname_val); ?>">
                        <input name="strasse_val" type="hidden" id="strasse_val" value="<?php echo($strasse_val); ?>">
                        <input name="ort_val" type="hidden" id="ort_val" value="<?php echo($ort_val); ?>">
                        <input name="land_val" type="hidden" id="land_val" value="<?php echo($land_val); ?>">
                        <input name="email_val" type="hidden" id="email_val" value="<?php echo($email_val); ?>">
                        <input name="tel_val" type="hidden" id="tel_val" value="<?php echo($tel_val); ?>">
                        <input name="fax_val" type="hidden" id="anrede_val" value="<?php echo($fax_val); ?>">
                        <input name="anmerkung_val" type="hidden" id="anrede_val"
                               value="<?php echo($anmerkung_val); ?>">
                        <input name="sprache_val" type="hidden" id="anrede_var" value="<?php echo($sprache_val); ?>">
                        <input name="plz_val" type="hidden" id="plz_val" value="<?php echo($plz_val); ?>">
                        <input name="index" type="hidden" value="<?php echo($index); ?>"/>
                    </form>
                </div>
            </div>

            <?php
        } //ende passwortprüfung
        else {
            echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!", $sprache, $link));
        } ?>
    </div>
</div>
</body>
</html>