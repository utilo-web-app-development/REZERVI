<?php session_start();
$root = "../..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once($root . "/include/sessionFunctions.inc.php");
/*   
			reservierungsplan
			benutzer anlegen
*/

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

?>
<?php include_once("../templates/headerA.php"); ?>
<style type="text/css">
    <?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("subtemplates/userCreate.js.php"); ?>

<?php include_once("../templates/headerB.php"); ?>
<!--<script language="JavaScript" type="text/javascript" src="./benutzerDaten.php">
</script>-->
<?php include_once("../templates/bodyA.php"); ?>

<div class="panel panel-default" ng-app="rezerviApp" ng-controller="MainController">
    <div class="panel-heading">
        <h2>
            <?php echo getUebersetzung("Benutzer anlegen", $sprache, $link); ?>
        </h2>
    </div>
    <div class="panel-body">
        <form action="./benutzerEintragen.php" method="post" name="benutzer" id="benutzer" target="_self"
              class="form-horizontal" novalidate>
            <input name="sprache" type="hidden" ng-model="sprache" value="<?php echo $sprache; ?>">
            <div class="form-group">
                <label for="name" class="col-sm-2 ">
                    <?php echo(getUebersetzung("Benutzername", $sprache, $link)); ?> *
                </label>
                <div class="col-sm-10">
                    <input name="name" type="text" id="name" ng-model="name" value="" class="form-control" required="required">
                </div>
            </div>

            <div class="form-group">
                <label for="pass"
                       class="col-sm-2 ">
                    <?php echo(getUebersetzung("Passwort", $sprache, $link)); ?> *
                </label>
                <div class="col-sm-10">
                    <input name="pass" id="pass" type="password" ng-model="pass" value="" class="form-control" required="required">
                </div>
            </div>

            <div class="form-group">
                <label for="pass2"
                       class="col-sm-2 ">
                    <?php echo(getUebersetzung("Passwort wiederholen", $sprache, $link)); ?>*
                </label>
                <div class="col-sm-10">
                    <input name="pass2" id="pass2" ng-model="pass2" type="password" value="" class="form-control"
                           use-form-error="isNotSame" use-error-expression="pass && pass2 && pass!=pass2"
                           required="required" >
                </div>
            </div>

            <div class="form-group" ng-messages="benutzer.pass2.$error">
                <div class="col-sm-12" >
                    <div >
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
                        <?php echo(getUebersetzung("Benutzer anlegen", $sprache, $link)); ?>
                    </button>
                    <a class="btn btn-primary" href="./index.php">
                        <?php echo(getUebersetzung("Abbrechen", $sprache, $link)); ?>
                    </a>
                </div>
            </div>

        </form>
    </div>
</div>
<?php include_once("../templates/end.php"); ?>
