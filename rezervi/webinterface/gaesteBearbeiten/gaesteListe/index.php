<?php session_start();
$root = "../../..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once($root . "/include/sessionFunctions.inc.php");
/*   
	reservierungsplan			
	author: christian osterrieder utilo.eu		
	
	dieser seite muss übergeben werden:
	Unterkunft PK_ID ($unterkunft_id)
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
$sprache = getSessionWert(SPRACHE);

define("LIMIT", "6"); //limit der angezeigten gäste pro seite
if (isset($_POST["index"]) && $_POST["index"] != "") {
    $index = $_POST["index"];
} else {
    $index = 0;
}

//datenbank öffnen:
include_once("../../../conf/rdbmsConfig.php");
include_once("../../../include/unterkunftFunctions.php");
include_once("../../../include/benutzerFunctions.php");
//uebersetzer einfuegen:
include_once("../../../include/uebersetzer.php");
include_once("../../../include/gastFunctions.php");
include_once("../../templates/components.php");

?>
<?php include_once("../../templates/headerA.php"); ?>
<style type="text/css">
    <?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../../templates/headerB.php"); ?>
<?php include_once("../../templates/bodyA.php"); ?>
<script language="JavaScript">
    <!--
    function sicher() {
        return confirm('<?php echo(getUebersetzung("Gast wirklich löschen?", $sprache, $link)); ?>');
    }
    //-->
</script>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3><?php echo(getUebersetzung("Gästeliste anzeigen und bearbeiten", $sprache, $link)); ?>.</h3>
    </div>
    <div class="panel-body">
        <?php
        //passwortprüfung:
        if (checkPass($benutzername, $passwort, $unterkunft_id, $link)) { ?>

            <?php
            //gästeliste ausgeben:
            //$res = getGuestList($unterkunft_id,$link);
            $res = getGuestListWithLimitAndIndex($unterkunft_id, LIMIT, $index, $link);

            while ($d = mysql_fetch_array($res)) {
                $gast_id = $d["PK_ID"];
                $vorname = $d["Vorname"];
                $nachname = $d["Nachname"];
                $strasse = $d["Strasse"];
                $plz = $d["PLZ"];
                $ort = $d["Ort"];
                $land = $d["Land"];
                $email = $d["EMail"];
                $tel = $d["Tel"];
                $fax = $d["Fax"];
                $anmerkung = $d["Anmerkung"];
                $anrede = $d["Anrede"];
                if ($d["Sprache"] == "de")
                    $speech = "Deutsch";
                else if ($d["Sprache"] == "en")
                    $speech = "Englisch";
                else if ($d["Sprache"] == "fr")
                    $speech = "Französisch";
                else if ($d["Sprache"] == "it")
                    $speech = "Italienisch";
                else if ($d["Sprache"] == "nl")
                    $speech = "Holländisch";

                ?>
                <table width="100%" border="0" cellspacing="3" cellpadding="0" class="tableColor">
                    <tr>
                        <?php if ($anrede_val == "true") { ?>
                            <td><?php echo(getUebersetzung("Anrede", $sprache, $link)); ?></td>
                        <?php }
                        if ($vorname_val == "true") { ?>
                            <td><?php echo(getUebersetzung("Vorname", $sprache, $link)); ?></td>
                        <?php }
                        if ($nachname_val == "true") { ?>
                            <td><?php echo(getUebersetzung("Nachname", $sprache, $link)); ?></td>
                        <?php }
                        if ($strasse_val == "true") { ?>
                            <td><?php echo(getUebersetzung("Straße/Hausnummer", $sprache, $link)); ?></td>
                        <?php }
                        if ($plz_val == "true") { ?>
                            <td><?php echo(getUebersetzung("PLZ", $sprache, $link)); ?></td>
                        <?php }
                        if ($ort_val == "true") { ?>
                            <td><?php echo(getUebersetzung("Ort", $sprache, $link)); ?></td>
                        <?php }
                        if ($land_val == "true") { ?>
                            <td><?php echo(getUebersetzung("Land", $sprache, $link)); ?></td>
                        <?php }
                        if ($email_val == "true") { ?>
                            <td><?php echo(getUebersetzung("E-Mail-Adresse", $sprache, $link)); ?></td>
                        <?php }
                        if ($tel_val == "true") { ?>
                            <td><?php echo(getUebersetzung("Telefon", $sprache, $link)); ?></td>
                        <?php }
                        if ($fax_val == "true") { ?>
                            <td><?php echo(getUebersetzung("Faxnummer", $sprache, $link)); ?></td>
                        <?php }
                        if ($sprache_val == "true") { ?>
                            <td><?php echo(getUebersetzung("Sprache", $sprache, $link)); ?></td>
                        <?php }
                        if ($anmerkung_val == "true") { ?>
                            <td><?php echo(getUebersetzung("Anmerkungen", $sprache, $link)); ?></td>
                        <?php }
                        ?>
                    </tr>
                    <tr>
                        <?php if ($anrede_val == "true") { ?>
                            <td><?php echo($anrede); ?></td>
                        <?php }
                        if ($vorname_val == "true") { ?>
                            <td><?php echo($vorname); ?></td>
                        <?php }
                        if ($nachname_val == "true") { ?>
                            <td><?php echo($nachname); ?></td>
                        <?php }
                        if ($strasse_val == "true") { ?>
                            <td><?php echo($strasse); ?></td>
                        <?php }
                        if ($plz_val == "true") { ?>
                            <td><?php echo($plz); ?></td>
                        <?php }
                        if ($ort_val == "true") { ?>
                            <td><?php echo($ort); ?></td>
                        <?php }
                        if ($land_val == "true") { ?>
                            <td><?php echo($land); ?></td>
                        <?php }
                        if ($email_val == "true") { ?>
                            <td><a href="mailto:<?php echo($email); ?>"><?php echo($email); ?></a></td>
                        <?php }
                        if ($tel_val == "true") { ?>
                            <td><?php echo($tel); ?></td>
                        <?php }
                        if ($fax_val == "true") { ?>
                            <td><?php echo($fax); ?></td>
                        <?php }
                        if ($sprache_val == "true") { ?>
                            <td><?php echo($speech); ?></td>
                        <?php }
                        if ($anmerkung_val == "true") { ?>
                            <td><?php echo($anmerkung); ?></td>
                        <?php }
                        ?>
                    </tr>
                    <tr>
                        <td colspan="11">
                            <table border="0" cellspacing="3" cellpadding="0">
                                <tr>
                                    <td>
                                        <form action="./gastBearbeiten/index.php" method="post" name="gastBearbeiten"
                                              target="_self">
                                            <div align="right">
                                                <input name="plz_val" type="hidden" id="plz_val"
                                                       value="<?php echo($plz_val); ?>">
                                                <input name="anrede_val" type="hidden" id="anrede_var"
                                                       value="<?php echo($anrede_val); ?>">
                                                <input name="vorname_val" type="hidden" id="vorname_var3"
                                                       value="<?php echo($vorname_val); ?>">
                                                <input name="nachname_val" type="hidden" id="anrede_var4"
                                                       value="<?php echo($nachname_val); ?>">
                                                <input name="strasse_val" type="hidden" id="anrede_var5"
                                                       value="<?php echo($strasse_val); ?>">
                                                <input name="plz_val" type="hidden" id="anrede_var5"
                                                       value="<?php echo($plz_val); ?>">
                                                <input name="ort_val" type="hidden" id="anrede_var6"
                                                       value="<?php echo($ort_val); ?>">
                                                <input name="land_val" type="hidden" id="anrede_var7"
                                                       value="<?php echo($land_val); ?>">
                                                <input name="email_val" type="hidden" id="anrede_var8"
                                                       value="<?php echo($email_val); ?>">
                                                <input name="tel_val" type="hidden" id="anrede_var9"
                                                       value="<?php echo($tel_val); ?>">
                                                <input name="fax_val" type="hidden" id="anrede_var"
                                                       value="<?php echo($fax_val); ?>">
                                                <input name="anmerkung_val" type="hidden" id="anrede_var"
                                                       value="<?php echo($anmerkung_val); ?>">
                                                <input name="sprache_val" type="hidden" id="anrede_var"
                                                       value="<?php echo($sprache_val); ?>">
                                                <input name="gast_id" type="hidden" id="gast_id"
                                                       value="<?php echo($gast_id); ?>">
                                                <input name="index" type="hidden" value="<?php echo($index); ?>"/>
                                                <input name="gastBearbeiten" type="submit" id="gastBearbeiten"
                                                       class="btn btn-primary"
                                                       value="<?php echo(getUebersetzung("Gast bearbeiten", $sprache, $link)); ?>">

                                            </div>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="./gastInfos/index.php" method="post" name="gastInfos"
                                              target="_self">
                                            <div align="right">
                                                <input name="gastInfos" type="submit" id="gastInfos"
                                                       class="btn btn-primary"
                                                       value="<?php echo(getUebersetzung("Reservierungs-Informationen", $sprache, $link)); ?>">
                                                <input name="anrede_val" type="hidden" id="anrede_var10"
                                                       value="<?php echo($anrede_val); ?>">
                                                <input name="vorname_val" type="hidden" id="vorname_var"
                                                       value="<?php echo($vorname_val); ?>">
                                                <input name="nachname_val" type="hidden" id="nachname_var"
                                                       value="<?php echo($nachname_val); ?>">
                                                <input name="strasse_val" type="hidden" id="strasse_var"
                                                       value="<?php echo($strasse_val); ?>">
                                                <input name="ort_val" type="hidden" id="ort_var"
                                                       value="<?php echo($ort_val); ?>">
                                                <input name="land_val" type="hidden" id="land_var"
                                                       value="<?php echo($land_val); ?>">
                                                <input name="email_val" type="hidden" id="email_var"
                                                       value="<?php echo($email_val); ?>">
                                                <input name="tel_val" type="hidden" id="tel_var"
                                                       value="<?php echo($tel_val); ?>">
                                                <input name="fax_val" type="hidden" id="anrede_var10"
                                                       value="<?php echo($fax_val); ?>">
                                                <input name="anmerkung_val" type="hidden" id="anrede_var10"
                                                       value="<?php echo($anmerkung_val); ?>">
                                                <input name="plz_val" type="hidden" id="plz_val"
                                                       value="<?php echo($plz_val); ?>">
                                                <input name="gast_id" type="hidden" id="gast_id"
                                                       value="<?php echo($gast_id); ?>">
                                                <input name="sprache_val" type="hidden" id="anrede_var"
                                                       value="<?php echo($sprache_val); ?>">
                                                <input name="index" type="hidden" value="<?php echo($index); ?>"/>
                                            </div>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="./gastLoeschen/index.php" method="post" name="gastLoeschen"
                                              target="_self" onSubmit="return sicher()">
                                            <div align="right">
                                                <input name="gastLoeschen" type="submit" id="gastLoeschen"
                                                       class="btn btn-danger"
                                                       value="<?php echo(getUebersetzung("Gast löschen", $sprache, $link)); ?>">
                                                <input name="anrede_val" type="hidden" id="anrede_var10"
                                                       value="<?php echo($anrede_val); ?>">
                                                <input name="vorname_val" type="hidden" id="vorname_var"
                                                       value="<?php echo($vorname_val); ?>">
                                                <input name="nachname_val" type="hidden" id="nachname_var"
                                                       value="<?php echo($nachname_val); ?>">
                                                <input name="strasse_val" type="hidden" id="strasse_var"
                                                       value="<?php echo($strasse_val); ?>">
                                                <input name="ort_val" type="hidden" id="ort_var"
                                                       value="<?php echo($ort_val); ?>">
                                                <input name="land_val" type="hidden" id="land_var"
                                                       value="<?php echo($land_val); ?>">
                                                <input name="email_val" type="hidden" id="email_var"
                                                       value="<?php echo($email_val); ?>">
                                                <input name="tel_val" type="hidden" id="tel_var"
                                                       value="<?php echo($tel_val); ?>">
                                                <input name="fax_val" type="hidden" id="anrede_var10"
                                                       value="<?php echo($fax_val); ?>">
                                                <input name="anmerkung_val" type="hidden" id="anrede_var10"
                                                       value="<?php echo($anmerkung_val); ?>">
                                                <input name="plz_val" type="hidden" id="plz_val"
                                                       value="<?php echo($plz_val); ?>">
                                                <input name="gast_id" type="hidden" id="gast_id"
                                                       value="<?php echo($gast_id); ?>">
                                                <input name="sprache_val" type="hidden" id="anrede_var"
                                                       value="<?php echo($sprache_val); ?>">
                                                <input name="index" type="hidden" value="<?php echo($index); ?>"/>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <br/>
            <?php } //ende while
            ?>
            </td>
            </tr>
            <tr>
                <td>
                    <table>
                        <tr>
                            <?php
                            if (($index - LIMIT) > -1) {
                                ?>
                                <td>
                                    <form action="./index.php" method="post" name="zurueck" target="_self"
                                          enctype="multipart/form-data">
                                        <input name="index" type="hidden" value="<?php echo($index - LIMIT); ?>"/>
                                        <input name="plz_val" type="hidden" id="plz_val"
                                               value="<?php echo($plz_val); ?>">
                                        <input name="anrede_val" type="hidden" id="anrede_var"
                                               value="<?php echo($anrede_val); ?>">
                                        <input name="vorname_val" type="hidden" id="vorname_var3"
                                               value="<?php echo($vorname_val); ?>">
                                        <input name="nachname_val" type="hidden" id="anrede_var4"
                                               value="<?php echo($nachname_val); ?>">
                                        <input name="strasse_val" type="hidden" id="anrede_var5"
                                               value="<?php echo($strasse_val); ?>">
                                        <input name="plz_val" type="hidden" id="anrede_var5"
                                               value="<?php echo($plz_val); ?>">
                                        <input name="ort_val" type="hidden" id="anrede_var6"
                                               value="<?php echo($ort_val); ?>">
                                        <input name="land_val" type="hidden" id="anrede_var7"
                                               value="<?php echo($land_val); ?>">
                                        <input name="email_val" type="hidden" id="anrede_var8"
                                               value="<?php echo($email_val); ?>">
                                        <input name="tel_val" type="hidden" id="anrede_var9"
                                               value="<?php echo($tel_val); ?>">
                                        <input name="fax_val" type="hidden" id="anrede_var"
                                               value="<?php echo($fax_val); ?>">
                                        <input name="anmerkung_val" type="hidden" id="anrede_var"
                                               value="<?php echo($anmerkung_val); ?>">
                                        <input name="sprache_val" type="hidden" id="anrede_var"
                                               value="<?php echo($sprache_val); ?>">
                                        <input name="gast_id" type="hidden" id="gast_id"
                                               value="<?php echo($gast_id); ?>">
                                        <?php
                                        showSubmitButton(getUebersetzung("zurückblättern", $sprache, $link));
                                        ?>
                                    </form>
                                </td>
                                <?php
                            }
                            if (($index + LIMIT) < getAnzahlGaeste($unterkunft_id, $link)) {
                                ?>
                                <td>
                                    <form action="./index.php" method="post" name="weiter" target="_self"
                                          enctype="multipart/form-data">
                                        <input name="index" type="hidden" value="<?php echo($index + LIMIT); ?>"/>
                                        <input name="plz_val" type="hidden" id="plz_val"
                                               value="<?php echo($plz_val); ?>">
                                        <input name="anrede_val" type="hidden" id="anrede_var"
                                               value="<?php echo($anrede_val); ?>">
                                        <input name="vorname_val" type="hidden" id="vorname_var3"
                                               value="<?php echo($vorname_val); ?>">
                                        <input name="nachname_val" type="hidden" id="anrede_var4"
                                               value="<?php echo($nachname_val); ?>">
                                        <input name="strasse_val" type="hidden" id="anrede_var5"
                                               value="<?php echo($strasse_val); ?>">
                                        <input name="plz_val" type="hidden" id="anrede_var5"
                                               value="<?php echo($plz_val); ?>">
                                        <input name="ort_val" type="hidden" id="anrede_var6"
                                               value="<?php echo($ort_val); ?>">
                                        <input name="land_val" type="hidden" id="anrede_var7"
                                               value="<?php echo($land_val); ?>">
                                        <input name="email_val" type="hidden" id="anrede_var8"
                                               value="<?php echo($email_val); ?>">
                                        <input name="tel_val" type="hidden" id="anrede_var9"
                                               value="<?php echo($tel_val); ?>">
                                        <input name="fax_val" type="hidden" id="anrede_var"
                                               value="<?php echo($fax_val); ?>">
                                        <input name="anmerkung_val" type="hidden" id="anrede_var"
                                               value="<?php echo($anmerkung_val); ?>">
                                        <input name="sprache_val" type="hidden" id="anrede_var"
                                               value="<?php echo($sprache_val); ?>">
                                        <input name="gast_id" type="hidden" id="gast_id"
                                               value="<?php echo($gast_id); ?>">
                                        <?php
                                        showSubmitButton(getUebersetzung("weiterblättern", $sprache, $link));
                                        ?>
                                    </form>
                                </td>
                                <?php
                            }
                            ?>
                        </tr>
                    </table>
                </td>
            </tr>
            </table>
            <form action="./export/csv.php" method="post" name="hauptmenue" id="hauptmenue">
                <input name="plz_val" type="hidden" id="plz_val" value="<?php echo($plz_val); ?>">
                <input name="anrede_val" type="hidden" id="anrede_var" value="<?php echo($anrede_val); ?>">
                <input name="vorname_val" type="hidden" id="vorname_var3" value="<?php echo($vorname_val); ?>">
                <input name="nachname_val" type="hidden" id="anrede_var4" value="<?php echo($nachname_val); ?>">
                <input name="strasse_val" type="hidden" id="anrede_var5" value="<?php echo($strasse_val); ?>">
                <input name="ort_val" type="hidden" id="anrede_var6" value="<?php echo($ort_val); ?>">
                <input name="land_val" type="hidden" id="anrede_var7" value="<?php echo($land_val); ?>">
                <input name="email_val" type="hidden" id="anrede_var8" value="<?php echo($email_val); ?>">
                <input name="tel_val" type="hidden" id="anrede_var9" value="<?php echo($tel_val); ?>">
                <input name="fax_val" type="hidden" id="anrede_var" value="<?php echo($fax_val); ?>">
                <input name="anmerkung_val" type="hidden" id="anrede_var" value="<?php echo($anmerkung_val); ?>">
                <input name="sprache_val" type="hidden" id="anrede_var" value="<?php echo($sprache_val); ?>">


                <div class="row">
                    <div class="col-sm-2">
                        <select name="format" size="1" class="btn btn-primary">
                            <option value="csv"><?php echo(getUebersetzung("Text", $sprache, $link)); ?> CSV</option>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <input name="exportieren" type="submit" class="btn btn-primary"
                               value="<?php echo(getUebersetzung("exportieren", $sprache, $link)); ?>">
                    </div>
                </div>
            </form>

        <?php } //ende passwortprüfung
        else {
            echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!", $sprache, $link));
        }
        ?>
        <div class="row">
            <hr>
        </div>
        <div class="row">
            <div class="col-sm-offset-10 col-sm-2">
                <a class="btn btn-primary" href="../../gaesteBearbeiten/index.php">
<!--                    <span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>&nbsp-->
                    <?php echo(getUebersetzung("Abbrechen", $sprache, $link)); ?></a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
