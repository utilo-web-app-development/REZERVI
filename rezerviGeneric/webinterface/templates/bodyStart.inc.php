<?php
	include_once($root."/include/vermieterFunctions.inc.php");
?>
<body class="<?php echo BACKGROUND_COLOR ?>">
<table border="0" cellpadding="3" cellspacing="0" class="<?php echo TABLE_STANDARD ?>">
  <tr>
  	<td colspan="2"><p class="<?php echo UEBERSCHRIFT ?>">Rezervi Generic Webinterface - <?php echo(getUebersetzung(getVermieterFirmenName($vermieter_id))); ?></p>
  	</td>
  </tr>
  <tr valign="top">
    <td>
		<?php
		//menue einfuegen
		include_once($root."/webinterface/templates/menue.inc.php");
		?>
	</td>
	<td>
	  <table border="0" cellpadding="3" cellspacing="0" class="<?php echo TABLE_STANDARD ?>">
		   <?php
		   //einfuegen von Fehlermeldung oder Info
		   if (isset($nachricht) && $nachricht != ""){
		   ?>
		   <tr>
		   	<?php if (isset($fehler) && $fehler == true) { ?>
			   	<td class="<?php echo BELEGT ?>">
			   		<?php echo($nachricht); ?>
			   	</td>
		   	<?php
		   	}
		   	else if(isset($info) && $info == true){
		   	?>
			   	<td class="<?php echo FREI ?>">
			   		<?php echo($nachricht); ?>
			   	</td>
		   	<?php
		   	}
		   	?>
		   </tr>
		   <?php
		   }
		   ?>
		   <tr>
		   	<td>
		   	<?php
		   	//start content:
		   	?>