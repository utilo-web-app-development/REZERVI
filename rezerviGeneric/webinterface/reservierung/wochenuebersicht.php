<?php
	include_once($root."/include/wochenuebersichtHelper.inc.php");
	include_once($root."/templates/constants.inc.php");
	$ansicht = WOCHENANSICHT;
?>
<table border="0" class="<?= TABLE_STANDARD ?>">
  <tr> 
    <td colspan="2"> 
      <?php
			showWeek($tag,$monat,$jahr,$vermieter_id,$mietobjekt_id,MODUS_WEBINTERFACE);							 			
		?>
    </td>
  </tr>
  <tr valign="middle"> 
    <td> 
      <?php 		
      	$newTag1 = $tag-7;		
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
          <input name="mietobjekt_id" type="hidden" id="mietobjekt_id" value="<?= $mietobjekt_id ?>">
          <input name="tag" type="hidden" id="tag" value="<?= $newTag1 ?>">
          <input name="monat" type="hidden" id="monat" value="<?= $mon ?>">
          <input name="ansicht" type="hidden" id="monat" value="<?= WOCHENANSICHT ?>">
          <input name="jahr" type="hidden" id="jahr" value="<?= $jah ?>">
          <input name="zurueck" type="submit" class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
       		onMouseOut="this.className='<?= BUTTON ?>';" 
       		id="zurueck" value="<?php echo(getUebersetzung("eine Woche zurück")); ?>">
        </div>
      </form></td>
    <td> 
      <?php		
      	$newTag2 = $tag+7;
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
        <input name="mietobjekt_id" type="hidden" id="mietobjekt_id" value="<?= $mietobjekt_id ?>">
        <input name="tag" type="hidden" id="tag" value="<?= $newTag2 ?>">
        <input name="monat" type="hidden" id="monat" value="<?= $mon ?>">
        <input name="ansicht" type="hidden" id="monat" value="<?= WOCHENANSICHT ?>">
        <input name="jahr" type="hidden" id="jahr" value="<?= $jah ?>">
        <input name="weiter" type="submit" class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
       		onMouseOut="this.className='<?= BUTTON ?>';" 
       		id="weiter" value="<?php echo(getUebersetzung("eine Woche weiter")); ?>">
      </form></td>
  </tr> 
</table>