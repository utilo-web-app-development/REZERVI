<? $root = "../..";

/*   
	date: 4.10.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");
include_once($root."/webinterface/templates/bodyStart.inc.php"); 
include_once($root."/webinterface/templates/components.inc.php"); 
include_once($root."/include/bildFunctions.inc.php"); 
include_once($root."/templates/constants.inc.php"); 

	$index = $_POST["index"];
	$bilder_id = $_POST["bilder_id"];

	deleteBild($bilder_id);	
	
	$anzahl = getAnzahlBilderOfVermieter($vermieter_id);
	if ($anzahl > 0){
?>
  <table border="0" cellpadding="0" cellspacing="3">
	<tr> 
      <td><form action="./bilderLoeschen.php" method="post" name="weiter" target="_self" enctype="multipart/form-data">
			<input name="index" type="hidden" value="<?php echo($index); ?>"/>
			<?php 
				showSubmitButton(getUebersetzung("weitere Bilder löschen"));
			?>
		  </form>
      </td>
    </tr>
  </table>
  <br/>
<?php 
	}
	  //-----buttons um zurück zu gelangen: 
	  showSubmitButtonWithForm("./index.php",getUebersetzung("zurück"));

include_once($root."/webinterface/templates/footer.inc.php");
?>
