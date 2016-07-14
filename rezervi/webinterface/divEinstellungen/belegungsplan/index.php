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
<?php
//passwortprüfung:
if (checkPass($benutzername, $passwort, $unterkunft_id, $link)) {
    ?>

    <?php
    if (isset($nachricht) && $nachricht != "") {
        ?>


        <?php if (isset($fehler) && $fehler == false) {
            echo("class=\"frei\"");
        } else {
            echo("class=\"belegt\"");
        } ?>><?php echo($nachricht) ?>


        <?php
    }
    ?>
    <div class="panel panel-default">
    <div class="panel-heading">
        <h2><?php echo(getUebersetzung("Einstellungen für den Belegungsplan", $sprache, $link)); ?>.</h2>
    </div>
    <div class="panel-body">

    <form role="form" action="./planAendern.php" method="post" target="_self">
        <div class="row">
            <label class="label-control col-sm-12">
                <input name="showSamstag" type="checkbox" id="showSamstag" value="true"
                    <?php
                    if ($aktiviert) {
                        echo(" checked=\"checked\"");
                    }
                    ?>
                >
                <?php echo(getUebersetzung("Samstage andersfärbig anzeigen.", $sprache, $link)); ?>
            </label>
        </div>

        <?php showSubmitButton(getUebersetzung("ändern", $sprache, $link)); ?>

    </form>
    <div class="form-group">
        <hr>
    </div>
    <form action="./ansichtenAendern.inc.php" method="post" target="_self">
        <div class="row panel-heading">
            <div class="col-sm-12">
                <h4><?php echo getUebersetzung("Ansichten anzeigen", $sprache, $link) ?></h4>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <label class="label-control">
                    <!-- Monatsübersicht   -->
                    <input name="showMonatsansicht" type="checkbox" id="showMonatsansicht" value="true"
                        <?php
                        if ($showMonatsansicht) {
                            echo(" checked=\"checked\"");
                        }
                        ?>
                    />
                    <?php echo getUebersetzung("Monatsübersicht", $sprache, $link) ?>
                </label>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <label class="label-control">
                    <!-- Jahresübersicht -->
                    <input name="showJahresansicht" type="checkbox" id="showJahresansicht" value="true"
                        <?php
                        if ($showJahresansicht) {
                            echo(" checked=\"checked\"");
                        }
                        ?>
                    />
                    <?php echo getUebersetzung("Jahresübersicht", $sprache, $link) ?>
                </label>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <label class="label-control">
                    <!-- Gesammtübersicht -->
                    <input name="showGesamtansicht" type="checkbox" id="showGesamtansicht" value="true"
                        <?php
                        if ($showGesamtansicht) {
                            echo(" checked=\"checked\"");
                        }
                        ?>
                    />

                    <?php echo getUebersetzung("Gesamtübersicht", $sprache, $link) ?>
                </label>
            </div>
        </div>

        <?php
        showSubmitButton(getUebersetzung("ändern", $sprache, $link));
        ?>

    </form>

    <br/>

    <?php
} //ende if passwortprüfung
else {
    echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!", $sprache, $link));
}
?>
<?php include_once("../../templates/end.php"); ?>