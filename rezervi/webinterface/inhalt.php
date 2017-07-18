<?php
session_start();
$root = "..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once($root . "/include/sessionFunctions.inc.php");
//alle alten session_daten löschen:
destroyInactiveSessions();

/*
    reservierungsplan - utilo.eu
    author: christian osterrieder

    inhaltsverzeinis für die wartung des benutzers
    über diese seite wird das passwort und der benutzername geprüft,
    zur prüfung übergeben werden die variablen
    benutzername
    passwort

    für die jeweiligen Rechten angepasstes Wartungsmenue

    Rechte:
    1 - Testversion
    2 - Zimmer bearbeiten, Unterkunftsdaten ändern
    3 - Design bearbeiten
      - Benutzerdaten bearbeiten

*/



//passwortprüfung vornehmen:
//datenbank öffnen:
include_once("../conf/rdbmsConfig.php");
//andere funktionen einbeziehen:
include_once("../include/benutzerFunctions.php");
include_once("../include/unterkunftFunctions.php");
include_once("../include/zimmerFunctions.php");
include_once("../include/zimmerFunctions.php");
include_once("../include/uebersetzer.php");

include_once("./templates/auth.php");

//sprache auslesen:
//entweder aus übergebener url oder aus session
if (isset($_POST["sprache"]) && $_POST["sprache"] != "") {
    $sprache = $_POST["sprache"];
    setSessionWert(SPRACHE, $sprache);
} else {
    $sprache = getSessionWert(SPRACHE);

}
setSessionWert(SPRACHE, $sprache);
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//unterkünfte sperren:
// 4 = la vielle maison
if ($unterkunft_id == -1) {
    echo("Zugang gesperrt!");
    $fehlgeschlagen = true;
    //include_once("./index.php");
    header("Location: ".$URL."webinterface/index.php"); /* Redirect browser */
    exit();
}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
else {

    //benutzerrechte auslesen:
    $benutzerrechte = getUserRights($benutzer_id, $link);
    $anzahlVorhandenerZimmer = getAnzahlVorhandeneZimmer($unterkunft_id, $link);

    ?>
    <?php include_once("./templates/headerA.php"); ?>
    <style type="text/css">
        <?php include_once($root."/templates/stylesheetsIE9.php"); ?>
    </style>
    <?php include_once("./templates/headerB.php"); ?>
    <?php include_once("./templates/bodyA.php"); ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>
                <?php echo(getUebersetzung("Benutzer", $sprache, $link)); ?>:
                <label class="label label-primary"><?php echo(getUserName($benutzer_id, $link)); ?></label>
            </h2>
        </div>
        <div class="panel-body">
            <?php if ($anzahlVorhandenerZimmer < 1) { ?>
            <?php } ?>


            <?php
            if ($benutzerrechte >= 1 && $anzahlVorhandenerZimmer > 0) {
                ?>
                <div class="row" <?php if ($benutzerrechte >= 1){ echo('style="margin-bottom: 10px;"'); }?>>
                    <div class="col-sm-3">
                        <a href="./reservierung/index.php" role="button" class="btn btn-default"
                           name="resEingebenAendern" style="width: 100%;"
                           target="_self">
                            <?php echo(getUebersetzung("Reservierungsplan bearbeiten", $sprache, $link)); ?>
                        </a>
                    </div>
                    <div class="col-sm-9">
                        <label class="label-control" style="margin-top:7px;">
                            <?php echo(getUebersetzung("Neue Reservierungen eingeben, Reservierungen bearbeiten oder löschen", $sprache, $link)); ?>
                            .
                        </label>
                    </div>
                </div>
                <div class="row" <?php if ($benutzerrechte >= 1){ echo('style="margin-bottom: 10px;"'); }?>>
                    <div class="col-sm-3">
                        <a href="./anfragenBearbeiten/index.php" role="button" class="btn btn-default"
                           name="anfragenBearbeiten" style="width: 100%;"
                           target="_self">
                            <?php echo(getUebersetzung("Anfragen bearbeiten", $sprache, $link)); ?>
                        </a>
                    </div>
                    <div class="col-sm-9">
                        <label class="label-control" style="margin-top:7px;">
                            <?php echo(getUebersetzung("Anfragen von Gästen als belegt bestätigen oder ablehnen", $sprache, $link)); ?>
                            .
                        </label>
                    </div>
                </div>
                <div class="row" <?php if ($benutzerrechte >= 1){ echo('style="margin-bottom: 10px;"'); }?>>
                    <div class="col-sm-3">
                        <a href="./gaesteBearbeiten/index.php" role="button" class="btn btn-default"
                           name="gaesteBearbeiten" style="width: 100%;"
                           target="_self">
                            <?php echo(getUebersetzung("Gäste bearbeiten", $sprache, $link)); ?>
                        </a>
                    </div>
                    <div class="col-sm-9">
                        <label class="label-control" style="margin-top:7px;">
                            <?php echo(getUebersetzung("Gespeicherte Daten der Gäste bearbeiten oder abfragen (z. B. E-Mail-Adressen ausgeben)", $sprache, $link)); ?>
                            .
                        </label>
                    </div>
                </div>

                <?php
            }
            if ($benutzerrechte == 1) {
                ?>
                <div class="row">
                    <div class="col-sm-3">
                        <a href="" role="button" class="btn btn-default" name="Benutzerdatenbearbeiten" target="_self"
                           style="width: 100%;">
                            <?php echo(getUebersetzung("Benutzerdaten bearbeiten", $sprache, $link)); ?>
                        </a>
                    </div>
                    <div class="col-sm-9">
                        <label class="label-control" style="margin-top:7px;">
                            <?php echo(getUebersetzung("Neue Benutzer anlegen, ändern (z. B. Passwort) oder bestehende Benutzer löschen", $sprache, $link)); ?>
                            .<strong><br/> <?php echo(getUebersetzung("Diese Funktion ist nur für Administratoren verfügbar", $sprache, $link)); ?>
                                !</strong>
                        </label>
                    </div>
                </div>
                <?php
            }
            if ($benutzerrechte >= 2) {
                ?>
                <div class="row" <?php if ($benutzerrechte >= 2)
                {
	                echo('style="margin-bottom: 10px;"');
                } ?> >
                    <div class="col-sm-3">
                        <a href="./benutzerBearbeiten/index.php" role="button" class="btn btn-default"
                           style="width: 100%;"
                           name="benutzerdatenEingebenAendern" target="_self">
                            <?php echo(getUebersetzung("Benutzerdaten bearbeiten", $sprache, $link)); ?>
                        </a>
                    </div>
                    <div class="col-sm-9">
                        <label class="label-control" style="margin-top:7px;">
                            <?php echo(getUebersetzung("Neue Benutzer anlegen, ändern (z. B. Passwort) oder bestehende Benutzer löschen", $sprache, $link)); ?>
                            .
                        </label>
                    </div>
                </div>
                <?php
            }
            if ($benutzerrechte >= 2) {
                ?>
                <div class="row" <?php if ($benutzerrechte >= 2){ echo('style="margin-bottom: 10px;"'); }?> >
                    <div class="col-sm-3">
                        <a href="./zimmerBearbeiten/index.php" role="button" class="btn btn-default"
                           name="zimmerBearbeiten" style="width: 100%;"
                           target="_self">
                            <?php echo(getUebersetzung("Zimmer bearbeiten", $sprache, $link)); ?>
                        </a>
                    </div>
                    <div class="col-sm-9">
                        <label class="label-control" style="margin-top:7px;">
                            <?php echo(getUebersetzung("Neue Zimmer/Appartements/Wohnung/etc. anlegen, löschen, oder bereits bestehende ändern", $sprache, $link)); ?>
                            .
                        </label>
                    </div>
                </div>
                <?php
            } else if ($benutzerrechte == 1) {
                ?>
                <div class="row">
                    <div class="col-sm-3">
                        <a href="#" role="button" class="btn btn-default" name="zimmerBearbeiten" target="_self"
                           style="width: 100%;">
                            <?php echo(getUebersetzung("Zimmer bearbeiten", $sprache, $link)); ?>
                        </a>
                    </div>
                    <div class="col-sm-9">
                        <label class="label-control" style="margin-top:7px;">
                            <?php echo(getUebersetzung("Neue Zimmer/Appartements/Wohnung/etc. anlegen, löschen, oder bereits bestehende ändern", $sprache, $link)); ?>
                            . <strong><br/>
                                <?php echo(getUebersetzung("Diese Funktion ist nur für Administratoren verfügbar", $sprache, $link)); ?>
                                !</strong>
                        </label>
                    </div>
                </div>
                <?php
            }
            //prüfen ob benutzer das recht hat den folgenden link auszuführen:
            if ($benutzerrechte >= 2) {
                ?>
                <div class="row" <?php if ($benutzerrechte >= 2){ echo('style="margin-bottom: 10px;"'); }?> >
                    <div class="col-sm-3">
                        <a href="./unterkunftBearbeiten/index.php" role="button" class="btn btn-default"
                           style="width: 100%;"
                           name="UnterkunftBearbeiten"
                           target="_self">
                            <?php echo(getUebersetzung("Unterkunft bearbeiten", $sprache, $link)); ?>
                        </a>
                    </div>
                    <div class="col-sm-9">
                        <label class="label-control" style="margin-top:7px;">
                            <?php echo(getUebersetzung("Daten Ihrer Unterkunft ändern (z. B. E-Mail-Adresse)", $sprache, $link)); ?>
                        </label>
                    </div>
                </div>
                <?php
            } else if ($benutzerrechte == 1) {
                ?>
                <div class="row">
                    <div class="col-sm-3">
                        <a href="#" role="button" class="btn btn-default" name="UnterkunftBearbeiten" target="_self"
                           style="width: 100%;">
                            <?php echo(getUebersetzung("Unterkunft bearbeiten", $sprache, $link)); ?>
                        </a>
                    </div>
                    <div class="col-sm-9">
                        <label class="label-control" style="margin-top:7px;">
                            <?php echo(getUebersetzung("Daten Ihrer Unterkunft ändern (z. B. E-Mail-Adresse)", $sprache, $link)); ?>
                            <strong><br/>
                                <?php echo(getUebersetzung("Diese Funktion ist nur für Administratoren verfügbar", $sprache, $link)); ?>
                                !</strong>
                        </label>
                    </div>
                </div>
                <?php
            }
            //prüfen ob benutzer das recht hat den folgenden link auszuführen:
            if ($benutzerrechte >= 2) {
                ?>
                <div class="row" <?php if ($benutzerrechte >= 2){ echo('style="margin-bottom: 10px;"'); }?> >
                    <div class="col-sm-3">
                        <a href="./divEinstellungen/index.php" role="button" class="btn btn-default"
                           name="DiverseEinstellungen" style="width: 100%;"
                           target="_self">
                            <?php echo(getUebersetzung("Diverse Einstellunge", $sprache, $link)); ?>
                        </a>
                    </div>
                    <div class="col-sm-9">
                        <label class="label-control" style="margin-top:7px;">
                            <?php echo(getUebersetzung("Diverse Einstellungen von Rezervi ändern", $sprache, $link)); ?>
                        </label>
                    </div>
                </div>
                <?php
            } else if ($benutzerrechte == 1) {
                ?>
                <div class="row">
                    <div class="col-sm-3">
                        <a href="#" role="button" class="btn btn-default" name="DiverseEinstellungen" target="_self"
                           style="width: 100%;">
                            <?php echo(getUebersetzung("Diverse Einstellunge", $sprache, $link)); ?>
                        </a>
                    </div>
                    <div class="col-sm-9">
                        <label class="label-control" style="margin-top:7px;">
                            <?php echo(getUebersetzung("Diverse Einstellungen von Rezervi ändern", $sprache, $link)); ?>
                            .<strong><br/>
                                <?php echo(getUebersetzung("Diese Funktion ist nur fär Administratoren verfägbar", $sprache, $link)); ?>
                                !</strong>
                        </label>
                    </div>
                </div>
                <?php
            }
//            if ($benutzerrechte >= 2) {
//                ?>
<!--                <div class="row" --><?php //if ($benutzerrechte >= 2){ echo('style="margin-bottom: 10px;"'); }?><!-- >-->
<!--                    <div class="col-sm-3">-->
<!--                        <a href="../webinterface/designBearbeiten/index.php" role="button" class="btn btn-default"-->
<!--                           style="width: 100%;"-->
<!--                           name="designBearbeiten" target="_self">-->
<!--                            --><?php //echo(getUebersetzung("Design bearbeiten", $sprache, $link)); ?>
<!--                        </a>-->
<!--                    </div>-->
<!--                    <div class="col-sm-9">-->
<!--                        <label class="label-control" style="margin-top:7px;">-->
<!--                            --><?php //echo(getUebersetzung("Das Design Ihres persönlichen Reservierungsplanes ändern (z. B. Hintergrundfarbe)", $sprache, $link)); ?>
<!--                        </label>-->
<!--                    </div>-->
<!--                </div>-->
<!--                --><?php
//            }
            if ($benutzerrechte == 1) {
                ?>
                <div class="row">
                    <div class="col-sm-3">
                        <a href="" role="button" class="btn btn-default" name="designBearbeiten" target="_self"
                           style="width: 100%;">
                            <?php echo(getUebersetzung("Design bearbeiten", $sprache, $link)); ?>
                        </a>
                    </div>
                    <div class="col-sm-9">
                        <label class="label-control" style="margin-top:7px;">
                            <?php echo(getUebersetzung("Das Design Ihres persönlichen Reservierungsplanes ändern (z. B. Hintergrundfarbe)", $sprache, $link)); ?>
                            .<strong><br/>
                                <?php echo(getUebersetzung("Diese Funktion ist nur für Administratoren verfügbar", $sprache, $link)); ?>
                                !</strong>
                        </label>
                    </div>
                </div>
                <?php
            }
            if ($benutzerrechte >= 2) {
                ?>
                <div class="row" <?php if ($benutzerrechte >= 2){ echo('style="margin-bottom: 10px;"'); }?> >
                    <div class="col-sm-3">
                        <a href="./autoResponse/index.php" role="button" class="btn btn-default"
                           name="antwortenBearbeiten" style="width: 100%;"
                           target="_self">
                            <?php echo(getUebersetzung("Automatische e-Mails", $sprache, $link)); ?>
                        </a>
                    </div>
                    <div class="col-sm-9">
                        <label class="label-control" style="margin-top:7px;">
                            <?php echo(getUebersetzung("Die automatischen E-Mail-Antworten an ihre Gäste ändern (z. B. Buchungsbestätigung) oder E-Mails an Ihre Gäste senden", $sprache, $link)); ?>
                            .
                        </label>
                    </div>
                </div>
                <?php
            }
            if ($benutzerrechte == 1) {
                ?>
                <div class="row">
                    <div class="col-sm-3">
                        <a href="" role="button" class="btn btn-default" name="antwortenBearbeiten" target="_self"
                           style="width: 100%;">
                            <?php echo(getUebersetzung("Automatische e-Mails", $sprache, $link)); ?>
                        </a>
                    </div>
                    <div class="col-sm-9">
                        <label class="label-control" style="margin-top:7px;">
                            <?php echo(getUebersetzung("Die automatischen E-Mail-Antworten an ihre Gäste ändern (z. B. Buchungsbestätigung) oder E-Mails an Ihre Gäste senden", $sprache, $link)); ?>
                            .<strong><br/>
                                <?php echo(getUebersetzung("Diese Funktion ist nur für Administratoren verfügbar", $sprache, $link)); ?>
                                !</strong>
                        </label>
                    </div>
                </div>
                <?php
            }
            ?>
            <div class="row" <?php if ($benutzerrechte >= 1){ echo('style="margin-bottom: 10px;"'); }?>>
                <div class="col-sm-3">
                    <a href="http://www.rezervi.com/joomlaRezervi/index.php/rezervi-belegungsplan/dokumentation"
                       role="button" style="width: 100%;"
                       class="btn btn-default" name="doku" target="_blank">
                        <?php echo(getUebersetzung("Dokumentation", $sprache, $link)); ?>
                    </a>
                </div>
                <div class="col-sm-9">
                    <label class="label-control" style="margin-top:7px;">
                        <?php echo(getUebersetzung("Dokumentation des Webinterface und des Installationsvorgangs", $sprache, $link)); ?>
                        .
                    </label>
                </div>
            </div>
            <?php
            if ($benutzerrechte >= 1) {
                ?>
                <div class="row" <?php if ($benutzerrechte >= 1){ echo('style="margin-bottom: 10px;"'); }?>>
                    <div class="col-sm-3">
                        <a href="./abmelden.php" role="button" class="btn btn-default" name="abmelden" target="_blank"
                           style="width: 100%;">
                            <?php echo(getUebersetzung("Abmelden", $sprache, $link)); ?>
                            <span class="glyphicon glyphicon-log-out"></span>
                        </a>
                    </div>
                    <div class="col-sm-9">
                        <label class="label-control" style="margin-top:7px;">
                            <?php echo(getUebersetzung("Hiermit beenden Sie Ihre Sitzung", $sprache, $link)); ?>
                            .
                        </label>
                    </div>
                </div>

                <?php
            }
            //prüfen ob benutzer das recht hat den folgenden link auszuführen:
            //	if ($benutzerrechte < 1000) {
            ?>
        </div>
    </div>

	<?php include_once("./templates/end.php"); ?>
    <?php
} //ende sperren unterkünfte
//} //ende passwortprüfung ok
?>
