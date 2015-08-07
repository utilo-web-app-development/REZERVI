<?php $root="../..";

/**
	date: 3.4.06
	author: christian osterrieder alpstein-austria						
*/

	 if (!isset($nachricht)){
		 session_start();
		 
		 // Send modified header for session-problem of ie:
		 // @see http://de.php.net/session
		 header('P3P: CP="NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM"');
	 }
 
	 //datenbank �ffnen:
 include_once($root."/include/rdbmsConfig.inc.php");
 //conf file �ffnen:
 include_once($root."/conf/conf.inc.php");
 include_once($root."/include/uebersetzer.inc.php");
 include_once($root."/include/sessionFunctions.inc.php");
 include_once($root."/include/cssFunctions.inc.php"); 
 include_once($root."/include/vermieterFunctions.inc.php"); 
 include_once($root."/include/mietobjektFunctions.inc.php");
 
//wurde die suche direkt aufgerufen?
if (isset($_GET["vermieter_id"])){
	$gastro_id = $_GET["vermieter_id"];
}
else if (isset($_POST["vermieter_id"])){
	$gastro_id = $_POST["vermieter_id"];	
}
else{
	$gastro_id = 1;
}

 //ist die suchfunktion �berhaupt aktiv?
 $sucheAktiv = getGastroProperty(SUCHFUNKTION_AKTIV,$gastro_id);
	if ($sucheAktiv == "true"){
		$sucheAktiv = true;
	}
	else{
		$nachricht = "";
		include_once($root."/start.php");
		exit;
	}

//sprache?
$temp = getSessionWert(SPRACHE);
if (isset($_GET["sprache"])){
	$sprache = $_GET["sprache"];	
}
else if (isset($_POST["sprache"])){
	$sprache = $_POST["sprache"];	
}
else if (!empty($temp)){
	$sprache = getSessionWert(SPRACHE);
}
else{
	$sprache = getGastroProperty(STANDARDSPRACHE,$gastro_id);
}
$temp = getSessionWert(SPRACHE);
if (empty($temp) && !empty($sprache)){
	setSessionWert(SPRACHE,$sprache);
}

//header einfuegen:
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Bookline Booking System - Bookline Buchungssystem - alpstein-austria</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
  <?php include_once($root."/templates/stylesheets.php"); ?>
</style>  
</head>
<?php
include_once($root."/templates/bodyStart.inc.php"); 
?>
<table border="0">
  <tr>
    <td><p class="<?= STANDARD_SCHRIFT ?>">
        <?= getUebersetzung("Sie k�nnen den Belegungsplan" .
	 				"betrachten,<br/>indem Sie eine Auswahl treffen " .
	 				"und auf [Belegungsplan anzeigen] klicken...")
	 	?>
      </p>
    </td>
  </tr>
</table>
<form action="<?= $root ?>/start.php" method="post" name="form1" target="_self">
  <table border="0" class="<?= TABLE_STANDARD ?>">
    <tr>
      <td class="<?= STANDARD_SCHRIFT_BOLD ?>">
      	<?= getUebersetzung("Belegungsplan f�r:") ?>
      </td>
    </tr>
    <tr>
      <td><?php   //es sollte die liste auf keinen fall groesser als 10 werden:
			$selectSize = getAnzahlVorhandeneRaeume($gastro_id);
		  		if ($selectSize > 10) { 
		  			$selectSize = 10; 
		  		} 
		  ?>
        <select name="mietobjekt_id" size="<?= $selectSize ?>" class="<?= STANDARD_SCHRIFT ?>">
            <?php 
			$res = getMietobjekte($gastro_id);
			$zaehler = 0;
			while ($d = $res->FetchNextObject()){ 
				$mietobjekt_ez = getMietobjekt_EZ($gastro_id);
				$bezeichnung = getUebersetzungGastro($mietobjekt_ez,$sprache,$gastro_id);
				$bezeichnung .= " ".$d->BEZEICHNUNG;
				?>
	          	<option value="<?= $d->MIETOBJEKT_ID ?>" <?php if ($zaehler++ == 0) { 
	          			echo("selected=\"selected\""); 
	          			} ?>><?= $bezeichnung ?>
	          	</option>
            <?php } //ende while mietobjekte
		    ?>
        </select>
      </td>
    </tr>
    <tr>
      <td><input type="submit" name="Submit" class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
       onMouseOut="this.className='<?= BUTTON ?>';" value="<?php echo(getUebersetzung("Belegungsplan anzeigen")); ?>">
      </td>
    </tr>
  </table>
</form>
<table border="0">
  <tr>
    <td><span class="<?= STANDARD_SCHRIFT ?>">
      <?= getUebersetzung("...oder eine automatische Suche durchf�hren, " .
      		"<br/>indem sie unterstehende Daten angeben und [Suche starten] klicken.") 
	  ?>
      </span></td>
  </tr>
</table>
<form action="./sucheDurchfuehren.php" method="post" name="suchen" target="_self" id="suchen">
  <table border="0" class="<?= TABLE_STANDARD ?>">
    <tr>
      <td><p class="<?= STANDARD_SCHRIFT_BOLD ?>">
			<?php include_once($root."/templates/datumVonDatumBis.inc.php"); ?>
          </p>
      </td>
    </tr>
    <tr>
      <td class="<?= STANDARD_SCHRIFT_BOLD ?>"><input name="sucheStarten" type="submit" class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
       	onMouseOut="this.className='<?= BUTTON ?>';" id="sucheStarten" value="<?php echo(getUebersetzung("Suche starten...")); ?>">
      </td>
    </tr>
  </table>
</form>
<?php
include_once($root."/templates/footer.inc.php");
?>