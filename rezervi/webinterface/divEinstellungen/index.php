<?php session_start();
$root = "../..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once($root . "/include/sessionFunctions.inc.php");
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
    <div class="panel panel-default">
    <div class="panel-heading">
        <h2><?php echo(getUebersetzung("diverse Einstellungen", $sprache, $link)); ?></h2>
    </div>
    <div class="panel-body">

<?php
//passwortprüfung:
if (checkPass($benutzername, $passwort, $unterkunft_id, $link)) {
    ?>

    <?php
    if (isset($nachricht) && $nachricht != "") {
        ?>
        <div class="row">
            <div class="alert alert-info"><?php echo($nachricht) ?></div>
        </div>

        <?php
    }
    ?>

        <div class="row">
            <div class="col-sm-10">
                <label>
                    <?php echo(getUebersetzung("Ändern der zur Auswahl stehenden Sprachen ihres Belegungsplanes", $sprache, $link)); ?>.
                </label>
            </div>
            <div class="col-sm-2">
                <a href="./sprachen/sprachen.php " name="sprachen"  class="btn btn-primary" id="sprachen" style="width: 100%;">
                    <?php echo(getUebersetzung("Sprachen", $sprache, $link)); ?>
                </a>

            </div>
        </div>
    <br>
    <div class="row">
        <div class="col-sm-10">
            <label>
                <?php echo(getUebersetzung("Ändern der Standard-Sprache des Belegungsplanes und Webinterfaces", $sprache, $link)); ?>.
            </label>
        </div>
        <div class="col-sm-2">
            <a href="./standardSprache/index.php"  name="standard-Sprache"  class="btn btn-primary" id="standard-Sprache" style="width: 100%;">
                <?php echo(getUebersetzung("Standard-Sprache", $sprache, $link)); ?>
            </a>
        </div>
    </div>
    <br>

        <div class="row">
            <div class="col-sm-10">
                <label>
                <?php echo(getUebersetzung("ändern der Standard-Framegrößen des Belegungsplanes", $sprache, $link)); ?>.
                </label>
            </div>
            <div class="col-sm-2">
                <a href="./frame/index.php" name="frames"  class="btn btn-primary" id="frames" style="width: 100%;">
                    <?php echo(getUebersetzung("Frames", $sprache, $link)); ?>
                </a>
            </div>
        </div>
   <br>

        <div class="row">
            <div class="col-sm-10">
                <label>
                <?php echo(getUebersetzung("Ändern der Suchoptionen", $sprache, $link)); ?>.
                </label>
            </div>
            <div class="col-sm-2">
                <a href="./suche/index.php" name="suche"  class="btn btn-primary" id="suche" style="width: 100%;">
                    <?php echo(getUebersetzung("Suche", $sprache, $link)); ?>
                </a>
            </div>
        </div>
   <br>

        <div class="row">
            <div class="col-sm-10">
                <label>
                <?php echo(getUebersetzung("Einschränken von Buchungen innerhalb eines bestimmten Zeitraumes", $sprache, $link)); ?>.
                </label>
            </div>
            <div class="col-sm-2">
                <a  href="./buchungseinschraenkungen/index.php" name="buchungeinschränken" type="submit" class="btn btn-primary" id="buchungeinschränken" style="width: 100%;">
                    <?php echo(getUebersetzung("Buchung einschränken", $sprache, $link)); ?>
                </a>
            </div>
        </div>
   <br>

        <div class="row">
            <div class="col-sm-10">
                <label>
                <?php echo(getUebersetzung("Einstellungen für Bilder der Zimmer", $sprache, $link)); ?>.
                </label>
            </div>
            <div class="col-sm-2">
                <a href="./bilder/index.php" name="bilder" type="submit" class="btn btn-primary" id=bilder" style="width: 100%;">
                <?php echo(getUebersetzung("Bilder", $sprache, $link)); ?>
                </a>
            </div>
        </div>
    <br>

        <div class="row">
            <div class="col-sm-10">
                <label>
                <?php echo(getUebersetzung("Einstellungen für den Belegungsplan", $sprache, $link)); ?>.
                </label>
            </div>
            <div class="col-sm-2">
                <a href="./belegungsplan/index.php" name="belegungsplan" type="submit" class="btn btn-primary" id=belegungsplan" style="width: 100%;">
                    <?php echo(getUebersetzung("Belegungsplan", $sprache, $link)); ?>
                    </a>
            </div>
        </div>
<br>

        <div class="row">
            <div class="col-sm-10">
                <label>
                    <?php echo(getUebersetzung("Einstellungen für Reservierungen", $sprache, $link)); ?>.
                </label>
            </div>
            <div class="col-sm-2">
                <a href="./reservierungen/index.php"  name="reservierungen" type="submit" class="btn btn-primary" id=reservierungen" style="width: 100%;">
                    <?php echo(getUebersetzung("Reservierungen", $sprache, $link)); ?>
                    </a>
            </div>

        </div>

<br>
        <div class="row">
            <div class="col-sm-10">
                <label>
                <?php echo(getUebersetzung("Einstellungen für das Buchungsformular", $sprache, $link)); ?>.
                    </label>
            </div>
            <div class="col-sm-2">
                <a href="./buchungsformular/index.php" name="buchungsformular" type="submit" class="btn btn-primary" id=buchungsformular" style="width: 100%;">
                    <?php echo(getUebersetzung("Buchungsformular", $sprache, $link)); ?>
                    </a>
        </div>

    <?php
} //ende if passwortprüfung
else {
    echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!", $sprache, $link));
}
?>
<?php include_once("../templates/end.php"); ?>