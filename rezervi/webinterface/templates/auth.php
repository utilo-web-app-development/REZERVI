<?php //variablen initialisieren:
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