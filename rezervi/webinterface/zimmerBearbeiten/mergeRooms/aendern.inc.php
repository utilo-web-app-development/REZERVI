<?php
/**
 * @author coster
 * @date 3.9.2007
 * 
 * edit, delete the room <-> house merge
 */
 
$zimmer = $_POST['zimmer'];
if (empty($zimmer)){
	$nachricht = "Bitte w�hlen Sie die Zimmer zum ausgew�hlten Haus.";
	$fehler = true;
}
else{
	
	//delete old merges first:
	deleteChildRooms($house);
	foreach($zimmer as $zi){

		setParentRoom($zi,$house);	
	
	}

}
 
?>