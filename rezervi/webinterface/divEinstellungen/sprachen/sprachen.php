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
<?php
//passwortprüfung:
if (checkPass($benutzername, $passwort, $unterkunft_id, $link)) {
    ?>
    <div class="panel panel-default">
    <div class="panel-body">

    <form action="./sprachenAendern.php" method="post" name="adresseForm" target="_self"
          onSubmit="return chkFormular();" class="form-horizontal">

        <h2><?php echo(getUebersetzung("Ändern der angezeigten Sprachen", $sprache, $link)); ?>.</h2>
        <h4><?php echo(getUebersetzung("Markieren sie die Sprachen, die auf ihrer Website zur Auswahl angeboten werden sollen", $sprache, $link)); ?>
            :</h4>


        <br/>
        <?php
        if (isset($nachricht) && $nachricht != "") {
            ?>


            <<?php if (isset($fehler) && $fehler == false) {
                echo("class=\"frei\"");
            } else {
                echo("class=\"belegt\"");
            } ?>><?php echo($nachricht) ?>


            <?php
        }
        ?>
        <table border="0" cellpadding="0" cellspacing="3" class="table">
            <form action="./sprachenAendern.php" method="post" target="_self">
                <?php
                //sprachen anzeigen die aktiviert sind:
                $res = getSprachenForBelegungsplan($link);
                while ($d = mysql_fetch_array($res)) {
                    $bezeichnung = $d["Bezeichnung"];
                    $spracheID = $d["Sprache_ID"];
                    $aktiviert = isSpracheShown($unterkunft_id, $spracheID, $link);
                    ?>
                    <tr>
                        <td>
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
                        </td>
                        <td>
                            <label class="label-control">
                                <script>console.log("<?php echo(getUebersetzung($bezeichnung, $sprache, $link)); ?>");</script>
                                <?php echo(getUebersetzung($bezeichnung, $sprache, $link)); ?>
                            </label>
                        </td>
                    </tr>
                    <?php
                }
                ?>

        </table>
        <?php showSubmitButton(getUebersetzung("ändern", $sprache, $link)); ?>
    </form>

    <?php
} //ende if passwortprüfung
else {
    echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!", $sprache, $link));
}
?>
<?php include_once("../../templates/end.php"); ?>