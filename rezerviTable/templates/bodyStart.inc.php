<body class="<?= BACKGROUND_COLOR ?>">

	   <?php
	   //einfuegen von Fehlermeldung oder Info
	   if (isset($nachricht) && $nachricht != ""){
	   ?>
	   <div name="nachricht" style="">
	   	<?php 
	   	if (isset($fehler) && $fehler == true) { ?>
		   	<div class="<?= BELEGT ?>">
		   		<?php echo($nachricht); ?>
		   	</div>
	   	<?php
	   	}
	   	else if(isset($info) && $info == true){
	   	?>
		   	<div class="<?= FREI ?>">
		   		<?php echo($nachricht); ?>
		   	</div>
	   	<?php
	   	}
	   	?>
	   	</div>
	   <?php
	   }
	   ?>
<!-- ende nachricht -->
<!-- start main content -->
<div name="content">