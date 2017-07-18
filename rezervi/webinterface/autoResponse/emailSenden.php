<?php session_start();
$root = "../..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once($root . "/include/sessionFunctions.inc.php");
/*
			reservierungsplan
			startseite zur wartung des designs
			author: christian osterrieder utilo.eu
*/

//variablen:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
$sprache = getSessionWert(SPRACHE);

//variablen initialisieren:
if (isset($_POST["ben"]) && isset($_POST["pass"])) {
    $ben = $_POST["ben"];
    $pass = $_POST["pass"];
} else {
    //aufruf kam innerhalb des webinterface:
    $ben = getSessionWert(BENUTZERNAME);
    $pass = getSessionWert(PASSWORT);
}

//datenbank öffnen:
include_once("../../conf/rdbmsConfig.php");

//andere funktionen importieren:
include_once("../../include/benutzerFunctions.php");
include_once("../../include/unterkunftFunctions.php");
include_once("../../include/gastFunctions.php");
include_once("../../include/autoResponseFunctions.php");
include_once("../../include/einstellungenFunctions.php");
include_once("../../include/propertiesFunctions.php");
include_once("../../include/uebersetzer.php");
include_once("../templates/components.php");
//uebersetzer einfuegen:
include_once("../../include/uebersetzer.php");

$benutzer_id = -1;
if (isset($ben) && isset($pass)) {
    $benutzer_id = checkPassword($ben, $pass, $link);
}
if ($benutzer_id == -1) {
    //passwortprüfung fehlgeschlagen, auf index-seite zurück:
    $fehlgeschlagen = true;
    header("Location: ".$URL."webinterface/index.php?fehlgeschlagen=true"); /* Redirect browser */
    exit();
    //include_once("./index.php");
    //exit;
} else {
    $benutzername = $ben;
    $passwort = $pass;
    setSessionWert(BENUTZERNAME, $benutzername);
    setSessionWert(PASSWORT, $passwort);

    //unterkunft-id holen:
    $unterkunft_id = getUnterkunftID($benutzer_id, $link);
    setSessionWert(UNTERKUNFT_ID, $unterkunft_id);
    setSessionWert(BENUTZER_ID, $benutzer_id);
}

$standardsprache = getStandardSprache($unterkunft_id, $link);

//variablen initialisieren:
$subject_de = "";
$anrede_de = "";
$text_de = "";
$unterschrift_de = "";
$subject_en = "";
$anrede_en = "";
$text_en = "";
$unterschrift_en = "";
$subject_fr = "";
$anrede_fr = "";
$text_fr = "";
$unterschrift_fr = "";
$subject_it = "";
$anrede_it = "";
$text_it = "";
$unterschrift_it = "";
$subject_nl = "";
$anrede_nl = "";
$text_nl = "";
$unterschrift_nl = "";
$subject_sp = "";
$anrede_sp = "";
$text_sp = "";
$unterschrift_sp = "";
$subject_es = "";
$anrede_es = "";
$text_es = "";
$unterschrift_es = "";


?>
<?php include_once("../templates/headerA.php"); ?>
<style type="text/css">
    <?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../templates/headerB.php"); ?>
<?php include_once("../templates/bodyA.php"); ?>
<?php
//passwortprüfung:
if (checkPass($benutzername, $passwort, $unterkunft_id, $link)){
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <?php
         if (isset($_POST["emails"])) {
            $art = "emails";
            ?>
            <h1><?php echo(getUebersetzung("Senden von E-Mails an Ihre Gäste", $sprache, $link)); ?></h1>
            <?php
        }

        ?>
    </div>
    <div class="panel-body">

        <form action="./texteAendern.php" method="post" name="adresseForm" target="_self"
              onSubmit="return chkFormular();" class="form-horizontal">
            <input name="art" type="hidden" value="<?php echo($art); ?>">
            <h4>
                <?php echo(getUebersetzung("Die mit [*] gekennzeichneten Felder müssen ausgefüllt werden", $sprache, $link)); ?>
                !
            </h4>
            <?php
            if (isset($fehler) && $fehler == true) {
                ?>
                <p class="lead"> <?php echo($message); ?></p>

                <?php
            }
            ?>
            <div id="accordion" role="tablist" aria-multiselectable="true">
                <?php
                if (isGermanShown($unterkunft_id, $link)) {
                    ?>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                                   aria-expanded="true" aria-controls="collapseOne">
                                    <?php echo(getUebersetzung("Texte in Deutsch", $sprache, $link));
                                    if ($standardsprache != "de") {
                                        ?>
                                        (<?php echo(getUebersetzung("Wenn sie diese Felder leer lassen wird auch in dieser Sprache die Standardsprache verwendet.", $sprache, $link)); ?>):
                                        <?php
                                    } else {
                                        echo("*");
                                    }
                                    ?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse" role="tabpanel"
                             aria-labelledby="headingOne">
                            <br>
                            <div class="form-group">
                                <label for="subject_de"
                                       class="col-sm-2 control-label"><?php echo(getUebersetzung("Betreff", $sprache, $link)); ?></label>
                                <div class="col-sm-10">
                                    <input name="subject_de" type="text" id="subject_de"
                                           value="<?php echo($subject_de); ?>"
                                           class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="anrede_de"
                                       class="col-sm-2 control-label"> <?php echo(getUebersetzung("Anrede", $sprache, $link)); ?></label>
                                <div class="col-sm-10">
                                    <input name="anrede_de" type="text" id="anrede_de"
                                           value="<?php echo($anrede_de); ?>"
                                           class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="subject_de" class="col-sm-2 control-label"> </label>
                                <div class="col-sm-10">
                                    (<?php echo(getUebersetzung("Nach ihrer Anrede wird der Name des Gastes automatisch eingesetzt", $sprache, $link)); ?>
                                    )
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="text_de"
                                       class="col-sm-2 control-label"><?php echo(getUebersetzung("Text", $sprache, $link)); ?></label>
                                <div class="col-sm-10">
                                    <textarea name="text_de" type="text" id="text_de" "
                                    class="form-control"><?php echo($text_de); ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="unterschrift_de"
                                       class="col-sm-2 control-label"> <?php echo(getUebersetzung("Unterschrift", $sprache, $link)); ?></label>
                                <div class="col-sm-10">
                                    <textarea name="unterschrift_de" type="text" id="unterschrift_de" "
                                    class="form-control"><?php echo($unterschrift_de); ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <?php
                if (isEnglishShown($unterkunft_id, $link)) {
                    ?>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingTwo">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"
                                   aria-expanded="true" aria-controls="collapseTwo">
                                    <?php echo(getUebersetzung("Texte in Englisch", $sprache, $link));
                                    if ($standardsprache != "en") {
                                        ?>
                                        (<?php echo(getUebersetzung("Wenn sie diese Felder leer lassen wird auch in dieser Sprache die Standardsprache verwendet.", $sprache, $link)); ?>):
                                        <?php
                                    } else {
                                        echo("*");
                                    }
                                    ?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel"
                             aria-labelledby="headingTwo">
                            <br>
                            <div class="form-group">
                                <label for="subject_de"
                                       class="col-sm-2 control-label"><?php echo(getUebersetzung("Betreff", $sprache, $link)); ?></label>
                                <div class="col-sm-10">
                                    <input name="subject_en" type="text" id="subject_en"
                                           value="<?php echo($subject_en); ?>"
                                           class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="anrede_en"
                                       class="col-sm-2 control-label"> <?php echo(getUebersetzung("Anrede", $sprache, $link)); ?></label>
                                <div class="col-sm-10">
                                    <input name="anrede_en" type="text" id="anrede_en"
                                           value="<?php echo($anrede_en); ?>"
                                           class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="anrede_en" class="col-sm-2 control-label"> </label>
                                <div class="col-sm-10">
                                    (<?php echo(getUebersetzung("Nach ihrer Anrede wird der Name des Gastes automatisch eingesetzt", $sprache, $link)); ?>
                                    )
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="text_en"
                                       class="col-sm-2 control-label"><?php echo(getUebersetzung("Text", $sprache, $link)); ?></label>
                                <div class="col-sm-10">
                                    <textarea name="text_en" type="text" id="text_en" "
                                    class="form-control"><?php echo($text_en); ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="unterschrift_en"
                                       class="col-sm-2 control-label"> <?php echo(getUebersetzung("Unterschrift", $sprache, $link)); ?></label>
                                <div class="col-sm-10">
                                    <textarea name="unterschrift_en" type="text" id="unterschrift_en" "
                                    class="form-control"><?php echo($unterschrift_en); ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <?php
                if (isFrenchShown($unterkunft_id, $link)) {
                    ?>

                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingThree">
                            <h4 class="panel-title">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion"
                                   href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    <?php echo(getUebersetzung("Texte in Französisch", $sprache, $link));
                                    if ($standardsprache != "fr") {
                                        ?>
                                        (<?php echo(getUebersetzung("Wenn sie diese Felder leer lassen wird auch in dieser Sprache die Standardsprache verwendet.", $sprache, $link)); ?>):
                                        <?php
                                    } else {
                                        echo("*");
                                    }
                                    ?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel"
                             aria-labelledby="headingThree">
                            <br>
                            <div class="form-group">
                                <label for="subject_fr"
                                       class="col-sm-2 control-label"><?php echo(getUebersetzung("Betreff", $sprache, $link)); ?></label>
                                <div class="col-sm-10">
                                    <input name="subject_fr" type="text" id="subject_fr"
                                           value="<?php echo($subject_fr); ?>"
                                           class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="anrede_fr"
                                       class="col-sm-2 control-label"> <?php echo(getUebersetzung("Anrede", $sprache, $link)); ?></label>
                                <div class="col-sm-10">
                                    <input name="anrede_fr" type="text" id="anrede_fr"
                                           value="<?php echo($anrede_fr); ?>"
                                           class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="anrede_fr" class="col-sm-2 control-label"> </label>
                                <div class="col-sm-10">
                                    (<?php echo(getUebersetzung("Nach ihrer Anrede wird der Name des Gastes automatisch eingesetzt", $sprache, $link)); ?>
                                    )
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="text_fr"
                                       class="col-sm-2 control-label"><?php echo(getUebersetzung("Text", $sprache, $link)); ?></label>
                                <div class="col-sm-10">
                                    <textarea name="text_fr" type="text" id="text_fr" "
                                    class="form-control"><?php echo($text_fr); ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="unterschrift_fr"
                                       class="col-sm-2 control-label"> <?php echo(getUebersetzung("Unterschrift", $sprache, $link)); ?></label>
                                <div class="col-sm-10">
                                    <textarea name="unterschrift_fr" type="text" id="unterschrift_fr" "
                                    class="form-control"><?php echo($unterschrift_fr); ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                if (isItalianShown($unterkunft_id, $link)) {
                    ?>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingFour">
                            <h4 class="panel-title">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion"
                                   href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    <?php echo(getUebersetzung("Texte in Italienisch", $sprache, $link));
                                    if ($standardsprache != "it") {
                                        ?>
                                        (<?php echo(getUebersetzung("Wenn sie diese Felder leer lassen wird auch in dieser Sprache die Standardsprache verwendet.", $sprache, $link)); ?>
                                        ):
                                        <?php
                                    } else {
                                        echo("*");
                                    }
                                    ?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapseFour" class="panel-collapse collapse" role="tabpanel"
                             aria-labelledby="headingFour">
                            <br>
                            <div class="form-group">
                                <label for="subject_it"
                                       class="col-sm-2 control-label"><?php echo(getUebersetzung("Betreff", $sprache, $link)); ?></label>
                                <div class="col-sm-10">
                                    <input name="subject_it" type="text" id="subject_it"
                                           value="<?php echo($subject_it); ?>"
                                           class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="anrede_it"
                                       class="col-sm-2 control-label"> <?php echo(getUebersetzung("Anrede", $sprache, $link)); ?></label>
                                <div class="col-sm-10">
                                    <input name="anrede_it" type="text" id="anrede_it"
                                           value="<?php echo($anrede_it); ?>"
                                           class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="anrede_it" class="col-sm-2 control-label"> </label>
                                <div class="col-sm-10">
                                    (<?php echo(getUebersetzung("Nach ihrer Anrede wird der Name des Gastes automatisch eingesetzt", $sprache, $link)); ?>
                                    )
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="text_fr"
                                       class="col-sm-2 control-label"><?php echo(getUebersetzung("Text", $sprache, $link)); ?></label>
                                <div class="col-sm-10">
                                    <textarea name="text_it" type="text" id="text_it" "
                                    class="form-control"><?php echo($text_fr); ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="unterschrift_it"
                                       class="col-sm-2 control-label"> <?php echo(getUebersetzung("Unterschrift", $sprache, $link)); ?></label>
                                <div class="col-sm-10">
                                    <textarea name="unterschrift_it" type="text" id="unterschrift_it" "
                                    class="form-control"><?php echo($unterschrift_it); ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                }
                if (isNetherlandsShown($unterkunft_id, $link)) {
                    ?>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingFive">
                            <h4 class="panel-title">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion"
                                   href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    <?php echo(getUebersetzung("Texte in Holländisch", $sprache, $link));
                                    if ($standardsprache != "nl") {
                                        ?>
                                        (<?php echo(getUebersetzung("Wenn sie diese Felder leer lassen wird auch in dieser Sprache die Standardsprache verwendet.", $sprache, $link)); ?>):
                                        <?php
                                    } else {
                                        echo("*");
                                    }
                                    ?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapseFive" class="panel-collapse collapse" role="tabpanel"
                             aria-labelledby="headingFive">
                            <br>
                            <div class="form-group">
                                <label for="subject_it"
                                       class="col-sm-2 control-label"><?php echo(getUebersetzung("Betreff", $sprache, $link)); ?></label>
                                <div class="col-sm-10">
                                    <input name="subject_it" type="text" id="subject_it"
                                           value="<?php echo($subject_it); ?>"
                                           class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="anrede_it"
                                       class="col-sm-2 control-label"> <?php echo(getUebersetzung("Anrede", $sprache, $link)); ?></label>
                                <div class="col-sm-10">
                                    <input name="anrede_it" type="text" id="anrede_it"
                                           value="<?php echo($anrede_it); ?>"
                                           class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="anrede_it" class="col-sm-2 control-label"> </label>
                                <div class="col-sm-10">
                                    (<?php echo(getUebersetzung("Nach ihrer Anrede wird der Name des Gastes automatisch eingesetzt", $sprache, $link)); ?>
                                    )
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="text_fr"
                                       class="col-sm-2 control-label"><?php echo(getUebersetzung("Text", $sprache, $link)); ?></label>
                                <div class="col-sm-10">
                                    <textarea name="text_it" type="text" id="text_it" "
                                    class="form-control"><?php echo($text_fr); ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="unterschrift_it"
                                       class="col-sm-2 control-label"> <?php echo(getUebersetzung("Unterschrift", $sprache, $link)); ?></label>
                                <div class="col-sm-10">
                                    <textarea name="unterschrift_it" type="text" id="unterschrift_it" "
                                    class="form-control"><?php echo($unterschrift_fr); ?></textarea>

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                if (isEspaniaShown($unterkunft_id, $link)) {
                    ?>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingSix">
                            <h4 class="panel-title">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseSix"
                                   aria-expanded="false" aria-controls="collapseSix">
                                    <?php echo(getUebersetzung("Texte in Spanisch", $sprache, $link));
                                    if ($standardsprache != "sp") {
                                        ?>
                                        (<?php echo(getUebersetzung("Wenn sie diese Felder leer lassen wird auch in dieser Sprache die Standardsprache verwendet.", $sprache, $link)); ?>):
                                        <?php
                                    } else {
                                        echo("*");
                                    }
                                    ?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapseSix" class="panel-collapse collapse" role="tabpanel"
                             aria-labelledby="headingSix">
                            <br>
                            <div class="form-group">
                                <label for="subject_sp"
                                       class="col-sm-2 control-label"><?php echo(getUebersetzung("Betreff", $sprache, $link)); ?></label>
                                <div class="col-sm-10">
                                    <input name="subject_sp" type="text" id="subject_sp"
                                           value="<?php echo($subject_sp); ?>"
                                           class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="anrede_sp"
                                       class="col-sm-2 control-label"> <?php echo(getUebersetzung("Anrede", $sprache, $link)); ?></label>
                                <div class="col-sm-10">
                                    <input name="anrede_sp" type="text" id="anrede_sp"
                                           value="<?php echo($anrede_es); ?>"
                                           class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="anrede_sp" class="col-sm-2 control-label"> </label>
                                <div class="col-sm-10">
                                    (<?php echo(getUebersetzung("Nach ihrer Anrede wird der Name des Gastes automatisch eingesetzt", $sprache, $link)); ?>
                                    )
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="text_sp"
                                       class="col-sm-2 control-label"><?php echo(getUebersetzung("Text", $sprache, $link)); ?></label>
                                <div class="col-sm-10">
                                    <textarea name="text_sp" type="text" id="text_sp" "
                                    class="form-control"><?php echo($text_sp); ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="unterschrift_sp"
                                       class="col-sm-2 control-label"> <?php echo(getUebersetzung("Unterschrift", $sprache, $link)); ?></label>
                                <div class="col-sm-10">
                                    <textarea name="unterschrift_sp" type="text" id="unterschrift_sp" "
                                    class="form-control"><?php echo($unterschrift_sp); ?></textarea>

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                if (isEstoniaShown($unterkunft_id, $link)) {
                    ?>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingSeven">
                            <h4 class="panel-title">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion"
                                   href="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                    <?php echo(getUebersetzung("Texte in Estnisch", $sprache, $link));
                                    if ($standardsprache != "es") {
                                        ?>
                                        (<?php echo(getUebersetzung("Wenn sie diese Felder leer lassen wird auch in dieser Sprache die Standardsprache verwendet.", $sprache, $link)); ?>):
                                        <?php
                                    } else {
                                        echo("*");
                                    }
                                    ?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapseSeven" class="panel-collapse collapse" role="tabpanel"
                             aria-labelledby="headingSeven">
                            <br>
                            <div class="form-group">
                                <label for="subject_es"
                                       class="col-sm-2 control-label"><?php echo(getUebersetzung("Betreff", $sprache, $link)); ?></label>
                                <div class="col-sm-10">
                                    <input name="subject_es" type="text" id="subject_es"
                                           value="<?php echo($subject_es); ?>"
                                           class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="anrede_es"
                                       class="col-sm-2 control-label"> <?php echo(getUebersetzung("Anrede", $sprache, $link)); ?></label>
                                <div class="col-sm-10">
                                    <input name="anrede_es" type="text" id="anrede_es"
                                           value="<?php echo($anrede_es); ?>"
                                           class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="anrede_es" class="col-sm-2 control-label"> </label>
                                <div class="col-sm-10">
                                    (<?php echo(getUebersetzung("Nach ihrer Anrede wird der Name des Gastes automatisch eingesetzt", $sprache, $link)); ?>
                                    )
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="text_es"
                                       class="col-sm-2 control-label"><?php echo(getUebersetzung("Text", $sprache, $link)); ?></label>
                                <div class="col-sm-10">
                                    <textarea name="text_es" type="text" id="text_es" "
                                    class="form-control"><?php echo($text_es); ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="unterschrift_es"
                                       class="col-sm-2 control-label"> <?php echo(getUebersetzung("Unterschrift", $sprache, $link)); ?></label>
                                <div class="col-sm-10">
                                    <textarea name="unterschrift_es" type="text" id="unterschrift_es" "
                                    class="form-control"><?php echo($unterschrift_es); ?></textarea>

                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                }
                ?>
            </div>

            <?php
            if ($art == "emails") {

            //gästeliste anzeigen zur auswahl:
            ?>
            <div class="well">
                <div class="lead" style="margin-bottom: 0px;">
                    <?php echo(getUebersetzung("Bitte wählen Sie die Gäste aus, an denen das E-Mail gesendet werden soll.", $sprache, $link)); ?>
                    <br/>
                    <?php echo(getUebersetzung("Wenn Sie mehrere auswählen wollen müssen Sie die [Strg] Taste gedrückt halten.", $sprache, $link)); ?>
                </div>
                <div class="form-group">
                    <hr style="border-top: 1px solid #777;">
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <select class=" form-control" name="gaeste[]" size="10" multiple>
                            <?php
                            //alle gäste der unterkunft auslesen:
                            $res = getGuestList($unterkunft_id, $link);
                            while ($d = mysqli_fetch_array($res)) {
                                $gast_id = $d["PK_ID"];
                                $vorname = $d["Vorname"];
                                $nachname = $d["Nachname"];
                                $ort = $d["Ort"];
                                $land = $d["Land"];
                                $email = $d["EMail"];
                                $gast = $nachname . " " . $vorname . ", " . $ort . ", " . $land . " , " . $email;
                                ?>
                                <option value="<?php echo($gast_id); ?>"><?php echo($gast); ?></option>
                                <?php
                            } //ende schleife.
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12" >
                    <button name="email" type="submit" class="btn btn-success" id="email">
                        <span class="glyphicon glyphicon-send"></span>
                        <?php echo(getUebersetzung("E-Mails senden", $sprache, $link)); ?>
                    </button>
                    <a class="btn btn-primary" href="./index.php">
                        <!--                        <span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>-->
                        <?php echo(getUebersetzung("Zurück", $sprache, $link)); ?>
                    </a>
                </div>
            </div>
            <?php
        }
        ?>
        <?php

        } //ende if passwortprüfung
        else {
            echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!", $sprache, $link));
        }
        ?>
        </form>
    </div>
</div>
<?php include_once("../templates/end.php"); ?>
