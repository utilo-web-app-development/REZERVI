<?php session_start();
$root = "../../..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once($root . "/include/sessionFunctions.inc.php");
/*   
	reservierungsplan
	gast-infos anzeigen und evt. ändern:
	author: christian osterrieder utilo.eu
			
	dieser seite muss Übergeben werden:
	Gast PK_ID $gast_id
	$unterkunft_id
*/

$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
$sprache = getSessionWert(SPRACHE);

//datenbank öffnen:
include_once("../../../conf/rdbmsConfig.php");

//funktions einbinden:
include_once("../../../include/unterkunftFunctions.php");
//uebersetzer einfuegen:
include_once("../../../include/uebersetzer.php");
include_once("../../../include/reservierungFunctions.php");
include_once("../../../include/gastFunctions.php");
include_once("../../../include/benutzerFunctions.php");
include_once("../../../include/einstellungenFunctions.php");

?>

<?php include_once("../../templates/headerA.php"); ?>
<style type="text/css">
    <?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../../templates/headerB.php"); ?>
<script language="JavaScript" type="text/javascript" src="formPruefen.php">
</script>
<?php include_once("../../templates/bodyA.php"); ?>
<?php
//passwortprüfung:
if (checkPass($benutzername, $passwort, $unterkunft_id, $link)) { ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2><?php echo(getUebersetzung("Anlegen eines neuen Gastes", $sprache, $link)); ?></h2>
        </div>
        <div class="panel-body">

            <form action="./anlegen.php" method="post" name="adresseForm" target="_self"
                  onSubmit="return chkFormular();" class="form-horizontal">

                <div class="form-group">
                    <label for="anrede"
                           class="col-sm-2 control-label"><?php echo(getUebersetzung("Anrede", $sprache, $link)); ?></label>
                    <div class="col-sm-10">
                        <input name="anrede" type="text" id="anrede" value="" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="vorname"
                           class="col-sm-2 control-label"><?php echo(getUebersetzung("Vorname", $sprache, $link)); ?></label>
                    <div class="col-sm-10">
                        <input name="vorname" type="text" id="vorname" value="" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="nachname"
                           class="col-sm-2 control-label"><?php echo(getUebersetzung("Nachname", $sprache, $link)); ?>
                        *</label>
                    <div class="col-sm-10">
                        <input name="nachname" type="text" id="nachname" value="" class="form-control"
                               required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label for="strasse"
                           class="col-sm-2 control-label"><?php echo(getUebersetzung("Straße/Hausnummer", $sprache, $link)); ?></label>
                    <div class="col-sm-10">
                        <input name="strasse" type="text" id="strasse" value="" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="plz"
                           class="col-sm-2 control-label"><?php echo(getUebersetzung("PLZ", $sprache, $link)); ?></label>
                    <div class="col-sm-10">
                        <input name="plz" type="text" id="plz" value="" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="ort"
                           class="col-sm-2 control-label"><?php echo(getUebersetzung("Ort", $sprache, $link)); ?></label>
                    <div class="col-sm-10">
                        <input name="ort" type="text" id="ort" value="" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="land"
                           class="col-sm-2 control-label"><?php echo(getUebersetzung("Land", $sprache, $link)); ?></label>
                    <div class="col-sm-10">
                        <input name="land" type="text" id="land" value="" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="email"
                           class="col-sm-2 control-label"><?php echo(getUebersetzung("E-Mail-Adresse", $sprache, $link)); ?></label>
                    <div class="col-sm-10">
                        <input name="email" type="text" id="email" value="" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="tel"
                           class="col-sm-2 control-label"><?php echo(getUebersetzung("Telefonnummer", $sprache, $link)); ?></label>
                    <div class="col-sm-10">
                        <input name="tel" type="text" id="tel" value="" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="fax"
                           class="col-sm-2 control-label"><?php echo(getUebersetzung("Faxnummer", $sprache, $link)); ?></label>
                    <div class="col-sm-10">
                        <input name="fax" type="text" id="fax" value="" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="speech"
                           class="col-sm-2 control-label"><?php echo(getUebersetzung("bevorzugte Sprache", $sprache, $link)); ?></label>
                    <div class="col-sm-10">
                        <select name="speech" type="text" id="speech" value="" class="form-control">>
                            <?php
                            //sprachen des belegungsplanes anzeigen:
                            $stdSpr = getStandardSprache($unterkunft_id, $link);
                            $res = getSprachen($unterkunft_id, $link);
                            while ($d = mysql_fetch_array($res)) {
                                $spr = $d["Sprache_ID"];
                                $bezeichnung = getBezeichnungOfSpracheID($spr, $link);
                                ?>
                                <option
                                    value="<?php echo($spr); ?>" <?php if ($stdSpr == $spr) echo("selected"); ?>><?php echo(getUebersetzung($bezeichnung, $sprache, $link)); ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="anmerkungen"
                           class="col-sm-2 control-label"><?php echo(getUebersetzung("Anmerkungen", $sprache, $link)); ?></label>
                    <div class="col-sm-10">
                        <textarea name="anmerkungen" type="text" id="anmerkungen" value=""
                                  class="form-control"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-9 col-sm-3">
                        <input type="submit" name="anlegen" class="btn btn-success"
                               value="<?php echo(getUebersetzung("Gast anlegen", $sprache, $link)); ?>">
                        <a class="btn btn-primary" href="../index.php">
<!--                            <span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>&nbsp;-->
                            <?php echo(getUebersetzung("Abbrechen", $sprache, $link)); ?>
                        </a>
                    </div>
                </div>

            </form>


        </div>
    </div>

<?php } //ende passwortprüfung 
else {
    echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!", $sprache, $link));
}
?>
</body>
</html>
