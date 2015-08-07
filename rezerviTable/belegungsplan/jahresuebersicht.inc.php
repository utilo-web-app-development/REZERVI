<?php
//helper-funktionen einfügen:
include_once($root."/include/jahresuebersichtHelper.inc.php");
?>
<table width="100%" border="0" class="<?= TABLE_STANDARD ?>">

  <tr>
    <td colspan="2"><?php			
			showYear(1,$jahr,$gastro_id,$mietobjekt_id);			
		?>
    </td>
  </tr>
  <tr valign="middle">
    <td width="50%"><?php		
		$jah = $jahr-1;
		if (!($jah < getTodayYear()-4)){																					 																			
		?>
      <form action="./start.php" method="post" name="monatZurueck" target="_self" id="monatZurueck">
        <div align="right">
          <input name="monat" type="hidden" id="monat" value="<? echo($monat); ?>">
          <input name="mietobjekt_id" type="hidden" id="mietobjekt_id" value="<? echo $mietobjekt_id ?>">
          <input name="jahr" type="hidden" id="jahr" value="<? echo($jah); ?>">
		  <input name="ansicht" type="hidden" id="monat" value="<?= JAHRESUEBERSICHT ?>">
          <input name="zurueck" type="submit" class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
       onMouseOut="this.className='<?= BUTTON ?>';" onClick="updateLeft(<?php echo(($monat).",".($jah).",".($mietobjekt_id)); ?>,0);" id="zurueck" value="<?php echo(getUebersetzung("ein Jahr zurück")); ?>">
        </div>
      </form>
      <?php } //ende if jahr 
	  ?></td>
    <td width="50%"><?php		
		$jah = $jahr+1;
		if (!($jah >= getTodayYear()+4)){																															
		?>
      <form action="./start.php" method="post" name="monatWeiter" target="_self" id="monatWeiter">
        <input name="mietobjekt_id" type="hidden" id="mietobjekt_id" value="<? echo $mietobjekt_id ?>">
        <input name="jahr" type="hidden" id="jahr" value="<? echo ($jah); ?>">
        <input name="monat" type="hidden" id="monat" value="<? echo($monat); ?>">
		<input name="ansicht" type="hidden" id="monat" value="<?= JAHRESUEBERSICHT ?>">
        <input name="weiter" type="submit" class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
       onMouseOut="this.className='<?= BUTTON ?>';" onClick="updateLeft(<?php echo(($monat).",".($jah).",".($mietobjekt_id)); ?>,1);" id="weiter" value="<?php echo(getUebersetzung("ein Jahr weiter")); ?>">
      </form>
      <?php } //ende if jahr 
	  ?></td>
  </tr>
</table>
