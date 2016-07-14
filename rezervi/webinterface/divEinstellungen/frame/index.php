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
include_once($root . "/include/propertiesFunctions.php");

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
    <!--<div class="panel panel-default">
        <div class="panel-body">
            <a class="btn btn-primary" href="./index.php">
                <span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>&nbsp;
                <?php /*echo(getUebersetzung("zurück", $sprache, $link)); */?>
            </a>
        </div>
    </div>-->
    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading"> <!--<p class=" standardSchriftBold lead">-->
            <?php //echo(getUebersetzung("Ändern der Framegrößen",$sprache,$link));
            ?><!--.</p>-->
             <h2><?php echo(getUebersetzung("Ändern der Framegrößen", $sprache, $link)); ?>.</h2>
        </div>
        <div class="panel-body">
            <?php
            //passwortprüfung:
            if (checkPass($benutzername, $passwort, $unterkunft_id, $link)) {
                ?>

                <?php
                if (isset($nachricht) && $nachricht != "") {
                    ?>
                    <p class="lead"> <?php if (isset($fehler) && $fehler == false) {
                            echo("class=\"frei\"");
                        } else {
                            echo("class=\"belegt\"");
                        } ?>><?php echo($nachricht) ?> </p>
                    <?php
                }
                ?>

                <form role="form" action="./frameAendern.php" method="post" target="_self" class="form-horizontal">
                    <?php

                    $framesizeLeftWI = getFramesizeLeftWI($unterkunft_id, $link);
                    $framesizeRightWI = getFramesizeRightWI($unterkunft_id, $link);
                    $framesizeLeftBP = getFramesizeLeftBP($unterkunft_id, $link);
                    $framesizeRightBP = getFramesizeRightBP($unterkunft_id, $link);
                    $framesizeLeftWIUnit = getFramesizeLeftWIUnit($unterkunft_id, $link);
                    $framesizeRightWIUnit = getFramesizeRightWIUnit($unterkunft_id, $link);
                    $framesizeLeftBPUnit = getFramesizeLeftBPUnit($unterkunft_id, $link);
                    $framesizeRightBPUnit = getFramesizeRightBPUnit($unterkunft_id, $link);

                    ?>
                    <div class="form-group">
                        <label
                            class="label-control col-sm-4"><?php echo(getUebersetzung("Belegungsplan links oder oben", $sprache, $link)); ?></label>
                        <div class="col-sm-3">
                            <input class="form-control" type="text" name="wertLeftBP"
                                   value="<?php echo($framesizeLeftBP); ?>" size="4"
                                   maxlength="3"/>&nbsp;
                        </div>
                        <div class="col-sm-1">
                            <select class="form-control" name="artLeftBP">
                                <option value="%" <?php if ($framesizeLeftBPUnit == "%") echo("selected"); ?>>%</option>
                                <option value="px" <?php if ($framesizeLeftBPUnit == "px") echo("selected"); ?>>px
                                </option>
                                <option
                                    value="*" <?php if ($framesizeLeftBPUnit == "*") echo("selected"); ?>><?php echo(getUebersetzung("relativ", $sprache, $link)); ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label
                            class="label-control col-sm-4"><?php echo(getUebersetzung("Belegungsplan rechts oder unten", $sprache, $link)); ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="wertRightBP" value="<?php echo($framesizeRightBP); ?>" size="4"
                                   maxlength="3"/>&nbsp;
                        </div>
                        <div class="col-sm-1">
                            <select name="artRightBP" class="form-control" >
                                <option value="%" <?php if ($framesizeRightBPUnit == "%") echo("selected"); ?>>%</option>
                                <option value="px" <?php if ($framesizeRightBPUnit == "px") echo("selected"); ?>>px</option>
                                <option
                                    value="*" <?php if ($framesizeRightBPUnit == "*") echo("selected"); ?>><?php echo(getUebersetzung("relativ", $sprache, $link)); ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label
                            class="label-control col-sm-4"><?php echo(getUebersetzung("Webinterface links", $sprache, $link)); ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="wertLeftWI" value="<?php echo($framesizeLeftWI); ?>" size="4"
                                   maxlength="3"/>&nbsp;
                        </div>
                        <div class="col-sm-1">
                            <select class="form-control" name="artLeftWI">
                                <option value="%" <?php if ($framesizeLeftWIUnit == "%") echo("selected"); ?>>%</option>
                                <option value="px" <?php if ($framesizeLeftWIUnit == "px") echo("selected"); ?>>px</option>
                                <option
                                    value="*" <?php if ($framesizeLeftWIUnit == "*") echo("selected"); ?>><?php echo(getUebersetzung("relativ", $sprache, $link)); ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label
                            class="label-control col-sm-4"><?php echo(getUebersetzung("Webinterface rechts", $sprache, $link)); ?></label>
                        <div class="col-sm-3">
                            <input class="form-control" type="text" name="wertRightWI" value="<?php echo($framesizeRightWI); ?>" size="4"
                                   maxlength="3"/>&nbsp;
                        </div>
                        <div class="col-sm-1">
                            <select class="form-control"  name="artRightWI">
                                <option value="%" <?php if ($framesizeRightWIUnit == "%") echo("selected"); ?>>%</option>
                                <option value="px" <?php if ($framesizeRightWIUnit == "px") echo("selected"); ?>>px</option>
                                <option
                                    value="*" <?php if ($framesizeRightWIUnit == "*") echo("selected"); ?>><?php echo(getUebersetzung("relativ", $sprache, $link)); ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label
                            class="label-control col-sm-4"> <?php echo(getUebersetzung("Frame horizontal teilen", $sprache, $link)); ?></label>
                        <div class="col-sm-3">
                            <input  type="checkbox" name="splitHorizontal" value="true"
                                <?php
                                if (getPropertyValue(HORIZONTAL_FRAME, $unterkunft_id, $link) == "true") {
                                    ?> checked="checked"<?php
                                }
                                ?>
                            />
                        </div>
                    </div>
                    <?php showSubmitButton(getUebersetzung("Ändern", $sprache, $link)); ?>
                </form>
            <?php } //ende if passwortprüfung
            else {
            echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!", $sprache, $link));
            } ?>
        </div>
    </div>

<?php
/*//passwortprüfung:
if (checkPass($benutzername, $passwort, $unterkunft_id, $link)) {
    */?><!--


    <?php
/*//-----buttons um zurück zum menue zu gelangen:
    showSubmitButtonWithForm("../index.php", getUebersetzung("zurück", $sprache, $link));
    */?>
    <br/>
    <?php
/*//-----buttons um zurück zum menue zu gelangen:
    showSubmitButtonWithForm("../../inhalt.php", getUebersetzung("Hauptmenü", $sprache, $link));
    */?>
    --><?php
/*} //ende if passwortprüfung
else {
    echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!", $sprache, $link));
}*/
?>
<?php include_once("../../templates/end.php"); ?>