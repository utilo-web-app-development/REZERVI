<?php
/*
	Button zur Anzeige des Hauptmenues des Webinterface
	Autor: Christian Osterrieder utilo.net
	Projekt: Rezervi 
*/

function showSubmitButtonWithForm($path,$value){
?>
	<table border="0" cellpadding="0" cellspacing="0" class="<?php echo TABLE_STANDARD ?>">
	  <tr>
		<td><form action="<?php echo($path); ?>" method="post" name="hauptmenue" target="_self" id="hauptmenue">
			<input name="<?php echo($value); ?>" type="submit" class="<?php echo BUTTON ?>" id="<?php echo($value); ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
		 onMouseOut="this.className='<?php echo BUTTON ?>';" value="<?php echo($value); ?>">
		  </form></td>
	  </tr>
	</table>
<?php
}


function showSubmitButton($value){
?>	
			<input name="<?php echo($value); ?>" type="submit" class="<?php echo BUTTON ?>" id="<?php echo($value); ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
		 onMouseOut="this.className='<?php echo BUTTON ?>';" value="<?php echo($value); ?>">
	
<?php
}
?>