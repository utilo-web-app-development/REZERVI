<?php session_start();
$root = "../../..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once($root . "/include/sessionFunctions.inc.php");

/*   
	date: 5.11.05
	author: christian osterrieder utilo.eu						
*/

//datenbank öffnen:
include_once($root . "/conf/rdbmsConfig.php");

//andere funktionen importieren:
include_once($root . "/include/benutzerFunctions.php");
include_once($root . "/include/unterkunftFunctions.php");
include_once($root . "/include/propertiesFunctions.php");
include_once($root . "/include/uebersetzer.php");
include_once($root . "/webinterface/templates/components.php");

//variablen:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
$sprache = getSessionWert(SPRACHE);

?>
<?php include_once($root . "/webinterface/templates/headerA.php"); ?>
    <style type="text/css">
        <?php include_once($root."/templates/stylesheetsIE9.php"); ?>
    </style>
    <script language="JavaScript" type="text/javascript" src="../buchungseinschraenkungen/updateDate.js">
    </script>
<?php include_once($root . "/webinterface/templates/headerB.php"); ?>
<?php include_once($root . "/webinterface/templates/bodyA.php"); ?>
<?php
//passwortprüfung:	
if (checkPass($benutzername, $passwort, $unterkunft_id, $link)){
    ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2><?php echo(getUebersetzung("Einstellungen für das Buchungsformular", $sprache, $link)); ?>.</h2>
        </div>
        <div class="panel-body">

            <?php
            if (isset($nachricht) && $nachricht != "") {
                ?>
                <div class="row">
                    <div class="col-sm-12">
                        <label <?php if (isset($fehler) && $fehler == false) {
                            echo("class=\"frei\"");
                        } else {
                            echo("class=\"belegt\"");
                        } ?>><?php echo($nachricht) ?></label>
                    </div>
                </div>

                <?php
            }
            ?>


            <form action="./aendern.php" method="post" target="_self" name="reservierung">

                <div class="row">
                    <div class="col-sm-12">
                        <label class="label-control">
                            <?php echo(getUebersetzung("Zusätzliche Attribute anzeigen:", $sprache, $link)); ?>
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <label class="label-control">
                            <?php
                            echo(getUebersetzung("Übernachtung", $sprache, $link));
                            ?>
                        </label>
                    </div>
                    <div class="col-sm-10">
                        <input name="uebernachtung" type="checkbox" value="true"
                            <?php
                            if (getPropertyValue(PENSION_UEBERNACHTUNG, $unterkunft_id, $link) == "true") {
                                ?>
                                checked="checked"
                                <?php
                            }
                            ?>
                        />

                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <label class="label-control">
                            <?php
                            echo(getUebersetzung("Frühstück", $sprache, $link));
                            ?>
                        </label>
                    </div>
                    <div class="col-sm-10">
                        <input name="fruehstueck" type="checkbox" value="true"
                            <?php
                            if (getPropertyValue(PENSION_FRUEHSTUECK, $unterkunft_id, $link) == "true") {
                                ?>
                                checked="checked"
                                <?php
                            }
                            ?>
                        />

                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-2">
                        <label class="label-control">
                            <?php
                            echo(getUebersetzung("Halbpension", $sprache, $link));
                            ?>
                        </label>
                    </div>
                    <div class="col-sm-10">
                        <input name="halbpension" type="checkbox" value="true"
                            <?php
                            if (getPropertyValue(PENSION_HALB, $unterkunft_id, $link) == "true") {
                                ?>
                                checked="checked"
                                <?php
                            }
                            ?>
                        />

                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <label>
                            <?php
                            echo(getUebersetzung("Vollpension", $sprache, $link));
                            ?>
                        </label>
                    </div>
                    <div class="col-sm-10">
                        <input name="vollpension" type="checkbox" value="true"
                            <?php
                            if (getPropertyValue(PENSION_VOLL, $unterkunft_id, $link) == "true") {
                                ?>
                                checked="checked"
                                <?php
                            }
                            ?>
                        />

                    </div>
                </div>
                <!--                 buttons um zurück zum menue zu gelangen:-->
                <?php showSubmitButton(getUebersetzung("ändern", $sprache, $link)); ?>


            </form>
            <?php
            } //ende if passwortprüfung
            else {
                echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!", $sprache, $link));
            }
            ?>
        </div>
    </div>
<?php include_once("../../templates/end.php"); ?>