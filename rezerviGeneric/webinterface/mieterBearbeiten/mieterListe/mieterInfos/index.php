<? $root = "../../../..";

/*   
	date: 14.10.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");

include_once($root."/include/mieterFunctions.inc.php");
include_once($root."/include/reservierungFunctions.inc.php");
include_once($root."/webinterface/templates/components.inc.php"); 

$mieter_id = $_POST["mieter_id"];
$index = $_POST["index"];

if(!hasMieterReservations($mieter_id)){
	$fehler = true;
	$nachricht = "Es liegen noch keine Reservierungen für den gewählten Mieter vor.";
}

include_once($root."/webinterface/templates/bodyStart.inc.php"); 
if(hasMieterReservations($mieter_id)){
?>
<p class="<?= STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("Es liegen folgende Reservierungen für den Mieter vor")); ?>:
</p>
<table  border="1" cellpadding="0" cellspacing="3">
  <tr class="<?= TABLE_COLOR ?>">
	<td><?php echo(getUebersetzung("Reservierung von")); ?></td>
	<td><?php echo(getUebersetzung("bis")); ?></td>
	<td><?php echo(getUebersetzung("für")); ?></td>
  </tr>
	<!-- ausgeben der reservierungen: -->
	<?php
		$res = getReservationsOfMieter($mieter_id);
		while($d = mysql_fetch_array($res)){
			//variablen auslesen:
			$mietobjekt_id = $d["MIETOBJEKT_ID"];
			$bezeichnung = getMietobjektBezeichnung($mietobjekt_id);
			$datumVon = $d["VON"];
			$datumBis = $d["BIS"];
	 ?>
              <tr class="<?= TABLE_STANDARD ?>">
                <td><?php echo($datumVon); ?></td>
                <td><?php echo($datumBis); ?></td>
                <td><?php echo($bezeichnung); ?></td>
  			  </tr>
		<?php 
			} //ende while
		?>
</table>
<?
}
?>
<br/>
<table border="0" cellspacing="3" cellpadding="0">
  <tr>
    <td>
      <form action="../index.php" method="post" name="ok" target="_self" id="ok">
        <input type="submit" name="Submit" class="<?= BUTTON ?>" id="zurueck" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
       onMouseOut="this.className='<?= BUTTON ?>';" value="<?php echo(getUebersetzung("zurück")); ?>">
		<input name="index" type="hidden" value="<?php echo($index); ?>"/>
      </form>      
    </td>
  </tr>
</table>
<?php	
include_once($root."/webinterface/templates/footer.inc.php");
?>