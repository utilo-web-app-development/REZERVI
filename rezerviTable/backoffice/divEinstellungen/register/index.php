<? 
$root = "../../..";
$ueberschrift = "Diverse Einstellungen";
$unterschrift = "Registrierungen";

/*   
	date: 26.9.05
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/include/vermieterFunctions.inc.php");
//aenderungen durchfuehren:
if (isset($_POST["changeKey"]) && $_POST["changeKey"] == "true"){
	setGastroProperty(RESERVIERUNGSSCHLUESSEL,$_POST["key"],$gastro_id);	
	$info = true;
	$nachricht = "Ihr Reservierungsschlüssel wurde erfolgreich gespeichert.";
	$nachricht = getUebersetzung($nachricht);	
}

include_once($root."/backoffice/templates/breadcrumps.inc.php");
$breadcrumps = erzeugenBC($root, $ueberschrift, "divEinstellungen/index.php",
							$unterschrift, "divEinstellungen/register/index.php");
include_once($root."/backoffice/templates/bodyStart.inc.php"); 
include_once($root."/backoffice/templates/bodyStart.inc.php"); 			
include_once($root."/backoffice/templates/components.inc.php"); 
$key = getGastroProperty(RESERVIERUNGSSCHLUESSEL,$gastro_id); 

?>

<table>
	<h2><?php echo(getUebersetzung("Bookline Registrierung")); ?></h2>
  	<tr>
    	<td><?php echo(getUebersetzung("Falls Sie noch keinen gültigen Registrierungsschlüssel besitzen, ".
	"wenden Sie sich bitte an Christian Osterrieder-Schlick, UTILO, ")); ?>
	<a href="mailto:office@utilo.eu">office@utilo.eu</a>,
	<a href="http://www.rezervi.com/">www.rezervi.com</a>.</td>
  	</tr>
</table>
<br/>
<table>
  <form action="./index.php" method="post" target="_self">
  <input type="hidden" name="changeKey" value="true" />
    <tr>
    	<td>
    		<?php echo(getUebersetzung("Registrierungsschlüssel")); ?>
    	</td>
	    <td>
	      	<input type="text" name="key" value="<?= $key ?>" />
		</td>
  </tr>
  <tr>
    <td colspan="3">
 	 <?php 
	  showSubmitButton(getUebersetzung("speichern"));
	?>
	</td>
  </tr>
  </form>
</table>
<?php 
include_once($root."/backoffice/templates/footer.inc.php");
?>