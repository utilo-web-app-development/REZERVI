<?php 
session_start();
$root = "../../..";
$ueberschrift = "Tischkarten bearbeiten";

/*   
	date: 26.9.05
	author: christian osterrieder alpstein-austria
	save or preview of a table card						
*/

	
if ( isset( $_POST['tableCardId'] ) ) {

	//function to generate a table card:
	include_once($root.'/include/tischkartenFunctions.inc.php');
	include_once($root."/include/rdbmsConfig.inc.php");
	include_once($root."/include/vermieterFunctions.inc.php");
	include_once($root."/include/sessionFunctions.inc.php");
	include_once($root."/include/uebersetzer.inc.php");
	include_once($root."/include/bildFunctions.inc.php");
	//bild bearbeiten:
	require_once($root."/include/imageResize/hft_image.php");
	
	$sprache = getSessionWert(SPRACHE);
	$gastro_id = getSessionWert(GASTRO_ID);
	$tableCardId = $_POST['tableCardId'];
	
	if (isset($_FILES['bild']['tmp_name'])){
		$bild = $_FILES['bild']['tmp_name'];
		$mimeType = $_FILES['bild']['type'];
		$fileExtension = getFileExtension($mimeType);	
		if (!($fileExtension == ".png" || $fileExtension == ".jpg")){
			$nachricht = "Sie können nur .png oder .jpg hochladen. Sie versuchten ".$fileExtension." hochzuladen.";
			$nachricht = getUebersetzung($nachricht);
			$fehler = true;
			include_once("./index.php");
			exit;
		}
	}		
		
	//add constans to db	
	if(getTableCardProperty("TC_PAGE_ORIENTATION",$tableCardId) == FALSE){
		setTableCardProperty("TC_PAGE_ORIENTATION",'TC_PAGE_ORIENTATION',$tableCardId);
		setTableCardProperty("TC_PORTRAIT",'TC_PORTRAIT',$tableCardId);
		setTableCardProperty("TC_LANDSCAPE",'TC_LANDSCAPE',$tableCardId);
		setTableCardProperty("TC_MEASURE_UNIT",'TC_MEASURE_UNIT',$tableCardId);
		setTableCardProperty("TC_MILLIMETER",'TC_MILLIMETER',$tableCardId);
		setTableCardProperty("TC_CENTIMETER",'TC_CENTIMETER',$tableCardId);
		setTableCardProperty("TC_DIMENSION",'TC_DIMENSION',$tableCardId);
		setTableCardProperty("TC_A4",'TC_A4',$tableCardId);
		setTableCardProperty("TC_A5",'TC_A5',$tableCardId);
		setTableCardProperty("TC_CUSTOM_FORMAT_X",'TC_CUSTOM_FORMAT_X',$tableCardId);
		setTableCardProperty("TC_CUSTOM_FORMAT_Y",'TC_CUSTOM_FORMAT_Y',$tableCardId);
		setTableCardProperty("font_heading",'font_heading',$tableCardId);
		setTableCardProperty("TC_FONT_TEXT",'TC_FONT_TEXT',$tableCardId);
		setTableCardProperty("TC_FONT_COURIER",'TC_FONT_COURIER',$tableCardId);
		setTableCardProperty("TC_FONT_ARIAL",'TC_FONT_ARIAL',$tableCardId);
		setTableCardProperty("TC_FONT_TIMES",'TC_FONT_TIMES',$tableCardId);
	}
	
	$x = $_POST['x'];
	$y = $_POST['y'];
	setTableCardProperty(TC_DIMENSION,TC_CUSTOM_FORMAT,$tableCardId);
	setTableCardProperty(TC_CUSTOM_FORMAT_X,$x,$tableCardId);
	setTableCardProperty(TC_CUSTOM_FORMAT_Y,$y,$tableCardId);	
	$fontHeading = $_POST['font_heading'];
	setTableCardProperty(TC_FONT_HEADING,$fontHeading,$tableCardId);
	
	$fontText = $_POST['font_text'];
	setTableCardProperty(TC_FONT_TEXT,$fontText,$tableCardId);
	
	$fontTextStyle = TC_FONT_STYLE_NORMAL;
	foreach($available_font_styles as $key => $value){ 
		if (isset($_POST['font_text_'.$value])){			
			$fontTextStyle.=$_POST['font_text_'.$value];
		}
	}

	//remove normal style if other exists:
	if (strlen($fontTextStyle)>1){
		$fontTextStyle = substr($fontTextStyle, 1);
	}	
	setTableCardProperty(TC_FONT_TEXT_STYLE,$fontTextStyle,$tableCardId);
	
	$fontHeadingStyle = TC_FONT_STYLE_NORMAL;
	foreach($available_font_styles as $key => $value){ 
		if (isset($_POST['font_heading_'.$value])){			
			$fontHeadingStyle.=$_POST['font_heading_'.$value];
		}
	}
	//remove normal style if other exists:
	if (strlen($fontHeadingStyle)>1){
		$fontHeadingStyle = substr($fontHeadingStyle, 1);
	}
	setTableCardProperty(TC_FONT_HEADING_STYLE,$fontHeadingStyle,$tableCardId);

	$fontHeadingSize = $_POST['font_size_heading'];
	setTableCardProperty(TC_FONT_HEADING_SIZE,$fontHeadingSize,$tableCardId);
	$fontTextSize    = $_POST['font_size_text'];
	setTableCardProperty(TC_FONT_TEXT_SIZE,$fontTextSize,$tableCardId);
	
	$headingText	 = $_POST['textHeading'];
	setTableCardProperty(TC_HEADING_TEXT,$headingText,$tableCardId);
	
	if (isset($_POST['show_name']) && $_POST['show_name'] == "true"){
		$showName = "true";
	}
	else{
		$showName = "false";
	}
	setTableCardProperty(TC_TEXT_SHOW_NAME,$showName,$tableCardId);
	
	if (isset($_POST['show_time']) && $_POST['show_time'] == "true"){
		$showTime = "true";
	}
	else{
		$showTime = "false";
	}
	setTableCardProperty(TC_TEXT_SHOW_TIME,$showTime,$tableCardId);
	
	//save the pic:
	if (isset($bild)){
	
		//alte bild id:
		$r = getTableCard($tableCardId);
		$bild_id = $r->fields("BILDER_ID");	
		$old_id = null;
		if (!empty($bild_id)){	
			$old_id = $bild_id;
		}

		//bild in groesse anpassen und speichern:	
		$maxBreite  = $x/3; //max ein drittel der seitenbreite
		$maxHoehe   = $y; //maximal die hoehe der karte
		
		//create the image from JPEG file
		$img = new hft_image($_FILES['bild']['tmp_name']);
		$origWidth = $img->image_original_width;
		$origHeight = $img->image_original_height;
		
		if ($origWidth < $maxBreite){
			$maxBreite = $origWidth;
		}
		if ($origHeight < $maxHoehe){
			$maxHoehe = $origHeight;
		}
		
		//keep X to Y ratio
		//so there will be no geometrical distortions:
		$img->resize($maxBreite,$maxHoehe,"-"); 		
		//save the resized image to file
		//commented to save server load
		$img->output_resized($_FILES['bild']['tmp_name']);
		//file-upload war erfolgreich:
		$pfad = $_FILES['bild']['tmp_name'];
		$bild_id = setBild($pfad,'Picture for table card '.$tableCardId,
			  $img->image_resized_width,$img->image_resized_height,
			  $fileExtension);
		setTableCardPic($bild_id,$tableCardId);
		if(!empty($old_id)){
			//altes bild loeschen		
			deleteBild($old_id);
		}
	
	}
	
	$nachricht = "Das Design der Tischkarte wurde erfolgreich gespeichert.";
	$nachricht = getUebersetzung($nachricht);
	$info = true;
	
	//back to the edit page:
	include_once('./index.php');
	exit;
	
} //end if tableCardId exists
?>