<?php

	//gibt das 1. gefundene zimmer zur�ck das zu
	//einer unterkunft gehört:
	function getFirstRoom($unterkunft_id,$link){
	
		$query = "
			select 
			Zimmernr,PK_ID 
			from
			Rezervi_Zimmer
			where
			FK_Unterkunft_ID = '$unterkunft_id' 
			ORDER BY 
			Zimmernr";

  		$res = mysqli_query($link, $query);
  		if (!$res)
  			echo("Anfrage $query scheitert.");
	
		$d = mysqli_fetch_array($res);
		return $d["PK_ID"];
	
	}
	
?>