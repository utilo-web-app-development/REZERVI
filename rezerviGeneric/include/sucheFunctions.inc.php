<?php
/**
 * gets the free rooms for the given time
 * @param $vermieter_id
 * @param $vonTag
 * @param $vonMonat
 * @param $vonJahr
 * @param $vonMinute
 * @param $vonStunde
 * @param $bisTag
 * @param $bisMonat
 * @param $bisJahr
 * @param $bisMinute
 * @param $bisStunde
 * @return array with MIETOBJEKT_ID that a free in the given period of time
 * */
function searchFreieMietobjekte($vermieter_id, $vonTag, $vonMonat, $vonJahr, $vonMinute, $vonStunde, 
						$bisTag, $bisMonat, $bisJahr, $bisMinute, $bisStunde){
							
	global $link;						
	global $root;
	
	 //leeres array erzeugen zum speichern der freien mo:
	 $freiMietobjekte = array();
	 
	 include_once($root."/include/reservierungFunctions.inc.php");
	 include_once($root."/include/mietobjektFunctions.inc.php");
	
		$res = getMietobjekte($vermieter_id);
		while ($d = mysql_fetch_array($res)){ 

			$mietobjekt_id = $d["MIETOBJEKT_ID"];
			$isTaken = isMietobjektTaken($mietobjekt_id,$vonMinute,$vonStunde,$vonTag,$vonMonat,$vonJahr,
				$bisMinute,$bisStunde,$bisTag,$bisMonat,$bisJahr);
			if ($isTaken != true){
				$freiMietobjekte[] = $mietobjekt_id;
			}
		}		
		
	return $freiMietobjekte;
	
}

?>