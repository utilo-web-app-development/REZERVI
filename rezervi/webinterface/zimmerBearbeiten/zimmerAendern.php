<?php session_start();
$root = "../..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once($root . "/include/sessionFunctions.inc.php");
/*   
			reservierungsplan
			ein neues zimmer anlegen.
*/
//datenbank öffnen:
include_once("../../conf/rdbmsConfig.php");

//andere funktionen importieren:
include_once("../../include/benutzerFunctions.php");
include_once("../../include/unterkunftFunctions.php");
include_once("../../include/einstellungenFunctions.php");
include_once("../../include/uebersetzer.php");
include_once("../../include/zimmerFunctions.php");
include_once($root . "/include/zimmerAttributes.inc.php");
include_once($root . "/include/propertiesFunctions.php");

//variablen intitialisieren:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$benutzername = getSessionWert(BENUTZERNAME);
$passwort = getSessionWert(PASSWORT);
$zimmer_id = $_POST["zimmer_id"];
$sprache = getSessionWert(SPRACHE);
$standardsprache = getStandardSprache($unterkunft_id, $link);

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
<?php //passwortprüfung:	
if (checkPass($benutzername, $passwort, $unterkunft_id, $link)){

$betten = getBetten($unterkunft_id, $zimmer_id, $link);
$bettenKinder = getBettenKinder($unterkunft_id, $zimmer_id, $link);
$linkName = getLink($unterkunft_id, $zimmer_id, $link);
$haustiere = getHaustiere($unterkunft_id, $zimmer_id, $link);

?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h2><?php echo(getUebersetzung("Zimmer/Appartement/Wohnung/etc. bearbeiten", $sprache, $link)); ?></h2>
    </div>
    <div class="panel-body">

        <form action="./zimmerAendernDurchfuehren.php" method="post" name="zimmerAendern" id="zimmerAendern"  target="_self"   class="form-horizontal">


            <h5> <?php echo(getUebersetzung("Bitte füllen Sie die untenstehenden Felder aus.", $sprache, $link)); ?>
                <?php echo(getUebersetzung("Die mit [*] gekennzeichneten Felder müssen ausgefüllt werden", $sprache, $link)); ?>
                !</h5>

            <?php
            if (isGermanShown($unterkunft_id, $link)) {
                //daten des ausgewählten zimmers auslesen:
                $zimmernr = getUebersetzungUnterkunft(getZimmerNr($unterkunft_id, $zimmer_id, $link), "de", $unterkunft_id, $link);
                $zimmerart = getUebersetzungUnterkunft(getZimmerArt($unterkunft_id, $zimmer_id, $link), "de", $unterkunft_id, $link);
                ?>

                <div class="form-group">
                    <label for="zimmerart" class="col-sm-7 control-label">
                        <?php echo(getUebersetzung("Zimmerart in deutsch", $sprache, $link)); ?>
                        <?php echo(getUebersetzung("(z. B. Zimmer, Wohnung, Ferienwohnung, Appartement, etc.)", $sprache, $link)); ?>
                        <?php if ($standardsprache == "de") { ?>
                            *
                        <?php } else {
                            ?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
                            <?php
                        }
                        ?>    </label>
                    <div class="col-sm-5">
                        <input name="zimmerart" type="text" id="zimmerart" value="<?php if (isset($zimmerart)) {
                            echo($zimmerart);
                        } ?>" class="form-control">
                    </div>
                </div>

                <?php
            }
            if (isEnglishShown($unterkunft_id, $link)) {
                $zimmernr_en = getUebersetzungUnterkunft(getZimmerNr($unterkunft_id, $zimmer_id, $link), "en", $unterkunft_id, $link);
                $zimmerart_en = getUebersetzungUnterkunft(getZimmerArt($unterkunft_id, $zimmer_id, $link), "en", $unterkunft_id, $link);
                ?>
                <div class="form-group">
                    <label for="zimmerart_en"
                           class="col-sm-7 control-label"><?php echo(getUebersetzung("Zimmerart in englisch", $sprache, $link)); ?>
                        <?php if ($standardsprache == "en") { ?>
                            *
                        <?php } else {
                            ?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
                            <?php
                        }
                        ?>    </label>
                    <div class="col-sm-5">
                        <input name="zimmerart_en" type="text" id="zimmerart_en"
                               value="<?php if (isset($zimmerart_en)) {
                                   echo($zimmerart_en);
                               } ?>" class="form-control">
                    </div>

                </div>


                <?php
            }
            if (isFrenchShown($unterkunft_id, $link)) {
                $zimmernr_fr = getUebersetzungUnterkunft(getZimmerNr($unterkunft_id, $zimmer_id, $link), "fr", $unterkunft_id, $link);
                $zimmerart_fr = getUebersetzungUnterkunft(getZimmerArt($unterkunft_id, $zimmer_id, $link), "fr", $unterkunft_id, $link);
                ?>
                <div class="form-group">
                    <label for="zimmerart_fr"
                           class="col-sm-7 control-label"><?php echo(getUebersetzung("Zimmerart in französisch", $sprache, $link)); ?>
                        <?php if ($standardsprache == "fr") { ?>
                            *
                        <?php } else {
                            ?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
                            <?php
                        }
                        ?>    </label>
                    <div class="col-sm-5">
                        <input name="zimmerart_fr" type="text" id="zimmerart_fr"
                               value="<?php if (isset($zimmerart_fr)) {
                                   echo($zimmerart_fr);
                               } ?>" class="form-control">
                    </div>
                </div>

                <?php
            }
            if (isItalianShown($unterkunft_id, $link)) {
                $zimmernr_it = getUebersetzungUnterkunft(getZimmerNr($unterkunft_id, $zimmer_id, $link), "it", $unterkunft_id, $link);
                $zimmerart_it = getUebersetzungUnterkunft(getZimmerArt($unterkunft_id, $zimmer_id, $link), "it", $unterkunft_id, $link);
                ?>
                <div class="form-group">
                    <label for="zimmerart_it"
                           class="col-sm-7 control-label"><?php echo(getUebersetzung("Zimmerart in italienisch", $sprache, $link)); ?>
                        <?php if ($standardsprache == "it") { ?>
                            *
                        <?php } else {
                            ?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
                            <?php
                        }
                        ?>
                    </label>
                    <div class="col-sm-5">
                        <input name="zimmerart_it" type="text" id="zimmerart_it"
                               value="<?php if (isset($zimmerart_it)) {
                                   echo($zimmerart_it);
                               } ?>" class="form-control">
                    </div>
                </div>

                <?php
            }
            if (isNetherlandsShown($unterkunft_id, $link)) {
                $zimmernr_nl = getUebersetzungUnterkunft(getZimmerNr($unterkunft_id, $zimmer_id, $link), "nl", $unterkunft_id, $link);
                $zimmerart_nl = getUebersetzungUnterkunft(getZimmerArt($unterkunft_id, $zimmer_id, $link), "nl", $unterkunft_id, $link);
                ?>
                <div class="form-group">
                    <label for="zimmerart_nl"
                           class="col-sm-7 control-label"><?php echo(getUebersetzung("Zimmerart in holländisch", $sprache, $link)); ?>
                        <?php if ($standardsprache == "nl") { ?>
                            *
                        <?php } else {
                            ?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
                            <?php
                        }
                        ?>
                    </label>
                    <div class="col-sm-5">
                        <input name="zimmerart_nl" type="text" id="zimmerart_nl"
                               value="<?php if (isset($zimmerart_nl)) {
                                   echo($zimmerart_nl);
                               } ?>" class="form-control">
                    </div>
                </div>

                <?php
            }
            if (isEspaniaShown($unterkunft_id, $link)) {
                $zimmernr_sp = getUebersetzungUnterkunft(getZimmerNr($unterkunft_id, $zimmer_id, $link), "sp", $unterkunft_id, $link);
                $zimmerart_sp = getUebersetzungUnterkunft(getZimmerArt($unterkunft_id, $zimmer_id, $link), "sp", $unterkunft_id, $link);
                ?>
                <div class="form-group">
                    <label for="zimmerart_sp"
                           class="col-sm-7 control-label"><?php echo(getUebersetzung("Zimmerart in spanisch", $sprache, $link)); ?>
                        <?php if ($standardsprache == "sp") { ?>
                            *
                        <?php } else {
                            ?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
                            <?php
                        }
                        ?>
                    </label>
                    <div class="col-sm-5">
                        <input name="zimmerart_sp" type="text" id="zimmerart_sp"
                               value="<?php if (isset($zimmerart_sp)) {
                                   echo($zimmerart_sp);
                               } ?>" class="form-control">
                    </div>
                </div>

                <?php
            }
            if (isEstoniaShown($unterkunft_id, $link)) {
                $zimmernr_es = getUebersetzungUnterkunft(getZimmerNr($unterkunft_id, $zimmer_id, $link), "es", $unterkunft_id, $link);
                $zimmerart_es = getUebersetzungUnterkunft(getZimmerArt($unterkunft_id, $zimmer_id, $link), "es", $unterkunft_id, $link);
                ?>
                <div class="form-group">
                    <label for="zimmerart_es" class="col-sm-7 control-label">
                        <?php echo(getUebersetzung("Zimmerart in estnisch", $sprache, $link)); ?>
                        <?php if ($standardsprache == "es") { ?>
                            *
                        <?php } else {
                            ?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
                            <?php
                        }
                        ?>
                    </label>
                    <div class="col-sm-5">
                        <input name="zimmerart_es" type="text" id="zimmerart_es"
                               value="<?php if (isset($zimmerart_es)) {
                                   echo($zimmerart_es);
                               } ?>" class="form-control">
                    </div>
                </div>

                <?php
            }
            ?>

            <?php
            if (isGermanShown($unterkunft_id, $link)) {
                ?>
                <div class="form-group">
                    <label for="zimmernr" class="col-sm-7 control-label ">
                        <?php echo(getUebersetzung("Zimmernummer in deutsch (z. B. Typ A, Nr. 10, Balkonzimmer, etc.)", $sprache, $link)); ?>
                        <?php if ($standardsprache == "de") { ?>
                            *
                        <?php } else {
                            ?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
                            <?php
                        }
                        ?>
                    </label>
                    <div class="col-sm-5">
                        <input name="zimmernr" type="text" id="zimmernr"
                               value="<?php if (isset($zimmernr)) {
                                   echo($zimmernr);
                               } ?>"
                               class="form-control" maxlength="30">
                    </div>
                </div>

                <?php
            }
            if (isEnglishShown($unterkunft_id, $link)) {
                ?>
                <div class="form-group">
                    <label for="zimmernr_en" class="col-sm-7 control-label ">
                        <?php echo(getUebersetzung("Zimmernummer in englisch (z. B. Typ A, Nr. 10, Balkonzimmer, etc.)", $sprache, $link)); ?>
                        <?php if ($standardsprache == "en") { ?>
                            *
                        <?php } else {
                            ?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
                            <?php
                        }
                        ?>
                    </label>
                    <div class="col-sm-5">
                        <input name="zimmernr_en" type="text" id="zimmernr_en" value="<?php if (isset($zimmernr_en)) {
                            echo($zimmernr_en);
                        } ?>"
                               class="form-control" maxlength="30">
                    </div>
                </div>

                <?php
            }
            if (isFrenchShown($unterkunft_id, $link)) {
                ?>
                <div class="form-group">
                    <label for="zimmernr_fr" class="col-sm-7 control-label ">
                        <?php echo(getUebersetzung("Zimmernummer in französisch (z. B. Typ A, Nr. 10, Balkonzimmer, etc.)", $sprache, $link)); ?>
                        <?php if ($standardsprache == "fr") { ?>
                            *
                        <?php } else {
                            ?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
                            <?php
                        }
                        ?>
                    </label>
                    <div class="col-sm-5">
                        <input name="zimmernr_fr" type="text" id="zimmernr_fr" value="<?php if (isset($zimmernr_fr)) {
                            echo($zimmernr_fr);
                        } ?>"
                               class="form-control" maxlength="30">
                    </div>
                </div>

                <?php
            }
            if (isItalianShown($unterkunft_id, $link)) {
                ?>
                <div class="form-group">
                    <label for="zimmernr_it" class="col-sm-7 control-label ">
                        <?php echo(getUebersetzung("Zimmernummer in italienisch (z. B. Typ A, Nr. 10, Balkonzimmer, etc.)", $sprache, $link)); ?>
                        <?php if ($standardsprache == "it") { ?>
                            *
                        <?php } else {
                            ?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
                            <?php
                        }
                        ?>
                    </label>
                    <div class="col-sm-5">
                        <input name="zimmernr_it" type="text" id="zimmernr_it" value="<?php if (isset($zimmernr_it)) {
                            echo($zimmernr_it);
                        } ?>"
                               class="form-control" maxlength="30">
                    </div>
                </div>

                <?php
            }
            if (isNetherlandsShown($unterkunft_id, $link)) {
                ?>
                <div class="form-group">
                    <label for="zimmernr_nl" class="col-sm-7 control-label ">
                        <?php echo(getUebersetzung("Zimmernummer in holländisch (z. B. Typ A, Nr. 10, Balkonzimmer, etc.)", $sprache, $link)); ?>
                        <?php if ($standardsprache == "nl") { ?>
                            *
                        <?php } else {
                            ?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
                            <?php
                        }
                        ?>
                    </label>
                    <div class="col-sm-5">
                        <input name="zimmernr_nl" type="text" id="zimmernr_nl" value="<?php if (isset($zimmernr_nl)) {
                            echo($zimmernr_nl);
                        } ?>"
                               class="form-control" maxlength="30">
                    </div>
                </div>

                <?php
            }
            if (isEspaniaShown($unterkunft_id, $link)) {
                ?>
                <div class="form-group">
                    <label for="zimmernr_sp" class="col-sm-7 control-label ">
                        <?php echo(getUebersetzung("Zimmernummer in spanisch (z. B. Typ A, Nr. 10, Balkonzimmer, etc.)", $sprache, $link)); ?>
                        <?php if ($standardsprache == "sp") { ?>
                            *
                        <?php } else {
                            ?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
                            <?php
                        }
                        ?>
                    </label>
                    <div class="col-sm-5">
                        <input name="zimmernr_sp" type="text" id="zimmernr_sp" value="<?php if (isset($zimmernr_sp)) {
                            echo($zimmernr_sp);
                        } ?>"
                               class="form-control" maxlength="30">
                    </div>
                </div>

                <?php
            }
            if (isEstoniaShown($unterkunft_id, $link)) {
                ?>
                <div class="form-group">
                    <label for="zimmernr_es" class="col-sm-7 control-label ">
                        ><?php echo(getUebersetzung("Zimmernummer in estnisch (z. B. Typ A, Nr. 10, Balkonzimmer, etc.)", $sprache, $link)); ?>
                        <?php if ($standardsprache == "es") { ?>
                            *
                        <?php } else {
                            ?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
                            <?php
                        }
                        ?>
                    </label>
                    <div class="col-sm-5">
                        <input name="zimmernr_es" type="text" id="zimmernr_es" value="<?php if (isset($zimmernr_es)) {
                            echo($zimmernr_es);
                        } ?>"
                               class="form-control" maxlength="30">
                    </div>
                </div>

                <?php
            }
            ?>
            <div class="form-group">
                <label for="betten" class="col-sm-7 control-label ">
                    <?php echo(getUebersetzung("Anzahl der Betten für Erwachsene", $sprache, $link)); ?>
                </label>
                <div class="col-sm-5">
                    <input name="betten" type="text" id="betten" value="<?php if (isset($betten)) {
                        echo($betten);
                    } ?>"
                           class="form-control" maxlength="6">
                </div>
            </div>
            <div class="form-group">
                <label for="bettenKinder" class="col-sm-7 control-label ">
                    <?php echo(getUebersetzung("Anzahl der Betten für Kinder", $sprache, $link)); ?>
                </label>
                <div class="col-sm-5">
                    <input name="bettenKinder" type="text" id="bettenKinder" value="<?php if (isset($bettenKinder)) {
                        echo($bettenKinder);
                    } ?>"
                           class="form-control" maxlength="6">
                </div>
            </div>

            <div class="form-group">
                <label for="linkName" class="col-sm-7 control-label ">
                    <?php echo(getUebersetzung("URL zu weiteren Informationen (z. B. http://www.rezervi.com/index.php)", $sprache, $link)); ?>
                </label>
                <div class="col-sm-5">
                    <input name="linkName" type="text" id="linkName" value="<?php if (isset($linkName)) {
                        echo($linkName);
                    } ?>"
                           class="form-control" maxlength="100">
                </div>
            </div>
            <div class="form-group">
                <label for="zimmernr_es" class="col-sm-7 control-label ">
                    <?php echo(getUebersetzung("Haustiere erlaubt", $sprache, $link)); ?>
                </label>
                <div class="col-sm-5">
                    <select class="form-control" name="Haustiere" id="Haustiere">
                        <option
                            value="true" <?php if ($haustiere == "true") echo("selected=\"selected\""); ?>><?php echo(getUebersetzung("ja", $sprache, $link)); ?></option>
                        <option
                            value="false" <?php if ($haustiere == "false") echo("selected=\"selected\""); ?>><?php echo(getUebersetzung("nein", $sprache, $link)); ?></option>
                    </select>
                </div>
            </div>

            <?php
            //sollen auch noch weitere attribute angezeigt werden?
            if (getPropertyValue(SHOW_ZIMMER_ATTRIBUTE_GESAMTUEBERSICHT, $unterkunft_id, $link) == "true") {
                $res = getAttributes();
                while ($d = mysqli_fetch_array($res)) {
                    $bezeichnung = $d["Bezeichnung"];
                    $beschreibung = $d["Beschreibung"];
                    $att_id = $d["PK_ID"];
                    $wert = getAttributValue($att_id, $zimmer_id);
                    ?>
                    <div class="form-group">
                        <label for="attWert_<?php echo $att_id ?>" class="col-sm-7 control-label ">
                            <?php echo $bezeichnung ?>
                            <?php if (!empty($beschreibung)){ ?>
                            (<?php echo $beschreibung ?>)
                        </label>
                        <?php } ?>
                        <div class="col-sm-5">
                            <input name="attWert_<?php echo $att_id ?>" type="text"
                                   id="attWert_<?php echo $att_id ?>"
                                   value="<?php echo $wert ?>"/>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
            <div class="form-group">
                <div class="col-md-offset-9 col-sm-3" style="text-align: right;">
                    <input name="zimmer_id" type="hidden" id="zimmer_id" value="<?php echo($zimmer_id); ?>">
                    <a name="submit" id="Submit" class="btn btn-success" onclick="checkForm('zimmerAendern');">
                        <?php echo(getUebersetzung("Zimmer ändern", $sprache, $link)); ?>
                    </a>
                    <a class="btn btn-primary" href="./index.php">
                        <!--                        <span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>&nbsp;-->
                        <?php echo(getUebersetzung("Abbrechen", $sprache, $link)); ?>
                    </a>
                </div>
            </div>

        </form>
        <?php
        } //ende if passwortprüfung
        else {
            echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!", $sprache, $link));
        }
        ?>
    </div>
</div>

<?php include_once("../templates/end.php"); ?>
