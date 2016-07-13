<?php 
$root = "../..";
$ueberschrift = "Tisch bearbeiten";

/*   
	date: 4.10.05
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/backoffice/templates/bodyStart.inc.php"); 
include_once($root."/backoffice/templates/components.inc.php"); 
include_once($root."/include/bildFunctions.inc.php"); 
include_once($root."/templates/constants.inc.php"); 

	$index = $_POST["index"];
	$bilder_id = $_POST["bilder_id"];

	deleteBild($bilder_id);	
	
	$anzahl = getAnzahlBilderOfRaum($gastro_id);
	if ($anzahl > 0){
?>
  <table border="0" cellpadding="0" cellspacing="3">
	<tr> 
      <td><form action="./bilderLoeschen.php" method="post" name="weiter" target="_self" enctype="multipart/form-data">
			<input name="index" type="hidden" value="<?php echo($index); ?>"/>
			<?php 
				showSubmitButton(getUebersetzung("weitere Bilder l�schen"));
			?>
		  </form>
      </td>
    </tr>
  </table>
  <br/>
<?php 
	}
	  //-----buttons um zur�ck zu gelangen: 
	  showSubmitButtonWithForm("./index.php",getUebersetzung("zurück"));

include_once($root."/backoffice/templates/footer.inc.php");
?>
