<?php
session_start();

$root = "..";

/* 
	author: coster
	date: 19.9.05
	
*/

//datenbank �ffnen:
include_once ($root."/conf/rdbmsConfig.inc.php");
//andere funktionen einbeziehen:
include_once ($root."/include/benutzerFunctions.inc.php");
include_once ($root."/include/vermieterFunctions.inc.php");
include_once ($root."/include/mietobjektFunctions.inc.php");
include_once ($root."/include/uebersetzer.inc.php");
include_once ($root."/include/sessionFunctions.inc.php");

//alte sessions l�schen:
destroyInactiveSessions();

$angemeldet = getSessionWert(ANGEMELDET);
if (isset($_POST["ben"])) {

	//variablen initialisieren:
	$ben = $_POST["ben"];
	$pass = $_POST["pass"];

	$benutzer_id = checkPassword($ben, $pass);

	if ($benutzer_id == -1) {
		//passwortpr�fung fehlgeschlagen, auf index-seite zur�ck:
		$fehlgeschlagen = true;
		include_once ("./index.php");
	} else {
		//passwortpr�fung erfolgreich:
		setSessionWert(ANGEMELDET, "true");

		//vermieter-id holen:
		$vermieter_id = getVermieterID($benutzer_id);
		setSessionWert(VERMIETER_ID, $vermieter_id);
		setSessionWert(BENUTZER_ID, $benutzer_id);
	}
}

//sprache auslesen:
//entweder aus �bergebener url oder aus session
if (isset ($_POST["sprache"]) && $_POST["sprache"] != "") {
	$sprache = $_POST["sprache"];
	setSessionWert(SPRACHE, $sprache);
} else {
	$sprache = getSessionWert(SPRACHE);	
}
if (empty($sprache)){
	$sprache = getVermieterEigenschaftenWert(STANDARDSPRACHE,$vermieter_id);
	setSessionWert(SPRACHE,$sprache);	
}

//benutzerrechte auslesen:
$benutzerrechte = getUserRights($benutzer_id);
$anzahlVorhandenerMietobjekte = getAnzahlVorhandeneMietobjekte($vermieter_id);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Rezervi Generic Webinterface</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
  <?php include_once($root."/templates/stylesheets.php"); ?>
</style>  
</head>
<body class="<?= BACKGROUND_COLOR ?>">
<p class="<?= UEBERSCHRIFT ?>"><?php echo(getUebersetzung(getVermieterFirmenName($vermieter_id))); ?></p>
<table border="0" cellpadding="0" cellspacing="3" class="<?= TABLE_STANDARD ?>">
  <tr>
    <td>
		<p class="<?= STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("Benutzer")); ?>: <?php echo(getUserName($benutzer_id)); ?></p>
		<table width="100%" border="0" cellspacing="3" cellpadding="0">
		<?php		
		//pr�fen ob benutzer das recht hat den folgenden link auszuf�hren:
		if ($benutzerrechte >= 1 && $anzahlVorhandenerMietobjekte > 0) {
		?>
		  <form action="./reservierung/index.php" method="post" name="resEingebenAendern" target="_self">    
		    <tr>
		      <td width="1"><input name="resEingebenAendern" type="submit" class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
		       onMouseOut="this.className='<?= BUTTON ?>';" id="resEingebenAendern" value="<?php echo(getUebersetzung("Belegungsplan bearbeiten")); ?>">
		      </td>
		      <td class="<?= STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("Neue Reservierungen eingeben, Reservierungen bearbeiten oder löschen.")); ?></td>
		    </tr>
		  </form>
		  <form action="./anfragenBearbeiten/index.php" method="post" name="resEingebenAendern" target="_self">
		    <tr>
		      <td>
		        <input type="submit" name="Submit" value="<?php echo(getUebersetzung("Anfragen bearbeiten")); ?>" class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
		       onMouseOut="this.className='<?= BUTTON ?>';"></td>
		      <td class="<?= STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("Anfragen als belegt bestätigen oder ablehnen")); ?>.</td>
		    </tr>
		  </form>
		  <form action="./mieterBearbeiten/index.php" method="post" name="mieterBearbeiten" target="_self">
		    <tr>
		      <td>
		        <input type="submit" name="Submit" value="<?php echo(getUebersetzung("Mieter bearbeiten")); ?>" class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
		       onMouseOut="this.className='<?= BUTTON ?>';"></td>
		      <td class="<?= STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("Gespeicherte Daten ihrer Mieter bearbeiten oder abfragen (z. B. E-Mail-Adressen ausgeben)")); ?></td>
		    </tr>
		  </form>
		  <?php		
		} //ende benutzerrechte >= 1
		//pr�fen ob benutzer das recht hat den folgenden link auszuf�hren:
		if ($benutzerrechte == 1) {
		?>
		  
		    <tr>
		      <td width="1"><input name="Benutzerdatenbearbeiten" type="submit" class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
		       onMouseOut="this.className='<?= BUTTON ?>';" id="Benutzerdatenbearbeiten" value="<?php echo(getUebersetzung("Benutzerdaten bearbeiten")); ?>"></td>
		      <td class="<?= STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("Neue Benutzer anlegen, ändern (z. B. Passwort) oder bestehende Benutzer löschen")); ?>.<strong><br/>
				<?php echo(getUebersetzung("Diese Funktion ist nur für Administratoren verfügbar")); ?>!</strong></td>
		    </tr>
		 
		  <?php
		
		}
		if ($benutzerrechte >= 2) {
		?>
		  <form name="benutzerdatenEingebenAendern" method="post" action="./benutzerBearbeiten/index.php">
		    <tr>
		      <td width="1"><input name="Benutzerdatenbearbeiten" type="submit" class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
		       onMouseOut="this.className='<?= BUTTON ?>';" id="Benutzerdatenbearbeiten" value="<?php echo(getUebersetzung("Benutzerdaten bearbeiten")); ?>"></td>
		      <td class="<?= STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("Neue Benutzer anlegen, ändern (z. B. Passwort) oder bestehende Benutzer löschen")); ?>.</td>
		    </tr>
		  </form>
		  <?php
		
		}
		//pr�fen ob benutzer das recht hat den folgenden link auszuf�hren:
		if ($benutzerrechte >= 2) {
		?>
		  <form action="./mietobjektBearbeiten/index.php" method="post" name="ZimmerBearbeiten" target="_self">
		    <tr>
		      <td width="1"><input name="ZimmerBearbeiten" type="submit" class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
		       onMouseOut="this.className='<?= BUTTON ?>';" id="ZimmerBearbeiten" value="<?php echo(getUebersetzung("Mietobjekt bearbeiten")); ?>"></td>
		      <td class="<?= STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("Neue Mietobjekte anlegen, löschen, oder bereits bestehende ändern")); ?>.</td>
		    </tr>
		  </form>
		  <?php		
		} else
		if ($benutzerrechte == 1) {
		?>
		  
		    <tr>
		      <td width="1"><input name="ZimmerBearbeiten" type="button" class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
				   onMouseOut="this.className='<?= BUTTON ?>';" id="ZimmerBearbeiten" value="<?php echo(getUebersetzung("Mietobjekt bearbeiten")); ?>"></td>
		      <td class="<?= STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("Neue Mietobjekte anlegen, löschen, oder bereits bestehende ändern")); ?>. <strong><br/>
		        <?php echo(getUebersetzung("Diese Funktion ist nur fü�r Administratoren verfügbar")); ?>!</strong></td>
		    </tr>
		  
		  <?php		
			}
		//pr�fen ob benutzer das recht hat den folgenden link auszuf�hren:
		if ($benutzerrechte >= 2) {
		?>
		  <form action="./vermieter/index.php" method="post" name="UnterkunftBearbeiten" target="_self">
		    <tr>
		      <td><input name="UnterkunftBearbeiten" type="submit" class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
		       onMouseOut="this.className='<?= BUTTON ?>';" id="UnterkunftBearbeiten" value="<?php echo(getUebersetzung("Stammdaten bearbeiten")); ?>"></td>
		      <td class="<?= STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("Daten Ihrer Firma ändern (z. B. E-Mail-Adresse)")); ?></td>
		    </tr>
		  </form>
		  <?php		
		} else
			if ($benutzerrechte == 1) {
		?>
		
		    <tr>
		      <td><input name="UnterkunftBearbeiten" type="button" class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
		       onMouseOut="this.className='<?= BUTTON ?>';" id="UnterkunftBearbeiten" value="<?php echo(getUebersetzung("Stammdaten bearbeiten")); ?>"></td>
		      <td class="<?= STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("Daten Ihrer Firma ändern (z. B. E-Mail-Adresse)")); ?><strong><br/>
		        <?php echo(getUebersetzung("Diese Funktion ist nur für Administratoren verfügbar")); ?>!</strong></td>
		    </tr>
		 
		  <?php		
			}
		//pr�fen ob benutzer das recht hat den folgenden link auszuf�hren:
		if ($benutzerrechte >= 2) {
		?>
		  <form action="./divEinstellungen/index.php" method="post" name="DiverseEinstellungen" target="_self">
		    <tr>
		      <td><input name="divEinstellungen" type="submit" class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
		       onMouseOut="this.className='<?= BUTTON ?>';" id="divEinstellungen" value="<?php echo(getUebersetzung("Diverse Einstellungen")); ?>"></td>
		      <td class="<?= STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("Diverse Einstellungen von Rezervi ändern")); ?>.</td>
		    </tr>
		  </form>
		  <?php		
		} else
			if ($benutzerrechte == 1) {
		?>
		  
		    <tr>
		      <td><input name="divEinstellungen" type="button" class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
		       onMouseOut="this.className='<?= BUTTON ?>';" id="divEinstellungen" value="<?php echo(getUebersetzung("diverse Einstellungen")); ?>"></td>
		      <td class="<?= STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("Diverse Einstellungen von Rezervi ändern")); ?>.<strong><br/>
		        <?php echo(getUebersetzung("Diese Funktion ist nur für Administratoren verfügbar")); ?>!</strong></td>
		    </tr>
		  
		  <?php		
			}
		//pr�fen ob benutzer das recht hat den folgenden link auszuf�hren:
		if ($benutzerrechte >= 2) {
		?>
		  <form name="designBearbeiten" method="post" action="../webinterface/designBearbeiten/index.php">
		    <tr>
		      <td width="1"><input name="designBearbeiten" type="submit" class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
		       onMouseOut="this.className='<?= BUTTON ?>';" id="designBearbeiten2" value="<?php echo(getUebersetzung("Design bearbeiten")); ?>">
		      </td>
		      <td class="<?= STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("Das Design Ihres persönlichen Belegungsplanes ändern (z. B. Hintergrundfarbe)")); ?>.</td>
		    </tr>
		  </form>
		  <?php		
		} //ende if benutzerrechte <= 2
		//pr�fen ob benutzer das recht hat den folgenden link auszuf�hren:
		if ($benutzerrechte == 1) {
		?>
		  
		    <tr>
		      <td width="1"><input name="designBearbeiten" type="button" class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
		       onMouseOut="this.className='<?= BUTTON ?>';" id="designBearbeiten2" value="<?php echo(getUebersetzung("Design bearbeiten")); ?>">
		      </td>
		      <td class="<?= STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("Das Design Ihres pers�nlichen Belegungsplanes ändern (z. B. Hintergrundfarbe)")); ?>.<strong><br/>
		        <?php echo(getUebersetzung("Diese Funktion ist nur für Administratoren verfügbar")); ?>!</strong></td>
		    </tr>
		  <?php		
		}
		//pr�fen ob benutzer das recht hat den folgenden link auszuf�hren:
		if ($benutzerrechte >= 2) {
		?>
		  <form name="antwortenBearbeiten" method="post" action="./autoResponse/index.php">
		    <tr>
		      <td><input name="antwortenBearbeiten" type="submit" class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
		       onMouseOut="this.className='<?= BUTTON ?>';" id="designBearbeiten2" value="<?php echo(getUebersetzung("Automatische e-Mails")); ?>">
		      </td>
		      <td class="<?= STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("Die automatischen E-Mail-Antworten an ihre Mieter ändern (z. B. Buchungsbestätigung) oder E-Mails an Ihre Mieter senden")); ?>.</td>
		    </tr>
			  </form>
		  <?php		
		} //ende if benutzerrechte <= 2
		//pr�fen ob benutzer das recht hat den folgenden link auszuf�hren:
		if ($benutzerrechte == 1) {
		?>
		  
		    <tr>
		      <td><input name="antwortenBearbeiten" type="button" class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
		       onMouseOut="this.className='<?= BUTTON ?>';" id="designBearbeiten2" value="<?php echo(getUebersetzung("Automatische e-Mails")); ?>">
		      </td>
		      <td class="<?= STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("Die automatischen E-Mail-Antworten an ihre Mieter ändern (z. B. Buchungsbestätigung) oder E-Mails an Ihre Mieter senden")); ?>.<strong><br/>
		    <?php echo(getUebersetzung("Diese Funktion ist nur für Administratoren verfügbar")); ?>!</strong></td>
		    </tr>
		  
		  <?php		
		} //ende if benutzerrechte <= 2
		?>
		  <tr>
		    <td>&nbsp;</td>
		    <td class="<?= STANDARD_SCHRIFT ?>">&nbsp;</td>
		  </tr>
		  <?php		
		if ($benutzerrechte >= 1) {
		?>
		  <form name="abmelden" method="post" action="./abmelden.php">
		    <tr>
		      <td width="1"><input name="abmelden" type="submit" class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
		       onMouseOut="this.className='<?= BUTTON ?>';" id="abmelden" value="<?php echo(getUebersetzung("Abmelden")); ?>"></td>
		      <td class="<?= STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("Hiermit beenden Sie Ihre Sitzung")); ?>.</td>
		    </tr>
		  </form>
		  <?php		
		}
		?>
		</td>
   </tr>
</table>
</body>
</html>
<?php
include_once ($root."/include/closeDB.inc.php");
?>