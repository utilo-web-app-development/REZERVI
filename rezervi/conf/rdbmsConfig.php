<?php

/****************************************************************************
	Config file for your database.
	Konfigurationsdatei für die Datenbank.
	
	You must fill in the URL, the name of the database, the username and
	the password of your MySQL database!
	Hier muss die URL, der Datenbankname, der Benutzername und das Passwort 
	der MySQL Datenbank	eingegeben werden!	
*****************************************************************************/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 

/****************************************************************************
	LOGIN DATA OF YOUR MYSQL DATABASE:
	ZUGANGSDATEN ZUR MYSQL DATENBANK:
*****************************************************************************/
	
	//URL for your MySQL database e.g. "localhost"
	//-- german:
	//URL zur MySQL Datenbank, z. B. "localhost"
	$DBMS_URL = "localhost";
	//Name of the MySQL database:
	//-- german:
	$DB_NAME = "rezervi";
	//username of the MySQL database:
	//-- german:
	//Benutzername der MySQL Datenbank:
	$USERNAME = "mySQL_username";
	//Password of the MySQL database:
	//-- german:
	//Passwort der MySQL Datenbank:
	$PASS = "mySQL_password"; 
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
	$URL = "http://www.rezervi.com";
	//e-mail address:
	//--german:
	//E-Mail-Adresse:
	$EMAIL = "office@utilo.eu";
	
	
/****************************************************************************
	ENDE DER BENUTZEREINGABEN
*****************************************************************************/
	if ($USERNAME != "" && $PASS != ""){
		$link = @mysqli_connect($DBMS_URL,$USERNAME,$PASS);
	}
	elseif ($USERNAME != ""){
		$link = @mysqli_connect($DBMS_URL,$USERNAME);
	}
	else{
		$link = @mysqli_connect($DBMS_URL);
	}
  	
  	if (!$link) {
  		echo("No connection to the database management system on $DBMS_URL!\n
			  Please check your dates for the database!\n");
        echo("Keine Verbindung mit dem Datenbankmanagementsystem auf $DBMS_URL möglich!\n
			  Bitte Überprüfen Sie die Zugangsdaten zu Ihrer Datenbank!");
        exit;
    }
	else{
  		// Auswahl der zu verwendenden Datenbank auf dem Server
  		$query = "use ".($DB_NAME);

		//if (!mysqli_query($query, $link)){
  		if (!mysqli_query($link,$query)){
  			echo("The database $DB_NAME does not exist.\n
			  Please check your dates for the database!\n");
    		echo("Die Datenbank $DB_NAME existiert nicht.\n
				  Bitte Überprüfen Sie die Zugangsdaten zu Ihrer Datenbank!");
  			exit;
  		}
	}
	
	define('DEBUG',false);  //aktivieren des debug modus
	define('DEMO',true); //wenn demo aktiviert werden z. b. keine mails versendet.
	 
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

?>
