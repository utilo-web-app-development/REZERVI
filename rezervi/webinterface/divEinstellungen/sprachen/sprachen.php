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
$standardsprache = getStandardSprache($unterkunft_id, $link);

?>
<?php include_once("../../templates/headerA.php"); ?>
    <style type="text/css">
        <?php include_once($root."/templates/stylesheetsIE9.php"); ?>
    </style>
<?php include_once("../../templates/headerB.php"); ?>
<?php include_once("../../templates/bodyA.php"); ?>
    <div class="panel panel-default">
    <div class="panel-heading">
        <h2><?php echo(getUebersetzung("Ändern der angezeigten Sprachen", $sprache, $link)); ?>.</h2>
    </div>
    <div class="panel-body">

<?php
//passwortprüfung:
if (checkPass($benutzername, $passwort, $unterkunft_id, $link)) {
    ?>

     <!-- Show message if there is -->
    <?php include_once("../../templates/message.php"); ?>

    <form action="./sprachenAendern.php" method="post" name="adresseForm" target="_self"
          onSubmit="return checkForm();" class="form-horizontal">
        <p class="lead">
            <?php echo(getUebersetzung("Markieren sie die Sprachen, die auf ihrer Website zur Auswahl angeboten werden sollen", $sprache, $link)); ?>
            :
        </p>


        <div class="well">
            <form action="./sprachenAendern.php" method="post" target="_self">
                <?php
                //sprachen anzeigen die aktiviert sind:
                $res = getSprachenForBelegungsplan($link);
                while ($d = mysqli_fetch_array($res)) {
                    $bezeichnung = $d["Bezeichnung"];
                    $spracheID = $d["Sprache_ID"];
                    $aktiviert = isSpracheShown($unterkunft_id, $spracheID, $link);
                    ?>
                    <div class="row">
                        <div class="col-sm-4">
                            <label class="label-control">
                                <script>console.log("<?php echo(getUebersetzung($bezeichnung, $sprache, $link)); ?>");</script>
                                <?php echo(getUebersetzung($bezeichnung, $sprache, $link)); ?>
                            </label>

                        </div>
                        <div class="col-sm-4">
                            <label>
                                <input name="<?php echo($spracheID); ?>"
                                       type="checkbox"
                                       id="<?php echo($spracheID); ?>"
                                       value="true"
                                    <?php if ($aktiviert) {
                                        echo(" checked");
                                    } ?>
                                />
                            </label>
                        </div>
                    </div>
                    <?php
                }
                ?>

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

    <?php
} //ende if passwortprüfung
else {
    echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!", $sprache, $link));
}
?>
<?php include_once("../../templates/end.php"); ?>