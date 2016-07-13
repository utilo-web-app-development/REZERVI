<?php $root="../..";

/**
	date: 3.4.06
	author: christian osterrieder utilo.net						
*/

	 if (!isset($nachricht)){
		 session_start();
		 
		 // Send modified header for session-problem of ie:
		 // @see http://de.php.net/session
		 header('P3P: CP="NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM"');
	 }
 
	 //datenbank öffnen:
 include_once($root."/conf/rdbmsConfig.inc.php");
 //conf file öffnen:
 include_once($root."/conf/conf.inc.php");
 include_once($root."/include/uebersetzer.inc.php");
 include_once($root."/include/sessionFunctions.inc.php");
 include_once($root."/include/cssFunctions.inc.php"); 
 include_once($root."/include/vermieterFunctions.inc.php"); 
 include_once($root."/include/mietobjektFunctions.inc.php");
 
//wurde die suche direkt aufgerufen?
if (isset($_GET["vermieter_id"])){
	$vermieter_id = $_GET["vermieter_id"];
}
else if (isset($_POST["vermieter_id"])){
	$vermieter_id = $_POST["vermieter_id"];	
}
else{
	$vermieter_id = 1;
}

 //ist die suchfunktion überhaupt aktiv?
 $sucheAktiv = getVermieterEigenschaftenWert(SUCHFUNKTION_AKTIV,$vermieter_id);
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
	$sprache = getVermieterEigenschaftenWert(STANDARDSPRACHE,$vermieter_id);
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
<title>Rezervi Generic Booking System - Rezervi Generic Buchungssystem - utilo.net</title>
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
    <td><p class="<?php echo STANDARD_SCHRIFT ?>">
        <?php echo getUebersetzung("Sie können den Belegungsplan" .
	 				"betrachten,<br/>indem Sie eine Auswahl treffen " .
	 				"und auf [Belegungsplan anzeigen] klicken...")
	 	?>
      </p>
    </td>
  </tr>
</table>
<form action="<?php echo $root ?>/start.php" method="post" name="form1" target="_self">
  <table border="0" class="<?php echo TABLE_STANDARD ?>">
    <tr>
      <td class="<?php echo STANDARD_SCHRIFT_BOLD ?>">
      	<?php echo getUebersetzung("Belegungsplan für:") ?>
      </td>
    </tr>
    <tr>
      <td><?php   //es sollte die liste auf keinen fall groesser als 10 werden:
			$selectSize = getAnzahlVorhandeneMietobjekte($vermieter_id);
		  		if ($selectSize > 10) { 
		  			$selectSize = 10; 
		  		} 
		  ?>
        <select name="mietobjekt_id" size="<?php echo $selectSize ?>" class="<?php echo STANDARD_SCHRIFT ?>">
            <?php 
			$res = getMietobjekte($vermieter_id);
			$zaehler = 0;
			while ($d = mysql_fetch_array($res)){ 
				$mietobjekt_ez = getMietobjekt_EZ($vermieter_id);
				$bezeichnung = getUebersetzungVermieter($mietobjekt_ez,$sprache,$vermieter_id);
				$bezeichnung .= " ".$d["BEZEICHNUNG"];
				?>
	          	<option value="<?php echo $d["MIETOBJEKT_ID"] ?>" <?php if ($zaehler++ == 0) { 
	          			echo("selected=\"selected\""); 
	          			} ?>><?php echo $bezeichnung ?>
	          	</option>
            <?php } //ende while mietobjekte
		    ?>
        </select>
      </td>
    </tr>
    <tr>
      <td><input type="submit" name="Submit" class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
       onMouseOut="this.className='<?php echo BUTTON ?>';" value="<?php echo(getUebersetzung("Belegungsplan anzeigen")); ?>">
      </td>
    </tr>
  </table>
</form>
<table border="0">
  <tr>
    <td><span class="<?php echo STANDARD_SCHRIFT ?>">
      <?php echo getUebersetzung("...oder eine automatische Suche durchführen, " .
      		"<br/>indem sie unterstehende Daten angeben und [Suche starten] klicken.") 
	  ?>
      </span></td>
  </tr>
</table>
<form action="./sucheDurchfuehren.php" method="post" name="suchen" target="_self" id="suchen">
  <table border="0" class="<?php echo TABLE_STANDARD ?>">
    <tr>
      <td><p class="<?php echo STANDARD_SCHRIFT_BOLD ?>">
			<?php include_once($root."/templates/datumVonDatumBis.inc.php"); ?>
          </p>
      </td>
    </tr>
    <tr>
      <td class="<?php echo STANDARD_SCHRIFT_BOLD ?>"><input name="sucheStarten" type="submit" class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
       	onMouseOut="this.className='<?php echo BUTTON ?>';" id="sucheStarten" value="<?php echo(getUebersetzung("Suche starten...")); ?>">
      </td>
    </tr>
  </table>
</form>
<?php
include_once($root."/templates/footer.inc.php");
?>