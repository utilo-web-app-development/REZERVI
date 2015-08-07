<?php
//spezielle funktionen zur suche nach freien zimmern:

//liefert die anzahl der erwachsenen, die eine unterkunft maximal haben kann:
function getAnzahlErwachsene($unterkunftId,$link){

	$anzahl = 0;

	$query="
		SELECT 
		Betten		
		FROM
		Rezervi_Zimmer
		WHERE
		FK_Unterkunft_ID = '$unterkunftId'	
	";
	
	$res = mysql_query($query, $link);
	if (!$res) {
		echo("Anfrage $query scheitert.");
	}
	else {		
		while ($d = mysql_fetch_array($res)){ 
			$r = $d["Betten"];
			$anzahl = $anzahl + $r;
		}	
	}
	
	return $anzahl;
	
}

//liefert die anzahl der kinder, die eine unterkunft maximal haben kann:
function getAnzahlKinder($unterkunftId,$link){

	$anzahl = 0;

	$query="
		SELECT 
		Betten_Kinder		
		FROM
		Rezervi_Zimmer
		WHERE
		FK_Unterkunft_ID = '$unterkunftId'	
	";
	
	$res = mysql_query($query, $link);
	if (!$res) {
		echo("Anfrage $query scheitert.");
	}
	else {		
		while ($d = mysql_fetch_array($res)){ 
			$r = $d["Betten_Kinder"];
			$anzahl = $anzahl + $r;
		}	
	}
	
	return $anzahl;
	
}

//liefert die freien zimmer_id in einem array zurück:
//wenn $freieZimmer[0] = -1 dann sind nicht genug freie zimmer fuer erwachsene
//                       -2 wenn nicht genug fuer kinder
//                       -3 wenn nicht genug zimmer
//                       -4 wenn buchungseinschraenkung für alle zimmer besteht
function getFreieZimmer($unterkunft_id, $anzahlErwachsene, $anzahlKinder, $anzahlZimmer,$haustiere,$vonTag,$vonMonat,$vonJahr,$bisTag,$bisMonat,$bisJahr,$link){
	
	 //leeres array erzeugen zum speichern der freien zimmer:
	 $freieZimmer = array();
	 //variable zum zaehlen der erwachsenenBetten, kinderBetten, freie zimmer
	 $bettenErw = 0;
	 $bettenKin = 0;
	 $freieZi = 0;
	 
	 //reservierungs-funktionen einbinden:
	 include_once("../include/reservierungFunctions.php");
	 //zimmer-funktionen hinzufügen:
	 include_once("../include/zimmerFunctions.php");
	 //properties hinzufügen:
	 include_once("../include/propertiesFunctions.php");
	
	 //alle zimmer der unterkunft auslesen und prüfen ob es im angegebenen zeitraum noch frei ist:
	 $query="
			SELECT 
			PK_ID		
			FROM
			Rezervi_Zimmer
			WHERE
			FK_Unterkunft_ID = '$unterkunft_id'	
			ORDER BY
			Zimmernr
		";
		$res = mysql_query($query, $link);
		while ($d = mysql_fetch_array($res)){ 
			//zimmer-id holen:
			$zi_id = $d["PK_ID"];

			//wenn die suche nach erwachsenen oder kindern nach zimmern gefiltert
			//werden soll (z. b. ferienhäuser nur mit bestimmter personenanzahl):
			//dont check it if the accomodation has rooms and subrooms:
			if (!hasParentRooms($unterkunft_id)){
				if (getPropertyValue(SUCHFILTER_ZIMMER,$unterkunft_id,$link) == "true"){
					if ($anzahlErwachsene > -1){
						if (getBetten($unterkunft_id,$zi_id,$link) < $anzahlErwachsene){
							continue;
						}
					}	
					if ($anzahlKinder > -1){
						if (getBettenKinder($unterkunft_id,$zi_id,$link) < $anzahlKinder){
							continue;
						}
					}		
				}	
			}		
			
			if(!isRoomTaken($zi_id,$vonTag,$vonMonat,$vonJahr,$bisTag,$bisMonat,$bisJahr,$link))
			{
				  //zimmer ist noch frei - dem array hinzufügen:
				  $freieZimmer[] = $zi_id;	
				  $freieZi++;			
				  //zaehlen wie viele erwachsene und kinder platz haben:
				  $bettenErw = $bettenErw + (getBetten($unterkunft_id,$zi_id,$link));
				  //echo("anzahlBetten insgesamt Erw =".$bettenErw."<br/>");
				  $bettenKin = $bettenKin + (getBettenKinder($unterkunft_id,$zi_id,$link));
				  //echo("anzahlBetten insgesamt Kin =".$bettenKin."<br/>");
			}			
		}	
		if ($anzahlErwachsene > -1){
			//checken ob genug betten fuer erwachsene frei sind:
			if ($anzahlErwachsene > $bettenErw){
				//es sind nicht genug betten fuer erwachsene frei!
				$freieZimmer[0] = -1;
			}		
		}
		if ($anzahlKinder > -1){
			//wieviele betten sind noch frei wenn ich die erwachsenen reingelegt habe?
			if ($anzahlErwachsene > -1)
				$insgesamtBettenFrei = ($bettenErw + $bettenKin) - $anzahlErwachsene;
			else
				$insgesamtBettenFrei = ($bettenErw + $bettenKin);
			//checken ob genug betten fuer kinder frei sind:
			if ($anzahlKinder > $insgesamtBettenFrei){
				//echo("nicht genug betten fuer kinder!<br/>");
				$freieZimmer[0] = -2;
			}
		}
		if ($anzahlZimmer > -1){
			//checken ob genug zimmer insgesamt frei sind:
			if ($anzahlZimmer > $freieZi){
				$freieZimmer[0] = -3;
			}
		}
		
		//check if a parent-child relation exists and remove the parent if the child is not free:
		$freeRooms = array();
		if (count($freieZimmer) > 0 
			&& hasParentRooms($unterkunft_id) 
			&& getPropertyValue(RES_HOUSE,$unterkunft_id,$link) == "true"){
				
			global $root;
			include_once($root."/include/zimmerFunctions.php");
			foreach($freieZimmer as $freeRoom){
				$count = 0;
				$count2 = 0;
				//is the room a parent room?
				if (hasChildRooms($freeRoom)){
					//the room is a parent room, check if ALL the children are free rooms
					$childs = getChildRooms($freeRoom);
					while ($c = mysql_fetch_array($childs)){
						$count2++;						
						for ($i = 0; $i < count($freieZimmer); $i++){
							if ($freieZimmer[$i] == $c['PK_ID']){
								$count++;
							}
						}
					}
					if ($count == $count2){
						$freeRooms[] = $freeRoom;
					}
				}
				else{
					$freeRooms[] = $freeRoom;
				}
			}
		}
		//if all rooms of a parent are occupied, remove the parent:
		else if(count($freieZimmer) > 0 
			&& hasParentRooms($unterkunft_id) 
			&& getPropertyValue(RES_HOUSE,$unterkunft_id,$link) != "true"){
				
			global $root;
			include_once($root."/include/zimmerFunctions.php");
			include_once($root."/include/reservierungFunctions.php");
			foreach($freieZimmer as $freeRoom){
				$count = 0;
				$count2 = 0;
				//is the room a parent room?
				if (hasChildRooms($freeRoom)){
					//the room is a parent room, check if ALL the children are occupied:
					$childs = getChildRooms($freeRoom);
					$allOcc = true;
					while ($c = mysql_fetch_array($childs)){
						$chid = $c['PK_ID'];
						//if the child is not occupied -> set to false!
						$taken = isRoomTaken($chid,$vonTag,$vonMonat,$vonJahr,$bisTag,$bisMonat,$bisJahr,$link);
						if (!$taken){
							$allOcc = false;
							break;
						}
					}
					if (!$allOcc){
						$freeRooms[] = $freeRoom;
					}
				}
				else{
					$freeRooms[] = $freeRoom;
				}
			}				
			
		}
		else{
			$freeRooms = $freieZimmer;
		}
		//checken ob genug zimmer insgesamt frei sind:
		if (count($freeRooms) < 1){
				$freeRooms[0] = -3;
		}
		
		return $freeRooms;
}

function getInformationHaustiere($unterkunft_id,$link)
{
  $query="
		SELECT 
		Value		
		FROM
		rezervi_properties
		WHERE
		FK_Unterkunft_ID = '$unterkunft_id' AND Name='Haustiere' ;
	";
 
  $res = mysql_query($query, $link);
  if (!$res)
  {
     echo("Anfrage $query scheitert.");
  }
  else 
  {
    while ($d = mysql_fetch_array($res))
    { 
      $r = $d["Wert"];
      //echo ("<h1>getInformationHaustiere: " . $r. "</h1>");
      return $r;
    }
  }
}

function getHaustiereErlaubt($unterkunftId,$link)
{
	$query="
		SELECT 
		Haustiere	
		FROM
		Rezervi_Zimmer
		WHERE
		FK_Unterkunft_ID = '$unterkunftId'	
	";
	
	$res = mysql_query($query, $link);
	if (!$res) {
		echo("Anfrage $query scheitert.");
	}
	else 
	{		
	  while ($d = mysql_fetch_array($res))
	  { 
        $r = $d["Haustiere"];
          if($r == 'true')
            return $r;
		}	
	}
}

?>