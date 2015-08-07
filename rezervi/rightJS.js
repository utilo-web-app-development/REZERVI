if(parent == null || parent == self) {top.location.href = './start.php';}
		 
function updateLeft(monatValue,jahrValue,zimmer_idValue,form){
	
	//werte auslesen:
	var monatIndex 		= parent.reservierung.getMonatIndex(monatValue);
	var jahrIndex 		= parent.reservierung.getJahrIndex(jahrValue);
	var zimmer_idIndex 	= parent.reservierung.getZimmer_idIndex(zimmer_idValue);
	//var tagIndex 		= parent.reservierung.getSelectedTagVon();
	
	//links updaten:	
	parent.reservierung.updateZimmerNrForm(jahrIndex,monatIndex,zimmer_idIndex);
	parent.reservierung.updateJahresuebersicht(jahrValue,monatValue,zimmer_idValue);
	parent.reservierung.updateSuche(jahrValue,monatValue);
	parent.reservierung.updateReservierung(0,monatIndex,jahrValue,0,monatIndex,jahrValue,zimmer_idValue);
	
	if (form == 1){
		document.monatWeiter.submit();
	}
	else {
		document.monatZurueck.submit();
	}
}