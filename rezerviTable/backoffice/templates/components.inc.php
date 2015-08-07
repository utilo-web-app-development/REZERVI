<?php
/*
	Button zur Anzeige des Hauptmenues des Backoffice
	Autor: Christian Osterrieder alpstein-austria
	Projekt: Rezervi 
*/

function showSubmitButtonWithForm($path,$value){
?>
	<table>
	  <tr valign="middle" >
		<td valign="middle"><form action="<?php echo($path); ?>" method="post" name="hauptmenue" target="_self" id="hauptmenue">
			<input name="<?php echo($value); ?>" type="submit" class="button" value="<?php echo($value); ?>">
		  </form></td>
	  </tr>
	</table>
<?php
}


function showSubmitButton($value){
?>	
	<input name="<?php echo($value); ?>" type="submit" class="button" value="<?php echo($value); ?>">
	
<?php
}

function showSubmitButtonNo($value){
?>	
	<input name="<?php echo($value); ?>"  type="button" class="button_nolink" value="<?php echo($value); ?>">
	
<?php
}
?>