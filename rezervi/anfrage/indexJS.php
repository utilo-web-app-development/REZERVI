<?php session_start(); 
$root = "..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
$sprache = getSessionWert(SPRACHE);	

include_once("../include/uebersetzer.php");
?>
function chkFormular() {
	     if( (document.adresseForm.vorname.value == "")){
	       alert("<?php echo(getUebersetzung("Bitte geben Sie den Vornamen ein!",$sprache,$link)); ?>");
	       document.adresseForm.vorname.focus();
	       return false;
	     }
	     else if( (document.adresseForm.nachname.value == "")){
	       alert("<?php echo(getUebersetzung("Bitte geben Sie den Nachnamen ein!",$sprache,$link)); ?>");
	       document.adresseForm.nachname.focus();
	       return false;
	     }
		 else if( (document.adresseForm.strasse.value == "")){
	       alert("<?php echo(getUebersetzung("Bitte geben Sie die Straße und Hausnummer ein!",$sprache,$link)); ?>");
	       document.adresseForm.strasse.focus();
	       return false;
	     }
		 else if( (document.adresseForm.plz.value == "")){
	       alert("<?php echo(getUebersetzung("Bitte geben Sie die Postleitzahl ein!",$sprache,$link)); ?>");
	       document.adresseForm.plz.focus();
	       return false;
	     }
		 else if( (document.adresseForm.ort.value == "")){
	       alert("<?php echo(getUebersetzung("Bitte geben Sie den Wohnort ein!",$sprache,$link)); ?>");
	       document.adresseForm.ort.focus();
	       return false;
	     }
		 else if( (document.adresseForm.email.value == "")){
	       alert("<?php echo(getUebersetzung("Bitte geben Sie die E-Mail-Adresse ein!",$sprache,$link)); ?>");
	       document.adresseForm.email.focus();
	       return false;
	     }
		 else{
	     	return true;
		 }
}