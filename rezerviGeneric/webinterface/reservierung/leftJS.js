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