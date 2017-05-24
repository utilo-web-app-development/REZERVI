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
$id            = $_POST["id"];
$pass          = $_POST["pass"];
$name          = $_POST["name"];
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
