function chkDays(sel){
	
	//sel == 0 ist das von datum
	//sel == 1 ist das bis datum
	var selektierterIndexBis = document.reservierung.bisTag.selectedIndex;
	var selektierterIndexVon = document.reservierung.vonTag.selectedIndex;
	var Stop = 31; //anzahl der tage f?r das jeweilige monat
	if (sel == 1){
		//zuerst alles aus der selection l?schen:
		for (var i=0; i < document.reservierung.bisTag.length; i++) {
 				document.reservierung.bisTag[i] = null;
		}
		//selectiertes monat und jahr auslesen:			
		var Monat = document.reservierung.bisMonat.value;
		var Jahr  = document.reservierung.bisJahr.value;
	}
	else if (sel == 0) { 
		for (var i=0; i < document.reservierung.vonTag.length; i++) {
 				document.reservierung.vonTag[i] = null;
		}
		var Monat = document.reservierung.vonMonat.value;
		var Jahr  = document.reservierung.vonJahr.value;			
	}
	
	//schaltjahre ber?cksichtigen:
	if(Monat == 4 || Monat == 6 || Monat == 9 || Monat==11) --Stop;
	if(Monat == 2) {
 				Stop = Stop - 3;
 				if(Jahr%4==0) Stop++;
 				if(Jahr%100==0) Stop--;
 				if(Jahr%400==0) Stop++;
	}
	
	//selection neu aufbauen:				    
	for (var i=0; i < Stop; i++) {
		if (sel == 1)								
 				document.reservierung.bisTag[i] = new Option(i+1);					
		else if (sel == 0)
			document.reservierung.vonTag[i] = new Option(i+1);
	}   
	//vorher selektieren index wieder herstellen:
	if (selektierterIndexBis <= document.reservierung.bisTag.length){
		document.reservierung.bisTag.selectedIndex = selektierterIndexBis;
	}
	if (selektierterIndexVon <= document.reservierung.vonTag.length){
		document.reservierung.vonTag.selectedIndex = selektierterIndexVon;
	}
}
		

		 
/**
liefert den ausgew?hlten tag aus dem
von-select
*/
function getSelectedTagVon(){
		
		return document.reservierung.vonTag.selectedIndex;;
		
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
		 
 function getMonatIndex(monatValue){
	
	var val = "";
	
	for(var i=0; i < document.ZimmerNrForm.monat.length; i++){				
		val = document.ZimmerNrForm.monat[i].value;
		if (val == monatValue) 
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
	 var tagIndex = document.reservierung.vonTag.selectedIndex; 
	 
	 //werte setzen:
	updateZimmerNrForm(jahrIndex,monatIndex,zimmer_idIndex);
	updateJahresuebersicht(jahrValue,monatValue,zimmer_idValue);
	//updateSuche(jahrValue,monatValue);
	updateReservierung(tagIndex,monatIndex,jahrIndex,tagIndex,monatIndex,jahrIndex,zimmer_idValue);
	
 }
		

