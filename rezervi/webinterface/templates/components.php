<?php
/*
	Button zur Anzeige des Hauptmenues des Webinterface
	Autor: Christian Osterrieder utilo.eu
	Projekt: Rezervi 
*/

function showSubmitButtonWithForm($path,$value){
?>
	<table border="0" cellpadding="0" cellspacing="0" class="table">
	  <tr>
		<td><form action="<?php echo($path); ?>" method="post" name="hauptmenue" target="_self" id="hauptmenue">
			<input name="<?php echo($value); ?>" type="submit" class="btn btn-primary" id="<?php echo($value); ?>" onMouseOver="this.className='button200pxB';"
		 onMouseOut="this.className='button200pxA';" value="<?php echo($value); ?>">
		  </form></td>
	  </tr>
	</table>
<?php
}


function showSubmitButton($value){
?>
	<div class="form-group">
		<div class="col-sm-offset-10 col-sm-2">
			<input name="<?php echo($value); ?>" type="submit" class="btn btn-primary" id="<?php echo($value); ?>" ;" value="<?php echo($value); ?>">
		</div>
	</div>

<?php
}
?>