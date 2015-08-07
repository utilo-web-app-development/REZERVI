<?php
/*
 * Created on 19.09.2005
 *
 * author: coster
 * 
 * definition von konstanten für das webinterface
 * 
 */
 
 define("ADMIN",1); //administrator-rechte
 define("USER",2);  //benutzer-rechte
 define("JAHRESUEBERSICHT","Jahresansicht");
 define("MONATSUEBERSICHT","Monatsansicht");
 define("WOCHENANSICHT","Wochenansicht");
 define("TAGESANSICHT","Tagesansicht");
 $ansicht_array = array(JAHRESUEBERSICHT,MONATSUEBERSICHT,WOCHENANSICHT,TAGESANSICHT);
 define("MODUS_BELEGUNGSPLAN","modus_belegungsplan"); //zur unterscheidung zwischen wi und bp
 define("MODUS_WEBINTERFACE","modus_webinterface");   // -- "" --
 
?>
