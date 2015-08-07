<?php
/*
 * Created on 22.09.2005
 *
 * author: coster UTILO.eu
 */
 
 define('DEBUG',false);  //aktivieren des debug modus
 define('MIETE',false); //true setzen wenn der belegungsplan im miet-modus betrieben wird
 define('DEMO',true); //wenn true dann ist plan im demomodus und versendet z. b. keine mails
 
 
 ////////////////////////////////////////////////////////////
 // dont't make changings after this line
 ///////////////////////////////////////////////////////////
 //debug-level:
 if (DEBUG){
 	error_reporting(E_ALL);
 }
 else{
 	error_reporting(E_ERROR);
 }
 $URL = "http://www.UTILO.eu";
 $EMAIL = "office@UTILO.eu";
 
?>
