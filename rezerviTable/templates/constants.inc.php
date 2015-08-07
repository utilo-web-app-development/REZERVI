<?php
/*
 * Created on 19.09.2005
 *
 * author: coster
 * 
 * definition von konstanten fuer das backoffice
 * 
 */
 
 define("ADMIN",1); //administrator-rechte
 define("USER",2);  //benutzer-rechte
 define("TAGESANSICHT","Tagesansicht");
 define("LISTENANSICHT","Listenansicht");
 $ansicht_array = array(TAGESANSICHT, LISTENANSICHT);
 define("MODUS_BELEGUNGSPLAN","modus_belegungsplan"); //zur unterscheidung zwischen wi und bp
 define("MODUS_WEBINTERFACE","modus_backoffice");   // -- "" --
 
 //status von tischen:
 define("TISCH_BUCHBAR","Tisch buchbar"); //Tisch kann von Benutzer gebucht werden
 define("TISCH_NICHT_BUCHBAR","Tisch gesperrt"); //Tisch kann nicht von Benutzer gebucht werden
 $status_array = array(TISCH_BUCHBAR,TISCH_NICHT_BUCHBAR);

 //status von tischgruppen:
 define("GRUPPE_BUCHBAR","gruppe buchbar"); //nur als Gruppe gebucht werden
 define("EINZELTISCH_BUCHBAR","tisch buchbar"); //einzel Tisch kann gebucht werden
 define("GRUPPE_UNBUCHBAR","gruppe gesperrt"); //ganze Gruppe kann nicht von Benutzer gebucht werden
 $gruppe_array = array(GRUPPE_BUCHBAR,EINZELTISCH_BUCHBAR, GRUPPE_UNBUCHBAR);

 //status von gäste:
 define("ECHT","echtBuchung"); 
 define("BUCHUNG","buchung");
 define("UNBUCHUNG","unbuchung");
 $gaeste_array = array(ECHT,BUCHUNG, UNBUCHUNG);
 
?>
