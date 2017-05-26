<?php session_start();
$root = "../../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
//variablen initialisieren:
$active = $_POST["active"];
$active2 = $_POST["active2"];
$width = $_POST["width"];
$height  = $_POST["height"];

$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$sprache = getSessionWert(SPRACHE);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);

//datenbank öffnen:
include_once("../../../conf/rdbmsConfig.php");
include_once("../../../include/propertiesFunctions.php");
include_once("../../../include/uebersetzer.php");
include_once("../../../include/benutzerFunctions.php");
include_once("../../../include/unterkunftFunctions.php");
include_once("../../../include/filesAndFolders.php");
include_once("../../templates/components.php");
include_once("../../templates/auth.php");

	if ($active == true){	
		setProperty(ZIMMER_THUMBS_ACTIV,"true",$unterkunft_id,$link);
	}
	else{
		setProperty(ZIMMER_THUMBS_ACTIV,"false",$unterkunft_id,$link);
	}
	if ($active2 == true){	
		setProperty(ZIMMER_THUMBS_AV_OV,"true",$unterkunft_id,$link);
	}
	else{
		setProperty(ZIMMER_THUMBS_AV_OV,"false",$unterkunft_id,$link);
	}	
	setProperty(BILDER_SUCHE_WIDTH,$width,$unterkunft_id,$link);
	setProperty(BILDER_SUCHE_HEIGHT,$height,$unterkunft_id,$link);
	
	$nachricht = "Die Einstellungen wurden erfolgreich geändert";
	$nachricht = getUebersetzung($nachricht,$sprache,$link);
	$nachricht.=".";
	$fehler = false;
	
	//falls das upload-verzeichnis noch nicht vorhanden ist, muss es erzeugt werden:
	$path = "../../../upload";
	if (!hasDirectory($path)){
		if (!phpMkDir($path)){
			//file erzeugen war nicht erfolgreich
				$nachricht = "Das Upload Verzeichnis konnte nicht erstellt werden";
				$nachricht = getUebersetzung($nachricht,$sprache,$link);
				$nachricht.=".";
				$fehler = false;
		}
	}

	include_once("index.php");

?>
