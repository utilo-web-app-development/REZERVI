<?php $root = "../..";

/*   
	date: 3.11.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");

include_once($root."/include/mietobjektFunctions.inc.php");
include_once($root."/include/datumFunctions.inc.php");
include_once($root."/include/mieterFunctions.inc.php");
include_once($root."/include/reservierungFunctions.inc.php");

$status = $_POST["status"];
$vonTag = $_POST["vonTag"];
$bisTag = $_POST["bisTag"];
$vonMonat = $_POST["vonMonat"];
$bisMonat = $_POST["bisMonat"];
$vonJahr = $_POST["vonJahr"];
$bisJahr = $_POST["bisJahr"];
$vonMinute=$_POST["vonMinute"];
$vonStunde=$_POST["vonStunde"];
$bisMinute=$_POST["bisMinute"];
$bisStunde=$_POST["bisStunde"];
$mietobjekt_id = $_POST["mietobjekt_id"];
$ansicht = $_POST["ansicht"];

include_once($root."/webinterface/templates/bodyStart.inc.php"); 	

deleteReservationWithDate($mietobjekt_id,$vonMinute,$vonStunde,$vonTag,$vonMonat,$vonJahr,$bisMinute,$bisStunde,$bisTag,$bisMonat,$bisJahr);
				
?>


<form action="./index.php" method="post" target="_self">
<input type="hidden" name="ansicht" value="<?php echo $ansicht ?>"/>
<input name="monat" type="hidden" id="monat" value="<?php echo $vonMonat ?>"> 
<input name="jahr" type="hidden" id="jahr" value="<?php echo $vonJahr ?>">
<input name="tag" type="hidden" id="tag" value="<?php echo $vonTag ?>">
<input name="mietobjekt_id" type="hidden" id="mietobjekt_id" value="<?php echo($mietobjekt_id); ?>">
  <table  border="0" cellpadding="0" cellspacing="3" class="<?php echo FREI ?>">
    <tr>
      <td><?php echo(getUebersetzung("Die Reservierungen wurden erfolgreich entfernt")); ?>!        
      </td>
    </tr>
  </table>
  <br/>
  <table  border="0" cellspacing="3" cellpadding="0">
    <tr>
      <td><input type="submit" name="Submit" class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
       onMouseOut="this.className='<?php echo BUTTON ?>';" value="<?php echo(getUebersetzung("zurück")); ?>"> </td>
    </tr>
  </table> 
  </form> 
<?php
	include_once($root."/webinterface/templates/footer.inc.php");
?>