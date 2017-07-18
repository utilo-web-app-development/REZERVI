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
include_once("../../../include/propertiesFunctions.php");
include_once("../../../include/uebersetzer.php");
include_once("../../templates/components.php");
include_once("./templates/auth.php");

//variablen:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
$sprache = getSessionWert(SPRACHE);
$aktiviert = getPropertyValue(SHOW_OTHER_COLOR_FOR_SA, $unterkunft_id, $link);
if ($aktiviert != "true") {
    $aktiviert = false;
}
$showMonatsansicht = getPropertyValue(SHOW_MONATSANSICHT, $unterkunft_id, $link);
$showJahresansicht = getPropertyValue(SHOW_JAHRESANSICHT, $unterkunft_id, $link);
$showGesamtansicht = getPropertyValue(SHOW_GESAMTANSICHT, $unterkunft_id, $link);

?>
<?php include_once("../../templates/headerA.php"); ?>
    <style type="text/css">
        <?php include_once($root."/templates/stylesheetsIE9.php"); ?>
    </style>
<?php include_once("../../templates/headerB.php"); ?>
<?php include_once("../../templates/bodyA.php"); ?>

    <div class="panel panel-default">
    <div class="panel-heading">
        <h2><?php echo(getUebersetzung("Einstellungen für den Belegungsplan", $sprache, $link)); ?>.</h2>
    </div>
    <div class="panel-body">

<?php
//passwortprüfung:
if (checkPass($benutzername, $passwort, $unterkunft_id, $link)) {
    ?>

    <!-- Show message if there is -->
    <?php include_once("../../templates/message.php"); ?>


    <form role="form" action="./planAendern.php" method="post" target="_self" class="form-horizontal">
        <div class="row">
            <label class="label-control col-sm-4">
                <?php echo(getUebersetzung("Samstage andersfärbig anzeigen.", $sprache, $link)); ?>
            </label>
            <div class="col-sm-1">
                <input name="showSamstag" type="checkbox" id="showSamstag" value="true"
                    <?php
                    if ($aktiviert) {
                        echo(" checked=\"checked\"");
                    }
                    ?>
                >
                </div>

                <div class="col-sm-offset-5 col-sm-2" style="text-align: right;">
                    <button name="aendern" type="submit" class="btn btn-success" id="aendern">
                        <span class="glyphicon glyphicon-wrench"></span>
                        <?php echo(getUebersetzung("Ändern", $sprache, $link)); ?>
                    </button>
                </div>
        </div>

    </form>
    <div class="form-group">
        <hr>
    </div>
    <form action="./ansichtenAendern.inc.php" method="post" target="_self">
        <div class="row">
            <div class="col-sm-12">
                <h3><?php echo getUebersetzung("Ansichten anzeigen", $sprache, $link) ?></h3>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <label class="label-control">
                    <!-- Monatsübersicht   -->
                    <?php echo getUebersetzung("Monatsübersicht", $sprache, $link) ?>
                </label>
            </div>
            <div class="col-sm-1">
                <input name="showMonatsansicht" type="checkbox" id="showMonatsansicht" value="true"
                    <?php
                    if ($showMonatsansicht) {
                        echo(" checked=\"checked\"");
                    }
                    ?>
                />
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <label class="label-control">
                    <!-- Jahresübersicht -->
                    <?php echo getUebersetzung("Jahresübersicht", $sprache, $link) ?>
                </label>
            </div>
            <div class="col-sm-1">
                <input name="showJahresansicht" type="checkbox" id="showJahresansicht" value="true"
                    <?php
                    if ($showJahresansicht) {
                        echo(" checked=\"checked\"");
                    }
                    ?>
                />
                </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <label class="label-control">
                    <!-- Gesammtübersicht -->

                    <?php echo getUebersetzung("Gesamtübersicht", $sprache, $link) ?>
                </label>
            </div>
            <div class="col-sm-1">
                <input name="showGesamtansicht" type="checkbox" id="showGesamtansicht" value="true"
                    <?php
                    if ($showGesamtansicht) {
                        echo(" checked=\"checked\"");
                    }
                    ?>
                />

            </div>
        </div>

        <div class="row">
            <div class="col-sm-12" style="text-align: right;">
                <button name="aendern" type="submit" class="btn btn-success" id="aendern">
                    <span class="glyphicon glyphicon-wrench"></span>
                    <?php echo(getUebersetzung("Ändern", $sprache, $link)); ?>
                </button>
                <a href="../index.php" class="btn btn-default">
                    <?php echo(getUebersetzung("Zurück", $sprache, $link)); ?>
                </a>

            </div>
        </div>

    </form>

    <br/>

    <?php
} //ende if passwortprüfung
else {
    echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!", $sprache, $link));
}
?>
<?php include_once("../../templates/end.php"); ?>