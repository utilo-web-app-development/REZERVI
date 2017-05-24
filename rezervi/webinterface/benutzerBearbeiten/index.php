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
$passwort      = getSessionWert(PASSWORT);
$benutzername  = getSessionWert(BENUTZERNAME);
$sprache       = getSessionWert(SPRACHE);
setSessionWert(SPRACHE, $sprache);

//variablen initialisieren:
if (isset($_POST["ben"]) && isset($_POST["pass"])) {
	$ben = $_POST["ben"];
	$pass = $_POST["pass"];
} else {
	//aufruf kam innerhalb des webinterface:
	$ben = getSessionWert(BENUTZERNAME);
	$pass = getSessionWert(PASSWORT);
}

//Messae
$message = $_GET["message"];
$error   = $_GET["error"];

if ($error)
{
	$message = str_replace("-", " ", $message);
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
<?php include_once("../../layouts/js/angularParent.php"); ?>
<?php include_once("subtemplates/index.js.php"); ?>

<?php include_once("../templates/headerB.php"); ?>
<?php include_once("../templates/bodyA.php"); ?>
<?php
//passwortprüfung:
if (checkPass($benutzername, $passwort, $unterkunft_id, $link))
{
?>

<?php if ($error == true)
{ ?>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="alert alert-success">
				<?php echo $message; ?>
            </div>
        </div>
    </div>
<?php }
else if ($error == false && $error != null)
{
	?>
    <div class="panel panel-danger">
        <div class="panel-body">
            <div class="alert alert-success">
				<?php echo $message; ?>
            </div>
        </div>
    </div>
	<?php
} ?>


    <div class="panel panel-default">
        <div class="panel-body">
            <a class="btn btn-primary btn-sm" href="./benutzerAnlegen.php">
				<?php echo(getUebersetzung("Benutzer anlegen", $sprache, $link)); ?>
            </a>
        </div>
    </div>
<div class="panel panel-default" ng-app="rezerviApp" ng-controller="MainController">
    <div class="panel-heading">
        <h3 class="panel-title">
			<?php echo(getUebersetzung("Benutzer", $sprache, $link)); ?>
        </h3>
    </div>
    <div class="panel-body">
        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th><?php echo(getUebersetzung("Benutzer", $sprache, $link)); ?></th>
                <th><?php echo(getUebersetzung("Benutzerrechte", $sprache, $link)); ?></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="userInfo in usersArray">
                <td>
                    {{userInfo.name}}
                </td>
                <td>
                    {{userInfo.role}}
                </td>
                <td class="text-right" nowrap>
                    <a class="btn btn-primary btn-sm" href="./benutzerAendern.php?id={{userInfo.id}}"
                       id="{{userInfo.id}}">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp
						<?php echo(getUebersetzung('Bearbeiten', $sprache, $link)); ?>
                    </a>
                    <button class="btn btn-danger btn-sm"
                            ng-confirm-click="Wollen Sie die User wirklich löschen?"
                            confirmed-click="delete('{{userInfo.id}}');">
                        <span class="glyphicon glyphicon-trash"></span>&nbsp
						<?php echo(getUebersetzung('Löschen', $sprache, $link)); ?>
                    </button>
                </td>
            </tr>
            </tbody>
        </table>


		<?php
		} //ende if passwortprüfung
		else
		{
			header("Location: ".$URL."webinterface/index.php"); /* Redirect browser */
			exit();
		}
		?>
    </div>
</div>
<?php include_once("../templates/end.php"); ?>
