<?php $root = "../../..";

/*   
	date: 26.9.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");
include_once($root."/include/filesAndFolders.inc.php");

//variablen initialisieren:
if (isset($_POST["suchergebnisseActive"])){
	$suchergebnisseActive = $_POST["suchergebnisseActive"];
}
else{
	$suchergebnisseActive = false;
}
if (isset($_POST["belegungsplanActive"])){
	$belegungsplanActive  = $_POST["belegungsplanActive"];
}
else{
	$belegungsplanActive = false;
}
$width = $_POST["width"];
$height  = $_POST["height"];

	//falls das upload-verzeichnis noch nicht vorhanden ist, muss es erzeugt werden:
	$path = $root."/upload";
	if (!hasDirectory($path)){
		if (!phpMkDir($path)){
			//file erzeugen war nicht erfolgreich
				$nachricht = "Das Upload Verzeichnis für die Bilder konnte nicht erstellt werden.";
				$nachricht = getUebersetzung($nachricht);
				$fehler = true;
				include_once("./index.php");
				exit;
		}
	}	

//sicherstellen, dass es sich um integer handelt:
$width = 1 + $width - 1;
$height = 1 + $height - 1;

	if ($width == "" || $height == "" || $height <=0 || $width <= 0){
		
		$nachricht = "Die Bildgrössen wurden nicht korrekt eingegeben.";
		$nachricht = getUebersetzung($nachricht);
		$fehler = true;
		include_once("./index.php");
		exit;
	
	}	
	
include_once($root."/webinterface/templates/bodyStart.inc.php"); 
include_once($root."/webinterface/templates/components.inc.php");
 

	if (isset($suchergebnisseActive) && $suchergebnisseActive == true){	
		setVermieterEigenschaftenWert(SUCHERGEBNISSE_BILDER_ACTIV,"true",$vermieter_id);
	}
	else{
		setVermieterEigenschaftenWert(SUCHERGEBNISSE_BILDER_ACTIV,"false",$vermieter_id);
	}
	
	if (isset($belegungsplanActive) && $belegungsplanActive == true){	
		setVermieterEigenschaftenWert(BELEGUNGSPLAN_BILDER_ACTIV,"true",$vermieter_id);
	}
	else{
		setVermieterEigenschaftenWert(BELEGUNGSPLAN_BILDER_ACTIV,"false",$vermieter_id);
	}
	
	setVermieterEigenschaftenWert(BILDER_WIDTH,$width,$vermieter_id);
	setVermieterEigenschaftenWert(BILDER_HEIGHT,$height,$vermieter_id);
		
?>
	<table  border="0" cellpadding="0" cellspacing="3" class="<?php echo FREI ?>">
	  <tr>
		<td><?php $nachricht = "Die Einstellungen der Bilder wurden erfolgreich geändert.";
				  $nachricht = getUebersetzung($nachricht);				
				  echo($nachricht) ?></td>
	  </tr>
	</table>
	<br/><br/>
<?php 
	  //-----buttons um zurück zum menue zu gelangen: 
	  showSubmitButtonWithForm("../index.php",getUebersetzung("zurück"));
	  
include_once($root."/webinterface/templates/footer.inc.php");
?>