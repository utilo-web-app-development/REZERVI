<?php $root = "../../../..";

/*   
	date: 17.10.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");

//prüfen ob noch reservierungen oder sowas für diesen gast vorhanden sind:
include_once($root."/include/mieterFunctions.inc.php");
include_once($root."/include/reservierungFunctions.inc.php");
$mieter_id = $_POST["mieter_id"];
if(hasMieterReservations($mieter_id)){
	$fehler = true;
	$nachricht = getUebersetzung("Der Mieter kann nicht gelöscht werden, da noch Reservierungen oder offene Reservierungsanfragen für diesen Mieter eingetragen sind!");
	include_once("./index.php");
	exit;
}

include_once($root."/webinterface/templates/bodyStart.inc.php"); 

$index = $_POST["index"];

deleteMieter($mieter_id);

?>

<table width="100%" border="0" cellspacing="3" cellpadding="0" class="<?php echo FREI ?>">
  <tr>
    <td><?php echo(getUebersetzung("Der Mieter wurde erfolgreich gelöscht")); ?>!    
    </td>
  </tr>
</table>
<br/>
  <form action="../index.php" method="post" name="ok" target="_self" id="ok">
    <input type="submit" name="Submit" class="<?php echo BUTTON ?>" id="zurueck" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
   onMouseOut="this.className='<?php echo BUTTON ?>';" value="<?php echo(getUebersetzung("zurück")); ?>">
	<input name="index" type="hidden" value="<?php echo($index); ?>"/>
  </form>  
<?php	  
include_once($root."/webinterface/templates/footer.inc.php");
?>
