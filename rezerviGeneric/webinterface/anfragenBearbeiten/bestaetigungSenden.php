<? $root = "../..";

/*   
	date: 7.10.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");
include_once($root."/webinterface/templates/components.inc.php"); 
include_once($root."/webinterface/templates/bodyStart.inc.php");
include_once($root."/include/mail.inc.php");
include_once($root."/include/mieterFunctions.inc.php");
$an = $_POST["an"];
$von = $_POST["von"];
$subject = $_POST["subject"];
$message = $_POST["message"];
$mieter_id = $_POST["mieter_id"];

sendMail($von,$an,$subject,$message); 

 //save mail in mieter Texte:
 $text = "Automatisch generierte Bestätigung zu einer Anfrage.\n";
 $text .="Betreff: ".$subject."\n";
 $text .="Nachricht: ".$message;
 insertMieterText($text,$mieter_id);
			 
?>
<p class="<?= FREI ?>"><?php echo(getUebersetzung("Der Mieter wurde per E-Mail verständigt")); ?>.</p>
<table border="0" cellpadding="0" cellspacing="3">
  <tr>
    <td>
      <?php 
	 	 showSubmitButtonWithForm("./index.php",getUebersetzung("zurück"));
		?>
    </td>
  </tr>
</table>
<?php 
include_once($root."/webinterface/templates/footer.inc.php");
?>