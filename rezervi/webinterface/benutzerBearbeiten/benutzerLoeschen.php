<?php session_start();
$root = "../..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once($root . "/include/sessionFunctions.inc.php");
/*   
			reservierungsplan
			bestätigung zum löschen von zimmern von benutzer einholen!
*/

$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort      = getSessionWert(PASSWORT);
$benutzername  = getSessionWert(BENUTZERNAME);
//$id = $_POST["id"];
$sprache = getSessionWert(SPRACHE);


//datenbank öffnen:
include_once("../../conf/rdbmsConfig.php");

//andere funktionen importieren:
include_once("../../include/benutzerFunctions.php");
include_once("../../include/unterkunftFunctions.php");
include_once("../../include/gastFunctions.php");
include_once("../../include/reservierungFunctions.php");
include_once("../../include/zimmerFunctions.php");
//uebersetzer einfuegen:
include_once("../../include/uebersetzer.php");


//variablen initialisieren:
if (isset($_POST["ben"]) && isset($_POST["pass"])) {
	$ben = $_POST["ben"];
	$pass = $_POST["pass"];
} else {
	//aufruf kam innerhalb des webinterface:
	$ben = getSessionWert(BENUTZERNAME);
	$pass = getSessionWert(PASSWORT);
}

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



<?php //passwortprüfung:
if (checkPass($benutzername, $passwort, $unterkunft_id, $link))
{
$benutzer_id = getUserId($benutzername, $passwort, $link);
?>

		<?php

		//benutzer auslesen:
		$query = "select 
				  PK_ID, Name
				  from 
				  Rezervi_Benutzer
				  where
				  FK_Unterkunft_ID = '$unterkunft_id'
				  ORDER BY 
				  Name";

		$res = mysqli_query($link, $query);
		if (!$res)
		{
			header("Location: ".$URL."webinterface/benutzerBearbeiten/index.php?message=Database-Fehler,-Versuchen-Sie-erneut-wieder&error=true"); /* Redirect browser */
			exit();
		}
		else
		{

			while ($d = mysqli_fetch_array($res))
			{

				if ($d["PK_ID"] == $benutzer_id) continue;
				if ($d["PK_ID"] == 1 && DEMO == true) continue;

				if (isset($_GET["user_" . $d["PK_ID"]]))
				{

					$query = ("DELETE FROM 
							Rezervi_Benutzer
	           			 	WHERE
	           				PK_ID = " . $d["PK_ID"]);

					$res = mysqli_query($link, $query);
					if (!$res)
					{
						header("Location: ".$URL."webinterface/benutzerBearbeiten/index.php?message=Database-Fehler,-Versuchen-Sie-erneut-wieder&error=true"); /* Redirect browser */
						exit();
					}

				}
			} //ende for

		}


    header("Location: ".$URL."webinterface/benutzerBearbeiten/index.php?message=Der-Benutzer-wurde-aus-der-Datenbank-gelöscht!&error=false"); /* Redirect browser */
    exit();
    //echo(getUebersetzung("Der Benutzer wurde aus der Datenbank gelöscht!", $sprache, $link)); ?>

		<?php
		} //ende if passwortprüfung
		else
		{
			header("Location: ".$URL."webinterface/benutzerBearbeiten/index.php?message=Bitte-Browser-schließen-und-neu-anmelden.-Passwortprüfung fehlgeschlagen!&error=true"); /* Redirect browser */
			exit();
            //echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!", $sprache, $link)); ?>

		<?php }
		?>
