<?php

/****************************************************************************
	Config file for your database.
	Konfigurationsdatei für die Datenbank.
	
	You must fill in the URL, the name of the database, the username and
	the password of your MySQL database!
	Hier muss die URL, der Datenbankname, der Benutzername und das Passwort 
	der MySQL Datenbank	eingegeben werden!	
*****************************************************************************/

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
	//Name der MySQL Datenbank:
	$DB_NAME = "rezerviGeneric_test";
	//username of the MySQL database:
	//-- german:
	//Benutzername der MySQL Datenbank:
	$USERNAME = "mySQL_user";
	//Password of the MySQL database:
	//-- german:
	//Passwort der MySQL Datenbank:
	$PASS = "mySQL_pass"; 
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
	$URL = "http://www.rezervi.com/";
	//e-mail address:
	//--german:
	//E-Mail-Adresse:
	$EMAIL = "myEMail@test.com";
	
	
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
  			echo("The database $DB_NAME does not exist or the username or password or the database host is not correct.<br/>
			  	  You need a MySQL database to install Rezervi Generic!<br/>" .
			  	 "Please edit the file '\\conf\\rdbmsConfig.inc.php'<br/><br/>" .
			  	 "If you need help for the installation, " .
			  	 "please contact <a href=\"mailto:office@utilo.net\">office@utilo.net</a><br/><br/>");
    		echo("Die Datenbank $DB_NAME existiert nicht, der benutzername das passwort oder der host sind nicht korrekt.<br/>
				  Sie benötigen eine MySQL Datenbank um Rezervi Generic installieren zu können.<br/>" .
				 "Bitte editieren sie dazu den File '\\conf\\rdbmsConfig.inc.php'<br/><br/>" .
			  	 "Wenn sie Hilfe bei der Installation benätigen können sie sich gerne an " .
			  	 "<a href=\"mailto:office@utilo.net\">office@utilo.net</a> wenden.<br/><br/>");
  			exit;
    }
	else{
  		// Auswahl der zu verwendenden Datenbank auf dem Server
  		$query = "use ".($DB_NAME);
		
  		if (!mysqli_query($link, $query)){
  			echo("The database $DB_NAME does not exist.<br/>
			  	  You need a MySQL database to install Rezervi Generic!<br/>" .
			  	 "Please edit the file '\\conf\\rdbmsConfig.inc.php'<br/><br/>" .
			  	 "If you need help for the installation, " .
			  	 "please contact <a href=\"mailto:office@utilo.net\">office@utilo.net</a><br/><br/>");
    		echo("Die Datenbank $DB_NAME existiert nicht.<br/>
				  Sie benötigen eine MySQL Datenbank um Rezervi Generic installieren zu können.<br/>" .
				 "Bitte editieren sie dazu den File '\\conf\\rdbmsConfig.inc.php'<br/><br/>" .
			  	 "Wenn sie Hilfe bei der Installation benätigen können sie sich gerne an " .
			  	 "<a href=\"mailto:office@utilo.net\">office@utilo.net</a> wenden.<br/><br/>");
  			exit;
  		}
	}
	
	if (!isset($doInstall) || $doInstall != true){
		//pruefe ob Rezervi Generic bereits installiert wurde:
		$query = ("SELECT 
						   *
						   FROM
						   REZ_GEN_VERMIETER
						   WHERE
						   VERMIETER_ID = '1'
			   			  ");           
	
		$res = mysqli_query($link, $query);
		if (!$res || (mysqli_num_rows($res)<=0)){
			  	echo("Rezervi Generic was not correctly installed. Please go to the page '\\install\\index.php' and do the installation.<br/><br/>" .
				  	 "If you need help for the installation, " .
				  	 "please contact <a href=\"mailto:office@utilo.net\">office@utilo.net</a><br/><br/>");
	    		echo("Rezervi Generic wurde noch nicht korrekt installiert. Bitte rufen sie die Seite '\\install\\index.php' auf und installieren sie Rezervi Generic<br/><br/>" .
				  	 "Wenn sie Hilfe bei der Installation benötigen können sie sich gerne an " .
				  	 "<a href=\"mailto:office@utilo.net\">office@utilo.net</a> wenden.<br/><br/>");
	  			exit;
		}
	}

?>