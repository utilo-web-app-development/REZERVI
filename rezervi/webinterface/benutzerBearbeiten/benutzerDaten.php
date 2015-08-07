<? session_start();
$root = "../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
$sprache = getSessionWert(SPRACHE);

	//datenbank öffnen:
	include_once("../../conf/rdbmsConfig.php");
	//uebersetzer einfuegen:
	include_once("../../include/uebersetzer.php");

?>
function chkFormular()
	{
		
	 if(document.benutzer.name.value == ""){
	   alert("<?php echo(getUebersetzung("Bitte geben Sie den Benutzernamen ein!",$sprache,$link)); ?>");
	   document.benutzer.name.focus();
	   return false;
	 }
	 if(document.benutzer.pass.value != document.benutzer.pass2.value){
	   alert("<?php echo(getUebersetzung("Die beiden Passwörter stimmen nicht überein!",$sprache,$link)); ?>");
	   document.benutzer.pass.focus();
	   return false;
	 }
	 return true;
}
