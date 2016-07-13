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
	while ($s = mysql_fetch_array($spr)){
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
		while ($s = mysql_fetch_array($spr)){
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

	} else {
	   $nachricht = "Das Bild konnte nicht hochgeladen werden!";
	   $fehler = true;
	   include_once("./bilderHochladen.php");
	   exit;
	}	
			
?>

<?php include_once("../templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../templates/headerB.php"); ?>
<?php include_once("../templates/bodyA.php"); ?>

<?php //passwortprüfung:	
	if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){		
?>

<form action="./index.php" method="post" name="zimmerEintragen" target="_self" enctype="multipart/form-data">
  <table border="0" cellpadding="0" cellspacing="3" class="table">
    <tr class="table"> 
      <td colspan="2"><p class="standardSchriftBold"><?php echo(getUebersetzung("Bilder für Zimmer/Appartement/Wohnung/etc. hochladen",$sprache,$link)); ?><br/>
      </td>
    </tr>
    <tr> 
      <td height="30" colspan="2"><?php echo(getUebersetzung("Das Bild wurde erfolgreich hochladen",$sprache,$link)); ?>.</td>
    </tr>
    <tr class="table"> 
      <td colspan="2"><input name="zimmer_id" type="hidden" id="zimmer_id" value="<?php echo($zimmer_id); ?>">
        <input name="Submit" type="submit" id="Submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("zurück",$sprache,$link)); ?>"></td>
    </tr>
  </table>
</form>
<br/>
<?php 
	  //-----buttons um zurück zum menue zu gelangen: 
	  showSubmitButtonWithForm("../inhalt.php",getUebersetzung("Hauptmenü",$sprache,$link));
?>
<p></td> </tr> </table> </p>  
<?php 
	} //ende if passwortprüfung
	else {
		echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!",$sprache,$link));
	}
 ?>   
 <?php include_once("../templates/end.php"); ?>
