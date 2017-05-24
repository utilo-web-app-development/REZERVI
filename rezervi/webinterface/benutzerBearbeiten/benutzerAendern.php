<?php session_start();
$root = "../..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once($root . "/include/sessionFunctions.inc.php");
/*   
			reservierungsplan rezervi
			author utilo.eu
			benutzer aendern
*/

//variablen:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
$id = $_POST["id"];
if(!isset($id)){
    $id = $_GET["id"];
}
$sprache = getSessionWert(SPRACHE);
setSessionWert(SPRACHE, $sprache);


//datenbank öffnen:
include_once("../../conf/rdbmsConfig.php");

//andere funktionen importieren:
include_once("../../include/benutzerFunctions.php");
include_once("../../include/unterkunftFunctions.php");
//uebersetzer einfuegen:
include_once("../../include/uebersetzer.php");

//daten des ausgewählten benutzers auslesen:
$name = getUserName($id, $link);
$pass = getPassword($id, $link);
$rechte = getUserRights($id, $link);
$testuser = "false";
if ($name == "test") {
    $testuser = "true";
}

?>
<?php include_once("../templates/headerA.php"); ?>
<style type="text/css">
    <?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>

<!--<script language="JavaScript" type="text/javascript" src="./benutzerDaten.php">-->
<!--</script>-->
<?php include_once("subtemplates/userEdit.js.php"); ?>

<?php include_once("../templates/headerB.php"); ?>
<?php include_once("../templates/bodyA.php"); ?>

<?php //passwortprüfung:
if (checkPass($benutzername, $passwort, $unterkunft_id, $link)) {

    ?>

    <div class="panel panel-default" ng-app="rezerviApp" ng-controller="MainController">
        <div class="panel-heading">
            <h2><?php echo(getUebersetzung("Benutzer bearbeiten", $sprache, $link)); ?></h2>
        </div>
        <div class="panel-body">
            <form action="./benutzerAendernDurchfuehren.php" method="post" name="benutzer" target="_self"
                  class="form-horizontal">

                <input name="id" ng-model="id" type="hidden" value="<?php echo $id; ?>">
                <input name="testuser" ng-model="testuser" type="hidden" value="<?php echo($testuser); ?>">
                <input name="sprache" type="hidden" ng-model="sprache" value="<?php echo $sprache; ?>">

                <div class="form-group">
                    <label for="name" class="col-sm-2"><?php echo(getUebersetzung("Benutzername", $sprache, $link)); ?>
                        *</label>
                    <div class="col-sm-10">
                        <input name="name" type="text" id="name" ng-model="name" value="" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="pass" class="col-sm-2">
                        <?php echo(getUebersetzung("Passwort", $sprache, $link)); ?>*
                    </label>
                    <div class="col-sm-10">
                        <input name="pass" type="password" id="pass" ng-model="pass" value="" class="form-control"
                               required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="pass2" class="col-sm-2">
                        <?php echo(getUebersetzung("Passwort wiederholen", $sprache, $link)); ?>*
                    </label>
                    <div class="col-sm-10">
                        <input name="pass2" type="password" id="pass2" ng-model="pass2" value="" class="form-control"
                               required
                               use-form-error="isNotSame" use-error-expression="pass && pass2 && pass!=pass2">
                    </div>
                </div>
                <div class="form-group" ng-messages="benutzer.pass2.$error">
                    <div class="col-sm-12" >
                        <div>
                            <div class="alert alert-danger" ng-message="isNotSame">
                                <?php echo(getUebersetzung("Passwort sind nicht gleich", $sprache, $link)); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="rechte" class="col-sm-2 ">
                        <?php echo(getUebersetzung("Benutzerrechte", $sprache, $link)); ?>
                    </label>
                    <div class="col-sm-10">
                        <select class="form-control" name="rechte" id="rechte"
                                ng-model="rechte">
                            <option ng-repeat="roleType in roles" value="{{roleType.id}}">{{roleType.role}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button name="submit" type="submit" id="submit" ng-model="submit"ng-disabled="benutzer.$invalid" class="btn btn-success">
                            <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
                        <?php echo(getUebersetzung("Benutzer ändern", $sprache, $link)); ?>
                        </button>
                        <a class="btn btn-primary" href="./index.php">
                            <?php echo(getUebersetzung("Abbrechen", $sprache, $link)); ?>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php
} //ende if passwortprüfung
else {
    header("Location: ".$URL."webinterface/index.php"); /* Redirect browser */
    exit();
}
?>
<?php include_once("../templates/end.php"); ?>