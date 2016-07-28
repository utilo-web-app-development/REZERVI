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

//datenbank öffnen:
include_once("../../conf/rdbmsConfig.php");

//andere funktionen importieren:
include_once("../../include/benutzerFunctions.php");
include_once("../../include/unterkunftFunctions.php");
//uebersetzer einfuegen:
include_once("../../include/uebersetzer.php");

?>
<?php include_once("../templates/headerA.php"); ?>
    <style type="text/css">
        <?php include_once($root."/templates/stylesheetsIE9.php"); ?>
    </style>
<?php include_once("../templates/headerB.php"); ?>
<?php include_once("../templates/bodyA.php"); ?>
    <div class="panel panel-default">
    <div class="panel-heading">
        <h2><?php echo(getUebersetzung("Automatische Antworten bearbeiten, E-Mails an Ihre Gäste senden", $sprache, $link)); ?></h2>
    </div>
    <div class="panel-body">
<?php
//passwortprüfung:
if (checkPass($benutzername, $passwort, $unterkunft_id, $link)) {
    ?>

    <p class="lead">
        <?php echo(getUebersetzung("Ändern Sie hier die automatischen E-Mail Antworten an Ihre Gäste oder benutzen Sie das Mail-Formular zum senden von E-Mails an Ihre Gäste.", $sprache, $link)); ?>
        <?php echo(getUebersetzung("Bitte achten Sie darauf, dass die automatischen E-Mail Antworten nur ausgeführt werden wenn Sie aktiviert wurden.", $sprache, $link)); ?>
        <?php echo(getUebersetzung("Eine nicht-aktivierte E-Mail Antwort wird nicht an Ihren Gast gesendet - Sie müssen die Anfragen händisch beantworten!", $sprache, $link)); ?>
    </p>



    <form action="./texteAnzeigen.php" method="post" name="BuchungsbestaetigungForm" id="BuchungsbestaetigungForm" target="_self"
          class="form-horizontal">
        <div class="row">
            <div class="col-sm-2">
                <input name="bestaetigung" type="submit" class="btn btn-primary" id="bestaetigung" style="width: 160px;"
                       value="<?php echo(getUebersetzung("Buchungsbestätigung", $sprache, $link)); ?>">
            </div>
            <label class="col-sm-10 label-control">
                <?php echo(getUebersetzung("ändern der E-Mail-Buchungsbestätigung die ein Gast erhält wenn Sie die Reservierung akzeptieren", $sprache, $link)); ?>
                .
            </label>
        </div>
    </form>
    <br>
    <form action="./texteAnzeigen.php" method="post" name="adresseForm" target="_self"
          class="form-horizontal">
        <div class="row">
            <div class="col-sm-2">
                <input name="ablehnung" type="submit" class="btn btn-primary" id="ablehnung" style="width: 160px;"
                       value="<?php echo(getUebersetzung("Buchungs-Absage", $sprache, $link)); ?>">
            </div>
            <label class="col-sm-10 label-control">
                <?php echo(getUebersetzung("ändern des Absagetextes einer Anfrage die ein Gast erhält wenn Sie die Reservierung ablehnen", $sprache, $link)); ?>
                .
            </label>
        </div>
    </form>
    <br>
    <form action="./texteAnzeigen.php" method="post" name="adresseForm" target="_self" onSubmit="return chkFormular();"
          class="form-horizontal">
        <div class="row">
            <div class="col-sm-2">
                <input name="anfrage" type="submit" class="btn btn-primary" id="anfrage" style="width: 160px;"
                       value="<?php echo(getUebersetzung("Buchungs-Anfrage", $sprache, $link)); ?>">
            </div>
            <label class="col-sm-10 label-control">
                <?php echo(getUebersetzung("ändern des Bestätigungstextes einer Buchungsanfrage die ein Gast erhält wenn er eine Buchungsanfrage im Belegungsplan vornimmt", $sprache, $link)); ?>
                .
            </label>
        </div>
    </form>
    <br>
    <form action="./texteAnzeigen.php" method="post" name="adresseForm" target="_self" onSubmit="return chkFormular();"
          class="form-horizontal">
        <div class="row">
            <div class="col-sm-2">
                <input name="emails" type="submit" class="btn btn-primary" id="emails" style="width: 160px;"
                       value="<?php echo(getUebersetzung("E-Mails senden", $sprache, $link)); ?>">
            </div>
            <label class="col-sm-10 label-control">
                <?php echo(getUebersetzung("E-Mails an ihre Gäste senden", $sprache, $link)); ?>.
            </label>
        </div>
    </form>

    <?php
} //ende if passwortprüfung
else {
    echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!", $sprache, $link));
}
?>
<?php include_once("../templates/end.php"); ?>