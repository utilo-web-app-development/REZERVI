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
//uebersetzer einfuegen:
include_once("../../../../include/uebersetzer.php");
include_once("../../../../include/reservierungFunctions.php");
include_once("../../../../include/gastFunctions.php");
include_once("../../../../include/benutzerFunctions.php");
include_once("../../../../include/einstellungenFunctions.php");


?>
<?php include_once("../../../templates/headerA.php"); ?>
<style type="text/css">
    <?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../../../templates/headerB.php"); ?>
<?php include_once("../../../templates/bodyA.php"); ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h2><?php echo(getUebersetzung("Gast bearbeiten", $sprache, $link)); ?>:</h2>
        <?php echo(getUebersetzung("Bitte überschreiben bzw. ergänzen Sie die Felder des Gastes den Sie ändern möchten", $sprache, $link)); ?>
    </div>

    <div class="panel-body">
        <?php
        //passwortprüfung:
        if (checkPass($benutzername, $passwort, $unterkunft_id, $link)) {
            ?>

            <form action="./gastAendern.php" method="post" name="gastAendern" target="_self" id="gastAendern"
                  class="form-horizontal">
                <div class="form-group">
                    <label for="anrede"
                           class="col-sm-2 control-label"><?php echo(getUebersetzung("Anrede", $sprache, $link)); ?></label>
                    <div class="col-sm-10">
                        <input name="anrede" type="text" id="anrede"
                               value="<?php echo(getGuestAnrede($gast_id, $link)); ?>" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="vorname" class="col-sm-2 control-label">
                        <?php echo(getUebersetzung("Vorname", $sprache, $link)); ?>*
                    </label>
                    <div class="col-sm-10">
                        <input name="vorname" type="text" id="vorname"
                               value="<?php echo(getGuestVorname($gast_id, $link)); ?>" class="form-control"
                               required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label for="nachname"
                           class="col-sm-2 control-label"><?php echo(getUebersetzung("Nachname", $sprache, $link)); ?>
                        *</label>
                    <div class="col-sm-10">
                        <input name="nachname" type="text" id="nachname"
                               value="<?php echo(getGuestNachname($gast_id, $link)); ?>" class="form-control"
                               required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label for="strasse"
                           class="col-sm-2 control-label"><?php echo(getUebersetzung("Straße/Hausnummer", $sprache, $link)); ?></label>
                    <div class="col-sm-10">
                        <input name="strasse" type="text" id="strasse"
                               value="<?php echo(getGuestStrasse($gast_id, $link)); ?>" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="plz"
                           class="col-sm-2 control-label"><?php echo(getUebersetzung("PLZ", $sprache, $link)); ?></label>
                    <div class="col-sm-10">
                        <input name="plz" type="text" id="plz" value="<?php echo(getGuestPLZ($gast_id, $link)); ?>"
                               class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="ort"
                           class="col-sm-2 control-label"><?php echo(getUebersetzung("Ort", $sprache, $link)); ?></label>
                    <div class="col-sm-10">
                        <input name="ort" type="text" id="ort" value="<?php echo(getGuestOrt($gast_id, $link)); ?>"
                               class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="land"
                           class="col-sm-2 control-label"><?php echo(getUebersetzung("Land", $sprache, $link)); ?></label>
                    <div class="col-sm-10">
                        <input name="land" type="text" id="land" value="<?php echo(getGuestLand($gast_id, $link)); ?>"
                               class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="email"
                           class="col-sm-2 control-label"><?php echo(getUebersetzung("E-Mail-Adresse", $sprache, $link)); ?>
                        *</label>
                    <div class="col-sm-10">
                        <input name="email" type="text" id="email"
                               value="<?php echo(getGuestEmail($gast_id, $link)); ?>" class="form-control"
                               required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label for="tel"
                           class="col-sm-2 control-label"><?php echo(getUebersetzung("Telefonnummer", $sprache, $link)); ?></label>
                    <div class="col-sm-10">
                        <input name="tel" type="text" id="tel" value="<?php echo(getGuestTel($gast_id, $link)); ?>"
                               class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="fax"
                           class="col-sm-2 control-label"><?php echo(getUebersetzung("Faxnummer", $sprache, $link)); ?></label>
                    <div class="col-sm-10">
                        <input name="fax" type="text" id="fax" value="<?php echo(getGuestFax($gast_id, $link)); ?>"
                               class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="speech"
                           class="col-sm-2 control-label"><?php echo(getUebersetzung("bevorzugte Sprache", $sprache, $link)); ?></label>
                    <div class="col-sm-10">
                        <select name="speech" id="speech" class="form-control">
                            <?php
                            //sprachen des belegungsplanes anzeigen:
                            $res = getSprachen($unterkunft_id, $link);
                            while ($d = mysqli_fetch_array($res)) {
                                $spr = $d["Sprache_ID"];
                                $bezeichnung = getBezeichnungOfSpracheID($spr, $link);
                                ?>
                                <option
                                    value="<?php echo($spr); ?>" <?php if (getGuestSprache($gast_id, $link) == $spr) echo("selected"); ?>><?php echo(getUebersetzung($bezeichnung, $sprache, $link)); ?></option>
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
                        <textarea name="anmerkungen" type="text" id="anmerkungen" value="<?php echo(getGuestAnmerkung($gast_id,$link)); ?>"
                                  class="form-control"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-10 col-sm-2" style="text-align: right;" >
                        <button name="gastAendern" type="button" id="gastAendern" class="btn btn-success" onclick="checkForm('gastAendern');">
                            <span class="glyphicon glyphicon-wrench"></span>
                            <?php echo(getUebersetzung("Gast ändern", $sprache, $link)); ?>
                            </button>
                        <input name="gast_id" type="hidden" id="gast_id" value="<?php echo($gast_id); ?>">
                        <input name="anrede_val" type="hidden" id="anrede_var" value="<?php echo($anrede_val); ?>">
                        <input name="plz_val" type="hidden" id="plz_val" value="<?php echo($plz_val); ?>">
                        <input name="vorname_val" type="hidden" id="vorname_var3"
                               value="<?php echo($vorname_val); ?>">
                        <input name="nachname_val" type="hidden" id="anrede_var4"
                               value="<?php echo($nachname_val); ?>">
                        <input name="strasse_val" type="hidden" id="anrede_var5"
                               value="<?php echo($strasse_val); ?>">
                        <input name="ort_val" type="hidden" id="anrede_var6" value="<?php echo($ort_val); ?>">
                        <input name="land_val" type="hidden" id="anrede_var7" value="<?php echo($land_val); ?>">
                        <input name="email_val" type="hidden" id="anrede_var8" value="<?php echo($email_val); ?>">
                        <input name="tel_val" type="hidden" id="anrede_var9" value="<?php echo($tel_val); ?>">
                        <input name="fax_val" type="hidden" id="anrede_var" value="<?php echo($fax_val); ?>">
                        <input name="anmerkung_val" type="hidden" id="anrede_var"
                               value="<?php echo($anmerkung_val); ?>">
                        <input name="sprache_val" type="hidden" id="anrede_var"
                               value="<?php echo($sprache_val); ?>">
                        <input name="index" type="hidden" value="<?php echo($index); ?>"/>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-sm-offset-9 col-sm-2" style="text-align: right;">

                        <a href="../../../inhalt.php" name="Submit3" target="_self" class="btn btn-primary">
                            <span class="glyphicon glyphicon-home"></span>
                            <?php echo(getUebersetzung("Hauptmenü", $sprache, $link)); ?>
                        </a>
                </div>
                <div class="col-sm-1">
                    <form action="../index.php" method="post" name="zurueck" target="_self" id="zurueck">
                        <button type="submit" name="Submit" class="btn btn-primary">
                            <?php echo(getUebersetzung("zurück", $sprache, $link)); ?>
                        </button>
                        <input name="anrede_val" type="hidden" id="anrede_val" value="<?php echo($anrede_val); ?>">
                        <input name="vorname_val" type="hidden" id="vorname_val"
                               value="<?php echo($vorname_val); ?>">
                        <input name="nachname_val" type="hidden" id="nachname_val"
                               value="<?php echo($nachname_val); ?>">
                        <input name="strasse_val" type="hidden" id="strasse_val"
                               value="<?php echo($strasse_val); ?>">
                        <input name="ort_val" type="hidden" id="ort_val" value="<?php echo($ort_val); ?>">
                        <input name="land_val" type="hidden" id="land_val" value="<?php echo($land_val); ?>">
                        <input name="email_val" type="hidden" id="email_val" value="<?php echo($email_val); ?>">
                        <input name="tel_val" type="hidden" id="tel_val" value="<?php echo($tel_val); ?>">
                        <input name="fax_val" type="hidden" id="anrede_val" value="<?php echo($fax_val); ?>">
                        <input name="anmerkung_val" type="hidden" id="anrede_val"
                               value="<?php echo($anmerkung_val); ?>">
                        <input name="sprache_val" type="hidden" id="anrede_var"
                               value="<?php echo($sprache_val); ?>">
                        <input name="plz_val" type="hidden" id="plz_val" value="<?php echo($plz_val); ?>">
                    </form>
                </div>
            </div>

        <?php } //ende passwortprüfung
        else {
            echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!", $sprache, $link));
        }
        ?>
    </div>
</div>
</body>
</html>
