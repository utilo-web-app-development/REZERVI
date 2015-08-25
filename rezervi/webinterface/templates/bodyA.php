<body class="backgroundColor">
	
	<!-- Bootstrap Menu -->
	<nav class="navbar navbar-inverse navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><?php echo(getUebersetzung(getUnterkunftName($unterkunft_id,$link),$sprache,$link)); ?></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="./inhalt.php"><a href="#">Home</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Reservierungen <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="<?= $root ?>/webinterface/reservierung/index.php"><?php echo(getUebersetzung("Reservierungsplan",$sprache,$link)); ?></a></li>
                <li><a href="<?= $root ?>/webinterface/anfragenBearbeiten/index.php"><?php echo(getUebersetzung("Anfragen",$sprache,$link)); ?></a></li>
              
              </ul> 
            </li>           
            <li><a href="<?= $root ?>/webinterface/gaesteBearbeiten/index.php"><?php echo(getUebersetzung("Gäste",$sprache,$link)); ?></a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Einstellungen <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="<?= $root ?>/webinterface/benutzerBearbeiten/index.php"><?php echo(getUebersetzung("Benutzerdaten bearbeiten",$sprache,$link)); ?></a></li>
                <li><a href="<?= $root ?>/webinterface/zimmerBearbeiten/index.php"><?php echo(getUebersetzung("Zimmer bearbeiten",$sprache,$link)); ?></a></li>
                <li><a href="<?= $root ?>/webinterface/unterkunftBearbeiten/index.php"><?php echo(getUebersetzung("Unterkunft bearbeiten",$sprache,$link)); ?></a></li>
                <li><a href="<?= $root ?>/webinterface/divEinstellungen/index.php"><?php echo(getUebersetzung("Diverse Einstellungen",$sprache,$link)); ?></a></li>
                <li><a href="<?= $root ?>/webinterface/designBearbeiten/index.php"><?php echo(getUebersetzung("Design bearbeiteien",$sprache,$link)); ?></a></li>
                <li><a href="<?= $root ?>/webinterface/autoResponse/index.php"><?php echo(getUebersetzung("Automatische e-Mails",$sprache,$link)); ?></a></li>
              </ul>
            </li>            
          </ul>
          <ul class="nav navbar-nav navbar-right">
        <li><a href="<?= $root ?>/webinterface/abmelden.php">Abmelden</a></li>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container" style="margin-top:70px;">	