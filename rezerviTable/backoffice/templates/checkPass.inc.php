<?php
/*
 * Created on 10.09.2005
 *
 * author: coster
 */
 
 include_once($root."/include/sessionFunctions.inc.php");
  
 $angem = getSessionWert(ANGEMELDET);

 if ($angem != "true"){
 	$fehler = true;
 	$nachricht = "Benutzeranmeldung fehlgeschlagen. Bitte melden sie sich erneut an.";
 	include($root."/backoffice/index.php");
 	exit;
 }
 
?>
