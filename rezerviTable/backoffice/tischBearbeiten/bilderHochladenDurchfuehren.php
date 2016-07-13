<?php 
$root = "../..";
$ueberschrift = "Tisch bearbeiten";

/*   
	date: 4.10.05
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/include/filesAndFolders.inc.php"); 
include_once($root."/include/bildFunctions.inc.php"); 
include_once($root."/backoffice/templates/components.inc.php"); 
include_once($root."/templates/constants.inc.php"); 

	//bild bearbeiten:
	require_once($root."/include/imageResize/hft_image.php");

	//variablen intitialisieren:
	$fehler = false;
	
	//wurden die felder mietobjekt_id und bild ausgef�llt?	
	$mietobjekt_id = $_POST["mietobjekt_id"];
	if ($mietobjekt_id == ""){
		$nachricht = "Bitte w�hlen sie ein Mietobjekt aus!";
		$nachricht = getUebersetzung($nachricht);
		$fehler = true;
		include_once("./bilderHochladen.php");
		exit;
	}
	$bild = $_FILES['bild']['tmp_name'];
	if ($bild == ""){
		$nachricht = "Bitte w�hlen sie ein Bild!";
		$nachricht = getUebersetzung($nachricht);
		$fehler = true;
		include_once("./bilderHochladen.php");
		exit;
	}
	
	$mimeType = $_FILES['bild']['type'];
	$fileExtension = getFileExtension($mimeType);
	if (!($fileExtension == ".png" || $fileExtension == ".gif" || $fileExtension == ".jpg")){
		$nachricht = "Sie k�nnen nur .png, .gif oder .jpg hochladen.".$fileExtension;
		$nachricht = getUebersetzung($nachricht);
		$fehler = true;
		include_once("./bilderHochladen.php");
		exit;
	}
	
	$maxHoehe  = $_POST["maxHoehe"];
	$maxBreite = $_POST["maxBreite"];
	//sicherstellen, dass es sich um integer handelt:
	$maxBreite = 1 + $maxBreite - 1;
	$maxHoehe = 1 + $maxHoehe - 1;

	if ($maxBreite == "" || $maxHoehe == "" || $maxBreite <=0 || $maxHoehe <= 0){
		
		$nachricht = "Die maximalen Bildgr�ssen wurden nicht korrekt eingegeben.";
		$nachricht = getUebersetzung($nachricht);
		$fehler = true;
		include_once("./bilderHochladen.php");
		exit;
	
	}	

	$beschreibung = $_POST["beschreibung"];

	//create the image from JPEG file
	$img = new hft_image($_FILES['bild']['tmp_name']);
	//keep X to Y ratio
	//so there will be no geometrical distortions:
	$img->resize($maxBreite,$maxHoehe,"-"); 
	
	//save the resized image to file
	//commented to save server load
	$img->output_resized($_FILES['bild']['tmp_name']);

	//file als blob einlesen:
	
		//file-upload war erfolgreich:
		$pfad = $_FILES['bild']['tmp_name'];
		$id = setBild($pfad,$beschreibung,$mietobjekt_id,$img->image_resized_width,$img->image_resized_height,$fileExtension);
		$nachricht = "Das Bild wurde erfolgreich hochgeladen.";
		$nachricht = getUebersetzung($nachricht);

			
include_once($root."/backoffice/templates/bodyStart.inc.php"); 
	
?>

<form action="./index.php" method="post" name="bilderHochladen" 
	target="_self">
  <table border="0" cellpadding="0" cellspacing="3" class="<?php echo FREI ?>">
    <tr> 
      <td height="30"><?php echo(getUebersetzung("Das Bild wurde erfolgreich hochladen")); ?>.</td>
    </tr>
  </table>
  <br/>
    <table border="0" cellpadding="0" cellspacing="3">
    <tr> 
      <td>
        <input name="Submit" type="submit" id="Submit" class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
       onMouseOut="this.className='<?php echo BUTTON ?>';" value="<?php echo(getUebersetzung("zurück")); ?>"></td>
    </tr>
  </table>
</form>
<?php	  
include_once($root."/backoffice/templates/footer.inc.php");
?>
