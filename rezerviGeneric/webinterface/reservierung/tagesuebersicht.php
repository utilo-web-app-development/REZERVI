<?php
	include_once($root."/include/tagesuebersichtHelper.inc.php");
	include_once($root."/templates/constants.inc.php");
	$ansicht = TAGESANSICHT;
?>
<table border="0" class="<?php echo TABLE_STANDARD ?>">
  <tr> 
    <td colspan="2"> 
      <?php
			showDay($tag,$monat,$jahr,$vermieter_id,$mietobjekt_id,MODUS_WEBINTERFACE);							 			
		?>
    </td>
  </tr>
  <tr valign="middle"> 
    <td> 
      <?php 		
      	$newTag1 = $tag-1;		
		$mon = $monat;
		$jah = $jahr;
		if ($newTag1 < 1){
			$newTag1 = getNumberOfDaysOfMonth($mon-1,$jahr);
			$mon = $mon - 1;
		}	
		if ($mon < 1){
			$mon = 12;
			$jah = $jah-1;
		}																		 																			
		?>
      <form action="./index.php" method="post" name="tagZurueck" target="_self" id="monatZurueck">
        <div align="right">           
          <input name="mietobjekt_id" type="hidden" id="mietobjekt_id" value="<?php echo $mietobjekt_id ?>">
          <input name="tag" type="hidden" id="tag" value="<?php echo $newTag1 ?>">
          <input name="monat" type="hidden" id="monat" value="<?php echo $mon ?>">
          <input name="ansicht" type="hidden" id="ansicht" value="<?php echo TAGESANSICHT ?>">
          <input name="jahr" type="hidden" id="jahr" value="<?php echo $jah ?>">
          <input name="zurueck" type="submit" class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
       		onMouseOut="this.className='<?php echo BUTTON ?>';" 
       		id="zurueck" value="<?php echo(getUebersetzung("einen Tag zurück")); ?>">
        </div>
      </form></td>
    <td> 
      <?php		
      	$newTag2 = $tag+1;
		$mon = $monat;
		$jah = $jahr;
		if ($newTag2 > getNumberOfDaysOfMonth($monat,$jahr)){
			$mon = $mon+1;		
			$newTag2 = 1;	
		}	
		if ($mon > 12){
			$mon = 1;
			$jah = $jah + 1;
		}																													
		?>
      <form action="./index.php" method="post" name="tagWeiter" target="_self" id="monatWeiter">
        <input name="mietobjekt_id" type="hidden" id="mietobjekt_id" value="<?php echo $mietobjekt_id ?>">
        <input name="tag" type="hidden" id="tag" value="<?php echo $newTag2 ?>">
        <input name="monat" type="hidden" id="monat" value="<?php echo $mon ?>">
        <input name="ansicht" type="hidden" id="ansicht" value="<?php echo TAGESANSICHT ?>">
        <input name="jahr" type="hidden" id="jahr" value="<?php echo $jah ?>">
        <input name="weiter" type="submit" class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
       		onMouseOut="this.className='<?php echo BUTTON ?>';" 
       		id="weiter" value="<?php echo(getUebersetzung("einen Tag weiter")); ?>">
      </form></td>
  </tr> 
</table>