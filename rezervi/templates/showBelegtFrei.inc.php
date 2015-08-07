<?php
/**
 * Created on 31.08.2006
 *
 * @author coster
 */
$saAktiviert = getPropertyValue(SHOW_OTHER_COLOR_FOR_SA,$unterkunft_id,$link);
if ($saAktiviert != "true"){
	$saAktiviert = false;
}
$showReservation = getPropertyValue(SHOW_RESERVATION_STATE,$unterkunft_id,$link);
if ($showReservation != "true"){
	$showReservation = false;
}
?>
<table border="0" class="tableColor">
    <tr>
      <td width="23" height="23" class="frei">&nbsp;</td>
      <td><?php echo(getUebersetzung("frei",$sprache,$link)); ?></td>
    </tr>
	<?php
	if ($showReservation){
	?>
	<tr>
	  <td width="23" height="23" class="reserviert">&nbsp;</td>
	  <td><?php echo(getUebersetzung("reserviert",$sprache,$link)); ?></td>
	</tr>
	<?php
	} //end show reservation
	?>    
    <tr>
      <td width="23" height="23" class="belegt">&nbsp;</td>
      <td><?php echo(getUebersetzung("belegt",$sprache,$link)); ?></td>
    </tr>    
	<?php
	if ($saAktiviert){
	?>
		<tr>
		  <td width="23" height="23" class="samstagFrei">&nbsp;</td>
		  <td><?php echo(getUebersetzung("Samstag frei",$sprache,$link)); ?></td>
		</tr>
		<?php
		if ($showReservation){
		?>
		<tr>
		  <td width="23" height="23" class="samstagReserviert">&nbsp;</td>
		  <td><?php echo(getUebersetzung("Samstag reserviert",$sprache,$link)); ?></td>
		</tr>
		<?php
		} //end show reservation
		?>		
		<tr>
		  <td width="23" height="23" class="samstagBelegt">&nbsp;</td>
		  <td><?php echo(getUebersetzung("Samstag belegt",$sprache,$link)); ?></td>
		</tr>
	<?php
	}
	?>
  </table>