<?php session_start();
$root = "..";
$doInstall = true;
include_once($root."/include/sessionFunctions.inc.php");

$sprache = $_POST["sprache"];
$name = $_POST["firma_name"];
		
include_once("../include/uebersetzer.inc.php");
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Installation Rezervi Table</title>
<link href="../templates/stylesheets.css" rel="stylesheet" type="text/css">
</head>

<body>
<p class="ueberschrift"><?php 
	//sprache ist erst ab installation-schritt 3 verf�gbar!
	if ($sprache == "en"){
		?>
		Installation of Rezervi Table
		<?php
	}
	else if ($sprache == "de"){
		?>
		Installation Rezervi Table
	<?php 
	}	
	?>
</p>
<br/>
<p class="standardSchriftBold"><?php 
	if ($sprache == "en"){
		?>
		Doing the installation ...
		<?php
	}
	else if ($sprache == "de"){
		?>
		Installation wird durchgeführt ... 
	<?php 
	}	
	?>
</p>
<?php
	//installation durchfuehren:
	//1. tabellen:
	include_once("installTables.php");
	setSessionWert(SPRACHE,$sprache);
?>
<p class="standardSchrift"><?php 
	if ($sprache == "en"){
		?>
		Part 1 finished ...
		<?php
	}
	else if ($sprache == "de"){
		?>
		Teil 1 abgeschlossen ... 
	<?php 
	}	
	?>
</p>
<?php
	//2. gastronomiebetrieb mit standardwerten fuellen:
	include_once("./mietobjektEintragen.php");
?>
<p class="standardSchrift"><?php
	if ($sprache == "en"){
		?>
		Part 2 finished ...
		<?php
	}
	else if ($sprache == "de"){
		?>
		Teil 2 abgeschlossen ... 
	<?php 
	}	
	?></p>
<?php
	//3. sprache
	include_once("installSprache.php");
?>
<p class="standardSchrift"><?php
	if ($sprache == "en"){
		?>
		Part 3 finished ...
		<?php
	}
	else if ($sprache == "de"){
		?>
		Teil 3 abgeschlossen ... 
	<?php 
	}	
	?></p>
<p class="standardSchrift"><?php echo(getUebersetzung("Installation abgeschlossen")); ?></p>

<?php if ($fehler == true) { ?><p class="belegt"><?php echo($antwort); ?></p><?php } ?>

<p class="standardSchriftBold"><?php echo(getUebersetzung("So können sie Rezervi Table verlinken")); ?>:</p>
<ul>
  <li class="standardSchrift"><?php echo(getUebersetzung("Die Startseite Ihres Tischreservierungsplanes")); ?>: <br>
    <?php echo(getUebersetzung("http://ihre-domain/ihrInstallationsverzeichnis/")); ?><a href="../start.php" target="_blank">start.php</a></li>
  <li class="standardSchrift"><?php echo(getUebersetzung("Dieser Seite können Sie auch die gewünschte Sprache übergeben")); ?>:<br>
  <?php echo(getUebersetzung("http://ihre-domain/ihrInstallationsverzeichnis/")); ?><a href="../start.php?spracheNeu=de" target="_blank">start.php?spracheNeu=de</a><br>
  <?php echo(getUebersetzung("http://ihre-domain/ihrInstallationsverzeichnis/")); ?><a href="../start.php?spracheNeu=en" target="_blank">start.php?spracheNeu=en</a><br>
  <?php echo(getUebersetzung("http://ihre-domain/ihrInstallationsverzeichnis/")); ?><a href="../start.php?spracheNeu=fr" target="_blank">start.php?spracheNeu=fr</a></li>
  <li class="standardSchrift"><?php echo(getUebersetzung("Den Zugang zum Backoffice erhalten sie über")); ?>
  (<?php echo(getUebersetzung("Verwenden sie als Benutzername und Passwort \"test\" und ändern sie das Passwort nach erstmaligem Einstieg.")); ?>):<br>
  <?php echo(getUebersetzung("http://ihre-domain/ihrInstallationsverzeichnis/")); ?><a href="../backoffice/index.php" target="_blank">backoffice/index.php</a></li>
</ul>
<p class="standardSchrift"><?php echo(getUebersetzung("Nach erfolgreicher Installation sollten Sie den Ordner &quot;install&quot; auf Ihrem Webserver löschen, ansonsten kann durch einen Angriff von aussen Ihre Datenbank verändert werden")); ?>!</p>

<p class="standardSchrift"><?php echo(getUebersetzung("Wir sind ihnen auch gerne bei Fragen zur Installation behilflich. Senden sie uns einfach ein E-Mail unter")); ?>:</p>
<p class="standardSchrift"><script language="JavaScript">
										<!--
										var name = "office";
										var domain = "utilo.eu";
										document.write('<a href=\"mailto:' + name + '@' + domain + '\">');
										document.write(name + '@' + domain + '</a>');
										// -->
									  </script></p>

<!-- backoffice �ffnen -->
<form action="../backoffice/index.php" method="post" id="formLizenz" name="formLizenz" target="_self" onSubmit="return checkLicence();">
	<p class="standardSchrift"><?php echo(getUebersetzung("Bitte ändern sie nun ihre Einstellungen im Backoffice")); ?></p>
	<input name="Submit" type="submit" class="button200pxA" value="<?= getUebersetzung("Backoffice öffnen") ?>">
</form>
<!-- ende backoffice oeffnen -->

</body>
</html>
