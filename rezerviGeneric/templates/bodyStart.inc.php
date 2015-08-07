<body class="<?= BACKGROUND_COLOR ?>">
<table border="0" cellpadding="3" cellspacing="0" class="<?= TABLE_STANDARD ?>">
  <tr>
  	<td>
  		<p class="<?= UEBERSCHRIFT ?>"><?php echo(getUebersetzung(getVermieterFirmenName($vermieter_id))); ?></p>
  	</td>
  </tr>
  <tr valign="top">
	<td>
	  <table border="0" cellpadding="3" cellspacing="0" class="<?= TABLE_STANDARD ?>">
		   <?php
		   //einfuegen von Fehlermeldung oder Info
		   if (isset($nachricht) && $nachricht != ""){
		   ?>
		   <tr>
		   	<?php if (isset($fehler) && $fehler == true) { ?>
			   	<td class="<?= BELEGT ?>">
			   		<?php echo($nachricht); ?>
			   	</td>
		   	<?php
		   	}
		   	else if(isset($info) && $info == true){
		   	?>
			   	<td class="<?= FREI ?>">
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