<?php session_start();
$root = "../../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
	include_once("../../../conf/rdbmsConfig.php");
	//uebersetzer einfuegen:
	include_once("../../../include/uebersetzer.php");
	$sprache = getSessionWert(SPRACHE);
?>
function chkFormular()
{

 if((document.adresseForm.nachname.value == "")){
   alert("<?php echo(getUebersetzung("Bitte geben Sie den Nachnamen ein!",$sprache,$link)); ?>");
   document.adresseForm.nachname.focus();
   return false;
 }
 return true;
}	