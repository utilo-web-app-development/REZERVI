
/* 'Transparenz 061005' (c) by cybaer@binon.net
   --------------------
 Inhalt    : Stellt die Transparenz von Elementen ein (von 0-100%)
 Aufruf    : transparency(element,percentage)
 Parameter : element (Element, auf das der Effekt angewendet werden soll. Reihenfolge der Auswertung:
                      Object (z.B. document.images[1])
                      NAME-Attribut (z.B. "transparent")
                      ID-Attribut (z.B. "transparent")
                      HTML-Tag (z.B. "img")
             percentage (Optional: Prozentsatz der Transparenz, voreingestellt: 50%)
 Sprache   : JavaScript 1.1 (ungesichert), JavaScript 1.5 (gesichert)
 Quelle    : http://Coding.binon.net/Transparenz (cybaer@binon.net)
             Die kostenlose Nutzung der Quelltexte in eigenen Projekten ist
             bei nicht-kommerziellen Projekten (und deren unentgeltlicher
             Herstellung) bei Nennung der Quelle ausdruecklich gestattet.
 InlineFunc: -
 Konstante : -
 Variable  : -
 SystemVar : -
 ExternVar : -
 Rueckgabe : -
 Anmerkung : Benutzt die CSS-Styles "filter" (Internet Explorer), "-moz-opacity" (aeltere Mozilla),
             "-khtml-opacity" (aeltere Konqueror/Safari) und "opacity" (CSS 3, Opera u.a.) mittels W3C-DOM
 Beispiele : HTML  : <img src="test.gif" onMouseOver="transparency(this,75);" onMouseOut="transparency(this,0);">
                  -> Das Bild test.gif wird zu 75% transparent, wenn die Maus drueber faehrt
             HTML  : <img id="T1" name="aussen" src="test.gif"><img id="T2" name="innen" src="test.gif"><img id="T3" name="aussen" src="test.gif">
             Script: transparency(document.images[0],50%);
                  -> Das erste Bild des Dokuments wird halb transparent.
             Script: transparency("T1");
                  -> Das linke Bild (mit der ID "T1") wird halb transparent.
             Script: transparency("aussen",25);
                  -> Das linke & rechte Bild (mit dem Namen "aussen") werden viertel transparent.
             Script: transparency("img",75);
                  -> Alle Bilder (HTML-Tag <img>) werden dreiviertel transparent.
*/

function transparency(element,percentage) {
 // Lokale Variablen definieren
 var i, count, objStyle;

 // Browser unterstuetzt (W3C-)DHTML?
 if(document.getElementById) {

  // Wurde Object uebergeben und existiert es?
  if(typeof(element)=="object" && element) { obj=element; }
  // Ansonsten: Existiert (mindestens) ein HTML-Element mit passendem NAME-Attribut?
  else if (document.getElementsByName(element) && document.getElementsByName(element)[0]) { obj=document.getElementsByName(element); }
  // Ansonsten: Existiert ein HTML-Element mit passendem ID-Attribut?
  else if (document.getElementById(element)) { obj=document.getElementById(element); }
  // Ansonsten: Existiert (mindestens) ein passendes HTML-Element?
  else if (document.getElementsByTagName && document.getElementsByTagName(element) && document.getElementsByTagName(element)[0]) { obj=document.getElementsByTagName(element); }
  // Ansonsten: Kein passendes Objekt gefunden
  else { obj=false; }

  // Wenn ein Objekt existiert
  if(obj) {
   // Gueltigen Prozentwert definieren (Deckungswert)
   percentage=(typeof(percentage)=="undefined")?50:100-percentage;
   // Anzahl der passenden Elemente bestimmen
   count=(obj.length)?obj.length:1;
   // Diese Elemente durchgehen
   for(i=0;i<count;i++) {
    // (Arbeits-)Stylesheet-Objekt definieren
    objStyle=(obj.length)?obj[i].style:obj.style;
    // "filter(Alpha)"-Style setzen (fuer IE)
    objStyle.filter="Alpha(opacity="+percentage+")";
    // "-moz-opacity"-Style setzen (fuer Mozilla)
    objStyle.MozOpacity=""+percentage/100;
    // "-khtml-opacity"-Style setzen (fuer Konqueror/Safari)
    objStyle.KTHMLOpacity=""+percentage/100;
    // "opacity"-Style setzen (fuer CSS-3-Browser)
    objStyle.opacity=""+percentage/100;
   }
  }

 }
}

// =============================== Direkt-Code ===============================

xJStrans=true; // Externes JavaScript geladen!
