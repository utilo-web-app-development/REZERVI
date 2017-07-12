<?php session_start();
$root = "../../..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once($root . "/include/sessionFunctions.inc.php");
/*   
	rezervi
	einstellungen zu bildern in der suchfunktion
	author: coster utilo.eu
	date: 3. aug. 2005					
*/

//datenbank öffnen:
include_once("../../../conf/rdbmsConfig.php");

//andere funktionen importieren:
include_once("../../../include/benutzerFunctions.php");
include_once("../../../include/unterkunftFunctions.php");
include_once("../../../include/bildFunctions.php");
include_once("../../../include/propertiesFunctions.php");
include_once("../../../include/uebersetzer.php");
include_once("../../templates/components.php");
include_once("../../templates/auth.php");

//variablen:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
$sprache = getSessionWert(SPRACHE);

//check if the upload dir is writeable:
if (!is_writeable($root . "/upload")) {
    $nachricht = "Achtung! Das Verzeichnis 'upload' ist nicht beschreibbar, Sie können erst Bilder hochladen wenn Sie diesem Verzeichnis Schreibrechte zuweisen!";
    $nachricht = getUebersetzung($nachricht, $sprache, $link);
    $fehler = true;
}

?>

<?php include_once("../../templates/headerA.php"); ?>
    <style type="text/css">
        <?php include_once($root."/templates/stylesheetsIE9.php"); ?>
    </style>
<?php include_once("../../templates/headerB.php"); ?>
<?php include_once("../../templates/bodyA.php"); ?>
    <div class="panel panel-default">
    <div class="panel-heading">
        <h2><?php echo(getUebersetzung("Einstellungen für Bilder der Zimmer", $sprache, $link)); ?>.</h2>
    </div>
    <div class="panel-body">
<?php
//passwortprüfung:
if (checkPass($benutzername, $passwort, $unterkunft_id, $link)) {
    ?>


    <!-- Show message if there is -->
    <?php include_once("../../templates/message.php"); ?>

    <form action="./bilderAendern.php" method="post" target="_self">
        <?php
        $active = getPropertyValue(ZIMMER_THUMBS_ACTIV, $unterkunft_id, $link);
        if ($active != "true") {
            $active = false;
        } else {
            $active = true;
        }
        $active2 = getPropertyValue(ZIMMER_THUMBS_AV_OV, $unterkunft_id, $link);
        if ($active2 != "true") {
            $active2 = false;
        } else {
            $active2 = true;
        }
        $width = getPropertyValue(BILDER_SUCHE_WIDTH, $unterkunft_id, $link);
        $height = getPropertyValue(BILDER_SUCHE_HEIGHT, $unterkunft_id, $link);
        ?>

        <div class="row">
            <div class="col-sm-5">
                <label class="control-label">
                    <?php echo(getUebersetzung("Bilder bei Suchergebnissen anzeigen", $sprache, $link)); ?>
                </label>

            </div>
            <div class="col-sm-1">
                <input name="active" type="checkbox" id="active" value="true"
                    <?php if ($active) echo("checked=\"checked\""); ?>>
                </div>
        </div>

        <div class="row">
            <div class="col-sm-5">

                <label class="control-label">
                    <?php echo(getUebersetzung("Bilder und Beschreibungen im Belegungsplan anzeigen", $sprache, $link)); ?>
                </label>
            </div>
            <div class="col-sm-1">
                <input name="active2" type="checkbox" id="active2" value="true"
                    <?php if ($active2) echo("checked=\"checked\""); ?>>
                </div>
        </div>
        <br>
        <div class="row">
            <label class="label-control col-sm-5">
                <?php echo(getUebersetzung("Maximale Höhe bei upload (px)", $sprache, $link)); ?>
            </label>
            <div class="col-sm-4">

                <input class="form-control" name="width" type="text" id="width" value="<?php echo($width); ?>"
                       size="5" maxlength="5"/>&nbsp;
            </div>
        </div>

        <div class="row">
            <label class="label-control col-sm-5">
                <?php echo(getUebersetzung("Maximale Breite bei upload (px)", $sprache, $link)); ?>
            </label>
            <div class="col-sm-4">
                <input class="form-control" name="height" type="text" id="height" value="<?php echo($height); ?>"
                       size="5" maxlength="5"/>&nbsp;
            </div>
        </div>

        <div class="row">
            <div class="col-sm-offset-10 col-sm-2" style="text-align: right;">
                <button name="aendern" type="submit" class="btn btn-success" id="aendern">
                    <span class="glyphicon glyphicon-wrench"></span>
                    <?php echo(getUebersetzung("Ändern", $sprache, $link)); ?>
                </button>

            </div>
        </div>

    </form>

    </div>

    <?php
} //ende if passwortprüfung
else {
    echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!", $sprache, $link));
}
?>
<?php include_once("../../templates/end.php"); ?>