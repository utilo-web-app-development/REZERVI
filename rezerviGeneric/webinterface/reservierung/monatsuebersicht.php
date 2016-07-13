<?php
	include_once($root."/include/monatsuebersichtHelper.inc.php");
	include_once($root."/templates/constants.inc.php");
	$ansicht = MONATSUEBERSICHT;
?>
<table width="100%" border="0" class="<?php echo TABLE_STANDARD ?>">
  <tr> 
    <td colspan="2"> 
      <?php
			//kontrolle ob monat nicht 0 oder 13:
			if ($monat > 12){
				$monat = 1;
				$jahr= $jahr + 1;
			} 
			elseif ($monat < 1){
				$monat = 12;
				$jahr= $jahr - 1;
			}
			//monat ausgeben:
			showMonth($monat,$jahr,$vermieter_id,$mietobjekt_id,MODUS_WEBINTERFACE);							 			
		?>
    </td>
  </tr>
  <tr valign="middle"> 
    <td> 
      <?php 				
		$mon = $monat-1;
		$jah = $jahr;
		if ($mon < 1){
			$mon = 12;
			$jah = $jah - 1;
		}																			 																			
		?>
      <form action="./index.php" method="post" name="monatZurueck" target="_self" id="monatZurueck">
        <div align="right">           
          <input name="mietobjekt_id" type="hidden" id="mietobjekt_id" value="<?php echo $mietobjekt_id ?>">
          <input name="monat" type="hidden" id="monat" value="<?php echo $mon ?>">
          <input name="jahr" type="hidden" id="jahr" value="<?php echo $jah ?>">
		  <input name="ansicht" type="hidden" id="monat" value="<?php echo MONATSUEBERSICHT ?>">
          <input name="zurueck" type="submit" class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
       		onMouseOut="this.className='<?php echo BUTTON ?>';" 
       		id="zurueck" value="<?php echo(getUebersetzung("ein Monat zurück")); ?>">
        </div>
      </form></td>
    <td> 
      <?php		
		$mon = $monat+1;
		$jah = $jahr;
		if ($mon > 12){
			$mon = 1;
			$jah = $jah + 1;
		}																														
		?>
      <form action="./index.php" method="post" name="monatWeiter" target="_self" id="monatWeiter">
        <input name="mietobjekt_id" type="hidden" id="mietobjekt_id" value="<?php echo $mietobjekt_id ?>">
        <input name="monat" type="hidden" id="monat" value="<?php echo $mon ?>">
        <input name="jahr" type="hidden" id="jahr" value="<?php echo $jah ?>">
		<input name="ansicht" type="hidden" id="monat" value="<?php echo MONATSUEBERSICHT ?>">
        <input name="weiter" type="submit" class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
       		onMouseOut="this.className='<?php echo BUTTON ?>';" 
       		id="weiter" value="<?php echo(getUebersetzung("ein Monat weiter")); ?>">
      </form></td>
  </tr> 
</table>