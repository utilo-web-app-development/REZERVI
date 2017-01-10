<?php session_start();
$root = "../..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once($root . "/include/sessionFunctions.inc.php");
/*   
			reservierungsplan rezervi
			author: christian osterrieder utilo.eu
*/

//variablen:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
$sprache = getSessionWert(SPRACHE);
setSessionWert(SPRACHE, $sprache);

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
<?php include_once("subtemplates/index.js.php"); ?>
<?php include_once("../templates/headerB.php"); ?>
<?php include_once("../templates/bodyA.php"); ?>
<?php //passwortprüfung:	
if (checkPass($benutzername, $passwort, $unterkunft_id, $link)){
?>

<div class="panel panel-default" ng-app="rezerviApp" ng-controller="MainController">
    <div class="panel-heading">
        <h2>
            <?php echo(getUebersetzung("Benutzer bearbeiten", $sprache, $link)); ?>
            TODO: Make a list of users
        </h2>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="col-sm-2">
                <?php echo(getUebersetzung("Benutzer", $sprache, $link)); ?>
            </label>
            <div class="col-sm-3">
                <select class="form-control" name="users" id="users"
                        ng-model="users"
                        ng-options="user.id as user.name for user in usersArray">
                </select>
            </div>
            <div class="col-sm-7">
                <a class="btn btn-primary" href="./benutzerAendern.php?id={{users}}" id="{{users}}">
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp
                    <?php echo(getUebersetzung("Benutzer Ändern", $sprache, $link)); ?>
                </a>

                <?php
                //-------------ende benutzer ändern
                /*
                //-------------benutzer löschen
                prüfen ob benutzer überhaupt vorhanden sind
                */
                if (getAnzahlVorhandeneBenutzer($unterkunft_id, $link) > 1) {
                    ?>
                    <a class="btn btn-danger" href="./benutzerLoeschenBestaetigen.php?id={{users}}" id="{{users}}">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>&nbsp
                        <?php echo(getUebersetzung("Benutzer Löschen", $sprache, $link)); ?>
                    </a>

                    <?php
                } //ende anzahlBenutzer ist ok
                ?>
                <a class="btn btn-primary" href="./benutzerAnlegen.php">
                    <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>&nbsp
                    <?php echo(getUebersetzung("Benutzer anlegen", $sprache, $link)); ?>
                </a>
            </div>
        </div>

        <?php
        } //ende if passwortprüfung
        else {
            header("Location: http://localhost/rezervi/rezervi/webinterface/index.php"); /* Redirect browser */
            exit();
        }
        ?>
    </div>
</div>
<?php include_once("../templates/end.php"); ?>
