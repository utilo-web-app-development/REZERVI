<?php session_start();
$root = "../../..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once($root . "/include/sessionFunctions.inc.php");
/*   
			reservierungsplan
			startseite zur wartung des designs
			author: christian osterrieder utilo.eu						
*/

//datenbank öffnen:
include_once("../../../conf/rdbmsConfig.php");

//andere funktionen importieren:
include_once("../../../include/benutzerFunctions.php");
include_once("../../../include/unterkunftFunctions.php");
include_once("../../../include/einstellungenFunctions.php");
include_once("../../../include/uebersetzer.php");
include_once("../../templates/components.php");

//variablen:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
$sprache = getSessionWert(SPRACHE);
//standard-sprache aus datenbank auslesen:
$standard = getStandardSprache($unterkunft_id, $link);
$standardBelegungsplan = getStandardSpracheBelegungsplan($unterkunft_id, $link);

?>
<?php include_once("../../templates/headerA.php"); ?>
    <style type="text/css">
        <?php include_once($root."/templates/stylesheetsIE9.php"); ?>
    </style>
<?php include_once("../../templates/headerB.php"); ?>
<?php include_once("../../templates/bodyA.php"); ?>
<?php
//passwortprüfung:
if (checkPass($benutzername, $passwort, $unterkunft_id, $link)) {
    ?>
    <div class="panel panel-default">
    <div class="panel-heading">
        <h2><?php echo(getUebersetzung("Ändern der Standard-Sprache", $sprache, $link)); ?>.</h2>
    </div>
    <div class="panel-body">

    <?php
    if (isset($nachricht) && $nachricht != "") {
        ?>
        <p class="lead"><?php echo($nachricht) ?> </p>
        <?php
    }
    ?>
    <form action="./spracheAendern.php" method="post" target="_self">
        <p class="lead"><?php echo(getUebersetzung("Bitte wählen sie die Standard-Sprache ihres Belegungsplanes", $sprache, $link)); ?>.</p>
        <p class="lead"><?php echo(getUebersetzung("Es werden hier nur Sprachen angeboten die unter dem Menüpunkt [Sprachen] ausgewählt wurden", $sprache, $link)); ?>.</p>
        <ul class="list-unstyled">
            <?php

            $res = getSprachen($unterkunft_id, $link);
            while ($d = mysqli_fetch_array($res)) {
                $spracheID = $d["Sprache_ID"];
                $bezeichnung = getBezeichnungOfSpracheID($spracheID, $link);
                ?>
                <li><input type="radio" name="standardspracheBelegungsplan" value="<?php echo($spracheID); ?>"
                        <?php if ($standardBelegungsplan == $spracheID) {
                            echo(" checked");
                        } ?>>
                    <label class="label-control"> <?php echo(getUebersetzung($bezeichnung, $sprache, $link)); ?></label>
                </li>
                <?php
            } //ende foreach
            ?>
        </ul>


        <p class="lead"><?php echo(getUebersetzung("Bitte wählen sie die Standard-Sprache ihres Webinterfaces", $sprache, $link)); ?>.</p>
        <ul class="list-unstyled">
            <?php
            $res = getSprachenForWebinterface($link);
            while ($d = mysqli_fetch_array($res)) {
                $bezeichnung = $d["Bezeichnung"];
                $spracheID = $d["Sprache_ID"];
                ?>

                <li><input type="radio" name="standardsprache" value="<?php echo($spracheID); ?>"
                        <?php if ($standard == $spracheID) {
                            echo(" checked");
                        } ?>>
                    <label class="label-control"> <?php echo(getUebersetzung($bezeichnung, $sprache, $link)); ?></label>
                </li>

                <?php
            } //ende foreach
            ?>

        </ul>
        <input type="checkbox" name="jetztWechseln" value="true" checked>
        <label
            class="label-control"><?php echo(getUebersetzung("Zur ausgewählten Sprache wechseln", $sprache, $link)); ?>.</label>

        <?php showSubmitButton(getUebersetzung("ändern", $sprache, $link)); ?>

    </form>
    <br/>
    <!-- <?php
    //-----buttons um zurück zum menue zu gelangen:
    showSubmitButtonWithForm("../index.php", getUebersetzung("zurück", $sprache, $link));
    ?>
<br/>
<?php
    //-----buttons um zurück zum menue zu gelangen:
    showSubmitButtonWithForm("../../inhalt.php", getUebersetzung("Hauptmenü", $sprache, $link));
    ?> -->
    <?php
} //ende if passwortprüfung
else {
    echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!", $sprache, $link));
}
?>
<?php include_once("../../templates/end.php"); ?>