<?php session_start();
$root = "..";
$doInstall = true;
include_once($root."/include/sessionFunctions.inc.php");

	$sprache = $_POST["sprache"];
	$name = $_POST["firma_name"];
	$mietobjekt_einzahl = $_POST["mietobjekt_ez"];
	$mietobjekt_mehrzahl = $_POST["mietobjekt_mz"];
		
	include_once("../include/uebersetzer.inc.php");
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Installation Rezervi</title>
<link href="../templates/stylesheets.css" rel="stylesheet" type="text/css">
</head>

<body>
<p class="ueberschrift"><?php 
	//sprache ist erst ab installation-schritt 3 verfügbar!
	if ($sprache == "en"){
		?>
		Installation of Rezervi Generic booking system
		<?php
	}
	else if ($sprache == "de"){
		?>
		Installation Rezervi Generic Buchungssystem
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
	//2. unterkunft:
	include_once("MietobjektEintragen.php");
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
<p class="standardSchrift"><?php echo(getUebersetzung("Installation abgeschlossen",$sprache,$link)); ?></p>

<?php if ($fehler == true) { ?><p class="belegt"><?php echo($antwort); ?></p><?php } ?>

<p class="standardSchriftBold"><?php echo(getUebersetzung("So können sie Rezervi Generic verlinken",$sprache,$link)); ?>:</p>
<ul>
  <li class="standardSchrift"><?php echo(getUebersetzung("Die Startseite Ihres Belegungsplanes",$sprache,$link)); ?>: <br>
    <?php echo(getUebersetzung("http://ihre-domain/ihrInstallationsverzeichnis/",$sprache,$link)); ?><a href="../start.php" target="_blank">start.php</a></li>
  <li class="standardSchrift"><?php echo(getUebersetzung("Dieser Seite können Sie auch die gewünschte Sprache übergeben",$sprache,$link)); ?>:<br>
  <?php echo(getUebersetzung("http://ihre-domain/ihrInstallationsverzeichnis/",$sprache,$link)); ?><a href="../start.php?spracheNeu=de" target="_blank">start.php?spracheNeu=de</a><br>
  <?php echo(getUebersetzung("http://ihre-domain/ihrInstallationsverzeichnis/",$sprache,$link)); ?><a href="../start.php?spracheNeu=en" target="_blank">start.php?spracheNeu=en</a><br>
  <?php echo(getUebersetzung("http://ihre-domain/ihrInstallationsverzeichnis/",$sprache,$link)); ?><a href="../start.php?spracheNeu=fr" target="_blank">start.php?spracheNeu=fr</a></li>
  <li class="standardSchrift"><?php echo(getUebersetzung("Sie können auch direkt die Suchfunktion aufrufen",$sprache,$link)); ?>:<br>
  <?php echo(getUebersetzung("http://ihre-domain/ihrInstallationsverzeichnis/",$sprache,$link)); ?><a href="../suche/index.php" target="_blank">suche/index.php</a></li>
  <li class="standardSchrift"><?php echo(getUebersetzung("Auch dieser Seite kann die gewünschte Sprache übergeben werden",$sprache,$link)); ?>: <br>
  <?php echo(getUebersetzung("http://ihre-domain/ihrInstallationsverzeichnis/",$sprache,$link)); ?><a href="../suche/index.php?sprache=de" target="_blank">suche/index.php?sprache=de</a><br>
  <?php echo(getUebersetzung("http://ihre-domain/ihrInstallationsverzeichnis/",$sprache,$link)); ?><a href="../suche/index.php?sprache=en" target="_blank">suche/index.php</a><a href="../suche/index.php" target="_blank">?sprache=en</a><br>
  <?php echo(getUebersetzung("http://ihre-domain/ihrInstallationsverzeichnis/",$sprache,$link)); ?><a href="../suche/index.php?sprache=fr" target="_blank">suche/index.php</a><a href="../suche/index.php" target="_blank">?sprache=fr</a> </li>
  <li class="standardSchrift"><?php echo(getUebersetzung("Den Zugang zur Webschnittstelle erhalten sie über",$sprache,$link)); ?>
  (<?php echo(getUebersetzung("Verwenden sie als Benutzername und Passwort \"test\" und ändern sie das Passwort nach erstmaligem Einstieg.",$sprache,$link)); ?>):<br>
  <?php echo(getUebersetzung("http://ihre-domain/ihrInstallationsverzeichnis/",$sprache,$link)); ?><a href="../webinterface/index.php" target="_blank">webinterface/index.php</a></li>
</ul>
<p class="standardSchrift"><?php echo(getUebersetzung("Nach erfolgreicher Installation sollten Sie den Ordner &quot;install&quot; auf Ihrem Webserver löschen, ansonsten kann durch einen Angriff von aussen Ihre Datenbank verändert werden",$sprache,$link)); ?>!</p>

<p class="standardSchrift"><?php echo(getUebersetzung("Wir sind ihnen auch gerne bei Fragen zur Installation behilflich. Senden sie uns einfach ein E-Mail unter",$sprache,$link)); ?>:</p>
<p class="standardSchrift"><a href="mailto:office@utilo.net">office@utilo.net</a></p>

<!-- webinterface öffnen -->
<form action="../webinterface/index.php" method="post" id="formLizenz" name="formLizenz" target="_self" onSubmit="return checkLicence();">
	<p class="standardSchrift"><?php echo(getUebersetzung("Bitte ändern sie nun ihre Einstellungen im Webinterface",$sprache,$link)); ?></p>
	<input name="Submit" type="submit" class="button200pxA" value="<?= getUebersetzung("Webinterface öffnen",$sprache,$link) ?>">
</form>
<!-- ende webinterface öffnen -->

</body>
</html>
