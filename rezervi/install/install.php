<?php session_start();
$root = "..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once($root . "/include/sessionFunctions.inc.php");

$sprache = $_POST["sprache"];
$name = $_POST["unterkunft_name"];
$art = $_POST["art"];
$ZIMMERART_EZ = $_POST["mietobjekt_ez"];
$ZIMMERART_MZ = $_POST["mietobjekt_mz"];

include_once("../include/uebersetzer.php");

?>
<?php
session_start();
$root = "..";
// Set flag that this is a parent file
define('_JEXEC', 1);

include_once($root . "/layouts/header.php");

?>
<title>Installation Rezervi</title>
<?php include_once("subtemplates/install.js.php"); ?>
<?php include_once($root . "/layouts/headerEnd.php"); ?>

<body class="backgroundColor" data-pinterest-extension-installed="cr1.39.1">
<div class="container" style="margin-top:20px;">


    <div class="panel panel-default" ng-app="rezerviApp" ng-controller="MainController">
        <div class="panel-heading">
            <h2>
                {{title}}
            </h2>
        </div>
        <div class="panel-body">
            <input type="hidden" name="sprache" ng-model="sprache" value="<?php echo $_POST["sprache"]; ?>">
            <h2>
                {{installation}}
            </h2>
            <?php
            //installation durchfuehren:
            //1. tabellen:
            include_once("installTables.php");
            setSessionWert(SPRACHE, $sprache);
            ?>
            <?php
            if (!$fail) {
                ?>
                <div class="alert alert-success">
                    <strong>Success!</strong> <?php echo(getUebersetzung("Teil 1 abgeschlossen", $sprache, $link)); ?>
                </div>
                <?php
            } else {
                ?>
                <div class="alert alert-danger">
                    <strong>Error!</strong> <?php echo(getUebersetzung("Teil 1 abgeschlossen", $sprache, $link)); ?>
                </div>
                <?php
            }
            ?>
            <div class="alert alert-info">
                <strong>Info!</strong> <?php echo $antwort ?>
            </div>

            <?php
            //2. unterkunft:
            $antwort = "";
            include_once("UKeintragen.php");
            ?>
            <?php
            if (!$fehler) {
                ?>
                <div class="alert alert-success">
                    <strong>Success!</strong> <?php echo(getUebersetzung("Teil 2 abgeschlossen", $sprache, $link)); ?>
                </div>
                <?php
            } else {
                ?>
                <div class="alert alert-danger">
                    <strong>Error!</strong> <?php echo(getUebersetzung("Teil 2 abgeschlossen", $sprache, $link)); ?>
                </div>
                <?php
            }
            ?>
            <div class="alert alert-info">
                <strong>Info!</strong> <?php echo $antwort ?>
            </div>
            <?php
            //3. sprache
            $antwort = "";
            include_once("installSprache.php");
            ?>
            <?php
            if (!$fehler) {
                ?>
                <div class="alert alert-success">
                    <strong>Success!</strong> <?php echo(getUebersetzung("Teil 3 abgeschlossen", $sprache, $link)); ?>
                </div>
                <?php
            } else {
                ?>
                <div class="alert alert-danger">
                    <strong>Error!</strong> <?php echo(getUebersetzung("Teil 3 abgeschlossen", $sprache, $link)); ?>
                </div>
                <?php
            }
            ?>
            <div class="alert alert-info">
                <strong>Info!</strong> <?php echo $antwort ?>
            </div>

        </div>
        <div class="panel-body">

            <h2><?php echo(getUebersetzung("So können sie Rezervi verlinken", $sprache, $link)); ?>:</h2>
            <ul class="list-group">
                <li class="list-group-item">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <?php echo(getUebersetzung("Die Startseite Ihres Belegungsplanes", $sprache, $link)); ?>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <?php echo(getUebersetzung("http://ihre-domain/ihrInstallationsverzeichnis/", $sprache, $link)); ?>
                            <a  href="../start.php" target="_blank">start.php</a>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <?php echo(getUebersetzung("Dieser Seite können Sie auch die gewünschte Sprache übergeben", $sprache, $link)); ?>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <ul class="list-unstyled">
                                <li>
                                    <?php echo(getUebersetzung("http://ihre-domain/ihrInstallationsverzeichnis/", $sprache, $link)); ?>
                                    <a  href="../start.php?spracheNeu=de" target="_blank">start.php?spracheNeu=de</a>
                                </li>
                                <li>
                                    <?php echo(getUebersetzung("http://ihre-domain/ihrInstallationsverzeichnis/", $sprache, $link)); ?>
                                    <a  href="../start.php?spracheNeu=en" target="_blank">start.php?spracheNeu=en</a>
                                </li>
                                <li>
                                    <?php echo(getUebersetzung("http://ihre-domain/ihrInstallationsverzeichnis/", $sprache, $link)); ?>
                                    <a  href="../start.php?spracheNeu=fr" target="_blank">start.php?spracheNeu=fr</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <?php echo(getUebersetzung("Sie können auch direkt die Suchfunktion aufrufen", $sprache, $link)); ?>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <?php echo(getUebersetzung("http://ihre-domain/ihrInstallationsverzeichnis/", $sprache, $link)); ?>
                            <a  href="../suche/index.php" target="_blank">suche/index.php</a>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <?php echo(getUebersetzung("Auch dieser Seite kann die gewünschte Sprache übergeben werden", $sprache, $link)); ?>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <ul class="list-unstyled">
                                <li>
                                    <?php echo(getUebersetzung("http://ihre-domain/ihrInstallationsverzeichnis/", $sprache, $link)); ?>
                                    <a  href="../suche/index.php?sprache=de"
                                       target="_blank">suche/index.php?sprache=de</a>
                                </li>
                                <li>
                                    <?php echo(getUebersetzung("http://ihre-domain/ihrInstallationsverzeichnis/", $sprache, $link)); ?>
                                    <a  href="../suche/index.php?sprache=en"
                                       target="_blank">suche/index.php?sprache=en</a>
                                </li>
                                <li>
                                    <?php echo(getUebersetzung("http://ihre-domain/ihrInstallationsverzeichnis/", $sprache, $link)); ?>
                                    <a  href="../suche/index.php?sprache=fr"
                                       target="_blank">suche/index.php?sprache=fr</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>

                <li class="list-group-item">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <?php echo(getUebersetzung("Den Zugang zur Webschnittstelle erhalten sie über", $sprache, $link)); ?>
                                (<?php echo(getUebersetzung("Verwenden sie als Benutzername und Passwort \"test\" und ändern sie das Passwort nach erstmaligem Einstieg.", $sprache, $link)); ?>
                                )
                            </h3>
                        </div>
                        <div class="panel-body">
                            <?php echo(getUebersetzung("http://ihre-domain/ihrInstallationsverzeichnis/", $sprache, $link)); ?>
                            <a href="../webinterface/index.php" target="_blank">webinterface/index.php</a>
                        </div>
                    </div>
                </li>
            </ul>
            <p>
                <?php echo(getUebersetzung("Nach erfolgreicher Installation sollten Sie den Ordner &quot;install&quot; auf Ihrem Webserver löschen, ansonsten kann durch einen Angriff von aussen Ihre Datenbank verändert werden", $sprache, $link)); ?>
                !
            </p>

            <p>
                <?php echo(getUebersetzung("Wir sind ihnen auch gerne bei Fragen zur Installation behilflich. Senden sie uns einfach ein E-Mail unter", $sprache, $link)); ?>
            </p>
            <p>
                <a class="btn btn-default" href="mailto:rezervi@utilo.eu"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> rezervi@utilo.eu</a>
            </p>

            <!-- webinterface öffnen -->
            <form action="../webinterface/index.php" method="post" id="formLizenz" name="formLizenz" target="_self"
                  onSubmit="return checkLicence();">
                <p class="standardSchrift">
                    <?php echo(getUebersetzung("Bitte ändern sie nun ihre Einstellungen im Webinterface", $sprache, $link)); ?>
                </p>
                <input name="Submit" type="submit" class="btn btn-primary"
                       value="<?php echo(getUebersetzung("Webinterface öffnen", $sprache, $link));?>">
            </form>
            <!-- ende webinterface öffnen -->
        </div>
    </div>
</body>
</html>
