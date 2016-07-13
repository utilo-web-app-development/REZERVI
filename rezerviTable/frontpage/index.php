<?php  
/**
	@date 10.10.06
	@author christian osterrieder utilo.net		
	Frontpage Einstiegsseite - Ansicht Raum				
*/
	 if (!isset($nachricht)){
		 session_start();
		 $root = "..";
		 
		 // Send modified header for session-problem of ie:
		 // @see http://de.php.net/session
		 header('P3P: CP="NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM"');
	 }
 
	 //datenbank öffnen:
 include_once($root."/include/rdbmsConfig.inc.php");
 //conf file �ffnen:
 include_once($root."/conf/conf.inc.php");
 //uebersetzer öffnen:
 include_once($root."/include/uebersetzer.inc.php");
 include_once($root."/include/sessionFunctions.inc.php");
 include_once($root."/include/cssFunctions.inc.php"); 
 include_once($root."/include/vermieterFunctions.inc.php"); 
 include_once($root."/include/mietobjektFunctions.inc.php");
 include_once($root."/include/datumFunctions.inc.php");
 include_once($root."/include/reservierungFunctions.inc.php");
 include_once($root."/templates/constants.inc.php");
	
//als erstes pruefen ob per get oder post diverse variablen uebergeben wurden
//vermieter?
if (isset($_GET["gastro_id"])){
	$gastro_id = $_GET["gastro_id"];
}
else if (isset($_POST["gastro_id"])){
	$gastro_id = $_POST["gastro_id"];	
}
else{
	$gastro_id = 1;
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
//mietobjekt?
if (isset($_GET["raum_id"])){
	$raum_id = $_GET["raum_id"];
}
else if (isset($_POST["raum_id"])){
	$raum_id = $_POST["raum_id"];	
}
else{
	$raum_id = getFirstRaumId($gastro_id);	
}
//alte session werte löschen:
destroyInactiveSessions();
//werte in session speichern:
setSessionWert(GASTRO_ID,$gastro_id);
setSessionWert(SPRACHE,$sprache);

//header einfuegen:
?>
<!DOCTYPE html">
<html>
<head>
<title>Bookline Booking System - Bookline Buchungssystem - alpstein-austria</title>
<meta http-equiv="Content-Type" content="text/html; ">
<meta charset="UTF-8">
<style type="text/css">
  <?php include_once($root."/templates/stylesheets.php"); ?>
</style>  
</head>
<?php
include_once($root."/templates/bodyStart.inc.php"); 
	
	//falls kein jahr ausgewählt wurde, das aktuelle jahr verwenden:
	if (isset($_POST["datumAnsicht"])){
		$jahr = getJahrFromDatePicker($_POST["datumAnsicht"]);
	}
	else if (isset($_POST["jahr"])){
		$jahr = $_POST["jahr"];
	}
	else{
		$jahr = getTodayYear();
	}
	
	if (isset($_POST["minute"])){
		$minute = $_POST["minute"];
	}
	else{
		$minute = getTodayMinute();
	}
	
	if (isset($_POST["stunde"])){
		$stunde = $_POST["stunde"];
	}
	else{
		$stunde = getTodayStunde();
	}
	
	if (isset($_POST["datumAnsicht"])){
		$monat = getMonatFromDatePicker($_POST["datumAnsicht"]);
	}
	else if (isset($_POST["monat"])){
		$monat = $_POST["monat"];
	}	
	else{
		$monat = getTodayMonth();
	}	
	
	if (isset($_POST["datumAnsicht"])){
		$tag = getTagFromDatePicker($_POST["datumAnsicht"]);
	}
	else if (isset($_POST["tag"])){
		$tag = $_POST["tag"];
	}	
	else{
		$tag = getTodayDay();
	}
	
	$startdatumDP = $tag."/".$monat."/".$jahr;
	
	//anzahl der minimalen und maximalen personenanzahl f�r diesen raum:
	$anzahlMinPersonen = getMinimaleBelegungOfRaum($raum_id);
	$anzahlMaxPersonen = getMaximaleBelegungOfRaum($raum_id);
		
?>
<script language="JavaScript" type="text/javascript" src="./leftJS.js">
</script>
<table cellpadding="3">
  <tr>
	<td valign="top">
	<!-- linke seite - navigation: -->	
		<!-- begin auswahl datum und uhrzeit -->
	  	<form action="<?= $root ?>/belegungsplan/anfrage/index.php" method="post" name="resAendern">
		  <input type="hidden" name="raum_id" value="<?= $raum_id ?>"/>
		  <table border="0" class="<?= TABLE_STANDARD ?>">	  
			<?php 
				include_once($root."/templates/datumVonDatumBis.inc.php"); 
			 ?>			        
		  <!-- end auswahl datum und uhrzeit -->
		  <!-- begin auswahl anzahl der personen -->
			  <tr>
			    <td>&nbsp;</td>
			    <td>
		   		  <label>
			   		  <select name="select">
					  	<?php
							for ($i = $anzahlMinPersonen; $i<$anzahlMaxPersonen; $i++){
						?>
							<option value="<?= $i ?>"><?= $i ?></option>
						<?php
						} //ende schleife anzahl personen
						?>
	   		      	  </select><?= getUebersetzung("Personen") ?>
		   		  </label>
				 </td>
			  </tr>					  
			  <tr>
			    <td colspan="2">
			          <input name="reservierungAendern" type="submit" class="<?= BUTTON ?>" 
			          	 onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
			      		 onMouseOut="this.className='<?= BUTTON ?>';" id="reservierungAbsenden2" 
			      		 value="<?= getUebersetzung("Tischreservierung starten") ?>"/>			        
			     </td>
			  </tr>
			</table>
		  </form>
		  <!-- end auswahl anzahl der personen -->
		  <!-- begin Anfrage per Mail --> 
		  <form action="<?= $root ?>/belegungsplan/anfrage/anfragePerEMail.php" method="post" name="suche">
			  <table border="0" class="<?= TABLE_STANDARD ?>">
			    <tr>
				    <td>		      
				        <div align="center">
				          <input name="suche" type="submit" id="suche" 
				          	value="<?php echo(getUebersetzung("Anfrage per E-Mail")); ?>" 
				          	class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
						    onMouseOut="this.className='<?= BUTTON ?>';">
				          <input name="jahr" type="hidden" id="jahr" value="<?= $jahr ?>"/>
				          <input name="monat" type="hidden" id="monat" value="<?= $monat ?>"/>	
				          <input name="tag" type="hidden" id="monat" value="<?= $tag ?>"/>
				          <input name="raum_id" type="hidden" id="raum_id" value="<?= $raum_id ?>"/>	  
				        </div>		     
				     </td>
				  </tr>
				</table>
			</form>
		  <!-- ende Anfrage per Mail -->		
		<!-- ende linke seite - menue -->
		</td>
		<td valign="top">
		<!-- rechte seite - plan -->
		<?php
			include_once($root."/frontpage/raeume/index.php");
		?>
		<!-- ende rechte seite plan -->
		</td>
	</tr>
</table>
<?php
include_once($root."/templates/footer.inc.php");
?>
