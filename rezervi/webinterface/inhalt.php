<?php session_start();
$root = "..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");	
//alle alten session_daten löschen:
destroyInactiveSessions();

	/* 
		reservierungsplan - utilo.eu
		author: christian osterrieder
		
		inhaltsverzeinis für die wartung des benutzers
		über diese seite wird das passwort und der benutzername geprüft,
		zur prüfung übergeben werden die variablen
		benutzername 
		passwort
	
		für die jeweiligen Rechten angepasstes Wartungsmenue

		Rechte:
		1 - Testversion
		2 - Zimmer bearbeiten, Unterkunftsdaten ändern
		3 - Design bearbeiten
		  - Benutzerdaten bearbeiten
		
	*/
	
	//variablen initialisieren:
	if (isset($_POST["ben"]) && isset($_POST["pass"])){
		$ben = $_POST["ben"];
		$pass = $_POST["pass"];
	}
	else {
		//aufruf kam innerhalb des webinterface:
		$ben = getSessionWert(BENUTZERNAME);
		$pass= getSessionWert(PASSWORT);
	}
	
	//passwortprüfung vornehmen:
	//datenbank öffnen:
	include_once("../conf/rdbmsConfig.php");
	//andere funktionen einbeziehen:
	include_once("../include/benutzerFunctions.php");
	include_once("../include/unterkunftFunctions.php");
	include_once("../include/zimmerFunctions.php");
	include_once("../include/uebersetzer.php");
	$benutzer_id = -1;
	if (isset($ben) && isset($pass)){
		$benutzer_id = checkPassword($ben,$pass,$link);
	}	
	if ($benutzer_id == -1){
		//passwortprüfung fehlgeschlagen, auf index-seite zurück:
		$fehlgeschlagen = true;
		include_once("./index.php");
		exit;
	}
	else{
		$benutzername = $ben; $passwort = $pass;
		setSessionWert(BENUTZERNAME,$benutzername);
		setSessionWert(PASSWORT,$passwort);
		
		//unterkunft-id holen:
		$unterkunft_id = getUnterkunftID($benutzer_id,$link);		
		setSessionWert(UNTERKUNFT_ID,$unterkunft_id);
		setSessionWert(BENUTZER_ID, $benutzer_id);
	}		
	
	//sprache auslesen:
	//entweder aus übergebener url oder aus session
	if (isset($_POST["sprache"]) && $_POST["sprache"] != ""){
		$sprache = $_POST["sprache"];
	 	setSessionWert(SPRACHE,$sprache);
	}
	else{
		$sprache = getSessionWert(SPRACHE);
	}

		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//unterkünfte sperren:
		// 4 = la vielle maison
		if ($unterkunft_id == -1){
			echo("Zugang gesperrt!");
			$fehlgeschlagen = true;
			include_once("./index.php");
		}
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		else{
			
		//benutzerrechte auslesen:
		$benutzerrechte = getUserRights($benutzer_id,$link);
		$anzahlVorhandenerZimmer = getAnzahlVorhandeneZimmer($unterkunft_id,$link);
		
?>
<?php include_once("./templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("./templates/headerB.php"); ?>
<?php include_once("./templates/bodyA.php"); ?>
<p class="standardSchriftBold"><?php echo(getUebersetzung("Benutzer",$sprache,$link)); ?>: <?php echo(getUserName($benutzer_id,$link)); ?></p>
<?php if ($anzahlVorhandenerZimmer < 1) { ?>
<?php } ?>
<table width="100%" border="0" cellspacing="3" cellpadding="0">
  <?php 
  //prüfen ob benutzer das recht hat den folgenden link auszuführen:
  if ($benutzerrechte >= 1 && $anzahlVorhandenerZimmer > 0) {
	?>
  <form action="./reservierung/index.php" method="post" name="resEingebenAendern" target="_self">    
    <tr>
      <td width="1"><input name="resEingebenAendern" type="submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" id="resEingebenAendern" value="<?php echo(getUebersetzung("Reservierungsplan bearbeiten",$sprache,$link)); ?>">
      </td>
      <td class="standardSchrift"><?php echo(getUebersetzung("Neue Reservierungen eingeben, Reservierungen bearbeiten oder löschen.",$sprache,$link)); ?></td>
    </tr>
  </form>
  <form action="./anfragenBearbeiten/index.php" method="post" name="resEingebenAendern" target="_self">
    <tr>
      <td>
        <input type="submit" name="Submit" value="<?php echo(getUebersetzung("Anfragen bearbeiten",$sprache,$link)); ?>" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';"></td>
      <td class="standardSchrift"><?php echo(getUebersetzung("Anfragen von Gästen als belegt bestätigen oder ablehnen",$sprache,$link)); ?>.</td>
    </tr>
  </form>
  <form action="./gaesteBearbeiten/index.php" method="post" name="gaesteBearbeiten" target="_self">
    <tr>
      <td>
        <input type="submit" name="Submit" value="<?php echo(getUebersetzung("Gäste bearbeiten",$sprache,$link)); ?>" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';"></td>
      <td class="standardSchrift"><?php echo(getUebersetzung("Gespeicherte Daten der Gäste bearbeiten oder abfragen (z. B. E-Mail-Adressen ausgeben)",$sprache,$link)); ?></td>
    </tr>
  </form>
  <?php
	 	} //ende benutzerrechte >= 1
	//prüfen ob benutzer das recht hat den folgenden link auszuführen:
		if ($benutzerrechte == 1) {
	?>
  <form name="benutzerdatenEingebenAendern" method="post" action="">
    <tr>
      <td width="1"><input name="Benutzerdatenbearbeiten" type="submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" id="Benutzerdatenbearbeiten" value="<?php echo(getUebersetzung("Benutzerdaten bearbeiten",$sprache,$link)); ?>"></td>
      <td class="standardSchrift"><?php echo(getUebersetzung("Neue Benutzer anlegen, ändern (z. B. Passwort) oder bestehende Benutzer löschen",$sprache,$link)); ?>.<strong><br/>
		<?php echo(getUebersetzung("Diese Funktion ist nur für Administratoren verfügbar",$sprache,$link)); ?>!</strong></td>
    </tr>
  </form>
  <?php
	 	}
		if ($benutzerrechte >= 2) {
	?>
  <form name="benutzerdatenEingebenAendern" method="post" action="./benutzerBearbeiten/index.php">
    <tr>
      <td width="1"><input name="Benutzerdatenbearbeiten" type="submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" id="Benutzerdatenbearbeiten" value="<?php echo(getUebersetzung("Benutzerdaten bearbeiten",$sprache,$link)); ?>"></td>
      <td class="standardSchrift"><?php echo(getUebersetzung("Neue Benutzer anlegen, ändern (z. B. Passwort) oder bestehende Benutzer löschen",$sprache,$link)); ?>.</td>
    </tr>
  </form>
  <?php
	 	}
	//prüfen ob benutzer das recht hat den folgenden link auszuführen:
		if ($benutzerrechte >= 2) {
	?>
  <form action="./zimmerBearbeiten/index.php" method="post" name="ZimmerBearbeiten" target="_self">
    <tr>
      <td width="1"><input name="ZimmerBearbeiten" type="submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" id="ZimmerBearbeiten" value="<?php echo(getUebersetzung("Zimmer bearbeiten",$sprache,$link)); ?>"></td>
      <td class="standardSchrift"><?php echo(getUebersetzung("Neue Zimmer/Appartements/Wohnung/etc. anlegen, löschen, oder bereits bestehende ändern",$sprache,$link)); ?>.</td>
    </tr>
  </form>
  <?php
	 	}
		else if($benutzerrechte == 1){		
			?>
  <form action="#" method="post" name="ZimmerBearbeiten" target="_self">
    <tr>
      <td width="1"><input name="ZimmerBearbeiten" type="button" class="button200pxA" onMouseOver="this.className='button200pxB';"
		   onMouseOut="this.className='button200pxA';" id="ZimmerBearbeiten" value="<?php echo(getUebersetzung("Zimmer bearbeiten",$sprache,$link)); ?>"></td>
      <td class="standardSchrift"><?php echo(getUebersetzung("Neue Zimmer/Appartements/Wohnung/etc. anlegen, löschen, oder bereits bestehende ändern",$sprache,$link)); ?>. <strong><br/>
        <?php echo(getUebersetzung("Diese Funktion ist nur für Administratoren verfügbar",$sprache,$link)); ?>!</strong></td>
    </tr>
  </form>
  <?php
	  }
	//prüfen ob benutzer das recht hat den folgenden link auszuführen:
		if ($benutzerrechte >= 2) {
	?>
  <form action="./unterkunftBearbeiten/index.php" method="post" name="UnterkunftBearbeiten" target="_self">
    <tr>
      <td><input name="UnterkunftBearbeiten" type="submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" id="UnterkunftBearbeiten" value="<?php echo(getUebersetzung("Unterkunft bearbeiten",$sprache,$link)); ?>"></td>
      <td class="standardSchrift"><?php echo(getUebersetzung("Daten Ihrer Unterkunft ändern (z. B. E-Mail-Adresse)",$sprache,$link)); ?></td>
    </tr>
  </form>
  <?php
	 	}
		else if ($benutzerrechte == 1) {
	?>
  <form action="#" method="post" name="UnterkunftBearbeiten" target="_self">
    <tr>
      <td><input name="UnterkunftBearbeiten" type="button" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" id="UnterkunftBearbeiten" value="<?php echo(getUebersetzung("Unterkunft bearbeiten",$sprache,$link)); ?>"></td>
      <td class="standardSchrift"><?php echo(getUebersetzung("Daten Ihrer Unterkunft ändern (z. B. E-Mail-Adresse)",$sprache,$link)); ?><strong><br/>
        <?php echo(getUebersetzung("Diese Funktion ist nur für Administratoren verfügbar",$sprache,$link)); ?>!</strong></td>
    </tr>
  </form>
  <?php
  }
  	//prüfen ob benutzer das recht hat den folgenden link auszuführen:
	if ($benutzerrechte >= 2) {
	?>
  <form action="./divEinstellungen/index.php" method="post" name="DiverseEinstellungen" target="_self">
    <tr>
      <td><input name="divEinstellungen" type="submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" id="divEinstellungen" value="<?php echo(getUebersetzung("Diverse Einstellungen",$sprache,$link)); ?>"></td>
      <td class="standardSchrift"><?php echo(getUebersetzung("Diverse Einstellungen von Rezervi ändern",$sprache,$link)); ?>.</td>
    </tr>
  </form>
  <?php
 	}
	else if ($benutzerrechte == 1) {
	?>
  <form action="#" method="post" name="DiverseEinstellungen" target="_self">
    <tr>
      <td><input name="divEinstellungen" type="button" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" id="divEinstellungen" value="<?php echo(getUebersetzung("diverse Einstellungen",$sprache,$link)); ?>"></td>
      <td class="standardSchrift"><?php echo(getUebersetzung("Diverse Einstellungen von Rezervi ändern",$sprache,$link)); ?>.<strong><br/>
        <?php echo(getUebersetzung("Diese Funktion ist nur für Administratoren verfügbar",$sprache,$link)); ?>!</strong></td>
    </tr>
  </form>
  <?php
  }
	//prüfen ob benutzer das recht hat den folgenden link auszuführen:
		if ($benutzerrechte >= 2) {
	?>
  <form name="designBearbeiten" method="post" action="../webinterface/designBearbeiten/index.php">
    <tr>
      <td width="1"><input name="designBearbeiten" type="submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" id="designBearbeiten2" value="<?php echo(getUebersetzung("Design bearbeiten",$sprache,$link)); ?>">
      </td>
      <td class="standardSchrift"><?php echo(getUebersetzung("Das Design Ihres persönlichen Reservierungsplanes ändern (z. B. Hintergrundfarbe)",$sprache,$link)); ?>.</td>
    </tr>
  </form>
  <?php
   	} //ende if benutzerrechte <= 2
	//prüfen ob benutzer das recht hat den folgenden link auszuführen:
	if ($benutzerrechte == 1) {
	?>
  <form name="designBearbeiten" method="post" action="">
    <tr>
      <td width="1"><input name="designBearbeiten" type="button" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" id="designBearbeiten2" value="<?php echo(getUebersetzung("Design bearbeiten",$sprache,$link)); ?>">
      </td>
      <td class="standardSchrift"><?php echo(getUebersetzung("Das Design Ihres persönlichen Reservierungsplanes ändern (z. B. Hintergrundfarbe)",$sprache,$link)); ?>.<strong><br/>
        <?php echo(getUebersetzung("Diese Funktion ist nur für Administratoren verfügbar",$sprache,$link)); ?>!</strong></td>
    </tr>
  <?php
  }
	//prüfen ob benutzer das recht hat den folgenden link auszuführen:
	if ($benutzerrechte >= 2) {
	?>
  <form name="antwortenBearbeiten" method="post" action="./autoResponse/index.php">
    <tr>
      <td><input name="antwortenBearbeiten" type="submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" id="designBearbeiten2" value="<?php echo(getUebersetzung("Automatische e-Mails",$sprache,$link)); ?>">
      </td>
      <td class="standardSchrift"><?php echo(getUebersetzung("Die automatischen E-Mail-Antworten an ihre Gäste ändern (z. B. Buchungsbestätigung) oder E-Mails an Ihre Gäste senden",$sprache,$link)); ?>.</td>
    </tr>
	  </form>
  <?php
   	} //ende if benutzerrechte <= 2
	//prüfen ob benutzer das recht hat den folgenden link auszuführen:
	if ($benutzerrechte == 1) {
	?>
  <form name="antwortenBearbeiten" method="post" action="">
    <tr>
      <td><input name="antwortenBearbeiten" type="button" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" id="designBearbeiten2" value="<?php echo(getUebersetzung("Automatische e-Mails",$sprache,$link)); ?>">
      </td>
      <td class="standardSchrift"><?php echo(getUebersetzung("Die automatischen E-Mail-Antworten an ihre Gäste ändern (z. B. Buchungsbestätigung) oder E-Mails an Ihre Gäste senden",$sprache,$link)); ?>.<strong><br/>
    <?php echo(getUebersetzung("Diese Funktion ist nur für Administratoren verfügbar",$sprache,$link)); ?>!</strong></td>
    </tr>
  </form>
  <?php
   	} //ende if benutzerrechte <= 2
	?>
  <tr>
    <td>&nbsp;</td>
    <td class="standardSchrift">&nbsp;</td>
  </tr>
  <form name="doku" target="_blank" method="post" action="http://www.rezervi.com/joomlaRezervi/index.php/rezervi-belegungsplan/dokumentation">
    <tr>
      <td width="1">
      		<input name="dokubut" type="submit" class="button200pxA" 
				onMouseOver="this.className='button200pxB';"
       			onMouseOut="this.className='button200pxA';" 
				value="<?php echo(getUebersetzung("Dokumentation",$sprache,$link)); ?>">
	  </td>
      <td class="standardSchrift">
      		<?php echo(getUebersetzung("Dokumentation des Webinterface und des Installationsvorgangs",$sprache,$link)); ?>.
	  </td>
    </tr>
  </form>	
  <tr>
    <td>&nbsp;</td>
    <td class="standardSchrift">&nbsp;</td>
  </tr>    
  <?php 
	 if ($benutzerrechte >=1) {
	 ?>
  <form name="abmelden" method="post" action="./abmelden.php">
    <tr>
      <td width="1"><input name="abmelden" type="submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" id="abmelden" value="<?php echo(getUebersetzung("Abmelden",$sprache,$link)); ?>"></td>
      <td class="standardSchrift"><?php echo(getUebersetzung("Hiermit beenden Sie Ihre Sitzung",$sprache,$link)); ?>.</td>
    </tr>
  </form>
  <?php
	}
	//prüfen ob benutzer das recht hat den folgenden link auszuführen:
	//	if ($benutzerrechte < 1000) {
	?>
</table>
</body>
</html>
<?php
	} //ende sperren unterk+ünfte
//} //ende passwortprüfung ok
?>
