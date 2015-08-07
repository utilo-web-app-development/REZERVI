<?php
/**
 * @author coster
 * @date 01.08.2007
 * functions for table cards
*/

//constans for table card properties:
//dimensions
define('TC_PAGE_ORIENTATION','page_orientation'); //Default page orientation.
define('TC_PORTRAIT','P'); //
define('TC_LANDSCAPE','L'); //

define('TC_MEASURE_UNIT','measure_unit'); //User measure unit
define('TC_MILLIMETER','mm'); //
define('TC_CENTIMETER','cm'); //

define('TC_DIMENSION','dimension'); //The format used for pages. 
define('TC_A4','A4'); //
define('TC_A5','A5'); //  
define('TC_CUSTOM_FORMAT','custom_format'); //
define('TC_CUSTOM_FORMAT_X','custom_format_x'); //the width of the table card
define('TC_CUSTOM_FORMAT_Y','custom_format_y'); //the height of the table card

//fonts:
define('TC_FONT_HEADING','font_heading'); //font for the heading
define('TC_FONT_TEXT','font_text'); //font for the texts
define('TC_FONT_COURIER','Courier');  //Courier (fixed-width)
define('TC_FONT_ARIAL','Arial'); // Arial (synonymous; sans serif)
define('TC_FONT_TIMES','Times'); //# Times (serif) 
$available_fonts = array();
$available_fonts[] = TC_FONT_COURIER;
$available_fonts[] = TC_FONT_ARIAL;
$available_fonts[] = TC_FONT_TIMES;

//font style:
define('TC_FONT_HEADING_STYLE','font_heading_style'); //style for the heading
define('TC_FONT_TEXT_STYLE','font_text_style'); //style for the texts
define('TC_FONT_STYLE_BOLD','B'); //style bold
define('TC_FONT_STYLE_NORMAL','N'); //style regular 
define('TC_FONT_STYLE_ITALIC','I'); //style italic
define('TC_FONT_STYLE_UNDERLINE','U'); //style underline
$available_font_styles = array();
$available_font_styles['fett']=TC_FONT_STYLE_BOLD; 
$available_font_styles['italic']=TC_FONT_STYLE_ITALIC; 
$available_font_styles['unterstrichen']=TC_FONT_STYLE_UNDERLINE; 

//font size:
define('TC_FONT_HEADING_SIZE','font_heading_size'); //font size of the heading
define('TC_FONT_TEXT_SIZE','font_text_size'); //font size of the heading

//heading text:
define('TC_HEADING_TEXT','HEADING-text'); //text of the heading

//show name and time on table card?
define('TC_TEXT_SHOW_NAME','text_zeige_namen'); //set to 'true' if the name of the guest should be shown
define('TC_TEXT_SHOW_TIME','text_zeige_zeit'); //set to 'true' if the time should be shown

/**
* @author coster
* @date 01.08.2007
* @param $tableCardId the id of the table card
* set the default properties for a table card
* */
function setTableCardDefaultProperties($tableCardId){

	setTableCardProperty(TC_PAGE_ORIENTATION,TC_LANDSCAPE,$tableCardId);
	setTableCardProperty(TC_MEASURE_UNIT,TC_MILLIMETER,$tableCardId);

	setTableCardProperty(TC_DIMENSION,TC_CUSTOM_FORMAT,$tableCardId);
	setTableCardProperty(TC_CUSTOM_FORMAT_X,'150',$tableCardId);
	setTableCardProperty(TC_CUSTOM_FORMAT_Y,'100',$tableCardId);
	
	setTableCardProperty(TC_FONT_HEADING,TC_FONT_ARIAL,$tableCardId);
	setTableCardProperty(TC_FONT_TEXT,TC_FONT_ARIAL,$tableCardId);	
	
	setTableCardProperty(TC_FONT_HEADING_STYLE,TC_FONT_STYLE_BOLD,$tableCardId);
	setTableCardProperty(TC_FONT_TEXT_STYLE,TC_FONT_STYLE_NORMAL,$tableCardId);	
	
	setTableCardProperty(TC_HEADING_TEXT,'RESERVIERT',$tableCardId);
	
	setTableCardProperty(TC_TEXT_SHOW_NAME,'true',$tableCardId);
	setTableCardProperty(TC_TEXT_SHOW_TIME,'true',$tableCardId);

}
/**
* @author coster
* @date 02.08.2007
* @return the auto generated id of the table card
* constructs a new table card
* */
function constructTableCard(){
	
	global $gastro_id;
	global $db;
	if (empty($gastro_id) || empty($db)){
		die ("Error on global variable!");	
	}
	$query = ("INSERT INTO 
		   BOOKLINE_TISCHKARTE
		   (GASTRO_ID)
		   VALUES
		   ('$gastro_id')
		  "); 
	$res = $db->Execute($query);
	if (!$res) { 		 
		print $db->ErrorMsg();
		die ("<br/>Die Anfrage <br/>$query<br/> scheiterte.");
	}
	
	return $db->Insert_ID();

}
/**
 * @author coster
 * @date 01.08.2007
 * gets a property for a table card
 * @param $label the constant as label
 * @param $tableCardId the id of the table card
 * @return the value
 * */
function getTableCardProperty($label,$tableCardId){
			
	global $db;	
	if (empty($db)){
		die ("Error on global variable!");	
	}		

	$query = ("SELECT 
			   *
			   FROM
			   BOOKLINE_TISCHKARTE_PROPERTIES
			   WHERE
			   LABEL = '$label'
			   AND
			   TISCHKARTE_ID = '$tableCardId'
   			  ");           

	$res = $db->Execute($query);
	
	if (!$res) { 		 
		print $db->ErrorMsg();
		die ("<br/>Die Anfrage <br/>$query<br/> scheiterte.");
	}
	else{
		$wert = $res->fields["VALUE"];
		
		$label = $res->fields["LABEL"];
		if (empty($wert) && empty($label)){
			return FALSE;
		}
		else{
			return $wert;
		}
	}

}
/**
 * @author coster
 * @date 03.08.2007
 * returns all table cards for a gastronomy
 * @return all table cards for a gastronomy
 * */
function getTableCards(){
			
	global $db;	
	global $gastro_id;
	if (empty($db) || empty($gastro_id)){
		die ("Error on global variable!");	
	}		

	$query = ("SELECT 
			   *
			   FROM
			   BOOKLINE_TISCHKARTE
			   WHERE
			   GASTRO_ID = '$gastro_id'
   			  ");           

	$res = $db->Execute($query);
	
	if (!$res) { 		 
		print $db->ErrorMsg();
		die ("<br/>Die Anfrage <br/>$query<br/> scheiterte.");
	}

	return $res;

}
function setTableCardPic($bild_id,$tableCardId){

	global $db;	
	if (empty($db)){
		die ("Error on global variable!");	
	}
	$query = ("update 
			   BOOKLINE_TISCHKARTE
			   set
			   BILDER_ID = '$bild_id'
			   WHERE
			   TISCHKARTE_ID = '$tableCardId'
   			  ");           

	$res = $db->Execute($query);
	
	if (!$res) { 		 
		print $db->ErrorMsg();
		die ("<br/>Die Anfrage <br/>$query<br/> scheiterte.");
	}

	return true;

}
/**
 * @author coster
 * @date 03.08.2007
 * returns the table cards with a specific id
 * @return the table cards with a specific id
 * @param $tableCardId the id of the table card
 * */
function getTableCard($tableCardId){
			
	global $db;	
	if (empty($db)){
		die ("Error on global variable!");	
	}		

	$query = ("SELECT 
			   *
			   FROM
			   BOOKLINE_TISCHKARTE
			   WHERE
			   TISCHKARTE_ID = '$tableCardId'
   			  ");           

	$res = $db->Execute($query);
	
	if (!$res) { 		 
		print $db->ErrorMsg();
		die ("<br/>Die Anfrage <br/>$query<br/> scheiterte.");
	}

	return $res;

}
/**
 * @author coster
 * @date 01.08.2007
 * set a value for a property 
 * */
function setTableCardProperty($label,$value,$tableCard_id){
	
	global $db;
	if (empty($db)){
		die ("Error on global variable!");	
	}	
	if (empty($tableCard_id)){
		die ("Table card id failes!");
	}
	
	$temp = getTableCardProperty($label,$tableCard_id);
	
	if ($temp === FALSE){
		$query = ("INSERT INTO 
		   BOOKLINE_TISCHKARTE_PROPERTIES
		   (LABEL,TISCHKARTE_ID,VALUE)
		   VALUES
		   ('$label','$tableCard_id','$value')
		  ");     
	}
	else{
		$query = ("UPDATE 
		   BOOKLINE_TISCHKARTE_PROPERTIES
		   SET
		   VALUE = '$value'
		   where
		   TISCHKARTE_ID = '$tableCard_id'
		   and
		   LABEL = '$label'
		  ");  
	}
	
	$res = $db->Execute($query);
	
	if (!$res) { 		 
		print $db->ErrorMsg();
		die ("<br/>Die Anfrage <br/>$query<br/> scheiterte.");
	}
	else{
		return true;
	}
}


?>