<?php session_start();
$root = "..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");

$sprache = $_POST["sprache"];
$name = $_POST["unterkunft_name"];
$art = $_POST["art"];
$ZIMMERART_EZ = $_POST["mietobjekt_ez"];
$ZIMMERART_MZ = $_POST["mietobjekt_mz"];
	
include_once("../include/uebersetzer.php");
	
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../templates/stylesheets.css" rel="stylesheet" type="text/css">
<title>Installation Rezervi</title
<!-- Bootstrap -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<!-- Bootstrap ende -->
</head>


<body class="backgroundColor" data-pinterest-extension-installed="cr1.39.1">
<div class="container" style="margin-top:70px;">	


  	<h2><?php 
	//sprache ist erst ab installation-schritt 3 verfügbar!
	if ($sprache == "en"){
		?>
		Installation of Rezervi availability overview and guest database
		<?php
	}
	else if ($sprache == "de"){
		?>
		Installation Rezervi Belegungsplan und Kundendatenbank
	<?php 
	}	
	?>
</h2>

	<div class="panel panel-default">
  <div class="panel-body">


<b><?php 
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
</b>
<?php
	//installation durchfuehren:
	//1. tabellen:
	include_once("installTables.php");
	setSessionWert(SPRACHE,$sprache);
?>
<p><?php 
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
	include_once("UKeintragen.php");
?>
<p><?php
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
<p><?php echo(getUebersetzung("Teil 3 abgeschlossen",$sprache,$link)); ?></p>

<?php if ($fehler == true) { ?><p class="belegt"><?php echo($antwort); ?></p><?php } ?>

<b><?php echo(getUebersetzung("So können sie Rezervi verlinken",$sprache,$link)); ?>:</b>
<ul>
  <li><?php echo(getUebersetzung("Die Startseite Ihres Belegungsplanes",$sprache,$link)); ?>: <br/>
    <?php echo(getUebersetzung("http://ihre-domain/ihrInstallationsverzeichnis/",$sprache,$link)); ?><a href="../start.php" target="_blank">start.php</a></li>
  <li ><?php echo(getUebersetzung("Dieser Seite können Sie auch die gewünschte Sprache übergeben",$sprache,$link)); ?>:<br/>
  <?php echo(getUebersetzung("http://ihre-domain/ihrInstallationsverzeichnis/",$sprache,$link)); ?><a href="../start.php?spracheNeu=de" target="_blank">start.php?spracheNeu=de</a><br/>
  <?php echo(getUebersetzung("http://ihre-domain/ihrInstallationsverzeichnis/",$sprache,$link)); ?><a href="../start.php?spracheNeu=en" target="_blank">start.php?spracheNeu=en</a><br/>
  <?php echo(getUebersetzung("http://ihre-domain/ihrInstallationsverzeichnis/",$sprache,$link)); ?><a href="../start.php?spracheNeu=fr" target="_blank">start.php?spracheNeu=fr</a></li>
  <li><?php echo(getUebersetzung("Sie können auch direkt die Suchfunktion aufrufen",$sprache,$link)); ?>:<br/>
  <?php echo(getUebersetzung("http://ihre-domain/ihrInstallationsverzeichnis/",$sprache,$link)); ?><a href="../suche/index.php" target="_blank">suche/index.php</a></li>
  <li><?php echo(getUebersetzung("Auch dieser Seite kann die gewünschte Sprache übergeben werden",$sprache,$link)); ?>: <br/>
  <?php echo(getUebersetzung("http://ihre-domain/ihrInstallationsverzeichnis/",$sprache,$link)); ?><a href="../suche/index.php?sprache=de" target="_blank">suche/index.php?sprache=de</a><br/>
  <?php echo(getUebersetzung("http://ihre-domain/ihrInstallationsverzeichnis/",$sprache,$link)); ?><a href="../suche/index.php?sprache=en" target="_blank">suche/index.php</a><a href="../suche/index.php" target="_blank">?sprache=en</a><br/>
  <?php echo(getUebersetzung("http://ihre-domain/ihrInstallationsverzeichnis/",$sprache,$link)); ?><a href="../suche/index.php?sprache=fr" target="_blank">suche/index.php</a><a href="../suche/index.php" target="_blank">?sprache=fr</a> </li>
  <li><?php echo(getUebersetzung("Den Zugang zur Webschnittstelle erhalten sie über",$sprache,$link)); ?>
  (<?php echo(getUebersetzung("Verwenden sie als Benutzername und Passwort \"test\" und ändern sie das Passwort nach erstmaligem Einstieg.",$sprache,$link)); ?>):<br/>
  <?php echo(getUebersetzung("http://ihre-domain/ihrInstallationsverzeichnis/",$sprache,$link)); ?><a href="../webinterface/index.php" target="_blank">webinterface/index.php</a></li>
</ul>
<p><?php echo(getUebersetzung("Nach erfolgreicher Installation sollten Sie den Ordner &quot;install&quot; auf Ihrem Webserver löschen, ansonsten kann durch einen Angriff von aussen Ihre Datenbank verändert werden",$sprache,$link)); ?>!</p>

<p><?php echo(getUebersetzung("Wir sind ihnen auch gerne bei Fragen zur Installation behilflich. Senden sie uns einfach ein E-Mail unter",$sprache,$link)); ?>:</p>
<p><a href="mailto:rezervi@utilo.eu">rezervi@utilo.eu</a></p>

<!-- webinterface öffnen -->
<form action="../webinterface/index.php" method="post" id="formLizenz" name="formLizenz" target="_self" onSubmit="return checkLicence();">
	<p class="standardSchrift"><?php echo(getUebersetzung("Bitte ändern sie nun ihre Einstellungen im Webinterface",$sprache,$link)); ?></p>
	<input name="Submit" type="submit" class="btn btn-primary" value="<?= getUebersetzung("Webinterface öffnen",$sprache,$link) ?>">
</form>
<!-- ende webinterface öffnen -->
</div>
</div>
</body>
</html>
