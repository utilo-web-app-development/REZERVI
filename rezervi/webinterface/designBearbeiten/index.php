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

$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
$sprache = getSessionWert(SPRACHE);

//datenbank öffnen:
include_once("../../conf/rdbmsConfig.php");

//andere funktionen importieren:
include_once("../../include/benutzerFunctions.php");
include_once("../../include/unterkunftFunctions.php");
include_once($root . "/include/propertiesFunctions.php");
include_once("../../include/zimmerFunctions.php");
//uebersetzer einfuegen:
include_once("../../include/uebersetzer.php");

include_once("../templates/auth.php");

//should the reservation state be shown?
$showReservation = getPropertyValue(SHOW_RESERVATION_STATE, $unterkunft_id, $link);
if ($showReservation != "true") {
    $showReservation = false;
}

?>
<?php include_once("../templates/headerA.php"); ?>
<style type="text/css">
    <?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>

<?php include_once("../templates/headerB.php"); ?>

<?php include_once("../templates/bodyA.php"); ?>

<div class="panel panel-default">
    <div class="panel-body">

        <?php
        //passwortprüfung:
        if (checkPass($benutzername, $passwort, $unterkunft_id, $link)) {
            ?>

            <form action="./styles.php" method="post" name="resEingebenAendernForm" id="resEingebenAendernForm" target="_self" class="form-horizontal">
                <div class="row">
                    <div class="col-sm-4">
                        <label class="control-label">
                            <?php echo(getUebersetzung("Ändern der Hintergrundfarbe", $sprache, $link)); ?>
                        </label>
                    </div>
                    <div class="col-sm-offset-6 col-sm-2">
                        <input name="hintergrund" type="submit" class="btn btn-primary" id="resEingebenAendern"
                               style="width: 100%"
                               value="<?php echo(getUebersetzung("Hintergrund", $sprache, $link)); ?>">

                        <input name="font_family" type="hidden" value="0">
                        <input name="font_size" type="hidden" value="0">
                        <input name="font_style" type="hidden" value="0">
                        <input name="font_weight" type="hidden" value="0">
                        <input name="text_align" type="hidden" value="0">
                        <input name="color" type="hidden" value="0">
                        <input name="border" type="hidden" value="0">
                        <input name="border_color" type="hidden" value="0">
                        <input name="background_color" type="hidden" value="1">
                        <input name="height" type="hidden" value="0">
                        <input name="width" type="hidden" value="0">
                        <input name="stylesheet" type="hidden" value="hintergrund">
                    </div>
                </div>
            </form>

            <div class="row">
                <hr>
            </div>

            <form action="./styles.php" method="post" name="resEingebenAendern" id="resEingebenAendern" target="_self" class="form-horizontal">
                <div class="row">
                    <div class="col-sm-4">
                        <label class="control-label">
                            <?php echo(getUebersetzung("Ändern der Standard-Schrift (Farbe, Art, Größe, ...)", $sprache, $link)); ?>
                        </label>
                    </div>
                    <div class="col-sm-offset-6 col-sm-2">
                        <input type="submit" name="resEingebenAendern" class="btn btn-primary" id="resEingebenAendern"
                               style="width: 100%"
                               value="<?php echo(getUebersetzung("Schrift", $sprache, $link)); ?>">
                        <input name="font_family" type="hidden" value="1">
                        <input name="font_size" type="hidden" value="1">
                        <input name="font_style" type="hidden" value="1">
                        <input name="font_weight" type="hidden" value="1">
                        <input name="text_align" type="hidden" value="1">
                        <input name="color" type="hidden" value="1">
                        <input name="border" type="hidden" value="0">
                        <input name="border_color" type="hidden" value="0">
                        <input name="background_color" type="hidden" value="0">
                        <input name="height" type="hidden" value="0">
                        <input name="width" type="hidden" value="0">
                        <input name="stylesheet" type="hidden" value="standardSchrift">
                    </div>
                </div>
            </form>

            <div class="row">
                <hr>
            </div>

            <form action="./styles.php" method="post" name="ueberschriftForm" id="ueberschriftForm" target="_self" class="form-horizontal">
                <div class="row">
                    <div class="col-sm-4">
                        <label class="control-label">
                            <?php echo(getUebersetzung("Ändern der Überschrift (Farbe, Art, Größe, ...)", $sprache, $link)); ?>
                        </label>
                    </div>
                    <div class="col-sm-offset-6 col-sm-2">
                        <input name="ueberschrift" type="submit" class="btn btn-primary" id="resEingebenAendern"
                               style="width: 100%"
                               value="<?php echo(getUebersetzung("Überschrift", $sprache, $link)); ?>">

                        <input name="font_family" type="hidden" value="1">
                        <input name="font_size" type="hidden" value="1">
                        <input name="font_style" type="hidden" value="1">
                        <input name="font_weight" type="hidden" value="1">
                        <input name="text_align" type="hidden" value="1">
                        <input name="color" type="hidden" value="1">
                        <input name="border" type="hidden" value="0">
                        <input name="border_color" type="hidden" value="0">
                        <input name="background_color" type="hidden" value="0">
                        <input name="height" type="hidden" value="0">
                        <input name="width" type="hidden" value="0">
                        <input name="stylesheet" type="hidden" value="ueberschrift">
                    </div>
                    </br>
                </div>
            </form>

            <div class="row">
                <hr>
            </div>

            <form action="./styles.php" method="post" name="markierteSchrift" id="markierteSchrift" target="_self" class="form-horizontal">
                <div class="row">
                    <div class="col-sm-4">

                        <label class="control-label">
                            <?php echo(getUebersetzung("Ändern der markierten Schrift", $sprache, $link)); ?>
                        </label>
                    </div>
                    <div class="col-sm-offset-6 col-sm-2">
                        <input name="markierteSchrift" type="submit" class="btn btn-primary" id="resEingebenAendern"
                               style="width: 100%"
                               value="<?php echo(getUebersetzung("markierte Schrift", $sprache, $link)); ?>">
                        <input name="font_family" type="hidden" value="1">
                        <input name="font_size" type="hidden" value="1">
                        <input name="font_style" type="hidden" value="1">
                        <input name="font_weight" type="hidden" value="1">
                        <input name="text_align" type="hidden" value="1">
                        <input name="color" type="hidden" value="1">
                        <input name="border" type="hidden" value="0">
                        <input name="border_color" type="hidden" value="0">
                        <input name="background_color" type="hidden" value="0">
                        <input name="height" type="hidden" value="0">
                        <input name="width" type="hidden" value="0">
                        <input name="stylesheet" type="hidden" value="markierteSchrift">
                    </div>
                </div>
            </form>
            <div class="row">
                <hr>
            </div>

            <form action="./styles.php" method="post" name="buttonAForm" id="buttonAForm" target="_self" class="form-horizontal">
                <div class="row">
                    <div class="col-sm-4">

                        <label class="control-label">
                            <?php echo(getUebersetzung("Ändern des Buttons", $sprache, $link)); ?>
                        </label>
                    </div>
                    <div class="col-sm-offset-6 col-sm-2">
                        <input name="buttonA" type="submit" class="btn btn-primary" id="resEingebenAendern"
                               style="width: 100%"
                               value="<?php echo(getUebersetzung("Button", $sprache, $link)); ?>">
                        <input name="font_size" type="hidden" value="1">
                        <input name="font_style" type="hidden" value="1">
                        <input name="font_weight" type="hidden" value="1">
                        <input name="text_align" type="hidden" value="1">
                        <input name="color" type="hidden" value="1">
                        <input name="border" type="hidden" value="1">
                        <input name="border_color" type="hidden" value="1">
                        <input name="background_color" type="hidden" value="1">
                        <input name="height" type="hidden" value="1">
                        <input name="width" type="hidden" value="1">
                        <input name="stylesheet" type="hidden" value="buttonA">
                    </div>
                </div>
            </form>
            <div class="row">
                <hr>
            </div>
            <form action="./styles.php" method="post" name="buttonBForm"  id="buttonBForm" target="_self" class="form-horizontal">
                <div class="row
">
                    <div class="col-sm-7">
                        <label class="control-label">
                            <?php echo(getUebersetzung("Ändern des Buttons der angezeigt wird, wenn die Maus darüber bewegt wird", $sprache, $link)); ?>
                        </label>
                    </div>
                    <div class="col-sm-offset-3 col-sm-2">
                        <input name="buttonB" type="submit" class="btn btn-primary" id="resEingebenAendern"
                               style="width: 100%"
                               value="<?php echo(getUebersetzung("Button rollover", $sprache, $link)); ?>">
                        <input name="font_size" type="hidden" value="1">
                        <input name="font_style" type="hidden" value="1">
                        <input name="font_weight" type="hidden" value="1">
                        <input name="text_align" type="hidden" value="1">
                        <input name="color" type="hidden" value="1">
                        <input name="border" type="hidden" value="1">
                        <input name="border_color" type="hidden" value="1">
                        <input name="background_color" type="hidden" value="1">
                        <input name="height" type="hidden" value="1">
                        <input name="width" type="hidden" value="1">
                        <input name="stylesheet" type="hidden" value="buttonB">
                    </div>
                </div>
            </form>
            <div class="row">
                <hr>
            </div>
            <form action="./styles.php" method="post" name="tabelleForm" id="tabelleForm" target="_self" class="form-horizontal">
                <div class="row">
                    <div class="col-sm-7">
                        <label class="control-label">
                            <?php echo(getUebersetzung("Ändern der Tabelle (Hintergrundfarbe, Schriftfarbe, Rahmen, etc.)", $sprache, $link)); ?>
                        </label>
                    </div>
                    <div class="col-sm-offset-3 col-sm-2">
                        <input name="tabelle" type="submit" class="btn btn-primary" id="resEingebenAendern"
                               style="width: 100%"
                               value="<?php echo(getUebersetzung("Tabelle", $sprache, $link)); ?>">
                        <input name="font_size" type="hidden" value="1">
                        <input name="font_style" type="hidden" value="1">
                        <input name="font_weight" type="hidden" value="1">
                        <input name="text_align" type="hidden" value="1">
                        <input name="color" type="hidden" value="1">
                        <input name="border" type="hidden" value="1">
                        <input name="border_color" type="hidden" value="1">
                        <input name="background_color" type="hidden" value="1">
                        <input name="height" type="hidden" value="0">
                        <input name="width" type="hidden" value="0">
                        <input name="stylesheet" type="hidden" value="tabelle">
                    </div>
                </div>
            </form>
            <div class="row">
                <hr>
            </div>

            <form action="./styles.php" method="post" name="tabelleColorForm" id="tabelleColorForm" target="_self" class="form-horizontal">
                <div class="row">
                    <div class="col-sm-7">
                        <label class="control-label">
                            <?php echo(getUebersetzung("Ändern der färbigen Tabellen", $sprache, $link)); ?>
                        </label>
                    </div>
                    <div class="col-sm-offset-3 col-sm-2">
                        <input name="tabelleColor" type="submit" class="btn btn-primary" id="resEingebenAendern"
                               style="width: 100%"
                               value="<?php echo(getUebersetzung("färbige Tabelle", $sprache, $link)); ?>">
                        <input name="font_size" type="hidden" value="1">
                        <input name="font_style" type="hidden" value="1">
                        <input name="font_weight" type="hidden" value="1">
                        <input name="text_align" type="hidden" value="1">
                        <input name="color" type="hidden" value="1">
                        <input name="border" type="hidden" value="1">
                        <input name="border_color" type="hidden" value="1">
                        <input name="background_color" type="hidden" value="1">
                        <input name="height" type="hidden" value="0">
                        <input name="width" type="hidden" value="0">
                        <input name="stylesheet" type="hidden" value="tabelleColor">
                    </div>
                </div>
            </form>
            <div class="row">
                <hr>
            </div>

            <form action="./styles.php" method="post" name="belegtForm" id="belegtForm" target="_self" class="form-horizontal">
                <div class="row">
                    <div class="col-sm-7">
                        <label class="control-label">
                            <?php echo(getUebersetzung("Ändern der Farbe der belegt-Anzeige", $sprache, $link)); ?>
                        </label>
                    </div>
                    <div class="col-sm-offset-3 col-sm-2">
                        <input name="belegt" type="submit" class="btn btn-primary" id="resEingebenAendern"
                               style="width: 100%"
                               value="<?php echo(getUebersetzung("belegt", $sprache, $link)); ?>">
                        <input name="font_size" type="hidden" value="1">
                        <input name="font_style" type="hidden" value="1">
                        <input name="font_weight" type="hidden" value="1">
                        <input name="text_align" type="hidden" value="1">
                        <input name="color" type="hidden" value="1">
                        <input name="border" type="hidden" value="1">
                        <input name="border_color" type="hidden" value="1">
                        <input name="background_color" type="hidden" value="1">
                        <input name="height" type="hidden" value="0">
                        <input name="width" type="hidden" value="0">
                        <input name="stylesheet" type="hidden" value="belegt">
                    </div>
                </div>
            </form>
            <div class="row">
                <hr>
            </div>

            <form action="./styles.php" method="post" name="samstagBelegtForm" id="samstagBelegtForm" target="_self" class="form-horizontal">
                <div class="row">
                    <div class="col-sm-7">
                        <label class="control-label">
                            <?php echo(getUebersetzung("Ändern der Farbe der Samstag belegt-Anzeige", $sprache, $link)); ?>
                        </label>
                    </div>
                    <div class="col-sm-offset-3 col-sm-2">
                        <input name="samstagBelegt" type="submit" class="btn btn-primary" id="resEingebenAendern"
                               style="width: 100%"
                               value="<?php echo(getUebersetzung("Samstag belegt", $sprache, $link)); ?>">
                        <input name="font_size" type="hidden" value="1">
                        <input name="font_style" type="hidden" value="1">
                        <input name="font_weight" type="hidden" value="1">
                        <input name="text_align" type="hidden" value="1">
                        <input name="color" type="hidden" value="1">
                        <input name="border" type="hidden" value="1">
                        <input name="border_color" type="hidden" value="1">
                        <input name="background_color" type="hidden" value="1">
                        <input name="height" type="hidden" value="0">
                        <input name="width" type="hidden" value="0">
                        <input name="stylesheet" type="hidden" value="samstagBelegt">
                    </div>
                </div>
            </form>
            <div class="row">
                <hr>
            </div>

            <form action="./styles.php" method="post" name="freiForm" id="freiForm" target="_self" class="form-horizontal">
                <div class="row">
                    <div class="col-sm-7">
                        <label class="control-label">
                            <?php echo(getUebersetzung("Ändern der Farbe der frei-Anzeige", $sprache, $link)); ?>
                        </label>
                    </div>
                    <div class="col-sm-offset-3 col-sm-2">
                        <input name="frei" type="submit" class="btn btn-primary" id="resEingebenAendern"
                               style="width: 100%"
                               value="<?php echo(getUebersetzung("frei", $sprache, $link)); ?>">
                        <input name="font_size" type="hidden" value="1">
                        <input name="font_style" type="hidden" value="1">
                        <input name="font_weight" type="hidden" value="1">
                        <input name="text_align" type="hidden" value="1">
                        <input name="color" type="hidden" value="1">
                        <input name="border" type="hidden" value="1">
                        <input name="border_color" type="hidden" value="1">
                        <input name="background_color" type="hidden" value="1">
                        <input name="height" type="hidden" value="0">
                        <input name="width" type="hidden" value="0">
                        <input name="stylesheet" type="hidden" value="frei">
                    </div>
                </div>
            </form>
            <div class="row">
                <hr>
            </div>

            <form action="./styles.php" method="post" name="samstagFreiForm" id="samstagFreiForm" target="_self" class="form-horizontal">
                <div class="row">
                    <div class="col-sm-7">
                        <label class="control-label">
                            <?php echo(getUebersetzung("Ändern der Farbe der Samstag frei-Anzeige", $sprache, $link)); ?>
                        </label>
                    </div>
                    <div class="col-sm-offset-3 col-sm-2">
                        <input name="samstagFrei" type="submit" class="btn btn-primary" id="resEingebenAendern"
                               style="width: 100%"
                               value="<?php echo(getUebersetzung("Samstag frei", $sprache, $link)); ?>">
                        <input name="font_size" type="hidden" value="1">
                        <input name="font_style" type="hidden" value="1">
                        <input name="font_weight" type="hidden" value="1">
                        <input name="text_align" type="hidden" value="1">
                        <input name="color" type="hidden" value="1">
                        <input name="border" type="hidden" value="1">
                        <input name="border_color" type="hidden" value="1">
                        <input name="background_color" type="hidden" value="1">
                        <input name="height" type="hidden" value="0">
                        <input name="width" type="hidden" value="0">
                        <input name="stylesheet" type="hidden" value="samstagFrei">
                    </div>
                </div>
            </form>
            <div class="row">
                <hr>
            </div>

            <?php
            if ($showReservation) {
                ?>

                <form action="./styles.php" method="post" name="reserviertForm" id="reserviertForm"  target="_self" class="form-horizontal">
                    <div class="row">
                        <div class="col-sm-7">
                            <label class="control-label">
                                <?php echo(getUebersetzung("Ändern der Farbe der reserviert-Anzeige", $sprache, $link)); ?>
                            </label>
                        </div>
                        <div class="col-sm-offset-3 col-sm-2">
                            <input name="reserviert" type="submit" class="btn btn-primary" id="resEingebenAendern"
                                   style="width: 100%"
                                   value="<?php echo(getUebersetzung("reserviert", $sprache, $link)); ?>">
                            <input name="font_size" type="hidden" value="1">
                            <input name="font_style" type="hidden" value="1">
                            <input name="font_weight" type="hidden" value="1">
                            <input name="text_align" type="hidden" value="1">
                            <input name="color" type="hidden" value="1">
                            <input name="border" type="hidden" value="1">
                            <input name="border_color" type="hidden" value="1">
                            <input name="background_color" type="hidden" value="1">
                            <input name="height" type="hidden" value="0">
                            <input name="width" type="hidden" value="0">
                            <input name="stylesheet" type="hidden" value="reserviert">
                        </div>
                    </div>
                </form>
                <div class="row">
                    <hr>
                </div>

                <form action="./styles.php" method="post" name="samstagReserviertForm" id="samstagReserviertForm" target="_self" class="form-horizontal">
                    <div class="row">
                        <div class="col-sm-7">
                            <label class="control-label">
                                <?php echo(getUebersetzung("Ändern der Farbe der Samstag reserviert-Anzeige", $sprache, $link)); ?>
                            </label>
                        </div>
                        <div class="col-sm-offset-3 col-sm-2">
                            <input name="samstagReserviert" type="submit" class="btn btn-primary"
                                   id="resEingebenAendern"
                                   style="width: 100%"
                                   value="<?php echo(getUebersetzung("Samstag reserviert", $sprache, $link)); ?>">
                            <input name="font_size" type="hidden" value="1">
                            <input name="font_style" type="hidden" value="1">
                            <input name="font_weight" type="hidden" value="1">
                            <input name="text_align" type="hidden" value="1">
                            <input name="color" type="hidden" value="1">
                            <input name="border" type="hidden" value="1">
                            <input name="border_color" type="hidden" value="1">
                            <input name="background_color" type="hidden" value="1">
                            <input name="height" type="hidden" value="0">
                            <input name="width" type="hidden" value="0">
                            <input name="stylesheet" type="hidden" value="samstagReserviert">
                        </div>
                    </div>
                </form>
                <div class="row">
                    <hr>
                </div>

                <?php
            } //end reservation state
            ?>

            <form action="./standardWerte.php" method="post" name="standardWerte" id="standardWerte" target="_self"
                   class="form-horizontal">
                <div class="row">
                    <div class="col-sm-7">
                        <label class="control-label">
                            <?php echo(getUebersetzung("Alle Änderungen werden auf die Rezervi-Standard-Werte zurückgesetzt.", $sprache, $link)); ?>
                        </label>
                    </div>
                    <div class="col-sm-offset-3 col-sm-2">
                        <input name="samstagReserviert" type="button" class="btn btn-primary" id="resEingebenAendern"
                               ng-confirm-click="Sind Sie Sicher?" confirmed-click="sicher('standardWerte');"
                               style="width: 100%"
                               value="<?php echo(getUebersetzung("Zurücksetzen", $sprache, $link)); ?>">
                    </div>
                </div>
            </form>
            <div class="row">
                <hr>
            </div>

<!--            <form action="./standardWerte.php" method="post" name="farbtabelle" target="_self"-->
<!--                  onSubmit="return sicher()" class="form-horizontal">-->
                <div class="row">
                    <div class="col-sm-7">
                        <label class="control-label">
                            <?php echo(getUebersetzung("Farbtabelle anzeigen.", $sprache, $link)); ?>
                        </label>
                    </div>
                    <div class="col-sm-offset-3 col-sm-2">
                        <input name="farbtabelle" type="button" class="btn btn-primary"
                               style="width: 100%"
                               onClick="window.open('./farbtabelle.php','Farbtabelle','toolbar=no,menubar=no,scrollbars=yes,width=650,height=800')"
                               id="farbtabelle"
                               value="<?php echo(getUebersetzung("Farbtabelle anzeigen", $sprache, $link)); ?>">
                    </div>
                </div>
<!--            </form>-->
            <?php
        } //ende if passwortprüfung
        else {
            echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!", $sprache, $link));
        }
        ?>
    </div>
</div>
</body>
</html>
