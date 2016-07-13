<?php

//gibt alle reservierungen eines gastes aus:
//gibt das array der datenbankabfrage zurück.
function getReservationsOfGuest($gast_id,$link){

		$query = "select 
					*
					from 
					Rezervi_Reservierung
					where 		
					FK_Gast_ID = '$gast_id'
					ORDER BY
					Datum_von
					desc
				  ";

  		$res = mysql_query($query, $link);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
		else		
			return $res;

}

?>