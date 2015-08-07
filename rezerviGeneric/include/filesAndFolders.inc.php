<?php
/**
prueft ob ein verzeichnis bereits vorhanden ist
author:coster
date: 18.8.05
*/
function hasDirectory($path){
	//file_exists -- Prüft, ob eine Datei oder ein Verzeichnis existiert
	return file_exists($path);
}
/**
	erzeugt ein directory mit permission 644 (rw,r,r)
	gibt bei erfolg true zurück, sonst false
	der pfad zusammen mit dem directory muss
	eine gültige uri ergeben
*/
function phpMkDir($path){

	return mkdir ($path, 0777);
	
}
/**
	erzeugt ein directory über die ftp funktion.
	dies muss verwendet werden, falls die php
	funktionen nicht erlaubt sind. 
	Quelle: http://at.php.net/manual/de/function.mkdir.php
	date: 4. Aug. 2005
*/
// create directory through FTP connection
function ftpMkDir($path, $newDir, $ftpServer, $ftpUser, $ftpPass) {
  
       $server=$ftpServer; // ftp server
       $connection = ftp_connect($server); // connection  
 
       // login to ftp server
       $user = $ftpUser;
       $pass = $ftpPass;
       $result = ftp_login($connection, $user, $pass);

   // check if connection was made
     if ((!$connection) || (!$result)) {
       return false;
       exit();
       } else {
         ftp_chdir($connection, $path); // go to destination dir
       if(ftp_mkdir($connection,$newDir)) { // create directory
           return $newDir;
       } else {
           return false;       
       }
   ftp_close($connection); // close connection
   }

}
/**
 * author:coster
 * date:26.9.05
   funktion zum löschen eines files.
   bei erfolgreichem löschen wird true zurückgegeben
 */
function rmFile($filename) {

   if (file_exists($filename)){
   		return unlink($filename);
   }
   echo("Der File ".$filename." existiert nicht!");
   return false;
}
?> 