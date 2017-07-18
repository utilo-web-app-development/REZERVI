<?php session_start();
$root = "../..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once($root . "/include/sessionFunctions.inc.php");
/*   
			reservierungsplan
			benutzeränderung durchführen
*/

$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort      = getSessionWert(PASSWORT);
$benutzername  = getSessionWert(BENUTZERNAME);
//variablen initialisieren:
if (isset($_POST["ben"]) && isset($_POST["pass"])) {
    $ben = $_POST["ben"];
    $passwort = $_POST["pass"];
} else {
    //aufruf kam innerhalb des webinterface:
    $ben = getSessionWert(BENUTZERNAME);
    $passwort = getSessionWert(PASSWORT);
}

$id            = $_POST["id"];
$name          = $_POST["name"];
$pass          = $_POST["pass"];
$pass2         = $_POST["pass2"];
$rechte        = $_POST["rechte"];
$sprache       = getSessionWert(SPRACHE);
$testuser      = $_POST["testuser"];

if ($testuser == "true")
{
	$testuser = true;
}
else
{
	$testuser = false;
}

//datenbank öffnen:
include_once("../../conf/rdbmsConfig.php");

//andere funktionen importieren:
include_once("../../include/benutzerFunctions.php");
include_once("../../include/unterkunftFunctions.php");
//uebersetzer einfuegen:
include_once("../../include/uebersetzer.php");

$benutzer_id = -1;
if (isset($ben) && isset($passwort)) {
    $benutzer_id = checkPassword($ben, $passwort, $link);
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
    $passwort = $passwort;
    setSessionWert(BENUTZERNAME, $benutzername);
    setSessionWert(PASSWORT, $passwort);

    //unterkunft-id holen:
    $unterkunft_id = getUnterkunftID($benutzer_id, $link);
    setSessionWert(UNTERKUNFT_ID, $unterkunft_id);
    setSessionWert(BENUTZER_ID, $benutzer_id);
}

?>

<?php //passwortprüfung:	

if (checkPass($benutzername, $passwort, $unterkunft_id, $link))
{

	if ($testuser == true && DEMO == true)
	{
		header("Location: ".$URL."webinterface/benutzerBearbeiten/index.php"); /* Redirect browser */
		exit();
	}
	else if (changeBenutzer($id, $name, $pass, $rechte, $unterkunft_id, $link))
	{

		//Änderungen in der session durchführen:
		if (getSessionWert(BENUTZER_ID) == $id)
		{
			setSessionWert(PASSWORT, $pass);
			setSessionWert(BENUTZERNAME, $name);
			setSessionWert(RECHTE, '2');
		}
		header("Location: ".$URL."webinterface/benutzerBearbeiten/index.php"); /* Redirect browser */
		exit();
	}
	?>

	<?php
} //ende if passwortprüfung
else
{
	header("Location: ".$URL."webinterface/index.php"); /* Redirect browser */
	exit();
}
?>
