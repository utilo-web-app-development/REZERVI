<?php session_start(); 
$root = "..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
$sprache = getSessionWert(SPRACHE);	

include_once("../include/uebersetzer.php");
?>
function chkFormular()
    {
     if(document.e_mail_form.name.value == ""){
       alert("<?php echo(getUebersetzung("Bitte geben Sie den Namen ein!",$sprache,$link)); ?>");
       document.e_mail_form.name.focus();
       return false;
     }
     else if(document.e_mail_form.email.value == ""){
       alert("<?php echo(getUebersetzung("Bitte geben Sie die E-Mail-Adresse ein!",$sprache,$link)); ?>");
       document.e_mail_form.email.focus();
       return false;
     }
	 else if(document.e_mail_form.nachricht.value == ""){
       alert("<?php echo(getUebersetzung("Bitte geben Sie Ihre Nachricht ein!",$sprache,$link)); ?>");
       document.e_mail_form.nachricht.focus();
       return false;
     }
     else{
     	return true;
     }
}