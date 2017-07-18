if(parent == null || parent == self) {
	//top.location.href = './start.php';
}

function updateReservierung(vonTagIndex,vonMonatIndex,vonJahrValue,bisTagIndex,bisMonatIndex,bisJahrValue,zimmer_idValue){
	
		document.reservierung.zimmer_id.value = zimmer_idValue;
		document.reservierung.datumVon_Day_ID.selectedIndex = vonTagIndex;
		document.reservierung.datumVon_Month.selectedIndex = vonMonatIndex;
		document.reservierung.datumVon_Year_ID.value = vonJahrValue;
		document.reservierung.datumBis_Day_ID.selectedIndex = bisTagIndex;
		document.reservierung.datumBis_Month.selectedIndex = bisMonatIndex;
		document.reservierung.datumBis_Year_ID.value = bisJahrValue;
		datumVon_Object.setPicked(vonJahrValue, vonMonatIndex, vonTagIndex+1);
		datumBis_Object.setPicked(bisJahrValue, bisMonatIndex, bisTagIndex+1);
			
}

function changeZimmer(){
	 
	 document.reservierung.zimmer_id.value = document.ZimmerNrForm.zimmer_id.value;
	 //document.kalender.zimmer_id.value = document.ZimmerNrForm.zimmer_id.value;
	 document.ZimmerNrForm.submit();
	 
 }
		 
function getJahrIndex(jahrValue){
	 			
		var val = "";
		
		for(var i=0; i < document.ZimmerNrForm.jahr.length; i++){				
			val = document.ZimmerNrForm.jahr[i].value;
			if (val == jahrValue) 
				return i;
		}
		
		return 0;
		
}

/**
liefert den ausgew?hlten tag aus dem
von-select

function getSelectedTagVon(){
		
		return document.reservierung.vonTag.selectedIndex;;
		
}
*/		 
function getMonatIndex(monatValue){
		
		var val = "";
		
		for(var i=0; i < document.ZimmerNrForm.monat.length; i++){				
			val = document.ZimmerNrForm.monat[i].value;
			if (val == monatValue) 
				return i;
		}
		
		return 0;
		
}
		 
function getZimmer_idIndex(zimmer_idValue){
		
		var val = "";
		
		for(var i=0; i < document.ZimmerNrForm.zimmer_id.length; i++){				
			val = document.ZimmerNrForm.zimmer_id[i].value;
			if (val == zimmer_idValue) 
				return i;
		}
		
		return 0;
		
}
		 
function updateKalender(monatValue,jahrValue,zimmer_idValue){
	 	 
		 //werte auslesen:
		 var jahrIndex = getJahrIndex(jahrValue);			 
		 var monatIndex = getMonatIndex(monatValue);	
		 var zimmer_idIndex = getZimmer_idIndex(zimmer_idValue);
		 var zimmer_idValue = document.ZimmerNrForm.zimmer_id.value;
		 //var tagIndex = document.reservierung.vonTag.selectedIndex; 
		 
		 //werte setzen:
		updateZimmerNrForm(jahrIndex,monatIndex,zimmer_idIndex);
		updateJahresuebersicht(jahrValue,monatValue,zimmer_idValue);
		updateSuche(jahrValue,monatValue);
		updateReservierung(0,monatIndex,jahrValue,0,monatIndex,jahrValue,zimmer_idValue);
		
}
		
function zimmerNrFormJahrChanged(){
		 //werte auslesen:
		 var jahrIndex = document.ZimmerNrForm.jahr.selectedIndex;
		 var jahrValue = document.ZimmerNrForm.jahr.value;
		 var monatIndex = document.ZimmerNrForm.monat.selectedIndex;
		 var monatValue = document.ZimmerNrForm.monat.value;
		 var zimmer_idValue = document.ZimmerNrForm.zimmer_id.value;
		 document.reservierung.zimmer_id.value = document.ZimmerNrForm.zimmer_id.value;
		 //andere forms updaten:
		 updateJahresuebersicht(jahrValue,monatValue,zimmer_idValue);
		 updateSuche(jahrValue,monatValue);
		 updateReservierung(0,monatIndex,jahrValue,0,monatIndex,jahrValue,zimmer_idValue);
		//formular absenden
	 	document.ZimmerNrForm.submit();
 }
