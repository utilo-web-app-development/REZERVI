//aendert die ZimmerNrForm von left.php
function updateZimmerNrForm(jahrIndex,monatIndex,zimmer_idIndex){
		 
		document.ZimmerNrForm.zimmer_id.selectedIndex = zimmer_idIndex;
		document.ZimmerNrForm.monat.selectedIndex = monatIndex;
		document.ZimmerNrForm.jahr.selectedIndex = jahrIndex;
			
}

//aendert die Jahresuebersicht von left.php
function updateJahresuebersicht(jahrValue,monatValue,zimmer_idValue){
		
		try{		 
			document.ansichtWaehlen.zimmer_id.value = zimmer_idValue;
			document.ansichtWaehlen.monat.value = monatValue;
			document.ansichtWaehlen.jahr.value = jahrValue;
		}
		catch(err){
			//jahresuebersicht ist nicht aktiviert!
		}
			
}

//aendert die Suche von left.php
function updateSuche(jahrValue,monatValue){
	
		document.suche.monat.value = monatValue;
		document.suche.jahr.value = jahrValue;
			
}

/*
function updateReservierung(vonTagIndex,vonMonatIndex,vonJahrIndex,bisTagIndex,bisMonatIndex,bisJahrIndex,zimmer_idValue){
	
		document.reservierung.zimmer_id.value = zimmer_idValue;
		document.reservierung.vonTag.selectedIndex = vonTagIndex;
		document.reservierung.vonMonat.selectedIndex = vonMonatIndex;
		document.reservierung.vonJahr.selectedIndex = vonJahrIndex;
		document.reservierung.bisTag.selectedIndex = bisTagIndex;
		document.reservierung.bisMonat.selectedIndex = bisMonatIndex;
		document.reservierung.bisJahr.selectedIndex = bisJahrIndex;
			
}
*/