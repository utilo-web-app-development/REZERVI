<?php
/****************************************************************************
	Config file for your database.
	Konfigurationsdatei f�r die Datenbank.
	
	You must fill in the URL, the name of the database, the username and
	the password of your MySQL database!
	Hier mu� die URL, der Datenbankname, der Benutzername und das Passwort 
	der MySQL Datenbank	eingegeben werden!	
*****************************************************************************/

/****************************************************************************
	LOGIN DATA OF YOUR MYSQL DATABASE:
	ZUGANGSDATEN ZUR MYSQL DATENBANK:
*****************************************************************************/
	//DBMS_DRIVER the database management system e.g. "mysql"
	//available drivers:
	//mysql, mssql, oracle, oci8, postgres, sybase, vfp, access, ibase
	//tested drivers:
	//mysql
	//-- german:
	//DBMS_DRIVER das Datenbankmanagementsystem z. B. "mysql"
	//verf�gbare Treiber:
	//mysql, mssql, oracle, oci8, postgres, sybase, vfp, access, ibase
	//getestete Treiber:
	//mysql
	$DBMS_DRIVER = 'mysql';
	//URL for your MySQL database e.g. "localhost"
	//-- german:
	//URL zur MySQL Datenbank, z. B. "localhost"
	$HOST = "localhost";
	//Name of the MySQL database:
	//-- german:
	//Name der MySQL Datenbank:
	$DB_NAME = "rezerviTable_test";
	//username of the MySQL database:
	//-- german:
	//Benutzername der MySQL Datenbank:
	$USERNAME = "testuser";
	//Password of the MySQL database:
	//-- german:
	//Passwort der MySQL Datenbank:
	$PASS = "testpass"; 
	//URL of your homepage/your availibilty overview
	//e.g. $URL = "http://www.my-domainname.com"
	//If you installed Rezervi on a special folder on your
	//webserver, you must also fill in this path.
	//e.g. $URL = "http://www.my-domainname.com/rezerviStable/
	//-- german:
	//URL ihrer Homepage/ihres Belegungsplanes
	//z. B. $URL = "http://www.mein-domainname.com"
	//falls Rezervi in einem speziellen Verzeichnis ihres Webservers
	//installiert wurde, geben sie bitte auch diesen Pfad mit in der URL an.
	//z. B. $URL = "http://www.mein-domainname.com/rezerviStable/"
	$URL = "http://www.utilo.eu";
	//e-mail address:
	//--german:
	//E-Mail-Adresse:
	$EMAIL = "myEMail2@test.com"; 
 
 ////////////////////////////////////////////////////////////
 // dont't make changings after this line
 ///////////////////////////////////////////////////////////
 define("DEBUG",false);  //aktivieren des debug modus
 define("MIETE",false); //true setzen wenn der belegungsplan im miet-modus betrieben wird
 define("DEMO",true); //wenn true dann ist plan im demomodus und versendet z. b. keine mails
 //debug-level:
 if (DEBUG){
 	error_reporting(E_ALL);
 }
 else{
 	error_reporting(E_ERROR);
 }
 
?>
