<?php session_start();
$root = "../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");

/*   
			reservierungsplan
			hochladen eines bilder fuer ein zimmer
			author: coster
			date: 18.8.05
*/

	//datenbank öffnen:
	include_once("../../conf/rdbmsConfig.php");
	
	//andere funktionen importieren:
	include_once("../../include/benutzerFunctions.php");
	include_once("../../include/unterkunftFunctions.php");
	include_once("../../include/uebersetzer.php");
	include_once("../../include/einstellungenFunctions.php");
	include_once("../../include/propertiesFunctions.php");
	include_once("../../include/zimmerFunctions.php");	
	include_once("../../include/bildFunctions.php");	
	include_once("../templates/components.php"); 
	//bild bearbeiten:
	require_once("../../include/imageResize/hft_image.php");

	//variablen intitialisieren:
	$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
	$benutzername = getSessionWert(BENUTZERNAME);
	$passwort = getSessionWert(PASSWORT);	
	$sprache = getSessionWert(SPRACHE);
	$standardsprache = getStandardSprache($unterkunft_id,$link);
	$fehler = false;
	
	//wurden die felder zimmer_id und bild ausgefüllt?	
	$zimmer_id = $_POST["zimmer_id"];
	if ($zimmer_id == ""){
		$nachricht = "Bitte wählen sie ein Zimmer!";
		$nachricht = getUebersetzung($nachricht,$sprache,$link);
		$fehler = true;
		include_once("./bilderHochladen.php");
		exit;
	}
	
	//check if the standard language was inserted:
	$spr = getSprachenForBelegungsplan($link);
	$standardLang = false;
	$anyDescription=false;
	$standardDescription = "";
	while ($s = mysqli_fetch_array($spr)){
		$lang = $s['Sprache_ID'];		
		if (isset($_POST["beschreibung_$lang"])){
			$besc = $_POST["beschreibung_$lang"];
			if (!empty($besc)){
				$anyDescription = true;
			}
			if ($lang == $standardsprache && !empty($besc)){
				$standardLang = true;
				$standardDescription = $besc;
				break;
			}
		}
	}
	if ($anyDescription && !$standardLang){
		$nachricht = "Bitte geben Sie die Beschreibung für Ihre Standardsprache ein!";
		$nachricht = getUebersetzung($nachricht,$sprache,$link);
		$fehler = true;
		include_once("./bilderHochladen.php");
		exit;
	}
	$bild = $_FILES['bild']['tmp_name'];
	if ($bild == ""){
		$nachricht = "Bitte wählen sie ein Bild!";
		$nachricht = getUebersetzung($nachricht,$sprache,$link);
		$fehler = true;
		include_once("./bilderHochladen.php");
		exit;
	}
	
	$uploaddir = "../../upload/";

	$mimeType = $_FILES['bild']['type'];
	$file_save_as = uniqid("utilo_") . getFileExtension($mimeType);

	//create the image from JPEG file
	$img = new hft_image($_FILES['bild']['tmp_name']);
	//keep X to Y ratio
	//so there will be no geometrical distortions:
	$bildXMax = getPropertyValue(BILDER_SUCHE_WIDTH,$unterkunft_id,$link);
	$bildYMax = getPropertyValue(BILDER_SUCHE_HEIGHT,$unterkunft_id,$link);
	$img->resize($bildXMax,$bildYMax,"-"); 
	
	//save the resized image to file
	//commented to save server load
	$img->output_resized($_FILES['bild']['tmp_name']);

	if (move_uploaded_file($_FILES['bild']['tmp_name'], $uploaddir . $file_save_as)) {
		chmod ($uploaddir . $file_save_as, 0755);

		//file-upload war erfolgreich:
		$id = setBild($uploaddir.$file_save_as,$standardDescription,$zimmer_id,$img->image_resized_width,$img->image_resized_height,$link);
		//set descriptions in other languages:
		$spr = getSprachenForBelegungsplan($link);
		while ($s = mysqli_fetch_array($spr)){
			$lang = $s['Sprache_ID'];		
			if (isset($_POST["beschreibung_$lang"])){
				$besc = $_POST["beschreibung_$lang"];
				if ($lang != $standardsprache && $besc != ""){
					setUebersetzungUnterkunft($besc,$standardDescription,$lang,$standardsprache,$unterkunft_id,$link);
				}
			}
		}		
		
		$nachricht = "Das Bild wurde erfolgreich hochgeladen.";
		$nachricht = getUebersetzung($nachricht,$sprache,$link);
		?>

        <form action="bilderHochladen.php" method="post" id="redirectForm">
            <input type="hidden" name="nachricht_alert" value="<?php echo $nachricht;?>">
            <input type="hidden" name="fehler_alert" value="false">
        </form>
<?php

//        header(
//            "Location: " . $URL . "webinterface/zimmerBearbeiten/bilderHochladen.php?nachricht_alert=$nachricht&fehler_alert=false"
//        ); /* Redirect browser */
//        exit();

	} else {

        $nachricht = "Das Bild konnte nicht hochgeladen werden!";
        $fehler = true;
        ?>
        <form action="bilderHochladen.php" method="post" id="redirectForm">
            <input type="hidden" name="nachricht_alert" value="<?php echo $nachricht;?>">
            <input type="hidden" name="fehler_alert" value="<?php echo $fehler; ?>">
        </form>
<!--        --><?php
//        header(
//            "Location: " . $URL . "webinterface/zimmerBearbeiten/bilderHochladen.php?nachricht_alert=$nachricht&fehler_alert=$fehler"
//        ); /* Redirect browser */
//        exit();


//	   include_once("./bilderHochladen.php");
//	   exit;
	}	
			
?>
<script>
    document.getElementById('redirectForm').submit();
</script>