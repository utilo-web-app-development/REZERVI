<?php session_start();
$root = "../..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once($root . "/include/sessionFunctions.inc.php");
/*   
			reservierungsplan
			bestätigung zum löschen von zimmern von benutzer einholen!
*/

//variablen intitialisieren:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$benutzername = getSessionWert(BENUTZERNAME);
$passwort = getSessionWert(PASSWORT);
$zimmer_id = $_POST["zimmer_id"];
$sprache = getSessionWert(SPRACHE);

//datenbank öffnen:
include_once("../../conf/rdbmsConfig.php");

//andere funktionen importieren:
include_once("../../include/benutzerFunctions.php");
include_once("../../include/unterkunftFunctions.php");
include_once("../../include/gastFunctions.php");
include_once("../../include/reservierungFunctions.php");
include_once("../../include/zimmerFunctions.php");
include_once("../../include/uebersetzer.php");

//wurde auch ein zimmer ausgewählt?
if (!isset($zimmer_id) || $zimmer_id == "") {
    $fehler = true;
    $nachricht = "Bitte wählen sie ein Zimmer aus!";
    $nachricht = getUebersetzung($nachricht, $sprache, $link);
    include_once("./index.php");
    exit;
}

?>
<?php include_once("../templates/headerA.php"); ?>
<style type="text/css">
    <?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../templates/headerB.php"); ?>
<?php include_once("../templates/bodyA.php"); ?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h2><?php echo(getUebersetzung("Löschung bestätigen", $sprache, $link)); ?></h2>
    </div>
    <div class="panel-body">
        <form action="./zimmerLoeschen.php" method="post" name="zimmerLoeschen" target="_self"
              onSubmit="return chkFormular();" class="form-horizontal">

            <div
                class="alert-danger alert"><?php echo(getUebersetzung("Folgende Zimmer/Appartements/Wohnungen/etc. werden aus der Datenbank entfernt", $sprache, $link)); ?>
                .
            </div>
            <div
                class="alert-info alert"><?php echo(getUebersetzung("Bitte beachten Sie, dass damit auch alle Reservierungen die diese(s) Zimmer/Appartement/Wohnung/etc. betreffen ebenfalls entfernt werden", $sprache, $link)); ?>
                !
            </div>

            <select name="zimmer_pk_id[]" type="text" id="zimmer_pk_id[]" class="form-control">
                <?php
                $anzahl = count($zimmer_id);
                for ($i = 0; $i < $anzahl; $i++) {
                    $temp = $zimmer_id[$i];
                    ?>
                    <option value="<?php echo($temp); ?>"
                            selected><?php echo(getUebersetzungUnterkunft(getZimmerNr($unterkunft_id, $temp, $link), $sprache, $unterkunft_id, $link));
                        ?></option>
                    <?php
                } //ende for
                ?>
            </select>

            </p>
            <p><?php echo(getUebersetzung("Nur die hier selektierten Zimmer/Appartements/Wohnungen/etc. werden gelöscht.", $sprache, $link)); ?>
                <?php echo(getUebersetzung("Entfernen Sie die Markierungen (mit [STRG] und Mausklick) die nicht gelöscht werden sollen!", $sprache, $link)); ?></p>

            <div class="row">
                <div class="col-sm-offset-9 col-sm-3" style="text-align: right;">
                    <a class="btn btn-primary" href="./index.php">
                        <!--                        <span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>&nbsp-->
                        <?php echo(getUebersetzung("Abbrechen", $sprache, $link)); ?>
                    </a>
                    <input name="retour" type="submit" class="btn btn-success" id="retour"
                           value="<?php echo(getUebersetzung("weiter", $sprache, $link)); ?>">
                </div>

            </div>
        </form>
    </div>
</div>
</body>
</html>
